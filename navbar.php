<?php
// navbar.php - Shared Navigation Bar
?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5858b6;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <span style="color:#e94560;">💎</span> SVT Events
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Registrations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : '' ?>" href="events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'about-project.php' ? 'active' : '' ?>" href="about-project.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'developers.php' ? 'active' : '' ?>" href="developers.php">Developers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php"><span style="color:#F7CAC9;">Log Out</span></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
