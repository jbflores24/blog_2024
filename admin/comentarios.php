<?php 
    include("../includes/header.php"); 
    include("../config/Mysql.php");
    include("../modelos/Comentario.php");
    $base = new Mysql();
    $cx = $base->connect();
    $comentarios = new Comentario($cx);
?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>       
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblContactos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comentario</th>
                        <th>Usuario</th>
                        <th>Artículo</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>                                          
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comentarios->listar() as $comment):?>
                    <tr>
                        <td><?=$comment->id?></td>
                        <td><?=$comment->comentario?></td>
                        <td><?=$comment->autor?></td>
                        <td><?=$comment->titulo?></td> 
                        <td><?=$comment->estado==1?'Aprobado':'No Aprobado'?></td>
                        <td><?=$comment->fecha_creacion?></td>              
                        <td>
                            <a href="editar_comentario.php?id=<?=$comment->id?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>                            
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblContactos').DataTable();
    });
</script>