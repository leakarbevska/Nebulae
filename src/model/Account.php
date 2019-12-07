<?php

class Account{
    private $name;
    private $login;
    private $password;
    private $status;

    function __construct($name, $login, $password, $status){
        $this->name  = $name;
        $this->login =  $login;
        $this->password =  $password;
        $this->status = $status;
    }

    function getName(){
        return $this->name;
    }

    function getLogin(){
        return $this->login;
    }

    function getPassword(){
        return $this->password;
    }

    function getStatus(){
        return $this->status;
    }
}