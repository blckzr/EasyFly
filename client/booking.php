<?php include '../components/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EasyFly - Book a Flight</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/booking.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
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

  <!-- Navigation -->
  <?php
  $curr_page = 'book';
  include '../components/header.php';
  ?>

  <!-- Progress Indicator -->
  <div class="progress-container">
    <div class="progress-steps">
      <div class="step active" data-step="1">
        <div class="step-number">1</div>
        <div class="step-text">Select Flight</div>
      </div>
      <!-- <div class="step-line"></div>
      <div class="step" data-step="2">
        <div class="step-number">2</div>
        <div class="step-text">Booking Details</div>
      </div>
      <div class="step-line"></div>
      <div class="step" data-step="3">
        <div class="step-number">3</div>
        <div class="step-text">Booker Details</div>
      </div> -->
      <div class="step-line"></div>
      <div class="step" data-step="2">
        <div class="step-number">2</div>
        <div class="step-text">Passengers</div>
      </div>
      <!-- <div class="step-line"></div>
      <div class="step" data-step="5">
        <div class="step-number">5</div>
        <div class="step-text">Summary</div>
      </div> -->
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-container">
    <!-- Step 1: Select Flight -->
    <div class="section active" id="step-1">
      <div class="section-header">
        <h2><i class="fas fa-plane-departure"></i> Select Flight</h2>
        <p>Choose your preferred flight</p>
      </div>

      <div class="form-container">
        <!-- Trip Type -->
        <div class="trip-type-section">
          <div class="radio-group horizontal">
            <label class="radio-option">
              <input type="radio" name="itinerary" value="ROUND" />
              <span class="radio-custom"></span>
              <span>Round Trip</span>
            </label>
            <label class="radio-option">
              <input type="radio" name="itinerary" value="ONEWAY" checked />
              <span class="radio-custom"></span>
              <span>One Way</span>
            </label>
          </div>
        </div>

        <!-- Class Selection -->
        <div class="class-selection-section">
          <div class="form-group">
            <label class="form-label">
              <i class="fas fa-chair"></i> Class
            </label>
            <select class="form-select class-select">
              <option value="ECONOMY">Economy</option>
              <option value="PREMIUM_ECONOMY">Premium Economy</option>
              <option value="BUSINESS">Business</option>
              <option value="FIRST">First Class</option>
            </select>
          </div>
        </div>

        <!-- Flight Options -->
        <div id="flight-options">
          <div style="padding:1em;text-align:center;">Loading flights...</div>
          <script>
            // Initial fetch to load flight options
            document.addEventListener('DOMContentLoaded', function() {
              updateFlightOptions('ONEWAY');
            });
          </script>
        </div>

        <script>
          // Helper to fetch and update flight options
          function updateFlightOptions(itinerary) {
            const flightOptionsDiv = document.getElementById('flight-options');
            flightOptionsDiv.innerHTML = '<div style="padding:1em;text-align:center;">Loading flights...</div>';
            fetch('booking_flights.php?itinerary=' + encodeURIComponent(itinerary))
              .then(res => res.text())
              .then(html => {
                flightOptionsDiv.innerHTML = html;
              })
              .catch(() => {
                flightOptionsDiv.innerHTML = '<div style="color:red;text-align:center;">Failed to load flights.</div>';
              });
          }

          // Listen for trip type change
          document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="itinerary"]').forEach(function(radio) {
              radio.addEventListener('change', function() {
                updateFlightOptions(this.value);
              });
            });
          });
        </script>
        <script>
          options = document.querySelectorAll('.flight-option');

          function proceedToPassenger(itinerary, flightNumber, retFlightNumber) {
            let url = `passenger.php?itinerary=${itinerary}&flightNumber=${flightNumber}`;
            if (retFlightNumber) {
              url += `&retFlightNumber=${retFlightNumber}`;
            }
            window.location.href = url;
          }
          options.forEach(option => {
            option.addEventListener('click', proceedToPassenger);
          });
        </script>
      </div>
    </div>
  </div>

  <!-- Step 2: Booking Details -->
  <div class="section" id="step-2">
    <div class="section-header">
      <h2><i class="fas fa-search"></i> Booking Details</h2>
      <p>Confirm your travel preferences</p>
    </div>

    <div class="form-container">
      <!-- Main Search Form -->
      <div class="search-form">
        <div class="location-row">
          <div class="form-group location-group">
            <label for="departure-from" class="form-label">
              <i class="fas fa-plane-departure"></i> Departure From
            </label>
            <input
              type="text"
              id="departure-from"
              class="form-input"
              disabled
              placeholder="Will be auto-filled" />
          </div>

          <div class="swap-button">
            <button type="button" class="btn-swap" disabled>
              <i class="fas fa-exchange-alt"></i>
            </button>
          </div>

          <div class="form-group location-group">
            <label for="arrival-to" class="form-label">
              <i class="fas fa-plane-arrival"></i> Arrive To
            </label>
            <input
              type="text"
              id="arrival-to"
              class="form-input"
              disabled
              placeholder="Will be auto-filled" />
          </div>
        </div>

        <div class="date-class-row">
          <div class="form-group">
            <label for="departure-date" class="form-label">
              <i class="fas fa-calendar-alt"></i> Departure Date
            </label>
            <input
              type="date"
              id="departure-date"
              class="form-input date-input"
              disabled />
          </div>

          <div class="form-group" id="return-date-group">
            <label for="return-date" class="form-label">
              <i class="fas fa-calendar-alt"></i> Return Date
            </label>
            <input
              type="date"
              id="return-date"
              class="form-input date-input"
              disabled />
          </div>
        </div>

        <div class="search-button-container">
          <button class="btn btn-search" onclick="nextStep()">
            <i class="fas fa-check"></i> Confirm Details
          </button>
        </div>
      </div>

      <div class="button-group mt-4">
        <button class="btn btn-secondary" onclick="prevStep()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
      </div>
    </div>
  </div>

  <!-- Step 3: Booker Details -->
  <div class="section" id="step-3">
    <div class="section-header">
      <h2><i class="fas fa-user"></i> Booker Details</h2>
      <p>Enter your personal information</p>
    </div>

    <div class="form-container">
      <div class="form-grid">
        <div class="form-group">
          <label for="booker-fn" class="form-label">First Name *</label>
          <input
            type="text"
            id="booker-fn"
            class="form-input"
            placeholder="Enter first name" />
        </div>
        <div class="form-group">
          <label for="booker-ln" class="form-label">Last Name *</label>
          <input
            type="text"
            id="booker-ln"
            class="form-input"
            placeholder="Enter last name" />
        </div>
        <div class="form-group">
          <label for="booker-passport" class="form-label">
            Passport Number *
          </label>
          <input
            type="text"
            id="booker-passport"
            class="form-input"
            placeholder="e.g., P2658972A" />
        </div>
        <div class="form-group">
          <label for="booker-email" class="form-label">Email Address *</label>
          <input
            type="email"
            id="booker-email"
            class="form-input"
            placeholder="Enter email address" />
        </div>
        <div class="form-group">
          <label for="booker-tel" class="form-label">Telephone *</label>
          <input
            type="tel"
            id="booker-tel"
            class="form-input"
            placeholder="Enter phone number" />
        </div>
        <div class="form-group">
          <label for="booker-address" class="form-label">Address *</label>
          <input
            type="text"
            id="booker-address"
            class="form-input"
            placeholder="Enter street address" />
        </div>
        <div class="form-group">
          <label for="booker-city" class="form-label">City *</label>
          <input
            type="text"
            id="booker-city"
            class="form-input"
            placeholder="Enter city" />
        </div>
        <div class="form-group">
          <label for="booker-postal" class="form-label">Postal Code *</label>
          <input
            type="text"
            id="booker-postal"
            class="form-input"
            placeholder="Enter postal code" />
        </div>
        <div class="form-group">
          <label for="booker-country" class="form-label">Country *</label>
          <input
            type="text"
            id="booker-country"
            class="form-input"
            placeholder="Enter country" />
        </div>
      </div>
      <div class="button-group">
        <button class="btn btn-secondary" onclick="prevStep()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-primary" onclick="nextStep()">
          Continue <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Step 4: Passenger Information -->
  <div class="section" id="step-4">
    <div class="section-header">
      <h2><i class="fas fa-users"></i> Passenger Information</h2>
      <p>Add passenger details (optional)</p>
    </div>

    <div class="form-container">
      <div id="passengers-container"></div>
      <button class="add-passenger-btn" onclick="addPassenger()">
        <i class="fas fa-plus"></i> Add Passenger
      </button>
      <div class="button-group">
        <button class="btn btn-secondary" onclick="prevStep()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-primary" onclick="nextStep()">
          Continue <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Step 5: Booking Summary -->
  <div class="section" id="step-5">
    <div class="section-header">
      <h2><i class="fas fa-check-circle"></i> Booking Summary</h2>
      <p>Review your booking details</p>
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
              <span class="booking-id-value" id="summary-booking-id"></span>
            </div>
            <div class="flight-route">
              <div class="route-info">
                <div class="route-from">
                  <span class="route-label">From</span>
                  <span class="route-value" id="summary-from"></span>
                </div>
                <div class="route-arrow">
                  <i class="fas fa-arrow-right"></i>
                </div>
                <div class="route-to">
                  <span class="route-label">To</span>
                  <span class="route-value" id="summary-to"></span>
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
                    id="summary-flight-number"></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-calendar"></i>
                <div>
                  <span class="detail-label">Departure</span>
                  <span
                    class="detail-value"
                    id="summary-departure-date"></span>
                </div>
              </div>
              <div class="detail-item" id="summary-return-row">
                <i class="fas fa-calendar-check"></i>
                <div>
                  <span class="detail-label">Return</span>
                  <span
                    class="detail-value"
                    id="summary-return-date"></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-chair"></i>
                <div>
                  <span class="detail-label">Class</span>
                  <span class="detail-value" id="summary-class"></span>
                </div>
              </div>
              <div class="detail-item">
                <i class="fas fa-route"></i>
                <div>
                  <span class="detail-label">Type</span>
                  <span class="detail-value" id="summary-itinerary"></span>
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
          <div class="summary-card-content" id="summary-booker"></div>
        </div>

        <div class="summary-card passengers-summary">
          <div class="summary-card-header">
            <i class="fas fa-users"></i>
            <h3>Passengers</h3>
          </div>
          <div class="summary-card-content" id="summary-passengers"></div>
        </div>
      </div>

      <div class="button-group">
        <button class="btn btn-secondary" onclick="prevStep()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-success" onclick="confirmBooking()">
          <i class="fas fa-credit-card"></i> Confirm Booking
        </button>
      </div>
    </div>
  </div>
  </div>

  <script src="booking.js"></script>
</body>

</html>