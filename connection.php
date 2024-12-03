<?php
function getConnection(): mysqli
{
    $host = "localhost";
    $port = 3306;
    $database = "db_user";
    $username = "root";
    $password = "";

    return new mysqli($host, $username, $password, $database, $port);
}