<?php
include_once("cabecera.php");

?>

        <!-- Header-->
        <header class="home-hero">
            <div class="container px-4 px-lg-5">
                <div class="home-hero__content">
                    <p class="home-hero__eyebrow">Tu selección, sin complicaciones</p>
                    <h1>Todos tus favoritos,<br><em style="color: #e97959";>en un solo lugar.</em></h1>
                    <p class="home-hero__text">Encuentra tu prenda adecuada para cada momento y recíbela en pocos clics.</p>
                    
                </div>
                <div class="home-hero__badge" aria-hidden="true">
                    <span>01</span>
                    <strong>Selección<br>semanal</strong>
                </div>
            </div>
        </header>
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
