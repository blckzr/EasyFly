<?php
header('Content-Type: application/json');
include '../../components/connect.php'; // Include the database connection

// Fetch total staff count
$sql = "SELECT COUNT(*) AS total_staff FROM staff";

$stmt = $conn->prepare($sql);
$stmt->execute();
$total_staff = $stmt->fetch(PDO::FETCH_ASSOC);

// Return the total staff count as JSON
echo json_encode($total_staff);
