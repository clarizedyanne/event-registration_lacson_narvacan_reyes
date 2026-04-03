<?php
include 'config.php';
requireLogin();

// Handle search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSQL = "";
if ($search !== '') {
    $s = $conn->real_escape_string($search);
    $searchSQL = "WHERE r.full_name LIKE '%$s%' OR r.email LIKE '%$s%' OR r.ticket_type LIKE '%$s%'";
}

$result = $conn->query("
    SELECT r.*, e.event_name, e.venue, e.event_date
    FROM registrations r
    JOIN events e ON r.event_id = e.id
    $searchSQL
    ORDER BY r.registered_at DESC
");

// Count stats
$totalRegs  = $conn->query("SELECT COUNT(*) as c FROM registrations")->fetch_assoc()['c'];
$totalEvents = $conn->query("SELECT COUNT(*) as c FROM events")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrations – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .stat-card { background: #91A8D0; color: white; border-radius: 12px; padding: 20px 28px; }
    .stat-card .number { font-size: 2rem; font-weight: 700; color: #F7CAC9; }
    .stat-card .label { font-size: 0.85rem; color: #1d1d1d; }
    .table thead { background-color: #91A8D0; color: white; }
    .btn-add { background-color: #e94560; color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; }
    .btn-add:hover { background-color: #c73652; color: white; }
    .badge-vip { background-color: #ff9896; }
    .badge-gen { background-color: #91A8D0; }
    .badge-fan { background-color: #bc8fff; }
    .page-title { color: #91A8D0; font-weight: 700; font-size: 1.5rem; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-4">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="page-title mb-0">Event Registrations</h1>
      <small class="text-muted">SEVENTEEN event registrants</small>
    </div>
    <a href="create.php" class="btn btn-add">+ Add Registration</a>
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="stat-card">
        <div class="number"><?= $totalRegs ?></div>
        <div class="label">Total Registrations</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="stat-card">
        <div class="number"><?= $totalEvents ?></div>
        <div class="label">Total Events</div>
      </div>
    </div>
  </div>

  <!-- Search Bar -->
  <form method="GET" class="mb-3">
    <div class="input-group" style="max-width: 400px;">
      <input type="text" name="search" class="form-control" placeholder="Search by name, email, ticket type..." value="<?= htmlspecialchars($search) ?>">
      <button class="btn btn-dark" type="submit">Search</button>
      <?php if ($search): ?>
        <a href="index.php" class="btn btn-outline-secondary">Clear</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Table -->
  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Event</th>
            <th>Ticket Type</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows == 0): ?>
            <tr><td colspan="8" class="text-center py-4 text-muted">No registrations found.</td></tr>
          <?php endif; ?>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
              <strong><?= htmlspecialchars($row['event_name']) ?></strong><br>
              <small class="text-muted"><?= date('M d, Y', strtotime($row['event_date'])) ?></small>
            </td>
            <td>
              <?php
                $badge = 'bg-secondary';
                if ($row['ticket_type'] == 'VIP') $badge = 'badge-vip';
                elseif ($row['ticket_type'] == 'General Admission') $badge = 'badge-gen';
                elseif ($row['ticket_type'] == 'Floor Pit') $badge = 'badge-fan';
              ?>
              <span class="badge <?= $badge ?>"><?= $row['ticket_type'] ?></span>
            </td>
            <td><?= date('M d, Y', strtotime($row['registered_at'])) ?></td>
            <td>
              <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
              <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Delete this registration?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
