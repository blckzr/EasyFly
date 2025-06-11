<?php
include '../components/connect.php';

$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';

try {
    // Check if user already exists
    $checkSql = "SELECT * FROM passport WHERE PassportNumber = :passport_number";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':passport_number', $passport_number);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        echo "<script>alert('User already exists!'); window.location.href='../client/signup.php';</script>";
        exit;
    }

    // Insert new user
    $insertSql = "INSERT INTO passport (PassportNumber, PassportExpiry, FirstName, LastName, Birthdate)
                  VALUES (:passport_number, :passport_expiry, :first_name, :last_name, :birthdate)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bindParam(':passport_number', $passport_number);
    $stmt->bindParam(':passport_expiry', $passport_expiry);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->execute();

    echo "<script>alert('Registration successful!'); window.location.href='../client/signin.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>