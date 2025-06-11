<?php
header('Content-Type: application/json');
include '../../components/connect.php';

$sql = "
    SELECT COUNT(*) AS total_flights
    FROM flight_history;
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
