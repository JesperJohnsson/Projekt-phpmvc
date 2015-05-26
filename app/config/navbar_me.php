<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',

    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home'
        ],

        // This is a menu item
        'questions'  => [
            'text'  => 'Questions',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'See Questions!'
        ],

        // This is a menu item
        'tags'  => [
            'text'  => 'Tags',
            'url'   => $this->di->get('url')->create('tags'),
            'title' => 'See Tags!'
        ],

        'users' => [
            'text'  => 'Users',
            'url'   => $this->di->get('url')->create('users'),
            'title' =>  'Användare',
            /*'submenu' => [
                'items' => [
                    'item 1'  => [
                        'text'  => 'Alla',
                        'url'   => $this->di->get('url')->create('users/list'),
                        'title' => 'Alla användare'
                    ],

                    'item 2'  => [
                        'text'  => 'Aktiva',
                        'url'   => $this->di->get('url')->create('users/active'),
                        'title' => 'Aktiva användare'
                    ],

                    'item 3'  => [
                        'text'  => 'Inaktiva',
                        'url'   => $this->di->get('url')->create('users/inactive'),
                        'title' => 'Inaktiva användare'
                    ],

                    'item 4'  => [
                        'text'  => 'Papperskorg',
                        'url'   => $this->di->get('url')->create('users/trashcan'),
                        'title' => 'Papperskorg'
                    ],

                    'item 5'  => [
                        'text'  => 'Skapa',
                        'url'   => $this->di->get('url')->create('users/add'),
                        'title' => 'Skapa användare'
                    ],

                    'item 6'  => [
                        'text'  => 'Logga in',
                        'url'   => $this->di->get('url')->create('users/login'),
                        'title' => 'Skapa användare'
                    ],


                    'item 7'  => [
                        'text'  => 'Återställ DB',
                        'url'   => $this->di->get('url')->create('users/setup'),
                        'title' => 'Återställ databas'
                    ]
                ]
            ]*/
        ],
        'about'  => [
            'text'  => 'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'About'
        ],

        // This is a menu item
        'askquestion'  => [
            'text'  => 'Ask Question',
            'url'   => $this->di->get('url')->create('questions/ask'),
            'title' => 'Ask Question',
            'class' => 'askquestiontab'
        ],
    ],



    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
