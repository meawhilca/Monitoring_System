<?php
include 'db.php';

// ===============================
// ADD CATEGORY
// ===============================
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

// ===============================
// DELETE CATEGORY
// ===============================
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: categories.php");
    exit();
}

// ===============================
// FETCH CATEGORIES
// ===============================
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
$categoryList = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories & Budget</title>
</head>
<body>

<h2>📂 Expense Categories</h2>

<!-- ADD CATEGORY -->
<form method="POST">
    <input type="text" name="category" placeholder="Enter category name" required>
    <button type="submit" name="add_category">Add Category</button>
</form>

<hr>

<!-- CATEGORY LIST -->
<table border="1" cellpadding="10">
    <tr>
        <th>Category Name</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td>
                <a href="categories.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this category?')">
                   Delete
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<hr>

