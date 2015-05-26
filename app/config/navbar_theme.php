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
        'theme'  => [
            'text'  => 'Tema',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Tema'
        ],

        // This is a menu item
        'regions'  => [
            'text'  => 'Regioner',
            'url'   => $this->di->get('url')->create('regions'),
            'title' => 'Regioner'
        ],

        // This is a menu item
        'grid'  => [
            'text'  => 'Rutnät',
            'url'   => $this->di->get('url')->create('grid'),
            'title' => 'Rutnät'
        ],

        //This is a menu item
        'typography' => [
            'text'  => 'Typografi',
            'url'   => $this->di->get('url')->create('typography'),
            'title' => 'Typografi'
        ],

        //This is a menu item
        'fontawesome' => [
            'text'  => 'Font Awesome',
            'url'   => $this->di->get('url')->create('fontawesome'),
            'title' => 'Font Awesome'
        ],

        //This is a menu item
        'me' => [
            'text'  => 'Tillbaka',
            'url'   => $this->di->get('url')->create('../'),
            'title' => 'Tillbaka'
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
