<?php
    require_once '../php/model/database.php';
    require_once '../php/model/categoriasModel.php';
    require_once '../php/model/categoria.php';
    require_once '../install/config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class categoriasController 
	{
        private $_arrCatPadre = array(1,2,3,4);
        private $_arrCatNom1 = array("pc", "laptop", "notebook", "minilap", "matebook");
        private $_arrCatNom2 = array("lenovo", "hp", "dell", "acer", "apple", "toshiba",  "samsung", "asus", "alienware", "gateway", "lanix", "sony", "lg");

 		function __construct() 
		{          
			$this->objconfig = new config();
			// $this->objsm =  new sportsModel($this->objconfig);
            $this->objcat = new categoriasModel($this->objconfig);
		}

        public function generaCategoria($accesorios = array()){
            
            $claveCP = array_rand($this->_arrCatPadre, 1);
            $claveN1 = array_rand($this->_arrCatNom1, 1);
            $claveN2 = array_rand($this->_arrCatNom2, 1);
            $arrIdsAcc = array();
            if(count($accesorios) > 0){
                $numAccesorios = rand(1,3);
                $arrClavesAcc = array_rand($accesorios, $numAccesorios);
                
                if(is_array($arrClavesAcc)){
                    foreach ($arrClavesAcc as $itemClaveAcc) {
                        $arrIdsAcc[] = $accesorios[$itemClaveAcc]->idAccesorio;
                    }
                }
            }
            $categoria=new categoria();
            $categoria->categoriaPadreId = trim($this->_arrCatPadre[$claveCP]);
            $categoria->nombre = trim($this->_arrCatNom1[$claveN1])." ".trim($this->_arrCatNom2[$claveN2]);
            $categoria->accesorios = implode(",", $arrIdsAcc);
            $idc = $this->objcat->insertRecord($categoria);

            return $idc;
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
        // // add new record
		// public function insert($categoriaPadreId, $nombre){
        //     try{
        //         $categoria=new categoria();
        //         if (isset($_POST['addbtn'])) {   
        //             // read form value
        //             $categoria->categoriaPadreId = trim($categoriaPadreId);
        //             $categoria->nombre = trim($nombre);
        //             //call validation
        //             $chk=$this->checkValidation($categoria);                    
        //             if($chk){   
        //                 //call insert record            
        //                 $pid = $this -> objsm ->insertRecord($categoria);
        //                 if($pid>0){			
        //                     $this->list();
        //                 }else{
        //                     echo "Somthing is wrong..., try again.";
        //                 }
        //             }else{    
        //                 $_SESSION['sporttbl0']=serialize($categoria);//add session obj           
        //                 // $this->pageRedirect("view/insert.php");                
        //             }
        //         }
        //     }catch (Exception $e) {
        //         // $this->close_db();	
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
        // // delete record
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