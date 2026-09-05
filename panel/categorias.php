<?php
$titulo="Categorias";
require_once("cabecera.php");

//eliminamos producto de la bbdd si hemos pinchado en el enlace de eliminar(GET)
if(isset($_GET["idcat"])){
    $idcat=$_GET["idcat"];
    $bbdd->borrarcat($idcat);
   
}
//como las he tocado necesito volver a sacarlas no me sirven las de la cabecera
$categorias=$bbdd->listarcat();

?>
<h2>Gestión de Categorías</h2>
<a href="crear_categoria.php"><button class="btn btn-primary mb-3">Nueva categoría</button></a>
<table class="table">
<tr><th>ID</th><th>Nombre</th><th>Productos</th><th>Acciones</th></tr>
<?php foreach($categorias as $cat){
  $prod=$bbdd->obtenerproductos($cat["id_cat"]);
  $numprod=count($prod);
?>
<tr><td><?=$cat["id_cat"]?></td><td><?=$cat["nombre"]?></td><td><?=$numprod?></td>
<td><a href="editar_categoria.php?idcat=<?=$cat["id_cat"]?>"><button class="btn btn-sm btn-warning">Editar</button></a>
<a href="categorias.php?idcat=<?=$cat["id_cat"]?>"><button class="btn btn-sm btn-danger">Eliminar</button></td></tr>
<?php
}
?>
</table>

</main>
</div>
</body>
</html>
