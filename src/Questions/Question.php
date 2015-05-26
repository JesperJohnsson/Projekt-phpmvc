<?php
namespace Anax\Questions;

/**
 * Model for Users.
 *
 */
class Question extends \Anax\MVC\CDatabaseModel
{

    /**
     *
     */
    public function __construct()
    {
        $this->setSource("VQuestion");
    }

    /**
     * Save current object/row.
     *
     * @param array $values key/values to save or empty to use object properties.
     *
     * @return boolean true or false if saving went okey.
     */
    public function save($values = [])
    {
        $this->setProperties($values);
        $values = $this->getProperties();

        if (isset($values['id'])) {
            return $this->update2($values);
        } else {
            return $this->create2($values);
        }
    }

    /**
     * Create new row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function create2($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        $this->db->insert(
            "question",
            $keys
        );

        $res = $this->db->execute($values);

        $this->id = $this->db->lastInsertId();

        return $res;
    }



    /**
     * Update row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function update2($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        array_shift($keys);
        array_shift($values);

        // Its update, remove id and use as where-clause
        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update(
            "question",
            $keys,
            "id = ?"
        );
        return $this->db->execute($values);
    }



    /**
     * Update row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function update3($values)
    {
        $this->id = $values['id'];
        $keys   = array_keys($values);
        $values = array_values($values);

        // Its update, remove id and use as where-clause

        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update(
            "question",
            $keys,
            "id = ?"
        );
        return $this->db->execute($values);
    }



    /**
     * Delete row.
     *
     * @param integer $id to delete.
     *
     * @return boolean true or false if deleting went okey.
     */
    public function delete2($id)
    {
        $ids[] = $id;
        $this->db->delete(
            'question',
            'id = ? or question_id = ?'
        );

        return $this->db->execute([$id, $id]);
    }



    /**
     * Delete row.
     *
     * @param integer $id to delete.
     *
     * @return boolean true or false if deleting went okey.
     */
    public function deleteanswer($id)
    {
        $ids[] = $id;
        $this->db->delete(
            'question',
            'id = ?'
        );

        return $this->db->execute([$id]);
    }



    /**
     * Find and return all questions with a limit.
     *
     * @return this
     */
    public function findAllLimit($limit)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('question_id IS NULL')
                 ->orderBy('created desc')
                 ->limit($limit);
        $this->db->execute();
        return $this->db->fetchAll();
    }



    /**
     * Find and return all questions with a bounty.
     *
     * @return this
     */
    public function findAllBounty()
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('question_id IS NULL')
                 ->andWhere('bounty IS NOT NULL')
                 ->orderBy('created desc');
        $this->db->execute();
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllRelated($acronym)
    {
        $this->db->select()
                 ->from("question")
                 ->where('acronym = ?');
        $this->db->execute([$acronym]);
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllQuestionsWithTag($tag)
    {
        $tag = '%'. $tag . '%';

        $this->db->select()
                 ->from($this->getSource())
                 ->where('tag LIKE ?');
        $this->db->execute([$tag]);
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllAndOrder($orderBy)
    {
        if (!isset($orderBy) ||  $orderBy == "created") {
            $orderBy = "created desc";
        }

        $this->db->select()
                 ->from($this->getSource())
                 ->orderBy($orderBy);
        $this->db->execute();
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllAnswers($id, $order = 'created')
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('question_id = ?')
                 ->orderBy($order);
        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function countAllAnswers($id)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('question_id = ?');
        $this->db->execute([$id]);
        $questions = $this->db->fetchAll();
        $nrOfQuestions = count($questions);
        return $nrOfQuestions;
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function getId()
    {
        $this->db->select("COUNT(*)")
                 ->from("question");
        $this->db->execute();
        $question = $this->db->fetchOne();
        return $question++;
    }

}
