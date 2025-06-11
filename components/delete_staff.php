<?php
include '../components/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
  $ids = $_POST['ids']; // No need for explode()

  // Prepare the correct number of placeholders
  $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
  $sql = "DELETE FROM staff WHERE Admin_ID IN ($placeholders)";
  $stmt = $conn->prepare($sql);

  if ($stmt->execute($ids)) {
    header("Location: ../admin/staff.php?msg=deleted");
    exit;
  } else {
    echo "Error: Could not delete records.";
  }
} else {
  echo "Invalid request.";
}
?>
