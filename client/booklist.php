<?php
include '../components/session_check.php'; // Ensure user is logged in
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/booklist.css">
</head>

<body>
    <?php
    $curr_page = 'book_list'; // Set the current page for active link highlighting
    include '../components/header.php';
    ?>
    <div id="background"></div>
    <div id="page">
        <h1>Your Booking List</h1>
        <p>Bookings made with your passport number <strong><?php echo $_SESSION['passport_number']; ?></strong>.</p>
        <div id="flight-options">
            <!-- PP0090572804BH test passport number -->
            <!-- 
            SELECT
                b.*,
                dfh.FlightTime as DepTime,
                dfh.FlightFrom as DepFrom,
                dfh.FlightTo as DepTo,
                afh.FlightTime as ArrTime,
                afh.FlightFrom as ArrFrom,
                afh.FlightTo as ArrTo
            FROM
                bookings b 
            INNER JOIN
                flight_history dfh ON dfh.FlightNumber = b.DepFlightNumber AND dfh.FlightDate = b.DepDate
            LEFT JOIN
                flight_history afh ON afh.FlightNumber = b.ArrFlightNumber AND afh.FlightDate = b.ArrDate
            WHERE
                b.PassportNumber = "PP0090572804BH"; 
            -->
        </div>
        <h1>Your Flights</h1>
        <p>Bookings where you are the passenger.</p>
        <div id="booking-options">

        </div>
    </div>
    <?php
    include '../components/footer.php'; // Include the footer component
    ?>
    <script>
        // Fetch the booking list when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchBookingList();
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetchFlightList();
        });

        function fetchBookingList() {
            const passportNumber = "<?php echo $_SESSION['passport_number']; ?>"; // Get the passport number from session
            fetch(`../client/get_booklist.php?passport=${passportNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        document.getElementById('flight-options').innerHTML = '<p>You have not made any bookings yet. Click <a href="./booking.php">here</a> to book now.</p>';
                    } else {
                        displayBookings(data.bookings);
                    }
                })
                .catch(error => console.error('Error fetching booking list:', error));
        }

        function fetchFlightList() {
            const passportNumber = "<?php echo $_SESSION['passport_number']; ?>"; // Get the passport number from session
            fetch(`../client/get_flights_of_passport.php?passport=${passportNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        document.getElementById('booking-options').innerHTML = '<p>You are not booked for any flights.</p>';
                    } else {
                        displayFlightList(data.flights);
                    }
                })
                .catch(error => console.error('Error fetching flight list:', error));
        }

        function displayBookings(bookings) {
            const flightOptionsDiv = document.getElementById('flight-options');
            flightOptionsDiv.innerHTML = ''; // Clear previous content

            bookings.forEach(booking => {
                const flightOption = document.createElement('div');
                flightOption.className = 'flight-option';
                flightOption.innerHTML = `
                    <a href="viewsummary.php?BookingID=${booking.BookingID}">
                    <div class="flight-header">
                        <div class="flight-number">${booking.DepFlightNumber} &rarr; ${booking.ArrFlightNumber || '--'}</div>
                        <div class="flight-price">${booking.BookingID}</div>
                    </div>
                    <div class="flight-details">
                        <div class="flight-time">
                            <div class="time">${booking.DepTime}</div>
                            <div class="airport">${booking.DepFrom}</div>
                        </div>
                        <div class="flight-duration">
                            <div class="duration-text">${booking.DepDate} (Departure)</div>
                            <div class="duration-display">
                                <div class="duration-line"></div>
                                <i class="fas fa-plane duration-plane"></i>
                                <div class="duration-line"></div>
                            </div>
                            <div class="duration-text">${booking.ArrDate || '--'} (Return)</div>
                        </div>
                        <div class="flight-time">
                            <div class="time">${booking.ArrTime || '--'}</div>
                            <div class="airport">${booking.ArrFrom || booking.DepTo}</div>
                        </div>
                    </div>
                    </a>`;
                flightOptionsDiv.appendChild(flightOption);
            });
        }

        function displayFlightList(flights) {
            const bookingOptionsDiv = document.getElementById('booking-options');
            bookingOptionsDiv.innerHTML = ''; // Clear previous content

            flights.forEach(flight => {
                const flightOption = document.createElement('div');
                flightOption.className = 'flight-option';
                flightOption.innerHTML = `
                    <a href="viewsummary.php?BookingID=${flight.BookingID}">
                    <div class="flight-header">
                        <div class="flight-number">${flight.DepFlightNumber} &rarr; ${flight.ArrFlightNumber || '--'}</div>
                        <div class="flight-price">${flight.BookingID}</div>
                    </div>
                    <div class="flight-details">
                        <div class="flight-time">
                            <div class="time">${flight.DepTime}</div>
                            <div class="airport">${flight.DepFrom}</div>
                        </div>
                        <div class="flight-duration">
                            <div class="duration-text">${flight.DepDate} (Departure)</div>
                            <div class="duration-display">
                                <div class="duration-line"></div>
                                <i class="fas fa-plane duration-plane"></i>
                                <div class="duration-line"></div>
                            </div>
                            <div class="duration-text">${flight.ArrDate || '--'} (Return)</div>
                        </div>
                        <div class="flight-time">
                            <div class="time">${flight.ArrTime || '--'}</div>
                            <div class="airport">${flight.ArrFrom || flight.DepTo}</div>
                        </div>
                    </div>
                    </a>`;
                bookingOptionsDiv.appendChild(flightOption);
            });
        }
    </script>
</body>

</html>