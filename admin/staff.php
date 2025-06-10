<?php
  include '../components/connect.php';

  try {
    $stmt = $conn->prepare("SELECT * FROM staff");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Staff Management</title>
  <link rel="stylesheet" href="../css/adminstaff.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container-xl">
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Manage <b>Employees</b></h2>
            </div>
            <div class="col-sm-6">
              <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
              <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
            </div>
          </div>
        </div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>
                <span class="custom-checkbox">
                  <input type="checkbox" id="selectAll">
                  <label for="selectAll"></label>
                </span>
              </th>
              <th>Admin ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Username</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row): ?>
              <tr>
                <td>
                  <span class="custom-checkbox">
                    <input type="checkbox" id="checkbox<?= htmlspecialchars($row['Admin_ID']); ?>" name="options[]" value="<?= htmlspecialchars($row['Admin_ID']); ?>">
                    <label for="checkbox<?= htmlspecialchars($row['Admin_ID']); ?>"></label>
                  </span>
                </td>
                <td><?= htmlspecialchars($row['Admin_ID']); ?></td>
                <td><?= htmlspecialchars($row['First_Name']); ?></td>
                <td><?= htmlspecialchars($row['Last_Name']); ?></td>
                <td><?= htmlspecialchars($row['Username']); ?></td>
                <td>
                  <a href="#editEmployeeModal" class="edit" data-toggle="modal" data-id="<?= htmlspecialchars($row['Admin_ID']); ?>"><i class="material-icons" title="Edit">&#xE254;</i></a>
                  <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="<?= htmlspecialchars($row['Admin_ID']); ?>"><i class="material-icons" title="Delete">&#xE872;</i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="clearfix">
          <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
            <ul class="pagination">
              <li class="page-item disabled"><a href="#">Previous</a></li>
              <li class="page-item"><a href="#" class="page-link">1</a></li>
              <li class="page-item"><a href="#" class="page-link">2</a></li>
              <li class="page-item active"><a href="#" class="page-link">3</a></li>
              <li class="page-item"><a href="#" class="page-link">4</a></li>
              <li class="page-item"><a href="#" class="page-link">5</a></li>
              <li class="page-item"><a href="#" class="page-link">Next</a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Employee Modal -->
  <div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="add_employee.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Add Employee</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Admin ID</label>
              <input type="text" name="admin_id" class="form-control" required>
            </div>
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-success" value="Add">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Employee Modal -->
  <div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="edit_employee.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Edit Employee</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group">
              <label>Admin ID</label>
              <input type="text" name="admin_id" id="edit-admin-id" class="form-control" required>
            </div>
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" id="edit-first-name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" id="edit-last-name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" id="edit-username" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-info" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="delete_employee.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Delete Employee</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="delete-id">
            <p>Are you sure you want to delete this record?</p>
            <p class="text-warning"><small>This action cannot be undone.</small></p>
          </div>
          <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-danger" value="Delete">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Load selected employee data into edit modal
    $('#editEmployeeModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const id = button.data('id');
      // TODO: Use AJAX to fetch data from server and fill inputs
      // Example:
      // $('#edit-id').val(id);
      // $('#edit-admin-id').val(...);
      // $('#edit-first-name').val(...);
    });

    // Pass selected ID to delete modal
    $('#deleteEmployeeModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const id = button.data('id');
      $('#delete-id').val(id);
    });
  </script>
</body>
</html>
