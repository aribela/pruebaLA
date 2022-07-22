<?php

class producto
{
    // table fields
    public $idProducto;
    public $categoriaPrincipalId;
    public $categorias;
    public $nombre;
    public $modelo;
    public $especificaciones;
    public $precio;
    // message string
    public $id_msg;
    public $category_msg;
    public $name_msg;
    // constructor set default value
    function __construct()
    {
        $idProducto=$categoriaPrincipalId=$precio=0;$categorias=$nombre=$modelo=$especificaciones="";
        $id_msg=$category_msg=$name_msg="";
    }
}

?>