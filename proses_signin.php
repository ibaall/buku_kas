<?php
session_start();

// Include the database connection file
require_once "connection.php";

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION["UserID"] = $user["UserID"];
        $_SESSION["username"] = $user["username"];
        header("Location: dashboard.php"); 
        exit();
    } else {
        $_SESSION["login_error"] = "Invalid username or password";
        header("Location: index.php"); 
        exit();
    }
} else {
    exit();
}
?>
