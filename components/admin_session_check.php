<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    // Not logged in, redirect to login page
    header("Location: ../admin/login.php");
    exit();
}
?>