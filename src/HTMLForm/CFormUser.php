<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormUser extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
            'acronym' => [
                'type' => 'text',
                'label' => 'Acronym',
                'required' => true,
                'validation' => [
                    'not_empty',
                    'custom_test' => [
                        'message' => 'The acronym is already in use',
                        'test' => [$this, 'duplicateAcronym'],
                        ]
                    ],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Name',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'label'       => 'Email',
                'required'    => true,
                'validation'  => [
                    'not_empty',
                    'email_adress',
                    'custom_test' => [
                        'message' => 'The email is already in use',
                        'test' => [$this, 'duplicateEmail'],
                        ]
                    ],
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Password',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'accept_agreement' => [
              'type'        => 'checkbox',
              'label'       => 'You must accept the <a href=http://opensource.org/licenses/GPL-3.0>license agreement</a>.',
              'required'    => true,
              'validation'  => ['must_accept'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Sign up',
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
            'controller' => 'users',
            'action'     => 'add',
            'params' => [true, $this->Value('acronym'),$this->Value('email'),$this->Value('name'),$this->Value('password')],
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



    /**
     * Checks if there is a user with the given acronym
     *
     * @return boolean, depending if there is a user with the same acronym
     */
    public function duplicateAcronym($value)
    {
        if ($value != "") {
            $item = $this->di->user->findByAcronym($value);
            if ($item) {
                return false;
            }
            return true;
        }
    }



    /**
     * Checks if there is a user with the given acronym
     *
     * @return boolean, depending if there is a user with the same acronym
     */
    public function duplicateEmail($value)
    {
        if ($value != "") {
            $item = $this->di->user->findByEmail($value, $this->di->user->getUserId());
            if ($item) {
                return false;
            }
            return true;
        }
    }


}
