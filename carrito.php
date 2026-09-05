<?php
include_once("cabecera.php");

?>

<main class="cart-page">
    <header class="cart-page__hero">
        <div class="container px-4 px-lg-5">
            <p class="category-hero__eyebrow">Tu selección</p>
            <h1>Todo lo que<br><em>te gusta.</em></h1>
            <p>Revisa tus favoritos antes de seguir disfrutando de Nuvia.</p>
        </div>
    </header>

    <section class="cart-page__content">
        <div class="container px-4 px-lg-5">
            <?php
            $total=0;
            if(empty($infocarritos)){ ?>
                <div class="cart-empty">
                    <p class="section-kicker">Tu carrito está esperando</p>
                    <h2>Aún no tienes productos.</h2>
                    <p>Explora nuestra selección y guarda aquí las prendas que más te gusten.</p>
                    <a class="cart-button cart-button--primary" href="categoria.php">Descubrir productos</a>
                </div>
            <?php }else{ ?>
                <div class="cart-page__heading">
                    <div>
                        <p class="section-kicker">Tu selección</p>
                        <h2>Carrito de compra</h2>
                    </div>
                    <span class="category-products__count"><?=count($infocarritos)?> productos</span>
                </div>

                <div class="cart-layout">
                    <div class="cart-items">
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th><span class="visually-hidden">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($infocarritos as $valor){
                                        $producto=$bbdd->obtenerproducto($valor["id_producto"]);
                                        $subtotal=(int)$valor["cantidad"]*(int)$producto["Precio"];
                                        $total=$total+$subtotal;
                                    ?>
                                    <tr>
                                        <td class="cart-table__product">
                                            <a href="producto.php?id=<?=$producto["ID"]?>"><?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?></a>
                                        </td>
                                        <td><?=number_format($producto["Precio"], 2, ",", ".")?>€</td>
                                        <td><span class="cart-table__quantity"><?=$valor["cantidad"]?></span></td>
                                        <td class="cart-table__subtotal"><?=number_format($subtotal, 2, ",", ".")?>€</td>
                                        <td>
                                            <form action="carrito.php" method="post">
                                                <input type="hidden" name="id_carrito" value="<?=$valor["id_carrito"]?>">
                                                <button class="cart-remove" type="submit" name="eliminar" aria-label="Eliminar <?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?>">
                                                    <i class="bi-trash3" aria-hidden="true"></i>
                                                    <span>Eliminar</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <aside class="cart-summary">
                        <p class="section-kicker">Resumen</p>
                        <h2>Total de tu pedido</h2>
                        <div class="cart-summary__total"><?=number_format($total, 2, ",", ".")?>€</div>
                        <p>Los gastos de envío se calculan al finalizar la compra.</p>
                        <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
                            <button class="cart-button cart-button--primary" type="submit" name="vaciarcarrito">Finalizar compra</button>
                        </form>
                        <a class="cart-button cart-button--secondary" href="categoria.php">Seguir comprando</a>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </section>
</main>
<?php
    include_once("pie.php");
?>
</body>
</html>