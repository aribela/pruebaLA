<?php

class categoria
{
    // table fields
    public $idCategoria;
    public $categoriaPadreId;
    public $nombre;
    public $accesorios;
    // message string
    public $id_msg;
    public $category_msg;
    public $name_msg;
    // constructor set default value
    function __construct()
    {
        $idCategoria=0;$categoriaPadreId=0;$nombre=$accesorios="";
        
        $id_msg=$category_msg=$name_msg="";
    }
}

?>