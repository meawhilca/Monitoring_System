<?php
include 'db.php';

/* =========================
   GET FORM DATA
========================= */
$category_name  = $_POST['category_name'] ?? null;
$budget_limit   = $_POST['budget_limit'] ?? null;
$monthly_budget = $_POST['monthly_budget'] ?? null;

/* =========================
   SAVE MONTHLY BUDGET
========================= */
if ($monthly_budget !== null && $monthly_budget !== '') {

    $check = $conn->prepare("SELECT id FROM monthly_budget LIMIT 1");
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        // UPDATE existing monthly budget
        $update = $conn->prepare("
            UPDATE monthly_budget 
            SET budget_amount = ?
        ");
        $update->bind_param("d", $monthly_budget);

        if (!$update->execute()) {
            die("Monthly budget update failed: " . $update->error);
        }

    } else {

        // INSERT new monthly budget
        $insert = $conn->prepare("
            INSERT INTO monthly_budget (budget_amount)
            VALUES (?)
        ");
        $insert->bind_param("d", $monthly_budget);

        if (!$insert->execute()) {
            die("Monthly budget insert failed: " . $insert->error);
        }
    }
}

/* =========================
   SAVE CATEGORY BUDGET
========================= */
if ($category_name && $budget_limit) {

    // CHECK IF CATEGORY EXISTS
    $check = $conn->prepare("SELECT category_name FROM categories_budget WHERE category_name = ?");
    $check->bind_param("s", $category_name);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {

        // UPDATE existing category budget
        $update = $conn->prepare("
            UPDATE categories_budget 
            SET budget_limit = ? 
            WHERE category_name = ?
        ");
        $update->bind_param("ds", $budget_limit, $category_name);

        if (!$update->execute()) {
            die("Category update failed: " . $update->error);
        }

    } else {

        // INSERT new category budget
        $insert = $conn->prepare("
            INSERT INTO categories_budget (category_name, budget_limit)
            VALUES (?, ?)
        ");
        $insert->bind_param("sd", $category_name, $budget_limit);

        if (!$insert->execute()) {
            die("Category insert failed: " . $insert->error);
        }
    }
}

/* =========================
   REDIRECT BACK
========================= */
header("Location: index.php");
exit();
?>