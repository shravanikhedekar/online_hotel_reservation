<?php
$conn = new mysqli("localhost", "root", "", "db_hor");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
