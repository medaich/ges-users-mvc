<?php

try {

    $pdo = new PDO('mysql:host=localhost;dbname=users', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    echo "Connected successfully";
    echo "<br>";

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
