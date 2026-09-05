<?php
require_once "cabecera.php";

if(isset($_SESSION["id_user"])){
  header("Location: index.php");
}//asi si ya tengo sesion iniciada me lleva al index


$usuarioerror="";
$contraerror="";
$nombreusuario="";
if(isset($_POST["usuario"])){ //Si existe usuario es que hemos pulsado el boton del formulario (Es lo mismo que comprobar si le hemos dado a enviar)

    $nombreusuario=htmlentities($_POST["usuario"]); //aqui tengo mi nombre de usuario
    $contraseña=$_POST["contraseña"]; //Tambien guardo la contra que me ha tenido que llegar

    if($nombreusuario==""){
        $usuarioerror="El campo no puede estar vacio";
        $banderaerror=True;
    }else if($contraseña==""){
        $contraerror="El campo contraseña no puede estar vacio";

    }else{ //Si ambos campos tienen contenido empiezan las comprobaciones

        if($bbdd->usuarioexiste($nombreusuario)){ //primera comprobacion, me duelve true si este nombre de usuario está en mi base de datos en este caso entro 

            if($bbdd->obtenerIntentos($nombreusuario)<3){ //Segunda comprobación, que no haya bloqueado la cuenta por el numero de intentos

                if($bbdd->comprobarcontra($nombreusuario,$contraseña)){ // Tercera comprobación, ver si la contraseña si no da fallo la contraseña nos devuelve true{
                    
                    session_regenerate_id(True);    //Refresca la sesion dandole un nuevo identificador (Seguridad)
                    $iduser=$bbdd->obtenerID($nombreusuario);

                    //obtengo los datos de usuario para sacar el ROL SIEMPRE GUARDADO EN UNA SESINO cuando se inicie sesion
                    $usuario=$bbdd->mostrarus($iduser); 
                    $_SESSION["rol"]=$usuario["rol"]; 

                    $_SESSION["id_user"]=$iduser;  //Aquí es cuando INICIO LA SESION DEL USUARIO si todo ha sido correcto CON EL ID que he obtenido (me logeo), el valor de la sesion sera el id del usuario
                    
                    $bbdd->resetearIntentos($nombreusuario); //Reseteo los intentos ya que ha conseguido entrar y la proxima vez debe empezar intentos de 0
                    
                    header("Location: index.php"); //mando a la cabecera cuando inicie sesion

			    }else{
                    $contraerror="Contraseña incorrecta"; //Lanzo el error si la contraseña falla
                    $bbdd->incrementarIntentos($nombreusuario);
                }
            }else{
                echo "Usuario bloqueado";
            }

        }else{ //Si el nombre de usuario no está en la base de datos lanza el aviso
            $usuarioerror="Estás intentando entrar con un nombre no registrado";
        }
    }
}
    


?>
    <header class="account-hero">
        <div class="container px-4 px-lg-5">
            <div class="account-hero__intro">
                <p class="category-hero__eyebrow">Qué bueno verte</p>
                <h1>Vuelve a<br><em>Nuvia.</em></h1>
                <p class="account-hero__text">Inicia sesión para continuar descubriendo prendas que encajan contigo.</p>
            </div>

            <form class="account-form" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
                <div class="account-form__heading">
                    <p class="section-kicker">Tu espacio</p>
                    <h2>Inicia sesión</h2>
                </div>

                <div class="account-form__field">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Escribe tu usuario" value="<?=$nombreusuario?>">
                    <?php if($usuarioerror!=""){ ?><p class="account-form__error"><?=$usuarioerror?></p><?php } ?>
                </div>

                <div class="account-form__field">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" id="contraseña" name="contraseña" placeholder="Escribe tu contraseña">
                    <?php if($contraerror!=""){ ?><p class="account-form__error"><?=$contraerror?></p><?php } ?>
                </div>

                <input class="account-form__submit" type="submit" value="Entrar" name="enviar">
                <p class="account-form__login">¿Aún no tienes una cuenta? <a href="registro.php">Regístrate</a></p>
            </form>
        </div>
    </header>
  <?php
        include_once("pie.php");
        ?>