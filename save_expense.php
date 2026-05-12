<?php
include 'db.php';

$message = "";
$status = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data safely
    $amount = $_POST['amount'];
    $category_id = $_POST['category_id'];
    $payment_method = $_POST['payment_method'];
    $date = $_POST['date'];
    $desc = $_POST['description'];

    // Get category name from ID
    $catQuery = $conn->query("SELECT name FROM categories WHERE id = '$category_id'");
    $catRow = $catQuery->fetch_assoc();
    $category = $catRow['name'] ?? 'Unknown';

    // Insert expense
    $stmt = $conn->prepare("INSERT INTO expenses (amount, category, payment_method, date, description) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {

        $stmt->bind_param("dssss", $amount, $category, $payment_method, $date, $desc);

        if ($stmt->execute()) {
            $message = "Expense added successfully!";
            $status = "success";
        } else {
            $message = "Failed to save expense.";
            $status = "error";
        }

        $stmt->close();

    } else {
        $message = "Database prepare failed.";
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Expense</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success {
            color: #155724;
            background: #d4edda;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            color: #721c24;
            background: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">

    <?php if ($message != ""): ?>

        <?php if ($status == 'success'): ?>
            <div class="success">
                <?php echo $message; ?>
            </div>
        <?php else: ?>
            <div class="error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <a href="index.php" class="btn">Back to Dashboard</a>

</div>

</body>
</html>