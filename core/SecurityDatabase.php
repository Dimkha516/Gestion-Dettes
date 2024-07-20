<?php

namespace Core;

use PDO;
use PDOException;

class SecurityDatabase{
    private $database;

    public function __construct(){
        $this->database = App::getInstance()->getDatabase();
    }

    public function login($username, $password){
        return Validator::validate($username, $password);
    }

    public function isLogged(){
        return isset($_SESSION['user']);
    }

    public function getUserLogged(){
        return $_SESSION['user'] ?? null;
    }

    public function query($sql, $params = []) {
        $stmt = $this->database->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    

    // public function lastInsertId() {
    //     return $this->database->lastInsertId();
    // }

    
}