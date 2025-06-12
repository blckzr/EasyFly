<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard Login</title>

  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/admin_login.css">
</head>

<body>
  <form action="../components/admin_logging.php" method="POST">
    <h1>Login</h1>
    <label for="username">
      Username<br>
      <input id="username" type="text" name="username" placeholder="Admin1" required>
    </label>
    <br>
    <label for="password">
      Password<br>
      <input id="password" type="password" name="password" required>
    </label>
    <br>
    <button type="submit">Log-in</button>
  </form>
</body>

</html>
