<?php
session_start();

// Set the booking amount (Replace this with dynamic value)
$amount = 5000; // Amount in paise (₹50.00 = 5000 paise)

// Store reservation details in session
$_SESSION['reservation_id'] = 101; // Replace with actual reservation ID
$_SESSION['amount'] = $amount;

// Your Razorpay API Key
$razorpayKey = "Your_Key"; // Replace with your actual test key
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Hotel Reservation</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Complete Your Payment</h2>
    <p>Total Amount: ₹<?php echo number_format($amount / 100, 2); ?></p>

    <!-- Razorpay Payment Button -->
    <button id="rzp-button1">Pay with Razorpay</button>

    <!-- Cash Payment Button -->
    <form action="cash_payment.php" method="POST" style="margin-top: 20px;">
        <input type="hidden" name="payment_type" value="cash">
        <button type="submit">Pay with Cash</button>
    </form>

    <script>
    var options = {
        "key": "<?php echo $razorpayKey; ?>", // Razorpay API Key
        "amount": "<?php echo $amount; ?>", 
        "currency": "INR",
        "name": "Hotel Reservation",
        "description": "Secure Payment for Your Booking",
        "handler": function (response) {
            console.log("Payment Response:", response); // Debugging: See response in console

            // Send payment_id via POST to charge.php
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "charge.php"; // Ensure this file exists and is correct

            var paymentInput = document.createElement("input");
            paymentInput.type = "hidden";
            paymentInput.name = "payment_id";
            paymentInput.value = response.razorpay_payment_id;
            form.appendChild(paymentInput);

            document.body.appendChild(form);
            form.submit();
        },
        "prefill": {
            "name": "Customer Name",
            "email": "customer@example.com"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };
    </script>
</body>
</html>
