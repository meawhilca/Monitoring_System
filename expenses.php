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
    background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    color: #fff;
}

/* HEADER */
.header {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    margin: 0;
}

/* NAV */
.nav {
    display: flex;
    gap: 10px;
}

.back-btn {
    color: #00eaff;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.back-btn:hover {
    background: rgba(0,234,255,0.2);
    box-shadow: 0 0 10px #00eaff;
}

/* PAGE */
.page-wrapper {
    padding: 25px;
}

/* TITLE */
.page-title h1 {
    margin: 0;
    color: #00eaff;
}

.subtitle {
    color: rgba(255,255,255,0.7);
}

/* TABLE CARD */
.table-card {
    margin-top: 20px;
    background: rgba(255,255,255,0.05);
    border-radius: 18px;
    padding: 15px;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 25px rgba(0,255,255,0.08);
    overflow-x: auto;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

/* HEADER */
thead {
    background: rgba(255,255,255,0.08);
}

th {
    color: #00eaff;
}

/* CELLS */
th, td {
    padding: 12px;
    font-size: 14px;
}

tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

tbody tr:hover {
    background: rgba(255,255,255,0.05);
}

/* AMOUNT */
.td-amount {
    font-weight: bold;
    color: #ff4d6d;
}

/* PAYMENT CHIP */
.payment-chip {
    background: rgba(0,234,255,0.2);
    color: #00eaff;
    padding: 5px 12px;
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
    transition: 0.3s;
}

.action-edit {
    background: rgba(241, 196, 15, 0.2);
    color: #f1c40f;
}

.action-edit:hover {
    box-shadow: 0 0 10px #f1c40f;
}

.action-delete {
    background: rgba(231, 76, 60, 0.2);
    color: #ff4d6d;
}

.action-delete:hover {
    box-shadow: 0 0 10px #ff4d6d;
}

/* FOOTER */
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
        <a href="index.php" class="back-btn">Home</a>
        <a href="dashboard.php" class="back-btn">Dashboard</a>
        <a href="expenses.php" class="back-btn">Expenses</a>
        <a href="categories.php" class="back-btn">Categories</a>
        <a href="set_budget.php" class="back-btn">Budget</a>
        <a href="reports.php" class="back-btn">Reports</a>
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