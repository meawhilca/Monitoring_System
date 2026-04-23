<?php
include 'db.php';

/* =========================
   FETCH EDIT DATA (SAFE)
========================= */
$editMonth = null;
$editCategory = null;

/* ===== MONTHLY EDIT ===== */
if (isset($_GET['edit_month'])) {
    $month = $_GET['edit_month'];

    $result = $conn->query("
        SELECT * FROM monthly_budget 
        WHERE month = '$month'
        LIMIT 1
    ");

    if ($result && $result->num_rows > 0) {
        $editMonth = $result->fetch_assoc();
    }
}

/* ===== CATEGORY EDIT ===== */
if (isset($_GET['edit_cat'])) {
    $cat = $_GET['edit_cat'];

    $result = $conn->query("
        SELECT * FROM categories_budget 
        WHERE category_name = '$cat'
        LIMIT 1
    ");

    if ($result && $result->num_rows > 0) {
        $editCategory = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Budget</title>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ===== YOUR ORIGINAL DESIGN (UNCHANGED) ===== */

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

.header {
    background: var(--header);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
}

.nav a {
    color: #00eaff;
    margin-left: 10px;
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
}

.nav a:hover {
    background: rgba(0,234,255,0.2);
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
    padding: 40px;
}

.card {
    background: var(--card);
    backdrop-filter: blur(15px);
    width: 100%;
    max-width: 520px;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}

h2 {
    text-align: center;
    color: #00eaff;
}

label {
    font-weight: 600;
    display: block;
    margin-top: 15px;
    margin-bottom: 6px;
}

input, select {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: white;
}

button {
    width: 100%;
    margin-top: 20px;
    padding: 13px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg,#00eaff,#00ffb3);
    font-weight: 600;
    cursor: pointer;
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
</div>

<div class="container">

<!-- ================= MONTHLY BUDGET ================= -->
<div class="card">

<h2>📅 Monthly Budget</h2>

<form method="POST" action="save_budget.php">

<label>Monthly Budget</label>

<input type="hidden" name="edit_month" value="<?php echo $editMonth['month'] ?? ''; ?>">

<input type="number"
       name="monthly_budget"
       value="<?php echo $editMonth['budget_amount'] ?? ''; ?>"
       placeholder="Enter monthly budget"
       required>

<button type="submit">
    <?php echo $editMonth ? "✏ Update Budget" : "💾 Save Budget"; ?>
</button>

</form>

</div>

<!-- ================= CATEGORY BUDGET ================= -->
<div class="card">

<h2>📂 Category Budget</h2>

<form method="POST" action="save_budget.php">

<label>Category</label>

<select name="category_name" required>
    <option value="">-- Select Category --</option>

    <?php
    $result = $conn->query("SELECT * FROM categories");

    while ($row = $result->fetch_assoc()) {
        $selected = ($editCategory && $editCategory['category_name'] == $row['name']) ? "selected" : "";
        echo "<option value='{$row['name']}' $selected>{$row['name']}</option>";
    }
    ?>
</select>

<label>Budget Limit</label>

<input type="number"
       name="budget_limit"
       value="<?php echo $editCategory['budget_limit'] ?? ''; ?>"
       placeholder="Enter budget limit"
       required>

<button type="submit">
    <?php echo $editCategory ? "✏ Update Category" : "💾 Save Category"; ?>
</button>

</form>

</div>

</div>

</body>
</html>