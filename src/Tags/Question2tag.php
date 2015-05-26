<?php
namespace Anax\Tags;

/**
 * Model for Users.
 *
 */
class Question2tag extends \Anax\MVC\CDatabaseModel
{
    /**
     * Delete all rows where question_id = $id.
     * This is to reset the tags.
     *
     * @param integer $id to delete.
     *
     * @return boolean true or false if deleting went okey.
     */
    public function delete($id)
    {
        $this->db->delete(
            $this->getSource(),
            'question_id = ?'
        );

        return $this->db->execute([$id]);
    }


    /**
     * Get the number of times this tag is used.
     *
     * @param integer $id to delete.
     *
     * @return boolean true or false if deleting went okey.
     */
    public function findTagsAmount($id)
    {
        /*$this->db->select("COUNT(*)")
                 ->where("tag_id = ?");

        return $this->db->execute([$id]);*/
    }
}
