<?php
session_start();
include 'db.php';

/* ===== FETCH EXPENSES ===== */
$result = $conn->query("
    SELECT * FROM expenses 
    ORDER BY date DESC
");

/* ===== FETCH MONTHLY BUDGET ===== */
$budgetResult = $conn->query("
    SELECT month, budget_amount 
    FROM monthly_budget
");

$budgets = [];
while ($row = $budgetResult->fetch_assoc()) {
    $budgets[$row['month']] = $row['budget_amount'];
}

/* ===== ORGANIZE EXPENSES BY MONTH ===== */
$monthlyData = [];

while ($row = $result->fetch_assoc()) {
    $month = date('Y-m', strtotime($row['date']));
    $monthlyData[$month][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Monthly Expense Report</title>

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
    max-width: 1200px;
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
    animation: fadeSlide 0.6s ease forwards;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* TITLES */
h2 {
    color: #00eaff;
}

.month-title {
    font-size: 20px;
    color: #00eaff;
    margin-bottom: 10px;
}

/* SUMMARY */
.summary {
    display: flex;
    justify-content: space-between;
    background: rgba(0,234,255,0.1);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    font-weight: bold;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
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
    transition: 0.3s;
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

<div class="container">

<h2>Monthly Expense Report</h2>

<?php foreach ($monthlyData as $month => $records): ?>

<div class="card">

    <!-- MONTH TITLE -->
    <div class="month-title">
        <?php echo date("F Y", strtotime($month)); ?>
    </div>

    <?php 
    $monthlyTotal = 0;
    foreach ($records as $row) {
        $monthlyTotal += $row['amount'];
    }

    $budget = $budgets[$month] ?? 0;
    $remaining = $budget - $monthlyTotal;
    ?>

    <!-- SUMMARY -->
    <div class="summary">
        <div>Monthly Budget: ₱<?php echo number_format($budget, 2); ?></div>
        <div>Total Expenses: ₱<?php echo number_format($monthlyTotal, 2); ?></div>
        <div>
            <?php if ($remaining >= 0): ?>
                Remaining: ₱<?php echo number_format($remaining, 2); ?>
            <?php else: ?>
                Over: ₱<?php echo number_format(abs($remaining), 2); ?>
            <?php endif; ?>
        </div>
    </div>

    <table>
        <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Description</th>
        </tr>

        <?php foreach ($records as $row): ?>
        <tr>
            <td><?php echo date("M d, Y", strtotime($row['date'])); ?></td>
            <td><span class="badge"><?php echo $row['category']; ?></span></td>
            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php endforeach; ?>

</div>

</body>
</html>