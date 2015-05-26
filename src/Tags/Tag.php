<?php
namespace Anax\Tags;

/**
 * Model for Users.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function exists($tag)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('tag_description = ?');
        $this->db->execute([$tag]);
        return $this->db->fetchOne();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function getId()
    {
        $this->db->select("COUNT(*)")
                 ->from($this->getSource());
        $this->db->execute();
        $tag = $this->db->fetchOne();
        return $tag++;
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function getIdWithTag($tag)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('tag_description = ?');
        $this->db->execute([$tag]);
        $tag = $this->db->fetchOne();
        return $tag;
    }


    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllSearch($search)
    {
        $search = '%' . $search . '%' ;
        $this->db->select()
                 ->from($this->getSource())
                 ->where('tag_description LIKE ?');
        $this->db->execute([$search]);
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
                 ->orderBy("amount desc")
                 ->limit($limit);
        $this->db->execute();
        return $this->db->fetchAll();
    }
}
