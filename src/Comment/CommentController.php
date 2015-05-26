<?php
namespace Anax\Comment;

/**
 * A controller for users and admin related events.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->comments2 = new \Anax\Comment\Comment2();
        $this->comments2->setDI($this->di);
    }



    /**
     * List all comments .
     *
     * @param $pageId is the page where the comments is
     *
     * @return void
     */
    public function listAction($id = null)
    {
        $this->initialize();
        $comments = $this->comments2->query()
                    ->where('question_id = ?')
                    ->orderBy("created desc")
                    ->execute([$id,]);

        $this->views->add('questions/comment', [
            'comments' => $comments,
            'pageId' => $id,
        ], 'CW' . $id);
    }



    /**
     * Add new comment.
     *
     * @return void
     */
    public function addAction($values = [])
    {
        $this->initialize();
        $now = date("c");
        $acronym = $this->di->user->getUserAcronym();

        $this->comments2->create([
            'question_id' => $values['id'],
            'thread_id' => $values['question_id'],
            'acronym' => $acronym,
            'content' => $values['content'],
            'created' => $now,
        ]);

        $this->dispatcher->forward([
            'controller' => 'activities',
            'action'     => 'add',
            'params'     => [['other_id' => $values['question_id'], 'icon' => 'fa fa-comment', 'acronym' => $acronym, 'action_desc' => 'left a comment', 'active' => 1]],
        ]);

        $this->dispatcher->forward([
            'controller' => 'activities',
            'action'     => 'badge',
            'params'     => [$acronym]
        ]);

        $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'updatevalue',
            'params'     => [['acronym' => $acronym, 'active_value' => 1]],
        ]);



        $this->response->redirect($_SERVER['HTTP_REFERER']);
        //$url = $this->url->create('questions/id/' . $values['question_id']);
        //$this->response->redirect($url);

    }

    /**
     * Add new user.
     *
     * @param id of comment to edit
     *
     * @return void
     */
    public function updateAction($id)
    {
        $comment = $this->comments2->find($id);
        if ($this->di->user->getUserAcronym() == $comment->acronym) {
            $form = new \Mos\HTMLForm\CForm([], [
                'contentcomment' => [
                    'type'        => 'textarea',
                    'label'       => 'Update Comment',
                    'required'    => true,
                    'validation'  => ['not_empty'],
                    'value' => $comment->content,
                ],
                'idcomment' => [
                    'type'      => 'hidden',
                    'value'     => $comment->id,
                ],
                'question_idcomment' => [
                    'type'      => 'hidden',
                    'value'     => $comment->question_id,
                ],
                'thread_idcomment' => [
                    'type'      => 'hidden',
                    'value'     => $comment->thread_id,
                ],
                'updatecomment' => [
                    'type' => 'submit',
                    'value' => 'Update',
                    'callback'  => function ($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],
            ]);

            $form->check(
                function ($form) use ($comment) {
                    $now = date("c");
                    $this->comments2->update([
                        'id' => $form->Value('idcomment'),
                        'content' => $form->Value('contentcomment'),
                        'question_id' => $form->Value('question_idcomment'),
                        'thread_id' => $form->Value('thread_idcomment'),
                        'updated' => $now,
                    ]);

                    $url = $this->url->create('questions/updatecomment/' . $comment->id);
                    $this->response->redirect($url);
                },
                function ($form) {
                    $form->addOutput('Something went wrong, check your credentials and try again.');
                }

            );

            $this->views->add('comment/html', [
                'content' => $form->getHTML(),
                'value' => $comment,
                'title' => 'Update comment',
            ]);
        } else {
            $url = $this->url->create('questions/id/' . $comment->thread_id);
            $this->response->redirect($url);
        }
    }


    /**
     * Delete comment.
     *
     * @param integer $id of comment to delete
     *
     * @return void
     */
    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $comment = $this->comments2->find($id);

        if ($this->di->user->getUserAcronym() == $comment->acronym) {
            $res = $this->comments2->delete($id);
        }
        $url = $this->url->create('questions/id/' .$comment->thread_id);
        $this->response->redirect($url);
    }




    /**
     * Returns all related comments to a user
     *
     *
     */
    public function getRelatedAction($acronym)
    {
        $allRelated = $this->comments2->findAllRelated($acronym);
        return $allRelated;
    }
}
