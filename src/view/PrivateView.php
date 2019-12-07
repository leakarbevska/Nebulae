<?php

class PrivateView extends View{
    private $account;

    function __construct($feedback, $account){
        parent::__construct($feedback);
        $this->account = $account;
    }

    function getMenu(){
        return array("Accueil" => $this->router->getHomePage(), "Compte" => $this->router->getProfileURL(), "Nébuleuses" => $this->router->getNebulaListPage(), "Nouvelle Nébuleuse" => $this->router->getNebulaCreationURL(), "À Propos" => $this->router->getAboutPage());
    }

    function makeHomePage(){
        $this->title   = "Homepage";
        $this->content = "<h2>Bienvenue ".$this->account->getName()."!</h2>";
        $this->content.= "<h1>Nébuleuse</h1><br>
                        <h3>Une nébuleuse (du latin nebula, nuage) désigne, en astronomie, un objet céleste composé de gaz raréfié, de plasma ou de poussières interstellaires. Avant les années 1920, le terme désignait tout objet du ciel d’aspect diffus. Étudiées par des astrophysiciens spécialisés dans l'étude du milieu interstellaire, les nébuleuses jouent un rôle clé dans la naissance des étoiles.</h3>
                        <img src='skin/planetary_nebulae.jpg' alt='Image of nebulae' width='550' height='400'>
                        <h4>Credits: <a href='https://fr.wikipedia.org/wiki/N%C3%A9buleuse'>Wikipedia</a><br></h4>";
        $this->render();
      }


    function makeProfilePage(){
        $this->title   = "Profile";
        $this->content = "<h1>Votre Compte</h1><br><br>
                         <br><img src='skin/profile_icon.png' alt='Profile picture' width='160' height='150'>";
        $this->content.= "<h2>Nom : ".$this->account->getName()."</h2>
                          <h2>Login : ".$this->account->getName()."</h2><br>
                      <br><h4><a href='".$this->router->getDeconnectionURL()."'>Log Out</a></h4>
                      <h4><a href='".$this->router->getAccountAskDeletionURL()."'>Supprimer Compte</a></h4>";
        $this->render();
    }


    function makeAccountDeletionPage(){
        $this->title   = "Page de confirmation de supression compte";
        $this->content = "<form action=".$this->router->getProfileURL()." method='POST'>
                          <h2>Êtes-vous sûr de vouloir supprimer votre compte?</h2>
                          <button type='submit'>Annuler</button>
                          <button type='submit' formaction=".$this->router->getAccountDeletionURL().">Confirmer</button>
                          </form>";
        $this->render();
    }
}

?>