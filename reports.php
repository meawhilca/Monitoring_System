<?php
session_start();
include 'db.php';

/* ===== DATA ===== */
$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");

$totalResult = $conn->query("SELECT SUM(amount) as total FROM expenses");
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'] ?? 0;

$categoryResult = $conn->query("
    SELECT category, SUM(amount) as total 
    FROM expenses 
    GROUP BY category
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Expense Report</title>

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
    max-width: 1100px;
    margin: 30px auto;
    padding: 25px;
}

/* CARD */
.card {
    background: rgba(255,255,255,0.05);
    border-radius: 18px;
    padding: 20px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 25px rgba(0,255,255,0.08);
    margin-bottom: 25px;
}

/* TITLES */
h2 {
    color: #00eaff;
}

h3 {
    color: #00eaff;
}

/* SUMMARY */
.summary {
    display: flex;
    justify-content: space-between;
    background: rgba(0,234,255,0.1);
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: rgba(255,255,255,0.08);
    color: #00eaff;
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

tr:hover {
    background: rgba(255,255,255,0.05);
}

/* BADGE */
.badge {
    display: inline-block;
    padding: 5px 12px;
    background: rgba(0,234,255,0.2);
    color: #00eaff;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>💰 Budget Dashboard</h2>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="set_budget.php">Budget</a>
        <a href="reports.php">Reports</a>
    </div>
</div>

<div class="container">

<h2>📊 Expense Report</h2>

<!-- SUMMARY -->
<div class="summary">
    <div>💰 Total Expenses: ₱<?php echo number_format($total, 2); ?></div>
</div>

<hr>

<!-- CATEGORY TABLE -->
<h3>📌 Expenses by Category</h3>
<table>
    <tr>
        <th>Category</th>
        <th>Total Amount</th>
    </tr>

    <?php while($row = $categoryResult->fetch_assoc()) { ?>
        <tr>
            <td><span class="badge"><?php echo $row['category']; ?></span></td>
            <td>₱<?php echo number_format($row['total'], 2); ?></td>
        </tr>
    <?php } ?>
</table>

<hr>

<!-- FULL LIST -->
<h3>📋 Full Expense List</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Payment Method</th>
        <th>Date</th>
        <th>Description</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
            <td><span class="badge"><?php echo $row['category']; ?></span></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php } ?>
</table>

</div>

</body>
</html>