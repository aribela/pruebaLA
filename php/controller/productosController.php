<?php
    require_once '../php/model/database.php';
    require_once '../php/model/productosModel.php';
    require_once '../php/model/producto.php';
    require_once '../install/config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class productosController 
	{
        private $_especificaciones = array(
            "fabricante" => "",
            "series" => array("IdeaPad 3-15ITL", "FA506IC-HN068W", "MateBook D 15"),
            "color" => array("plateado", "negro", "azul", "rosa"),
            "pantalla" => array("13.3", "14", "15", "15.6"),
            "resolucion" => array("1366*768", "1920*1080"),
            "procesador"=>array("intel", "amd", "apple"),
            "tipo de procesador" => array("intel core i3","intel core i7","rayzen 5","rayzen 3","Chip Apple M1"),
            "velocidad del procesador" => array("3Ghz","4ghz"),
            "numero de procesadores" => array("1","2"),
            "tamaño de ram" => array("8gb","4gb"),
            "memoria maxima compatible" => array("32gb","16gb"),
            "tamaño de la unidad de disco duro" => array("256gb","512gb","1t"),
            "marca de tarjeta grafica" => array("intel", "nvidia"),
            "numero de puertos usb 2.0" => array("0", "1", "2"),
            "numero de puertos usb 3.0" => array("0", "1", "2", "3"),
            "tipo de unidad optica" => array("dvd", "cd-rom"),
            "sistema operativo" => array("windows 8.1", "windows 10", "windows 11", "MacOS"),
        );

 		function __construct() {          
			$this->objconfig = new config();
			// $this->objsm =  new sportsModel($this->objconfig);
            $this->objprod =  new productosModel($this->objconfig);
		}

        public function generaProducto($categorias){
            // echo "<pre>";print_r($categorias);echo "</pre>";die();
            $catIndex = rand(0, count($categorias)-1);
            $categoria = $categorias[$catIndex];
            $arrNomCat = explode(" ", $categoria->nombre);
            $modelo = $arrNomCat[1];

            $producto=new producto();
            $producto->categoriaPrincipalId = trim($categoria->idCategoria);
            $producto->categorias = trim($categoria->idCategoria);
            $producto->nombre = trim($categoria->nombre);
            $producto->modelo = trim($modelo);
            $producto->especificaciones = $this->obtenerExpecificaciones($modelo);
            $producto->precio = trim(rand(10000,60000));
            $idp = $this->objprod->insertRecord($producto);

            return $idp;
        }

        private function obtenerExpecificaciones($modelo){
            $html = "";

            $html .= "<table>";
            foreach($this->_especificaciones as $key => $esp){
                $especificacion = "";
                if($key == "fabricante"){
                    $especificacion = $modelo;
                }else{
                    $claveEsp = array_rand($esp, 1);
                    $especificacion = $esp[$claveEsp];
                }
                $html .= "<tr>";
                $html .= "<td>".$key."</td>";
                $html .= "<td>".$especificacion."</td>";
                $html .= "</tr>";
            }
            $html .= "</table>";

            return $html;
        }

        // mvc handler request
		public function mvcHandler() {
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) {
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
				default:
                    // $this->list();
			}
		}		
        // page redirection
		public function pageRedirect($url){
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
        // add new record
		// public function insert(){
        //     try{
        //         $sporttb=new sports();
        //         if (isset($_POST['addbtn'])) {   
        //             // read form value
        //             $sporttb->category = trim($_POST['category']);
        //             $sporttb->name = trim($_POST['name']);
        //             //call validation
        //             $chk=$this->checkValidation($sporttb);                    
        //             if($chk){   
        //                 //call insert record            
        //                 $pid = $this -> objsm ->insertRecord($sporttb);
        //                 if($pid>0){			
        //                     $this->list();
        //                 }else{
        //                     echo "Somthing is wrong..., try again.";
        //                 }
        //             }else{    
        //                 $_SESSION['sporttbl0']=serialize($sporttb);//add session obj           
        //                 $this->pageRedirect("view/insert.php");                
        //             }
        //         }
        //     }catch (Exception $e) {
        //         $this->close_db();	
        //         throw $e;
        //     }
        // }
        // update record
        // public function update(){
        //     // echo "aqui";die();
        //     try{
        //         if (isset($_POST['updatebtn'])) {
        //             $sporttb=unserialize($_SESSION['sporttbl0']);
        //             $sporttb->id = trim($_POST['id']);
        //             $sporttb->category = trim($_POST['category']);
        //             $sporttb->name = trim($_POST['name']);                    
        //             // check validation  
        //             $chk=$this->checkValidation($sporttb);
        //             if($chk){
        //                 $res = $this -> objsm ->updateRecord($sporttb);	                        
        //                 if($res){			
        //                     $this->list();                           
        //                 }else{
        //                     echo "Somthing is wrong..., try again.";
        //                 }
        //             }else{         
        //                 $_SESSION['sporttbl0']=serialize($sporttb);      
        //                 $this->pageRedirect("view/update.php");                
        //             }
        //         }elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        //             $id=$_GET['id'];
        //             // echo "id: " . $id;die();
        //             $result=$this->objsm->selectRecord($id);
        //             // echo "<pre>";print_r($result);echo "</pre>";die();
        //             // $row=mysqli_fetch_array($result);  
        //             $sporttb=new sports();                  
        //             $sporttb->id=$result->id;
        //             $sporttb->name=$result->name;
        //             $sporttb->category=$result->category;
        //             $_SESSION['sporttbl0']=serialize($sporttb);
        //             $this->pageRedirect('view/update.php');
        //         }else{
        //             echo "Invalid operation.";
        //         }
        //     }
        //     catch (Exception $e) {
        //         // $this->close_db();	
        //         $this->connection = null;			
        //         throw $e;
        //     }
        // }
        // delete record
        // public function delete(){
        //     try{
        //         if (isset($_GET['id'])) {
        //             $id=$_GET['id'];
        //             $res=$this->objsm->deleteRecord($id);                
        //             if($res){
        //                 $this->pageRedirect('index.php');
        //             }else{
        //                 echo "Somthing is wrong..., try again.";
        //             }
        //         }else{
        //             echo "Invalid operation.";
        //         }
        //     }
        //     catch (Exception $e) {
        //         // $this->close_db();		
        //         $this->connection = null;		
        //         throw $e;
        //     }
        // }
        // public function list(){
        //     $result=$this->objsm->selectRecord(0);
        //     include "view/list.php";                                        
        // }
    }
		
	
?>