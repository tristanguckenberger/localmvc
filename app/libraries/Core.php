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
        //print_r($this->getUrl());
        $url = $this->getUrl();

        // Look in Controllers for first value
//        foreach($url as $index){
//           //echo $index.' ';
//           //${$index} = $index;
//
//            if($index == ){
//
//            }
//
//        }
        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/'.$this->currentController.'.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of URL
        if(isset($url[1])){
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];


                unset($url[1]);
            }
        }

        // Get params
        /*
         * If url has parameters, in our case, pages/about/something
         * $url ?
         * Add those parameters to the params array
         * $this->params = array_values($url);
         * Otherwise $this->params = [];
         */
        $this->params = $url ? array_values($url) :[];

        // Call function, call_user_func_array
        /*
         * Call a callback with array of params
         *
         * So basically if the method exists in the current controller,
         * what's inside it will be executed.
         */
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    // Get url add to array
    public function getUrl(){
        $items = $_GET['url'];

        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}

// Need to instantiate for this to run see ../public/index.php
// This works because we've required this file in boostrap and required bootstrap in index

