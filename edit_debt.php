<?php
require_once "connection.php";

$conn = getConnection();

// Initialize $editData with an empty array
$editData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $debtorName = $_POST["debtor-name"];
    $productName = $_POST["product-title"];
    $amount = $_POST["user-amount"];
    $debtDate = $_POST["debt-date"];
    $dueDate = $_POST["due-date"];

    $updateSql = "UPDATE debt SET title_debt='$productName', amount_debt=$amount, debt_date='$debtDate', debt_due_date='$dueDate', debtor_name='$debtorName' WHERE DebtID=$id";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: debt.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $selectSql = "SELECT * FROM debt WHERE DebtID = $id";
        $editResult = $conn->query($selectSql);

        if ($editResult->num_rows == 1) {
            $editData = $editResult->fetch_assoc();
        } else {
            echo "Debt not found";
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
    <title>Edit Debt</title>
    <link rel="stylesheet" href="Assets/edit_debt.css">

</head>

<body>
<div class="user-amount-container">
    <form method="post" action="">
        <h3>EDIT DEBT</h3>
        <input type="hidden" name="id" value="<?php echo $editData['DebtID']; ?>">
        <input type="text" name="debtor-name" placeholder="Enter Debtor's Name" value="<?php echo $editData['debtor_name']; ?>">
        <input type="text" class="product-title" name="product-title" placeholder="Enter Information of Debt" value="<?php echo $editData['title_debt']; ?>">
        <input type="number" name="user-amount" placeholder="Enter Amount of Debt" value="<?php echo $editData['amount_debt']; ?>">
        <input type="date" name="debt-date" placeholder="Select Debt Date" value="<?php echo $editData['debt_date']; ?>">
        <input type="date" name="due-date" placeholder="Select Due Date" value="<?php echo $editData['debt_due_date']; ?>">
        <a href="debt.php" class="button" id="check-amount">Back</a>
        <button type="submit" class="submit" id="check-amount">Update Debt</button>
    </form>
</div>
</body>

</html>
