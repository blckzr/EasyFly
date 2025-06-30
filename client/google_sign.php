<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EasyFly</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="../css/signin.css">
  <link rel="stylesheet" type="text/css" href="../css/date.css">

  <script src="../js/googleJS.js"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
  <div class="wrapper">
    <!-- Sign In -->
    <div class="form-wrapper sign-in">
      <form id="signin-form" action="../components/register.php" method="POST">
        <h3>Hello <?php echo isset($_SESSION['google_firstName']) ? htmlspecialchars($_SESSION['google_firstName']) : 'N/A'; ?>! Register to see Amazing Offers!</h3>
        <div class="input-group">
          <input type="text" id="passport-number" name="passport_number" required>
          <label>Passport Number</label>
        </div>
        <div class="input-row">
          <div class="input-group half">
            <input type="date" id="passport-expiry" name="passport_expiry" required>
            <label>Passport Expiry</label>
          </div>
          <div class="input-group half">
            <input type="date" id="birthdate" name="birthdate" required>
            <label>Birthday</label>
          </div>
        </div>
        <div class="input-row">
          <div class="input-group half">
            <input type="text" id="first-name" name="first_name" value="<?php echo isset($_SESSION['google_firstName']) ? htmlspecialchars($_SESSION['google_firstName']) : 'N/A'; ?>" required>
            <label>First Name</label>
          </div>
          <div class="input-group half">
            <input type="text" id="last-name" name="last_name" value="<?php echo isset($_SESSION['google_lastName']) ? htmlspecialchars($_SESSION['google_lastName']) : 'N/A'; ?>" required>
            <label>Last Name</label>
          </div>
            <input type="hidden" id="email" name="email" value="<?php echo isset($_SESSION['google_email']) ? htmlspecialchars($_SESSION['google_email']) : 'N/A'; ?>" required>
        </div>
        <button type="submit" >Submit</button>
      </form>
    </div>

  <script src="../js/signin.js"></script>
</body>
</html>
