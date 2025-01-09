<?php
session_start();
include 'db.php'; // Database connection file

// Redirect if not logged in or if the user is not a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// CREATE (Insert a new record)
if (isset($_POST['create'])) {
    $client_id = $user_id; // Use logged-in client's ID
    $property_id = $_POST['property_id'];
    
    // SQL query to insert a record into the BUYS table
    $sql = "INSERT INTO BUYS (CLIENT_ID, PROPERTY_ID) VALUES ('$client_id', '$property_id')";
    
    // Error handling for the query
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "Record added successfully.";
    }
}

// READ: Fetch only the purchases of the logged-in client
$result = mysqli_query($conn, "SELECT * FROM BUYS WHERE CLIENT_ID = '$user_id'");

// Error handling for fetching records
if (!$result) {
    echo "Error fetching records: " . mysqli_error($conn);
}

// DELETE (Delete a record)
if (isset($_GET['delete'])) {
    $property_id = $_GET['property_id'];
    
    // SQL query to delete a record from the BUYS table
    if (mysqli_query($conn, "DELETE FROM BUYS WHERE CLIENT_ID='$user_id' AND PROPERTY_ID='$property_id'")) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buys Table</title>
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
        .record-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .record-card:hover {
            transform: scale(1.05);
        }
        .delete-btn {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
        .delete-btn:hover {
            color: #c82333;
        }
        .buy-btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .buy-btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }
        h2, h3 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Buys Table</h2>

    <!-- Simple Form for Creating a New Record -->
    <div class="form-container">
        <form method="POST">
            <div class="mb-3">
                <label for="property_id" class="form-label">Property ID</label>
                <input type="text" class="form-control" id="property_id" name="property_id" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary w-100">Add Record</button>
        </form>
    </div>

    <!-- Display Existing Records -->
    <h3>Your Purchases</h3>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="record-card">
            <p><strong>Client ID:</strong> <?php echo $row['CLIENT_ID']; ?> | <strong>Property ID:</strong> <?php echo $row['PROPERTY_ID']; ?></p>
            <a href="?delete=1&property_id=<?php echo $row['PROPERTY_ID']; ?>" class="delete-btn">Delete</a>
            <a href="transaction.php?client_id=<?php echo $row['CLIENT_ID']; ?>&property_id=<?php echo $row['PROPERTY_ID']; ?>" class="buy-btn">Proceed to Buy</a>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>