<?php

// Add session checking here (wala pa table for admins)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

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
        <div id="infos">
            <div class="info-box info-yellow">
                <h2>Total Users</h2>
                <h1>500</h1>
            </div>
            <div class="info-box info-blue">
                <h2>Total Admins</h2>
                <h1>10</h1>
            </div>
            <div class="info-box info-purple">
                <h2>Total Passengers</h2>
                <h1>10238</h1>
            </div>
            <div class="info-box info-green">
                <h2>Number of Flights</h2>
                <h1>134</h1>
            </div>
        </div>
        <div id="graph-table-container">
            <div id="graph-container">
                <h2>Monthly Passengers</h2>
            </div>
            <div id="table-container">
                <h2>Flights This Week</h2>
                <table class="table table-striped fs-4">
                    <thead>
                        <tr>
                            <th scope="col">Day</th>
                            <th scope="col">Flight Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>MON</td>
                            <td>TKYMNL-1130</td>
                        </tr>
                        <tr>
                            <td>MON</td>
                            <td>TKYMNL-1130</td>
                        </tr>
                        <tr>
                            <td>MON</td>
                            <td>TKYMNL-1130</td>
                        </tr>
                        <tr>
                            <td>MON</td>
                            <td>TKYMNL-1130</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <!-- D3js for Bar Graph -->
    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>

    <script src="../js/admin_dashboard.js"></script>
</body>

</html>