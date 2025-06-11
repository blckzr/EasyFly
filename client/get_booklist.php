<?php
header('Content-Type: application/json');
include '../components/connect.php'; // Include the database connection

$passportNumber = isset($_GET['passport']) ? $_GET['passport'] : null;
if (!$passportNumber) {
    echo json_encode(['error' => 'Passport number is required']);
    exit;
}

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
            b.PassportNumber = ?"; // Use a prepared statement to prevent SQL injection

$stmt = $conn->prepare($sql);
$stmt->execute([$passportNumber]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($bookings) {
    echo json_encode(['bookings' => $bookings]);
} else {
    echo json_encode(['error' => 'No bookings found for this passport number']);
}
