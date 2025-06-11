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
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <?php
    $curr_page = 'profile'; // Set the current page for active link highlighting
    include '../components/connect.php'; // Include the database connection 
    include '../components/header.php';
    ?>
    <div id="background"></div>
    <div id="page">
        <h1>Profile</h1>
        <!-- Balak ko kukunin ko lang (pic(optional), given name, family name, gmail) -->
        <div class="profile-container">
            <img src="../img/Default_pfp.jpg" alt="Profile Picture">
        </div>
        <div class="google-profile-details">
            <h2>Google Profile Details</h2>
            <div class="profile-field">
                <p class="label">Given Name</p>
                <div class="info"><?php echo isset($_SESSION['given_name']) ? htmlspecialchars($_SESSION['given_name']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Family Name</p>
                <div class="info"><?php echo isset($_SESSION['family_name']) ? htmlspecialchars($_SESSION['family_name']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Email</p>
                <div class="info"><?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A'; ?></div>
            </div>
        </div>
        <div class="booker-information">
            <h2>Booker Details</h2>
            <div class="profile-field">
                <p class="label">First name</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Last name</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Birthdate</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Passport Number</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Passport Expiry</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Address</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Postal Code</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">City</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Country</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">E-mail</p>
                <div class="info"></div>
            </div>
            <div class="profile-field">
                <p class="label">Telephone</p>
                <div class="info"></div>
            </div>
        </div>

        <div class="profile-actions">
            <button class="edit-profile">Edit Profile</button>
            <button class="logout">Logout</button>
        </div>
    </div>


    <?php
    include '../components/footer.php';
    ?>
</body>

</html>