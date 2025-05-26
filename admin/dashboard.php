<?php

// Add session checking here (wala pa table for admins)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>

<body>
    <div id="nav-placeholder"></div>
    <script>
        fetch("../components/admin_navbar.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("nav-placeholder").innerHTML = data;
            });
    </script>

    <main>
        <h1>Administrator Dashboard</h1>
        <div id="infos">
            <div class="info-box">
                <h2>Total Users</h2>
                <h1>500</h1>
            </div>
            <div class="info-box">
                <h2>Total Admins</h2>
                <h1>10</h1>
            </div>
            <div class="info-box">
                <h2>Total Passengers</h2>
                <h1>10238</h1>
            </div>
            <div class="info-box">
                <h2>Number of Flights</h2>
                <h1>134</h1>
            </div>
        </div>
    </main>

</body>

</html>