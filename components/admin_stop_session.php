<?php
    session_start();
    session_unset();    // Remove all session variables
    session_destroy();  // End the session
    header("Location: ../admin/login.php");
    exit();
?>