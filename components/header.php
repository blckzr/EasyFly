<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="../css/header.css">
<header>
  <nav class="navbar">
    <div class="nav-links">
      <a href="../client/index.html" class="<?php echo ($curr_page == 'home') ? 'active' : ''; ?>">Home</a>
      <a href="../client/booking.php" class="<?php echo ($curr_page == 'book') ? 'active' : ''; ?>">Book</a>
      <a href="#" class="<?php echo ($curr_page == 'book_list') ? 'active' : ''; ?>">View Bookings</a>
      <a href="../client/about.php" class="<?php echo ($curr_page == 'about') ? 'active' : ''; ?>">About</a>
    </div>
    <div class="right-section">
      <img class="logo" src="../img/newlogo.png" alt="Logo" />
      <a href="../client/profile.php" title="Profile" class="<?php echo ($curr_page == 'profile') ? 'active' : ''; ?>">
        <i class="fa fa-user"></i>
      </a>
    </div>
  </nav>
</header>