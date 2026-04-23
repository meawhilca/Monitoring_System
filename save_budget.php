<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* =========================
   SAVE / UPDATE MONTHLY BUDGET
========================= */
if (isset($_POST['monthly_budget']) && $_POST['monthly_budget'] !== '') {

    $month = date('Y-m');
    $budget = $_POST['monthly_budget'];

    $conn->query("
        INSERT INTO monthly_budget (month, budget_amount)
        VALUES ('$month', '$budget')
        ON DUPLICATE KEY UPDATE budget_amount = '$budget'
    ");
}

/* =========================
   SAVE / UPDATE CATEGORY BUDGET
========================= */
if (isset($_POST['category_name']) && $_POST['category_name'] !== '' 
    && isset($_POST['budget_limit']) && $_POST['budget_limit'] !== '') {

    $category = $_POST['category_name'];
    $limit = $_POST['budget_limit'];

    $conn->query("
        INSERT INTO categories_budget (category_name, budget_limit)
        VALUES ('$category', '$limit')
        ON DUPLICATE KEY UPDATE budget_limit = '$limit'
    ");
}

/* =========================
   REDIRECT AFTER SAVE
========================= */
header("Location: budget_summary.php?success=1");
exit();
?>