<?php
$titulo="Editar producto";
require_once("cabecera.php");

//Aqui solo entra la primera vez que llegue a editar para que se muestren los valores del prod a editar en el formulario (luego ya se pasaran en post)
if(isset($_GET["idprod"])){ 

    $idprod=$_GET["idprod"];
    
    $producto=$bbdd->obtenerproducto($idprod);

        $nombre=$producto["nombre"];
        $precio=$producto["Precio"];
        $stock=$producto["Stock"];
        $nombreimagen=$producto["Imagen"];
        $descripcion=$producto["Descripcion"];
        $idcat=$producto["id_cat"];
        $ventas=$producto["Ventas"];
    
}

//todos los valores que me lelguen despues del post los reocojo en la cabecera en las validaciones

//Asi tengo el id prod siempre
if(isset($_POST["idprod"])){ 
  $idprod=$_POST["idprod"];
}

if(isset($_POST["guardaredicion"])&&$banderaerror==false){
  
  $bbdd->editarprod($idprod,$nombre,$descripcion,$stock,$nombreimagen,$precio,$ventas);
  
  header("Location:productos.php");
}

?>


<h2>Editar producto</h2>
<form action="editar_producto.php" method="post" enctype="multipart/form-data" class="card p-4">
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
    <option value="<?=$cat["id_cat"]?>" 
      <?php
      //Cuando la categoria del desplegable coincida con la que se este editando la seleccionara para que no se pierda
      if ($idcat == $cat["id_cat"]) {
          echo 'selected';
      }
      ?>
    ><?=$cat["nombre"]?></option>
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
      <input name="ventas" type="number" class="form-control" value="<?=$ventas?>">
      <p><?= $ventaserror?></p>
    </div>
  </div>

  <!-- La tercera caja de mi formulario tiene la descripción-->
  <div class="mb-3">
  <label>Descripción</label>
  <textarea name="descripcion" class="form-control"><?=$descripcion?></textarea>
  <p><?= $descripcionerror?></p>
  </div>

  <!-- Siempre envio el id de nuevo -->
  <input type="hidden" name="idprod" value="<?=$idprod?>">
 
 <button type="submit" value="guardaredicion" name="guardaredicion" class="btn btn-success">Guardar cambios</button>
  <!-- Si le doy a cancelar vuelvo a mi panel de productos-->
  <a href="productos.php" class="btn btn-secondary">Cancelar</a>
</form>

</main>
</div>
</body>
</html>
