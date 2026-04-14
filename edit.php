<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Get ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("No ID provided.");
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM expenses WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Record not found.");
}

// Update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $payment_method = $_POST['payment_method'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $update = $conn->prepare("UPDATE expenses 
        SET amount=?, category=?, payment_method=?, date=?, description=? 
        WHERE id=?");

    $update->bind_param("dssssi", $amount, $category, $payment_method, $date, $description, $id);

    if ($update->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense</title>
</head>
<body>

<h2>✏️ Edit Expense</h2>

<form method="POST">
    
    Amount:
    <input type="number" step="0.01" name="amount" value="<?= $data['amount'] ?>" required><br><br>

    Category:
    <input type="text" name="category" value="<?= $data['category'] ?>" required><br><br>

    Payment Method:
    <input type="text" name="payment_method" value="<?= $data['payment_method'] ?>"><br><br>

    Date:
    <input type="date" name="date" value="<?= $data['date'] ?>" required><br><br>

    Description:
    <input type="text" name="description" value="<?= $data['description'] ?>"><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="index.php">⬅ Back</a>

</body>
</html>