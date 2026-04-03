<?php
include 'config.php';
requireLogin();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name   = trim($_POST['full_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $event_id    = intval($_POST['event_id']);
    $ticket_type = trim($_POST['ticket_type']);

    // Basic validation
    if (empty($full_name) || empty($email) || empty($phone) || empty($event_id) || empty($ticket_type)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO registrations (full_name, email, phone, event_id, ticket_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $email, $phone, $event_id, $ticket_type);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Error saving registration: " . $conn->error;
        }
    }
}

$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Registration – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
    .form-card { background: white; border-radius: 14px; padding: 32px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); max-width: 600px; margin: 40px auto; }
    .form-card h2 { color: #91A8D0; font-weight: 700; margin-bottom: 4px; }
    .btn-save { background-color: #ff8886; border: none; color: white; padding: 10px 28px; border-radius: 8px; font-weight: 600; }
    .btn-save:hover { background-color: #e94560; color: white; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <div class="form-card">
    <h2>Add Registration</h2>
    <p class="text-muted mb-4">Register a fan for a SEVENTEEN event</p>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label fw-semibold">Full Name</label>
        <input type="text" name="full_name" class="form-control" placeholder="e.g. Juan Dela Cruz" required value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="e.g. juan@email.com" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Phone Number</label>
        <input type="text" name="phone" class="form-control" placeholder="e.g. 09XXXXXXXXX" required value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Select Event</label>
        <select name="event_id" class="form-select" required>
          <option value="">-- Choose an Event --</option>
          <?php while ($event = $events->fetch_assoc()): ?>
            <option value="<?= $event['id'] ?>" <?= (isset($_POST['event_id']) && $_POST['event_id'] == $event['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($event['event_name']) ?> – <?= date('M d, Y', strtotime($event['event_date'])) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-4">
        <label class="form-label fw-semibold">Ticket Type</label>
        <select name="ticket_type" class="form-select" required>
          <option value="">-- Choose Ticket Type --</option>
          <option value="VIP" <?= (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'VIP') ? 'selected' : '' ?>>VIP</option>
          <option value="Floor Pit" <?= (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'Floor Pit') ? 'selected' : '' ?>>Floor Pit</option>
          <option value="General Admission" <?= (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'General Admission') ? 'selected' : '' ?>>General Admission</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Ticket Price</label>
        <input type="text" id="ticket_price_display" class="form-control" placeholder="Select an event and ticket type" readonly>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-save">Save Registration</button>
        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const eventSelect   = document.querySelector('select[name="event_id"]');
const ticketSelect  = document.querySelector('select[name="ticket_type"]');
const priceDisplay  = document.getElementById('ticket_price_display');

// Store prices from PHP
const eventPrices = {
  <?php
    $evs = $conn->query("SELECT * FROM events");
    while($ev = $evs->fetch_assoc()) {
      echo $ev['id'] . ": { vip: " . $ev['price_vip'] . ", floorpit: " . $ev['price_floorpit'] . ", general: " . $ev['price_general'] . " },";
    }
  ?>
};

function updatePrice() {
  const eventId = eventSelect.value;
  const ticket  = ticketSelect.value;
  if (!eventId || !ticket) { priceDisplay.value = ''; return; }
  const prices = eventPrices[eventId];
  if (!prices) return;
  if (ticket === 'VIP')                priceDisplay.value = '₱' + prices.vip.toFixed(2);
  else if (ticket === 'Floor Pit')       priceDisplay.value = '₱' + prices.floorpit.toFixed(2);
  else if (ticket === 'General Admission') priceDisplay.value = '₱' + prices.general.toFixed(2);
}

eventSelect.addEventListener('change', updatePrice);
ticketSelect.addEventListener('change', updatePrice);
</script>
</body>
</html>
