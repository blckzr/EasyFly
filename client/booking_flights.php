<?php
include '../components/connect.php';

$today = date('Y-m-d');
$itinerary = isset($_GET['itinerary']) ? $_GET['itinerary'] : 'ONEWAY';

if ($itinerary === 'ROUND') {
    $stmt = $conn->prepare("
        SELECT 
            f1.FlightNumber AS OutFlightNumber,
            f1.FlightDate AS OutFlightDate,
            f1.FlightTime AS OutFlightTime,
            f1.FlightFrom AS OutFlightFrom,
            f1.FlightTo AS OutFlightTo,
            f2.FlightNumber AS RetFlightNumber,
            f2.FlightDate AS RetFlightDate,
            f2.FlightTime AS RetFlightTime
        FROM flight_history f1
        JOIN flight_history f2
            ON f1.FlightFrom = f2.FlightTo
            AND f1.FlightTo = f2.FlightFrom
            AND f2.FlightDate > f1.FlightDate
        WHERE f1.FlightDate >= ?
        ORDER BY f1.FlightDate, f1.FlightTime, f2.FlightDate, f2.FlightTime
        LIMIT 20
    ");
    $stmt->execute([$today]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
        <div class="flight-option" onclick="proceedToPassenger('<?php echo $itinerary; ?>', '<?php echo $row['OutFlightNumber']; ?>', '<?php echo $row['RetFlightNumber']; ?>');">
            <div class="flight-header">
                <div class="flight-number"><?php echo htmlspecialchars($row['OutFlightNumber']); ?> &rarr; <?php echo htmlspecialchars($row['RetFlightNumber']); ?></div>
                <div class="flight-price">--</div>
            </div>
            <div class="flight-details">
                <div class="flight-time">
                    <div class="time"><?php echo htmlspecialchars(substr($row['OutFlightTime'], 0, 5)); ?></div>
                    <div class="airport"><?php echo htmlspecialchars($row['OutFlightFrom']); ?></div>
                </div>
                <div class="flight-duration">
                    <div class="duration-text"><?php echo htmlspecialchars($row['OutFlightDate']); ?> (Departure)</div>
                    <div class="duration-display">
                        <div class="duration-line"></div>
                        <i class="fas fa-plane duration-plane"></i>
                        <div class="duration-line"></div>
                    </div>
                    <div class="duration-text"><?php echo htmlspecialchars($row['RetFlightDate']); ?> (Return)</div>
                </div>
                <div class="flight-time">
                    <div class="time"><?php echo htmlspecialchars(substr($row['RetFlightTime'], 0, 5)); ?></div>
                    <div class="airport"><?php echo htmlspecialchars($row['OutFlightTo']); ?></div>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    $stmt = $conn->prepare("SELECT FlightNumber, FlightDate, FlightTime, FlightFrom, FlightTo FROM flight_history WHERE FlightDate >= ? ORDER BY FlightDate, FlightTime LIMIT 20");
    $stmt->execute([$today]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <div class="flight-option" onclick="proceedToPassenger('<?php echo $itinerary; ?>', '<?php echo $row['FlightNumber']; ?>', null);">
            <div class="flight-header">
                <div class="flight-number"><?php echo htmlspecialchars($row['FlightNumber']); ?></div>
                <div class="flight-price">--</div>
            </div>
            <div class="flight-details">
                <div class="flight-time">
                    <div class="time"><?php echo htmlspecialchars(substr($row['FlightTime'], 0, 5)); ?></div>
                    <div class="airport"><?php echo htmlspecialchars($row['FlightFrom']); ?></div>
                </div>
                <div class="flight-duration">
                    <div class="duration-text"><?php echo htmlspecialchars($row['FlightDate']); ?></div>
                    <div class="duration-display">
                        <div class="duration-line"></div>
                        <i class="fas fa-plane duration-plane"></i>
                        <div class="duration-line"></div>
                    </div>
                </div>
                <div class="flight-time">
                    <div class="time">--:--</div>
                    <div class="airport"><?php echo htmlspecialchars($row['FlightTo']); ?></div>
                </div>
            </div>
        </div>
<?php
    }
}
?>