<?php

class accesorio
{
    // table fields
    public $idAccesorio;
    public $nombre;
    // message string
    public $id_msg;
    public $category_msg;
    public $name_msg;
    // constructor set default value
    function __construct()
    {
        $idAccesorio=0;$nombre="";
        
        $id_msg=$category_msg=$name_msg="";
    }
}

?>