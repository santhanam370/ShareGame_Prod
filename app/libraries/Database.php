<?php 

class Database{
    protected $pdo;
    protected $error;
    protected $stmt;
    public function __construct(){
        $user = DB_USER;
        $pass = DB_PASS;
        $dns = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->pdo = new PDO($dns,$user,$pass,$options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    public function prepare($sql){
        $this->stmt = $this->pdo->prepare($sql);
    }

    public function bind($param,$value,$type=null){
        if(is_null($type)){
            switch(true){
                case is_int($value) : $type=PDO::PARAM_INT;
                                     break;
                case is_bool($value) : $type=PDO::PARAM_BOOL;
                                     break;
                case is_null($value) : $type=PDO::PARAM_NULL;
                                     break;                                     
                default : $type=PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }
    
    public function retrieveRay(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function retrievePoint(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount(){
        $this->retrieveRay();
        return $this->stmt->rowCount();
    }
}