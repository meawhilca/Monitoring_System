<?php
include 'db.php';

// ✅ GET ID SAFELY
$id = $_GET['id'] ?? '';

if (!is_numeric($id) || $id <= 0) {
    die("Invalid ID");
}

// ✅ DELETE USING PREPARED STATEMENT
$stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting record.";
}
?>