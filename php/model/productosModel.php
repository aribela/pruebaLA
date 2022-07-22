<?php
	
	class productosModel extends Database
	{
		private $_tabla = "productos";
		public function close_db(){
			// $this->condb->close();
		}	

		// insert record
		public function insertRecord($obj){
			try{
				// $this->open_db();
				$conn = parent::connect();
				$query=$conn->prepare("INSERT INTO ".$this->_tabla." (categoriaPrincipalId,categorias, nombre, modelo, especificaciones, precio) VALUES (?, ?, ?, ?, ?, ?)");
				$query->bindParam(1, $obj->categoriaPrincipalId, PDO::PARAM_INT);
				$query->bindParam(2, $obj->categorias, PDO::PARAM_STR);
				$query->bindParam(3, $obj->nombre, PDO::PARAM_STR);
				$query->bindParam(4, $obj->modelo, PDO::PARAM_STR);
				$query->bindParam(5, $obj->especificaciones, PDO::PARAM_STR);
				$query->bindParam(6, $obj->precio, PDO::PARAM_INT);
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

		public function updateVisitas($productoId){
			try{	
				$query=parent::connect()->prepare("UPDATE ".$this->_tabla." SET visitas=visitas+1 WHERE idProducto=? ");
				$query->bindParam(1, $productoId, PDO::PARAM_INT);
				
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
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}		
        }   
        // select record     
		public function selectRecord($categoriaId = "", $id = "", $textBuscar = ""){
			try{
                // $this->open_db();
                if($id>0){	
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." WHERE idProducto=?");
					$query->bindParam(1, $id, PDO::PARAM_INT);
					$query->execute();
					$res = $query->fetch();
					// echo "id: ".$id;
				}
                elseif($categoriaId > 0){
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." 
					WHERE 
					(categorias LIKE '$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId')
					 ");	
					$query->execute();
					$rw = $query->rowCount();
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					// echo "rw: ".$rw;
					// echo "<pre>"; print_r($res); echo "</pre>";
					if($rw == 0){
						$res = array();
					}
				}	
				elseif($textBuscar !== ""){
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." 
					WHERE 
					(nombre LIKE '%$textBuscar%')
					 ");	
					$query->execute();
					// echo "<pre>"; print_r($query); echo "</pre>";
					$rw = $query->rowCount();
					$res = $query->fetchAll(PDO::FETCH_OBJ);
					// echo "rw: ".$rw;
					if($rw == 0){
						$res = array();
					}
				}	
				else{
					$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." ");	
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

		public function obtProductosDestacados($categoriaId = ""){
			try{
                // $this->open_db();
                $where = ($categoriaId !== "")?"
				WHERE 
					(categorias LIKE '$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId') OR 
					categorias='$categoriaId'
				":"";
				$query=parent::connect()->prepare("SELECT * FROM ".$this->_tabla." 
				$where
				ORDER BY RAND()
				LIMIT  40
					");	
				$query->execute();
				$rw = $query->rowCount();
				$res = $query->fetchAll(PDO::FETCH_OBJ);
				// echo "rw: ".$rw;
				// echo "<pre>"; print_r($res); echo "</pre>";
				if($rw == 0){
					$res = array();
				}
						
				         
                return $res;
			}
			catch(Exception $e){
				$this->close_db();
				throw $e; 	
			}
		}

		public function obtProductosMasVendidos($categoriaId = ""){
			try{
                // $this->open_db();
                $where = ($categoriaId !== "")?"
				WHERE 
					(categorias LIKE '$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId,%') OR
					(categorias LIKE '%,$categoriaId') OR 
					categorias='$categoriaId'
				":"";
				$query=parent::connect()->prepare("SELECT A.*, 
				(SELECT AVG(B.calificacion) FROM comentarios B WHERE B.productoId
				=A.idProducto ) AS promedio 
				FROM ".$this->_tabla." A 
				$where 
				ORDER BY promedio DESC
				
					");	
				$query->execute();
				$rw = $query->rowCount();
				$res = $query->fetchAll(PDO::FETCH_OBJ);
				// echo "rw: ".$rw;
				// echo "<pre>"; print_r($res); echo "</pre>";
				if($rw == 0){
					$res = array();
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