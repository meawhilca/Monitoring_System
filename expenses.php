<?php
include 'db.php';

$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expense List</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #2c3e50, #1f2c3c);
    color: white;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    margin: 0;
    font-size: 20px;
}

/* NAV BUTTONS */
.nav {
    display: flex;
    gap: 10px;
}

.back-btn {

    color: white;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.back-btn:hover {
    background: #2980b9;
}

/* CONTAINER */
.page-wrapper {
    padding: 25px;
}

/* TITLE */
.page-title h1 {
    margin: 0;
    color: #2c3e50;
}

.subtitle {
    margin-top: 5px;
    color: #7f8c8d;
}

/* TABLE */
.table-card {
    margin-top: 20px;
    background: white;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

thead {
    background: #2c3e50;
    color: white;
}

th, td {
    padding: 12px;
    text-align: left;
    font-size: 14px;
}

tbody tr {
    border-bottom: 1px solid #eee;
}

tbody tr:hover {
    background: #f8f9fb;
}

/* AMOUNT */
.td-amount {
    font-weight: bold;
    color: #e74c3c;
}

/* PAYMENT CHIP */
.payment-chip {
    background: #ecf0f1;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* ACTION BUTTONS */
.action-btn {
    text-decoration: none;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
    margin-right: 5px;
}

.action-edit {
    background: #f1c40f;
    color: #000;
}

.action-delete {
    background: #e74c3c;
    color: white;
}

/* FOOTER CENTER BUTTON */
.footer {
    text-align: center;
    margin: 25px 0;
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>📋 Expense List</h1>

    <div class="nav">
        <a href="index2.php" class="back-btn">🏠 Home</a>
        <a href="expenses.php" class="back-btn">📋 Expenses</a>
        <a href="categories.php" class="back-btn">🏷️ Categories</a>
        <a href="set_budget.php" class="back-btn">💰 Budget</a>
    </div>
</div>

<!-- CONTENT -->
<div class="page-wrapper">

    <div class="page-title">
        <h1>All Expenses</h1>
        <p class="subtitle">View and manage all recorded expenses</p>
    </div>

    <div class="table-card">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>

                    <td>#<?= htmlspecialchars($row['id']) ?></td>

                    <td class="td-amount">
                        ₱<?= number_format($row['amount'], 2) ?>
                    </td>

                    <td><?= htmlspecialchars($row['category']) ?></td>

                    <td>
                        <span class="payment-chip">
                            <?= htmlspecialchars($row['payment_method']) ?>
                        </span>
                    </td>

                    <td><?= htmlspecialchars($row['date']) ?></td>

                    <td><?= htmlspecialchars($row['description'] ?: '—') ?></td>

                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn action-edit">
                            ✏️ Edit
                        </a>

                        <a href="delete.php?id=<?= $row['id'] ?>" 
                           class="action-btn action-delete"
                           onclick="return confirm('Delete this expense?')">
                            🗑️ Delete
                        </a>
                    </td>

                </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

    <!-- CENTER FOOTER BUTTON -->
    <div class="footer">
        <a href="index2.php" class="back-btn">⬅ Back to Dashboard</a>
    </div>

</div>

</body>
</html>