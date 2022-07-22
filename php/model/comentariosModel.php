<?php
	
	class comentariosModel extends Database
	{
		private $_tabla = "comentarios";

		public function close_db(){
			// $this->condb->close();
		}	

		// insert record
		public function insertRecord($obj){
			try{
				// $this->open_db();
				$conn = parent::connect();
				$query=$conn->prepare("INSERT INTO ".$this->_tabla." (productoId,nombre, text, calificacion) VALUES (?, ?,?,?)");
				$query->bindParam(1, $obj->productoId, PDO::PARAM_INT);
				$query->bindParam(2, $obj->nombre, PDO::PARAM_STR);
				$query->bindParam(3, $obj->text, PDO::PARAM_STR);
				$query->bindParam(4, $obj->calificacion, PDO::PARAM_INT);
				$query->execute();
				$res=$query->rowCount();
				$last_id=$conn->lastInsertId();
				// $query->close();
				$this->close_db();
				return $last_id;
			}
			catch (Exception $e) {
				$this->close_db();	
            	throw $e;
        	}
		}
        //update record
		public function updateRecord($obj){
			try{	
				$query=parent::connect()->prepare("UPDATE sports SET category=?,name=? WHERE id=?");
				$query->bindParam(1, $obj->category, PDO::PARAM_STR);
				$query->bindParam(2, $obj->name, PDO::PARAM_STR);
				$query->bindParam(3, $obj->id, PDO::PARAM_INT);
				
				$query->execute();
				$res=$query->rowCount();					
				$this->close_db();
				return true;
			}
			catch (Exception $e) {
            	$this->close_db();
            	throw $e;
        	}
        }
         // delete record
		public function deleteRecord($id){	
			try{
				// $this->open_db();
				$query=parent::connect()->prepare("DELETE FROM sports WHERE id=?");
				$query->bindParam(1, $id, PDO::PARAM_INT);
				$query->execute();
				$res=$query->rowCount();
				// $query->close();
				$this->close_db();
				return true;	
			}
			catch (Exception $e) {
            	$this->close_db();
            	throw $e;
        	}		
        }   
        // select record     
		public function selectRecord($id = "", $productoId = ""){
			try{
                // $this->open_db();
                if($id>0){	
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." WHERE id=?");
					$query->bindParam(1, $id, PDO::PARAM_INT);
					$query->execute();
					$res = $query->fetch();
					echo "id: ".$id;
				}
                else{
					$query=parent::connect()->prepare("SELECT *, DATE_FORMAT(fechaCreacion, \"%d/%m/%Y %H:%i\") AS fechaCreacion2 FROM ".$this->_tabla." WHERE productoId=? ORDER BY calificacion DESC ");	
					$query->bindParam(1, $productoId, PDO::PARAM_INT);
					$query->execute();
					$rw = $query->rowCount();
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					
					if($rw == 0){
						$res = array();
					}
				}		
				          
                return $res;
			}
			catch(Exception $e){
				$this->close_db();
				throw $e; 	
			}
			
		}
	}

?>