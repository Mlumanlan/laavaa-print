<?php

session_start();
if (!isset($_SESSION['email'])) {
    echo header("Location: products.php");
    exit();
}

$email = $_SESSION['email'];
// Logout logic
if (isset($_POST['logout'])) {

    session_unset();
    session_destroy();


    header("Location: products.php");
    exit();
}
?>