<?php
    class Articulo{
        private $conn;
        private $tabla = 'articulos';

        public function __construct($cx){
            $this->conn = $cx;
        }

        public function listar($usuario_id, $rol_id){
            try{
                $cad="";
                if ($rol_id != 1){
                    $cad = " where usuario_id = :usuario_id";
                }
                $qry = "select * from view_".$this->tabla.$cad;
                $st = $this->conn->prepare($qry);
                if ($rol_id != 1){
                    $st->bindParam(':usuario_id', $usuario_id,  PDO::PARAM_INT);
                }

                $st->execute();
                return $st->fetchAll (PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo "Errores : " . $e->getMessage();
                return false;
            }
        }

        public function crear($titulo, $imagen, $texto, $usuario_id ){
            try {
                $qry = "insert into " . $this->tabla . " (titulo, imagen, texto, usuario_id) values (:titulo, :imagen, :texto, :usuario_id)";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':titulo', $titulo, PDO::PARAM_STR);
                $st->bindParam(':imagen', $imagen, PDO::PARAM_STR);
                $st->bindParam(':texto', $texto, PDO::PARAM_STR);
                $st->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo "Errores : " . $e->getMessage();
                return false;
            } catch (Exception $error){
                echo "Errores : " . $error->getMessage();
                return false;
            }
        }

        function getArticulo ($id){
            try {
                $qry = "select * from ".  $this->tabla." where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam (':id', $id, PDO::PARAM_INT);
                $st->execute();
                return $st->fetch(PDO::FETCH_OBJ);
            } catch (PDOException $e){
                echo "Mensajes encontrados : " . $e->getMessage();
            }
        }

        function editar ($id, $titulo, $imagen, $texto){
            try {
                $qry = 'update '. $this->tabla.' set titulo=:titulo, texto=:texto where id=:id';
                if ($imagen != ""){
                    $qry = 'update '. $this->tabla.' set titulo=:titulo, texto=:texto, imagen = :imagen where id=:id';
                }
                $st = $this->conn->prepare($qry);
                $st->bindParam(':id',$id, PDO::PARAM_INT);
                $st->bindParam(':titulo' ,$titulo, PDO::PARAM_STR);
                $st->bindParam(':texto', $texto, PDO::PARAM_STR);
                if ($imagen != ""){
                    $st->bindParam(':imagen',$imagen, PDO::PARAM_STR);
                }
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo "Errores : " . $e->getMessage();
                return false;
            }
        }

        public function borrar($id){
            try {
                $qry = "delete from " . $this->tabla . "  where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo "Errores : " . $e->getMessage();
                return false;
            }
        }
    }