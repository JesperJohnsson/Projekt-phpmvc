<?php
namespace Anax\Questions;

/**
 * A controller for users and admin related events.
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDI($this->di);
    }



    /**
     * List all questions.
     *
     * @return void
     */
    public function listAction($orderBy)
    {
        $this->initialize();
        $this->checkBountyAction();

        $all = $this->questions->findAllAndOrder($orderBy);

        $this->theme->setTitle("List all questions");
        $this->views->add('questions/list', [
            'questions' => $all,
            'title' => "View all Questions",
        ]);
    }



    /**
     * List all questions.
     *
     * @return void
     */
    public function frontpageAction()
    {
        $this->initialize();
        $this->checkBountyAction();

        $all = $this->questions->findAllLimit(3);
        $questionsWithBounty = $this->questions->findAllBounty(3);

        $this->theme->setTitle("List all questions");
        if (isset($questionsWithBounty[0])) {
            $this->views->add('questions/bounty', [
                'title' => "Questions with bounty!",
                'questions' => $questionsWithBounty,
            ], 'flash');
        }

        $this->views->add('me/title', [
            'title' => "Newest Questions",
        ], 'wrap-featured');

        if (isset($all[0]) && isset($all[1]) && isset($all[2])) {
            $this->views->add('questions/front', [
                'question' => $all[0],
            ], 'featured-1');
            $this->views->add('questions/front', [
                'question' => $all[1],
            ], 'featured-2');
            $this->views->add('questions/front', [
                'question' => $all[2],
            ], 'featured-3');
        }

    }



    /**
     * List question with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
        $this->checkBountyAction();
        $url = $this->url->create('questions');
        if (!isset($id)) {
            $this->response->redirect($url);
        }
        $this->initialize();

        $question = $this->questions->find($id);
        if ($question) {
            if ($question->question_id == 0) {
                $order = $this->request->getGet('order');
                if (!isset($order)) {
                    $order = 'created desc';
                }

                //Finds all the answers to the question
                $all = $this->questions->findAllAnswers($id, $order);

                //Gets the properties out of the question.
                $properties = $question->getProperties();

                //Adds the answer form
                $this->di->dispatcher->forward([
                  'controller' => 'questions',
                  'action'     => 'addAnswer',
                  'params'     => [false, $id],
                ]);

                //Adds the comment form to question
                $this->di->dispatcher->forward([
                  'controller' => 'commentform',
                  'action'     => '',
                  'params'     => [$id, $id],
                ]);

                //Adds the comment form to the answers
                foreach ($all as $answer) {
                    $this->di->dispatcher->forward([
                      'controller' => 'commentform',
                      'action'     => '',
                      'params'     => [$id ,$answer->id],
                    ]);
                }

                //Sends the question and all the answers to the questions/view.
                $this->theme->setTitle("View question");
                $this->views->add('questions/view', [
                    'question' => $question,
                    'questions'=> $all,
                    'orderofanswers' => $order,
                    'title' => ucfirst($properties['title']),
                ]);

                //Lists the comments for the Question
                $this->di->dispatcher->forward([
                  'controller' => 'comment',
                  'action'     => 'list',
                  'params'     => [$id],
                ]);

                //Lists the comments for the answer.
                foreach ($all as $answer) {
                    $this->di->dispatcher->forward([
                      'controller' => 'comment',
                      'action'     => 'list',
                      'params'     => [$answer->id],
                    ]);
                }
            } else {
                $this->response->redirect($url);
            }
        } else {
            $this->response->redirect($url);
        }
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function taggedAction($tag)
    {
        $all = $this->questions->findAllQuestionsWithTag($tag);

        $this->views->add('questions/list', [
            'questions'=> $all,
            'back' => "<a href={$this->url->create('questions')}>Back to questions</a>",
            'title' => "View all questions " . $tag,
        ]);

    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function addQuestionAction($submit = false, $values = [])
    {
        if ($this->di->user->isAuthenticated()) {
            if (!$submit) {
                $this->dispatcher->forward([
                    'controller' => 'questionform',
                    'action'     => ''
                ]);
            } else {
                $now = date("c");
                $this->questions->create2([
                    'acronym' => $values['acronym'],
                    'title' => $values['title'],
                    'content' => $values['content'],
                    'created' => $now,
                ]);
                $id = $this->questions->getlastInsertId();

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $id, 'icon' => 'fa fa-question-circle', 'acronym' => $values['acronym'], 'action_desc' => 'asked a question', 'active' => 3]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'badge',
                    'params'     => [$values['acronym']]
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $values['acronym'], 'active_value' => 3]],
                ]);

                $tags = explode(',', $values['tag']);
                $this->dispatcher->forward([
                    'controller' => 'tags',
                    'action'     => '',
                    'params'     => [$id, $tags]
                ]);



                $url = $this->url->create('questions');
                $this->response->redirect($url);
            }
        }
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function addAnswerAction($submit = false, $id = null, $values = [])
    {
        //$this->initialize();
        if (!$this->di->user->isAuthenticated()) {
            $signin = $this->url->create('signin');
            $signup = $this->url->create('signup');
            $this->di->flashMessage->error("You need to be <a href={$signin}>signed in</a> to ask a question! Don't got a account yet? <a href={$signup}>Sign up</a> here!");
        } elseif (!$submit) {
            $this->dispatcher->forward([
                'controller' => 'questionform',
                'action'     => 'answer',
                'params'     => [$id],
            ]);
        } else {
            $now = date("c");
            $res = $this->questions->create2([
                'question_id' => $id,
                'acronym'     => $values['acronym'],
                'content'     => $values['content'],
                'created'     => $now,
            ]);

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'add',
                'params'     => [['other_id' => $id, 'icon' => 'fa fa-reply', 'acronym' => $values['acronym'], 'action_desc' => 'answered a question', 'active' => 2]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'badge',
                'params'     => [$values['acronym']]
            ]);

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'updatevalue',
                'params'     => [['acronym' => $values['acronym'], 'active_value' => 2]],
            ]);



            if ($res) {
                $nrOfAnswers = $this->questions->countAllAnswers($id);
                $this->questions->save([
                    'id' => $id,
                    'answers' => $nrOfAnswers,
                ]);
                $url = $this->url->create('questions/id/' . $id);
                $this->response->redirect($url);
            } else {
                //$this->di->flashMessage->error("Something went wrong when processing your answer.");
            }

            /*$url = $this->url->create($id);
            $this->response->redirect($url);*/
        }
    }



    /**
     * Edit question.
     *
     * @param id of user to edit
     *
     * @return void
     */
    public function updatequestionAction($id)
    {
        //$this->initialize();
        $question = $this->questions->find($id);
        if ($this->di->user->isAuthenticated() && $this->di->user->getUserAcronym() == $question->acronym) {
            $form = new \Mos\HTMLForm\CForm([], [
                'title2' => [
                    'type'        => 'text',
                    'label'       => 'Title',
                    'required'    => true,
                    'validation'  => ['not_empty'],
                    'value' => $question->title,
                ],
                /*'tag2' => [
                    'type'        => 'text',
                    'label'       => 'Tags',
                    'required'    => true,
                    'validation'  => ['not_empty'],
                    'value' => $question->tag,
                ],*/
                'content2' => [
                    'type'        => 'textarea',
                    'label'       => 'Description',
                    'required'    => true,
                    'validation'  => ['not_empty', 'email_adress'],
                    'value' => $question->content,
                ],
                'update' => [
                    'type' => 'submit',
                    'value'=> 'Update',
                    'callback'  => function ($form) {
                        //$form->saveInSession = true;
                        return true;
                    }
                ],
            ]);

            /*No idea what is happening here, the form always submit false.*/

            $form->check(
                function ($form) use ($question) {
                    $now = date("c");
                    $this->questions->update2([
                        'id' => $question->id,
                        'title' => $form->Value('title'),
                        //'tag' => $form->Value('tag'),
                        'content' => $form->Value('content'),
                        'updated' => $now,
                    ]);
                    $tags = explode(',', $values['tag']);
                    $this->dispatcher->forward([
                        'controller' => 'tags',
                        'action'     => 'update',
                        'params'     => [$question->id, $tags]
                    ]);
                    $url = $this->url->create('questions/updatequestion/' . $question->id);
                    $this->response->redirect($url);
                },
                function ($form) use ($question) {
                    $now = date("c");
                    $this->questions->update2([
                        'id' => $question->id,
                        'title' => $form->Value('title2'),
                        //'tag' => $form->Value('tag'),
                        'content' => $form->Value('content2'),
                        'updated' => $now,
                    ]);
                    /*$tags = explode(',', $form->Value('tag2'));
                    $this->dispatcher->forward([
                        'controller' => 'tags',
                        'action'     => 'update',
                        'params'     => [$question->id, $tags]
                    ]);*/
                    $url = $this->url->create('questions/updatequestion/' . $question->id);
                    $this->response->redirect($url);
                }

            );

            $this->views->add('questions/html', [
                'content' => $form->getHTML(),
                'value' => $question,
                'title' => 'Update your Question',
            ]);
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }

    }



    /**
     * Edit question.
     *
     * @param id of user to edit
     *
     * @return void
     */
    public function updateanswerAction($id)
    {
        //$this->initialize();
        $answer = $this->questions->find($id);
        if ($this->di->user->isAuthenticated() && $this->di->user->getUserAcronym == $answer->acronym) {
            $form = new \Mos\HTMLForm\CForm([], [
                'content' => [
                    'type'        => 'textarea',
                    'label'       => 'Description',
                    'required'    => true,
                    'validation'  => ['not_empty', 'email_adress'],
                    'value' => $answer->content,
                ],
                'submit' => [
                    'type' => 'submit',
                    'value'=> 'Update',
                    'callback'  => function ($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],
            ]);


            //Same here as in updatequestion where the form always is false for some reason
            $form->check(
                function ($form) use ($answer) {
                    $now = date("c");
                    $this->questions->update2([
                        'id' => $answer->id,
                        'content' => $form->Value('content'),
                        'updated' => $now,
                    ]);

                    $url = $this->url->create('questions/updateanswer/' . $answer->id);
                    $this->response->redirect($url);
                },
                function ($form) use ($answer) {
                    $now = date("c");
                    $this->questions->update2([
                        'id' => $answer->id,
                        'content' => $form->Value('content'),
                        'updated' => $now,
                    ]);

                    $url = $this->url->create('questions/updateanswer/' . $answer->id);
                    $this->response->redirect($url);
                }

            );

            $this->views->add('questions/html', [
                'content' => $form->getHTML(),
                'value'   => $answer,
                'title' => 'Update your Answer',
            ]);
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }

    }



    /**
     * Updates comment.
     *
     * @param integer $id of user to delete
     *
     * @return void
     */
    public function updatecommentAction($id = null)
    {
        if ($this->di->user->isAuthenticated()) {
            $this->dispatcher->forward([
                'controller' => 'comment',
                'action'     => 'update',
                'params'     => [$id]
            ]);
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }
    }



    /**
     * Deletes questions.
     *
     * @param integer $id of question to delete
     *
     * @return void
     */
    public function deletequestionAction($id = null)
    {
        $url = $this->url->create('questions');
        if (!isset($id)) {
            $this->response->redirect($url);
        }

        $question = $this->questions->find($id);

        if ($this->di->user->getUserAcronym() == $question->acronym) {
            $this->dispatcher->forward([
                'controller' => 'q2t',
                'action'     => 'delete',
                'params'     => [$id],
            ]);
            $this->questions->delete2($id);
            $this->response->redirect($_SERVER['HTTP_REFERER']);
        }
        $this->response->redirect($url);
    }



    /**
     * Deletes answers.
     *
     * @param integer $id of answer to delete
     *
     * @return void
     */
    public function deleteanswerAction($id = null)
    {
        $url = $this->url->create('questions');
        if (!isset($id)) {
            $this->response->redirect($url);
        }

        $question = $this->questions->find($id);
        if ($this->di->user->getUserAcronym() == $question->acronym) {
            $this->dispatcher->forward([
                'controller' => 'q2t',
                'action'     => 'delete',
                'params'     => [$id],
            ]);
            $res = $this->questions->deleteanswer($id);
            $nrOfAnswers = $this->questions->countAllAnswers($question->question_id);

            $this->questions->update3([
                'id' => $question->question_id,
                'answers' => $nrOfAnswers,
            ]);
            $this->response->redirect($_SERVER['HTTP_REFERER']);
        }
        $this->response->redirect($url);
    }



    /**
     * Deletes comments.
     *
     * @param integer $id of comment to delete
     *
     * @return void
     */
    public function deletecommentAction($id = null)
    {
        $url = $this->url->create('questions');
        if (!isset($id)) {
            $this->response->redirect($url);
        }


        $this->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'delete',
            'params'     => [$id],
        ]);

        //$this->response->redirect($url);
    }



    /**
     * Upvote question/answer
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function upvoteAction($id = null)
    {
        $question = $this->questions->find($id);
        $url = $this->url->create('questions/id/' . $id. '#C' . $id);
        $acronym = $this->di->user->getUserAcronym();
        if ($question->acronym != $acronym) {
            $relateda = $this->dispatcher->forward([
                'controller' => 'vote',
                'action'     => 'getRelated',
                'params'     => [$acronym, $id],
            ]);

            $boolean = true;
            $boolean2 = false;
            //dump($relateda);
            foreach ($relateda as $activity) {
                if ($activity->action_desc == "upvote") {
                    $boolean = false;
                } elseif ($activity->action_desc == "downvote") {
                    $boolean2 = true;
                }
            }

            if ($boolean) {
                if ($boolean2) {
                    $this->questions->update2([
                        'id' => $question->id,
                        'score' => $question->score + 2,
                    ]);
                } else {
                    $this->questions->update2([
                        'id' => $question->id,
                        'score' => $question->score + 1,
                    ]);
                }

                $relateda = $this->dispatcher->forward([
                    'controller' => 'vote',
                    'action'     => 'delete',
                    'params'     => [$acronym, $id],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'vote',
                    'action'     => 'add',
                    'params'     => [['question' => $id, 'acronym' => $acronym, 'action_desc' => 'upvote']],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $id, 'icon' => 'fa fa-thumbs-up', 'acronym' => $acronym, 'action_desc' => 'gave a positive vote', 'active' => 1, 'reputation' => 1]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $acronym, 'active_value' => 1, 'reputation' => 1]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-thumbs-o-up', 'acronym' => $question->acronym, 'action_desc' => 'got a positive vote', 'reputation' => 3]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $question->acronym, 'reputation' => 3 ]],
                ]);

            }


            if (isset($question->question_id)) {
                $url = $this->url->create('questions/id/' . $question->question_id . '#C' . $question->question_id);
            } else {
                $url = $this->url->create('questions/id/' . $question->id . '#C' . $question->id);
            }
            $this->response->redirect($url);
        }
        $this->response->redirect($url);
    }



    /**
     * Downvote question/answer
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function downvoteAction($id = null)
    {
        $question = $this->questions->find($id);
        $url = $this->url->create('questions/id/' . $question->question_id. '#C' . $id);

        $user = $this->di->user->findByAcronym($this->di->user->getUserAcronym());
        $acronym = $user->acronym;

        if ($question->acronym != $acronym && $user->reputation > 0) {
            $relateda = $this->dispatcher->forward([
                'controller' => 'vote',
                'action'     => 'getRelated',
                'params'     => [$acronym, $id],
            ]);

            $boolean = true;
            $boolean2 = false;
            foreach ($relateda as $activity) {
                if ($activity->action_desc == "downvote") {
                    $boolean = false;
                } elseif ($activity->action_desc == "upvote") {
                    $boolean2 = true;
                }
            }

            if ($boolean) {
                if ($boolean2) {
                    $this->questions->update2([
                        'id' => $question->id,
                        'score' => $question->score - 2,
                    ]);
                } else {
                    $this->questions->update2([
                        'id' => $question->id,
                        'score' => $question->score - 1,
                    ]);
                }

                $this->dispatcher->forward([
                    'controller' => 'vote',
                    'action'     => 'delete',
                    'params'     => [$acronym, $id],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'vote',
                    'action'     => 'add',
                    'params'     => [['question' => $id, 'acronym' => $acronym, 'action_desc' => 'downvote']],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $id, 'icon' => 'fa fa-thumbs-down', 'acronym' => $acronym, 'action_desc' => 'gave a negative vote', 'active' => 1]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $acronym, 'active_value' => 1]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-thumbs-o-down', 'acronym' => $question->acronym, 'action_desc' => 'got a negative vote', 'reputation' => -3]],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $question->acronym, 'reputation' => -3 ]],
                ]);

            }
        }

        if (isset($question->question_id)) {
            $url = $this->url->create('questions/id/' . $question->question_id . '#C' . $question->question_id);
        } else {
            $url = $this->url->create('questions/id/' . $question->id . '#C' . $question->id);
        }
        $this->response->redirect($url);
    }



    /**
     * Returns all related questions/answers to a user
     *
     *
     */
    public function getRelatedAction($acronym)
    {
        $allRelated = $this->questions->findAllRelated($acronym);
        return $allRelated;
    }



    /**
     * Set an accepted answer
     *
     * @param $id, the id of the answer
     */
    public function setacceptedAction($id = null)
    {
        $answer = $this->questions->find($id);
        $aacronym = $answer->acronym;
        $question = $this->questions->find($answer->question_id);

        if ($this->di->user->getUserAcronym() == $question->acronym) {
            if (isset($question->bounty)) {
                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $aacronym, 'reputation' => $question->bounty ]],
                ]);

                $this->questions->update2([
                    'id' => $question->id,
                    'accepted' => $id,
                    'bounty' => null,
                    'bountytime' => null,
                ]);

                $this->dispatcher->forward([
                    'controller' => 'activities',
                    'action'     => 'add',
                    'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-dollar', 'acronym' => $aacronym, 'action_desc' => 'awarded a bounty', 'reputation' => $question->bounty]],
                ]);
            } else {
                $this->questions->update2([
                    'id' => $question->id,
                    'accepted' => $id,
                ]);
            }

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'add',
                'params'     => [['other_id' => $id, 'icon' => 'fa fa-check-circle', 'acronym' => $question->acronym, 'action_desc' => 'accepted an answer', 'active' => 3]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'updatevalue',
                'params'     => [['acronym' => $question->acronym, 'active_value' => 3]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'add',
                'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-check-circle-o', 'acronym' => $aacronym, 'action_desc' => 'answer got accepted', 'reputation' => 10]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'updatevalue',
                'params'     => [['acronym' => $aacronym, 'reputation' => 10 ]],
            ]);


        }
        $url = $this->url->create('questions/id/' . $question->id);
        $this->response->redirect($url);
    }

    /**
     * Unset an accepted answer
     *
     * @param $idQuestion, the id of the question
     * @param $idAnswer, the id of the answer
     */
    public function unsetacceptedAction($id = null)
    {
        $answer = $this->questions->find($id);
        $aacronym = $answer->acronym;
        $question = $this->questions->find($answer->question_id);
        if ($this->di->user->getUserAcronym() == $question->acronym) {
            $this->questions->update2([
                'id' => $question->id,
                'accepted' => null,
            ]);

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'add',
                'params'     => [['other_id' => $id, 'icon' => 'fa fa-times-circle', 'acronym' => $question->acronym, 'action_desc' => 'rejected an already accepted answer', 'reputation' => -5]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'updatevalue',
                'params'     => [['acronym' => $question->acronym, 'reputation' => -5]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'activities',
                'action'     => 'add',
                'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-times-circle-o', 'acronym' => $aacronym, 'action_desc' => 'accepted answer got rejected', 'reputation' => -5]],
            ]);

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'updatevalue',
                'params'     => [['acronym' => $aacronym, 'reputation' => -5 ]],
            ]);


        }
        $url = $this->url->create('questions/id/' . $question->id);
        $this->response->redirect($url);
    }


    /**
     * Sets bounty for a question
     *
     * @param integer $id of question to set a bounty on.
     *
     * @return void
     */
    public function bountyAction($id = null)
    {
        //$this->initialize();
        $question = $this->questions->find($id);
        if ($this->di->user->isAuthenticated() && $this->di->user->getUserAcronym() == $question->acronym) {
            $this->di->flashMessage->warning("Remember that setting a bounty is non refundable, the amount chosen will be deducted from your total reputation forever ( it's a long time )!");
            $html = $this->di->flashMessage->get();
            $this->di->flashMessage->clear();
            $html .= '<span id="currentValue">50</span><span> Reputation</span>';
            $form = new \Mos\HTMLForm\CForm([], [
                'range' => [
                    'type'        => 'range',
                    'description' => 'Min is 50 and Max bounty is 500',
                    'placeholder' => 'Here is a placeholder',
                    'value'       => 50,
                    'min'         => 50,
                    'max'         => 500,
                    'step'        => 50,
                    'oninput'     => 'myFunction(this.value)'
                ],
                'submit' => [
                    'type' => 'submit',
                    'value'=> 'Set Bounty',
                    'callback'  => function ($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],
            ]);

            //Same here as in updatequestion where the form always is false for some reason
            $form->check(
                function ($form) use ($question) {
                    $now = date("c");
                    $future = date('c', strtotime("+1 day"));
                    $eligible = $this->dispatcher->forward([
                        'controller' => 'users',
                        'action'     => 'checkReputation',
                        'params'     => [['acronym' => $question->acronym, 'repValue' => $form->Value('range') ]],
                    ]);

                    if ($eligible) {
                        $this->questions->update2([
                            'id' => $question->id,
                            'bounty' => $form->Value('range'),
                            'bountytime' => $future,
                        ]);

                        $eligible = $this->dispatcher->forward([
                            'controller' => 'users',
                            'action'     => 'updatevalue',
                            'params'     => [['acronym' => $question->acronym, 'reputation' => -$form->Value('range') ]],
                        ]);

                        $this->dispatcher->forward([
                            'controller' => 'activities',
                            'action'     => 'add',
                            'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-exclamation', 'acronym' => $question->acronym, 'action_desc' => 'set a bounty', 'reputation' => -$form->Value('range')]],
                        ]);

                        $url = $this->url->create('questions/id/' . $question->id);
                        $this->response->redirect($url);
                    } else {
                        $url = $this->url->create('questions/bounty/' . $question->id);
                        $this->response->redirect($url);
                    }
                },
                function ($form) use ($question) {
                    /*$now = date("c");
                    $this->questions->update2([
                        'id' => $question->id,
                        'bounty' => $form->Value('range'),
                        'updated' => $now,
                    ]);

                    $url = $this->url->create('questions/id/' . $question->id);
                    $this->response->redirect($url);*/
                }

            );

            $html .= $form->getHTML();
            $this->views->add('questions/html', [
                'content' => $html,
                'value'   => $question,
                'title' => 'Set a Bounty',
            ]);
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }
    }



    /**
     * Checks bounty for all questions
     *
     * @param integer $id of question to set a bounty on.
     *
     * @return void
     */
    public function checkBountyAction()
    {
        $questions = $this->questions->findAll();
        $now = date("c");

        foreach ($questions as $question) {
            if (!isset($question->question_id)) {

                if (isset($question->bountytime) && $now > $question->bountytime) {
                    $answers = $this->questions->findAllAnswers($question->id);

                    $id = 0;
                    $score = 0;

                    foreach ($answers as $answer) {
                        if ($answer->score >= 2 && $answer->score > $score) {
                            $score = $answer->score;
                            $id = $answer->id;
                        }
                    }

                    if ($id != 0 && $score != 0) {
                        $answer = $this->questions->find($id);

                        $this->questions->update3([
                            'id' => $answer->question_id,
                            'bounty' => null,
                            'bountytime' => null,
                        ]);

                        $this->dispatcher->forward([
                            'controller' => 'users',
                            'action'     => 'updatevalue',
                            'params'     => [['acronym' => $answer->acronym, 'reputation' => $question->bounty]],
                        ]);

                        $this->dispatcher->forward([
                            'controller' => 'activities',
                            'action'     => 'add',
                            'params'     => [['other_id' => $question->id, 'icon' => 'fa fa-dollar', 'acronym' => $answer->acronym, 'action_desc' => 'awarded a bounty', 'reputation' => $question->bounty]],
                        ]);

                    } else {
                        $this->questions->update2([
                            'id' => $question->id,
                            'bounty' => null,
                            'bountytime' => null,
                        ]);
                    }
                }
            }
        }
    }
}
