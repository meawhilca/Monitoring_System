<?php
session_start();
include 'db.php';
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
    background: #f0f2f5;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #1f2c3c, #2c3e50);
    color: white;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    margin: 0;
    font-size: 20px;
}

.nav a {
    color: white;
    margin-left: 12px;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 8px;
    transition: 0.3s;
}

.nav a:hover {
    background: rgba(255,255,255,0.15);
}

/* CONTAINER */
.container {
    padding: 25px;
}

/* CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 18px;
    margin-top: 10px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    text-align: center;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h2 {
    margin: 0;
    font-size: 26px;
    color: #2c3e50;
}

.card p {
    margin-top: 5px;
    color: #7f8c8d;
}

/* CHARTS */
.charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 25px;
}

.chart-box {
    background: white;
    padding: 18px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    height: 260px;
}

.chart-box h3 {
    margin: 0 0 10px 0;
    font-size: 16px;
    color: #2c3e50;
}

/* CANVAS */
canvas {
    width: 100% !important;
    height: 200px !important;
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
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="set_budget.php">Budget</a>
    </div>
</div>

<div class="container">

<?php
$budget = 10000;

$result = $conn->query("SELECT SUM(amount) as total FROM expenses");
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;

$remaining = $budget - $total;
$percent = ($budget > 0) ? ($total / $budget) * 100 : 0;
?>

<!-- CARDS -->
<div class="cards">

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

<!-- CHARTS -->
<div class="charts">

    <div class="chart-box">
        <h3>Budget Overview</h3>
        <canvas id="budgetChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Expenses vs Remaining</h3>
        <canvas id="barChart"></canvas>
    </div>

</div>

</div>

<script>
const budget = <?php echo $budget; ?>;
const total = <?php echo $total; ?>;
const remaining = <?php echo $remaining; ?>;

/* PIE CHART */
new Chart(document.getElementById('budgetChart'), {
    type: 'doughnut',
    data: {
        labels: ['Expenses', 'Remaining'],
        datasets: [{
            data: [total, remaining],
            backgroundColor: ['#e74c3c', '#2ecc71'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

/* BAR CHART */
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Budget', 'Expenses', 'Remaining'],
        datasets: [{
            data: [budget, total, remaining],
            backgroundColor: ['#3498db', '#e74c3c', '#2ecc71'],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

</body>
</html>