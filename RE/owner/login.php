<?php
session_start();
include '../db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    // Sanitize and trim input data to remove any leading/trailing spaces
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query to authenticate the owner by email
    $query = "SELECT * FROM OWNER WHERE EMAIL = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Query preparation failed: ' . $conn->error); // Error handling
    }

    // Bind parameters to the SQL query
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the owner details from the database
    $owner = $result->fetch_assoc();

    if ($owner) {
        // Verify if the entered password matches the hashed password stored in the database
        if (password_verify($password, $owner['PASSWORD'])) {
            // Set session variables
            $_SESSION['owner_id'] = $owner['OWNER_ID'];
            $_SESSION['user_type'] = 'owner';
            $_SESSION['name'] = $owner['NAME'];

            // Redirect to the owner's dashboard
            header("Location: owner.php");
            exit();
        } else {
            $error_message = "Invalid email or password!";
        }
    } else {
        $error_message = "Invalid email or password!";
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #34495e;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }
        .btn-primary {
            width: 100%;
            border-radius: 5px;
            background-color: #3b58a1;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #2f477d;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        p a {
            color: #3b58a1;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Owner Login</h1>

        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php } ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>

        <p class="text-center mt-3">Don't have an account? <a href="signup.php">Signup here</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
