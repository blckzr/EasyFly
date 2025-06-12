<?php
include '../components/connect.php';
include '../components/admin_session_check.php';

try {
    // Set number of records per page
    $limit = 10;

    // Get current page number from URL, default to 1
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

    // Calculate offset
    $offset = ($page - 1) * $limit;

    // Get total number of records for pagination
    $totalStmt = $conn->query("SELECT COUNT(*) FROM passport");
    $totalRows = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRows / $limit);

    // Main query with JOIN and pagination
    $sql = "
        SELECT 
            p.PassportNumber,
            p.FirstName,
            p.LastName,
            p.Birthdate,
            p.PassportExpiry,
            b.Email,
            b.Telephone,
            b.Address,
            b.PostalCode,
            b.City,
            b.Country
        FROM 
            passport p
        LEFT JOIN 
            booker b ON p.PassportNumber = b.PassportNumber
        ORDER BY 
            p.PassportNumber ASC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Logs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin_navbar.css">
    <link rel="stylesheet" href="../css/flight_logs.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success text-center">
            <?php if ($_GET['message'] === 'deleted') echo "Flight deleted successfully."; ?>
            <?php if ($_GET['message'] === 'updated') echo "Flight updated successfully."; ?>
        </div>
    <?php endif; ?>
    <div id="nav-placeholder"></div>
    <script>
        fetch("../components/admin_navbar.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("nav-placeholder").innerHTML = data;
            });
    </script>

    <main>
        <div class="container mt-4">
            <div class="flight-logs-container">
                <!-- <div class="filter-section">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <label>Show:</label>
                            <input type="text" id="limitInput" class="form-control form-control-sm" value="10" />
                        </div>
                        <div class="col-md-2">
                            <label>Date</label>
                            <select id="dateFilter" class="form-select">
                                <option selected>All</option>
                                <option>Today</option>
                                <option>This Week</option>
                                <option>This Month</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Time</label>
                            <select class="form-select" id="timeFilter">
                                <option selected>All</option>
                                <option>Morning</option>
                                <option>Afternoon</option>
                                <option>Evening</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-end">
                            <button id="filterBtn" class="btn btn-primary">Filter</button>
                            <button class="btn btn-primary new-flight-btn" href="#addFlight" data-toggle='modal'>New Flight</button>
                        </div>
                    </div>
                </div> -->

                <div class="table-responsive mt-4">
                    <table class="table table-striped fs-5">
                        <thead>
                            <tr>
                                <th scope="col">Passport Number</th>
                                <th scope="col">Passport Expiry</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Birthdate</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Postal Code</th>
                                <th scope="col">City</th>
                                <th scope="col">Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($results)): ?>
                                <?php foreach ($results as $row): ?>
                                    <?php
                                        $passportNumber = htmlspecialchars($row['PassportNumber']);
                                        $firstName = htmlspecialchars($row['FirstName']);
                                        $lastName = htmlspecialchars($row['LastName']);
                                        $birthdate = date("m/d/Y", strtotime($row['Birthdate']));
                                        $passportExpiry = date("m/d/Y", strtotime($row['PassportExpiry']));
                                        $email = htmlspecialchars($row['Email']);
                                        $telephone = htmlspecialchars($row['Telephone']);
                                        $address = htmlspecialchars($row['Address']);
                                        $postalCode = htmlspecialchars($row['PostalCode']);
                                        $city = htmlspecialchars($row['City']);
                                        $country = htmlspecialchars($row['Country']);
                                    ?>
                                    <tr>
                                        <td><?= $passportNumber ?></td>
                                        <td><?= $firstName ?></td>
                                        <td><?= $lastName ?></td>
                                        <td><?= $birthdate ?></td>
                                        <td><?= $passportExpiry ?></td>
                                        <td><?= $email ?></td>
                                        <td><?= $telephone ?></td>
                                        <td><?= $address ?></td>
                                        <td><?= $postalCode ?></td>
                                        <td><?= $city ?></td>
                                        <td><?= $country ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="11" class="text-center">No passport/booker records found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                    $maxVisiblePages = 5;
                    $startPage = max(1, $page - floor($maxVisiblePages / 2));
                    $endPage = $startPage + $maxVisiblePages - 1;

                    if ($endPage > $totalPages) {
                        $endPage = $totalPages;
                        $startPage = max(1, $endPage - $maxVisiblePages + 1);
                    }
                ?>
                <div class="pagination-container mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Add Flight Modal -->
        <div id="addFlight" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../components/flight_manage.php" method="POST">
                            <input type="hidden" name="action" value="add">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Flight</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="flightNumber" class="form-label">Flight Number</label>
                                <input type="text" class="form-control" id="flightNumber" name="flightNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label for="from" class="form-label">From</label>
                                <input type="text" class="form-control" id="from" name="from" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="col-md-6">
                                <label for="to" class="form-label">To</label>
                                <input type="text" class="form-control" id="to" name="to" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-danger me-2" onclick="location.href='flight_logs.php'">Cancel</button>
                                <button type="submit" name="action" value="add" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Flight Modal -->
        <div id="editFlight" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../components/flight_manage.php" method="POST">
                        <input type="hidden" id="originalFlightNumber" name="originalFlightNumber">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Flight</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="flightNumber" class="form-label">Flight Number</label>
                                <input type="text" class="form-control" id="flightNumber" name="flightNumber">
                            </div>
                            <div class="col-md-6">
                                <label for="from" class="form-label">From</label>
                                <input type="text" class="form-control" id="from" name="from">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time">
                            </div>
                            <div class="col-md-6">
                                <label for="to" class="form-label">To</label>
                                <input type="text" class="form-control" id="to" name="to">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" name="action" value="delete" class="btn btn-danger me-2">Delete</button>
                                <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="../js/flight_logs.js"></script>
</body>

</html>
