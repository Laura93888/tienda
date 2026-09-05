<?php
$titulo="Productos";
require_once("cabecera.php");
//Mostramos todos los usuarios
$usuarios=$bbdd->mostrarusuarios();

?>

<h2>Gestión de Usuarios</h2>
<table class="table">
<tr><th>ID</th><th>Nombre</th><th>Rol</th><th>Acciones</th></tr>
<?php
foreach($usuarios as $us){
  if($us["rol"]==0){
    $rol="Usuario";
  }else{
    $rol="Administrador";
  }
?>
  <tr>
<td><?=$us["id_user"]?></td><td><?=$us["nombre"]?></td><td><?=$rol?></td>
<td><a href="editar_usuario.php?idus=<?=$us["id_user"]?>"><button class="btn btn-sm btn-warning">Editar</button></a></td>
</tr>
<?php
}
?>
</table>

</main>
</div>
</body>
</html>
