<?php
header('Content-Type: application/json');
include '../../components/connect.php';

$sql = "
    WITH RankedDestinations AS (
        SELECT
            FlightTo,
            COUNT(*) AS count,
            DENSE_RANK() OVER (ORDER BY COUNT(*) DESC) AS rank
        FROM flight_history
        GROUP BY FlightTo
    )

    SELECT FlightTo, count
    FROM RankedDestinations
    WHERE rank <= 5
    ORDER BY count DESC;
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
