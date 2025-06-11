<?php
// Database connection
include '../components/connect.php';

// Get and sanitize inputs
$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';

try {
    $sql = "INSERT INTO passport (PassportNumber, PassportExpiry, FirstName, LastName, Birthdate)
            VALUES (:passport_number, :passport_expiry, :first_name, :last_name, :birthdate)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':passport_number', $passport_number);
    $stmt->bindParam(':passport_expiry', $passport_expiry);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':birthdate', $birthdate);
    
    $stmt->execute();
    
    echo "<script>alert('Employee added successfully!'); window.location.href='../client/signin.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Login Process
try {
    $sql = "SELECT * FROM passport WHERE PassportNumber = :passport_number AND PassportExpiry = :passport_expiry";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':passport_number', $passport_number);
    $stmt->bindParam(':passport_expiry', $passport_expiry);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Start session and store user data
        session_start();
        $_SESSION['passport_number'] = $user['PassportNumber'];
        $_SESSION['first_name'] = $user['FirstName'];
        $_SESSION['last_name'] = $user['LastName'];

        echo "<script>alert('Login successful!'); window.location.href='../client/index.php';</script>";
    } else {
        echo "<script>alert('Invalid passport number or expiry date.'); window.location.href='../client/signin.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
