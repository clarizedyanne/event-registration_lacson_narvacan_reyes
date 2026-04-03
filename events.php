<?php
include 'config.php';
requireLogin();

$error = $success = "";

// Add event
if (isset($_POST['add_event'])) {
    $event_name  = trim($_POST['event_name']);
    $venue       = trim($_POST['venue']);
    $event_date  = $_POST['event_date'];
    $slots       = intval($_POST['slots_available']);

    if (empty($event_name) || empty($venue) || empty($event_date)) {
        $error = "All fields are required.";
    } else {
        $price_vip     = floatval($_POST['price_vip']);
        $price_floorpit  = floatval($_POST['price_floorpit']);
        $price_general = floatval($_POST['price_general']);

        // FIXED: Corrected bind_param type string from "sssdddі" to "sssdddi"
        $stmt = $conn->prepare("INSERT INTO events (event_name, venue, event_date, price_vip, price_floorpit, price_general, slots_available) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssdddi", $event_name, $venue, $event_date, $price_vip, $price_floorpit, $price_general, $slots);
        $stmt->execute() ? $success = "Event added!" : $error = $conn->error;
    }
}

// Delete event
if (isset($_GET['del'])) {
    $del_id = intval($_GET['del']);
    $conn->query("DELETE FROM events WHERE id=$del_id");
    header("Location: events.php");
    exit();
}

$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Events – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .table thead { background-color: #91A8D0; color: white; }
    .btn-add { background-color: #e94560; color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; }
    .btn-add:hover { background-color: #c73652; color: white; }
    .page-title { color: #1a1a2e; font-weight: 700; font-size: 1.5rem; }
    .form-card { background: white; border-radius: 14px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin-bottom: 28px; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container py-4">
  <h1 class="page-title mb-1">Manage Events</h1>
  <p class="text-muted mb-4">Add or remove SEVENTEEN concert events</p>

  <!-- Add Event Form -->
  <div class="form-card">
    <h5 class="fw-bold mb-3">Add New Event</h5>

    <?php if ($error): ?><div class="alert alert-danger py-2"><?= $error ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success py-2"><?= $success ?></div><?php endif; ?>

    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Event Name</label>
          <input type="text" name="event_name" class="form-control" placeholder="e.g. SEVENTEEN FOLLOW Tour Manila" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Venue</label>
          <input type="text" name="venue" class="form-control" placeholder="e.g. Philippine Arena" required>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Event Date</label>
          <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">VIP Price (₱)</label>
          <input type="number" step="0.01" name="price_vip" class="form-control" placeholder="5000.00" required>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Floor Pit Price (₱)</label>
          <input type="number" step="0.01" name="price_floorpit" class="form-control" placeholder="3500.00" required>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">General Admission Price (₱)</label>
          <input type="number" step="0.01" name="price_general" class="form-control" placeholder="2000.00" required>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Slots Available</label>
          <input type="number" name="slots_available" class="form-control" placeholder="200" required>
        </div>
        <div class="col-12">
          <button type="submit" name="add_event" class="btn btn-add">+ Add Event</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Events Table -->
  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Venue</th>
            <th>Date</th>
            <th>VIP</th>
            <th>Floor Pit</th>
            <th>General</th>
            <th>Slots</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($events->num_rows == 0): ?>
            <tr><td colspan="9" class="text-center py-4 text-muted">No events yet.</td></tr>
          <?php endif; ?>
          <?php while ($ev = $events->fetch_assoc()): ?>
          <tr>
            <td><?= $ev['id'] ?></td>
            <td><strong><?= htmlspecialchars($ev['event_name']) ?></strong></td>
            <td><?= htmlspecialchars($ev['venue']) ?></td>
            <td><?= date('M d, Y', strtotime($ev['event_date'])) ?></td>
            <td>₱<?= number_format($ev['price_vip'], 2) ?></td>
            <td>₱<?= number_format($ev['price_floorpit'], 2) ?></td>
            <td>₱<?= number_format($ev['price_general'], 2) ?></td>
            <td><?= $ev['slots_available'] ?></td>
            <td>
              <a href="update.php?type=event&id=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
              <a href="events.php?del=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Delete this event? All registrations for it will also be deleted.')">Delete</a>
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