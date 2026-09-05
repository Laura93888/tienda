<?php
$titulo="Editar categoria";
include_once("cabecera.php");


$nombrecat="";
$errorcat="";
if(isset($_POST["nombrecat"])){
    if($_POST["nombrecat"]=="") {
        $errorcat="Debes escribir una categoria";
        $banderaerror=True;
    }else{
        $nombrecat=$_POST["nombrecat"];
    }
}

//Aqui entra cuando viene del enlace de editar categoria del panel-categorias
if(isset($_GET["idcat"])){
  $idcat=$_GET["idcat"];

  $categoria=$bbdd->obtenercat($idcat);
  //Sacamos el Nombre de la cat a editar para la 1º vez
  $nombrecat=$categoria["nombre"];

}
//siempre nos quedamos con el id de la categoria
if(isset($_POST["idcat"])){
  $idcat=$_POST["idcat"];
}

if(isset($_POST["guardar"])&&$banderaerror==False){

  $bbdd->editarcat($idcat,$nombrecat);
  header("Location:categorias.php");
}

?>

<h2>Editar categoría</h2>
<form action="editar_categoria.php" method="post" enctype="multipart/form-data" class="card p-4">
<div class="mb-3">
<input type="text" name="nombrecat" class="form-control" value="<?=$nombrecat?>">
  <!-- SIEMPRE VOLVER A ENVIAR DATOS -->
  <input type="hidden" name="idcat" value="<?=$idcat?>">
</div>
<button type="submit" value="guardar" name="guardar" class="btn btn-primary">Guardar cambios</button>
<a href="categorias.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>
</html>
