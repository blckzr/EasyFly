<?php
header('Content-Type: application/json');
include '../../components/connect.php';

$sql = "
    SELECT
        DAYNAME(fh.FlightDate) AS weekday,
        fh.FlightNumber AS flight_num
    FROM
        flight_history fh
    WHERE
        fh.FlightDate BETWEEN
            DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
        AND
            DATE_ADD(CURDATE(), INTERVAL (6 - WEEKDAY(CURDATE())) DAY);
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
