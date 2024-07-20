<?php

namespace Core;

abstract class Model{
    protected $table;
    protected $database;

    public function __construct(){
        $this->database = App::getInstance()->getDatabase();
    }

    public function query($sql, $params = []){
        $stmt = $this->database->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}