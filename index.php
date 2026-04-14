<?php include 'db.php'; ?>
<?php include 'user_sidebar.php'; ?>

<div class="content">

<h2>💰 Budget Reminder System</h2>

<?php
$budget = 10000;

// TOTAL EXPENSES
$result = $conn->query("SELECT SUM(amount) as total FROM expenses");
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;

// QUOTES
$exceededQuotes = [
    "Overspending today means financial struggle tomorrow.",
    "A small expense today can become a big problem later.",
    "Discipline is the bridge between goals and achievement.",
    "Control your spending before it controls you.",
    "Budgeting is telling your money where to go, not wondering where it went.",
    "Financial freedom starts with self-control.",
    "Think before you spend, or regret after you spend.",
    "Every peso saved is a step toward financial security."
];

$warningQuotes = [
    "Be careful! You're getting close to your limit.",
    "Slow down your spending—you’re almost there.",
    "A wise person tracks every expense.",
    "You are approaching your budget boundary.",
    "Pause and think before your next purchase.",
    "Stay alert—financial discipline is key."
];

$safeQuotes = [
    "Great job! You are managing your money well.",
    "Keep it up! Financial discipline pays off.",
    "You are in control of your expenses.",
    "Smart spending leads to a secure future.",
    "Success starts with good budgeting habits."
];

function randomQuote($arr) {
    return $arr[array_rand($arr)];
}
?>

<?php
if ($total > $budget) {
    echo "<h3 style='color:red;'>⚠️ Budget Exceeded!</h3>";
    echo "<p style='color:red;'>" . randomQuote($exceededQuotes) . "</p>";

} elseif ($total > ($budget * 0.8)) {
    echo "<h3 style='color:orange;'>⚠️ Near Budget Limit!</h3>";
    echo "<p style='color:orange;'>" . randomQuote($warningQuotes) . "</p>";

} else {
    echo "<h3 style='color:green;'>✅ You are within your budget.</h3>";
    echo "<p style='color:green;'>" . randomQuote($safeQuotes) . "</p>";
}
?>

<h3>Total Spending: ₱<?= $total ?> / ₱<?= $budget ?></h3>

<hr>

<!-- ================= CATEGORY BUDGET DISPLAY ================= -->
<h3>📂 Category Budget Limits</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Category</th>
    <th>Budget Limit</th>
</tr>

<?php
$budgetResult = $conn->query("SELECT * FROM categories_budget");

while ($b = $budgetResult->fetch_assoc()) {
    echo "<tr>
        <td>{$b['category_name']}</td>
        <td>₱{$b['budget_limit']}</td>
    </tr>";
}
?>
</table>

<hr>

<!-- ================= ADD EXPENSE ================= -->
<h3>Add Expense</h3>

<form method="POST" action="add.php">

    Amount:
    <input type="number" step="0.01" name="amount" required><br><br>

    Category:
    <select name="category_id" required>
        <option value="">-- Select Category --</option>

        <?php
        $result = $conn->query("SELECT * FROM categories");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    Payment Method:
    <select name="payment_method" required>
        <option value="">-- Select Payment Method --</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="Bank Transfer">Bank Transfer</option>
    </select><br><br>

    Date:
    <input type="date" name="date" required><br><br>

    Description:
    <input type="text" name="description"><br><br>

    <button type="submit">Add Expense</button>
</form>

<hr>

<!-- ================= EXPENSE LIST ================= -->
<h3>Expense List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Amount</th>
    <th>Category</th>
    <th>Payment</th>
    <th>Date</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM expenses");

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['amount']}</td>
        <td>{$row['category']}</td>
        <td>{$row['payment_method']}</td>
        <td>{$row['date']}</td>
        <td>{$row['description']}</td>
        <td>
           <a href='edit.php?id={$row['id']}'>Edit</a> | 
           <a href='delete.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>
</table>

<br>

<a href="report.php">
    <button>📊 View Report</button>
</a>

</div>