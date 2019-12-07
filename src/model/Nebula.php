<?php
class Nebula{
    private $name;
    private $image;
    private $constellation;
    private $distance;
    private $radius;
    private $user;

    function __construct($name, $image, $constellation, $distance, $radius, $user){
        $this->name = $name;
        $this->image = $image;
        $this->constellation = $constellation;
        $this->distance = $distance;
        $this->radius = $radius;
        $this->user  = $user;
    }

    function getName(){
        return $this->name;
    }

    function getImage(){
        return $this->image;
    }

    function getConstellation(){
        return $this->constellation;
    }

    function getDistance(){
        return $this->distance;
    }

    function getRadius(){
        return $this->radius;
    }

    function getUser(){
        return $this->user;
    }
}
?>