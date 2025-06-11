<?php
header('Content-Type: application/json');
include '../../components/connect.php';

$sql = "
    SELECT FlightTo, COUNT(*) AS count 
    FROM flight_history 
    GROUP BY FlightTo 
    ORDER BY count DESC 
    LIMIT 5;
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
