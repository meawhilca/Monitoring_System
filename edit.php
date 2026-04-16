<?php
include 'db.php';

// GET ID
$id = $_GET['id'] ?? null;

// VALIDATE ID
if (!$id || !is_numeric($id)) {
    die("Invalid ID (missing or not numeric)");
}

// FETCH RECORD
$stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid ID (record not found)");
}

$data = $result->fetch_assoc();

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $payment = $_POST['payment_method'];
    $date = $_POST['date'];
    $desc = $_POST['description'];

    $update = $conn->prepare("
        UPDATE expenses 
        SET amount=?, category=?, payment_method=?, date=?, description=? 
        WHERE id=?
    ");

    $update->bind_param("dssssi", $amount, $category, $payment, $date, $desc, $id);
    $update->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Edit Expense</h2>

<form method="POST">
    Amount:
    <input type="number" step="0.01" name="amount" value="<?= $data['amount'] ?>" required><br><br>

    Category:
    <input type="text" name="category" value="<?= $data['category'] ?>" required><br><br>

    Payment Method:
    <input type="text" name="payment_method" value="<?= $data['payment_method'] ?>" required><br><br>

    Date:
    <input type="date" name="date" value="<?= $data['date'] ?>" required><br><br>

    Description:
    <input type="text" name="description" value="<?= $data['description'] ?>"><br><br>

    <button type="submit">Update</button>
</form>