<?php

class AuthenticationManager{
  private $comptes;

  function __construct($comptes){
    $this->comptes = $comptes;
  }

  function connectUser($login, $password){
    $key = array_search($login, array_column($this->comptes,'login'));
    $account = $this->comptes[$key];
    if(password_verify($password, $account['password'])){
      return true;
    }
    return false;
  }

  function isUserConnected(){
    if(!empty($_SESSION['user'])){
      return true;
    }
    return false;
  }


  function isAdminConnected(){
    $key = array_search($_SESSION['login'], array_column($this->comptes,'login'));
    if('admin' === $this->comptes[$key]['status']){
      return true;
    }
    return false;
  }

  function getUserName(){
    if(!empty($_SESSION['user'])){
      $key = array_search($_SESSION['user']['login'], array_column($this->comptes,'login'));
      return $this->comptes[$key]['name'];
    }else{
      throw new Exception('User is not logged in');
    }
  }

  function disconnectUser(){
    session_unset();
  }
}