<?php
include 'config.php';
requireLogin();

$error = "";
$type = isset($_GET['type']) ? $_GET['type'] : 'registration'; // Default to registration
$id = intval($_GET['id']);

// Determine what we're updating
if ($type == 'event') {
    // Get existing event
    $result = $conn->query("SELECT * FROM events WHERE id=$id");
    if ($result->num_rows == 0) {
        header("Location: events.php");
        exit();
    }
    $data = $result->fetch_assoc();
    
    // Handle event update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $event_name  = trim($_POST['event_name']);
        $venue       = trim($_POST['venue']);
        $event_date  = $_POST['event_date'];
        $price_vip     = floatval($_POST['price_vip']);
        $price_floorpit  = floatval($_POST['price_floorpit']);
        $price_general = floatval($_POST['price_general']);
        $slots       = intval($_POST['slots_available']);

        if (empty($event_name) || empty($venue) || empty($event_date)) {
            $error = "All fields are required.";
        } else {
            $stmt = $conn->prepare("UPDATE events SET event_name=?, venue=?, event_date=?, price_vip=?, price_floorpit=?, price_general=?, slots_available=? WHERE id=?");
            $stmt->bind_param("sssdddii", $event_name, $venue, $event_date, $price_vip, $price_floorpit, $price_general, $slots, $id);
            if ($stmt->execute()) {
                header("Location: events.php");
                exit();
            } else {
                $error = "Error updating: " . $conn->error;
            }
        }
    }
} else {
    // Get existing registration
    $result = $conn->query("SELECT * FROM registrations WHERE id=$id");
    if ($result->num_rows == 0) {
        header("Location: index.php");
        exit();
    }
    $data = $result->fetch_assoc();
    
    // Handle registration update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $full_name   = trim($_POST['full_name']);
        $email       = trim($_POST['email']);
        $phone       = trim($_POST['phone']);
        $event_id    = intval($_POST['event_id']);
        $ticket_type = trim($_POST['ticket_type']);

        if (empty($full_name) || empty($email) || empty($phone) || empty($event_id) || empty($ticket_type)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            $stmt = $conn->prepare("UPDATE registrations SET full_name=?, email=?, phone=?, event_id=?, ticket_type=? WHERE id=?");
            $stmt->bind_param("sssssi", $full_name, $email, $phone, $event_id, $ticket_type, $id);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Error updating: " . $conn->error;
            }
        }
    }
    
    // Get events for dropdown
    $events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $type == 'event' ? 'Edit Event' : 'Edit Registration' ?> – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .form-card { background: white; border-radius: 14px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); max-width: <?= $type == 'event' ? '700px' : '600px' ?>; margin: 40px auto; }
    .form-card h2 { color: #1a1a2e; font-weight: 700; margin-bottom: 4px; }
    .btn-save { background-color: #3b7bbb; border: none; color: white; padding: 10px 28px; border-radius: 8px; font-weight: 600; }
    .btn-save:hover { background-color: #89b0e0; color: white; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <div class="form-card">
    <?php if ($type == 'event'): ?>
      <!-- EVENT EDIT FORM -->
      <h2>✏️ Edit Event</h2>
      <p class="text-muted mb-4">Update event information</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Event Name</label>
            <input type="text" name="event_name" class="form-control" required value="<?= htmlspecialchars($data['event_name']) ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Venue</label>
            <input type="text" name="venue" class="form-control" required value="<?= htmlspecialchars($data['venue']) ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Event Date</label>
            <input type="date" name="event_date" class="form-control" required value="<?= $data['event_date'] ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Slots Available</label>
            <input type="number" name="slots_available" class="form-control" required value="<?= $data['slots_available'] ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">VIP Price (₱)</label>
            <input type="number" step="0.01" name="price_vip" class="form-control" required value="<?= $data['price_vip'] ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Floor Pit Price (₱)</label>
            <input type="number" step="0.01" name="price_floorpit" class="form-control" required value="<?= $data['price_floorpit'] ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">General Admission Price (₱)</label>
            <input type="number" step="0.01" name="price_general" class="form-control" required value="<?= $data['price_general'] ?>">
          </div>
          <div class="col-12">
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-save">Update Event</button>
              <a href="events.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </form>

    <?php else: ?>
      <!-- REGISTRATION EDIT FORM -->
      <h2>✏️ Edit Registration</h2>
      <p class="text-muted mb-4">Update registrant information</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($data['full_name']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($data['email']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Phone Number</label>
          <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($data['phone']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Select Event</label>
          <select name="event_id" class="form-select" required>
            <option value="">-- Choose an Event --</option>
            <?php while ($event = $events->fetch_assoc()): ?>
              <option value="<?= $event['id'] ?>" <?= $data['event_id'] == $event['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($event['event_name']) ?> – <?= date('M d, Y', strtotime($event['event_date'])) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-4">
          <label class="form-label fw-semibold">Ticket Type</label>
          <select name="ticket_type" class="form-select" required>
            <option value="VIP" <?= $data['ticket_type'] == 'VIP' ? 'selected' : '' ?>>VIP</option>
            <option value="Floor Pit" <?= $data['ticket_type'] == 'Floor Pit' ? 'selected' : '' ?>>Floor Pit</option>
            <option value="General Admission" <?= $data['ticket_type'] == 'General Admission' ? 'selected' : '' ?>>General Admission</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-save">Update Registration</button>
          <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>