<?php
session_start();
include '../components/connect.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {
    // Fetch user by username
    $sql = "SELECT * FROM staff WHERE Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        // Store relevant staff details in session
        $_SESSION['admin_id'] = $user['Admin_ID'];
        $_SESSION['first_name'] = $user['First_Name'];
        $_SESSION['last_name'] = $user['Last_Name'];
        $_SESSION['username'] = $user['Username'];

        echo "<script>window.location.href='../admin/dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid username or password!'); window.location.href='../client/signin.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>