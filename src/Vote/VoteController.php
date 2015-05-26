<?php
namespace Anax\Vote;

/**
 * A controller for users and admin related events.
 *
 */
class VoteController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->votes = new \Anax\Vote\Vote();
        $this->votes->setDI($this->di);
    }



    /**
     * List all comments .
     *
     * @param $pageId is the page where the comments is
     *
     * @return void
     */
    public function listAction($acronym = null)
    {
        $this->initialize();

        $all = $this->votes->findAllRelated($acronym);

        //$this->theme->setTitle("List all questions");
        $this->views->add('activities/list', [
            'activities' => $all,
            'title' => "Activities",
        ]);
    }



    /**
     * Add new comment.
     *
     * @return void
     */
    public function addAction($values = [])
    {
        $now = date("c");
        $this->votes->save([
            'question' => $values['question'],
            'acronym' => $values['acronym'],
            'action_desc' => $values['action_desc'],
            'created' => $now,
        ]);
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

    }


    /**
     * Delete comment.
     *
     * @param integer $id of comment to delete
     *
     * @return void
     */
    public function deleteAction($acronym, $question)
    {
        $related = $this->votes->findAllRelated($acronym, $question);
        foreach ($related as $rel) {
            if (isset($rel->id)) {
                $this->votes->delete($rel->id);
            }
        }
    }



    /**
     * Returns all related votes to a user and question
     */
    public function getRelatedAction($acronym, $question)
    {
        $allRelated = $this->votes->findAllRelated($acronym, $question);
        return $allRelated;
    }
}
