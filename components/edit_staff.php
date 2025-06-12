<?php
session_start();
require_once '../components/connect.php'; // Make sure this sets up $conn as a PDO instance

// Get form inputs
$adminID         = trim($_POST['admin_id']);
$firstName       = trim($_POST['first_name']);
$lastName        = trim($_POST['last_name']);
$username        = trim($_POST['username']);
$oldPassword     = $_POST['old_password'];
$newPassword     = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

// Step 1: Fetch current hashed password from DB
$stmt = $conn->prepare("SELECT Password FROM staff WHERE Admin_ID = ?");
$stmt->execute([$adminID]);
$currentHash = $stmt->fetchColumn();

// Check if record was found
if (!$currentHash) {
    echo "<script>alert('Error: Admin not found.'); window.history.back();</script>";
    exit;
}

$updatePassword = false;
$newHash = null;

// Step 2: Handle password change
if (!empty($oldPassword) || !empty($newPassword) || !empty($confirmPassword)) {
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "<script>alert('Please fill in all password fields to change the password.'); window.history.back();</script>";
        exit;
    }

    if (!password_verify($oldPassword, $currentHash)) {
        echo "<script>alert('Old password is incorrect.'); window.history.back();</script>";
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match.'); window.history.back();</script>";
        exit;
    }

    // Password is valid and confirmed
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $updatePassword = true;
}

// Step 3: Update the database
if ($updatePassword) {
    $stmt = $conn->prepare("UPDATE staff SET First_Name = ?, Last_Name = ?, Username = ?, Password = ? WHERE Admin_ID = ?");
    $success = $stmt->execute([$firstName, $lastName, $username, $newHash, $adminID]);
} else {
    $stmt = $conn->prepare("UPDATE staff SET First_Name = ?, Last_Name = ?, Username = ? WHERE Admin_ID = ?");
    $success = $stmt->execute([$firstName, $lastName, $username, $adminID]);
}

// Step 4: Set Session
try {
    // Fetch user by username
    $sql = "SELECT * FROM staff WHERE Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['admin_id'] = $user['Admin_ID'];
    $_SESSION['first_name'] = $user['First_Name'];
    $_SESSION['last_name'] = $user['Last_Name'];
    $_SESSION['username'] = $user['Username'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Step 5: Notify result
if ($success) {
    echo "<script>alert('Employee updated successfully.'); window.location.href='../admin/staff.php';</script>";
} else {
    echo "<script>alert('Error updating employee.'); window.history.back();</script>";
}
?>
