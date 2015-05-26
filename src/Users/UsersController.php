<?php
namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Creates/Resets the table in the database file to a default state
     * Also adds two default users, admin and John/Jane Doe
     *
     * @return void
     */
    public function setupAction()
    {
        if ($this->di->user->isAdmin()) {
            $table = [
                    'id'=> ['integer', 'primary key', 'not null', 'auto_increment'],
                    'acronym' => ['varchar(20)', 'unique', 'not null'],
                    'email' => ['varchar(80)'],
                    'name' => ['varchar(80)'],
                    'password' => ['varchar(225)'],
                    'gravatar' => ['varchar(80)'],
                    'active_value' => ['integer', 'default 0'],
                    'reputation' => ['integer', 'default 0'],
                    'type' => ['varchar(80)'],
                    'created' => ['datetime'],
                    'updated' => ['datetime'],
                    'deleted' => ['datetime'],
                    'active' => ['datetime'],
                ];
            $res = $this->users->setupTable($table);

            if ($res) {
                $now = date('c');

                $this->users->create([
                    'acronym' => 'jejd14',
                    'email' => 'jesper.johnsson1995@hotmail.com',
                    'name' => 'Jesper Johnsson',
                    'password' => password_hash('abc123', PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim('jesper.johnsson1995@hotmail.com'))),
                    'type' => 'moderator',
                    'created' => $now,
                    'active' => $now,
                ]);

                $this->users->create([
                    'acronym' => 'doe',
                    'email' => 'doe@dbwebb.se',
                    'name' => 'John/Jane Doe',
                    'password' => password_hash('doe', PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim('doe@dbwebb.se'))),
                    'type' => 'user',
                    'created' => $now,
                    'active' => $now,
                ]);

                $this->users->create([
                    'acronym' => 'winston',
                    'email' => 'winston@dbwebb.se',
                    'name' => 'Winston Crouch',
                    'password' => password_hash('winston', PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim('winston@dbwebb.se'))),
                    'type' => 'user',
                    'created' => $now,
                    'active' => $now,
                ]);

                $this->users->create([
                    'acronym' => 'eric111',
                    'email' => 'eric@dbwebb.se',
                    'name' => 'Eric Ryley',
                    'password' => password_hash('eric', PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim('eric@dbwebb.se'))),
                    'type' => 'user',
                    'created' => $now,
                    'active' => $now,
                ]);

                $this->users->create([
                    'acronym' => 'royale',
                    'email' => 'royale@dbwebb.se',
                    'name' => 'Royale Glover',
                    'password' => password_hash('royale', PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim('royale@dbwebb.se'))),
                    'type' => 'user',
                    'created' => $now,
                    'active' => $now,
                ]);
            }
        }
        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }



    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
        $form = new \Mos\HTMLForm\CForm(['action' => '?', 'method' => 'get'], [
            'search' => [
                'type'        => 'search-widget',
                'placeholder' => 'Search for users',
                'label'       => 'Search',
                'callback'  => function ($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        $search = $this->request->getGet('search');
        $order = $this->request->getGet('order');
        $this->initialize();

        $all = $this->users->findAllSearch($search, $order);
        $this->theme->setTitle("List all users");
        $this->views->add('users/list', [
            'search'=> $form->getHTML(),
            'users' => $all,
            'title' => "View all Users",
            'searchword' => $search,
            'orderby' => $order,
        ]);
    }


    /**
     * List all users.
     *
     * @return void
     */
    public function frontpageAction()
    {
        $this->initialize();

        $all = $this->users->findAllLimit(4);
        $this->views->add('users/front', [
            'users' => $all,
        ]);
    }




    /**
     * List user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
        $this->initialize();

        $limit = $this->request->getGet('limit');
        if (!isset($limit) || $limit < 20) {
            $limit = 20;
        }
        if ($limit == "all") {
            $limit = 2000000000;
        }

        $user = $this->users->find($id);
        $properties = $user->getProperties();
        $relatedqa = $this->dispatcher->forward([
            'controller' => 'questions',
            'action' => 'getRelated',
            'params' => [$user->acronym],
        ]);
        $relatedc = $this->dispatcher->forward([
            'controller' => 'comment',
            'action' => 'getRelated',
            'params' => [$user->acronym],
        ]);
        $relateda = $this->dispatcher->forward([
            'controller' => 'activities',
            'action' => 'getRelated',
            'params' => [$user->acronym, $limit],
        ]);

        $this->views->add('questions/separatelist', [
            'name' => $user->name,
            'questions' => $relatedqa,
            'comments' => $relatedc,
            'activities' => $relateda,
        ], 'qa');

        $this->theme->setTitle("View user " . $user->acronym);
        $this->views->add('users/view', [
            'user' => $user,
            'title' => ucfirst($properties['name']),
        ]);
    }

    /**
     * Add new user.
     *
     * @param string $acronym of user to add
     *
     * @return void
     */
    public function addAction($submit = false, $acronym = null, $email = null, $name = null, $password = null)
    {
        if (!$this->di->user->isAuthenticated()) {
            if (!$submit) {
                // Include userform
                $this->dispatcher->forward([
                    'controller' => 'userform',
                    'action'     => '',
                ]);
            } else {
                $now = date('c');
                $this->users->save([
                    'acronym' => $acronym,
                    'email' => $email,
                    'name' => $name,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'gravatar' => md5(strtolower(trim($email))),
                    'type' => 'user',
                    'created' => $now,
                    'active' => $now,
                ]);
                $this->loginAction(true, $acronym, $password);
            }
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }
    }

    /**
     * Edit user.
     *
     * @param id of user to edit
     *
     * @return void
     */
    public function updateAction($id)
    {
        $user2 = $this->users->find($id);
        $form = new \Mos\HTMLForm\CForm([], [
            'name' => [
                'type'        => 'text',
                'label'       => 'Name',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value' => $user2->name,
            ],
            'email' => [
                'type'        => 'text',
                'label'       => 'Email',
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
                'value' => $user2->email,
            ],
            'submit' => [
                'type' => 'submit',
                'callback'  => function($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        $form->check(
            function ($form) use ($user2) {
                $now = date('c');
                $this->users->update([
                    'id' => $user2->id,
                    'email' => $form->Value('email'),
                    'name' => $form->Value('name'),
                    'gravatar' => md5(strtolower(trim($form->Value('email')))),
                    'updated' => $now,
                ]);

                $url = $this->url->create('users/id/' . $this->users->id);
                $this->response->redirect($url);
            },
            function ($form) {
                $form->addOutput('Something went wrong, check your credentials and try again.');
            }

        );

        $this->views->add('me/page', [
            'content' => $form->getHTML(),
            'title' => 'Created new User',
        ]);

    }


    /**
     * Delete user.
     *
     * @param integer $id of user to delete
     *
     * @return void
     */
    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }



    /**
     * Delete (soft) user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function softDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }



    /**
     * Reactivate/Undelete a deleted (soft) user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function softUndeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->deleted = null;
        $user->active = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }



    /**
     * List all active and not deleted users.
     *
     * @return void
     */
    public function activeAction()
    {
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Users that are active");
        $this->views->add('users/list', [
            'users' => $all,
            'title' => "Users that are active",
        ]);
    }



    /**
     * List all inactive and deleted users.
     *
     * @return void
     */
    public function inactiveAction()
    {
        $all = $this->users->query()
            ->where('active IS NULL')
            ->execute();

        $this->theme->setTitle("Users that are inactive");
        $this->views->add('users/list', [
            'users' => $all,
            'title' => "Users that are inactive",
        ]);
    }

    /**
     * Make user active.
     *
     * @param integer $id of user to activate.
     *
     * @return void
     */
    public function activateAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->active = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $user->id);
        $this->response->redirect($url);
    }



    /**
     * Make user inactive.
     *
     * @param integer $id of user to deactivate.
     *
     * @return void
     */
    public function deactivateAction($id = null) {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->active = null;
        $user->save();

        $url = $this->url->create('users/id/' . $user->id);
        $this->response->redirect($url);
    }


    /**
     * List all soft-deleted users.
     *
     * @return void
     */
    public function trashcanAction()
    {
        $all = $this->users->query()
            ->where("deleted is NOT NULL")
            ->execute();

        $this->theme->setTitle("Users that are soft-deleted");
        $this->views->add('users/list', [
            'users' => $all,
            'title' => "Users that are soft-deleted",
        ]);
    }


    /**
     * Login a user.
     *
     */
    public function loginAction($submit = false, $acronym = null, $password = null)
    {
        if (!$this->users->isAuthenticated()) {
            if (!$submit) {
                $this->dispatcher->forward([
                    'controller' => 'userform',
                    'action'     => 'login',
                ]);
            } else {
                $admin = $this->url->create('users/id/' . 1);
                if ($this->users->login($acronym, $password)) {
                    $user = $this->users->findByAcronym($acronym);
                    if (isset($user->active)) {
                        if (!isset($user->deleted)) {
                            $url = $this->url->create('');
                            $this->response->redirect($url);
                        } else {
                            $this->users->logout();
                            $this->di->flashMessage->error("The account with this acronym is deleted, send a email <a href='$admin'>@Administrator</a> to get your account back.");
                        }

                    } else {
                        $this->users->logout();
                        $this->di->flashMessage->error("The account with this acronym is inactivated, send a email <a href='$admin'>@Administrator</a> to get your account back.");
                    }
                    //Redirect to welcome page
                    $url = $this->url->create('questions/ask');
                    $this->response->redirect($url);

                } else {
                    //Add error message
                    $this->di->flashMessage->error("Wrong acronym or password.");
                }
            }
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }
    }



    /**
     * logout a user.
     *
     */
    public function logoutAction()
    {
        if ($this->users->isAuthenticated()) {
            $this->users->logout();
            //Redirect to logout page
            $url = $this->url->create('');
            $this->response->redirect($url);
        } else {
            $url = $this->url->create('');
            $this->response->redirect($url);
        }
    }



    /**
     * logout a user.
     *
     */
    public function updatevalueAction($values = [])
    {
        $user = $this->users->findByAcronym($values['acronym']);

        $active_value = null;
        if (isset($values['active_value'])) {
            $active_value = $values['active_value'];
        }

        $reputation = null;
        if (isset($values['reputation'])) {
            $reputation = $values['reputation'];
        }

        $this->users->update([
            'id' => $user->id,
            'active_value' => $user->active_value + $active_value,
            'reputation' => $user->reputation + $reputation,
        ]);
    }



    /**
     * logout a user.
     *
     */
    public function checkReputationAction($values = [])
    {
        $user = $this->users->findByAcronym($values['acronym']);
        if ($values['repValue'] <= $user->reputation) {
            return true;
        } else {
            $this->di->flashMessage->error("Not enough reputation.");
            return false;
        }
    }
}
