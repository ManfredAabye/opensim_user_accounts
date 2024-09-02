<?php
require 'auth.php'; // Zugriff nur für angemeldete Benutzer
require 'functions.php';

// Implementieren Sie hier die Funktionen zum Anlegen, Ändern und Löschen von Benutzern
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Benutzerverwaltung</title>
</head>
<body>
    <h1>Benutzerverwaltung</h1>
    <a href="logout.php">Logout</a>

    <h2>User anlegen</h2>
    <form method="post" action="create_user.php">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">User anlegen</button>
    </form>

    <h2>Passwort ändern</h2>
    <form method="post" action="change_password.php">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="new_password" placeholder="Neues Passwort" required><br>
        <button type="submit">Passwort ändern</button>
    </form>

    <h2>User löschen</h2>
    <form method="post" action="delete_user.php">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <button type="submit">User löschen</button>
    </form>
</body>
</html>
