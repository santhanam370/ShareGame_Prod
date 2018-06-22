<?php

class UserQuestionMap extends Database{

    private $playerId;
    private $questionId;
    private $selectedOption;
    private $user;
    private $question;

    public static $REF_TABLE_NAME = 'playerquestionmap';

    public function setPlayerId($playerId){
        $this->playerId = $playerId;
    }
    public function getPlayerId(){
        return $this->playerId;
    }

    public function setQuestionId($questionId){
        $this->questionId = $questionId;
    }
    public function getQuestionId(){
        return $this->questionId;
    }

    public function setSelectedOption($selectedOption){
        $this->selectedOption = $selectedOption;
    }
    public function getSelectedOption(){
        return $this->selectedOption;
    }

    public function setUser($user){
        $this->user = $user;
    }
    public function getUser(){
        return $this->user;
    }

    public function setQuestion($question){
        $this->question = $question;
    }
    public function getQuestion(){
        return $this->question;
    }

    public function createPlayerQuestionMap(){
        $sql = 'insert into '.self::$REF_TABLE_NAME.' (playerid, questionid, selectedOption) values (:playerId, :questionId, :selectedOption)';
        $this->prepare($sql);
        $this->bind(':playerId',$this->playerId);
        $this->bind(':questionId',$this->questionId);
        $this->bind(':selectedOption',$this->selectedOption);
        $this->execute();
    }

    public function getAllQuestionsForUser(){
        $user = $this->fetchUser($this->playerId);
        $sql = 'select playerid, questionid, selectedoption from '.self::$REF_TABLE_NAME.' where playerid = :playerId';
        $this->prepare($sql);
        $this->bind(':playerId',$this->playerId);
        $results = $this->retrieveRay();
        if(empty($result)){
            return null;
        }
        $userQstnMapArr = array();
        foreach($results as $result){
            $userQstMap = new UserQuestionMap;
            $userQstMap->setPlayerId($result->playerid);
            $userQstMap->setQuestionId($result->questionid);
            $userQstMap->setSelectedOption($result->selectedoption);
            $userQstMap->setUser($user);
            $question = $this->fetchQuestion($result->questionid);
            $userQstMap->setQuestion($question);
            array_push($userQstnMapArr,$userQstMap);
        }

        return $userQstnMapArr;
    }

    public function getTotalScoreForUser(){
        $sql = 'select playerid, questionid, selectedoption from '.self::$REF_TABLE_NAME.' where playerid = :playerId';
        $this->prepare($sql);
        $this->bind(':playerId',$this->playerId);
        return $this->rowCount();
    }

    public function getNextQuestionForUser($questionnumber=0, $category=CATEGORY){
        $user = $this->fetchUser($this->playerId);

        $sql = 'select qpm.playerid playerid, qpm.questionid questionid, qpm.selectedoption selectedoption, q.Question Question, q.Options Options, q.category category, q.questionnumber questionnumber from '.self::$REF_TABLE_NAME.' qpm, '.Question::$REF_TABLE_NAME.' q where qpm.playerid = :playerid and q.questionnumber = :questionnumber and q.category = :category and qpm.questionid=q.id';
        $this->prepare($sql);
        $this->bind(':playerid',$this->playerId);
        $this->bind(':questionnumber',$questionnumber+1);
        $this->bind(':category',$category);
        $result = $this->retrievePoint();
        if(empty($result)){
            return null;
        }
        
        $question = new Question;
        $question->setId($result->questionid);
        $question->setQuestion($result->Question);
        $question->setOptions($result->Options);
        $question->setCategory($result->category);
        $question->setQuestionNumber($result->questionnumber);

        $nxtUserQstMap = new UserQuestionMap;
        $nxtUserQstMap->setPlayerId($result->playerid);
        $nxtUserQstMap->setQuestionId($result->questionid);
        $nxtUserQstMap->setSelectedOption($result->selectedoption);
        $nxtUserQstMap->setUser($user);
        $nxtUserQstMap->setQuestion($question);   
        return $nxtUserQstMap;     
    }

    private function fetchUser($userId){
        $user = new User;
        $user->setId($userId);
        return  $user->getUserById();
    }

    private function fetchQuestion($questionId){
        $question = new Question;
        $question->setQuestionId($questionId);
        return $question->getQuestionById();
    }
}