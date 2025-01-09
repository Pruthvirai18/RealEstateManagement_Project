<?php
session_start();
include 'db.php'; // Ensure the path is correct

// Redirect to login if session is not set
if (!isset($_SESSION['owner_id'])) {
    header("Location: login.php");
    exit();
}

$owner_id = $_SESSION['owner_id']; // Use the logged-in owner's ID

// Handle Create and Update Property
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $property_type = $_POST['property_type'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $size = $_POST['size'];

        $sql = "INSERT INTO PROPERTY (PROPERTY_TYPE, LOCATION, PRICE, SIZE, OWNER_ID)
                VALUES ('$property_type', '$location', '$price', '$size', $owner_id)";
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $property_id = $_POST['property_id'];
        $property_type = $_POST['property_type'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $size = $_POST['size'];

        $sql = "UPDATE PROPERTY SET PROPERTY_TYPE='$property_type', LOCATION='$location',
                PRICE='$price', SIZE='$size' WHERE PROPERTY_ID=$property_id";
        if (!$conn->query($sql)) {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle Delete Property
if (isset($_GET['delete'])) {
    $property_id = $_GET['delete'];
    $sql = "DELETE FROM PROPERTY WHERE PROPERTY_ID=$property_id";
    if (!$conn->query($sql)) {
        echo "Error: " . $conn->error;
    }
}

// Fetch Properties belonging to the logged-in owner
$sql = "SELECT * FROM PROPERTY WHERE OWNER_ID = $owner_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            color: #343a40;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn-danger {
            margin-left: 5px;
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Property Management</h1>
                <!-- Add New Property -->
                <form method="POST" action="property.php" class="mt-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="property_type" class="form-label">Property Type</label>
                            <input type="text" class="form-control" id="property_type" name="property_type" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">Size</label>
                            <input type="number" step="0.01" class="form-control" id="size" name="size" required>
                        </div>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary w-100">Add Property</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">Properties List</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['PROPERTY_ID'] ?></td>
                            <td><?= $row['PROPERTY_TYPE'] ?></td>
                            <td><?= $row['LOCATION'] ?></td>
                            <td><?= $row['PRICE'] ?></td>
                            <td><?= $row['SIZE'] ?></td>
                            <td>
                                <a href="property.php?delete=<?= $row['PROPERTY_ID'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
