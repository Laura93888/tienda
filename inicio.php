<?php
session_start();
include_once("funciones.php");
include_once("funcionesextra.php");

$bbdd = new db(
    "sql209.infinityfree.com",
    3306,
    "if0_42999121_Tienda1",
    "if0_42999121",
    "nuviainfinity"
);

?>