<?php include 'db.php'; ?>

<h2>🎯 Set Category Budget</h2>

<form method="POST" action="save_budget.php">

    Category:
    <select name="category_name" required>
        <option value="">-- Select Category --</option>

        <?php
        $result = $conn->query("SELECT * FROM categories");

        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['name']}'>{$row['name']}</option>";
        }
        ?>

    </select><br><br>

    Budget Limit:
    <input type="number" step="10" name="budget_limit" required><br><br>

    <button type="submit">💾 Save Budget</button>
</form>