<?php

class Database{

    function __construct($consetup)
    {
        $this->host = $consetup->host;
        $this->user = $consetup->user;
        $this->pass =  $consetup->pass;
        $this->db = $consetup->db;            					
    }
    
    public function connect(){
        try{
            return new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8;',
				$this->user,
				$this->pass,
					[
						/**
						 * Activar el manejo de errores y retornar una exception.
						 */
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						/**
						 * Cambiar el modo de gestion de datos en el software
						 * En este caso queremos que retorne objetos.
						 */
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
					]);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

}