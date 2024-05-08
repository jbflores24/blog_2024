<?php 
    include("../includes/header.php");
    include("../config/Mysql.php");
    include("../modelos/Comentario.php");
    $base = new Mysql();
    $cx = $base->connect();
    $Comentario = new Comentario($cx);
    if (isset($_GET['id'])){
        $comentario_id = $_GET['id'];
        $comment = $Comentario->getComentario($comentario_id);
    }

    if (isset($_POST['editarComentario'])){
        $estado = $_POST['estado'];
        if ($estado == -1){
            $error = "Debes seleccionar un estado";
        } else {
            if ($Comentario->editarComentario($estado,$comentario_id)){
                $mensaje = "Comentario editado correctamente";
                header('location:comentarios.php?mensaje=' . urlencode($mensaje));
            } else {
                $error = "No se pudo editar el comentario";
            }
        }
    }

    if (isset($_POST['borrarComentario'])){
        if ($Comentario->borrarComentario($comentario_id)){
            $mensaje = "Se ha eliminado el comentario";
            header('location:comentarios.php?mensaje=' . urlencode($mensaje));
        } else {
                $error = "No se pudo eliminar el comentario";
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
        <div class="col-sm-12 text-center">
            <h3>Editar Comentario</h3>
        </div>            
    </div>
    <div class="row my-5">
        <div class="col-sm-6 offset-3">
        <form method="POST" action=""> 

            <input type="hidden" name="id" value="<?=$comment->id?>">

            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly><?=$comment->comentario?></textarea>              
            </div>               

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" value="<?=$comment->autor?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="estado" aria-label="Default select example">
                <option value="-1">--Seleccionar una opción--</option>
                <option value="1" <?=($comment->estado==1?'selected':'')?>>Aprobado</option>
                <option value="0" <?=($comment->estado==0?'selected':'')?>>No Aprobado</option>              
                </select>                 
            </div>  

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       