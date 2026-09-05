<?php
$titulo="Crear categoria";
include_once("cabecera.php");


//Si le doy a guardar y no hay error entra aqui
if((isset($_POST["guardar"]))&&($banderaerror==False)){

        $idmax=0;
        //busco el id mas grande de mi lista de prod
        foreach($categorias as $cat){
            if($idmax<$cat["id_cat"]){
                $idmax=$cat["id_cat"];
            }
        }
        $idnuevo=$idmax+1;

    $bbdd->anadircat($idnuevo,$nombre);

        //redirigimos a pag categorias
    header("Location:categorias.php");

    }

?>

<h2>Crear categoría</h2>
<form action="crear_categoria.php" method="post" enctype="multipart/form-data" class="card p-4">
<div class="mb-3">
<label>Nombre de la categoría</label>
<input type="text" name="nombre" value="<?=$nombre?>" class="form-control">
</div>
<button type="submit" value="guardar" name="guardar" class="btn btn-success">Guardar</button>
<a href="categorias.html" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>
</html>
