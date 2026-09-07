<?php
include_once("inicio.php");

if(isset($_GET["idcat"])){ //el id de categoria se nos ha pasado desde la cabecera en el desplegable si hemos elegido una categoria
    $idcat=$_GET["idcat"];
    $productos=$bbdd->obtenerproductos($idcat); //Obtengo los productos solo de la categoria marcada
    $categoria=$bbdd->obtenercat($idcat);
    $nombreCategoria=$categoria["nombre"];

}else{
    $productos=$bbdd->mostrarprodycat(); //Si no me pasan id de cat porque he elegido la opcion "todas las cat" muestro todos los prod (estoy usando el mismo nombre)
    $nombreCategoria="todos nuestros productos";
}

$nombreCategoria=htmlspecialchars(strtolower($nombreCategoria), ENT_QUOTES, "UTF-8");

require_once("cabecera.php");

?>
       <!-- Header-->
        <header class="category-hero">
    <div class="container px-4 px-lg-5">
        <div class="category-hero__content">

            <p class="category-hero__eyebrow">Nuestra colección</p>

            <h1>
                <span class="category-hero__discover">Descubre<br><?= $nombreCategoria === "todos nuestros productos" ? "todos" : $nombreCategoria ?></span><br>
                <em><?= $nombreCategoria === "todos nuestros productos" ? "nuestros productos." : "tu nueva colección." ?></em>
            </h1>

        </div>
    </div>
</header>
        <section class="category-products">
            <div class="container px-4 px-lg-5">
                <div class="category-products__heading">
                    <div>
                        <p class="section-kicker">Nuestra selección</p>
                        <h2>Productos para ti</h2>
                    </div>
                    <span class="category-products__count"><?=count($productos)?> productos</span>
                </div>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    foreach($productos as $valor){
                        echo mostrarproducto($valor);
                    }
                    ?>                   
                </div>
            </div>
        </section>
        <?php
        include_once("pie.php");
        ?>
    </body>
</html>