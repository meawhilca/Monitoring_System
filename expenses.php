<?php
include 'db.php';

$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expense List</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    color: #fff;
}

.header {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    color: #00eaff;
}

.nav {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.nav a {
    color: #00eaff;
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
}

.nav a:hover {
    background: rgba(0,234,255,0.2);
    box-shadow: 0 0 10px #00eaff;
}

.page-wrapper {
    padding: 25px;
}

.add-btn {
    background: linear-gradient(135deg,#00eaff,#00bcd4);
    color: #000;
    padding: 12px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: bold;
}

.table-card {
    margin-top: 20px;
    background: rgba(255,255,255,0.05);
    border-radius: 18px;
    padding: 15px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

thead {
    background: rgba(255,255,255,0.08);
}

th {
    color: #00eaff;
}

th, td {
    padding: 12px;
    text-align: center;
    font-size: 14px;
}

.td-amount {
    color: #ff4d6d;
    font-weight: bold;
}

.payment-chip {
    background: rgba(0,234,255,0.2);
    color: #00eaff;
    padding: 5px 12px;
    border-radius: 20px;
}

.month-header {
    background: rgba(0,234,255,0.15);
    color: #00eaff;
    font-weight: bold;
}

.month-total {
    text-align: right;
    padding: 10px;
    color: #00ffcc;
    font-weight: bold;
    background: rgba(0,0,0,0.3);
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>Budget Dashboard</h2>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="set_budget.php">Budget</a>
        <a href="reports.php">Reports</a>
    </div>
</div>

<div class="page-wrapper">

<div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
    <h1 style="color:#00eaff;">All Expenses</h1>
    <a href="add_expense.php" class="add-btn">+ Add Expense</a>
</div>

<div class="table-card">

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Amount</th>
    <th>Category</th>
    <th>Payment</th>
    <th>Date</th>
    <th>Description</th>
</tr>
</thead>

<tbody>

<?php
$currentMonth = "";
$monthlyTotal = 0;

while($row = $result->fetch_assoc()):

$month = date("F Y", strtotime($row['date']));

if ($month != $currentMonth):

    if ($currentMonth != ""):
?>
<tr>
    <td colspan="6" class="month-total">
        💰 Monthly Total (<?= $currentMonth ?>): ₱<?= number_format($monthlyTotal, 2) ?>
    </td>
</tr>
<?php
    endif;

    $currentMonth = $month;
    $monthlyTotal = 0;
?>

<tr>
    <td colspan="6" class="month-header">📅 <?= $month ?></td>
</tr>

<?php endif;

$monthlyTotal += $row['amount'];
?>

<tr>
    <td>#<?= $row['id'] ?></td>
    <td class="td-amount">₱<?= number_format($row['amount'], 2) ?></td>
    <td><?= $row['category'] ?></td>
    <td><span class="payment-chip"><?= $row['payment_method'] ?></span></td>
    <td><?= $row['date'] ?></td>
    <td><?= $row['description'] ?: '—' ?></td>
</tr>

<?php endwhile; ?>

<!-- ✅ FINAL MONTH TOTAL FIX -->
<?php if ($currentMonth != ""): ?>
<tr>
    <td colspan="6" class="month-total">
        💰 Monthly Total (<?= $currentMonth ?>): ₱<?= number_format($monthlyTotal, 2) ?>
    </td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>

</div>

</body>
</html>