<?php
include 'db.php';

// Get categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Expense</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #0f2027, #203a43, #2c5364);
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* CARD */
.form-card {
    width: 100%;
    max-width: 500px;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 0 25px rgba(0,234,255,0.1);
}

/* TITLE */
.form-card h2 {
    text-align: center;
    color: #00eaff;
    margin-bottom: 20px;
}

/* INPUTS */
input, select, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: none;
    outline: none;
    background: rgba(0,0,0,0.3);
    color: #fff;
    border: 1px solid rgba(255,255,255,0.1);
}

textarea {
    resize: none;
    height: 80px;
}

/* LABEL */
label {
    font-size: 14px;
    color: rgba(255,255,255,0.8);
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #00eaff, #00bcd4);
    border: none;
    border-radius: 12px;
    font-weight: bold;
    color: #000;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    box-shadow: 0 0 20px #00eaff;
    transform: translateY(-2px);
}

/* BACK LINK */
.back {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #00eaff;
    text-decoration: none;
}

.back:hover {
    text-shadow: 0 0 10px #00eaff;
}
</style>

</head>

<body>

<div class="form-card">

    <h2>Add Expense</h2>

    <form action="save_expense.php" method="POST">

        <!-- AMOUNT -->
        <label>Amount</label>
        <input type="number" step="10" name="amount" required>

        <!-- CATEGORY -->
        <label>Category</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php while($row = $categories->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>">
                    <?= htmlspecialchars($row['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- PAYMENT -->
        <label>Payment Method</label>
        <select name="payment_method" required>
            <option value="Cash">Cash</option>
            <option value="GCash">GCash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
        </select>

        <!-- DATE -->
        <label>Date</label>
        <input type="date" name="date" required>

        <!-- DESCRIPTION -->
        <label>Description</label>
        <textarea name="description" placeholder="Optional..."></textarea>

        <!-- SUBMIT -->
        <button type="submit">Save Expense</button>

    </form>

    <a href="expenses.php" class="back">← Back to Expenses</a>

</div>

</body>
</html>