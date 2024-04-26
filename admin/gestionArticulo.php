<?php 
    include("../includes/header.php");
    include("../config/Mysql.php");
    include("../modelos/Articulo.php");
    $base = new Mysql();
    $cx = $base->connect();
    $articulo = new Articulo($cx); 
    if (isset($_GET['opcion'])){
        $op = $_GET['opcion'];
        $id = $_GET['id'];
        if ($op == 1){
            $tituloF = "AGREGAR UN ARTíCULO";
            $boton = "Agregar Artículo";
        } else {
            $tituloF = "EDITAR ARTíCULO";
            $boton = "Editar Artículo";
            $article = $articulo->getArticulo($id);
        }
        if (isset($_POST['gestionArticulo'])){
            $titulo = $_POST['titulo'];
            $texto  = $_POST['texto'];
            if ($titulo=='' || empty ($titulo) || $texto=='' || empty($texto)){
                $error = "Debe completar los campos";
            } else {
                if ($_FILES['imagen']['error']>0){
                    if ($op!=2){
                        $error = "Debe seleccionar una imagen";
                    } else {
                        //echo "<h1>pase x aqui</h1>";
                        if ($articulo->editar($id, $titulo, '' ,$texto)){
                            $mensaje ="Artículo editado correctamente";
                            header('Location: articulos.php?mensaje='.urlencode($mensaje));
                        } else {
                            $error = "No se ha podido editar el artículo";
                        }
                    }
                } else {
                    $image = $_FILES['imagen']['name'];
                    $imgArr = explode('.', $image);
                    $rand = rand(1000,9999);
                    $newImage = $imgArr[0].$rand.".".$imgArr[1];
                    $rutaFinal = "../img/articulos/". $newImage;
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'],$rutaFinal)){
                        if ($op==1){
                            if ($articulo->crear($titulo,$newImage,$texto,$_SESSION['id'])){
                                $mensaje = "Articulo creado correctamente";
                                header ("location:articulos.php?mensaje=".urlencode($mensaje));
                            } else {
                                $error = "No se pudo crear el registro";
                            }
                        } else {
                            if ($articulo->editar($id, $titulo, $newImage ,$texto)){
                                $mensaje ="Artículo editado correctamente";
                                header('Location: articulos.php?mensaje='.urlencode($mensaje));
                            } else {
                                $error = "No se ha podido editar el artículo";
                            }
                        }
                    }
                }
            }
        }
        if (isset($_REQUEST['borrarArticulo'])) {
            if ($articulo->borrar($id)){
                $mensaje="El artículo se ha eliminado correctamente";
                header('Location: articulos.php?mensaje='.urlencode($mensaje));
            } else{
                $error="Error al intentar borrar el artículo";
            }
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
<div class="container">

    <div class="row">
        <div class="col-sm-12 text-center">
            <h3><?=$tituloF?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
            <form method="POST" action="" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?=$article->id?>">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" value="<?=$article->titulo?>">
                </div>
                <?php if ($op==2):?>
                    <div class="mb-3">
                        <img class="img-fluid img-thumbnail" src="../img/articulos/<?=$article->imagen?>">
                    </div>
                <?php endif;?>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">
                </div>
                <div class="mb-3">
                    <label for="texto">Texto</label>
                    <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px"><?=$article->texto?></textarea>
                </div>

                <br />
                <button type="submit" name="gestionArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> <?=$boton?></button>
                <?php if ($op==2):?>
                    <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
                <?php endif;?>
            </form>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>