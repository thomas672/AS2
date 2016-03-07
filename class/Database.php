<?php

class Database{

    //Proprieté d'initialisation de l'objet PDO
    private $pdo;
    //Fonction __construct permetant d'initialisé l'objet PDO avec nos info serveur MySQL
    public function __construct($user, $password, $database_name, $host = '127.0.0.1'){
        $this->pdo = new PDO("mysql:dbname=$database_name;host=$host", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }
    //Fonction permetant de faire une requete SQL rapidement
    public function query($query, $params = false){
        if($params) {
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        }
        else{
            $req = $this->pdo->query($query);
        }
        return $req;
    }

    public function delete($query){
        $req = $this->pdo->prepare($query);
        $req->execute();
        return true;
    }

    public function insert($query){
        $req = $this->pdo->prepare($query);
        $req->execute();
        return true;
    }
}