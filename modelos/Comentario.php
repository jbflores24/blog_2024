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

        public function listar(){
            try {
                $qry = "select * from view_".$this->table;
                $st = $this->conn->prepare($qry);
                $st->execute();
                return $st->fetchAll (PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo "Error al listar : " . $e->getMessage();
                return false;
            }
        }
        
    }