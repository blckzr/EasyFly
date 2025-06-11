<?php
include '../components/connect.php'; // Include the database connection 

$itinerary = isset($_GET['itinerary']) ? $_GET['itinerary'] : 'ONEWAY';
$flightNumber = isset($_GET['flightNumber']) ? $_GET['flightNumber'] : '';
$roundFlightNumber = isset($_GET['roundFlightNumber']) ? $_GET['roundFlightNumber'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Passengers</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/booking.css">
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

    <?php
    $curr_page = 'book'; // Set the current page for active link highlighting
    include '../components/header.php'; // Include the header component
    ?>

    <!-- Progress Indicator -->
    <div class="progress-container">
        <div class="progress-steps">
            <div class="step" data-step="1">
                <div class="step-number">1</div>
                <div class="step-text">Select Flight</div>
            </div>
            <div class="step-line"></div>
            <div class="step active" data-step="2">
                <div class="step-number">2</div>
                <div class="step-text">Passengers</div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="section active" id="step-4">
            <div class="section-header">
                <h2><i class="fas fa-users"></i> Passenger Information</h2>
                <p>Add passenger details</p>
            </div>

            <div class="form-container">
                <div id="passengers-container"></div>
                <button class="add-passenger-btn" onclick="addPassenger()">
                    <i class="fas fa-plus"></i> Add Passenger
                </button>

                <div class="button-group">
                    <button class="btn btn-secondary" onclick="submitPassengers()">
                        <i class="fas fa-check"></i> Finalize Booking
                    </button>
                </div>
            </div>
        </div>

        <script>
            let passengerCount = 0;

            function addPassenger() {
                passengerCount++
                const container = document.getElementById("passengers-container")

                const passengerCard = document.createElement("div")
                passengerCard.className = "passenger-card"
                passengerCard.id = `passenger-${passengerCount}`

                passengerCard.innerHTML = `
        <div class="passenger-header">
            <h4 class="passenger-title">Passenger ${passengerCount}</h4>
            <button class="remove-btn" onclick="removePassenger(${passengerCount})">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">First Name *</label>
                <input type="text" class="form-input passenger-fn" placeholder="Enter first name" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Last Name *</label>
                <input type="text" class="form-input passenger-ln" placeholder="Enter last name" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Birth Date</label>
                <input type="date" class="form-input passenger-bd" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">
                    Passport Number *
                    <span class="field-hint">e.g., P2658972A, AB123456, etc.</span>
                </label>
                <input type="text" class="form-input passenger-passport" placeholder="e.g., P2658972A" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Passport Expiry</label>
                <input type="date" class="form-input passenger-expiry" data-passenger="${passengerCount}">
            </div>
        </div>
    `

                container.appendChild(passengerCard)
            }

            function removePassenger(id) {
                const passengerCard = document.getElementById(`passenger-${id}`)
                if (passengerCard) {
                    passengerCard.remove()
                }
            }

            function getPassengerData() {
                const passengers = []
                const passengerCards = document.querySelectorAll(".passenger-card")

                passengerCards.forEach(card => {
                    const firstName = card.querySelector(".passenger-fn").value.trim()
                    const lastName = card.querySelector(".passenger-ln").value.trim()
                    const birthDate = card.querySelector(".passenger-bd").value
                    const passportNumber = card.querySelector(".passenger-passport").value.trim()
                    const passportExpiry = card.querySelector(".passenger-expiry").value

                    if (firstName && lastName && passportNumber) {
                        passengers.push({
                            firstName,
                            lastName,
                            birthDate,
                            passportNumber,
                            passportExpiry
                        })
                    }
                })

                return passengers
            }

            function submitPassengers() {
                const passengers = getPassengerData()
                if (passengers.length === 0) {
                    alert("Please add at least one passenger.")
                    return
                }

                const itinerary = "<?php echo $itinerary; ?>";
                const flightNumber = "<?php echo $flightNumber; ?>";
                const roundFlightNumber = "<?php echo $roundFlightNumber; ?>";

                // Redirect to the payment page with passenger data
                const queryParams = new URLSearchParams({
                    itinerary,
                    flightNumber,
                    roundFlightNumber,
                    passengers: JSON.stringify(passengers)
                }).toString()

                window.location.href = `booking_finalize.php?${queryParams}`
            }
        </script>
</body>

</html>