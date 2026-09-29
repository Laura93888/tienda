<?php
session_start();
include_once("funciones.php");
include_once("funcionesextra.php");

//Los datos de conexión están en config.php (ese archivo NO se sube a git)
$config = require __DIR__ . "/config.php";

$bbdd = new db(
    $config["host"],
    $config["port"],
    $config["db"],
    $config["user"],
    $config["pass"]
);

?>