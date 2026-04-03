<?php
include 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .hero { background: linear-gradient(135deg, #91A8D0, #F7CAC9); color: white; padding: 60px 0 40px; text-align: center; margin-bottom: 40px; }
    .hero h1 { font-size: 2.2rem; font-weight: 800; }
    .hero p { color: #2b2b2b; font-size: 1rem; }
    .section-title { color: #1a1a2e; font-weight: 700; border-left: 4px solid #610a09; padding-left: 12px; margin-bottom: 16px; }
    .feature-item { background: white; border-radius: 12px; padding: 20px 24px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 14px; }
    .feature-icon { font-size: 1.5rem; }
    .tech-badge { display: inline-block; background: #F7CAC9; color: #1a1a2e; border-radius: 20px; padding: 6px 18px; margin: 4px; font-size: 0.85rem; font-weight: 600; }
    .seventeen { width: 500px; padding: 20px 24px; margin-left: 53px;}
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="hero">
  <h1>SVT Events</h1>
  <p>SEVENTEEN Event Registration System</p>
  <p class="mt-1" style="color:#2b2b2b; font-weight:600;">ITEL 203 – Web Systems and Technologies | Group Performance Task 2</p>
</div>

<div class="container pb-5">
  <div class="row g-4">

    <!-- Purpose -->
    <div class="col-md-6">
      <h4 class="section-title">Purpose of the System</h4>
      <img src="pics/sebong.jpg" class="seventeen" alt="SEVENTEEN at Glastonbury 2024" title="SEVENTEEN">
      <p class="text-muted">
        SVT Events is a PHP and MySQL-based web application made to manage and track 
        fan registration details on SEVENTEEN events in the Philippines. This will help
        organizers maintain order and authenticate attendees, while preventing illegal entry.
      </p>
    </div>

    <!-- Features -->
    <div class="col-md-6">
      <h4 class="section-title">System Features</h4>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Create</strong> – Add new registrations and events</div></div>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Read</strong> – View all registrations in a table</div></div>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Update</strong> – Edit existing registrant information</div></div>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Delete</strong> – Remove registrations or events</div></div>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Search</strong> – Filter registrations by name, email, or ticket type</div></div>
      <div class="feature-item"><span class="feature-icon"></span><div><strong>Login</strong> – Admin authentication to protect the system</div></div>
    </div>

    <!-- Technologies -->
    <div class="col-12">
      <h4 class="section-title">Technologies Used</h4>
      <span class="tech-badge">PHP</span>
      <span class="tech-badge">MySQL</span>
      <span class="tech-badge">Bootstrap 5</span>
      <span class="tech-badge">HTML5 & CSS3</span>
      <span class="tech-badge">XAMPP</span>
      <span class="tech-badge">phpMyAdmin</span>
      <span class="tech-badge">Visual Studio Code</span>
      <span class="tech-badge">GitHub</span>
      <span class="tech-badge">InfinityFree</span>
    </div>

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
