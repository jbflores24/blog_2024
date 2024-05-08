<?php 
    class Comentario{
        private $table = 'comentarios';
        private $conn;

        public function __construct($cx){
            $this->conn = $cx;
        }

        public function crearComentario ($comentario, $usuario_id, $articulo_id){
            try {
                $qry = "insert into ". $this->table . " (comentario, usuario_id, articulo_id, estado) values (:comentario, :usuario_id, :articulo_id, 0)";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':comentario', $comentario, PDO::PARAM_STR);
                $st->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $st->bindParam(':articulo_id', $articulo_id, PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error en crear comentario : " . $e->getMessage();
                return false;
            } catch (Exception $err) {
                echo "Error en crear comentario : " . $err->getMessage();
                return false;
            }
        }

        public function listar($usuario_id, $rol_id){
            try {
                $cad = '';
                if ($rol_id!=1){
                    $cad = " where prop_art = :usuario_id";
                }
                $qry = "select * from view_".$this->table.$cad;
                $st = $this->conn->prepare($qry);
                if ($rol_id!=1){
                    $st->bindParam(":usuario_id",$usuario_id,PDO::PARAM_INT);
                }
                $st->execute();
                return $st->fetchAll (PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo "Error al listar : " . $e->getMessage();
                return false;
            }
        }

        public function getComentario($id){
            try{
                $qry = "select * from view_".  $this->table." where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam (':id', $id, PDO::PARAM_INT);
                $st->execute();
                return $st->fetch(PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo "Error al listar : " . $e->getMessage();
                return false;
            }
        }

        public function editarComentario ($estado, $id){
            try {
                $qry = "update  ".$this->table." set estado=:estado where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->bindParam(':estado', $estado, PDO::PARAM_STR);
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function borrarComentario ($id){
            try{
                $qry = "delete from  ".$this->table." where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':id',$id,PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function comentarios_articulos ($id){
            try {
                $qry = "select * from view_" . $this->table . " where articulo_id = :id and estado = 1";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':id', $id, PDO::PARAM_INT);
                $st->execute();
                return $st->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }
        
        
    }