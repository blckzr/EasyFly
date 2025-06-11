<?php
include 'connect.php'; // update with your actual connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $originalFlightNumber = $_POST['originalFlightNumber'] ?? '';

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM flight_history WHERE FlightNumber = :flightNumber");
        $stmt->execute([':flightNumber' => $originalFlightNumber]);
        header("Location: ../admin/flight_logs.php?message=deleted");
        exit;
    }

    if ($action === 'save') {
        $newFlightNumber = $_POST['flightNumber'] ?? '';
        $from = $_POST['from'] ?? '';
        $to = $_POST['to'] ?? '';
        $time = $_POST['time'] ?? '';
        $date = $_POST['date'] ?? '';

        $stmt = $conn->prepare("UPDATE flight_history SET
            FlightNumber = :newFlightNumber,
            FlightFrom = :from,
            FlightTo = :to,
            FlightTime = :time,
            FlightDate = :date
            WHERE FlightNumber = :originalFlightNumber
        ");

        $stmt->execute([
            ':newFlightNumber' => $newFlightNumber,
            ':from' => $from,
            ':to' => $to,
            ':time' => $time,
            ':date' => $date,
            ':originalFlightNumber' => $originalFlightNumber
        ]);

        header("Location: ../admin/flight_logs.php?message=updated");
        exit;
    }

    if ($action === 'add') {
        $newFlightNumber = $_POST['flightNumber'] ?? '';
        $from = $_POST['from'] ?? '';
        $to = $_POST['to'] ?? '';
        $time = $_POST['time'] ?? '';
        $date = $_POST['date'] ?? '';

        $stmt = $conn->prepare("INSERT INTO flight_history 
            (FlightNumber, FlightFrom, FlightTo, FlightTime, FlightDate)
            VALUES (:flightNumber, :from, :to, :time, :date)
        ");

        $stmt->execute([
            ':flightNumber' => $newFlightNumber,
            ':from' => $from,
            ':to' => $to,
            ':time' => $time,
            ':date' => $date
        ]);

        header("Location: ../admin/flight_logs.php?message=added");
        exit;
    }
}
?>
