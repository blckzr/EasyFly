<?php
session_start();

if (!isset($_SESSION['passport_number'])) {
    // Not logged in, redirect to login page
    header("Location: ../client/signin.php");
    exit();
}
?>