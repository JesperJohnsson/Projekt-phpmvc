<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CommentformController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Index action using external form.
     *
     */
    public function indexAction($id = null, $answerId = null)
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormComment($id, $answerId);
        $form->setDI($this->di);
        $form->check();

        $this->di->views->add('me/html', [
            'content' => $form->getHTML()
        ], 'C' . $answerId);
    }
}
