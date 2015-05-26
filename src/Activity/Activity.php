<?php
namespace Anax\Activity;

/**
 * Model for Users.
 *
 */
class Activity extends \Anax\MVC\CDatabaseModel
{



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllRelated2($acronym)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym = ?')
                 ->orderBy('created desc');
        $this->db->execute([$acronym]);
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllRelated($acronym, $limit = null)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym = ?')
                 ->orderBy('created desc')
                 ->limit($limit);
        $this->db->execute([$acronym]);
        return $this->db->fetchAll();
    }

    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllLimit($limit)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->orderBy('created desc')
                 ->limit($limit);
        $this->db->execute();
        return $this->db->fetchAll();
    }
}
