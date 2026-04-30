<?php
include 'db.php';

// ADD CATEGORY
if (isset($_POST['add_category'])) {
    $category = $_POST['category'];

    if (!empty($category)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category);
        $stmt->execute();
    }

    header("Location: categories.php");
    exit();
}

// DELETE CATEGORY
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: categories.php");
    exit();
}

$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Categories</title>

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
    color: #fff;
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
    padding: 30px;
}

/* CARD (GLASS EFFECT) */
.card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-radius: 18px;
    padding: 25px;
    max-width: 850px;
    margin: auto;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 25px rgba(0,255,255,0.08);
}

/* TITLE */
h2 {
    margin-top: 0;
    color: #00eaff;
}

/* FORM */
form {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
}

/* INPUT */
input[type="text"] {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.2);
    background: transparent;
    color: #fff;
    outline: none;
}

input::placeholder {
    color: rgba(255,255,255,0.5);
}

input:focus {
    border-color: #00eaff;
    box-shadow: 0 0 8px #00eaff;
}

/* BUTTON */
button {
    background: linear-gradient(135deg, #00eaff, #00ffb3);
    color: #000;
    border: none;
    padding: 12px 18px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #00eaff;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

/* TABLE HEADER */
th {
    background: rgba(255,255,255,0.08);
    padding: 12px;
    text-align: left;
    color: #00eaff;
}

/* TABLE ROW */
td {
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

tr:hover {
    background: rgba(255,255,255,0.05);
}

/* BADGE */
.badge {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(0,234,255,0.2);
    color: #00eaff;
    border-radius: 20px;
    font-weight: 600;
}

/* DELETE LINK */
a {
    color: #ff4d6d;
    text-decoration: none;
    font-weight: bold;
    transition: 0.2s;
}

a:hover {
    text-shadow: 0 0 8px #ff4d6d;
}

/* RESPONSIVE */
@media(max-width: 768px){
    form {
        flex-direction: column;
    }
}

</style>

</head>

<body>

<!-- HEADER (same style as index2.php) -->
<div class="header">
   <h2>📂 Manage Categories</h2>

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

<div class="card">

    <h2>Manage Categories</h2>

    <!-- ADD CATEGORY -->
    <form method="POST">
        <input type="text" name="category" placeholder="Enter category name" required>
        <button type="submit" name="add_category">Add</button>
    </form>

    <!-- TABLE -->
    <table>
        <tr>
            <th>Category Name</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td>
                <span class="badge"><?= htmlspecialchars($row['name']) ?></span>
            </td>
            <td>
                <a href="categories.php?delete=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this category?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

</div>

</body>
</html>