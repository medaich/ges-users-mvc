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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["age"]) && isset($_POST["categorie"])) {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $categorie = $_POST["categorie"];

    $stmt = $pdo->prepare("INSERT INTO users (nom, email, age, categorie) VALUES (:nom, :email, :age, :categorie)");
    /* $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':categorie', $categorie); */



    if ($stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':age' => $age,
        ':categorie' => $categorie
    ])) {
        echo "Utilisateur ajouté avec succès.";
        header("location: welcome.php");
        exit;
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Ajouter un Utilisateur</h1>
    <form method="POST" action="add.php">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required><br><br>
        <label for="categorie">Catégorie:</label><br>
        <input type="text" id="categorie" name="categorie" required><br><br>
        <input type="submit" value="Ajouter">
    </form>

    <a href="welcome.php">Retour à la liste des utilisateurs</a>
</body>