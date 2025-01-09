<?php
session_start();
include '../db.php';

// Redirect if not logged in or if the user is not an owner
if (!isset($_SESSION['owner_id']) || $_SESSION['user_type'] !== 'owner') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['owner_id']; // Get logged-in owner's ID

// Handle Update Owner
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $owner_id = $_POST['owner_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    // Update owner details in the database
    $sql = "UPDATE OWNER SET NAME='$name', CONTACT='$contact', ADDRESS='$address' WHERE OWNER_ID=$owner_id AND OWNER_ID=$user_id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Your details have been updated successfully!";
    } else {
        $error_message = "Error updating details: " . $conn->error;
    }
}

// Fetch the logged-in owner's details
$sql = "SELECT OWNER_ID, NAME, CONTACT, ADDRESS, EMAIL FROM OWNER WHERE OWNER_ID = $user_id";
$result = $conn->query($sql);
$owner = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
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
        <h1>Welcome, <?= htmlspecialchars($owner['NAME']) ?></h1>

        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php } ?>

        <!-- Display Owner Details -->
        <h3>Your Details:</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Owner ID:</strong> <?= htmlspecialchars($owner['OWNER_ID']) ?></li>
            <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($owner['NAME']) ?></li>
            <li class="list-group-item"><strong>Contact:</strong> <?= htmlspecialchars($owner['CONTACT']) ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($owner['ADDRESS']) ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($owner['EMAIL']) ?></li>
        </ul>

        <!-- Update Owner Form -->
        <h3>Update Your Details</h3>
        <form method="POST" action="owner.php">
            <input type="hidden" name="owner_id" value="<?= htmlspecialchars($owner['OWNER_ID']) ?>">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($owner['NAME']) ?>" required>
            </div>
            <div class="form-group">
                <label>Contact:</label>
                <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($owner['CONTACT']) ?>" required>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($owner['ADDRESS']) ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Details</button>
        </form>

        <!-- Additional Links -->
        <hr><hr>
        <a href="../property.php" class="btn btn-warning">Manage Properties</a>
        <a href="../viewstatus.php" class="btn btn-primary">View Property Status</a>
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
