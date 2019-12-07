<?php

 class Controller{
  private $view;
  private $nebulaStorage;
  private $accountStorage;

  function __construct($view, $nebulaStorage, $accountStorage){
    $this->view = $view;
    $this->nebulaStorage  = $nebulaStorage;
    $this->accountStorage = $accountStorage;
  }

//-------------------- List Nebulae --------------------//
function showList(){
  $this->view->makeListPage($this->nebulaStorage->readAll());
}


//------------------------ Nebula Info ------------------------// 
  function showInformation($id) {
    if($id!=null){
       $nebula = $this->nebulaStorage->read($id);
       $permission = ($_SESSION['user']->getLogin() === $nebula->getUser() or $this->accountStorage->checkPermission($_SESSION['user']->getLogin()));
  	   $this->view->makeNebulaPage($nebula, $id, $permission);
     }else{
       $this->view->makeUnknownNebulaPage();
     }
  }


//------------------------ Log In/Out ------------------------//
  function checkConnection(array $login){
    $account = $this->accountStorage->checkAuth($login['login'], $login['password']);
    if($account!==null){
      $_SESSION['user'] = $account;
      $this->view->displayConnectionSuccess();
    }else{
      $this->view->displayConnectionFailure();
    }
  }

  function deconnection(){
    unset($_SESSION['user']);
    $this->view->displayDeconnectionSuccess();
  }

//---------------------- Creation Account -----------------------//
  function newAccount(){
    if(key_exists('currentNewAccount',$_SESSION)){
      $accountBuilder = $_SESSION['currentNewAccount'];
    }else{
      $accountBuilder = new AccountBuilder(null);
    }
    var_dump($accountBuilder);
    $this->view->makeLoginFormPage($accountBuilder);
  }

  function checkNewAccount(array $data){
    $accountBuilder = new AccountBuilder($data);
    if(!$accountBuilder->isValid()){
      $_SESSION['currentNewAccount'] = $accountBuilder;
      $this->view->displayAccountCreationFailure();
    }else{
      $account = $accountBuilder->createAccount($data);
      $id = $this->accountStorage->create($account);
      $_SESSION['user'] = $account;
      unset($_SESSION['currentNewAccount']);
      $this->view->displayConnectionSuccess();
    }
  }

//--------------------- Deleting Account -----------------------//
function askAccountDeletion($account){
  if(in_array($account, $this->accountStorage->readAll())){
    $this->view->makeAccountDeletionPage();
  }else{
    $this->view->makeErrorPage();
  }
}

function deleteAccount($account){
  $this->accountStorage->delete($account);
  unset($_SESSION['user']);
  $this->view->displayAccountDeletionSuccess($account);
}

//---------------------- Creation Nebula -----------------------//

  function saveNewNebula(array $data){
    $nebulaBuilder = new NebulaBuilder($data, $_SESSION['user']->getLogin());
    if(!$nebulaBuilder->isValid()){
      $_SESSION['currentNewNebula'] = $nebulaBuilder;
      $this->view->displayNebulaCreationFailure();
    }else{
      $id = $this->nebulaStorage->create($nebulaBuilder->createNebula($data));
      unset($_SESSION['currentNewNebula']);
      $this->view->displayNebulaCreationSuccess($id);
    }
  }

  function newNebula(){
    if(key_exists('currentNewNebula',$_SESSION)){
      $nebulaBuilder = $_SESSION['currentNewNebula'];
    }else{
      $nebulaBuilder = new NebulaBuilder(null);
    }
    $this->view->makeNebulaCreationPage($nebulaBuilder);
  }


//------------------------ Modifying Nebula -----------------------//

  function saveModifiedNebula($id, array $data){
    $nebulaBuilder = new NebulaBuilder($data);
    if(!$nebulaBuilder->isValid()){
      $nebula = $this->nebulaStorage->read($id);
      $nebulaBuilder = NebulaBuilder::createFromNebula($nebula);
      $_SESSION['modifiedNebula'] = $nebulaBuilder;
      $this->view->displayNebulaModificationFailure($id);
    }else{
      $this->nebulaStorage->modify($id, $nebulaBuilder->createNebula($data));
      unset($_SESSION['modifiedNebula']);
      $this->view->displayNebulaModificationSuccess($id);
    }
  }

  function modifyNebula($id){
    if(key_exists('modifiedNebula',$_SESSION)){
      $nebulaBuilder = $_SESSION['modifiedNebula'];
    }else{
      $nebula = $this->nebulaStorage->read($id);
      $nebulaBuilder = NebulaBuilder::createFromNebula($nebula);
      $_SESSION['modifiedNebula'] = $nebulaBuilder;
    }
    $this->view->makeNebulaModificationPage($id, $nebulaBuilder);
  }


//--------------------------- Deleting Nebula --------------------------//
  function askNebulaDeletion($id){
    if(array_key_exists($id, $this->nebulaStorage->readAll())){
      $this->view->makeNebulaDeletionPage($id);
    }else{
      $this->view->makeErrorPage();
    }
  }

  function deleteNebula($id){
    $this->nebulaStorage->delete($id);
    $this->view->displayNebulaDeletionSuccess($id);
  }


 }
