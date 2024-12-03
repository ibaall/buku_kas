<?php
require_once "connection.php";

$conn = getConnection();

$editData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $productName = $_POST["product_name"];
    $amount = $_POST["tax_total"];
    $dueDate = $_POST["due_date_tax"];

    $updateSql = "UPDATE tax SET product_name='$productName', tax_total=$amount, due_date_tax='$debtDate' WHERE tax_id=$id";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: tax.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $selectSql = "SELECT * FROM tax WHERE tax_id = $id";
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
        <h3>EDIT TAX</h3>
        <input type="hidden" name="id" value="<?php echo $editData['tax_id']; ?>">
        <input type="text" class="product-title" name="product-title" placeholder="Enter Information of Debt" value="<?php echo $editData['product_name']; ?>">
        <input type="number" name="user-amount" placeholder="Enter Amount of Debt" value="<?php echo $editData['tax_total']; ?>">
        <input type="date" name="due-date" placeholder="Select Due Date" value="<?php echo $editData['due_date_tax']; ?>">
        <a href="tax.php" class="button" id="check-amount">Back</a>
        <button type="submit" class="submit" id="check-amount">Update tax</button>
    </form>
</div>
</body>


</html>
