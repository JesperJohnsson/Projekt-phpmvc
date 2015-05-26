<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormComment extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    /**
     * Constructor
     *
     */
    public function __construct($id = null, $answerId = null)
    {
        parent::__construct([], [
            'content' => [
                'type'      => 'textarea',
                'required'  => true,
                'label'     => "",
                'validation' => ['not_empty'],
                'id'         => "content" . $answerId,
            ],
            'question_id' => [
                'type'      => 'hidden',
                'value'     => $answerId,
                'id'        => "question_id" . $answerId,
            ],
            'thread_id' => [
                'type'      => 'hidden',
                'value'     => $id,
                'id'        => "thread_id" . $id,
            ],
            'comment' . $answerId => [
                'type'      => 'submit',
                'value'     => 'Comment',
                'callback'  => [$this, 'callbackSubmit'],
                'id'        => "submit" . $answerId,
            ],
        ]);


    }



    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $this->di->dispatcher->forward([
            'controller' => 'comment',
            'action'     => 'add',
            'params' => [['id' => $this->Value('question_id'), 'question_id' => $this->Value('thread_id'), 'content' => $this->Value('content')]],
        ]);
    }


    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        $this->redirectTo();
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
