<?php
	
	class accesoriosModel extends Database
	{
		private $_tabla = "accesorios";

		public function close_db()
		{
			// $this->condb->close();
		}	

		// insert record
		public function insertRecord($obj){
			try{
				// $this->open_db();
				$conn = parent::connect();
				$query=$conn->prepare("INSERT INTO ".$this->_tabla." (categoriaPadreId, nombre) VALUES (?, ?)");
				$query->bindParam(1, $obj->categoriaPadreId, PDO::PARAM_INT);
				$query->bindParam(2, $obj->nombre, PDO::PARAM_STR);
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
		public function updateRecord($obj)
		{
			try
			{	
				$query=parent::connect()->prepare("UPDATE sports SET category=?,name=? WHERE id=?");
				$query->bindParam(1, $obj->category, PDO::PARAM_STR);
				$query->bindParam(2, $obj->name, PDO::PARAM_STR);
				$query->bindParam(3, $obj->id, PDO::PARAM_INT);
				
				$query->execute();
				$res=$query->rowCount();					
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}
        }
         // delete record
		public function deleteRecord($id)
		{	
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
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}		
        }   
        // select record     
		public function selectRecord($accesoriosStr = "", $id = ""){
			try{
                // $this->open_db();
                if($id>0){	
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." WHERE idCategoria=?");
					$query->bindParam(1, $id, PDO::PARAM_INT);
					$query->execute();
					$res = $query->fetch();
					// echo "id: ".$id;
				}
                elseif($accesoriosStr !== ""){
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." WHERE idAccesorio IN($accesoriosStr) ");	
					$query->execute();
					$rw = $query->rowCount();
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					// echo "rw: ".$rw;
					// echo "<pre>"; print_r($res); echo "</pre>";
					if($rw == 0){
						$res = array();
					}
				}else{
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." ");	
					$query->execute();
					$rw = $query->rowCount();
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					// echo "rw: ".$rw;
					// echo "<pre>"; print_r($res); echo "</pre>";
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