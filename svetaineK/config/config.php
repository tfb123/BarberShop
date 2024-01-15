<?php
define('DB_HOST', 'db');
define('DB_NAME', 'mydb');
define('DB_USER', 'user');
define('DB_PASS', 'password');

function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>