<?php

try {
    $pdo = new PDO(
    "mysql:host=127.0.0.1;port=3306;dbname=Tienda1;charset=utf8",
    "tienda",
    "tienda123"
);

    echo "CONEXIÓN CORRECTA";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}