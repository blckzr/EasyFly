<?php
session_start();
header('Content-Type: application/json');
include '../components/connect.php';

// Ensure user is logged in
if (!isset($_SESSION['passport_number'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$sessionPassport = $_SESSION['passport_number'];
$requestedPassport = $_GET['passport'] ?? null;

// Use session passport if no GET param provided
$passportNumber = $requestedPassport ?? $sessionPassport;

// Ownership check: prevent accessing other users' bookings
if ($passportNumber !== $sessionPassport) {
    // Confirm if the requested passport exists in bookings under the user's passport
    $checkSql = "SELECT COUNT(*) FROM bookings WHERE PassportNumber = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([$passportNumber]);
    $bookingCount = $checkStmt->fetchColumn();

    if ($bookingCount == 0) {
        echo json_encode(['error' => 'Access denied. This booking does not belong to your account.']);
        exit;
    }
}

// Now proceed with the main booking query (you said to keep this unchanged)
$sql = "SELECT
            b.*,
            dfh.FlightTime as DepTime,
            dfh.FlightFrom as DepFrom,
            dfh.FlightTo as DepTo,
            afh.FlightTime as ArrTime,
            afh.FlightFrom as ArrFrom,
            afh.FlightTo as ArrTo
        FROM
            bookings b 
        INNER JOIN
            flight_history dfh ON dfh.FlightNumber = b.DepFlightNumber AND dfh.FlightDate = b.DepDate
        LEFT JOIN
            flight_history afh ON afh.FlightNumber = b.ArrFlightNumber AND afh.FlightDate = b.ArrDate
        WHERE
            b.PassportNumber = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$passportNumber]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($bookings) {
    echo json_encode(['bookings' => $bookings]);
} else {
    echo json_encode(['error' => 'No bookings found for this passport number']);
}
