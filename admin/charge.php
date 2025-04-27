<?php
session_start();
require '../vendor/autoload.php'; // Ensure Razorpay SDK is installed

use Razorpay\Api\Api;

// Razorpay API credentials
$razorpayKey = "Your_Key";  // Replace with your actual Test Key
$razorpaySecret = "Your_Pay_Secret";  // Replace with your actual Secret Key

// Check if Payment ID is received
if (empty($_POST['payment_id'])) {
    die("Payment ID not received!");
}

$payment_id = $_POST['payment_id']; 

// Initialize Razorpay API
$api = new Api($razorpayKey, $razorpaySecret);

try {
    // Fetch payment details from Razorpay
    $payment = $api->payment->fetch($payment_id);

    if ($payment->status == "authorized" || $payment->status == "captured") {
        // ✅ Store successful payment session
        $_SESSION['payment_success'] = true;

        // ✅ Redirect to Thank You Page (NO DATABASE OPERATION)
        header("Location: ../thank_you.php");
        exit();
    } else {
        echo "<h2>Payment Failed!</h2>";
        echo "<p>Status: " . $payment->status . "</p>";
    }
} catch (Exception $e) {
    echo "<h2>Payment Error!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
