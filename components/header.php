<link rel="stylesheet" href="../css/header.css">
<header>
  <nav class="navbar">
    <div class="nav-links">
      <a href="../client/index.html" class="<?php echo ($curr_page == 'home') ? 'active' : ''; ?>">Home</a>
      <a href="../client/booking.php" class="<?php echo ($curr_page == 'book') ? 'active' : ''; ?>">Book</a>
      <a href="#" class="<?php echo ($curr_page == 'book_list') ? 'active' : ''; ?>">View Bookings</a>
      <a href="../client/about.php" class="<?php echo ($curr_page == 'about') ? 'active' : ''; ?>">About</a>
    </div>
    <img class="logo" src="../img/newlogo.png" alt="Logo" />
  </nav>
</header>