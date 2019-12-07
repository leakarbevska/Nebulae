<?php

class AccountStorageStub implements AccountStorage{
    private $accounts;

    function init(){
        $this->accounts= array(
            array(
                'login' => 'toto',
                'password' => '$2y$10$vecze/V//nVxqjpk2VqMOuk46PoPs/ol.xdB4.0OTtj1Z.ee0W4a.',
                'name' => 'Toto Dupont',
                'status' => 'admin',
            ),
            array(
                'login' => 'testeur',
                'password' => '$2y$10$Lj0O5fP9xARQvYuo5/dd7.PLAVm9mPo5zwPEohMogU3XwIGN6ZY2C',
                'name' => 'Jean-Michel Testeur',
                'status' => 'user',
            ),
            array(
                'login' => 'martine',
                'password' => '$2y$10$yZ6Wvlp1ylaRK6IwjY0CzuJ.eSQJyao/iMWbHT1SMDKkJ6WEBCnr6',
                'name' => 'Martine Dubois',
                'status' => 'user',
            ),
            array(
                'login' => 'raymond',
                'password' => '$2y$10$X1HrGzMVPYiOeV6UibjGnuDd/MoGnm0.hwhiwWDmyzjjHlfZpsOlm',
                'name' => 'Raymond Martin',
                'status' => 'user',
            ),
        );
    }


    function checkAuth($login, $password){
        $key = array_search($login, array_column($this->accounts,'login'));
        $account = $this->accounts[$key];
        if(password_verify($password, $account['password'])){
            return $account;
        }
        return null;
    }

}
?>