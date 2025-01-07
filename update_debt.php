<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $debtId = $_POST["debt-id"];
    $title = $_POST["product-title"];
    $amount = $_POST["user-amount"];
    $debtDate = $_POST["debt-date"];
    $dueDate = $_POST["due-date"];
    $debtorName = $_POST["debtor-name"];

    $sql = "UPDATE debt SET title='$title', amount=$amount, debt_date='$debtDate', due_date='$dueDate', debtor_name='$debtorName' WHERE id=$debtId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Debt Updated Successfully');</script>";
        echo '<script>window.location.href = "debt.php";</script>';
    } else {
        echo "Error updating debt: " . $conn->error;
    }
}

$conn->close();
?>
