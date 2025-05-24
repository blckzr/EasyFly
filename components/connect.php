<?php
  // Set the PDO connection string with host, database, username, and password
  $conn = new PDO('mysql:host=localhost;dbname=easyfly_db', 'root', '');

  // Set the PDO error mode to exception for better error handling
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($conn) {
    // echo "Connected to the database successfully!";
  } else {
    echo "Failed to connect to the database!";
  }
?>