<?php

class AccountStorageSQL implements AccountStorage{
    private $bd;

    function __construct($bd){
        $this->bd = $bd;
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function init(){
        $myfile = fopen("sql/accounts.sql", "r") or die("Unable to open file!");
        $query  = fread($myfile,filesize("sql/accounts.sql"));
        fclose($myfile);

        $stmt = $this->bd->query($query);
    }

    function checkAuth($login, $password){
        $rq = "SELECT * FROM accounts WHERE login=:login";
        $stmt = $this->bd->prepare($rq);
        $data = array(":login" => $login);
        $stmt->execute($data);
        $list = $stmt->fetch();
        if(password_verify($password, $list['password'])){
            return new Account($list['name'],$list['login'],$list['password'],$list['status']);
        }
        return null;
    }

    function checkPermission($login){
        $rq = "SELECT * FROM accounts WHERE login=:login";
        $stmt = $this->bd->prepare($rq);
        $data = array(":login" => $login);
        $stmt->execute($data);
        if(!$stmt){
            throw new core_exception_database("checkPermission  does not work!");
        }
        $list = $stmt->fetch();
        return $list['status'] === 'admin';
    }

    function create(Account $account){
        $rq = "INSERT INTO accounts (name, login, password, status) VALUES (:name, :login, :password, :status)";
        $stmt = $this->bd->prepare($rq);
        $data = array(":name" =>$account->getName(),
                      ":login" => $account->getLogin(),
                      ":password" => $account->getPassword(),
                      ":status" => $account->getStatus());
        $stmt->execute($data);
        if(!$stmt){
            return null;
        }
        return $this->bd->lastInsertId();
    }

    function readAll(){
        $accounts = array();
        $stmt = $this->bd->query("SELECT * FROM accounts");
        if ($stmt !== FALSE) {
            $list = $stmt->fetchAll();
            foreach($list as $key => $value){
                $accounts[$value['id']] = new Account($value[AccountBuilder::NAME_REF], $value[AccountBuilder::LOGIN_REF], $value[AccountBuilder::PASSWORD_REF], $value[AccountBuilder::STATUS_REF]);
            }
            return $accounts;
        }
        return null;
    }

    function delete($account){
        $rq = "DELETE FROM accounts WHERE login=:login AND name=:name AND password=:password AND status=:status;";
        $stmt = $this->bd->prepare($rq);
        $data = array(":name" =>$account->getName(),
                      ":login" => $account->getLogin(),
                      ":password" => $account->getPassword(),
                      ":status" => $account->getStatus());
        $stmt->execute($data);
        if(!$stmt){
            throw new core_exception_database("DELETE query does not work!");
        }
    }

}
?>