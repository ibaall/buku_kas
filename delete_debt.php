<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['usernamae'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["username"])) {
    $debtId = $_GET["id"];

    $deleteSql = "DELETE FROM debt WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("ss", $debtId, $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Debt Deleted Successfully');</script>";
        header("Location: debt.php");
    } else {
        echo "Error deleting debt: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
