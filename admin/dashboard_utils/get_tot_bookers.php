<?php
header('Content-Type: application/json');
include '../../components/connect.php'; // Include the database connection

$sql = "SELECT COUNT(*) AS total_bookers FROM booker";
$stmt = $conn->prepare($sql);
$stmt->execute();
$total_bookers = $stmt->fetch(PDO::FETCH_ASSOC);

// Return the total bookers count as JSON
echo json_encode($total_bookers);
