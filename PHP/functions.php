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
