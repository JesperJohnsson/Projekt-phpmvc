<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormQuestion extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        //\Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
            'title' => [
                'type'      => 'text',
                'label'     => 'Title',
                'required'  => true,
                'validation' => ['not_empty'],
                'placeholder'=> htmlspecialchars("What's your gaming question? Be specific.", ENT_QUOTES),
            ],
            'tag' => [
                'type'      => 'text',
                'label'     => 'Tags',
                'validation' => ['not_empty'],
                'placeholder'=> "GTAV, Action",
            ],
            'content' => [
                'type'      => 'textarea',
                'label'     => 'Description',
                'required'  => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Ask Question',
                'callback'  => [$this, 'callbackSubmit'],
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
            'controller' => 'questions',
            'action'     => 'addQuestion',
            'params'     => [true, ['acronym' => $this->di->user->getUserAcronym(), 'title' => $this->Value('title'), 'content' => $this->Value('content'), 'tag' => $this->Value('tag')]]
        ]);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        //$this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        //$this->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        $this->redirectTo();
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        //$this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
