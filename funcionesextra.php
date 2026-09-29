<?php

//Funcion para mostrar los productos(le llega un producto)
//Solo muestra imagen si existe
function mostrarproducto($valor){

    $nombre=htmlspecialchars($valor["nombre"], ENT_QUOTES, "UTF-8");
    $precio=number_format($valor["Precio"], 2, ",", ".");

    if($valor["Imagen"]!=""){
        $img="<img class='card-img-top' src='img/".htmlspecialchars($valor["Imagen"], ENT_QUOTES, "UTF-8")."' alt='".$nombre."'>";
    }else{
        $img="";
    }

    return "<div class='col mb-5'>
                <div class='card product-card h-100'>
                    <a class='product-card__link' href='producto.php?id=".(int)$valor["ID"]."'>"
                    .$img."
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h5 class='fw-bolder product-card__title'>".$nombre."</h5>
                                ".$precio."€
                            </div>
                        </div>
                    </a>
                    ".mostraranadircarrito($valor)."
                </div>
            </div>";

}

//Hago esta funcion para deshabilitar el boton si no hay stock
function mostraranadircarrito($valor){

    $sinstock=$valor["Stock"]<1 ? "disabled" : "";
    $accion=htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8");

    return "<div class='product-card__cart text-center'>
            <form method='POST' action='".$accion."'>
                <input class='product-card__quantity' type='number' name='cantidad' value='1' min='1' max='".(int)$valor["Stock"]."' aria-label='Cantidad' ".$sinstock.">
                <input type='hidden' name='idpro' value='".(int)$valor["ID"]."'>
                <input class='product-card__submit' type='submit' value='Añadir al carrito' name='anadirpro' ".$sinstock.">
            </form>
        </div>";

}

function anadiralcarritocookie(&$carrito,$idpro,$cant){

     //bandera para comprobar que el producto no está en la cookie carrito
        $estapro=False;
        //Recorro el carrito para ver si el producto está en el 
        foreach ($carrito as $pos => $produc){
            if($produc["id_producto"]==$idpro){
                $estapro=True; //pasamos a true si lo encuentra
                //sumo la cantidad que me ha llegado por post si lo encuentra
                $carrito[$pos]["cantidad"]+=$cant;  
            }
        }

        //Si no está este producto (no se ha levantado bandera) crea su array dentro de la cookie carrito
        if(!$estapro){

            //GENERAR ID CARRITO nuevo (solo tengo que mirar el id más grande de mis carritos)
            //Cuando mi carrito exista pero este vacio porque he borrado productos(pongo id=1)
            if(empty($carrito)){
                $nuevoId=1;
            }else{
                 $nuevoId = max(array_column($carrito, "id_carrito"))+1; //Extrae una columna concreta de un array de arrays
            }

            //AÑADIR PRODUCTO A CARRITO COOKIES
            $carrito[]=[
                "id_producto" => $idpro,
                "cantidad" => $cant,
                "id_carrito" =>$nuevoId
                ];
        }
    
}


?>