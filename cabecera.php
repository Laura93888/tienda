<?php
session_start();
include_once("funciones.php");
include_once("funcionesextra.php");

$bbdd = new db("127.0.0.1",3306,"Tienda1","tienda","tienda123");

//CATEGORIAS para hacer el desplegable de la cabecera
$categorias=$bbdd->listarcat(); 

//CERRAR SESION SI ME LLEGA
if(isset($_GET["cerrar"])){ //esto cuando pulse en el boton cerrar sesion me va a redirigir a esta pagina y tendrá este parámetro
    session_destroy();
    header("Location:index.php"); //Aqui me vuelvo a redirigir a esta misma pagina porque si no la cabecera se ha creado
}

//Siempre lo inicio vacio para que no de error
$botonpanel="";
//SI hay sesion saco los datos de usuario
if(isset($_SESSION["id_user"])){
    $iduser=$_SESSION["id_user"]; //Tengo el id de usuario en todas mis pag por la cabecera, es lo primero que saco gracias a la sesion

    //Con el id saco todos los datos que voy a usar
    $usuario=$bbdd->mostrarus($iduser);

    //Si el rol es administrador le muestro el enlace (cuando he iniciado sesión he guardado una sesion con el id y una sesion con el rol, aunque tambien pordira mirarlo en la info del usuario pero me ahorro consultas)
    if(($_SESSION["rol"]==1)){

        $botonpanel="<a class='site-navbar__admin-link' href='./panel/dashboard.php'>Panel Administrador</a>";

    }else{
        $botonpanel=""; 
    }

}

//OBTENGO CONTENIDO del carrito si ya existe la COOKIE
    if(isset($_COOKIE["carrito"])){
        $carrito=json_decode($_COOKIE["carrito"],true); //Con jsondecode ya puedo leer arrays(poner TRUE) -> leo mi carrito de la variale
        
    //CREO LA VARIABLE Si no existe
    }else{
        $carrito=[];
    }
    

//ELIMINAR el prodcuto si me llega eliminar (antes de sacar la variable que los muestra)
if(isset($_POST["eliminar"])){
    $idcarrito=$_POST["id_carrito"]; //Recupero la id de mi carrito que me llega por post porque es un form de la pag carrito

    //si es con SESSION borro de la bbdd
    if(isset($_SESSION["id_user"])){
        $bbdd->eliminarprocarrito($idcarrito); //elimino el carrito para lo que ncesito tanto el producto que es como el usuario al que pertenece (solo puede hacer 1 que lo cumpla)
    
    //Si no hay sesion borro de la COOKIE
    }else{
        $carrito=json_decode($_COOKIE["carrito"],true);
        foreach ($carrito as $pos => $produc){
            if($produc["id_carrito"]==$idcarrito){
                unset($carrito[$pos]); //Elimino el carrito usando la posicion
            }
    }
    //GUARDO COOKIE al terminar de trabajar con ella
        setcookie("carrito", json_encode($carrito), time() + 7*24*60*60, "/");

}
}

//AÑADIR PRODUCTO AL CARRITO
if((isset($_POST["anadirpro"]))){
    //saco cantidad y idpro que me ha llegado de cualquiera de los form de añadir al carrito(esta en funciones extra y en producto)
    $cant=max(1, (int)($_POST["cantidad"] ?? 1));
    $idpro=(int)($_POST["idpro"] ?? 0);

    // CON SESION INICIADA, asi lo hago desde cualquier página que tenga cabecera
    if($idpro>0 && isset($_SESSION["id_user"])){

        //devuelve 1 si el id de prod está para este usuario, 0 si no esta
        $estapro=$bbdd->comprobarsiesta($iduser,$idpro); //Llamamos a la función que comprueba si el usuario tiene ya un carrito de este producto (cada usuario tiene un carrito por cada producto)
        
        if($estapro==1){
            //Si está ya solo sumamos la cantidad
            $bbdd->sumarcantidad($cant,$iduser,$idpro);
        }else if($estapro==0){
            //si no está creamos el carrito
            $bbdd->crearcarrito($iduser,$idpro,$cant);
        }
    
    //SIN SESION INICIADA
    }else if($idpro>0){

        //funcion para añadir un prod al carrito cookies
        anadiralcarritocookie($carrito,$idpro,$cant);

        //GUARDO COOKIE al terminar de trabajar con ella
        setcookie("carrito", json_encode($carrito), time() + 7*24*60*60, "/");

    }

    if($idpro>0){
        header("Location: carrito.php");
        exit;
    }

}

//Aqui tendriamos que tener en cuenta si hay stock de los productos y restarlo
//Elimino todos los productos del carrito
if(isset($_POST["vaciarcarrito"])){

    //si tenemos SESION iniciada llamo a la funcion de la bbdd
    if ((isset($_SESSION["id_user"]))){
        
        $bbdd->vaciarcarrito($iduser);

    //Si no vacio la COOKIe
    }else{
        
        $carrito=[]; 

        //GUARDO COOKIE al terminar de trabajar con ella
        setcookie("carrito", json_encode($carrito), time() + 7*24*60*60, "/");

    }

}


//SACAR numero de productos del carrito y la info al final porque si no cuando borre no estará actualizado(borro antes)

//lo saco asi si tengo sesión
if(isset($_SESSION["id_user"])){
  
     $infocarritos=$bbdd->infoCarritoSesion($iduser); //Lo obtengo de la bbdd

     $cantcarrito=$bbdd->numprodcarrito($iduser);

//Si no hay sesion saco carrito de cookies (Asi tengo la variable infocarritos de todas formas, por eso no uso carrito para no tener que diferenciarlo del de sesion al usarlo)
}else{

    $infocarritos=$carrito; //cookie carrito va a existir siempre porqeu lo he creado

    $cantcarrito=count($carrito); //Cuento el numero de elementos de mi array $carrito

}


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
        <nav class="navbar navbar-expand-lg navbar-light site-navbar">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand site-navbar__brand" href="index.php">
                    <span class="site-navbar__brand-mark">+</span>
                    Nuvia
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="categoria.php">Todos los productos</a></li> <!-- SI no paso id me va a mostrar todos los proructos al hacer clic porque no le llegará nada a la pag categoria-->
                                <?php
                                   
                                    foreach($categorias as $valor){  //recorro para obtener sus valores
                                ?>
                                 <!-- Si hago clic en cualquiera de las categorias sí le llgea el id de la cat a la página categorias-->
                                <li><a class="dropdown-item" href="categoria.php?idcat=<?=$valor["id_cat"]?>"><?=$valor["nombre"]?></a></li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
                        <?php if($botonpanel!=""){ ?>
                            <li class="nav-item site-navbar__admin-item"><?=$botonpanel?></li>
                        <?php } ?>
                    </ul>
                    
                    <?php

                    //Uso usuario porque si tengo iniciada sesion tengo guardados los datos en $usuario, pero puedo usar session[id],
                    if(!isset($usuario)){ //Si no tengo iniciada sesion muestro los botones de inicio de sesion que me redirigen a las páginas correspondientes

                    ?>
                    <div class="site-navbar__actions">
                        <a class="site-navbar__account-link" href="login.php">
                            <i class="bi-person"></i>
                            Iniciar Sesion        
                        </a>
                        <a class="site-navbar__account-button" href="registro.php">
                            Registrarse
                        </a>
                    </div>
                    <?php
                    }else{ //Si tengo iniciada sesion digo hola nombreusuario, utilizado los datos de usuario que me he guardado
                        //Muestro la opcion de cerrar sesion
                    ?>
                        <div class="site-navbar__user">
                            <span>Hola, <strong><?=$usuario["nombre"]?></strong></span>
                            <a class="site-navbar__logout" href="index.php?cerrar=si">Cerrar sesion</a>
                        </div>
                    <?php
                    }
                    //Luego siempre muestro el boton que me lleva al carrito (Este o no registrado) con la cantidad de productos que hay
                    ?>
                     
                        <a href="carrito.php" class="site-navbar__cart">
                            <i class="bi-cart-fill me-1"></i>
                            <span>Carrito</span>
                            <span class="site-navbar__cart-count"><?=$cantcarrito?></span>
                        </a>
                    
                </div>
            </div>
        </nav>
       