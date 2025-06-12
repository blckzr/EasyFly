<?php
include '../components/connect.php';

$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';

try {
    // Check if passport already exists
    $checkSql = "SELECT * FROM passport WHERE PassportNumber = :passport_number";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':passport_number', $passport_number);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        echo "<script>alert('User already exists!'); window.location.href='../client/signin.php';</script>";
        exit;
    }

    // Begin transaction
    $conn->beginTransaction();

    // Insert into passport table
    $insertPassportSql = "INSERT INTO passport (PassportNumber, PassportExpiry, FirstName, LastName, Birthdate)
                          VALUES (:passport_number, :passport_expiry, :first_name, :last_name, :birthdate)";
    $passportStmt = $conn->prepare($insertPassportSql);
    $passportStmt->bindParam(':passport_number', $passport_number);
    $passportStmt->bindParam(':passport_expiry', $passport_expiry);
    $passportStmt->bindParam(':first_name', $first_name);
    $passportStmt->bindParam(':last_name', $last_name);
    $passportStmt->bindParam(':birthdate', $birthdate);
    $passportStmt->execute();

    // Insert into booker table (only passport_number)
    $insertBookerSql = "INSERT INTO booker (PassportNumber) VALUES (:passport_number)";
    $bookerStmt = $conn->prepare($insertBookerSql);
    $bookerStmt->bindParam(':passport_number', $passport_number);
    $bookerStmt->execute();

    // Commit transaction
    $conn->commit();

    echo "<script>alert('Registration successful!'); window.location.href='../client/signin.php';</script>";
} catch (PDOException $e) {
    // Rollback if any error occurs
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
