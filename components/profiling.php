<?php
session_start();
include '../components/connect.php';

// Get values from POST
$passport_number = $_POST['passport_number'] ?? '';
$passport_expiry = $_POST['passport_expiry'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$birth_date = $_POST['birth_date'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$country = $_POST['country'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';

try {
    // Update passport info
    $updatePassportSql = "UPDATE passport 
                          SET PassportExpiry = :passport_expiry, FirstName = :first_name, LastName = :last_name, Birthdate = :birth_date 
                          WHERE PassportNumber = :passport_number";
    $passportStmt = $conn->prepare($updatePassportSql);
    $passportStmt->execute([
        ':passport_number' => $passport_number,
        ':passport_expiry' => $passport_expiry,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':birth_date' => $birth_date,
    ]);

    // Update or insert into booker table
    $checkSql = "SELECT * FROM booker WHERE PassportNumber = :passport_number";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':passport_number', $passport_number);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Update existing booker
        $updateSql = "UPDATE booker 
                      SET Email = :email, Telephone = :telephone, Address = :address,
                          PostalCode = :postal_code, City = :city, Country = :country
                      WHERE PassportNumber = :passport_number";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->execute([
            ':email' => $email,
            ':telephone' => $telephone,
            ':address' => $address,
            ':postal_code' => $postal_code,
            ':city' => $city,
            ':country' => $country,
            ':passport_number' => $passport_number,
        ]);
    } else {
        // Insert new booker
        $insertSql = "INSERT INTO booker (PassportNumber, Email, Telephone, Address, PostalCode, City, Country)
                      VALUES (:passport_number, :email, :telephone, :address, :postal_code, :city, :country)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->execute([
            ':passport_number' => $passport_number,
            ':email' => $email,
            ':telephone' => $telephone,
            ':address' => $address,
            ':postal_code' => $postal_code,
            ':city' => $city,
            ':country' => $country,
        ]);
    }

    // ✅ Refresh session data after updating DB
    $fetchPassport = $conn->prepare("SELECT * FROM passport WHERE PassportNumber = :passport_number");
    $fetchPassport->bindParam(':passport_number', $passport_number);
    $fetchPassport->execute();
    $user = $fetchPassport->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['passport_number'] = $user['PassportNumber'];
        $_SESSION['first_name'] = $user['FirstName'];
        $_SESSION['last_name'] = $user['LastName'];
        $_SESSION['birthdate'] = $user['Birthdate'];
        $_SESSION['passport_expiry'] = $user['PassportExpiry'];
    }

    $fetchBooker = $conn->prepare("SELECT * FROM booker WHERE PassportNumber = :passport_number");
    $fetchBooker->bindParam(':passport_number', $passport_number);
    $fetchBooker->execute();
    $booker = $fetchBooker->fetch(PDO::FETCH_ASSOC);

    if ($booker) {
        $_SESSION['email'] = $booker['Email'];
        $_SESSION['telephone'] = $booker['Telephone'];
        $_SESSION['address'] = $booker['Address'];
        $_SESSION['postal_code'] = $booker['PostalCode'];
        $_SESSION['city'] = $booker['City'];
        $_SESSION['country'] = $booker['Country'];
    }

    echo "<script>alert('Profile updated successfully!'); window.location.href='../client/profile.php';</script>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
