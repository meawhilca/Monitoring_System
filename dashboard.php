<?php
session_start();
include 'db.php';

/* ===== GET MONTHLY BUDGET ===== */
$month = date('Y-m'); // current month like 2026-04

$budgetResult = $conn->prepare("
    SELECT budget_amount 
    FROM monthly_budget 
    WHERE month = ?
    LIMIT 1
    
");
$budgetResult->bind_param("s", $month);
$budgetResult->execute();
$res = $budgetResult->get_result();

$budgetRow = $res->fetch_assoc();
$budget = $budgetRow['budget_amount'] ?? 0;

/* ===== EXPENSE TOTAL ===== */
$result = $conn->query("SELECT SUM(amount) as total FROM expenses");
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;

/* ===== CALCULATIONS ===== */
$remaining = max($budget - $total, 0);
$percent = ($budget > 0) ? min(($total / $budget) * 100, 100) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Budget Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    padding: 25px;
}

/* TITLE */
.title h1 {
    margin: 0;
    color: #00eaff;
}

.title p {
    color: rgba(255,255,255,0.7);
}

/* CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-top: 20px;
}

.card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    padding: 20px;
    border-radius: 18px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 20px rgba(0,255,255,0.08);
}

.card h2 {
    color: #00eaff;
}

/* PROGRESS */
.progress {
    background: rgba(255,255,255,0.1);
    border-radius: 20px;
    height: 12px;
    margin-top: 15px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00eaff, #00ffb3);
}

/* CHARTS */
.charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 30px;
}

.chart-box {
    background: rgba(255,255,255,0.05);
    padding: 18px;
    border-radius: 18px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    height: 280px;
}

.chart-box h3 {
    color: #00eaff;
}

/* CANVAS */
canvas {
    width: 100% !important;
    height: 210px !important;
}

/* FOOTER */
.footer {
    text-align: center;
    padding: 15px;
    margin-top: 30px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
}

/* RESPONSIVE */
@media(max-width: 768px){
    .charts {
        grid-template-columns: 1fr;
    }
}
</style>

</head>

<body>

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

<div class="title">
    <h1>Welcome 👋</h1>
    <p>Track your expenses and manage your budget effectively.</p>
</div>

<div class="cards">

    <div class="card">
        <h2>₱<?= number_format($budget, 2) ?></h2>
        <p>Total Budget (This Month)</p>
    </div>

    <div class="card">
        <h2>₱<?= number_format($total, 2) ?></h2>
        <p>Total Expenses</p>
    </div>

    <div class="card">
        <h2>₱<?= number_format($remaining, 2) ?></h2>
        <p>Remaining Balance</p>
    </div>

    <div class="card">
        <h2><?= round($percent, 2) ?>%</h2>
        <p>Budget Used</p>

        <div class="progress">
            <div class="progress-fill" style="width: <?= $percent ?>%"></div>
        </div>
    </div>

</div>

<div class="charts">

    <div class="chart-box">
        <h3>Budget Overview</h3>
        <canvas id="pieChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Comparison</h3>
        <canvas id="barChart"></canvas>
    </div>

</div>

</div>

<div class="footer">
    © <?= date("Y") ?> Budget Monitoring System
</div>

<script>
const budget = <?= $budget ?>;
const total = <?= $total ?>;
const remaining = <?= $remaining ?>;

Chart.defaults.color = "#ffffff";
Chart.defaults.font.family = "Segoe UI";
Chart.defaults.font.size = 16;

/* PIE CHART */
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Expenses', 'Remaining Budget'],
        datasets: [{
            data: [total, remaining],
            backgroundColor: ['#e74c3c', '#2ecc71']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: "#fff", font: { size: 18 } }
            }
        }
    }
});

/* BAR CHART */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Budget', 'Expenses', 'Remaining'],
        datasets: [{
            data: [budget, total, remaining],
            backgroundColor: ['#3498db', '#e74c3c', '#2ecc71']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                ticks: { color: "#fff", font: { size: 18 } }
            },
            y: {
                ticks: { color: "#fff", font: { size: 16 } }
            }
        }
    }
});
</script>

</body>
</html>