<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budget Monitoring System</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .nav {
            display: flex;
            gap: 15px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .nav a:hover {
            background: #34495e;
        }

        .container {
            padding: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h2 {
            margin: 0;
            font-size: 28px;
            color: #2c3e50;
        }

        .card p {
            margin: 5px 0 0;
            color: #7f8c8d;
        }

        .footer {
            text-align: center;
            padding: 15px;
            margin-top: 30px;
            background: #2c3e50;
            color: white;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>💰 Budget Monitoring System</h1>

    <div class="nav">
        <a href="index.php">Home</a>
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="budget.php">Budget</a>
        <a href="reports.php">Reports</a>
    </div>
</div>

<div class="container">

    <h2>Welcome to the System 👋</h2>
    <p>Track your expenses, manage your budget, and monitor your financial status in real time.</p>

    <?php
    $budget = 10000;

    $result = $conn->query("SELECT SUM(amount) as total FROM expenses");
    $row = $result->fetch_assoc();
    $total = $row['total'] ?? 0;

    $remaining = $budget - $total;
    $percent = min(($total / $budget) * 100, 100);
    ?>

    <div class="card-container">

        <div class="card">
            <h2>₱<?php echo number_format($budget, 2); ?></h2>
            <p>Total Budget</p>
        </div>

        <div class="card">
            <h2>₱<?php echo number_format($total, 2); ?></h2>
            <p>Total Expenses</p>
        </div>

        <div class="card">
            <h2>₱<?php echo number_format($remaining, 2); ?></h2>
            <p>Remaining Balance</p>
        </div>

        <div class="card">
            <h2><?php echo round($percent, 2); ?>%</h2>
            <p>Budget Used</p>
        </div>

    </div>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> Budget Monitoring System
</div>

</body>
</html>