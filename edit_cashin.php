<?php
require_once "connection.php";

$conn = getConnection();

$editData = [];

// Check if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $id = intval($_POST["id"]);
    $productName = $conn->real_escape_string($_POST["product-title"]);
    $notes = $conn->real_escape_string($_POST["notes"]);
    $amount = floatval($_POST["user-amount"]);
    $budgetDate = $conn->real_escape_string($_POST["due-date"]);

    // Use prepared statement to prevent SQL injection
    $updateSql = $conn->prepare("UPDATE budgets SET title_budget=?, amount_budget=?, notes_budget=?, budget_date=? WHERE BudgetID=?");
    $updateSql->bind_param("sdsis", $productName, $amount, $notes, $budgetDate, $id);

    // Execute the update query
    if ($updateSql->execute()) {
        // Redirect after successful update
        header("Location: CashIn.php");
        exit;
    } else {
        // Handle errors
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET["id"])) {
        // Sanitize the 'id' parameter to prevent SQL injection
        $id = intval($_GET["id"]);

        // Use prepared statement to prevent SQL injection
        $selectSql = $conn->prepare("SELECT * FROM budgets WHERE BudgetID = ?");
        $selectSql->bind_param("i", $id);

        // Execute the select query
        $selectSql->execute();
        $editResult = $selectSql->get_result();

        // Check if a budget with the specified ID exists
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

$selectSql->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Budget</title>
    <link rel="stylesheet" href="Assets/edit_debt.css">
</head>

<body>
<div class="user-amount-container">
    <h3>EDIT CASH IN</h3>
    <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $editData['BudgetID']; ?>">
    <input type="text" class="product-title" name="product-title" placeholder="Enter Information of Budget" value="<?php echo htmlspecialchars($editData['title_budget']); ?>">
    <input type="number" name="user-amount" placeholder="Enter Amount Budgets" value="<?php echo $editData['amount_budget']; ?>">
    <input type="date" name="due-date" placeholder="Select Due Date" value="<?php echo $editData['budget_date']; ?>">
    <a href="CashIn.php" class="button" id="check-amount">Back</a>
    <button type="submit" class="submit" id="check-amount">Update Budget</button>
    
</form>
</div>
</body>

</html>
