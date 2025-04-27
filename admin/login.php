<?php
session_start();
require_once 'connect.php'; // Ensure database connection is included

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $fetch = $result->fetch_assoc();

    if ($fetch) {
        // If passwords are stored as plaintext, compare directly (Not recommended)
        if ($password === $fetch['password']) { 
            $_SESSION['admin_id'] = $fetch['admin_id'];
            header('location: home.php');
            exit();
        } else {
            echo "<center><label style='color:red;'>Invalid username or password</label></center>";
        }
    } else {
        echo "<center><label style='color:red;'>Invalid username or password</label></center>";
    }

    $stmt->close();
}
?>
