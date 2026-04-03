<?php
include 'config.php';
requireLogin();

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM registrations WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
