<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $this->getUrl();
    }

    // Get url add to array
    public function getUrl(){
        echo $_GET['url'];
    }
}

// Need to instantiate for this to run see ../public/index.php
// This works because we've required this file in boostrap and required bootstrap in index

