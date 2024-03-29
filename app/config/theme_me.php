<?php
/**
 * Config-file for Anax, theme related settings, return it all as array.
 *
 */
return [

    /**
     * Settings for Which theme to use, theme directory is found by path and name.
     *
     * path: where is the base path to the theme directory, end with a slash.
     * name: name of the theme is mapped to a directory right below the path.
     */
    'settings' => [
        'path' => ANAX_INSTALL_PATH . 'theme/',
        'name' => 'anax-grid', //anax-base
    ],


    /**
     * Add default views.
     */
    'views' => [

        //View for header
        [
            'region'   => 'header',
            'template' => 'me/header',
            'data'     => [
                'siteTitle'   => "Min me-sida i PHPMVC",
                'siteTagline' => "Här är en tagline som säger något vackert",
            ],
            'sort'     => -1
        ],

        //View for footer
        ['region' => 'footer', 'template' => 'me/footer', 'data' => [], 'sort' => -1],

        //View for footer-col-1
        [
            'region' => 'footer-col-1',
            'template' => 'me/footer-col',
            'data' => [
                'file' => 'footer-col-1.md'
            ],
            'sort' => -1
        ],

        //View for footer-col-2
        [
            'region' => 'footer-col-2',
            'template' => 'me/footer-col',
            'data' => [
                'file' => 'footer-col-2.md'
            ],
            'sort' => -1
        ],

        //View for footer-col-3
        [
            'region' => 'footer-col-3',
            'template' => 'me/footer-col',
            'data' => [
                'file' => 'footer-col-3.md'
            ],
            'sort' => -1
        ],



        //View for navbar
        [
            'region' => 'navbar',
            'template' => [
                'callback' => function() {
                    return $this->di->navbar->create();
                },
            ],
            'data' => [],
            'sort' => -1
        ],
    ],


    /**
     * Data to extract and send as variables to the main template file.
     */
    'data' => [

        // Language for this page.
        'lang' => 'sv',

        // Append this value to each <title>
        'title_append' => ' | Anax a web template',

        // Stylesheets
        'stylesheets' => ['css/anax-grid/style.php'],

        // Inline style
        'style' => null,

        // Favicon
        'favicon' => 'favicon.ico',

        // Path to modernizr or null to disable
        'modernizr' => 'js/modernizr.js',

        // Path to jquery or null to disable
        'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',

        // Array with javscript-files to include
        'javascript_include' => ['js/script.js', 'js/jquery.timeago.js'],

        // Use google analytics for tracking, set key or null to disable
        'google_analytics' => null,
    ],
];
