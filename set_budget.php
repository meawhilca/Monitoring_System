<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Category Budget</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

/* HEADER (same as dashboard) */
.header {
    background: linear-gradient(135deg, #2c3e50, #1f2c3c);
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
    margin-left: 10px;
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
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    padding: 20px;
}

/* CARD STYLE */
.card {
    background: white;
    width: 100%;
    max-width: 500px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* ICON */
.icon {
    text-align: center;
    font-size: 45px;
    margin-bottom: 10px;
}

/* TITLE */
h2 {
    text-align: center;
    margin: 0 0 20px 0;
    color: #2c3e50;
}

/* LABEL */
label {
    font-weight: 600;
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    color: #2c3e50;
}

/* INPUTS */
select, input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
    outline: none;
    transition: 0.3s;
    font-size: 14px;
}

select:focus, input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52,152,219,0.3);
}

/* BUTTON */
button {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    border: none;
    background: #3498db;
    color: white;
    font-size: 15px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #2980b9;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>🎯 Set Category Budget</h2>

    <div class="nav">
        <a href="index2.php">🏠 Home</a>
        <a href="expenses.php">📋 Expenses</a>
        <a href="categories.php">🏷️ Categories</a>
        <a href="set_budget.php">💰 Budget</a>
    </div>
</div>

<!-- FORM CARD -->
<div class="container">

<div class="card">

    <div class="icon">🎯</div>

    <h2>Set Category Budget</h2>

    <form method="POST" action="save_budget.php">

        <label>Category</label>
        <select name="category_name" required>
            <option value="">-- Select Category --</option>

            <?php
            $result = $conn->query("SELECT * FROM categories");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['name']}'>{$row['name']}</option>";
            }
            ?>

        </select>

        <label>Budget Limit</label>
        <input type="number" step="10" name="budget_limit" placeholder="Enter budget amount" required>

        <button type="submit">💾 Save Budget</button>

    </form>

</div>

</div>

</body>
</html>