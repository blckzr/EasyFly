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
        <h1>Booking List</h1>
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
    </div>
    <?php
    include '../components/footer.php'; // Include the footer component
    ?>
    <script>
        // Fetch the booking list when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchBookingList();
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

        function displayBookings(bookings) {
            const flightOptionsDiv = document.getElementById('flight-options');
            flightOptionsDiv.innerHTML = ''; // Clear previous content

            bookings.forEach(booking => {
                const flightOption = document.createElement('div');
                flightOption.className = 'flight-option';
                flightOption.innerHTML = `
                    <div class="flight-header">
                        <div class="flight-number">${booking.DepFlightNumber} &rarr; ${booking.ArrFlightNumber || '--'}</div>
                        <div class="flight-price">--</div>
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
                            <div class="airport">${booking.ArrTo || booking.DepTo}</div>
                        </div>
                    </div>`;
                flightOptionsDiv.appendChild(flightOption);
            });
        }
    </script>
</body>

</html>