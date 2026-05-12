<?php
include 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data safely
    $amount = $_POST['amount'] ?? 0;
    $category_id = $_POST['category_id'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $date = $_POST['date'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate required fields
    if ($amount <= 0 || empty($category_id) || empty($payment_method) || empty($date)) {
        header("Location: add_expense.php?error=1");
        exit();
    }

    // Get category name from ID
    $catStmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
    $catStmt->bind_param("i", $category_id);
    $catStmt->execute();
    $catResult = $catStmt->get_result();
    $catRow = $catResult->fetch_assoc();

    $category = $catRow['name'] ?? 'Unknown';

    // Insert into expenses table
    $stmt = $conn->prepare("
        INSERT INTO expenses (amount, category, payment_method, date, description)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "dssss",
        $amount,
        $category,
        $payment_method,
        $date,
        $description
    );

    $stmt->execute();

    // Redirect with success popup trigger
    header("Location: index.php?success=1");
    exit();

} else {
    // If accessed directly
    header("Location: add_expense.php");
    exit();
}
?>