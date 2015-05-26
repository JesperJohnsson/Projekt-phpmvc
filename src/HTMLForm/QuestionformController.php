<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class QuestionformController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Index action using external form.
     *
     */
    public function indexAction()
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormQuestion();
        $form->setDI($this->di);
        $form->check();

        $this->di->views->add('me/html', [
            'content' => $form->getHTML()
        ]); //'comment-form');
    }



    /**
     * Answer action using external form.
     *
     */
    public function answerAction($id)
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormAnswer($id);
        $form->setDI($this->di);
        $form->check();

        $this->di->views->add('me/html', [
            'content' => $form->getHTML()
        ], 'comment-form');
    }
}
