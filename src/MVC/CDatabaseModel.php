<?php
namespace Anax\MVC;

/**
 * Model for Users.
 *
 */
class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Get the table name.
     *
     * @return string with the table name.
     */
    public function getSource()
    {
        if (isset($this->source)) {
            return $this->source;
        } else {
            return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
        }
    }



    /**
     * Set the table name.
     *
     * @return string with the table name.
     */
    public function setSource($source)
    {
        $this->source = $source;
        //return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
    }



    /**
     * Get the last Inserted Id.
     *
     * @return int id.
     */
    public function getlastInsertId()
    {
        return $this->db->lastInsertId();
    }



    /**
     * Creates a table
     *
     * @param $values is the table
     *
     * @return boolean true or false if saving went ok
     */
    public function setupTable($table)
    {
        $this->db->dropTableIfExists($this->getSource())->execute();
        $res = $this->db->createTable($this->getSource(), $table)->execute();
        return $res;
    }


    /**
     * Find and return all.
     *
     * @return array
     */
    public function findAll()
    {
        $this->db->select()
                 ->from($this->getSource());

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }



    /**
     * Get object properties.
     *
     * @return array with object properties.
     */
    public function getProperties()
    {
        $properties = get_object_vars($this);
        unset($properties['di']);
        unset($properties['db']);

        return $properties;
    }

    /**
     * Set object properties.
     *
     * @param array $properties with properties to set.
     *
     * @return void
     */
    public function setProperties($properties)
    {
        // Update object with incoming values, if any
        if (!empty($properties)) {
            foreach ($properties as $key => $val) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Find and return specific.
     *
     * @return this
     */
    public function find($id)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where("id = ?");

        $this->db->execute([$id]);
        return $this->db->fetchInto($this);
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
            return $this->update($values);
        } else {
            return $this->create($values);
        }
    }

    /**
     * Create new row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function create($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        $this->db->insert(
            $this->getSource(),
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
    public function update($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        // Its update, remove id and use as where-clause
        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update(
            $this->getSource(),
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
    public function delete($id)
    {
        $this->db->delete(
            $this->getSource(),
            'id = ?'
        );

        return $this->db->execute([$id]);
    }

    /**
     * Build a select-query.
     *
     * @param string $columns which columns to select.
     *
     * @return $this
     */
    public function query($columns = '*')
    {
        $this->db->select($columns)
                 ->from($this->getSource());

        return $this;
    }

    /**
     * Build the inner join part.
     *
     * @param string table, name of table.
     * @param string $condition to join.
     *
     * @return $this
     */
    public function join($table, $condition)
    {
        $this->db->join($table, $condition);

        return $this;
    }



    /**
     * Build the right join part.
     *
     * @param string $table, name of table.
     * @param string $condition to join
     *
     * @return $this
     */
    public function rightJoin($table, $condition)
    {
        $this->db->rightJoin($table, $condition);

        return $this;
    }



    /**
     * Build the left join part.
     *
     * @param string $table, name of table.
     * @param string $condition to join
     *
     * @return $this
     */
    public function leftJoin($table, $condition)
    {
        $this->db->leftJoin($table, $condition);

        return $this;
    }



    /**
     * Build the where part.
     *
     * @param string $condition for building the where part of the query.
     *
     * @return $this
     */
    public function where($condition)
    {
        $this->db->where($condition);

        return $this;
    }

    /**
     * Build the where part.
     *
     * @param string $condition for building the where part of the query.
     *
     * @return $this
     */
    public function andWhere($condition)
    {
        $this->db->andWhere($condition);

        return $this;
    }



    /**
     * Build the group by part.
     *
     * @param string $condition for building the group by part of the query.
     *
     * @return $this
     */
    public function groupBy($condition)
    {
        $this->db->groupBy($condition);

        return $this;
    }



    /**
     * Build the order by part.
     *
     * @param string $condition for building the order by part of the query.
     *
     * @return $this
     */
    public function orderBy($condition)
    {
        $this->db->orderBy($condition);

        return $this;
    }



    /**
     * Build the LIMIT part.
     *
     * @param string $condition for building the LIMIT part of the query.
     *
     * @return $this
     */
    public function limit($condition)
    {
        $this->db->limit($condition);

        return $this;
    }



    /**
     * Build the OFFSET part.
     *
     * @param string $condition for building the OFFSET part of the query.
     *
     * @return $this
     */
    public function offset($condition)
    {
        $this->db->offset($condition);

        return $this;
    }



    /**
     * Execute the query built.
     *
     * @param string $query custom query.
     *
     * @return $this
     */
    public function execute($params = [])
    {
        $this->db->execute($this->db->getSQL(), $params);
        $this->db->setFetchModeClass(__CLASS__);

        return $this->db->fetchAll();
    }
}
