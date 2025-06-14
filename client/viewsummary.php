<?php
$bookingId = $_GET['BookingID'] ?? null;

if (!$bookingId) {
    echo "Invalid flight details.";
    exit;
}

require '../components/connect.php';

// Get booking info
$stmt = $conn->prepare("SELECT * FROM bookings WHERE BookingID = ?");
$stmt->execute([$bookingId]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo "No booking found.";
    exit;
}

// Get flight info
$stmt3 = $conn->prepare("SELECT FlightNumber, FlightFrom, FlightTo FROM flight_history WHERE FlightNumber = ? AND FlightDate = ?");
$stmt3->execute([$booking['DepFlightNumber'], $booking['DepDate']]);
$flight = $stmt3->fetch(PDO::FETCH_ASSOC);

// Get booker info using PassportNumber
$passportNumber = $booking['PassportNumber'];
$stmt2 = $conn->prepare("SELECT * FROM booker WHERE PassportNumber = ?");
$stmt2->execute([$passportNumber]);
$booker = $stmt2->fetch(PDO::FETCH_ASSOC);

// Get passport info using PassportNumber
$passportNumber = $booking['PassportNumber'];
$stmt4 = $conn->prepare("SELECT * FROM passport WHERE PassportNumber = ?");
$stmt4->execute([$passportNumber]);
$user = $stmt4->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyFly - Flight Summary</title>
    <link rel="stylesheet" href="../css/viewsummary.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
<body>
    <?php
        include '../components/header.php';
    ?>
    <div class="background-slideshow">
        <div
        class="bg-slide active"
        style="
            background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/bookbg-yTtodtOJBvbbS4GUOTsieccHHbLDIs.png');
            "></div>
        <div
        class="bg-slide"
        style="
            background-image: url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            "></div>
        <div
        class="bg-slide"
        style="
            background-image: url('https://images.unsplash.com/photo-1569154941061-e231b4725ef1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            "></div>
        <div
        class="bg-slide"
        style="
            background-image: url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            "></div>
        <div
        class="bg-slide"
        style="
            background-image: url('https://images.unsplash.com/photo-1583500178690-f7fd646d4d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            "></div>
    </div>
    <div class="background-overlay"></div>    

    <!-- Main Content -->
  <div class="main-container">
  <!-- Step 5: Booking Summary -->
  <div class="section" id="step-5">
    <div class="section-header">
      <br>
      <h2><i class="fas fa-check-circle"></i> Flight Summary</h2>
    </div>

    <div class="form-container">
      <div class="summary-container">
        <div class="summary-card flight-summary">
          <div class="summary-card-header">
            <i class="fas fa-plane-departure"></i>
            <h3>Flight Information</h3>
          </div>
          <div class="summary-card-content">
            <div class="booking-id-badge">
              <span class="booking-id-label">Booking ID</span>
              <span class="booking-id-value" id="summary-booking-id"><?= htmlspecialchars($bookingId) ?></span>
            </div>
            <div class="flight-route">
              <div class="route-info">
                <div class="route-from">
                  <span class="route-label">From</span>
                  <span class="route-value" id="summary-from"><?= htmlspecialchars($flight['FlightFrom']) ?></span>
                </div>
                <div class="route-arrow">
                  <i class="fas fa-arrow-right"></i>
                </div>
                <div class="route-to">
                  <span class="route-label">To</span>
                  <span class="route-value" id="summary-to"><?= htmlspecialchars($flight['FlightTo']) ?></span>
                </div>
              </div> 
            </div>
            <div class="flight-details-grid">
              <div class="detail-item">
                <i class="fas fa-plane"></i>
                <div>
                  <span class="detail-label">Flight Number</span>
                  <span
                    class="detail-value"
                    id="summary-flight-number"><?= htmlspecialchars($booking['DepFlightNumber']) ?></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-calendar"></i>
                <div>
                  <span class="detail-label">Departure</span>
                  <span
                    class="detail-value"
                    id="summary-departure-date"><?= htmlspecialchars($booking['DepDate']) ?></span>
                </div>
              </div>
              <div class="detail-item" id="summary-return-row">
                <i class="fas fa-calendar-check"></i>
                <div>
                  <span class="detail-label">Return</span>
                  <span
                    class="detail-value"
                    id="summary-return-date"><?php echo isset($booking['ArrDate']) ? htmlspecialchars($booking['ArrDate']) : 'N/A'; ?></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-chair"></i>
                <div>
                  <span class="detail-label">Class</span>
                  <span class="detail-value" id="summary-class"><?= htmlspecialchars($booking['Class']) ?></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-route"></i>
                <div>
                  <span class="detail-label">Type</span>
                  <span class="detail-value" id="summary-itinerary"><?= htmlspecialchars($booking['ItineraryType']) ?> TRIP</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="summary-card booker-summary">
          <div class="summary-card-header">
            <i class="fas fa-user"></i>
            <h3>Booker Information</h3>
          </div>
          <div class="summary-card-content" id="summary-booker">
            <div class="detail-item">
              <i class="fas fa-user"></i>
              <div>
                  <span class="detail-label">Name</span>
                  <span class="detail-value"><?=  htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']) ?></span>
              </div>
          </div>
          <div class="detail-item">
              <i class="fas fa-passport"></i>
              <div>
                  <span class="detail-label">Passport</span>
                  <span class="detail-value"><?=  htmlspecialchars($user['PassportNumber']) ?></span>
              </div>
          </div>
          <div class="detail-item">
              <i class="fas fa-envelope"></i>
              <div>
                  <span class="detail-label">Email</span>
                  <span class="detail-value"><?=  htmlspecialchars($booker['Email']) ?></span>
              </div>
          </div>
          <div class="detail-item">
              <i class="fas fa-phone"></i>
              <div>
                  <span class="detail-label">Phone</span>
                  <span class="detail-value"><?=  htmlspecialchars($booker['Telephone']) ?></span>
              </div>
          </div>
          <div class="detail-item">
              <i class="fas fa-map-marker-alt"></i>
              <div>
                  <span class="detail-label">Address</span>
                  <span class="detail-value"><?=  htmlspecialchars($booker['Address'] . ' ' . $booker['City']) ?></span>
              </div>
          </div>
          </div>
        </div>
      </div>

      <a class="button-group" href="../client/booklist.php" style="text-decoration: none;">
        <button class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Back
        </button>
      </a>
    </div>
  </div>
  </div>
  </body>
</html>
