<?php
session_start();
include 'db.php';

// GET ID
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid ID");
}

// FETCH RECORD
$stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Record not found");
}

$data = $result->fetch_assoc();

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $payment = $_POST['payment_method'];
    $date = $_POST['date'];
    $desc = $_POST['description'];

    $update = $conn->prepare("
        UPDATE expenses 
        SET amount=?, category=?, payment_method=?, date=?, description=? 
        WHERE id=?
    ");

    $update->bind_param("dssssi", $amount, $category, $payment, $date, $desc, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Expense</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    color: #fff;
}

/* HEADER */
.header {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav a {
    color: #00eaff;
    margin-left: 10px;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 8px;
    transition: 0.3s;
}

.nav a:hover {
    background: rgba(0,234,255,0.2);
    box-shadow: 0 0 10px #00eaff;
}

/* CONTAINER */
.container {
    max-width: 500px;
    margin: 50px auto;
}

/* FORM CARD */
.form-card {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 18px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 25px rgba(0,255,255,0.08);
}

.form-card h2 {
    margin-top: 0;
    color: #00eaff;
}

/* INPUTS */
.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #fff;
}

input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.2);
    outline: none;
    background: rgba(0,0,0,0.2);
    color: #fff;
}

input:focus {
    border-color: #00eaff;
    box-shadow: 0 0 8px #00eaff;
}

/* BUTTON */
.btn {
    width: 100%;
    padding: 12px;
    background: rgba(0,234,255,0.15);
    color: #00eaff;
    border: 1px solid #00eaff;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #00eaff;
    color: #000;
}

/* NAV TITLE */
h2 {
    color: #00eaff;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>💰 Budget Dashboard</h2>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="set_budget.php">Budget</a>
        <a href="reports.php">Reports</a>
    </div>
</div>

<div class="container">

<div class="form-card">
<h2>✏️ Edit Expense</h2>

<form method="POST">

    <div class="form-group">
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" value="<?= $data['amount'] ?>" required>
    </div>

    <div class="form-group">
        <label>Category</label>
        <input type="text" name="category" value="<?= $data['category'] ?>" required>
    </div>

    <div class="form-group">
        <label>Payment Method</label>
        <input type="text" name="payment_method" value="<?= $data['payment_method'] ?>" required>
    </div>

    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" value="<?= $data['date'] ?>" required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" value="<?= $data['description'] ?>">
    </div>

    <button type="submit" class="btn">Update Expense</button>

</form>

</div>

</div>

</body>
</html>