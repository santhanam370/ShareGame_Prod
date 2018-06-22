<?php

class Question extends Database{
    private $id;
    private $question;
    private $options;
    private $category;
    private $questionNumber;

    public static $REF_TABLE_NAME = 'questionbank';

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }

    
    public function setQuestion($question){
        $this->question=$question;
    }
    public function getQuestion(){
        return $this->question;
    }
    
    public function setOptions($options){
        $this->options=$options;
    }
    public function getOptions(){
        return $this->options;
    }
    
    public function setCategory($category){
        $this->category=$category;
    }
    public function getCategory(){
        return $this->category;
    }
    
    public function setQuestionNumber($questionNumber){
        $this->questionNumber=$questionNumber;
    }
    public function getQuestionNumber(){
        return $this->questionNumber;
    }
    
    public function retrieveNextQuestion(){
        $sql = 'select ID, Question, Options, category, questionnumber from '.self::$REF_TABLE_NAME.' where category=:category and questionNumber=:questionNumber';
        $this->prepare($sql);
        $this->bind(':category',$this->category);
        $this->bind(':questionNumber',$this->questionNumber+1);
        $result = $this->retrievePoint();
        if(empty($result)){
           return null;
        }
        $nextQuestion = new Question;
        $nextQuestion->setId($result->ID);
        $nextQuestion->setQuestion($result->Question);
        $nextQuestion->setOptions($result->Options);
        $nextQuestion->setCategory($result->category);
        $nextQuestion->setQuestionNumber($result->questionnumber);
        return $nextQuestion;
    }

    public function getQuestionByid(){
        $sql = 'select ID, Question, Options, category, questionnumber from '.self::$REF_TABLE_NAME.' where ID = :id';
        $this->prepare($sql);
        $this->bind(':id',$this->id);
        $result = $this->retrievePoint();
        if(empty($result)){
           return null;
        }
        $question = new Question;
        $question->setId($result->ID);
        $question->setQuestion($result->Question);
        $question->setOptions($result->Options);
        $question->setCategory($result->category);
        $question->setQuestionNumber($result->questionnumber);
        return $question;
    }
}