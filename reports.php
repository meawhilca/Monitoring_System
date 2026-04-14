<?php
include 'db.php';

// Get all expenses
$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");

// Total expenses
$totalResult = $conn->query("SELECT SUM(amount) as total FROM expenses");
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'] ?? 0;

// Category breakdown
$categoryResult = $conn->query("
    SELECT category, SUM(amount) as total 
    FROM expenses 
    GROUP BY category
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expense Report</title>
</head>
<body>

<h2>📊 Expense Report</h2>

<h3>💰 Total Expenses: ₱<?php echo number_format($total, 2); ?></h3>

<hr>

<h3>📌 Expenses by Category</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Category</th>
        <th>Total Amount</th>
    </tr>

    <?php while($row = $categoryResult->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['category']; ?></td>
            <td>₱<?php echo number_format($row['total'], 2); ?></td>
        </tr>
    <?php } ?>
</table>

<hr>

<h3>📋 Full Expense List</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Payment Method</th>
        <th>Date</th>
        <th>Description</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td>₱<?php echo $row['amount']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>