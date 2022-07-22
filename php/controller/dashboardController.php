<?php
    require '../php/model/database.php';
    // require '../php/model/sportsModel.php';
    // require '../php/model/sports.php';
    require '../php/model/accesoriosModel.php';
    require '../php/model/accesorio.php';
    require 'categoriasController.php';
    require 'productosController.php';
    require 'comentariosController.php';
    require_once '../install/config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class dashboardController 
	{
        

        function __construct() 
		{          
			$this->objconfig = new config();
			// $this->objsm =  new sportsModel($this->objconfig);
            $this->objcat = new categoriasModel($this->objconfig);
            $this->objprod = new productosModel($this->objconfig);
            $this->objcom = new comentariosModel($this->objconfig);
            $this->objacc = new accesoriosModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
            $categoriasP = $this->objcat->selectRecord(0);
            $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
            $numPorPagina = 10;
            
			switch ($act) 
			{
                case 'add' :                    
					// $this->insert();
					break;						
				case 'update':
                    // echo "antes de update";die();
					// $this->update();
					break;				
				case 'delete' :					
					// $this -> delete();
					break;			
                case 'subcategorias':
                    $this->subcategorias();
                break;
                case 'producto':
                    $this->producto($categoriasP);
                break;
                case 'crearRegistros';
                    $this->crearRegistros();
                break;
                case 'crearProductos';
                    $this->crearProductos();
                break;
                case 'crearComentarios';
                    $this->crearComentarios();
                break;
                case 'buscar';
                    $this->buscar($categoriasP, $pagina, $numPorPagina);
                break;
				default:
                    $this->list($categoriasP);
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        // check validation
		public function checkValidation($sporttb)
        {    $noerror=true;
            // Validate category        
            if(empty($sporttb->category)){
                $sporttb->category_msg = "Field is empty.";$noerror=false;
            } elseif(!filter_var($sporttb->category, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $sporttb->category_msg = "Invalid entry.";$noerror=false;
            }else{$sporttb->category_msg ="";}            
            // Validate name            
            if(empty($sporttb->name)){
                $sporttb->name_msg = "Field is empty.";$noerror=false;     
            } elseif(!filter_var($sporttb->name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $sporttb->name_msg = "Invalid entry.";$noerror=false;
            }else{$sporttb->name_msg ="";}
            return $noerror;
        }
       
        
        public function list($categoriasP){
            $categoriaId = (isset($_GET["categoriaId"]))?$_GET["categoriaId"]:"";
            // echo "categoria: ".$categoriaId;
            // $result=$this->objsm->selectRecord(0);
            
            $destacados = $this->objprod->obtProductosDestacados($categoriaId);
            $vendidos = $this->objprod->obtProductosMasVendidos($categoriaId);
            $categoria = $categoriaPadre = array();
            if($categoriaId > 0){
                $categoria = $this->objcat->selectRecord("", $categoriaId);
                $categoriaPadre = $this->objcat->selectRecord("", $categoria->categoriaPadreId);
            }
            include "view/list.php";                                        
        }

        public function buscar($categoriasP, $pagina, $numPorPagina){
            //textbuscar
            $categoriaId = (isset($_GET["categoriaId"]))?$_GET["categoriaId"]:"";
            $textbuscar = (isset($_GET["textbuscar"]))?$_GET["textbuscar"]:"";
            // echo "categoria: ".$categoriaId;
            // $result=$this->objsm->selectRecord(0);
            
            $productos = $this->objprod->selectRecord("", "", $textbuscar);
            
            $categoria = $categoriaPadre = array();
            if($categoriaId > 0){
                $categoria = $this->objcat->selectRecord("", $categoriaId);
                $categoriaPadre = $this->objcat->selectRecord("", $categoria->categoriaPadreId);
            }
            include "view/buscar.php";   
        }

        public function producto($categoriasP){
            $productoId = (isset($_GET["id"]))?$_GET["id"]:"";
            // echo "categoria: ".$categoriaId;
            
            $this->objprod->updateVisitas($productoId);
            $producto = $this->objprod->selectRecord("", $productoId);
            $comentarios = $this->objcom->selectRecord("", $productoId);
            $categoriaId = $producto->categoriaPrincipalId;
            $categoria = $categoriaPadre = array();
            $accesorios = array();
            if($categoriaId > 0){
                $categoria = $this->objcat->selectRecord("", $categoriaId);
                $categoriaPadre = $this->objcat->selectRecord("", $categoria->categoriaPadreId);
                if($categoria->accesorios != ""){
                    $accesorios = $this->objacc->selectRecord($categoria->accesorios);
                }
            }
            include "view/producto.php";                                        
        }

        public function subcategorias(){
            $categoriaPadreId = (isset($_GET["categoriaPadreId"])) ? $_GET["categoriaPadreId"] : 0;
            $categorias = $this->objcat->selectRecord($categoriaPadreId);
            echo json_encode($categorias);     
        }

        public function crearRegistros(){
            $numRegistros = 10;
            $categorias = $this->objcat->selectRecord("", "");
            $accesorios = $this->objacc->selectRecord("", "");
            $contCat = $contProd = $contCom = 0;
            //categoria
            for ($i=0; $i < $numRegistros; $i++) {
                $catController = new categoriasController(); 
                $idc = $catController->generaCategoria($accesorios);
                if($idc > 0){
                    $contCat++;
                }
            }

            //productos
            for ($i=0; $i < $numRegistros; $i++) {
                $prodController = new productosController(); 
                $idp = $prodController->generaProducto($categorias);
                if($idp > 0){
                    $contProd++;
                }
            }

            //comentarios
            for ($i=0; $i < $numRegistros; $i++) {
                $comController = new comentariosController(); 
                $productoId = rand(1,10);
                $idc = $comController->generaComentario($productoId);
                if($idc > 0){
                    $contCom++;
                }
            }

            $msg = "";
            $msg .= "Se insertaron ".$contCat." categorias, $contProd productos, $contCom comentarios";
            $this->guardaLog($msg);

            $arrRes = array("success" => true, "msg" => $msg);
            echo json_encode($arrRes);     
        }

        public function crearProductos(){
            $numRegistros = 200;
            $categorias = $this->objcat->selectRecord("", "");
            $contCat = $contProd = $contCom = 0;
            //productos
            for ($i=0; $i < $numRegistros; $i++) {
                $prodController = new productosController(); 
                $idp = $prodController->generaProducto($categorias);
                if($idp > 0){
                    $contProd++;
                }
            }

            $msg = "";
            $msg .= "Se insertaron $contProd productos";
            $this->guardaLog($msg);

            $arrRes = array("success" => true, "msg" => $msg);
            echo json_encode($arrRes);     
        }

        public function crearComentarios(){
            $numRegistros = 1000;
            $productos = $this->objprod->selectRecord("", "");
            $contCat = $contProd = $contCom = 0;
            //productos
            if(count($productos) > 0){
                while($contCom <= $numRegistros){
                    foreach ($productos as $producto) {
                        $comController = new comentariosController();
                        $idc = $comController->generaComentario($producto->idProducto);
                        if($idc > 0){
                            $contCom++;
                        }
                        if($contCom > $numRegistros){
                            break;
                        }
                    }
                }
            }
            

            $msg = "";
            $msg .= "Se insertaron $contCom comentarios";
            $this->guardaLog($msg);

            $arrRes = array("success" => true, "msg" => $msg);
            echo json_encode($arrRes);          
        }

        private function guardaLog($msg){
            $dateByZone = new DateTime("now", new DateTimeZone('America/Mexico_City') );
            $dateTime = $dateByZone->format('d-m-Y H:i:s'); //fecha Actual
            if(!file_exists("log_sql.txt")){
				$file = fopen("log_sql.txt", "w");
				fclose($file);
			}
			$file = fopen("log_insert.txt", "a");
			fwrite($file, $dateTime.": ".$msg . PHP_EOL);
			fclose($file);
        }

        

    }
		
	
?>