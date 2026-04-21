<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Budget</title>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

:root {
    --bg: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    --card: rgba(255,255,255,0.05);
    --text: #ffffff;
    --subtext: rgba(255,255,255,0.7);
    --header: rgba(255,255,255,0.05);
    --input-bg: rgba(255,255,255,0.05);
    --border: rgba(255,255,255,0.2);
}

body {
    margin: 0;
    font-family: 'Outfit', sans-serif;
    background: var(--bg);
    color: var(--text);
}

/* HEADER */
.header {
    background: var(--header);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav a {
    color: #00eaff;
    margin-left: 10px;
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
    transition: 0.3s;
}

.nav a:hover {
    background: rgba(0,234,255,0.2);
    box-shadow: 0 0 10px #00eaff;
}

/* CONTAINER */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
    padding: 40px;
}

/* CARD */
.card {
    background: var(--card);
    backdrop-filter: blur(15px);
    width: 100%;
    max-width: 520px;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 25px rgba(0,255,255,0.08);
}

/* TITLE */
h2 {
    text-align: center;
    color: #00eaff;
}

.subtitle {
    text-align: center;
    font-size: 13px;
    color: var(--subtext);
    margin-bottom: 20px;
}

/* LABEL */
label {
    font-weight: 600;
    display: block;
    margin-top: 15px;
    margin-bottom: 6px;
}

/* INPUTS */
select, input {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--input-bg);
    color: var(--text);
    outline: none;
}

select:focus, input:focus {
    border-color: #00eaff;
    box-shadow: 0 0 8px #00eaff;
}

/* BUTTON */
button {
    width: 100%;
    margin-top: 20px;
    padding: 13px;
    border: none;
    background: linear-gradient(135deg, #00eaff, #00ffb3);
    color: #000;
    font-size: 15px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #00eaff;
}

/* SECTION TITLE */
.section-title {
    margin-bottom: 10px;
    color: #00eaff;
    font-size: 14px;
    text-transform: uppercase;
    text-align: center;
}

/* NOTE */
.note {
    text-align: center;
    font-size: 12px;
    color: var(--subtext);
    margin-top: 10px;
}

</style>
</head>

<body>

<div class="header">
    <h2>🎯 Budget Control</h2>
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

<!-- ================= MONTHLY BUDGET ================= -->
<div class="card">

    <h2>📅 Monthly Budget</h2>
    <div class="subtitle">Set your total monthly spending limit</div>

    <form method="POST" action="save_budget.php">

        <label>Total Monthly Budget (₱)</label>
        <input type="number" step="10" name="monthly_budget" placeholder="e.g. 10000" required>

        <button type="submit">💾 Save Monthly Budget</button>

    </form>

</div>

<!-- ================= CATEGORY BUDGET ================= -->
<div class="card">

    <h2>📂 Category Budget</h2>
    <div class="subtitle">Set limits per expense category</div>

    <form method="POST" action="save_budget.php">

        <label>Category</label>
        <select name="category_name" required>
            <option value="">-- Select Category --</option>

            <?php
            $result = $conn->query("SELECT * FROM categories");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".htmlspecialchars($row['name'])."'>".htmlspecialchars($row['name'])."</option>";
            }
            ?>
        </select>

        <label>Category Budget Limit (₱)</label>
        <input type="number" step="10" name="budget_limit" placeholder="e.g. 500" required>

        <button type="submit">💾 Save Category Budget</button>

    </form>

</div>

</div>

</body>
</html>