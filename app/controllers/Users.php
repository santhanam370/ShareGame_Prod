<?php

class Users extends Controller{
    
    public function __construct(){
        $this->userModel = $this->loadModel('User');
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'title' => 'Create and share your quiz',
                'name'=>trim($_POST['name']),
                'nameerror'=>''
            ];
            if(empty($data['name'])){
                $data['nameerror']='Please enter your name.';
            }elseif(strlen($data['name'])<3){
                $data['nameerror']='Name is too short. Should be atleast three characters.';
            }elseif(strlen($data['name'])>50){
                $data['nameerror']='Name is too long. Should be less than 50 characters.';
            }
            elseif(!preg_match('/^[a-zA-Z]([a-zA-Z0-9_])+/',$data['name'])){
                $data['nameerror']='Name invalid. Please enter valid name.';
            }
            if(!empty($data['nameerror'])){
                $this->loadView('users/register',$data);
            }else{
                $this->userModel->setName($data['name']);
                $this->userModel->setSessionId(session_id());
                $_SESSION[USERNAME]=$data['name'];
                try{
                    $user = $this->userModel->createUser();
                    $_SESSION[USERID] = $user->getId();
                    header('Location: '.BASEURL.'/Quizes/questions');
                    exit();
                }catch(Exception $e){
                    $data['nameerror'] = $e->getMessage();
                    $this->loadView('users/register',$data);
                }
            }
        }else{
            $data=[
                'title' => 'Create and share your quiz',
                'name'=>'',
                'nameerror'=>''
            ];
            $this->loadView('users/register',$data);
        }
    }

}