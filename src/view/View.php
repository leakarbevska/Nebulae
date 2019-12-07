<?php

class View{
  protected $title;
  protected $content;
  protected $router;
  protected $menu;
  protected $feedback;

  function __construct($feedback){
    $this->router = new Router();
    $this->feedback = $feedback;
  }

  function getMenu(){
    return array("Accueil" => $this->router->getHomePage(), "Connexion" => $this->router->getConnectionPageURL(), "Nébuleuses" => $this->router->getNebulaListPage(), "Nouvelle Nébuleuse" => $this->router->getNebulaCreationURL(), "À Propos" => $this->router->getAboutPage());
  }

  function render(){
    echo"<!doctype html>
        <html lang='fr'>
        <head>
        <meta charset='utf-8'>
        <link type='text/css' rel='stylesheet' href='skin/skin.css' />
        <link rel='stylesheet' type='text/css' href='skin/list.css' />
        <title>".$this->title."</title></head>
        <body>
        <ul>"; 
        foreach($this->getMenu() as $key => $url){ //menu
          echo "<li><a href='".$url."'>".$key."</a><br></li>";
        }
    echo"</ul><div>
        <h5>".$this->feedback."</h5>
        ".$this->content."
        </div>
        <script src='script/script.js'></script>
        </body>
        </html>";
    unset($_SESSION['feedback']);
  }

  //--------------------------------------------------------------- PAGE DESIGN ----------------------------------------------------------------//
  function makeHomePage(){
    $this->title   = "Homepage";
    $this->content = "<h1>Nébuleuse</h1><br>
    <h3>Une nébuleuse (du latin nebula, nuage) désigne, en astronomie, un objet céleste composé de gaz raréfié, de plasma ou de poussières interstellaires. Avant les années 1920, le terme désignait tout objet du ciel d’aspect diffus. Étudiées par des astrophysiciens spécialisés dans l'étude du milieu interstellaire, les nébuleuses jouent un rôle clé dans la naissance des étoiles.</h3>
    <img src='skin/planetary_nebulae.jpg' alt='Image of nebulae' width='550' height='400'>
    <h4>Credits: <a href='https://fr.wikipedia.org/wiki/N%C3%A9buleuse'>Wikipedia</a><br></h4>";
    $this->render();
  }


  function makeLoginFormPage(AccountBuilder $accountBuilder){
    $this->title   = "Page pour connexion";
    $this->content = "<h1>Connectez-vous</h1><br>
                      <br><form action='".$this->router->getCheckConnection()."' method='POST'>
                      <label>Login : <input type='text' name='login' value='' pattern='^[a-zA-ZÀ-ÿ-. ]*$' /></label>
                      <label>Password: <input type='password' name='password' value='' /></label>
                      <button type='submit'>Log In</button>
                      </form><br>";
    $this->content.= "<br><hr><br><br><h2>Créer un nouveau compte</h2><br>
                     <form action='".$this->router->getCheckNewAccount()."' method='POST'>
                     <label><input type='text' name='login' value='".$accountBuilder->getData()[AccountBuilder::NAME_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' placeholder='Login' /></label><br>
                     <label><input type='text' name='name' value='".$accountBuilder->getData()[AccountBuilder::LOGIN_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' placeholder='Name' /></label><br>
                     <label><input type='password' name='password' value='".$accountBuilder->getData()[AccountBuilder::PASSWORD_REF]."' placeholder='Password' /></label><br>
                     <h4>Status :</h4>";
    if($accountBuilder->getData()[AccountBuilder::STATUS_REF] === 'admin'){
      $this->content.=  "<label>User <input type='radio' name='status' value='user' ></label>
                         <label>Admin <input type='radio' name='status' value='admin' checked></label><br>";                 
    }else{
      $this->content.=  "<label>User <input type='radio' name='status' value='user' checked></label>
                         <label>Admin <input type='radio' name='status' value='admin' ></label><br>";}
    $this->content.= "<br><button type='submit'>Sign Up</button> </form>
                       <br>".$accountBuilder->getError();
    $this->render();
  }


  function makeListPage($nebulae){
    $this->title   = "Page de la liste";
    $this->content = "<h1>";
    foreach($nebulae as $key => $nebula){
      $this->content.= "<a href='".$this->router->getNebulaURL($key)."'>".$nebula->getName()."</a><br>";
    }
    $this->content.= "</h1><br><h4>Credits: <a href='https://fr.wikipedia.org/wiki/N%C3%A9buleuse'>Wikipedia</a><br>
                      <a href='https://www.nasa.gov/subject/6893/nebulae/'>NASA</a></h4>";
    $this->render();
  }


  function makeNebulaPage($nebula, $id, $permission){
    $this->title   = "Page sur ".$nebula->getName();
    $this->content = "<h1>".$nebula->getName()."</h1><br>
                      <img id='originalImg' src='".$nebula->getImage()."' alt='".$nebula->getName()." Nebula' style='width:100%;max-width:400px'>
                      <div id='myModal' class='modal'>
                        <img src='data:,' alt='' class='modal-content' id='modalImg'>
                        <div id='caption'></div>
                      </div>
                      <h4>La nébuleuse ".$nebula->getName()." est située dans la constellation ".$nebula->getConstellation().", 
                      à environ ".$nebula->getDistance()." années-lumière de la terre.</h4>
                      <h4>Son rayon est de ".$nebula->getRadius()." années lumière.</h4>";
    if($permission){
      $this->content.= "<a href='".$this->router->getNebulaAskDeletionURL($id)."'>Suppresion</a><br>
                        <a href='".$this->router->getNebulaModifyURL($id)."'>Modification</a><br>";
    }
    $this->render();
  }


  function makeNebulaDeletionPage($id){
    $this->title   = "Page de confirmation de supression ".$id;
    $this->content = "<form action='".$this->router->getNebulaURL($id)."' method='POST'>
                      <h2>Êtes-vous sûr de vouloir supprimer l'nebula avec l'id: ".$id."?</h2>
                      <button type='submit'>Annuler</button>
                      <button type='submit' formaction='".$this->router->getNebulaDeletionURL($id)."' >Confirmer</button>
                      </form><br>";
    $this->render();
  }


  function makeNebulaModificationPage($id, NebulaBuilder $nebulaBuilder){
    $this->title   = "Page pour modification nebula";
    $this->content = "<form action='".$this->router->getNebulaSaveModificationURL($id)."' method='POST'>
                      <label>Nom:    <input type='text' name='name' value='".$nebulaBuilder->getData()[$nebulaBuilder::NAME_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' /></label><br>
                      <label>Image : <input type='text' name='image' value='".$nebulaBuilder->getData()[$nebulaBuilder::IMAGE_REF]."' pattern='(http(s?):)([/|.|\w|\s|-])*\.(?:jpg|gif|png)' placeholder='http://example.jpg' /></label><br>
                      <label>Constellation : <input type='text' name='constellation' value='".$nebulaBuilder->getData()[$nebulaBuilder::CONSTEL_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' /></label><br>
                      <label>Distance :    <input type='text' name='distance' value='".$nebulaBuilder->getData()[$nebulaBuilder::DISTANCE_REF]."' pattern='[0-9]*' /></label><br>
                      <label>Rayon :    <input type='text' name='radius' value='".$nebulaBuilder->getData()[$nebulaBuilder::RADIUS_REF]."' pattern='^\d{0,2}(\.\d{1,2})?$' /></label><br>
                      <button type='submit'>Modifier !</button>
                      </form><br>".$nebulaBuilder->getError();
    $this->render();
  }


  public function makeNebulaCreationPage(NebulaBuilder $nebulaBuilder){
    $this->title   = "Page pour creation nebula";
    $this->content = "<br><h1>Créez votre nouvelle nébuleuse</h1><br>";
    $this->content.= "<br><form action='".$this->router->getNebulaSaveURL()."' method='POST'>
                      <label>Nom :    <input type='text' name='name' value='".$nebulaBuilder->getData()[NebulaBuilder::NAME_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' /></label><br>
                      <label>Image : <input type='text' name='image' value='".$nebulaBuilder->getData()[$nebulaBuilder::IMAGE_REF]."' pattern='(http(s?):)([/|.|\w|\s|-])*\.(?:jpg|gif|png)' placeholder='http://example.jpg'/></label><br>
                      <label>Constellation : <input type='text' name='constellation' value='".$nebulaBuilder->getData()[NebulaBuilder::CONSTEL_REF]."' pattern='^[a-zA-ZÀ-ÿ-. ]*$' /></label><br>
                      <label>Distance :    <input type='text' name='distance' value='".$nebulaBuilder->getData()[NebulaBuilder::DISTANCE_REF]."' pattern='[0-9]*' /></label><br>
                      <label>Rayon :    <input type='text' name='radius' value='".$nebulaBuilder->getData()[NebulaBuilder::RADIUS_REF]."' pattern='^\d{0,2}(\.\d{1,2})?$' /></label><br>
                      <button type='submit'>Envoyer !</button>
                      </form><br>".$nebulaBuilder->getError();
    $this->render();
  }


  function makeAboutPage(){
    $this->title   = "Page à propos";
    $this->content = "<img src='skin/star.png' alt='ChristmasTree' width='60' height='60'>";
    $this->content.= "<h5>NUMETU: 21711436</h5><br>
                      <h4>Fonctionnalités principales: </h4>
                      <p>Création, modification, suppression d'une Nébuleuse;<br>
                      Création, déconnexion, connexion, suppression d'un Compte;<br>
                      Retour d'information pour chaque action mentionnée ci-dessus;<br>
                      Restriction sur certaines pages et fonctionnalités selon que l'utilisateur est connecté ou non;<br>
                      Chaque image d'une nébuleuse est cliquable et l'affiche en plus grand format en haut de la page actuelle (image modale).</p>";
    $this->render();
  }


  //------------------------ EXTRA -----------------------------//
  function makeUnknownNebulaPage() {
    $this->title   = "Page sur une nébuleuse inconnu";
    $this->content = "<h1>Nébuleuse inconnu</h1>";
    $this->render();
  }

  function makeRestrictedPage(){
    $this->title   = "Page restreinte";
    $this->content = "<br><h1>Cette page est restreinte!</h1>
                     <h4>Connectez-vous <a href='".$this->router->getConnectionPageURL()."' >ici</a>, pour obtenir l'accès.</h4>";
    $this->render();
  }

  public function makeErrorPage(){
    $this->title   = "Page d'erreur";
    $this->content = "<h1>ERROR<h1>";
    $this->render();
  }

  public function makeDebugPage($variable) {
  	$this->title   = 'Debug';
  	$this->content = '<pre>'.var_export($variable, true).'</pre>';
    $this->render();
  }

  function makeTestView(){
    $this->title   = "Test Title!";
    $this->content = "<h1>Voilà.</h1>";
    $this->render();
  }


  //-------------------------------------------------------------- REDIRECTS ----------------------------------------------------------------//
  function displayNebulaCreationFailure() {
    $this->router->POSTredirect($this->router->getNebulaCreationURL(),"creation failure");
  }

  public function displayNebulaCreationSuccess($id){
    $this->router->POSTredirect($this->router->getNebulaURL($id), "creation successful");
  }

  function displayNebulaDeletionSuccess($id){
    $this->router->POSTredirect($this->router->getNebulaListPage(),"nebula with id:".$id." deleted succesfully");
  }

  function displayNebulaModificationFailure($id){
    $this->router->POSTredirect($this->router->getNebulaModifyURL($id),"modification failure");
  }

  function displayNebulaModificationSuccess($id){
    $this->router->POSTredirect($this->router->getNebulaURL($id),"modification successful");
  }

  function displayConnectionSuccess(){
    $this->router->POSTredirect($this->router->getHomePage(),"connection successful");
  }

  function displayConnectionFailure(){
    $this->router->POSTredirect($this->router->getConnectionPageURL(),"connection failure");
  }

  function displayAccountCreationFailure(){
    $this->router->POSTredirect($this->router->getNewAccountURL(),"creation of account failure");
  }

  function displayDeconnectionSuccess(){
    $this->router->POSTredirect($this->router->getHomePage(), "deconnection succesful");
  }

  function displayAccountDeletionSuccess($account){
    $this->router->POSTredirect($this->router->getHomePage(),"account with login:".$account->getLogin()." deleted succesfully");
  }

}
?>