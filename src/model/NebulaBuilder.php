<?php

class NebulaBuilder{
  private $data;
  private $error;

  const NAME_REF     = 'name';
  const IMAGE_REF    = 'image';
  const CONSTEL_REF  = 'constellation';
  const DISTANCE_REF = 'distance';
  const RADIUS_REF   = 'radius';
  const USER_REF     = 'user';
  

  function __construct($data, $user=null){
    if($data === null){
      $this->data = array(self::NAME_REF => "", self::IMAGE_REF => "", self::CONSTEL_REF => "", self::DISTANCE_REF => "", self::RADIUS_REF => "", self::USER_REF => "");
    }else{
      $this->data = $data + array(self::USER_REF => $user);
    }
    $this->error = null;
  }

  static function createFromNebula(Nebula $nebula){
    return new NebulaBuilder(array(self::NAME_REF => $nebula->getName(), self::IMAGE_REF => $nebula->getImage(), self::CONSTEL_REF => $nebula->getConstellation(), self::DISTANCE_REF => $nebula->getDistance(),self::RADIUS_REF => $nebula->getRadius(), self::USER_REF => $nebula->getUser()));
  }

  function getData(){
    return $this->data;
  }

  function getError(){
    return $this->error;
  }

  function createNebula(){
    return new Nebula($this->data[self::NAME_REF], $this->data[self::IMAGE_REF], $this->data[self::CONSTEL_REF], $this->data[self::DISTANCE_REF], $this->data[self::RADIUS_REF], $this->data[self::USER_REF]);
  }

  function isValid(){
    if(!key_exists(self::NAME_REF, $this->data) or strlen($this->data[self::NAME_REF])==0){
        $this->error .= "Error: Le nom est vide! <br>";
    }if(!key_exists(self::IMAGE_REF, $this->data) or strlen($this->data[self::IMAGE_REF])==0){
        $this->error .= "Error: L'image est vide! <br>";
    }if(!key_exists(self::CONSTEL_REF, $this->data) or strlen($this->data[self::CONSTEL_REF])==0){
        $this->error .= "Error: La constellation est vide! <br>";
    }if(!key_exists(self::RADIUS_REF, $this->data) or strlen($this->data[self::RADIUS_REF])==0){
        $this->error .= "Error: Le rayon est vide! <br>";
    }elseif($this->data[self::RADIUS_REF]<0){
        $this->error .= "Error: Le rayon est negatif! <br>";
    }if(!key_exists(self::DISTANCE_REF, $this->data) or strlen($this->data[self::DISTANCE_REF])==0){
        $this->error .= "Error: La distance est vide! <br>";
    }elseif($this->data[self::DISTANCE_REF]<0){
        $this->error .= "Error: La distance est negatif! <br>";
    }
    return ($this->error == null);
  }

}

?>
