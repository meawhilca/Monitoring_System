<?php
include 'db.php';

$category_name = $_POST['category_name'] ?? null;
$budget_limit = $_POST['budget_limit'] ?? null;

if (!$category_name || !$budget_limit) {
    die("Missing form data.");
}

// CHECK IF CATEGORY ALREADY EXISTS
$check = $conn->prepare("SELECT category_name FROM categories_budget WHERE category_name = ?");
$check->bind_param("s", $category_name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {

    // UPDATE existing budget
    $update = $conn->prepare("
        UPDATE categories_budget 
        SET budget_limit = ? 
        WHERE category_name = ?
    ");
    $update->bind_param("ds", $budget_limit, $category_name);

    if (!$update->execute()) {
        die("Update failed: " . $update->error);
    }

} else {

    // INSERT new budget (created_at auto-handled if DEFAULT CURRENT_TIMESTAMP)
    $insert = $conn->prepare("
        INSERT INTO categories_budget (category_name, budget_limit)
        VALUES (?, ?)
    ");
    $insert->bind_param("sd", $category_name, $budget_limit);

    if (!$insert->execute()) {
        die("Insert failed: " . $insert->error);
    }
}

header("Location: index.php");
exit();
?>