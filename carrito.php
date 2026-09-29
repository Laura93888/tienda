<?php
include_once("cabecera.php");
   
?>

<main class="cart-page">
    <header class="cart-page__hero">
        <div class="container px-4 px-lg-5">
            <p class="cart-page__eyebrow"><i class="bi bi-bag" aria-hidden="true"></i> Carrito de compra</p>
            <h1>Tu carrito<br><em>está aquí.</em></h1>
            <p>Revisa tu selección antes de finalizar el pedido.</p>
            <span class="cart-page__status"><strong><?=$cantcarrito?></strong> <?=($cantcarrito == 1) ? "producto" : "productos"?> en tu carrito</span>
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
                                        $subtotal=(int)$valor["cantidad"]*(float)$producto["Precio"];
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
                        <button class="cart-remove" type="button"
                            data-bs-toggle="modal" data-bs-target="#modalEliminar"
                            data-id-carrito="<?=$valor["id_carrito"]?>"
                            data-nombre="<?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?>"
                            aria-label="Eliminar <?=htmlspecialchars($producto["nombre"], ENT_QUOTES, "UTF-8")?>">
                            <i class="bi-trash3" aria-hidden="true"></i>
                            <span>Eliminar</span>
                        </button>
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
                            <button class="cart-button cart-button--primary" type="submit" name="terminarpedido">Terminar pedido</button>
                        </form>
                        <a class="cart-button cart-button--secondary" href="categoria.php">Seguir comprando</a>
                    </aside>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<!-- Modal: confirmar que se elimina un producto -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="tituloEliminar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="tituloEliminar">¿Quitar del carrito?</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Vas a eliminar <strong id="nombreEliminar"></strong> de tu carrito.</p>
            </div>
            <div class="modal-footer">
                <form action="carrito.php" method="post">
                    <input type="hidden" name="id_carrito" id="idCarritoEliminar" value="">
                    <button class="cart-button cart-button--primary" type="submit" name="eliminar">Sí, eliminar</button>
                </form>
                <button type="button" class="cart-button cart-button--secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: pedido realizado -->
<div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="tituloPedido" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="tituloPedido">¡Pedido realizado!</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Hemos recibido tu pedido. En unos minutos te llegará un correo con el resumen.</p>
            </div>
            <div class="modal-footer">
                <a class="cart-button cart-button--primary" href="categoria.php">Seguir comprando</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal: hay que iniciar sesión para terminar el pedido -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="tituloLogin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="tituloLogin">Inicia sesión para continuar</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Para terminar tu pedido necesitas una cuenta. Tu carrito se mantiene mientras tanto.</p>
            </div>
            <div class="modal-footer">
                <a class="cart-button cart-button--primary" href="login.php">Iniciar sesión</a>
                <a class="cart-button cart-button--secondary" href="registro.php">Crear cuenta</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Modal de eliminar: le paso el producto que se ha pulsado
    var modalEliminar = document.getElementById("modalEliminar");
    modalEliminar.addEventListener("show.bs.modal", function (evento) {
        var boton = evento.relatedTarget;
        document.getElementById("idCarritoEliminar").value = boton.dataset.idCarrito;
        document.getElementById("nombreEliminar").textContent = boton.dataset.nombre;
    });

    // Modales que se abren solos según lo que haya pasado en el servidor
    <?php if($pedido_realizado){ ?>
    new bootstrap.Modal(document.getElementById("modalPedido")).show();
    <?php } ?>
    <?php if($necesita_login){ ?>
    new bootstrap.Modal(document.getElementById("modalLogin")).show();
    <?php } ?>
});
</script>
<?php
    include_once("pie.php");
?>

</body>
</html>