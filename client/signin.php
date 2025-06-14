<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EasyFly</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="../css/signin.css">
  <link rel="stylesheet" href="../css/date.css">

  <script src="../js/googleJS.js"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
  <div class="wrapper">
    <!-- Sign In -->
    <div class="form-wrapper sign-in">
      <form id="signin-form" action="../components/logging.php" method="POST">
        <h3>Sign In for Simplified Booking</h3>
        <div class="input-group">
          <input type="text" id="signin-passport-number" name="passport_number" required>
          <label>Passport Number</label>
        </div>
        <div class="input-group">
          <input type="date" id="signin-passport-expiry" name="passport_expiry" required>
          <label>Passport Expiry</label>
        </div>
        <button type="submit">Sign In</button>

        <div class="google-signin-container">
          <!-- Google Sign-In -->
          <div id="g_id_onload"
              data-client_id="127520857260-aj8rmg1u6v8pbbjb7smtlrq8vql51q09.apps.googleusercontent.com"
              data-callback="handleCredentialResponse"
              data-auto_prompt="false"
              data-itp_support="true">
          </div>
          <div class="g_id_signin"
              data-type="standard"
              data-size="large"
              data-theme="outline"
              data-text="sign_in_with"
              data-shape="rectangular"
              data-logo_alignment="left">
          </div>
        </div>

        <div class="signUp-link">
          <br>
          <p>Don't have an account? <a href="#" class="signUpBtn-link">Register Now!</a></p>
        </div>
      </form>
    </div>

    <!-- Sign Up -->
    <div class="form-wrapper sign-up">
      <form id="signup-form" action="../components/register.php" method="POST">
        <h3>Register to see Amazing Offers!</h3>
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
            <input type="text" id="first-name" name="first_name" required>
            <label>First Name</label>
          </div>
          <div class="input-group half">
            <input type="text" id="last-name" name="last_name" required>
            <label>Last Name</label>
          </div>
        </div>
        <button type="submit" >Register</button>
        <div class="signUp-link">
          <br>
          <p>Already have an account? <a href="#" class="signInBtn-link">Sign In</a></p>
        </div>
      </form>
    </div>

  <script src="../js/signin.js"></script>
</body>
</html>
