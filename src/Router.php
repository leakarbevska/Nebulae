<?php

class Router{

  function main(NebulaStorage $nebulaStorage, AccountStorage $accountStorage){
    session_start();

    $_SESSION['feedback'] = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';

    
    /*--- Check connection of User ---*/
    if(key_exists('user', $_SESSION)){
      $account = $_SESSION['user'];
      $view = new PrivateView($_SESSION['feedback'], $account);
    }else{
      $view = new View($_SESSION['feedback']);
    }

    unset($_SESSION['feedback']);

    //session_destroy();
    $controller = new Controller($view, $nebulaStorage, $accountStorage);

    $permission = false;
    if(key_exists('action',$_GET)){
      $permission = $this->checkPermission($_GET['action']);

      /*--------------    NEBULA   -------------*/
      if(key_exists('id', $_GET)){
        if($_GET['action']==="nebula"){
          if($permission){
            $controller->showInformation($_GET['id']);
          }else{
            $view->makeRestrictedPage();}
        }elseif($_GET['action']==="demanderSuppression" and $permission){
          $controller->askNebulaDeletion($_GET['id']);
        }elseif($_GET['action']==="suppression"  and $permission){
          $controller->deleteNebula($_GET['id']);
        }elseif($_GET['action']==="modification" and $permission){
          $controller->modifyNebula($_GET['id']);
        }elseif($_GET['action']==="sauverModification" and $permission){
          $controller->saveModifiedNebula($_GET['id'], $_POST); }
      }elseif($_GET['action']==="nouveau" ){
        if($permission){
          $controller->newNebula();
        }else{
          $view->makeRestrictedPage(); }
      }elseif($_GET['action']==="sauverNouveau" and $permission){
        $controller->saveNewNebula($_POST);

      } /*-------------    ACCOUNT  --------------*/
      elseif($_GET['action']==='connexionCompte' and $permission){
        $view->makeLoginFormPage(new AccountBuilder());
      }elseif($_GET['action']==='verifierConnexionCompte' and $permission){
        $controller->checkConnection($_POST);
      }elseif($_GET['action']==='nouveauCompte'  and $permission){
        $controller->newAccount();
      }elseif($_GET['action']==='verifierCompte' and $permission){
        $controller->checkNewAccount($_POST);
      }elseif($_GET['action']==="deconnexionCompte" and $permission){
        $controller->deconnection();
      }elseif($_GET['action']==="demanderSuppressionCompte" and $permission){
        $controller->askAccountDeletion($_SESSION['user']);
      }elseif($_GET['action']==="suppressionCompte" and $permission){
        $controller->deleteAccount($_SESSION['user']);
      }elseif($_GET['action']==='compte' and $permission){
        $view->makeProfilePage();

      }/*--------------   OTHER PAGES   ---------------*/
      elseif($_GET['action']==='liste'    and $permission){
        $controller->showList();
      }elseif($_GET['action']==='apropos' and $permission){
        $view->makeAboutPage();
      }elseif($_GET['action']==='accueil' and $permission){
        $view->makeHomePage();
      }

    }else{
      $view->makeErrorPage();
    }
    
 }

 /*----- ACCESS PERMISSION ------*/
function checkPermission($action){
  $everyoneAllowed = array("connexionCompte", "verifierConnexionCompte", "verifierCompte", "nouveauCompte",
                              "accueil", "liste", "apropos");
  $connectedAllowed = array("compte", "demanderSuppressionCompte", "suppressionCompte", "deconnexionCompte",
                            "nebula", "nouveau", "sauverNouveau", "demanderSuppression", "suppression", "modification", "sauverModification");
  
  if(in_array($action, $everyoneAllowed))  { return true; }
  if(in_array($action, $connectedAllowed) and (key_exists('user', $_SESSION)))  { return true; }
  return false;
}

/*------ REDIRECTION ------*/
  function POSTredirect($url, $feedback){
    $_SESSION['feedback'] = $feedback;
    header("HTTP/1.1 303 See Other");
    header("Location: ".$url);
    die;
  }

//------------------------------------------ PAGE URLs ------------------------------------------//

  /*---------- ACCOUNT ----------*/
  function getConnectionPageURL(){
    return "index.php?action=connexionCompte";
  }

  function getCheckConnection(){
    return "index.php?action=verifierConnexionCompte";
  }

  function getProfileURL(){
    return "index.php?action=compte";
  }
  
  function getCheckNewAccount(){
    return "index.php?action=verifierCompte";
  }

  function getNewAccountURL(){
    return "index.php?action=nouveauCompte";
  }

  function getAccountAskDeletionURL(){
    return "index.php?action=demanderSuppressionCompte";
  }

  function getAccountDeletionURL(){
    return "index.php?action=suppressionCompte";
  }

  function getDeconnectionURL(){
    return "index.php?action=deconnexionCompte";
  }

  /*----------- NEBULA ----------*/
  function getNebulaURL($id){
    return "index.php?action=nebula&id=".$id;
  }

  function getNebulaCreationURL(){
    return "index.php?action=nouveau";
  }

  function getNebulaSaveURL(){
    return "index.php?action=sauverNouveau";
  }

  function getNebulaAskDeletionURL($id){
    return "index.php?id=".$id."&action=demanderSuppression";
  }

  function getNebulaDeletionURL($id){
    return "index.php?id=".$id."&action=suppression";
  }

  function getNebulaModifyURL($id){
    return "index.php?id=".$id."&action=modification";
  }

  function getNebulaSaveModificationURL($id){
    return "index.php?id=".$id."&action=sauverModification";
  }

  /*---------- OTHER PAGES ---------*/
  function getHomePage(){
    return "index.php?action=accueil";
  }

  function getNebulaListPage(){
    return "index.php?action=liste";
  }

  function getAboutPage(){
    return "index.php?action=apropos";
  }

}
