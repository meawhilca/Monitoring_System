<?php include 'db.php'; ?>

<style>
body {
    margin: 0;
    font-family: Arial;
}

.sidebar {
    width: 240px;
    height: 100vh;
    background: #2c3e50;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
}

.sidebar h2 {
    color: white;
    text-align: center;
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px;
    text-decoration: none;
    margin: 5px 10px;
    border-radius: 5px;
}

.sidebar a:hover {
    background: #4c6a88;
}

.content {
    margin-left: 250px;
    padding: 20px;
}
</style>

<div class="sidebar">
    <h2>💰 Budget System</h2>

    <a href="index.php">🏠 Dashboard</a>
    <a href="set_budget.php">🎯 Set Budget</a>
    <a href="categories.php">📂 Categories</a>
    <a href="reports.php">📊 Reports</a>
    <a href="edit.php">✏️ Edit Expense</a>
    <a href="delete.php">🗑️ Delete Expense</a>
</div>