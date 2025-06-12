<?php
include '../components/session_check.php'; // Ensure user is logged in
include '../components/connect.php';

$passport_num = $_SESSION['passport_number'] ?? '';
if (empty($passport_num)) {
    header("Location: ../client/signin.php");
    exit();
}

$itinerary = isset($_GET['itinerary']) ? $_GET['itinerary'] : 'ONEWAY';
$flightNumber = isset($_GET['flightNumber']) ? $_GET['flightNumber'] : '';
$flightDate = isset($_GET['flightDate']) ? $_GET['flightDate'] : '';
$flightClass = isset($_GET['flightClass']) ? $_GET['flightClass'] : 'ECONOMY';
$retFlightNumber = isset($_GET['retFlightNumber']) ? $_GET['retFlightNumber'] : '';
$retFlightDate = isset($_GET['retFlightDate']) ? $_GET['retFlightDate'] : '';
$passengers_json = isset($_GET['passengers']) ? $_GET['passengers'] : '[]';

// convert JSON string to PHP array
$passengers = json_decode($passengers_json, true);

$sql = "
    INSERT INTO bookings
    (PassportNumber, BookingDate, ItineraryType, Class, DepFlightNumber, DepDate, ArrFlightNumber, ArrDate)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $passport_num,
    date('Y-m-d H:i:s'),
    $itinerary,
    $flightClass,
    $flightNumber,
    $flightDate,
    $retFlightNumber !== '' ? $retFlightNumber : null,
    $retFlightDate !== '' ? $retFlightDate : null
]);
$bookingID = $conn->lastInsertId();

$lastTicketIDStmt = $conn->query("SELECT TicketID FROM ticket ORDER BY TicketID DESC LIMIT 1");
$lastTicketID = $lastTicketIDStmt->fetch(PDO::FETCH_ASSOC);
$nextTicketID = $lastTicketID ? hexdec($lastTicketID['TicketID']) + 1 : 1;

// insert passenger passport info to passenger table
foreach ($passengers as $index => $p) {
    $passportStmt = $conn->prepare("
        INSERT INTO passport
            (PassportNumber, PassportExpiry, FirstName, LastName, BirthDate)
        VALUES
            (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            PassportExpiry = VALUES(PassportExpiry),
            FirstName = VALUES(FirstName),
            LastName = VALUES(LastName),
            BirthDate = VALUES(BirthDate)
    ");
    $passportStmt->execute([
        $p['passportNumber'],
        $p['passportExpiry'],
        $p['firstName'],
        $p['lastName'],
        $p['birthDate']
    ]);

    $passengerStmt = $conn->prepare("
        INSERT INTO passenger
            (PassportNumber, PassengerNumber)
        VALUES
            (?, ?)
    ");
    $passengerStmt->execute([
        $p['passportNumber'],
        $index + 1 // PassengerNumber starts from 1
    ]);

    $ticketID = strtoupper(str_pad(dechex($nextTicketID), 4, '0', STR_PAD_LEFT));
    $nextTicketID++;

    $ticketStmt = $conn->prepare("
        INSERT INTO ticket (TicketID, BookingID, PassengerPassportNumber)
        VALUES (?, ?, ?)
    ");
    $ticketStmt->execute([
        $ticketID,
        $bookingID,
        $p['passportNumber']
    ]);
}
