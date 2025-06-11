<?php
header('Content-Type: application/json');

include '../../components/connect.php';

$sql = "
    SELECT 
        MONTHNAME(bookings.BookingDate) as month, 
        COUNT(*) AS pass_count 
    FROM ticket 
    INNER JOIN 
        bookings ON ticket.BookingID = bookings.BookingID 
    WHERE 
        YEAR(bookings.BookingDate) = YEAR(CURDATE()) 
    GROUP BY 
        MONTHNAME(bookings.BookingDate) 
    ORDER BY 
        MONTH(bookings.BookingDate); 
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
