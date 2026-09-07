<?php
$titulo="Editar usuario";
require_once("cabecera.php");

$banderaerror=False;


$nombreus="";
$nombreuserror="";
if(isset($_POST["nombreus"])){
    $nombreus=htmlentities($_POST["nombreus"]);
    if($bbdd->usuarioexiste($nombreus)){ 
        $nombreuserror="El nombre de usuario ya existe";
        $banderaerror=True;
    }if($nombreus==""){
        $nombreuserror="El campo no puede estar vacio";
        $banderaerror=True;
    }else if(strlen($nombreus)>40){
        $nombreuserror="no puede exceder de 40 caracteres";
         $banderaerror=True;
    }
}

//Guardo el rol cuando me llegue que será cuando le doy a guardar al formulario
if(isset($_POST["rolus"])){
    //No doy error en el rol porque no he dado la opcion vacia solo se puede cambiar de admin a user
    $rol=$_POST["rolus"];
}
//SIEMPRE guarda el id de neuvo cuando estés editando, ademas de los valores
if(isset($_POST["idus"])){
    $idus=$_POST["idus"];
}

//accedemos a los valores del usuario SOLO cuando venimos del enlace de editar(GET), la primera vez (asi los tenemos para mostrarlos y luego enviarlos)
if(isset($_GET["idus"])){
    $idus=$_GET["idus"];
    $usuario=$bbdd->mostrarus($idus);
    $nombreus=$usuario["usuario"];
    $rol=$usuario["rol"];
}

//Si le he dado a guardar y no ha habido error en el nombre entra aquí con los valores que tenga
if(isset($_POST["guardar"])&&$banderaerror==False){
    $bbdd->editarus($idus,$nombreus,$rol);
    //header("Location:usuarios.php");

}

?>

<h2>Editar usuario</h2>
<form action="editar_usuario.php" method="post" enctype="multipart/form-data" class="card p-4">
<div class="mb-3">
<input type="text" name="nombreus" class="form-control" value="<?=$nombreus?>">
<p><?= $nombreuserror?></p>
<label>Rol</label>
        <select name="rolus" class="form-select">
        <option value="1"
        <?php
        //Cuando el rol desplegable coincida con el usuario que se este editando lo seleccionara para que no se pierda
        if ($rol == 1) {
          echo 'selected';
        }
        ?>
        >Administrador</opcion>
        <option value="0"
        <?php
        //Cuando el rol desplegable coincida con el usuario que se este editando lo seleccionara para que no se pierda
        if ($rol == 0) {
          echo 'selected';
        }
        ?>
        >Usuario</opcion>
        </select>
  <!-- SIEMPRE VOLVER A ENVIAR DATOS -->
  <input type="hidden" name="idus" value="<?=$idus?>">
</div>
<button type="submit" value="guardar" name="guardar" class="btn btn-primary">Guardar cambios</button>
<a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>
</html>