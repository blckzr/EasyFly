<?php
include '../components/connect.php'; // Adjust path as needed
session_start();

$input = json_decode(file_get_contents('php://input'), true);
$idToken = $input['token'] ?? '';

$verifyUrl = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($idToken);
$response = file_get_contents($verifyUrl);
$payload = json_decode($response, true);

if (isset($payload['email'])) {
    $picture = $payload['picture'] ?? '';
    $google_email = $payload['email'];
    $given_name = $payload['given_name'];
    $family_name = $payload['family_name'];

    $stmt = $conn->prepare("SELECT * FROM booker WHERE Email = :email");
    $stmt->bindParam(':email', $google_email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $passportNumber = $user['PassportNumber'];

        // Fetch passport details using PassportNumber
        $passportStmt = $conn->prepare("SELECT * FROM passport WHERE PassportNumber = :passport_number");
        $passportStmt->bindParam(':passport_number', $passportNumber);
        $passportStmt->execute();
        $passport = $passportStmt->fetch(PDO::FETCH_ASSOC);

        // Store google session data
        $_SESSION['google_picture'] = $picture;
        $_SESSION['google_email'] = $google_email;
        $_SESSION['google_firstName'] = $given_name;
        $_SESSION['google_lastName'] = $family_name;

        // Store booker session data
        $_SESSION['email'] = $user['Email'];
        $_SESSION['telephone'] = $user['Telephone'];
        $_SESSION['address'] = $user['Address'];
        $_SESSION['city'] = $user['City'];
        $_SESSION['country'] = $user['Country'];
        $_SESSION['postal_code'] = $user['PostalCode'];

        // Store passport session data
        $_SESSION['passport_number'] = $passportNumber;
        $_SESSION['first_name'] = $passport['FirstName'];
        $_SESSION['last_name'] = $passport['LastName'];
        $_SESSION['birthdate'] = $passport['Birthdate'];
        $_SESSION['passport_expiry'] = $passport['PassportExpiry'];

        echo json_encode(['redirect' => '../client/index.php']);
    } else {
        $_SESSION['google_email'] = $google_email;
        $_SESSION['google_firstName'] = $given_name;
        $_SESSION['google_lastName'] = $family_name;

        echo json_encode(['redirect' => '../client/google_sign.php']);
    }
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
}
