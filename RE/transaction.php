<?php
session_start();
include 'db.php';

// Redirect if not logged in or if the user is not a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Check if property_id is passed in the URL
if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];
} else {
    echo "Error: Property ID is missing.";
    exit();
}

// Fetch property details and amount for the property the client is purchasing
$sql = "SELECT PRICE FROM PROPERTY WHERE PROPERTY_ID = '$property_id'";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);

// If the property doesn't exist, redirect to an error page or display a message
if (!$property) {
    echo "Error: Property not found.";
    exit();
}

$property_amount = $property['PRICE'];
$transaction_date = date('Y-m-d'); // Set the transaction date to today's date

// CREATE (Insert a new record)
if (isset($_POST['payment'])) {
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $property_id = $_POST['property_id'];
    $client_id = $_POST['client_id'];

    // Check if the client_id exists in the CLIENT table
    $client_check_sql = "SELECT * FROM CLIENT WHERE CLIENT_ID = '$client_id'";
    $client_check_result = mysqli_query($conn, $client_check_sql);

    if (mysqli_num_rows($client_check_result) > 0) {
        // Client exists, proceed with transaction insertion
        $sql = "INSERT INTO TRANSACTION (TRANSACTION_DATE, TRANSACTION_AMOUNT, PROPERTY_ID, CLIENT_ID) 
                VALUES ('$date', '$amount', '$property_id', '$client_id')";
        if (mysqli_query($conn, $sql)) {
            // Redirect to payment.php after successful transaction
            header('Location: payment.php');
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Client doesn't exist, show an error message
        echo "Error: Client ID does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .form-container h3 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-container .form-label {
            color: #495057;
        }
        .form-container input {
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
        }
        .form-container button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            width: 100%;
            transition: background-color 0.3s, transform 0.3s;
        }
        .form-container button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Transaction Table</h2>

    <!-- Simple Form for Creating a New Transaction -->
    <div class="form-container">
        <h3>Create a New Transaction</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Transaction Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $transaction_date; ?>" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $property_amount; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="property_id" class="form-label">Property ID</label>
                <input type="text" class="form-control" id="property_id" name="property_id" value="<?php echo $property_id; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="client_id" class="form-label">Client ID</label>
                <input type="text" class="form-control" id="client_id" name="client_id" value="<?php echo $user_id; ?>" readonly>
            </div>
            <button type="submit" name="payment" class="btn btn-primary w-100">Payment</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>