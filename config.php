<?php
// config.php - Database Connection

session_start();

$host     = "sql303.infinityfree.com";
$user     = "if0_41571900";
$password = "NvkPFFwN5hOoEu";
$dbname   = "if0_41571900_seventeen";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper: redirect if not logged in
function requireLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>
