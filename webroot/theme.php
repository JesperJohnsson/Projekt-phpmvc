<?php
/**
 * This is a Anax pagecontroller / frontcontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php';


$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->theme->setVariable('title', "Me-sida!");

$di->setShared('log', function() {
    $log = new jejd14\clog\CLog();
    return $log;
});

$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Tema");
    $app->theme->addStylesheet('css/anax-grid/theme_demo.css');
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    $sidebar = $app->fileContent->get('sidebar.md');
    $sidebar = $app->textFilter->doFilter($sidebar, 'shortcode, markdown');

    $app->views->addString('Här står det något flashigt!', 'flash')
               ->addString($content, 'main')
               ->addString($sidebar, 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');

});

$app->router->add('regions', function() use ($app) {
    $app->theme->setTitle("Regioner");

    $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');

});

$app->router->add('grid', function() use ($app) {
    $app->theme->setTitle("Rutnät");

    $app->theme->addStylesheet('css/anax-grid/grid_pattern.css');
    $content = $app->fileContent->get('theme.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->addString( $content, 'main');
});

$app->router->add('typography', function() use ($app) {
    $app->theme->setTitle("Rutnät");
    $app->theme->addStylesheet('css/anax-grid/grid_pattern.css');
    $content = $app->fileContent->get('typography.html');

    $app->views->addString( $content, 'main')
               ->addString( $content, 'sidebar');
});

$app->router->add('fontawesome', function() use ($app) {
    $app->theme->setTitle("Font Awesome");

    $app->views->addString('<i class="fa fa-arrow-circle-o-right"></i>', 'featured-2')
               ->addString('<i class="fa fa-arrow-circle-o-right"></i>', 'featured-3')
               ->addString('<i class="fa fa-child fa-5x"></i>', 'main')
               ->addString('<p><i class="fa fa-coffee fa-lg"></i> fa-coffee</p>
<p><i class="fa fa-home fa-2x"></i> fa-home</p>
<p><i class="fa fa-key fa-3x"></i> fa-key</p>
<p><i class="fa fa-rocket fa-4x"></i> fa-rocket</p>
<p><i class="fa fa-camera-retro fa-5x"></i> fa-camera-retro</p>', 'sidebar');


});

$app->router->handle();
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');

// Render the response using theme engine.
$app->theme->render();
