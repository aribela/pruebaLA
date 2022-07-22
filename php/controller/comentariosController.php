<?php
    require_once '../php/model/database.php';
    require_once '../php/model/comentariosModel.php';
    require_once '../php/model/comentario.php';
    require_once '../install/config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class comentariosController 
	{

        private $_arrNombres = array(
            "Alan",	"Jacinto",	"Martinez",
            "Alicia",	"Jesús",	"Mirta",
            "Andrea",	"Josefina",	"Mónica",
            "Andrés",	"Juan",	"Nicolás",
            "Antonia",	"Juana",	"Noé",
            "Antonio",	"Juárez",	"Noelia",
            "Azul",	"Julia",	"Paula",
            "Bartolomé",	"Julián",	"Patricio",
            "Belén",	"Juliana",	"Renzo",
            "Celeste",	"Julio",	"Rodrigo",
            "Edgardo",	"Leandro",	"Rodríguez",
            "Felicia",	"Luis",	"Romina",
            "Florencia",	"Luisa",	"Rosario",
            "Gaspar",	"Marcelo",	"Tato",
            "Gerardo",	"Marcos",	"Tomás",
            "Giménez",	"María",	"Victor",
            "Gonzalo",	"Mariano",	"Yayo",
           " Gustavo",	"Martín",	"Zulema",
        );

        private $_lorem = ['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'praesent', 'interdum', 'dictum', 'mi', 'non', 'egestas', 'nulla', 'in', 'lacus', 'sed', 'sapien', 'placerat', 'malesuada', 'at', 'erat', 'etiam', 'id', 'velit', 'finibus', 'viverra', 'maecenas', 'mattis', 'volutpat', 'justo', 'vitae', 'vestibulum', 'metus', 'lobortis', 'mauris', 'luctus', 'leo', 'feugiat', 'nibh', 'tincidunt', 'a', 'integer', 'facilisis', 'lacinia', 'ligula', 'ac', 'suspendisse', 'eleifend', 'nunc', 'nec', 'pulvinar', 'quisque', 'ut', 'semper', 'auctor', 'tortor', 'mollis', 'est', 'tempor', 'scelerisque', 'venenatis', 'quis', 'ultrices', 'tellus', 'nisi', 'phasellus', 'aliquam', 'molestie', 'purus', 'convallis', 'cursus', 'ex', 'massa', 'fusce', 'felis', 'fringilla', 'faucibus', 'varius', 'ante', 'primis', 'orci', 'et', 'posuere', 'cubilia', 'curae', 'proin', 'ultricies', 'hendrerit', 'ornare', 'augue', 'pharetra', 'dapibus', 'nullam', 'sollicitudin', 'euismod', 'eget', 'pretium', 'vulputate', 'urna', 'arcu', 'porttitor', 'quam', 'condimentum', 'consequat', 'tempus', 'hac', 'habitasse', 'platea', 'dictumst', 'sagittis', 'gravida', 'eu', 'commodo', 'dui', 'lectus', 'vivamus', 'libero', 'vel', 'maximus', 'pellentesque', 'efficitur', 'class', 'aptent', 'taciti', 'sociosqu', 'ad', 'litora', 'torquent', 'per', 'conubia', 'nostra', 'inceptos', 'himenaeos', 'fermentum', 'turpis', 'donec', 'magna', 'porta', 'enim', 'curabitur', 'odio', 'rhoncus', 'blandit', 'potenti', 'sodales', 'accumsan', 'congue', 'neque', 'duis', 'bibendum', 'laoreet', 'elementum', 'suscipit', 'diam', 'vehicula', 'eros', 'nam', 'imperdiet', 'sem', 'ullamcorper', 'dignissim', 'risus', 'aliquet', 'habitant', 'morbi', 'tristique', 'senectus', 'netus', 'fames', 'nisl', 'iaculis', 'cras', 'aenean'];

        private $_calificaciones = array(1 => "Pesimo", 2 => "Malo", 3 => "Regular", 4 => "Bueno", 5 => "Excelente");

 		function __construct() {          
			$this->objconfig = new config();
			// $this->objsm =  new sportsModel($this->objconfig);
            $this->objcom =  new comentariosModel($this->objconfig);
		}

        public function generaComentario($productoId){
            $claveNom = array_rand($this->_arrNombres, 1);
            $claveCal = array_rand($this->_calificaciones, 1);
            
            $comentario=new comentario();
            $comentario->productoId = trim($productoId);
            $comentario->nombre = trim($this->_arrNombres[$claveNom]);
            $comentario->calificacion = trim($claveCal);
            $comentario->text = $this->obtenerTexto($claveCal);
            $idc = $this->objcom->insertRecord($comentario);

            return $idc;
        }

        function obtenerTexto($claveCal){
            $numParrafos = rand(1,3);
            $parrafos = "";
            $textoCal = $this->_calificaciones[$claveCal];
            $texto = "<p>".$textoCal."<p>";

            for ($i=1; $i <=$numParrafos ; $i++) { 
                $numPalabras = random_int(5, 15);
                $palabras = [];

                for ($i=1; $i <=$numPalabras ; $i++) { 
                    $clavePal = array_rand($this->_lorem, 1);
                    $palabras[] = $this->_lorem[$clavePal];
                }

                $parrafos .= "<p>".implode(" ", $palabras)."<p>";
            }

            $texto .= $parrafos;
            return $texto;
        }

        // mvc handler request
		public function mvcHandler(){
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
		public function checkValidation($sporttb){    $noerror=true;
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