<?php
namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findAllSearch($search, $order)
    {
        if (!isset($order)) {
            $order = 'created';
        }

        $search = '%' . $search . '%' ;
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym LIKE ?')
                 ->orderBy($order);
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
                 ->orderBy("created desc")
                 ->limit($limit);
        $this->db->execute();
        return $this->db->fetchAll();
    }



    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findByAcronym($acronym)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('acronym = ?');
        $this->db->execute([$acronym]);
        $user = $this->db->fetchInto($this);
        return $user;
    }



    /**
    * Find and return specific.
    *
    * @return this
    */
    public function findByEmail($email, $not_id = null)
    {
        if (!$not_id) {
            $this->db->select()
                ->from($this->getSource())
                ->where("email = ?");
                $this->db->execute([$email]);
        } else {
            $this->db->select()
                ->from($this->getSource())
                ->where("email = ?")
                ->andWhere("id ?");
            $this->db->execute([$email, $not_id]);
        }
        return $this->db->fetchInto($this);
    }


    /**
     * Find and return specific.
     *
     * @return this
     */
    public function login($acronym, $password)
    {
        $currentUser = $this->findByAcronym($acronym);
        if (isset($currentUser->acronym)) {
            if (password_verify($password, $currentUser->password)) {
                $this->session->set(
                    'user',
                    [
                        'id'        => $currentUser->id,
                        'acronym'   => $currentUser->acronym,
                        'name'      => $currentUser->name,
                        'email'     => $currentUser->email,
                        'type'      => $currentUser->type,
                        'gravatar'  => $currentUser->gravatar,
                        'active_value'  => $currentUser->active_value,
                        'reputation' => $currentUser->reputation,
                        'created'   => $currentUser->created,
                        'active'    => $currentUser->active,
                    //'contributionCount' => $currentUser->contributionCount,
                    ]
                );
                return true;

            } else {
                session_unset();
                return false;
            }
        }
    }



    /*
     * Gets the user as an array.
     *
     * @return array, with the user info.
     */
    public function logout()
    {
        $currentUser = $this->session->get('user');
        if (isset($currentUser)) {
            session_unset($currentUser);
        }
    }



    /*
     * Gets the user as an array.
     *
     * @return array, with the user info.
     */
    public function getUser()
    {
        $currentUser = $this->session->get('user');
        if (isset($currentUser)) {
            return $currentUser;
        }
    }



    /*
     * Check if user is logged in.
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        $currentUser = $this->getUser();
        if (isset($currentUser)) {
            return true;
        } else {
            return false;
        }
    }



    /*
     * Check if user is admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        $currentUser = $this->getUser();
        if ($currentUser['type'] === 'moderator') {
            return true;
        }
        return false;
    }



    /*
     * Gets the name of the user.
     * Relies on that there is a logged in user.
     *
     * @return string, name.
     */
    public function getUserName()
    {
        $currentUser = $this->getUser();
        return $currentUser['name'];
    }



    /*
     * Gets the acronym of the user.
     * Relies on that there is a logged in user.
     *
     * @return string, acronym.
     */
    public function getUserAcronym()
    {
        $currentUser = $this->getUser();
        return $currentUser['acronym'];
    }



    /*
     * Gets the email of the user.
     * Relies on that there is a logged in user.
     *
     * @return string, email.
     */
    public function getUserEmail()
    {
        $currentUser = $this->getUser();
        return $currentUser['email'];
    }



    /*
     * Gets the acronym of the user.
     * Relies on that there is a logged in user.
     *
     * @return string, gravatar.
     */
    public function getUserGravatar()
    {
        $currentUser = $this->getUser();
        return $currentUser['gravatar'];
    }



    /*
     * Gets the id of the user.
     * Relies on that there is a logged in user.
     *
     * @return int, id.
     */
    public function getUserId()
    {
        $currentUser = $this->getUser();
        return $currentUser['id'];
    }



    /*
     * Gets the id of the user.
     * Relies on that there is a logged in user.
     *
     * @return int, id.
     */
    public function getUserReputation()
    {
        $currentUser = $this->getUser();
        return $currentUser['reputation'];
    }
}
