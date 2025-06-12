<?php
header('Content-Type: application/json');
include '../../components/connect.php'; // Include the database connection

$sql = "SELECT 
            DAYNAME(DepDate) as weekday_name, 
            COUNT(*) as flight_count
        FROM bookings
        WHERE DepDate >= CURDATE() - INTERVAL (WEEKDAY(CURDATE()) + 1) DAY
        GROUP BY weekday_name
        ORDER BY FIELD(weekday_name, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')";

$stmt = $conn->prepare($sql);
$stmt->execute();
$flight_counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($flight_counts);
