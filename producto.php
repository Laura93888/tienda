<?php


if(!isset($_GET["id"])){  //Si no me ha llegado id de producto que mostrar redirijo al index
    header("Location:index.php");

}else{
    
    include_once("cabecera.php");
    $id=$_GET["id"];
    $producto=$bbdd->obtenerproducto($id); //obtengo todos los datos del producto

    $listadorelacionados=$bbdd->obtenerproductos($producto["id_cat"]); //Obtengo los productos realizaciones de la categoria del producto en el que estoy (accediendo al idcat del producto)

}


?>
        <main class="product-detail">
            <section class="product-detail__hero">
                <div class="container px-4 px-lg-5">
                    <div class="product-detail__grid">
                        <div class="product-detail__media">
                            <?php if($producto["Imagen"]!=""){ ?>
                                <img src="img/<?=$producto["Imagen"]?>" alt="<?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?>">
                            <?php }else{ ?>
                                <div class="product-detail__placeholder">Imagen no disponible</div>
                            <?php } ?>
                        </div>

                        <div class="product-detail__info">
                            <p class="category-hero__eyebrow">Pieza seleccionada</p>
                            <h1><?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?></h1>
                            <p class="product-detail__price"><?=number_format($producto["Precio"], 2, ",", ".")?>€</p>
                            <p class="product-detail__description"><?=htmlspecialchars($producto["Descripcion"], ENT_QUOTES, "UTF-8")?></p>

                            <div class="product-detail__availability">
                                <?php if($producto["Stock"]>0){ ?>
                                    <span class="product-detail__stock product-detail__stock--available">Disponible</span>
                                    <span><?=$producto["Stock"]?> unidades</span>
                                <?php }else{ ?>
                                    <span class="product-detail__stock product-detail__stock--unavailable">Agotado</span>
                                <?php } ?>
                            </div>

                            <form action="producto.php?id=<?=$producto['ID']?>" method="POST" class="product-detail__form">
                                <label for="cantidad">Cantidad</label>
                                <div class="product-detail__form-row">
                                    <input class="product-detail__quantity" type="number" id="cantidad" name="cantidad" value="1" min="1" max="<?=$producto["Stock"]?>" <?= $producto["Stock"]<1 ? "disabled" : "" ?>>
                                    <input type="hidden" name="idpro" value="<?=$producto['ID']?>">
                                    <button class="product-detail__submit" type="submit" name="anadirpro" <?= $producto["Stock"]<1 ? "disabled" : "" ?>>
                                        <i class="bi-bag-plus"></i>
                                        Añadir al carrito
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="product-detail__related">
                <div class="container px-4 px-lg-5">
                    <div class="category-products__heading">
                        <div>
                            <p class="section-kicker">También puede gustarte</p>
                            <h2>Más de esta colección</h2>
                        </div>
                    </div>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <?php foreach($listadorelacionados as $valor){
                            echo mostrarproducto($valor);
                        } ?>
                    </div>
                </div>
            </section>
        </main>
          <?php
        include_once("pie.php");
        ?>
    </body>
</html>
