<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginUser($username, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Ungültige Anmeldeinformationen.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Noch kein Konto? Registrieren</a>
</body>
</html>
