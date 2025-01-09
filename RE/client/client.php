<?php
session_start();
include '../db.php';

// Redirect if not logged in or if the user is not a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Handle Update Client
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $client_id = $_POST['client_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Update client details in the database
    $sql = "UPDATE CLIENT SET NAME='$name', CONTACT='$contact', ADDRESS='$address' WHERE CLIENT_ID=$client_id AND CLIENT_ID=$user_id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Your details have been updated successfully!";
    } else {
        $error_message = "Error updating details: " . $conn->error;
    }
}

// Fetch the logged-in user's details
$sql = "SELECT CLIENT_ID, NAME, CONTACT, ADDRESS, EMAIL FROM CLIENT WHERE CLIENT_ID = $user_id";
$result = $conn->query($sql);
$client = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../assets/bg-real-estate.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            font-size: 1em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-3px);
        }

        h1, h2, h3 {
            color: #007bff;
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($client['NAME']) ?></h1>

        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php } ?>

        <!-- Display Client Details -->
        <h3>Your Details:</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Client ID:</strong> <?= htmlspecialchars($client['CLIENT_ID']) ?></li>
            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($client['NAME']) ?></li>
            <li class="list-group-item"><strong>Contact:</strong> <?= htmlspecialchars($client['CONTACT']) ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($client['ADDRESS']) ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($client['EMAIL']) ?></li>
        </ul>

        <!-- Update Client Form -->
        <h3>Update Your Details</h3>
        <form method="POST" action="client.php">
            <input type="hidden" name="client_id" value="<?= htmlspecialchars($client['CLIENT_ID']) ?>">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($client['NAME']) ?>" required>
            </div>
            <div class="form-group">
                <label>Contact:</label>
                <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($client['CONTACT']) ?>" required>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($client['ADDRESS']) ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Details</button>
        </form>

        <!-- Add Requirement Section -->
        <hr><hr>
        <a href="../requirement.php" class="btn btn-warning">Go to Requirements</a>
        <a href="../viewproperty.php" class="btn btn-primary">View All Properties</a>
    </div>

    <footer>
        <p>Real Estate Management &copy; 2024. All Rights Reserved.</p>
    </footer>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
