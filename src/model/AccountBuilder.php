<?php

class AccountBuilder{
  private $data;
  private $error;

  const NAME_REF     = 'name';
  const LOGIN_REF    = 'login';
  const PASSWORD_REF = 'password';
  const STATUS_REF   = 'status';

  

  function __construct($data=null){
    if($data === null){
      $this->data = array(self::NAME_REF => "", self::LOGIN_REF => "", self::PASSWORD_REF => "", self::STATUS_REF => "");
    }
    $this->data = $data;
    $this->error = null;
  }

  static function createFromAccount(Account $account){
    return new AccountBuilder(array(self::NAME_REF => $account->getName(), self::LOGIN_REF => $account->getLogin(), self::PASSWORD_REF => $account->getPassword(), self::STATUS_REF => $account->getStatus()));
  }

  function getData(){
    return $this->data;
  }

  function getError(){
    return $this->error;
  }

  function createAccount(){
    return new Account($this->data[self::NAME_REF], $this->data[self::LOGIN_REF], password_hash($this->data[self::PASSWORD_REF], PASSWORD_BCRYPT), $this->data[self::STATUS_REF]);
  }

  function isValid(){
    if(!key_exists(self::NAME_REF, $this->data) or strlen($this->data[self::NAME_REF])==0){
        $this->error .= "Error: Le nom est vide! <br>";
    }if(!key_exists(self::LOGIN_REF, $this->data) or strlen($this->data[self::LOGIN_REF])==0){
        $this->error .= "Error: Le login est vide! <br>";
    }if(!key_exists(self::PASSWORD_REF, $this->data) or strlen($this->data[self::PASSWORD_REF])==0){
        $this->error .= "Error: Le password est vide! <br>";
    //}if(!key_exists(self::STATUS_REF, $this->data) or strlen($this->data[self::STATUS_REF])==0){
    //    $this->error .= "Error: Le status est vide! <br>";
    }
    return ($this->error == null);
  }

}

?>
