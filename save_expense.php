<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Add Expense</title>

<style>
body{
    font-family:Segoe UI;
    background:#0f2027;
    color:white;
    padding:30px;
}

.form-card{
    max-width:500px;
    margin:auto;
    background:rgba(255,255,255,0.05);
    padding:25px;
    border-radius:15px;
    backdrop-filter:blur(10px);
}

input, select, textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:20px;
    border:none;
    border-radius:10px;
}

button{
    background:#00eaff;
    color:black;
    padding:12px 20px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    box-shadow:0 0 15px #00eaff;
}
</style>

</head>
<body>

<div class="form-card">

<h2>Add Expense</h2>

<form action="save_expense.php" method="POST">

    <label>Amount</label>
    <input type="number" step="0.01" name="amount" required>

    <label>Category</label>
    <select name="category_id" required>

        <?php
        $cats = $conn->query("SELECT * FROM categories");

        while($cat = $cats->fetch_assoc()):
        ?>

        <option value="<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['name']) ?>
        </option>

        <?php endwhile; ?>

    </select>

    <label>Payment Method</label>
    <select name="payment_method">
        <option>Cash</option>
        <option>GCash</option>
        <option>Credit Card</option>
        <option>Debit Card</option>
    </select>

    <label>Date</label>
    <input type="date" name="date" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <button type="submit">
        Save Expense
    </button>

</form>

</div>

</body>
</html>