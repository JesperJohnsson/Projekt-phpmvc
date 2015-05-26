<?php
namespace Anax\Vote;

/**
 * Model for Users.
 *
 */
class Vote extends \Anax\MVC\CDatabaseModel
{
    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllRelated($acronym, $question)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym = ?')
                 ->andWhere('question = ?')
                 ->orderBy('created desc');
        $this->db->execute([$acronym, $question]);
        return $this->db->fetchAll();
    }
}
