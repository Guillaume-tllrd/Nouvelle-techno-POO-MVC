<?php
// je met le namespace en premier pour ne pas avoir de pb avec le model:
namespace App\Models;

class UsersModel extends Model{
    protected $id;
    protected $email;
    protected $password;

    public function __construct(){
        $this->table = 'users';
    }

// faire les getter settrer (accesseur):
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }
}