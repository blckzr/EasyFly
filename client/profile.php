<?php
// session check
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <?php
    $curr_page = 'profile'; // Set the current page for active link highlighting
    include '../components/connect.php'; // Include the database connection 
    include '../components/header.php';
    ?>

    <?php
    include '../components/footer.php';
    ?>
</body>

</html>