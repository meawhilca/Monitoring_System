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

/* NAV */
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
    padding: 25px;
}

/* CARD */
.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    max-width: 800px;
    margin: auto;
}

/* TITLE */
h2 {
    margin-top: 0;
    color: #2c3e50;
}

/* FORM */
form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

input[type="text"] {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    outline: none;
}

input:focus {
    border-color: #3498db;
}

/* BUTTON */
button {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #2980b9;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #2c3e50;
    color: white;
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f8f9fb;
}

/* BADGE */
.badge {
    display: inline-block;
    padding: 6px 12px;
    background: #e3f2fd;
    color: #1e3a8a;
    border-radius: 20px;
    font-weight: 600;
}

/* DELETE LINK */
a {
    color: #e74c3c;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
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
    <h2>📂 Categories</h2>

    <div class="nav">
        <a href="index2.php">🏠 Home</a>
        <a href="expenses.php">📋 Expenses</a>
        <a href="categories.php">🏷️ Categories</a>
        <a href="set_budget.php">💰 Budget</a>
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