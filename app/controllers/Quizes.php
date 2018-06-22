<?php

class Quizes extends Controller{
    
    public function __construct(){
        $this->quizModel = $this->loadModel('Question');
        $this->usrQstnMapModel = $this->loadModel('UserQuestionMap');
        $this->usr = $this->loadModel('User');
    }

    public function questions(){
        $nxtQstn=null;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $this->populateAnsweredQuestionFromRequest();
            $this->quizModel->setCategory(CATEGORY);
            $this->quizModel->setQuestionNumber($_POST['questionnumber']);
            $nxtQstn = $this->quizModel->retrieveNextQuestion();
        }else{
            $this->quizModel->setCategory(CATEGORY);
            $this->quizModel->setQuestionNumber(0);
            $nxtQstn = $this->quizModel->retrieveNextQuestion();
        }
        if($nxtQstn != null){
            $options = explode('^',$nxtQstn->getOptions());
            $data=[
                'title'=>'Question '.$nxtQstn->getQuestionNumber(),
                'context'=>'answer',
                'questionnumber'=>$nxtQstn->getQuestionNumber(),
                'id'=>$nxtQstn->getId(),
                'question'=>$nxtQstn->getQuestion(),
                'options'=>$options
            ];
            $this->loadView('quiz/questions',$data);
        }else{
            $url=$this->generateURL();
            $data=[
                'title' => 'Thank You for taking the QUIZ in Share Games.',
                'urlref'=>$url
            ];
            $this->loadView('quiz/sharequiz',$data);
        }
    }

    public function answeredQuestions($sessionId=null,$name=null){
        $usrQstnMapModel = null;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->updateScore();
            $usrQstnMapModel = $this->loadModel('UserQuestionMap');
            $usrQstnMapModel->setPlayerId($_SESSION[USERID]);
            $usrQstnMapModel = $usrQstnMapModel->getNextQuestionForUser($_POST['questionnumber'],CATEGORY);
        }else{
            if(isset($_SESSION[QUIZFINSHED])){
                $this->showScoreCardPage();
            }else{
                $user = $this->loadModel('User');
                $user->setSessionId($sessionId);
                $user->setName($name);
                $user = $user->getUserByNameAndSessionId();
                $_SESSION[USERNAME]=$user->getName();
                $_SESSION[USERID]=$user->getId();
                $_SESSION[USERFRNDSCORE]=0;
                $usrQstnMapModel = $this->loadModel('UserQuestionMap');
                $usrQstnMapModel->setPlayerId($user->getId());
                $usrQstnMapModel = $usrQstnMapModel->getNextQuestionForUser(0,CATEGORY);
                $_SESSION[TOTALSCORE]=$usrQstnMapModel->getTotalScoreForUser();
            }
        }

        if($usrQstnMapModel != null){
            $options = explode('^',$usrQstnMapModel->getQuestion()->getOptions());
            $data=[
                'title'=>'Question '.$usrQstnMapModel->getQuestion()->getQuestionNumber(),
                'context'=>'verifyanswer',
                'questionnumber'=>$usrQstnMapModel->getQuestion()->getQuestionNumber(),
                'id'=>$usrQstnMapModel->getQuestion()->getId(),
                'question'=>$usrQstnMapModel->getQuestion()->getQuestion(),
                'options'=>$options,
                'score'=>$_SESSION[USERFRNDSCORE],
                'correctOption'=>$usrQstnMapModel->getSelectedOption(),
                'totalScore'=>$_SESSION[TOTALSCORE]
            ];
            $this->loadView('quiz/questions',$data);
        }else{
            $this->showScoreCardPage();
        }
    }

    private function populateAnsweredQuestionFromRequest(){
        $this->usrQstnMapModel->setPlayerId($_SESSION[USERID]);
        $this->usrQstnMapModel->setQuestionId($_POST['id']);
        $this->usrQstnMapModel->setSelectedOption($_POST['selectedOption']);
        $this->usrQstnMapModel->createPlayerQuestionMap();
    }

    private function updateScore(){
        if($_POST['selectedOption']==$_POST['correctOption']){
            $_SESSION[USERFRNDSCORE]++;
        }
    }

    private function generateURL(){
        $user = $this->usr;
        $user->setId($_SESSION[USERID]);
        $user=$user->getUserByid();
        return BASEURL.'/Quizes/answeredQuestions/'.$user->getSessionId().'/'.$user->getName();
    }

    private function showScoreCardPage(){
        $data=[
            'title'=>'Thank You for taking the QUIZ in Share Games.',
            'scoreinfo'=>'You have scored '.$_SESSION[USERFRNDSCORE].' out of '.$_SESSION[TOTALSCORE]
        ];
        $_SESSION[QUIZFINSHED]=true;
        $this->loadView('quiz/scorecard',$data);
    }
}		