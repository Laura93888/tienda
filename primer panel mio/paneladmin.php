
<?php

include_once("funciones.php");
include_once("funcionesextra.php");

$bbdd= new db("localhost",3306,"Tienda1","root","");

//eliminamos producto si hemos pinchado en el enlace de eliminar(GET)
if(isset($_GET["ideliminar"])){
    $ideliminar=$_GET["ideliminar"];
    $bbdd->eliminarprod($ideliminar);
   
}

//USADO
$banderaerror=False;

$nombre="";
$nombreerror="";
if(isset($_POST["nombre"])){
    $nombre=htmlentities($_POST["nombre"]);
    if($nombre==""){
        $nombreerror="El campo no puede estar vacio";
        $banderaerror=True;
    }else if(strlen($nombre)>40){
        $nombreerror="no puede exceder de 40 caracteres";
         $banderaerror=True;
    }
}

//funcion SUBSTR para romper cadenas substr(cadena, indiceinicio, indicefinal),
$precio="";
$precioerror="";
if(isset($_POST["precio"])){
    $precio=htmlentities($_POST["precio"]);
    if($precio==""){
        $precioerror="El campo no puede estar vacio";
        $banderaerror=True;
    } else if (!is_numeric($precio)) {
        $precioerror = "Debe ser un número";
        $banderaerror = True;
    }else if($precio<=0){
        $precioerror = "El precio debe ser entero positivo";
    }
}

$stock="";
$stockerror="";
if(isset($_POST["stock"])){
    $stock=htmlentities($_POST["stock"]);
    if($stock==""){
        $stockerror="El campo no puede estar vacio";
        $banderaerror=True;
    } else if (!is_numeric($stock)) {
        $stockerror = "Debe ser un número";
        $banderaerror = true;
    }else if($stock<=0){
        $stockerror = "El stock debe ser entero positivo";
    }
}

$descripcion="";
$descripcionerror="";
if(isset($_POST["descripcion"])){
    $descripcion=htmlentities($_POST["descripcion"]);
    if($descripcion==""){
        $descripcionerror="El campo no puede estar vacio";
        $banderaerror=True;
    }else if(strlen($descripcion)<50){
        $descripcionerror="La descripción debe tener mas de 50 caracteres";
        $banderaerror=True;
    }
}

//USADO
$idcat="";
$errorcat="";
if(isset($_POST["categoria"])){
    if($_POST["categoria"]=="") {
        $errorcat="Debes seleccionar una categoria";
        $banderaerror=True;
    }else{
        $idcat=$_POST["categoria"];
    }
}

//Validación de contraseña (IMPLEMENTAR PARA ENTRAR AL PANEL pendiente)
$contraseña=""; //si no la creo luego no sabe que hacer con el value del desplegable!!!
$conterror="";
if(isset($_POST["contraseña"])){
	$contraseña=htmlentities($_POST["contraseña"]);
    $barra=false;
    $mayus=false;
	if($contraseña==""){

		$conterror="Se debe meter contrasera";
		$banderaerror=true;

	}else{

        if (strpos($contraseña, "/") !== false) {
            $barra = true;
        }
        for ($i = 0; $i < strlen($contraseña); $i++) {
            if (ctype_upper($contraseña[$i])) {
                $mayus = true;
            }
        }

         }

        if($barra==false||$mayus==false){
            $banderaerror=true;
            $conterror="Debe tener una mayuscula y una barra";
        }
    }

//CUANDO PULSO ENLACE EDITAR GUARDA TODA LA INFO DEL PRODUCTO ESCOGIDO (con el ideditar) EN LAS VARIABLES PARA MOSTRARLO EN EL FORMULARIO Y PODER CAMBIARLO Y ENVIARLO
//CUANDO PULSO GUARDAR FORMULARIO NO ENTRA AQUI
if(isset($_GET["ideditar"])){ 

    $ideditar=$_GET["ideditar"];
    
    $producto=$bbdd->obtenerproducto($ideditar);

        $nombre=$producto["nombre"];
        $precio=$producto["Precio"];
        $stock=$producto["Stock"];
        $nombreimagen=$producto["Imagen"];
        $descripcion=$producto["Descripcion"];
        $idcat=$producto["id_cat"];
    
}

//CUANDO PULSO GUARDAR ENTRA AQUI SOLO SI VENIA ANTES DE EDITAR (para editar el producto necesito el id que he enviado como un input hidden, los demas datos estan en formulario)
if(isset($_POST["ideditar"])){ 
    $ideditar=$_POST["ideditar"];
}

//CARGA DE IMAGEN (lo hago depsues porque necesito el id a editar)
if(isset($_FILES["fotoproducto"])){//comprueba que se ha enviado el formulario
	if(is_uploaded_file($_FILES["fotoproducto"]["tmp_name"])){ //comprueba que se ha subido la imagen
		$nombreimagen = "img/".$_FILES["fotoproducto"]["name"];
		move_uploaded_file($_FILES["fotoproducto"]["tmp_name"],$nombreimagen); //muevo la imagen a La ruta 
	
    }else if(isset($_POST["ideditar"])){
        $producto=$bbdd->obtenerproducto($ideditar);
        $nombreimagen=$producto["Imagen"];

    }else{//NO pongo error si no se sube porque quiero que sea opcional
            $nombreimagen="";
    }
            
}


//Si he enviado el formulario y no ha habido errores entrro
if((isset($_POST["guardar"]))&&($banderaerror==False)){
 
    if(isset($ideditar)){ //AQUI ENTRA CUANDO ESTE EDITANDO UN PRODUCTO TIENE LOS VALORES NUEVOS Y LOS CAMBIADOS PORQUE SE HABIA ESCRITO TODO EN EL form (EL IDCAT NO SE MODIFICA)

      $bbdd->editarprod($ideditar,$nombre,$descripcion,$stock,$nombreimagen,$precio);

    }else{ //aqui para agregar nuevos productos

        $productos=$bbdd->mostrartodosproductos();
        $idmax=0;
        //busco el id mas grande de mi lista de prod
        foreach($productos as $producto){
            if($idmax<$producto["ID"]){
                $idmax=$producto["ID"];
            }
        }
        $idnuevo=$idmax+1;

    $bbdd->anadirprod($idnuevo,$nombre,$descripcion,$stock,$nombreimagen,$precio,$idcat);

    $nombre="";
    $precio="";
    $stock="";
    $nombreimagen="";
    $descripcion="";
    $idcat="";
    }
}

//Vuelvo a obtener la lista de productos que esta actualizada si algo se ha modificado para poder usarla
$productos=$bbdd->mostrartodosproductos();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Pagina de inicio</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Menu de navegacion por categorias-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="paneladmin.php">Panel Administrador</a>
            </div>
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Salir</a>
            </div>
        </nav>

<main>
<section style="display:flex;gap:18px;align-items:flex-start">
<div style="flex:1">
<!-- MOSTRAMOS LOS PRODUCTOS QUE HAY EN LA BBDD-->
<h2>Productos</h2>
<table class="table">
    <thead>
        <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        <?php
        foreach($productos as $producto){
            ?>
        <tr>
            <td><?=$producto["ID"]?></td>
            <td><?=$producto["nombre"]?></td>
            <td><?=$producto["Precio"]?> €</td>
            <td><?=$producto["Stock"]?></td>
            <td>
            <div class="row">
            <a href="paneladmin.php?ideditar=<?=$producto["ID"]?>">Editar</a>
            <a href="paneladmin.php?ideliminar=<?=$producto["ID"]?>">Eliminar</a>
            </div>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
</div>

    <!-- CREAMOS EL FORMULARIO PARA CREAR Y EDITAR PRODUCTO -->
<aside style="width:380px">
<div class="card">
<h3>Crear / Editar producto</h3>
  <form action="paneladmin.php" method="post" enctype="multipart/form-data">
            
            <div class="form-row">
                <input class="input" type="text" name="nombre" placeholder="Nombre" value="<?=$nombre?>">
                <p><?= $nombreerror?></p>
                <input class="input" type="number" step="0.01" name="precio" placeholder="Precio" value="<?= $precio?>">
                <p><?= $precioerror?></p>
            </div>

            <div style="margin-top:10px">
                <input type="file" name="fotoproducto"/>
            </div>

            <div style="margin-top:10px">
                <input class="input" type="number" name="stock" placeholder="Stock" value="<?= $stock?>">
                <p><?= $stockerror?></p>
            </div>

            <div style="margin-top:10px">
                <textarea class="input" name="descripcion" rows="4" placeholder="Descripción"><?= $descripcion?></textarea>
                <p><?= $descripcionerror?></p>
            </div>

            <!-- Despplegable de categorias-->
            <div style="margin-top:10px">
                <label>Categoria:</label>
                <select name="categoria">
                    <option value="">--Seleccione una categoria--</option>
                    <?php 
                     $categorias = $bbdd->mostrartodascategorias();
                        foreach($categorias as $cat){ 
                    ?>
                        <option value="<?= $cat["id_cat"] ?>" 
                        <?php
                        //Cuando la categoria del desplegable coincida con la que se este editando la seleccionara para que no se pierda
                        if ($idcat == $cat["id_cat"]) {
                            echo 'selected';
                        }
                        ?>
                        ><?=$cat["nombre"]?></option>

                    <?php }; ?>
                </select>
                <p><?=$errorcat?></p>
            </div>

            <!-- Vuelvo a enviar este valor si vengo del enlace de editar por lo que tengo el id del producto que voy a editar para enviarlo con el form-->
            <?php if (isset($_GET["ideditar"])) { ?> 
                <input type="hidden" name="ideditar" value="<?=$_GET["ideditar"]?>">
            <?php } ?>

            <div style="margin-top:12px" class="row">
                <!-- Botón tipo submit para enviar el formulario -->
                 <input type="submit" value="Guardar" name="guardar"/> 
                <!-- Botón tipo reset para limpiar campos -->
                <button type="reset" class="btn btn-ghost">Limpiar</button>
            </div>

        </form>
</div>
</aside>
</section>
</main>

    </body>
<?php
include_once("pie.php");
?>