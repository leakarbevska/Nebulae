<?php

class NebulaStorageFile implements NebulaStorage{
  private $db;

  function __construct($file){
    $this->db = new ObjectFileDB($file);
  }

  function init(){
    $this->db->deleteAll();
    $this->db->insert(new Nebula('Orion','Orion',1344,12.0,'toto'));
    $this->db->insert(new Nebula('Horsehead','Orion',1500,3.5,'martine'));
    $this->db->insert(new Nebula('Crab','Taurus',6523,5.5,'toto'));
  }

  function read($id){
    if ($this->db->exists($id)) {
      return $this->db->fetch($id);
    } else {
      return null;
    }
  }

  function readAll(){
    return $this->db->fetchAll();
  }

  function create(Nebula $nebula){
    return $this->db->insert($nebula);
  }

  function delete($id){
    $this->db->delete($id);
  }

  function modify($id, $nebula){
    $this->db->update($id, $nebula);
  }
}
?>
