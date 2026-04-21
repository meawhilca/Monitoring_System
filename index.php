<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Budget Monitoring System</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    color: #fff;
}

/* NAVBAR */
.navbar {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-links a {
    color: #00eaff;
    text-decoration: none;
    margin-left: 15px;
    padding: 8px 12px;
    border-radius: 8px;
    transition: 0.3s;
}

.nav-links a:hover {
    background: rgba(0,234,255,0.2);
    box-shadow: 0 0 10px #00eaff;
}

/* HERO */
.hero {
    text-align: center;
    padding: 90px 20px;
}

.hero h1 {
    font-size: 44px;
    color: #00eaff;
}

.hero p {
    font-size: 18px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 30px;
}

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #00eaff, #00ffb3);
    color: #000;
    padding: 12px 22px;
    text-decoration: none;
    border-radius: 10px;
    font-weight: bold;
    transition: 0.3s;
}

.btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #00eaff;
}

/* FEATURES */
.features {
    padding: 40px 20px;
    max-width: 1000px;
    margin: auto;
}

.features h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #00eaff;
}

/* GRID */
.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

/* CARD */
.feature {
    background: rgba(255,255,255,0.05);
    padding: 25px;
    border-radius: 18px;
    text-align: center;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: 0.3s;
    box-shadow: 0 0 20px rgba(0,255,255,0.08);
}

.feature:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 25px rgba(0,255,255,0.4);
}

.feature h3 {
    color: #00eaff;
}

.feature p {
    color: rgba(255,255,255,0.7);
}

/* FOOTER */
.footer {
    text-align: center;
    padding: 15px;
    margin-top: 40px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.1);
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Budget Monitoring System</h2>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="expenses.php">Expenses</a>
        <a href="categories.php">Categories</a>
        <a href="set_budget.php">Budget</a>
        <a href="reports.php">Reports</a>
    </div>
</div>

<!-- HERO SECTION -->
<div class="hero">
    <h1>Manage Your Money Smarter 💡</h1>
    <p>Track expenses, control your budget, and achieve financial discipline.</p>

</div>

<!-- FEATURES -->
<div class="features">
    <h2>✨ Features</h2>

    <div class="feature-grid">

        <div class="feature">
            <h3>📊 Expense Tracking</h3>
            <p>Monitor all your daily expenses in one place.</p>
        </div>

        <div class="feature">
            <h3>💰 Budget Control</h3>
            <p>Set limits and avoid overspending.</p>
        </div>

        <div class="feature">
            <h3>📈 Reports</h3>
            <p>Analyze your spending with clear reports.</p>
        </div>

        <div class="feature">
            <h3>⚡ Real-Time Updates</h3>
            <p>Instantly see your financial status.</p>
        </div>

    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    © <?php echo date("Y"); ?> Budget Monitoring System
</div>

</body>
</html>