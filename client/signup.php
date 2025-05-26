<?php
include '../components/connect.php';

// setup form data
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$address = $_POST['address'];
$city = $_POST['city'];
$country = $_POST['country'];
$pcode = $_POST['postalcode'];
$email = $_POST['email'];
$phone = $_POST['telephone'];
$passnum = $_POST['passportnumber'];
$passexp = $_POST['passportexpiry'];
$bdate = $_POST['birthdate'];

// insert to passport table firt to ensure passnum exists
$sql = "INSERT INTO passport (PassportNumber, PassportExpiry, FirstName, LastName, Birthdate) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute([$passnum, $passexp, $fname, $lname, $bdate]);
} catch (PDOException $e) {
    die("Error inserting passport into database: " . $e->getMessage());
}

// insert to booker table
$sql = "INSERT INTO booker (PassportNumber, Email, Telephone, Address, PostalCode, City, Country) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
try {
    $stmt->execute([$passnum, $email, $phone, $address, $pcode, $city, $country]);
} catch (PDOException $e) {
    die("Error inserting booker information into database: " . $e->getMessage());
}

header("Location: signup.html");
exit;
