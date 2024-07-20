<?php

namespace App\Models;

use Core\Model;

class UserModel extends Model{
    protected $table = 'users';

    public function findByUsername($username){
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        return $this->query($sql, [$username]);
    }
}