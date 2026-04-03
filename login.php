<?php
include 'config.php';

// If already logged in, go to index
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // For simplicity, plain password check (use password_verify for production)
        // Default: admin / admin123
        if ($admin && ($password === 'admin123' || password_verify($password, $admin['password']))) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login – SVT Events</title>
  <link rel="icon" type="image/png" href="pics/svt logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1a1a2e;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: #16213e;
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 8px 32px rgba(233,69,96,0.2);
      border: 1px solid #e9456022;
    }
    .login-card h2 {
      color: #e94560;
      font-weight: 700;
      text-align: center;
      margin-bottom: 8px;
    }
    .login-card p {
      color: #aaa;
      text-align: center;
      margin-bottom: 28px;
      font-size: 0.9rem;
    }
    .form-control {
      background: #0f3460;
      border: 1px solid #e9456033;
      color: #fff;
      border-radius: 8px;
    }
    .form-control:focus {
      background: #0f3460;
      color: #fff;
      border-color: #e94560;
      box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
    }
    .form-label { color: #ccc; }
    .btn-login {
      background-color: #e94560;
      border: none;
      color: white;
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      transition: background 0.2s;
    }
    .btn-login:hover { background-color: #c73652; }
    .star { color: #e94560; font-size: 2rem; text-align: center; display: block; margin-bottom: 10px; }
  </style>
</head>
<body>
  <div class="login-card">
    <span class="star">★</span>
    <h2>SVT Events</h2>
    <p>Admin Login – SEVENTEEN Event Registration System</p>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="admin" required>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>

    <p class="mt-3" style="color:#555; font-size:0.8rem; text-align:center;">
      Default: admin / admin123
    </p>
  </div>
</body>
</html>
