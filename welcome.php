<?php

session_start();

if (isset($_SESSION["user"])) {


    $user = unserialize($_SESSION["user"]);

    echo "Hello ". $user["nom"];
}
require_once 'config.php';
$stmt = $pdo->query("SELECT u.*, c.type FROM users u JOIN categories c ON u.categorie=c.id  WHERE u.deleted_at IS NULL;");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$users) {
    echo "No users found.";
    exit;
}
?>



<table>
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>age</th>
        <th>categorie</th>
        <th>modify</th>
        <th>delete</th>
    </tr>



    <?php foreach ($users as $user) { ?>
    <tr>

        <td><?php echo $user["nom"]; ?></td>
        <td><?php echo $user["email"]; ?></td>
        <td><?php echo $user["age"]; ?></td>
        <td><?php echo $user["type"]; ?>
        <td>
            <a
                href="modify.php?id=<?= $user["id"] ?>">Modifier</a>
        </td>
        <td>
            <a
                href="delete.php?id=<?= $user["id"] ?>">delete</a>
        </td>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="add.php">Ajouter utilisateur</a>

<br>

<a href="deconnect.php">Déconnecter</a>