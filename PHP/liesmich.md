### 1. Projektstruktur

- **index.php** – Hauptseite mit Formularen zum Anlegen, Ändern und Löschen von Benutzern.
- **login.php** – Seite zur Anmeldung der Benutzer.
- **logout.php** – Seite zur Abmeldung der Benutzer.
- **register.php** – Seite zur Registrierung neuer Benutzer.
- **config.php** – Konfigurationsdatei für die Datenbankverbindung.
- **functions.php** – Hilfsfunktionen für die Benutzerverwaltung.
- **auth.php** – Skript, das den Zugang auf registrierte Benutzer beschränkt.
- **db.sql** – SQL-Datei zum Erstellen der notwendigen Tabellen.

### 2. Datenbankstruktur

```sql
CREATE DATABASE user_management;
USE user_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Konfigurationsdatei (`config.php`)

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### 4. Hilfsfunktionen (`functions.php`)

```php
<?php
session_start();
require 'config.php';

function registerUser($username, $password) {
    global $conn;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $passwordHash);
    return $stmt->execute();
}

function loginUser($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $passwordHash);
        $stmt->fetch();
        if (password_verify($password, $passwordHash)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
    }
    return false;
}

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logoutUser() {
    session_unset();
    session_destroy();
}
?>
```

### 5. Zugriffsbeschränkung (`auth.php`)

```php
<?php
require 'functions.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
```

### 6. Login-Seite (`login.php`)

```php
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
```

### 7. Registrierungsseite (`register.php`)

```php
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
```

### 8. Hauptseite (`index.php`)

```php
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
```

### 9. Logout-Seite (`logout.php`)

```php
<?php
require 'functions.php';

logoutUser();
header("Location: login.php");
exit;
```

### Sicherheitshinweise

- **Passwörter hashen:** Immer Passwörter mit einem sicheren Hashing-Algorithmus wie `bcrypt` speichern.
- **SQL-Injection vermeiden:** Verwenden Sie vorbereitete Anweisungen (Prepared Statements) für alle SQL-Abfragen.
- **Sessions:** Verwenden Sie `session_start()` und prüfen Sie die Authentifizierung bei jedem Seitenaufruf.
- **HTTPS verwenden:** Verschlüsseln Sie die gesamte Kommunikation zwischen dem Client und dem Server durch den Einsatz von HTTPS.

