<?php
require 'functions.php';

logoutUser();
header("Location: login.php");
exit;
