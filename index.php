<?php
include_once("cabecera.php");

?>

        <!-- Cabecera principal-->
        <header class="home-hero">
            <div class="container px-4 px-lg-5">
                <div class="home-hero__content">
                    <p class="home-hero__eyebrow">Tu selección, sin complicaciones</p>
                    <h1>Todos tus favoritos,<br><em style="color: #e97959">en un solo lugar.</em></h1>
                    <p class="home-hero__text">Encuentra tu prenda adecuada para cada momento y recíbela en pocos clics.</p>
                </div>
                <div class="home-hero__image">
                    <img src="img/ropaportada.png" alt="Selección de prendas">
                </div
            </div>
        </header>

<section style="
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    width: 100%;
    background: #e07a3f;
    color: #17324d;
">

    <p style="
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin: 0;
        padding: 1rem 0.5rem;
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 0.02em;
    ">
        <i class="bi-truck"></i>
        Envío gratis desde 50 €
    </p>

    <p style="
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin: 0;
        padding: 1rem 0.5rem;
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 0.02em;
        border-left: 1px solid rgba(23, 50, 77, 0.28);
    ">
        <i class="bi-arrow-repeat"></i>
        Devoluciones en 30 días
    </p>

    <p style="
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin: 0;
        padding: 1rem 0.5rem;
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 0.02em;
        border-left: 1px solid rgba(23, 50, 77, 0.28);
    ">
        <i class="bi-shield-check"></i>
        Pago 100% seguro
    </p>

</section>
        <!-- Section-->
        <section class="home-products py-5" id="mas-vendidos">
            <div class="container px-4 px-lg-5">
                <div class="home-products__heading">
                    <div>
                        <p class="section-kicker">Lo más elegido</p>
                        <h2>Los más comprados de la semana</h2>
                    </div>
                    <p class="section-note">Productos que están conquistando carritos.</p>
                </div>
                <div class="row gx-4 gy-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    $masvendidos=$bbdd->cuatromasvendidos();
                    $contador=0;
                    foreach($masvendidos as $valor){
                        if($contador<4){ //asi saco 4, si quiero sacar mas solo cambio este dato

                        echo mostrarproducto($valor);

                        $contador++;
                        }
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
