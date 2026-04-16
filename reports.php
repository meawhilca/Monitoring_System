<?php
include 'db.php';

$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");

$totalResult = $conn->query("SELECT SUM(amount) as total FROM expenses");
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'] ?? 0;

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

<link rel="stylesheet" href="css/style.css">
    
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: white;
        padding: 25px;
        border-radius: 12px;
        border: 2px solid #4c6a88; /* MAIN COLOR BORDER */
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    h2, h3 {
        color: #4c6a88;
    }

    .summary {
        display: flex;
        justify-content: space-between;
        background: #eef3f8;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #333;
    }

    /* TABLE STYLE */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th {
        background: #4c6a88;
        color: white;
        padding: 12px;
        text-align: left;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    tr:hover {
        background: #f1f5f9;
    }

    /* BUTTONS */
    .btn {
        display: inline-block;
        padding: 10px 15px;
        background: #4c6a88;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        margin-right: 10px;
        transition: 0.3s;
    }

    .btn:hover {
        background: #3b556f;
    }

    .btn-group {
        margin-bottom: 15px;
    }

    /* BADGE */
    .badge {
        display: inline-block;
        padding: 5px 10px;
        background: #e0ecff;
        color: #1e3a8a;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }


</style>

</head>

<body>

<div class="container">

<h2>📊 Expense Report</h2>

<div class="summary">
    <div>💰 Total Expenses: ₱<?php echo number_format($total, 2); ?></div>
</div>

<div class="btn-group">
    <a href="#" class="btn">⬇ Export</a>
    <a href="#" class="btn">🖨 Print</a>
</div>

<hr>

<h3>📌 Expenses by Category</h3>
<table>
    <tr>
        <th>Category</th>
        <th>Total Amount</th>
    </tr>

    <?php while($row = $categoryResult->fetch_assoc()) { ?>
        <tr>
            <td><span class="badge"><?php echo $row['category']; ?></span></td>
            <td>₱<?php echo number_format($row['total'], 2); ?></td>
        </tr>
    <?php } ?>
</table>

<hr>

<h3>📋 Full Expense List</h3>

<table>
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
            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
            <td><span class="badge"><?php echo $row['category']; ?></span></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php } ?>
</table>

</div>

</body>
</html>