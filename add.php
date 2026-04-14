<?php
include 'db.php';

// Get form data safely
$amount = $_POST['amount'];
$category_id = $_POST['category_id'];
$payment_method = $_POST['payment_method'];
$date = $_POST['date'];
$desc = $_POST['description'];

// Get category name from ID
$catQuery = $conn->query("SELECT name FROM categories WHERE id = '$category_id'");
$catRow = $catQuery->fetch_assoc();
$category = $catRow['name'] ?? 'Unknown';

// Insert expense
$stmt = $conn->prepare("INSERT INTO expenses (amount, category, payment_method, date, description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("dssss", $amount, $category, $payment_method, $date, $desc);
$stmt->execute();

// Redirect
header("Location: index.php");
exit();
?>