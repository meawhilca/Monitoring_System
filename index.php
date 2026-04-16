<?php include 'db.php'; ?>
<?php include 'user_sidebar.php'; ?>

<?php
$budget = 10000;

$result = $conn->query("SELECT SUM(amount) as total FROM expenses");
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;

$exceededQuotes = [
    "Overspending today means financial struggle tomorrow.",
    "Control your spending before it controls you.",
    "Think before you spend, or regret after you spend."
];

$warningQuotes = [
    "Be careful! You're getting close to your limit.",
    "Slow down your spending—you’re almost there."
];

$safeQuotes = [
    "Great job! You are managing your money well.",
    "Keep it up! Financial discipline pays off."
];

function randomQuote($arr) {
    return $arr[array_rand($arr)];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Budget System</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .content {
        max-width: 1100px;
        margin: 30px auto;
        background: white;
        padding: 25px;
        border-radius: 12px;
        border: 2px solid #4c6a88;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    h2, h3 {
        color: #4c6a88;
    }

    /* STATUS BOX */
    .status-box {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        font-weight: bold;
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

    /* INPUTS */
    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #4c6a88;
        box-shadow: 0 0 5px rgba(76,106,136,0.3);
    }

    /* BUTTONS */
    button {
        background: #4c6a88;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #3b556f;
    }

    a {
        color: #4c6a88;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .safe { color: green; }
    .warning { color: orange; }
    .danger { color: red; }
</style>

</head>

<body>

<div class="content">

<h2>💰 Budget Reminder System</h2>

<?php
if ($total > $budget) {
    echo "<div class='status-box danger'>⚠️ Budget Exceeded!<br>" . randomQuote($exceededQuotes) . "</div>";

} elseif ($total > ($budget * 0.8)) {
    echo "<div class='status-box warning'>⚠️ Near Budget Limit!<br>" . randomQuote($warningQuotes) . "</div>";

} else {
    echo "<div class='status-box safe'>✅ You are within your budget.<br>" . randomQuote($safeQuotes) . "</div>";
}
?>

<h3>Total Spending: ₱<?= $total ?> / ₱<?= $budget ?></h3>

<hr>

<h3>📂 Daily Category Budget</h3>

<table>
<tr>
    <th>Category</th>
    <th>Budget / Day</th>
    <th>Spent Today</th>
    <th>Status</th>
</tr>

<?php
$dateToday = date("Y-m-d");

$budgetResult = $conn->query("SELECT * FROM categories_budget");

while ($b = $budgetResult->fetch_assoc()) {

    $category = $b['category_name'];
    $limit = $b['budget_limit'];

    $spentQuery = $conn->prepare("
        SELECT SUM(amount) as total 
        FROM expenses 
        WHERE category = ? AND date = ?
    ");
    $spentQuery->bind_param("ss", $category, $dateToday);
    $spentQuery->execute();
    $spentResult = $spentQuery->get_result()->fetch_assoc();

    $spent = $spentResult['total'] ?? 0;

    if ($spent > $limit) {
        $status = "<span class='danger'>⚠️ Exceeded</span>";
    } elseif ($spent > ($limit * 0.8)) {
        $status = "<span class='warning'>⚠️ Near</span>";
    } else {
        $status = "<span class='safe'>✅ Safe</span>";
    }

    echo "<tr>
        <td>$category</td>
        <td>₱$limit</td>
        <td>₱$spent</td>
        <td>$status</td>
    </tr>";
}
?>
</table>

<hr>

<h3>➕ Add Expense</h3>

<form method="POST" action="add.php">

    Amount:
    <input type="number" step="0.01" name="amount" required>

    Category:
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php
        $catResult = $conn->query("SELECT * FROM categories");
        while ($row = $catResult->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    Payment Method:
    <select name="payment_method" required>
        <option value="">-- Select Payment Method --</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="Bank Transfer">Bank Transfer</option>
    </select>

    Date:
    <input type="date" name="date" required>

    Description:
    <input type="text" name="description">

    <button type="submit">➕ Add Expense</button>
</form>

<hr>

<h3>📋 Expense List</h3>

<table>
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
$result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>₱{$row['amount']}</td>
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

<a href="reports.php">
    <button>📊 View Report</button>
</a>

</div>

</body>
</html>