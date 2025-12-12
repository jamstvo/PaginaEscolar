<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestionHorarios", "dev", "1234");
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo $e->getMessage();
}
