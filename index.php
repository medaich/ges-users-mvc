<?php

session_start();

if (isset($_SESSION["user"])) {
    header("location: welcome.php");
    exit;
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["email"]) && isset($_POST["password"])) {


    $email = $_POST["email"];
    $psw = $_POST["password"];

    require_once "config.php";
    $is_authenticated = false;

    $stmt = $pdo->query("SELECT * FROM users WHERE email = '$email';");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);



    if (!$user) {
        echo "user not exist";
        $is_authenticated = false;
        header("location: index.php");
        exit;

    }

    $is_authenticated = $psw === $user["password"];

    if (!$is_authenticated) {
        header("location: index.php");
        exit;
    }


    $serialized_user = serialize($user);

    $_SESSION["user"] = $serialized_user;

    header("location: welcome.php");
    exit;




} else {



    require_once 'config.php';
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <form action="index.php" method="POST">

        <input type="email" name="email" placeholder="Enter your email...">
        <input type="password" name="password" placeholder="Enter your password...">
        <button>Submit</button>

    </form>
</body>

</html>

<?php
}
?>