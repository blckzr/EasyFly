<?php 
    include '../components/session_check.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/profile.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
                <div class="info"><?php echo isset($_SESSION['google_firstName']) ? htmlspecialchars($_SESSION['google_firstName']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Family Name</p>
                <div class="info"><?php echo isset($_SESSION['google_lastName']) ? htmlspecialchars($_SESSION['google_lastName']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Email</p>
                <div class="info"><?php echo isset($_SESSION['google_email']) ? htmlspecialchars($_SESSION['google_email']) : 'N/A'; ?></div>
            </div>
        </div>
        <div class="booker-information">
            <h2>Booker Details</h2>
            <div class="profile-field">
                <p class="label">First name</p>
                <div class="info"><?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Last name</p>
                <div class="info"><?php echo isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Birthdate</p>
                <div class="info"><?php echo isset($_SESSION['birthdate']) ? htmlspecialchars($_SESSION['birthdate']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Passport Number</p>
                <div class="info"><?php echo isset($_SESSION['passport_number']) ? htmlspecialchars($_SESSION['passport_number']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Passport Expiry</p>
                <div class="info"><?php echo isset($_SESSION['passport_expiry']) ? htmlspecialchars($_SESSION['passport_expiry']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Address</p>
                <div class="info"><?php echo isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Postal Code</p>
                <div class="info"><?php echo isset($_SESSION['postal_code']) ? htmlspecialchars($_SESSION['postal_code']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">City</p>
                <div class="info"><?php echo isset($_SESSION['city']) ? htmlspecialchars($_SESSION['city']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Country</p>
                <div class="info"><?php echo isset($_SESSION['country']) ? htmlspecialchars($_SESSION['country']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">E-mail</p>
                <div class="info"><?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A'; ?></div>
            </div>
            <div class="profile-field">
                <p class="label">Telephone</p>
                <div class="info"><?php echo isset($_SESSION['telephone']) ? htmlspecialchars($_SESSION['telephone']) : 'N/A'; ?></div>
            </div>
        </div>

        <div class="profile-actions">
            <button 
                class="edit-profile" 
                data-toggle="modal" 
                href="#editProfile"
                data-passport-number="<?php echo $_SESSION['passport_number'] ?? ''; ?>"
                data-passport-expiry="<?php echo $_SESSION['passport_expiry'] ?? ''; ?>"
                data-first-name="<?php echo $_SESSION['first_name'] ?? ''; ?>"
                data-last-name="<?php echo $_SESSION['last_name'] ?? ''; ?>"
                data-birthdate="<?php echo $_SESSION['birthdate'] ?? ''; ?>"
                data-telephone="<?php echo $_SESSION['telephone'] ?? ''; ?>"
                data-email="<?php echo $_SESSION['email'] ?? ''; ?>"
                data-address="<?php echo $_SESSION['address'] ?? ''; ?>"
                data-city="<?php echo $_SESSION['city'] ?? ''; ?>"
                data-country="<?php echo $_SESSION['country'] ?? ''; ?>"
                data-postal-code="<?php echo $_SESSION['postal_code'] ?? ''; ?>"
            >Edit Profile
            </button>
            <button class="logout" onclick="window.location.href='../components/stop_session.php';">Logout</button>
        </div>
    </div>

    <!-- Edit Profile Modal -->
        <div id="editProfile" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../components/profiling.php" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Profile</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Passport Number</label>
                                    <input type="text" class="form-control" id="passport_number" name="passport_number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Passport Expiry</label>
                                    <input type="date" class="form-control" id="passport_expiry" name="passport_expiry">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Birthdate</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Telephone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    include '../components/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="../js/profile.js"></script>
</body>

</html>