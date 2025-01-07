<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if (isset($_GET['delete'])) {
    $deleteTaxId = $_GET['delete'];
    $deleteSql = "DELETE FROM tax WHERE tax_id = $deleteTaxId";

    if ($conn->query($deleteSql) === TRUE) {
        header("Location: tax.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
