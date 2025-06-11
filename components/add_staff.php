<?php
include '../components/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // Check if passwords match
  if ($password !== $confirmPassword) {
    echo "<script>alert('Error: Passwords do not match.'); window.location.href='../admin/adminstaff.php';</script>";
    exit;
  }

  // Hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  try {
    $stmt = $conn->prepare("INSERT INTO staff (First_Name, Last_Name, Username, Password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $username, $hashedPassword]);

    echo "<script>alert('Employee added successfully!'); window.location.href='../admin/staff.php';</script>";
  } catch (PDOException $e) {
    echo "<script>alert('Error: Failed to add employee.'); window.location.href='../admin/staff.php';</script>";
  }
}
?>
