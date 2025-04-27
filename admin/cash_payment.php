<?php
session_start();

// Check if Cash Payment option is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payment_type"]) && $_POST["payment_type"] == "cash") {
    $_SESSION['payment_success'] = true;

    // Redirect to the Thank You Page
    header("Location: thank_you.php");
    exit();
} else {
    echo "<h2>Invalid Payment Method!</h2>";
}
?>
