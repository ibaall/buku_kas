<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    if ($password1 != $password2) {
        session_start();
        $_SESSION["signup_error"] = "Passwords do not match";
        header("Location: index.php"); 
        exit();
    }

    $query = "INSERT INTO user (username, password) VALUES ('$username', '$password1')";
    $result = $conn->query($query);

    if ($result) {
        header("Location: index.php"); 
        exit();
    } else {
        
        session_start();
        $_SESSION["signup_error"] = "Error during sign-up";
        header("Location: index.php"); 
        exit();
    }
} else {
  
    header("Location: index.php"); 
    exit();
}
?>
