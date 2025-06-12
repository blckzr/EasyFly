<?php
header('Content-Type: application/json');
include '../../components/connect.php'; // Include the database connection

$sql = "SELECT b.PassportNumber, COUNT(*) as total_bookings
    FROM bookings b
    GROUP BY b.PassportNumber
    ORDER BY total_bookings DESC
    LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->execute();
$top_bookers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($top_bookers);
