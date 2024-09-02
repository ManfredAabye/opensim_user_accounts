<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (registerUser($username, $password)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Benutzername bereits vergeben.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
</head>
<body>
    <h2>Registrieren</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Registrieren</button>
    </form>
    <a href="login.php">Schon ein Konto? Login</a>
</body>
</html>
