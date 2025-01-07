<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete'])) {
    $deleteID = mysqli_real_escape_string($conn, $_GET['delete']);
    $deleteQuery = "DELETE FROM budgets WHERE BudgetID = '$deleteID'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Data deleted successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

header("Location: CashIn.php");
exit();
?>
