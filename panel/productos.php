<?php
$titulo="Productos";
require_once("cabecera.php");

//eliminamos producto de la bbdd si hemos pinchado en el enlace de eliminar(GET)
if(isset($_GET["ideliminar"])){
    $ideliminar=$_GET["ideliminar"];
    $bbdd->eliminarprod($ideliminar);
   
}

//Sacamos los productos para mostrarlos, despues de eliminarlo para ue este actualizado
$productos=$bbdd->mostrarprodycat();

?>

<h2>Gestión de Productos</h2>

<!-- Un enlace con forma de botón para crear nuevo producto-->
<a href="crear_producto.php"><button class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Nuevo producto</button></a>

<table class="table table-hover">
<thead>
    <tr>
        <th>ID</th>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Ventas</th>
        <th>Acciones</th>
    </tr>
</thead>
<tbody>
    <?php
    foreach($productos as $prod){
        //Para la imagen me estoy llendo una carpeta atras para que funcione la ruta
    ?>
    <tr>
        <td><?=$prod["ID"]?></td>
        <td>
        <?php
        if($prod["Imagen"]!=""){
            echo "<img src='../img/".$prod['Imagen']."'>";
        }
        ?>
        </td>
        <td><?=$prod["nombre"]?></td><td><?=$prod["nombre_categoria"]?></td>
        <td><?=$prod["Precio"]?>€</td>
        <td><?=$prod["Stock"]?></td>
        <td><?=$prod["Ventas"]?></td>
        <td>
            <a href="editar_producto.php?idprod=<?=$prod["ID"]?>"><button class="btn btn-sm btn-warning">Editar</button></a>
            <a href="productos.php?ideliminar=<?=$prod["ID"]?>"><button class="btn btn-sm btn-danger">Eliminar</button></a>
        </td>
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

</main>
</div>
</body>
</html>
