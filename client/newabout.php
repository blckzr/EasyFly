<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EasyFly - About Us</title>
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="../css/newabout.css" />
</head>

<body>

  <!-- Navigation Bar -->

  <?php
  $curr_page = 'about';
  include '../components/header.php';
  ?>

  <div class="container">
    <section>
      <img src="../img/newabout.jpg" alt="Airplane flying" class="airplane-image">
      <h2 class="section-title">About Us</h2>
      <p class="about-text">
        At EasyFly, we aim to make air travel seamless and affordable for everyone. We plan to connect thousands of travelers to destinations worldwide using cutting-edge booking technology, real-time pricing, and customer-first support.
      </p>
      <p class="about-text">
        Our mission is to redefine the way people discover, book, and experience air travel. Whether you're planning a vacation, a business trip, or a last-minute getaway, EasyFly is here to take you where you want to go—safely, quickly, and with peace of mind.
      </p>
    </section>

    <section>
      <h2 class="section-title">Our Team</h2>
      <div class="team">
        <div class="team-member">
          <img src="../img/easyfly team/james.jpg">
          <h3>Agbon, James</h3>
        </div>
        <div class="team-member">
          <img src="../img/easyfly team/trisha.jpeg">
          <h3>Esperon, Trisha Mae</h3>
        </div>
        <div class="team-member">
          <img src="../img/easyfly team/kevin.jpg">
          <h3>Gerona, Jan Kevin</h3>
        </div>
        <div class="team-member">
          <img src="../img/easyfly team/karl.jpg">
          <h3>Logdat, Karl Joseph</h3>
        </div>
        <div class="team-member">
          <img src="../img/easyfly team/Jem.jpeg">
          <h3>Salazar, Clarisse Jem</h3>
        </div>
      </div>
    </section>
  </div>

  <?php include '../components/footer.php'; ?>

</body>

</html>