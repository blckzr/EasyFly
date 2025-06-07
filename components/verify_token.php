<?php
session_start();

$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'];

$client_id = "YOUR_GOOGLE_CLIENT_ID"; // Replace with yours

// Verify with Google's public keys
$client = new Google_Client(['client_id' => $client_id]);  // From Google API PHP Client
$payload = $client->verifyIdToken($token);

if ($payload) {
    $_SESSION['user'] = [
        'name' => $payload['name'],
        'email' => $payload['email'],
        'picture' => $payload['picture'],
        'google_id' => $payload['sub']
    ];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
