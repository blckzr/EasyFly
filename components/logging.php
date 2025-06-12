<?php
session_start();
include '../components/connect.php';

$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';

try {
    // Step 1: Authenticate from passport table
    $sql = "SELECT * FROM passport WHERE PassportNumber = :passport_number AND PassportExpiry = :passport_expiry";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':passport_number', $passport_number);
    $stmt->bindParam(':passport_expiry', $passport_expiry);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Set session values from passport table
        $_SESSION['passport_number'] = $user['PassportNumber'];
        $_SESSION['first_name'] = $user['FirstName'];
        $_SESSION['last_name'] = $user['LastName'];
        $_SESSION['birthdate'] = $user['Birthdate'];
        $_SESSION['passport_expiry'] = $user['PassportExpiry'];

        // Step 2: Try to fetch additional booker details
        $bookerSql = "SELECT Email, Telephone, Address, PostalCode, City, Country 
                      FROM booker WHERE PassportNumber = :passport_number";
        $bookerStmt = $conn->prepare($bookerSql);
        $bookerStmt->bindParam(':passport_number', $passport_number);
        $bookerStmt->execute();

        $booker = $bookerStmt->fetch(PDO::FETCH_ASSOC);

        // If booker record exists, store its values in session
        if ($booker) {
            $_SESSION['email'] = $booker['Email'];
            $_SESSION['telephone'] = $booker['Telephone'];
            $_SESSION['address'] = $booker['Address'];
            $_SESSION['postal_code'] = $booker['PostalCode'];
            $_SESSION['city'] = $booker['City'];
            $_SESSION['country'] = $booker['Country'];
        }

        echo "<script>alert('Login successful!'); window.location.href='../client/index.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials!'); window.location.href='../client/signin.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
