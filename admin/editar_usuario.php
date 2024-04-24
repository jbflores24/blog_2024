<?php 
    include("../includes/header.php");
    include("../config/Mysql.php");
    include("../modelos/Usuario.php");
    $base = new Mysql();
    $cx = $base->connect();
    $usuario = new Usuario($cx);
    $id=0;
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $user = $usuario->getUser($id);
    } 
    if (isset($_POST['editarUsuario'])){
        $nombre=$_POST["nombre"];
        $email =$_POST['email'];
        $rol_id=$_POST['rol_id'];
        $id = $_POST['id'];
        if ($nombre=='' || empty($nombre) || $email=='' || empty($email) || $rol_id==0){
            $error = "Todos los campos son obligatorios";
        } else {
            if ($usuario->editarUsuario($id, $nombre,$email,$rol_id)) {
                $mensaje = "Se ha actualizado el registro";
                header( "Location: usuarios.php?mensaje=".urlencode($mensaje));
            } else {
                $error = "Existe un problema al actualizar";
            }
        }
    }
    if (isset($_POST['borrarUsuario'])){
        $id = $_POST['id'];
        if ($usuario->borrarUsuario($id)){
            $mensaje = "Se ha borrado el registro";
            header( "Location: usuarios.php?mensaje=".urlencode($mensaje));
        } else {
            $error = "Error al borrar el registro";
        }
    }
?>
    <!--Imprimir el error o el mensaje -->
<div class="row">
    <div class="col-sm-12">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $error ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php if (isset($mensaje)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $mensaje ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>

    <div class="row">
        <div class="col-sm-6">
            <h3>Editar Usuario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?=$user->id?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?=$user->nombre?>" >              
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?=$user->email?>" >               
            </div>
            <div class="mb-3">
            <label for="rol_id" class="form-label">Rol:</label>
            <select class="form-select" aria-label="Default select example" name="rol_id">
                <option value="0">--Selecciona un rol--</option>
                <option value="1" <?=($user->rol_id==1?'selected':'')?>>Administrador</option>  
                <option value="2" <?=($user->rol_id==2?'selected':'')?>>Registrado</option>
                             
            </select>             
            </div>          
        
            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       