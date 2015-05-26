<?php

namespace Anax\MVC;

/**
 * A controller base class
 *
 */
class CControllerBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;

} 
