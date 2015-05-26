<?php
namespace Anax\Tags;

/**
 * A controller for users and admin related events.
 *
 */
class Q2tController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->question2tag = new \Anax\Tags\Question2tag();
        $this->question2tag->setDI($this->di);
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function indexAction($id, $idTags)
    {
        $this->initialize();
        foreach ($idTags as $idTag) {
            $this->question2tag->create([
                'question_id' => $id,
                'tag_id' => $idTag,
            ]);
        }
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function getAllAction()
    {
        $this->initialize();
        $all = $this->question2tag->findAll();
        return $all;
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function updateAction($id, $idTags)
    {
        $this->initialize();
        $this->question2tag->delete($id);

        foreach ($idTags as $idTag) {
            $this->question2tag->create([
                'question_id' => $id,
                'tag_id' => $idTag,
            ]);
        }
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function deleteAction($id)
    {
        $this->question2tag->delete($id);
    }
}
