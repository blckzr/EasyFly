<?php

include '../components/connect.php'

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>

    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div id="bg-img"></div>
    <div id="content">
        <form action="" method="post">
            <h1>Sign-Up</h1>

            <label>
                First Name
                <input type="text" name="firstname" placeholder="Juan" required>
            </label>

            <label>
                Last Name
                <input type="text" name="lastname" placeholder="Dela Cruz" required>
            </label>
            <br>

            <label>
                Address
                <input type="text" name="address" placeholder="#100 Gumamela St., Baranggay Bulaklak" required>
            </label>
            <br>

            <label>
                City
                <input type="text" name="city" placeholder="Manila" required>
            </label>

            <label>
                Country
                <input type="text" name="country" placeholder="Philippines" required>
            </label>

            <label>
                Postal Code
                <input type="text" name="postalcode" placeholder="1727" required>
            </label>
            <br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>