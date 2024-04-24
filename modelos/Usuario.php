<?php
    class Usuario{
        private $conn; //conexión con la BD
        private $table = "usuarios";

        public  function __construct($cx) {
            $this->conn =$cx;
        }

        public function registro ($nombre, $email, $password){
            try {
                //Instrucción que dice que hacer
                $qry = "insert into " . $this->table . "(nombre,  email, password, rol_id) values (:nombre, :email, :password, 2)";
                //Preparo la operación
                $st = $this->conn->prepare($qry);
                //Asignar los valores
                $pass_encriptada = md5($password);
                $st->bindParam (':nombre', $nombre, PDO::PARAM_STR);
                $st->bindParam (":email", $email,PDO::PARAM_STR);
                $st->bindParam (":password", $pass_encriptada, PDO::PARAM_STR);
                $st->execute();
                return true;
            } catch (PDOException $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function validaEmail($email){
            try{
                $qry = 'select * from ' .$this->table . " where email = :email";
                $st = $this->conn->prepare($qry);
                $st->bindParam(":email", $email, PDO::PARAM_STR);
                $st->execute();
                $resultado = $st->fetch(PDO::FETCH_ASSOC);
                if ($resultado){
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }
        
        public function listar(){
            try{
                $qry = "select * from view_" .$this->table;
                $st = $this->conn->prepare($qry);
                $st->execute();
                return $st->fetchAll(PDO::FETCH_OBJ);
            }catch(PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function getUser($id){
            try{
                $qry = "select * from ". $this->table . " where id = :id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':id', $id, PDO::PARAM_INT);
                $st->execute();
                return $st->fetch(PDO::FETCH_OBJ);
            } catch( PDOException $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function editarUsuario($id, $nombre, $email, $rol_id){
            try {
                $qry = "update  ".$this->table." set nombre=:nombre, email=:email, rol_id=:rol_id where id=:id";
                $st = $this->conn->prepare($qry);
                $st->bindParam(":id", $id, PDO::PARAM_INT);
                $st->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $st->bindParam(':email', $email, PDO::PARAM_STR);
                $st->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
                $st->execute();
                return true;
            } catch (PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function borrarUsuario ($id){
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

        public function login ($email, $password){
            try {
                $pass = md5($password);
                $qry = "select * from " . $this->table . " where email = :email and password = :password";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':email', $email, PDO::PARAM_STR);
                $st->bindParam(':password', $pass,  PDO::PARAM_STR);
                $st->execute();
                $resultado = $st->fetch(PDO::FETCH_ASSOC);
                if ($resultado){
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e){
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

        public function consultaEmail ($email){
            try{
                $qry = "select * from ". $this->table . " where email = :email";
                $st = $this->conn->prepare($qry);
                $st->bindParam(':email', $email, PDO::PARAM_STR);
                $st->execute();
                return $st->fetch(PDO::FETCH_OBJ);
            } catch( PDOException $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
                return false;
            }
        }

    }