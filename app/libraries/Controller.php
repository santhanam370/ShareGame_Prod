<?php 

class Controller{

    public function loadModel($model){
        if(file_exists('../app/models/'.$model.'.php')){
            require_once '../app/models/'.$model.'.php';
            return new $model;
        }
    }

    public function loadView($view,$data=[]){
        if(file_exists('../app/views/'.$view.'.php')){
            require_once '../app/views/'.$view.'.php';
        }
    }
}