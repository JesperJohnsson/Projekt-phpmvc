<?php
namespace Anax\Activity;

/**
 * A controller for users and admin related events.
 *
 */
class ActivitiesController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->activities = new \Anax\Activity\Activity();
        $this->activities->setDI($this->di);
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
        $all = $this->activities->findAllRelated($acronym);

        $this->views->add('activities/list', [
            'activities' => $all,
            'title' => "Activities",
        ]);
    }



    /**
     * List all comments .
     *
     * @param $pageId is the page where the comments is
     *
     * @return void
     */
    public function frontpageAction()
    {
        $this->initialize();
        $all = $this->activities->findAllLimit(25);

        $this->views->add('activities/list', [
            'activities' => $all,
            'title' => "Newest Activities",
        ]);
    }



    /**
     * List all comments .
     *
     * @param $pageId is the page where the comments is
     *
     * @return void
     */
    public function badgeAction($acronym = null)
    {
        $all = $this->activities->findAllRelated2($acronym);
        $questions = 0;
        $answers = 0;
        $comments = 0;

        $action_desc = ["asked a question"];

        foreach ($all as $activity) {
            if ($activity->action_desc == $action_desc[0]) {
                $questions++;
            }
            if ($activity->action_desc == "answered a question") {
                $answers++;
            }
            if ($activity->action_desc == "left a comment") {
                $comments++;
            }
        }

        $this->setbadge($acronym, $all, "question", $questions);
        $this->setbadge($acronym, $all, "answer", $answers);
        $this->setbadge($acronym, $all, "comment", $comments);
    }



    public function setbadge($acronym, $all, $type, $nrOfType)
    {
        $badges = [1, 5, 10, 25, 50, 100];
        $point = [10, 25, 50, 100, 250, 500];
        $desc = [ 'First','5th','10th','25th','50th','100th',];
        $has = [false,false,false,false,false,false];

        foreach ($badges as $key => $badge) {
            foreach ($all as $activity) {
                if ($activity->action_desc == $desc[$key] . " " . $type) {
                    $has[$key] = true;
                }
            }
            if ($nrOfType >= $badge && $has[$key] == false) {
                $this->addAction([
                    'other_id' => 0,
                    'icon' => 'fa fa-trophy',
                    'acronym' => $acronym,
                    'action_desc' => $desc[$key] . ' ' . $type,
                    'reputation' => $point[$key],
                ]);

                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'updatevalue',
                    'params'     => [['acronym' => $acronym, 'reputation' => $point[$key]]],
                ]);
            }
        }
    }



    /**
     * Add new comment.
     *
     * @return void
     */
    public function addAction($values = [])
    {
        $reputation = null;
        if (isset($values['reputation'])) {
            $reputation = $values['reputation'];
        }
        $active = null;
        if (isset($values['active'])) {
            $active = $values['active'];
        }
        $now = date("c");
        $this->activities->create([
            'other_id' => $values['other_id'],
            'icon' => $values['icon'],
            'acronym' => $values['acronym'],
            'action_desc' => $values['action_desc'],
            'active' => $active,
            'reputation' => $reputation,
            'created' => $now,
        ]);
    }



    /**
     * Returns all related activities to a user
     */
    public function getRelatedAction($acronym, $limit)
    {
        $allRelated = $this->activities->findAllRelated($acronym, $limit);
        return $allRelated;
    }
}
