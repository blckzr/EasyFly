<?php
session_start();
include '../components/connect.php';

$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';

try {
    $sql = "SELECT * FROM passport WHERE PassportNumber = :passport_number AND PassportExpiry = :passport_expiry";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':passport_number', $passport_number);
    $stmt->bindParam(':passport_expiry', $passport_expiry);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['passport_number'] = $user['PassportNumber'];
        $_SESSION['first_name'] = $user['FirstName'];
        $_SESSION['last_name'] = $user['LastName'];
        $_SESSION['birthdate'] = $user['Birthdate'];
        $_SESSION['passport_expiry'] = $user['PassportExpiry'];

        echo "<script>alert('Login successful!'); window.location.href='../client/index.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials!'); window.location.href='../client/signin.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
