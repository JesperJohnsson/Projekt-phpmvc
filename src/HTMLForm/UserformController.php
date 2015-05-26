<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class UserformController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
     * Index action using external form.
     *
     */
    public function indexAction()
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormUser();
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Sign up");
        $this->di->views->add('projekt/signup', [
            'title' => "Sign up",
            'content' => $form->getHTML()
        ]);
    }

    /**
     * Index action using external form.
     *
     */
    public function loginAction()
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormUserLogin();
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Sign in");
        $this->di->views->add('projekt/signin', [
            'title' => "Sign in",
            'content' => $form->getHTML()
        ]);
    }
}
