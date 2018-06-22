<?php

class User extends Database{
    private $id;
    private $name;
    private $sessionId;
    
    public static $REF_TABLE_NAME = 'player';

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }

    public function setSessionId($sessionId){
        $this->sessionId=$sessionId;
    }
    public function getSessionId(){
        return $this->sessionId;
    }

    public function createUser(){
        $sql = 'insert into '.self::$REF_TABLE_NAME.' (player,sessionid) values (:player,:sessionId)';
        $this->prepare($sql);
        $this->bind(':player',$this->name);
        $this->bind(':sessionId',$this->sessionId);
        $this->execute();

        return $this->getUserByNameAndSessionId();
    }

    public function getUserByNameAndSessionId(){
        $sql = 'select id, player, sessionid from '.self::$REF_TABLE_NAME.' where player = :player and sessionid = :sessionId';
        $this->prepare($sql);
        $this->bind(':player',$this->name);
        $this->bind(':sessionId',$this->sessionId);
        $result = $this->retrievePoint();
        if(empty($result)){
           return null;
        }
        $user = new User;
        $user->setId($result->id);
        $user->setName($result->player);
        $user->setSessionId($result->sessionid);
        return $user;
    }

    public function getUserByid(){
        $sql = 'select id, player, sessionid from '.self::$REF_TABLE_NAME.' where id = :id';
        $this->prepare($sql);
        $this->bind(':id',$this->id);
        $result = $this->retrievePoint();
        if(empty($result)){
           return null;
        }
        $user = new User;
        $user->setId($result->id);
        $user->setName($result->player);
        $user->setSessionId($result->sessionid);
        return $user;
    }
}