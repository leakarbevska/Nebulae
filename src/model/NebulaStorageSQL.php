<?php

class NebulaStorageSQL implements NebulaStorage{
    private $bd;

    function __construct($bd){
        $this->bd = $bd;
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function init(){
        $myfile = fopen("sql/nebulae.sql", "r") or die("Unable to open file!");
        $query  = fread($myfile,filesize("sql/nebulae.sql"));
        fclose($myfile);

        $stmt = $this->bd->query($query);
    }
    

    function read($id){
        $rq = "SELECT * FROM nebulae WHERE id=:id";
        $stmt = $this->bd->prepare($rq);
        $data = array(":id" => $id);
        $stmt->execute($data);
        if(!$stmt){
            return null;
        }
        $list = $stmt->fetch();
        return new Nebula($list[NebulaBuilder::NAME_REF], $list[NebulaBuilder::IMAGE_REF], $list[NebulaBuilder::CONSTEL_REF], $list[NebulaBuilder::DISTANCE_REF], $list[NebulaBuilder::RADIUS_REF], $list[NebulaBuilder::USER_REF]);
    }

    function readAll(){
        $nebulae = array();
        $stmt = $this->bd->query("SELECT * FROM nebulae");
        if ($stmt !== FALSE) {
            $list = $stmt->fetchAll();
            foreach($list as $key => $value){
                $nebulae[$value['id']] = new Nebula($value[NebulaBuilder::NAME_REF], $value[NebulaBuilder::IMAGE_REF], $value[NebulaBuilder::CONSTEL_REF], $value[NebulaBuilder::DISTANCE_REF], $value[NebulaBuilder::RADIUS_REF], $value[NebulaBuilder::USER_REF]);
            }
            return $nebulae;
        }
        return null;
    }

    function create(Nebula $nebula){
        $rq = "INSERT INTO nebulae (name, image, constellation, distance, radius, user) 
                           VALUES (:name, :image, :constellation, :distance, :radius, :user)";
        $stmt = $this->bd->prepare($rq);
        $data = array(":name" =>$nebula->getName(),
                    ":image" => $nebula->getImage(),
                    ":constellation" => $nebula->getConstellation(),
                    ":distance" => $nebula->getDistance(),
                    ":radius" => $nebula->getRadius(),
                    ":user"  => $nebula->getUser());
        $stmt->execute($data);
        if(!$stmt){
            return null;
        }
        return $this->bd->lastInsertId();
    }

    function delete($id){
        $rq = "DELETE FROM nebulae WHERE id=:id";
        $stmt = $this->bd->prepare($rq);
        $data = array(":id" => $id);
        $stmt->execute($data);
        if(!$stmt){
            throw new core_exception_database("DELETE query does not work!");
        }
    }

    function modify($id, $nebula){
        $rq = "UPDATE nebulae
               SET name=:name, image=:image, constellation=:constellation, distance=:distance, radius=:radius
               WHERE id=:id";
        $stmt = $this->bd->prepare($rq);
        $data = array(":id"  => $id, 
                    ":name"  => $nebula->getName(),
                    ":image" => $nebula->getImage(),
                    ":constellation" => $nebula->getConstellation(),
                    ":distance" => $nebula->getDistance(),
                    ":radius" => $nebula->getRadius());
        $stmt->execute($data);
        if(!$stmt){
            throw new core_exception_database("INSERT query does not work!");
        }
    }
}
