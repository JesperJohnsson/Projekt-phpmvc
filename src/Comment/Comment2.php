<?php
namespace Anax\Comment;

/**
 * Model for Users.
 *
 */
class Comment2 extends \Anax\MVC\CDatabaseModel
{
    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllRelated($acronym)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym = ?');
        $this->db->execute([$acronym]);
        return $this->db->fetchAll();
    }
}
