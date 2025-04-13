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
    $id = $_GET['id'];


    $stmt = $pdo->prepare("UPDATE users SET nom=:nom, email=:email, age=:age, categorie=:categorie WHERE id=:id");
    if ($stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':age' => $age,
        ':categorie' => $categorie,
        ':id' => $id
    ])) {
        echo "Utilisateur modifié avec succès.";
        header("location: welcome.php");
        exit;
    } else {
        echo "Erreur lors de la modification de l'utilisateur.";
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
    <title>Modifier Utilisateur</title>

</head>

<body>
    <h1>Modifier un Utilisateur</h1>
    <?php
    $id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id AND deleted_at IS NULL");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <form method="POST"
        action="modify.php?id=<?= $user['id'] ?>">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom"
            value="<?= $user['nom'] ?>"
            required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"
            value="<?= $user['email'] ?>"
            required><br><br>
        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age"
            value="<?= $user['age'] ?>"
            required><br><br>
        <label for="categorie">Catégorie:</label><br>

        <select id="categorie" name="categorie" required>
            <option value="1" <?= $user["categorie"] == 1 ? "selected" : "" ?>>normale
            </option>
            <option value="2" <?= $user["categorie"] == 2 ? "selected" : "" ?>>administrateur
            </option>
        </select><br><br>


        <input type="submit" value="Modifier">
    </form>
    <br>
    <a href="welcome.php">Retour à la liste des utilisateurs</a>
</body>

</html>