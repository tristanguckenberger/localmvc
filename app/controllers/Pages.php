<?php

class Pages extends Controller {

    public function __construct()
    {

    }

    public function index() {
        $data = [
            'title' => 'Welcome'
        ];
        $this->view('pages/index', $data);
    }

    public function about(){
//        echo 'This is about';
        $this->view('pages/about');
    }
}