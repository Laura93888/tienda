<?php
require_once "cabecera.php";

if(isset($_SESSION["id_user"])){
  header("Location: index.php");
}//asi si ya tengo sesion iniciada me lleva al index

$banderaerror=False;

$usuarioerror="";
$usuario="";
if(isset($_POST["usuario"])){
    $usuario=htmlentities($_POST["usuario"]);
    if($usuario==""){
        $usuarioerror="El campo no puede estar vacio";
        $banderaerror=True;
    }else if($bbdd->usuarioexiste($usuario)==true){ //Compruebo que el usuario metido no exista para que no se repita el nombre
        $usuarioerror="Este usuario ya existe prueba otro nombre";
        $banderaerror=True;
    }
}

$contraseña="";
$contraerror="";
if(isset($_POST["contraseña"])){
    $contraseña=htmlentities($_POST["contraseña"]);
    if($contraseña==""){
        $contraerror="El campo no puede estar vacio";
        $banderaerror=True;
    }
}

if($banderaerror==False&&isset($_POST["enviar"])){
    $bbdd->RegistrarUsuario($usuario,$contraseña);
    header("Location: login.php"); //Me voy al inicio de sesion cuadno me registro
}

?>
    <header class="account-hero">
        <div class="container px-4 px-lg-5">
            <div class="account-hero__intro">
                <p class="category-hero__eyebrow">Únete a Nuvia</p>
                <h1>Crea tu<br><em>cuenta.</em></h1>
                <p class="account-hero__text">Guarda tus favoritos y disfruta de una compra sencilla, pensada para ti.</p>
            </div>

            <form class="account-form" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                <div class="account-form__heading">
                    <p class="section-kicker">Empieza aquí</p>
                    <h2>Regístrate</h2>
                </div>

                <div class="account-form__field">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Escribe tu usuario" value="<?=$usuario?>">
                    <?php if($usuarioerror!=""){ ?><p class="account-form__error"><?=$usuarioerror?></p><?php } ?>
                </div>

                <div class="account-form__field">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Crea una contraseña">
                    <?php if($contraerror!=""){ ?><p class="account-form__error"><?=$contraerror?></p><?php } ?>
                </div>

                <input class="account-form__submit" type="submit" value="Crear cuenta" name="enviar">
                <p class="account-form__login">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
            </form>
        </div>
    </header>

  <?php
        include_once("pie.php");
        ?>