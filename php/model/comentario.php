<?php

class comentario
{
    // table fields
    public $idComentario;
    public $productoId;
    public $nombre;
    public $text;
    public $calificacion;
    // message string
    public $id_msg;
    public $category_msg;
    public $name_msg;
    // constructor set default value
    function __construct()
    {
        $idComentario=$productoId=$calificacion=0;$nombre=$text="";
        $id_msg=$category_msg=$name_msg="";
    }
}

?>