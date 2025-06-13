<?php
header('Content-Type: application/json');
include '../../components/connect.php'; // Include the database connection

$sql = 
    "WITH RankedBookings AS (
        SELECT
            b.PassportNumber,
            COUNT(*) AS total_bookings,
            DENSE_RANK() OVER (ORDER BY COUNT(*) DESC) AS rank
        FROM bookings b
        GROUP BY b.PassportNumber
    )
    SELECT PassportNumber, total_bookings
    FROM RankedBookings
    WHERE rank <= 5
    ORDER BY total_bookings DESC;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$top_bookers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($top_bookers);
