<?php

class Pages extends Controller{

    public function __construct(){}

    public function index(){
        $data=['title'=>'Share Games'];
        $this->loadView('pages/index',$data);
    }

    public function about(){
        $data=['title'=>'About Us'];
        $this->loadView('pages/aboutus',$data);
    }
}