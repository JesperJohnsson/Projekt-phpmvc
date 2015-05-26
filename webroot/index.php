<?php
/**
 * This is a Anax pagecontroller / frontcontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php';

//

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

// Set the title of the page
$app->theme->setVariable('title', "Me-sida!");
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->session();

// Set database connection
$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->setShared('user', function () use ($di) {
    $user = new \Anax\Users\User();
    $user->setDI($di);
    return $user;
});

$di->setShared('log', function () {
    $log = new jejd14\clog\CLog();
    return $log;
});

$di->setShared('flashMessage', function () use ($di) {
    $flashMessage = new \Anax\Flash\CFlash();
    $flashMessage->setDI($di);
    return $flashMessage;
});

// Set comment controller
$di->set('CommentController', function () use ($di) {
    $controller = new Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentformController', function () use ($di) {
     $controller = new \Anax\HTMLForm\CommentformController();
     $controller->setDI($di);
     return $controller;
});

$di->set('UsersController', function () use ($di) {
     $controller = new \Anax\Users\UsersController();
     $controller->setDI($di);
     return $controller;
});

$di->set('UserformController', function () use ($di) {
     $controller = new \Anax\HTMLForm\UserformController();
     $controller->setDI($di);
     return $controller;
});

$di->set('QuestionsController', function () use ($di) {
     $controller = new \Anax\Questions\QuestionsController();
     $controller->setDI($di);
     return $controller;
});

$di->set('QuestionformController', function () use ($di) {
     $controller = new \Anax\HTMLForm\QuestionformController();
     $controller->setDI($di);
     return $controller;
});

$di->set('TagsController', function () use ($di) {
     $controller = new \Anax\Tags\TagsController();
     $controller->setDI($di);
     return $controller;
});

$di->set('Q2tController', function () use ($di) {
     $controller = new \Anax\Tags\Q2tController();
     $controller->setDI($di);
     return $controller;
});

$di->set('ActivitiesController', function () use ($di) {
     $controller = new \Anax\Activity\ActivitiesController();
     $controller->setDI($di);
     return $controller;
});

$di->set('VoteController', function () use ($di) {
     $controller = new \Anax\Vote\VoteController();
     $controller->setDI($di);
     return $controller;
});



$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Home");

    $app->dispatcher->forward([
       'controller' => 'tags',
       'action'     => 'frontpage',
    ]);

    $app->dispatcher->forward([
       'controller' => 'questions',
       'action'     => 'frontpage',
    ]);

    $app->dispatcher->forward([
       'controller' => 'users',
       'action'     => 'frontpage',
    ]);

    $app->dispatcher->forward([
       'controller' => 'activities',
       'action'     => 'frontpage',
    ]);

    //$app->views->addString($footercol1, 'footer-col-1');
});

$app->router->add('questions', function () use ($app) {
    $app->theme->setTitle("Questions");
    $order = $app->request->getGet('order');
    if (!isset($order)) {
        $order = 'created';
    }
    $app->dispatcher->forward([
       'controller' => 'questions',
       'action'     => 'list',
       'params'     => [$order]
    ]);
});

$app->router->add('tags', function () use ($app) {
    $app->theme->setTitle("Tags");

    $app->dispatcher->forward([
        'controller' => 'tags',
        'action'     => 'list',
    ]);
});

$app->router->add('users', function () use ($app) {
    $app->theme->setTitle("Users");

    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'list',
    ]);
});

$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("About");

    $about = $app->fileContent->get('about.md');
    $about = $app->textFilter->doFilter($about, 'shortcode, markdown');


    $app->views->add('me/page', [
        'content' => $about,
    ]);
});


$app->router->add('questions/ask', function () use ($app) {
    $app->theme->setTitle("Ask Question");

    $content = $app->fileContent->get('questionhelp.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    if (!$app->user->isAuthenticated()) {
        $signin = $app->url->create('signin');
        $signup = $app->url->create('signup');
        $app->flashMessage->error("You need to be <a href={$signin}>Signed in</a> to ask a question! Don't got a account yet? <a href={$signup}>Sign up</a> here!");
        $app->views->addString($app->flashMessage->get(), 'flash');
        $app->flashMessage->clear();
    } else {

    }

    $app->views->addString($content, 'main');

    $app->dispatcher->forward([
      'controller' => 'questions',
      'action'     => 'addQuestion',
    ]);
});

$app->router->add('signin', function () use ($app) {
    $app->theme->setTitle("Sign in");
    $app->dispatcher->forward([
       'controller' => 'users',
       'action'     => 'login',
    ]);
});

$app->router->add('signup', function () use ($app) {
    $app->theme->setTitle("Sign in");

    $app->dispatcher->forward([
       'controller' => 'users',
       'action'     => 'add',
    ]);
});



$app->router->handle();
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Render the response using theme engine.
$app->theme->render();
