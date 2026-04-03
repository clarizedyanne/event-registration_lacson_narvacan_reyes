<?php
include 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Developers – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .hero { background: linear-gradient(135deg, #91A8D0, #F7CAC9); color: white; padding: 50px 0 36px; text-align: center; margin-bottom: 40px; }
    .hero h1 { font-size: 2rem; font-weight: 800; }
    .dev-card { background: white; border-radius: 14px; padding: 28px 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); text-align: center; height: 100%; }
    .dev-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 16px; display: block; border: 3px solid #F7CAC9; }
    .dev-name { font-weight: 700; font-size: 1.1rem; color: #1a1a2e; }
    .dev-role { color: #91A8D0; font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; }
    .dev-desc { color: #666; font-size: 0.88rem; }
    .section-title { color: #1a1a2e; font-weight: 700; border-left: 4px solid #e94560; padding-left: 12px; margin-bottom: 20px; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="hero">
  <h1>Meet the Developers</h1>
  <p style="color:#2b2b2b;">The team behind SVT Events</p>
</div>

<div class="container pb-5">
  <h4 class="section-title text-center" style="border:none; padding:0;">The Shining Diamond Team</h4>
  <p class="text-center text-muted mb-4">ITEL 203 – Group Performance Task #2</p>

  <div class="row g-4 justify-content-center">

    <!-- EDIT NAMES, ROLES, AND CONTRIBUTIONS BELOW -->

    <div class="col-md-4">
      <div class="dev-card">
        <div><img src="pics/claire.jpg" class="dev-avatar" style="object-fit:cover;"></div>
        <div class="dev-name">Clarize Dyanne R. Reyes</div>
        <div class="dev-role">Project Lead / Back-end Developer</div>
        <div class="dev-desc">
          Handled the database design, PHP CRUD logic, and overall project structure.
          Set up the MySQL tables and config file.
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="dev-card">
        <div><img src="pics/lea.jpg" class="dev-avatar" style="object-fit:cover;"></div>
        <div class="dev-name">Lea Chelsy K. Narvacan</div>
        <div class="dev-role">Front-end Developer / UI Designer</div>
        <div class="dev-desc">
          Designed and styled all pages using Bootstrap. Responsible for the
          navigation, forms, and overall visual layout of the system.
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="dev-card">
        <div><img src="pics/eper.jpg" class="dev-avatar" style="object-fit:cover;"></div>
        <div class="dev-name">Jennifer P. Lacson</div>
        <div class="dev-role">Deployment & Documentation</div>
        <div class="dev-desc">
          Handled deployment on InfinityFree, GitHub repository setup,
          README documentation, and the Canva presentation.
        </div>
      </div>
    </div>

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
