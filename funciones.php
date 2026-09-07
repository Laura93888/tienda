<?php

//Aqui tengo solo las funciones para trabajar con la base de datos
class db{

public $pdo;

public function __construct($host,$port,$db,$user,$pass) { //asi se hacen los constructores, como es un objeto voy a meterlo así, al crear un objeto vacio automaticamente ocurre esto
        $this->pdo = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$db.";charset=utf8", $user, $pass);
    }

//FUNCIONES PARA CATEGORIAS

//Saco la lista de todas las categorias con todos sus datos
function listarcat(){

    $sentencia="SELECT * FROM Categorias";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute();

    $fila=$ejecucion->fetchAll(PDO::FETCH_ASSOC); 

    //array de categorias
    return $fila;
}

//Obtengo solo la info de una categoria(quiero el nombre en panel-categorias.editar)
function obtenercat($idcat){
    $sentencia="SELECT * FROM Categorias WHERE id_cat=:id_cat";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute([
        ":id_cat" => $idcat
    ]);

    $fila=$ejecucion->fetch(PDO::FETCH_ASSOC); 

    return $fila;
}

//Modificar nombre de la cat para el panel
function editarcat($idcat,$nombre){
    $sentencia="UPDATE categorias SET nombre = :nombre WHERE id_cat = :id_cat";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id_cat" => $idcat,
        ":nombre" => $nombre
    ]);

}

//añadir categoria a la bbdd para el panel
function anadircat($idnuevo,$nombre){
    $sentencia="INSERT INTO categorias VALUES (:id, :nombre)";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id" => $idnuevo,
        ":nombre" => $nombre
    ]);
}

function borrarcat($idcat){

    $sentencia="DELETE FROM categorias WHERE id_cat = :id_cat";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id_cat" => $idcat,
    ]);

}

//FUNCIONES PARA MOSTRAR PRODUCTOS

//obtengo todos los productos de una categoria concreta con su id
function obtenerproductos($idcat){
    $sentencia="SELECT * FROM Productos WHERE id_cat=:id_cat";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute([
        ":id_cat" => $idcat
    ]);

    $fila=$ejecucion->fetchAll(PDO::FETCH_ASSOC); 

    return $fila;
}

//Saco toda la info de todos los productos y también el nombre de la categoria
public function mostrarprodycat(){
    $sentencia="SELECT p.*, c.nombre AS nombre_categoria FROM Productos p JOIN Categorias c WHERE p.id_cat = c.id_cat";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute();

    $filas=$ejecucion->fetchAll(PDO::FETCH_ASSOC); 

    return $filas;
}

//Saco TODOS los productos ORDENADOS por ventas (mas vendidos para el index)
function cuatromasvendidos(){

    $sentencia="SELECT * FROM Productos ORDER BY ventas DESC";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute();

    $fila=$ejecucion->fetchAll(PDO::FETCH_ASSOC); 

    return $fila;

}

//Saco toda la informacion de un producto concreto con su id
function obtenerproducto($id){
    $sentencia="SELECT * FROM Productos WHERE ID=:id";
    $ejecucion=$this->pdo->prepare($sentencia);
    $ejecucion->execute([
        ":id" => $id
    ]);

    $fila=$ejecucion->fetch(PDO::FETCH_ASSOC); 

    return $fila;
}

//FUNCIONES PARA EL USUARIO

//compruebo si el nombre de usuario ya existe(para el registro no repetir nombres)
public function usuarioexiste($nombre){

    $sentencia="SELECT COUNT(*) as cantidad FROM Usuarios WHERE usuario = :usuario";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $nombre
    ]);

    //se guarda la cantidad de veces que aparece ese nombre en la tabla(0 o 1)
    $res=$ejecuccion->fetch(PDO::FETCH_ASSOC);

    if($res["cantidad"]==0){
		return False;
	}else{
		return True;
	}
}

//añadir usuario a la bbdd(desde registro)
public function RegistrarUsuario($nombre,$contraseña){
    $contracifrada=password_hash($contraseña, PASSWORD_DEFAULT);

    $sentencia="INSERT INTO Usuarios (usuario, contrasea) VALUES (:usuario, :hash)";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $nombre,
        ":hash" => $contracifrada
    ]);

}

//Obtener el id a partir del nombre de usuario, como no hay dos nombres de usuario iguales puedo hacer esto (para el login, iniciar sesion)
public function ObtenerID($usuario){

    $sentencia="SELECT id_user FROM Usuarios WHERE usuario = :usuario";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $usuario
    ]);    

    $id = $ejecuccion->fetch(PDO::FETCH_ASSOC);
    
    return $id["id_user"];

}

//mostrar todos los usuarios de la bbdd y sus atributos (para el panel-usuarios  y panel-dashboard)
public function mostrarusuarios(){

    $sentencia="SELECT * FROM Usuarios";
	$ejecucion=$this->pdo->prepare($sentencia);
	$ejecucion->execute();
	$res=$ejecucion->fetchAll(PDO::FETCH_ASSOC); //Aqui esta guardada la contraseña de mi usuario

    return $res;
}

//funcion para mostrar un usuario y sus datos para usarlo y editarlo (en cabecera normal, y en panel dashboard y usuarios, editarus)
public function mostrarus($idus){

    $sentencia="SELECT * FROM Usuarios WHERE id_user=:idus";
	$ejecucion=$this->pdo->prepare($sentencia);
	$ejecucion->execute([
        ":idus"=>$idus
    ]);
	$res=$ejecucion->fetch(PDO::FETCH_ASSOC); //Aqui esta guardado mi usuario

    return $res;

}

//funcion para editar el usuario (panel-usuarios-editar)
public function editarus($idus,$nombre,$rol){

    $sentencia="UPDATE Usuarios SET usuario=:usuario, rol=:rol WHERE id_user=:idus";
	$ejecucion=$this->pdo->prepare($sentencia);
	$ejecucion->execute([
        ":usuario"=>$nombre,
        ":rol"=>$rol,
        ":idus"=>$idus
    ]);
}

//comprobar si la contraseña es correcta(para hacer login)
public function comprobarcontra($nombre,$pass){
        $sentencia="SELECT contrasea FROM Usuarios WHERE usuario=:usuario";
		$ejecucion=$this->pdo->prepare($sentencia);
		$ejecucion->execute([
            ":usuario" => $nombre
		]);
		$res=$ejecucion->fetch(PDO::FETCH_ASSOC); //Aqui esta guardada la contraseña de mi usuario
        if($res && password_verify($pass,$res["contrasea"])){ //hace al contrario descrifra la contraseña
			return True;
		}else{
			return False;
		}
	}

//funciones para INTENTOS (login)

public function Obtenerintentos($usuario){

    $sentencia="SELECT intentos FROM Usuarios WHERE usuario = :usuario"; //sacamos los intentos del usuario del login
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $usuario
    ]);

    $fila = $ejecuccion->fetch(PDO::FETCH_ASSOC); //si no estuviera este usuario esta consulta da vacia por lo que daría falso
    $intentos=$fila["intentos"];
    return $intentos;
}
public function IncrementarIntentos($usuario){

    $sentencia="UPDATE Usuarios SET intentos = intentos+1 WHERE usuario = :usuario";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $usuario
    ]);

}
public function ResetearIntentos($usuario){

    $sentencia="UPDATE Usuarios SET intentos = 0 WHERE usuario = :usuario";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":usuario" => $usuario
]);

}

//FUNCIONES DEL CARRITO

//comprueba si un usuario tiene un prod en la cesta
public function comprobarsiesta($iduser,$idpro){ 
    $sentencia="SELECT COUNT(*) as cantidad FROM carrito WHERE id_usuario = :iduser AND id_producto = :idpro";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":iduser" => $iduser,
        ":idpro" => $idpro
    ]);    

    $cant = $ejecuccion->fetch(PDO::FETCH_ASSOC); //me saca un cantidad => valor con el nº de veces que de la consulta (1 si esta o 0 si no)
    
    return $cant["cantidad"];
}

//Cuento el numero de usuarios que tienen algun carrito activo(panel,dashboard)
public function contarcarritos(){

    //La subconsulta da como resultado, para cada usuario que tenga al menos un producto en el carrito, una sola fila con su id_usuario.
    //La consulta externa cuenta el número de filas que devuelve la subconsulta por lo que nos da el número de usuarios que tienen algun carrito 
    $sentencia="SELECT COUNT(*) AS total FROM (SELECT id_usuario FROM carrito GROUP BY id_usuario) AS usuarios_con_carrito";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute();

    //Cuidado los fetch siempre devuelven un array asociativo indice=valor
    $res = $ejecuccion->fetch(PDO::FETCH_ASSOC); 
    //como hemos llamado "total" al resultado de mi consulta el inidice al que queremos acceder es "total"
    return $res["total"];

}

//sacamos el nombre e id de los usuarios que tienen un carrito, el numero de productos que tiene(panel,carritos), y el precio total de todos sus prodcutos (para panel, carritos)
public function productoscarritousuarios(){

    //Uno el carrito con la tabla usuarios y la tabla productos, luego agrupo por id de usuario y nombre
    $sentencia="SELECT u.usuario AS nombre, c.id_usuario, COUNT(c.id_producto) AS total, SUM(c.cantidad*p.precio) AS precio
    FROM carrito c 
    JOIN Usuarios u ON u.id_user=c.id_usuario
    JOIN Productos p ON c.id_producto=p.id 
    GROUP BY c.id_usuario,u.usuario"; //tengo que poner en el group by todo lo que quiera mostrar que no este en consulta count,sum...

    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute();

    //Cuidado los fetch siempre devuelven un array asociativo indice=valor
    $res = $ejecuccion->fetchAll(PDO::FETCH_ASSOC); 
    //en este resultado esta guardado el total y el id_usuario de cada usuario que tenga carrito
    return $res;

}

//Cuenta el numero de productos que tiene un usuario concreto en la tabla carritos(en cabecera para carrito)
public function numprodcarrito($iduser){

    $valores=$this->infoCarritoSesion($iduser);
    $numarticulos=count($valores);
    return $numarticulos;

}

//Saca la información del carrito de un usuario concreto, (en cabecera para carrito)
public function infoCarritoSesion($iduser){
    $sentencia="SELECT * FROM carrito WHERE id_usuario = :iduser";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":iduser" => $iduser,
    ]);
    //saca todos los productos del carrito de un usuario concreto
    $valores = $ejecuccion->fetchAll(PDO::FETCH_ASSOC); 
    return $valores;
}

//Crea el carrito con todos los datos cuando no existe
public function crearcarrito($idus,$idpro,$cant){ //Crea el carrito con todos los datos cuando no existe

    $sentencia="INSERT INTO carrito (id_usuario,id_producto,cantidad) VALUES (:id_usuario,:id_producto,:cantidad)";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id_usuario" => $idus,
        ":id_producto" => $idpro,
        ":cantidad" => $cant
    ]);

}

//Si el usuario tiene ya el producto sumamos la cantidad añadida AL CARRITO
public function sumarcantidad($cant,$iduser,$idpro){ 
    $sentencia="UPDATE carrito SET cantidad = cantidad + :cant WHERE id_usuario = :iduser AND id_producto = :idpro";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":cant" => $cant,
        ":iduser" => $iduser,
        ":idpro" => $idpro
    ]);

}

//Eliminar el producto del carrito (en cabecera para carrito)
public function eliminarprocarrito($id_carrito, $iduser){

    $sentencia="DELETE FROM carrito WHERE id_carrito = :id_carrito AND id_usuario = :iduser";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id_carrito" => $id_carrito,
        ":iduser" => $iduser,
    ]);

}

//quita todos los productos del carrito de un usuario(borra todas las ocurrencias de la tabla carrito donde el id de usuario sea el que ha iniciado sesion)
public function vaciarcarrito($iduser){

    $sentencia="DELETE FROM carrito WHERE id_usuario = :id_usuario";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":id_usuario" => $iduser,
    ]);

}


//FUNCIONES PARA AÑADIR,ELIMINAR Y EDITAR PROD

//eliminar producto de la bbdd
public function eliminarprod($idprod){

    $sentencia="DELETE FROM Productos WHERE ID = :idprod";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":idprod" => $idprod,
    ]);

}

//editar producto de la bbdd
public function editarprod($ideditar,$nombre,$desc,$stock,$img,$precio,$ventas){

    $sentencia="UPDATE Productos SET nombre = :nombre, Precio=:precio, Descripcion=:descripcion, Stock=:stock, Imagen=:imagen, Ventas=:ventas WHERE ID = :idprod";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":idprod" => $ideditar,
        ":nombre" => $nombre,
        ":descripcion" => $desc,
        ":stock" => $stock,
        ":imagen" =>$img,
        ":precio" => $precio,
        ":ventas" => $ventas
    ]);

}

public function anadirprod($idprod,$nombre,$desc,$stock,$img,$precio,$idcat){

    $sentencia="INSERT INTO Productos VALUES (:idprod, :nombre, :precio, :stock, :imagen, :descripcion, :ventas, :idcat)";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":idprod" => $idprod,
        ":idcat" => $idcat,
        ":nombre" => $nombre,
        ":descripcion" => $desc,
        ":stock" => $stock,
        ":imagen" =>$img,
        ":precio" => $precio,
        ":ventas" => 0 
    ]);

}

//restar stock de un producto concreto (Aun no esta implementada hay que hacerlo cuando finalice compra)
public function quitarstock($idprod,$cant){

    $sentencia="UPDATE Productos SET Stock = Stock-:cant WHERE ID = :idprod";
    $ejecuccion=$this->pdo->prepare($sentencia);
    $ejecuccion->execute([
        ":idprod" => $idprod,
        ":cant" => $cant
    ]);

}

}

?>