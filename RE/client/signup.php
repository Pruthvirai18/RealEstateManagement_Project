<?php
include '../db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Ensure all fields are not empty
    if (empty($name) || empty($contact) || empty($address) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    } else {
        // Call the stored procedure to handle signup
        $query = "CALL SignupClient(?, ?, ?, ?, ?, @p_error_message)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $name, $contact, $address, $email, $password);
        $stmt->execute();
        $stmt->close();

        // Retrieve the result of the stored procedure
        $result_query = "SELECT @p_error_message AS error_message";
        $result = $conn->query($result_query);
        $row = $result->fetch_assoc();

        $error_message = $row['error_message'];

        if ($error_message == 'Signup successful! You can now login.') {
            $success_message = "Signup successful! You can now login.";
            $error_message = ''; // Reset the error message since signup was successful
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 450px;
            margin-top: 100px;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            box-shadow: none;
        }
        .btn-signup {
            width: 100%;
            padding: 12px;
            font-weight: bold;
            border-radius: 10px;
        }
        .error-message, .success-message {
            font-size: 1.1rem;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .error-message {
            color: #dc3545;
        }

        .success-message {
            color: #28a745;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">Signup</h2>

        <?php if (isset($error_message) && !empty($error_message)) { ?>
            <div class="error-message">
                <?= $error_message ?>
            </div>
        <?php } ?>
        <?php if (isset($success_message)) { ?>
            <div class="success-message">
                <?= $success_message ?>
            </div>
        <?php } ?>

        <form method="POST" action="signup.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" name="contact" id="contact" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary btn-signup">Signup</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
