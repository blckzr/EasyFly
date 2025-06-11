<?php
include '../components/connect.php';

$defaultLimit = 10;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int) $_GET['limit'] : $defaultLimit;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$where = [];
$params = [];

// Date filter
if (isset($_GET['date_filter']) && $_GET['date_filter'] !== 'All') {
    $today = date('Y-m-d');
    if ($_GET['date_filter'] === 'Today') {
        $where[] = "FlightDate = :today";
        $params[':today'] = $today;
    } elseif ($_GET['date_filter'] === 'This Week') {
        $params[':start_week'] = date('Y-m-d', strtotime('monday this week'));
        $params[':end_week'] = date('Y-m-d', strtotime('sunday this week'));
        $where[] = "FlightDate BETWEEN :start_week AND :end_week";
    } elseif ($_GET['date_filter'] === 'This Month') {
        $params[':start_month'] = date('Y-m-01');
        $params[':end_month'] = date('Y-m-t');
        $where[] = "FlightDate BETWEEN :start_month AND :end_month";
    }
} else {
    $where[] = "FlightDate >= CURDATE()";
}

// Time filter
if (isset($_GET['time_filter']) && $_GET['time_filter'] !== 'All') {
    if ($_GET['time_filter'] === 'Morning') {
        $where[] = "FlightTime BETWEEN :morning_start AND :morning_end";
        $params[':morning_start'] = '05:00:00';
        $params[':morning_end'] = '11:59:59';
    } elseif ($_GET['time_filter'] === 'Afternoon') {
        $where[] = "FlightTime BETWEEN :afternoon_start AND :afternoon_end";
        $params[':afternoon_start'] = '12:00:00';
        $params[':afternoon_end'] = '17:59:59';
    } elseif ($_GET['time_filter'] === 'Evening') {
        $where[] = "FlightTime BETWEEN :evening_start AND :evening_end";
        $params[':evening_start'] = '18:00:00';
        $params[':evening_end'] = '23:59:59';
    }
}

$whereSQL = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";

// Count total records
$countSQL = "SELECT COUNT(*) FROM flight_history $whereSQL";
$countStmt = $conn->prepare($countSQL);
$countStmt->execute($params);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// Main query
$sql = "
    SELECT *
    FROM flight_history
    $whereSQL
    ORDER BY FlightDate ASC, FlightTime ASC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);

// Bind filter values
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// Bind pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <div class="filter-section">
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
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-striped fs-5">
                        <thead>
                            <tr>
                                <th scope="col">Flight Number</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Source</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="flightTableBody">
                            <?php if (count($flights) > 0): ?>
                                <?php foreach ($flights as $flight): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($flight['FlightNumber']) ?></td>
                                        <td><?= date("m/d/Y", strtotime($flight['FlightDate'])) ?></td>
                                        <td><?= date("h:i A", strtotime($flight['FlightTime'])) ?></td>
                                        <td><?= htmlspecialchars($flight['FlightFrom']) ?></td>
                                        <td><?= htmlspecialchars($flight['FlightTo']) ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button 
                                                class="btn btn-sm btn-primary editBtn"
                                                data-toggle="modal"
                                                data-target="#editFlight"
                                                data-flightnumber="<?= htmlspecialchars($flight['FlightNumber']) ?>"
                                                data-from="<?= htmlspecialchars($flight['FlightFrom']) ?>"
                                                data-to="<?= htmlspecialchars($flight['FlightTo']) ?>"
                                                data-time="<?= htmlspecialchars($flight['FlightTime']) ?>"
                                                data-date="<?= htmlspecialchars($flight['FlightDate']) ?>"
                                                >
                                                    ⋯
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center">No flight records found.</td></tr>
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

                    // Get current filter values from the query string
                    $limit = isset($_GET['limit']) ? $_GET['limit'] : '';
                    $dateFilter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';
                    $timeFilter = isset($_GET['time_filter']) ? $_GET['time_filter'] : '';

                    // Build the base query string for pagination links
                    $queryString = http_build_query([
                        'limit' => $limit,
                        'date_filter' => $dateFilter,
                        'time_filter' => $timeFilter
                    ]);
                ?>
                <div class="pagination-container mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>&<?= $queryString ?>">&laquo;</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&<?= $queryString ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>&<?= $queryString ?>">&raquo;</a>
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
