<?php
include 'db.php';

/* ===== FETCH MONTHLY BUDGET ===== */
$monthly = $conn->query("
    SELECT * FROM monthly_budget ORDER BY month DESC
");

/* ===== FETCH CATEGORY BUDGET ===== */
$category = $conn->query("
    SELECT * FROM categories_budget ORDER BY category_name ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Budget Summary</title>

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
    max-width: 800px;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}

h2 {
    text-align: center;
    color: #00eaff;
}

/* ================= TABLE FIX ================= */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: rgba(255,255,255,0.08);
    color: #00eaff;
    padding: 12px;
    text-align: center;
}

td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    text-align: center;
}

/* LEFT ALIGN FIRST COLUMN */
th:first-child,
td:first-child {
    text-align: left;
}

/* RIGHT ALIGN MONEY (optional finance style) */
td:nth-child(2) {
    text-align: right;
}

tr:hover {
    background: rgba(255,255,255,0.05);
}

.badge {
    padding: 5px 12px;
    background: rgba(0,234,255,0.2);
    border-radius: 20px;
    color: #00eaff;
    font-size: 12px;
}

/* EDIT BUTTON */
.edit-btn {
    padding: 5px 10px;
    background: rgba(0,234,255,0.2);
    color: #00eaff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12px;
    transition: 0.3s;
}

.edit-btn:hover {
    background: rgba(0,234,255,0.4);
    box-shadow: 0 0 8px #00eaff;
}

</style>
</head>

<body>

<div class="header">
    <h2>Budget Control</h2>
    <div class="nav">
        <a href="set_budget.php">Back</a>
    </div>
</div>

<div class="container">

<!-- MONTHLY BUDGET -->
<div class="card">

<h2>Monthly Budget</h2>

<table>
<tr>
    <th>Month</th>
    <th>Budget</th>
    <th>Action</th>
</tr>

<?php while($row = $monthly->fetch_assoc()): ?>
<tr>
    <td><?php echo date("F Y", strtotime($row['month'])); ?></td>
    <td>₱<?php echo number_format($row['budget_amount'], 2); ?></td>
    <td>
        <a class="edit-btn" href="set_budget.php?edit_month=<?php echo $row['month']; ?>">
            Edit
        </a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>

<!-- CATEGORY BUDGET -->
<div class="card">

<h2>Category Budget</h2>

<table>
<tr>
    <th>Category</th>
    <th>Budget</th>
    <th>Action</th>
</tr>

<?php while($row = $category->fetch_assoc()): ?>
<tr>
    <td><span class="badge"><?php echo $row['category_name']; ?></span></td>
    <td>₱<?php echo number_format($row['budget_limit'], 2); ?></td>
    <td>
        <a class="edit-btn" href="set_budget.php?edit_cat=<?php echo $row['category_name']; ?>">
            Edit
        </a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>