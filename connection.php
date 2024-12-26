<?php
function getConnection() {
    $dbhost = "localhost";   // Ubah jika diperlukan
    $dbuser = "root";        // Username database Anda
    $dbpass = "";            // Password database Anda
    $dbname = "db_user";     // Nama database Anda

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $connection;
}
?>
