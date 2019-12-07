<?php

interface NebulaStorage{
    function read($id);
    function readAll();
    function create(Nebula $nebula);
    function delete($id);
    function modify($id, $nebula);
}
?>
