<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - GPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 100px;
            max-width: 500px;
        }
        .payment-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .payment-card h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-pay {
            background-color: #34b7f1;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-pay:hover {
            background-color: #007bff;
            transform: scale(1.05);
        }
        .payment-logo {
            width: 120px; /* Increased size */
            height: 120px; /* Increased size */
            background: #f1f1f1;
            border-radius: 50%;
            margin: 20px auto;
        }
        .success-message {
            font-size: 20px;
            color: #28a745;
            font-weight: 600;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="payment-card">
        <div class="payment-logo d-flex align-items-center justify-content-center">
            <img src="https://media.licdn.com/dms/image/D4D12AQFuzxAphyok_Q/article-cover_image-shrink_720_1280/0/1671599753429?e=2147483647&v=beta&t=JbpDuOjYFvvC4p7-vzcI-y4ApAG5YZwue9uEaD9mkTc" alt="Payment Logo" class="img-fluid">
        </div>
        <h2>Payment Successful</h2>
        <button class="btn-pay" id="payButton">Pay</button>
        <p class="success-message" id="successMessage">Payment was successfully completed!</p>
    </div>
</div>

<script>
    // Assume property_id is passed to this page, you can pass it via query string or set it in PHP
    var property_id = new URLSearchParams(window.location.search).get('property_id'); // Get the property_id from the URL

    document.getElementById('payButton').addEventListener('click', function() {
        // Simulate a successful payment
        document.getElementById('successMessage').style.display = 'block';

        // Redirect to client.php with the property_id after 2 seconds
        setTimeout(function() {
            if (property_id) {
                window.location.href = "client.php?property_id=" + property_id; // Redirect with property_id
            } else {
                alert("Payment Done!");
            }
        }, 2000);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>