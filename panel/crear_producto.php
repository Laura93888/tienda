<?php
$titulo="Crear producto";
include_once("cabecera.php");


//Si le doy a guardar y no hay error entra aqui
if((isset($_POST["guardar"]))&&($banderaerror==False)){

        $productos=$bbdd->mostrarprodycat();
        $idmax=0;
        //busco el id mas grande de mi lista de prod
        foreach($productos as $producto){
            if($idmax<$producto["ID"]){
                $idmax=$producto["ID"];
            }
        }
        $idnuevo=$idmax+1;

    $bbdd->anadirprod($idnuevo,$nombre,$descripcion,$stock,$nombreimagen,$precio,$idcat,$ventas);

    $nombre="";
    $precio="";
    $stock="";
    $nombreimagen="";
    $descripcion="";
    $idcat="";

}

//Vuelvo a obtener la lista de productos que esta actualizada si algo se ha modificado para poder mostrarla
$productos=$bbdd->mostrarprodycat();

?>

<h2>Crear producto</h2>
  <form action="crear_producto.php" method="post" enctype="multipart/form-data" class="card p-4">
  <!-- La primera caja de mi formulario tiene el nombre y la cateogira-->
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nombre</label>
      <input name="nombre" value="<?=$nombre?>" class="form-control">
      <p><?= $nombreerror?></p>
    </div>
    <div class="col-md-6 mb-3">
      <label>Categoría</label>
        <select name="cat" class="form-select">
          <option value="">Elige una categoria</opcion>
          <?php
          foreach($categorias as $cat){
          ?>
          <option value="<?=$cat["id_cat"]?>"><?=$cat["nombre"]?></option>
          <?php
          }
          ?>
          <p><?= $errorcat?></p>
        </select>
    </div>
  </div>

  <!-- La segunda caja de mi formulario tiene el precio, stock y ventas-->
  <div class="row">
    <div class="col-md-4 mb-3">
      <label>Precio</label>
      <input name="precio" value="<?=$precio?>" type="number" class="form-control">
      <p><?= $precioerror?></p>
    </div>
    <div class="col-md-4 mb-3">
      <label>Stock</label>
      <input name="stock" value="<?=$stock?>" type="number" class="form-control">
      <p><?= $stockerror?></p>
    </div>
    <div class="col-md-4 mb-3">
      <label>Ventas</label>
      <input name="ventas" type="number" class="form-control" disabled value="0">
      <p><?= $ventaserror?></p>
    </div>
  </div>

  <!-- La tercera caja de mi formulario tiene la descripción-->
  <div class="mb-3">
  <label>Descripción</label>
  <textarea name="descripcion" value=<?=$descripcion?> class="form-control"></textarea>
  <p><?= $descripcionerror?></p>
  </div>

  <!-- La última caja de mi formulario tiene la insercción de imagen-->
  <div class="mb-3">
  <label>Imagen</label>
  <input name="nombreimagen" value="<?=$nombreimagen?>" type="file" class="form-control">
  </div>

  <button type="submit" value="guardar" name="guardar" class="btn btn-success">Guardar</button>
  <!-- Si le doy a cancelar vuelvo a mi panel de productos-->
  <a href="productos.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>
</html>
