<?php

session_start();
if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit;
}

$user = unserialize($_SESSION["user"]);
if ($user["categorie"] != 2) {
    header("location: welcome.php");
    exit;
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $pdo->prepare("UPDATE users SET deleted_at = NOW() WHERE id = :id");
    if ($stmt->execute([':id' => $id])) {
        echo "Utilisateur supprimé avec succès.";
        header("location: welcome.php");
        exit;
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
} else {
    echo "Veuillez sélectionner un utilisateur à supprimer.";
}
