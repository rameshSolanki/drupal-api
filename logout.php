<?php
session_start();
$_SESSION["name"] = "";
unset($_COOKIE['csrf_token']);
unset($_COOKIE['logout_token']);
session_destroy();
header("Location: http://fridayapp.cu.ma/drupal-api/login.php");
