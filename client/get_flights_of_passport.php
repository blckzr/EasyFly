<?php
header('Content-Type: application/json');
include '../components/connect.php';

$passport_num = $_GET['passport'] ?? '';

$sql = "SELECT
    b.*,
    dfh.FlightTime AS DepTime,
    dfh.FlightFrom AS DepFrom,
    dfh.FlightTo AS DepTo,
    afh.FlightTime AS ArrTime,
    afh.FlightFrom AS ArrFrom,
    afh.FlightTo AS ArrTo
FROM
    ticket t
INNER JOIN bookings b ON t.BookingID = b.BookingID
INNER JOIN flight_history dfh ON dfh.FlightNumber = b.DepFlightNumber AND dfh.FlightDate = b.DepDate
LEFT JOIN flight_history afh ON afh.FlightNumber = b.ArrFlightNumber AND afh.FlightDate = b.ArrDate
WHERE
    t.PassengerPassportNumber = ?
ORDER BY
    b.BookingDate DESC;";

$stmt = $conn->prepare($sql);
$stmt->execute([$passport_num]);
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($flights) {
    echo json_encode(['flights' => $flights]);
} else {
    echo json_encode(['error' => 'No flights found for this passport number.']);
}
