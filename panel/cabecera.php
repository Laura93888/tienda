<?php
//TENGO QUE INICIAR LA SESIÓN SIEMPRE DONDE VAYA A USARLA
session_start();
//Tengo que utilizar las funciones las llamo
require_once("../funciones.php");
//inicio mi nueva bbdd para usar las funciones
$bbdd= new db("localhost",3306,"Tienda1","root","");

//si se ha iniciado sesión guardo la info de mi usuario
if(isset($_SESSION["id_user"])){
    $iduser=$_SESSION["id_user"]; //Tengo el id de usuario en todas mis pag por la cabecera, es lo primero que saco 

    //si tengo sesión iniciada pero no soy admin me redirige (lo veo gracias a mi session rol)
    if(($_SESSION["rol"]==0)){
        header("Location:../index.php");
    }

//Si no tengo sesión iniciada también me redirijo (no debo poder entrar si no soy admin)
}else{
    header("Location:../index.php");
}

//Listo las categorias ya que las voy a usar en varias páginas del panel
$categorias=$bbdd->listarcat();

//FORMULARIO PARA PAGINAS DE CREAR Y EDITAR PRODUCTO
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

//Esta solo sirve para el formulario de crear y editar producto,(post) los desplegables
$idcat="";
$errorcat="";
if(isset($_POST["cat"])){
    if($_POST["cat"]=="") {
        $errorcat="Debes seleccionar una categoria";
        $banderaerror=True;
    }else{
        $idcat=$_POST["cat"];
    }
}

//funcion SUBSTR para romper cadenas substr(cadena, indiceinicio, indicefinal),
$precio=0;
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

$stock=0;
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

$ventas=0;
$ventaserror="";
if(isset($_POST["ventas"])){
    $ventas=htmlentities($_POST["ventas"]);
    if($ventas==""){
        $ventaserror="El campo no puede estar vacio";
        $banderaerror=True;
    } else if (!is_numeric($ventas)) {
        $ventaserror = "Debe ser un número";
        $banderaerror = true;
    }else if($ventas<=0){
        $ventaserror = "Las ventas deben ser un numero entero positivo";
    }
}

$descripcion="";
$descripcionerror="";
$descripcionestiloerror="";
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

$nombreimagen="";
if(isset($_FILES["nombreimagen"])){//comprueba que se ha enviado el formulario
	if(is_uploaded_file($_FILES["nombreimagen"]["tmp_name"])){ //comprueba que se ha subido la imagen
		
    //este es solo para guardar en la bbd lo usaremos despues
    $nombreimagen = $_FILES["nombreimagen"]["name"]; 
    
    //aqui es donde quiero mover mi imagen
    $destinoimagen= "../img/".$_FILES["nombreimagen"]["name"];

		move_uploaded_file($_FILES["nombreimagen"]["tmp_name"],$destinoimagen); //muevo la imagen a La ruta 
    }
    //no pongo error si no se hace porque quiero que sea opcional
            
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$titulo?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="admin-style.css">
</head>
<body>
<div class="d-flex">
<nav id="sidebar">
  <div class="sidebar-brand"><i class="bi bi-shop"></i> Admin</div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
    <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>
    <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
    <li class="nav-item"><a class="nav-link" href="carritos.php">Carritos</a></li>
  </ul>
</nav>
<main class="content">