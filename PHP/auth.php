<?php
require 'functions.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>
