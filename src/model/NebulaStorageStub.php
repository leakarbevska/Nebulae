<?php

class NebulaStorageStub implements NebulaStorage{
    private $nebulaeTab;

    function __construct(){
      $this->nebulaeTab = array(
                  '1'  => new Nebula('Orion',"https://www.nasa.gov/sites/default/files/thumbnails/image/orion-nebula-xlarge_web.jpg",'Orion',1344,12.0,'toto'),
                  '2'  => new Nebula('Horsehead',"https://en.wikipedia.org/wiki/Horsehead_Nebula#/media/File:Barnard_33.jpg",'Orion',1500,3.5,'martine'),
                  '3'  => new Nebula('Crab','http://cdn.eso.org/images/screen/eso9948f.jpg','Taurus',6523,5.5,'toto'));
    }

    function read($id){
        return $this->nebulaeTab[$id];
    }

    function readAll(){
        return $this->nebulaeTab;
    }

    function create(Nebula $nebula){
      array_push($this->nebulaeTab,$nebula);
    }

    function delete($nebula){
      unset($this->$nebulaeTab[$nebula]);
    }

    function modify($id, $nebula){
      $this->nebulaeTab[$id] = $nebula;
    }
}

?>
