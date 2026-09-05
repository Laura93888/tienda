<?php
//este titulo lo uso en la cabecera por eso lo necesito que es diferente en cada pag
$titulo="Dashboard";
require_once("cabecera.php");

//Vamos a sacar el total de prod
$todosproductos=$bbdd->cuatromasvendidos();
$numprod=count($todosproductos);

//Vamos a sacar el total de categorias
$categorias=$bbdd->listarcat();
$numcat=count($categorias);

//Vamos a sacar el total de usuarios
$usuarios=$bbdd->mostrarusuarios();
$numusu=count($usuarios);

//vamos a sacar el total de carritos
$numcarritos=$bbdd->contarcarritos();


?>

<h2>Dashboard</h2>
<div class="row">
  <div class="col-md-3"><div class="card p-3">Productos<br><strong><?=$numprod?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Categorías<br><strong><?=$numcat?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Usuarios<br><strong><?=$numusu?></strong></div></div>
  <div class="col-md-3"><div class="card p-3">Carritos activos<br><strong><?=$numcarritos?></strong></div></div>
</div>

</main>
</div>
</body>
</html>
