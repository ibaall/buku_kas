<?php
require_once "connection.php";

$conn = getConnection();

$editData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $productName = $_POST["product-title"];
    $notes = $_POST["user-notes"];
    $amount = $_POST["user-amount"];
    $expensesDate = $_POST["expenses_date"];

    $updateSql = "UPDATE expenses SET title_expenses='$productName', amount_expenses=$amount, notes_expenses='$notes', expenses_date='$expensesDate' WHERE ExpenseID=$id";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: CashOut.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $selectSql = "SELECT * FROM expenses WHERE ExpenseID = $id";
        $editResult = $conn->query($selectSql);

        if ($editResult->num_rows == 1) {
            $editData = $editResult->fetch_assoc();
        } else {
            echo "Budget not found";
            exit;
        }
    } else {
        echo "Invalid request";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Budget</title>
    <link rel="stylesheet" href="Assets/edit_debt.css">

</head>

<body>
<div class="user-amount-container">
    <form method="post" action="">
        <h3>EDIT CASH OUT</h3>
        <input type="hidden" name="id" value="<?php echo $editData['ExpenseID']; ?>">
        <input type="text" class="product-title" name="product-title" placeholder="Enter Information of Budget" value="<?php echo $editData['title_expenses']; ?>">
        <input type="text" name="user-notes" placeholder="Enter Notes" value="<?php echo $editData['notes_expenses']; ?>">
        <input type="number" name="user-amount" placeholder="Enter Amount Expenses" value="<?php echo $editData['amount_expenses']; ?>">
        <input type="date" name="expenses_date" placeholder="Select Data Expenses" value="<?php echo $editData['expenses_date']; ?>">
        <a href="CashOut.php" class="button" id="check-amount">Back</a>
        <button type="submit" class="submit" id="check-amount">Update Expenses</button>
    </form>
</div>
</body>

</html>
