<?php
$titulo="Carritos";
require_once("cabecera.php");

if(isset($_GET["vaciarcarrito"])){
    $iduser=$_GET["iduser"];
    $bbdd->vaciarcarrito($iduser);

}

//esta consulta saca todo lo que necesito 
$carritosporus=$bbdd->productoscarritousuarios();

?>


<h2>Gestión de Carritos</h2>
<table class="table">
<tr><th>ID</th><th>Usuario</th><th>Productos</th><th>Total</th><th>Acciones</th></tr>
<?php
foreach($carritosporus as $car){
?>
<tr>

<td><?=$car["id_usuario"]?></td><td><?=$car["nombre"]?></td><td><?=$car["total"]?></td><td><?=$car["precio"]?></td>
<td><button class="btn btn-sm btn-info">Ver</button>
<a href="carritos.php?vaciarcarrito=si&iduser=<?=$car["id_usuario"]?>"><button class="btn btn-sm btn-danger">Vaciar</button></a></td>
</tr>
<?php
};
?>
</table>

</main>
</div>
</body>
</html>
