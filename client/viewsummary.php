<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyFly - Book a Flight</title>
    <link rel="stylesheet" href="../css/book.css" />
  </head>
  <body>
    <!-- Summary Section -->
    <div class="section" id="summary-section" style="display: none">
      <h3 class="summary-title">Booking Summary</h3>
      <div class="summary-box">
        <div class="summary-left">
          <p><strong>Booking ID:</strong> <span id="booking-id"></span></p>
          <p><strong>Flight Number:</strong> EF1234</p>
          <p>
            <strong>Departure Date:</strong>
            <span id="summary-departure-date"></span>
          </p>
          <p>
            <strong>Arrival Date:</strong>
            <span id="summary-arrival-date"></span>
          </p>
        </div>
        <div class="summary-right">
          <p><strong>Class:</strong> <span id="summary-class"></span></p>
          <p>
            <strong>Itinerary:</strong> <span id="summary-itinerary"></span>
          </p>
          <p>
            <strong>Passenger Information:</strong>
            <span id="passenger-names"></span>
          </p>
          <p>
            <strong>Ticket ID(s):</strong> Will be generated after confirmation.
          </p>
        </div>
      </div>
      <div class="btn-group">
        <button onclick="showSection('passenger-section')">Back</button>
        <button onclick="alert('Booking Confirmed!')">Confirm</button>
      </div>
    </div>

    <script src="book.js"></script>
  </body>
</html>
