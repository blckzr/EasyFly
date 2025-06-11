<?php
header('Content-Type: application/json');
include '../../components/connect.php';

$sql = "
    SELECT 
        COUNT(*) AS total_passengers 
    FROM 
        ticket
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
