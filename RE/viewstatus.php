<?php
session_start();
include 'db.php';

if (!isset($_SESSION['owner_id']) || $_SESSION['user_type'] !== 'owner') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['owner_id'];

$sql = "SELECT PROPERTY_ID, PROPERTY_TYPE, LOCATION, PRICE, SIZE, STATUS 
        FROM PROPERTY WHERE OWNER_ID = $user_id";
$result = $conn->query($sql);

// Debugging
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            animation: fadeIn 1s ease-in-out;
            border-radius: 10px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        h1.page-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff; /* Blue heading color */
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: #007bff; /* Blue background for table headers */
            color: blue; /* White text for table headers */
            text-align: center;
        }
        td {
            text-align: center;
            color: #333; /* Dark text color for better visibility */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow p-4">
                <!-- Heading -->
                <h1 class="page-title">Property Status</h1>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0) { ?>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['PROPERTY_ID']) ?></td>
                                    <td><?= htmlspecialchars($row['PROPERTY_TYPE']) ?></td>
                                    <td><?= htmlspecialchars($row['LOCATION']) ?></td>
                                    <td><?= htmlspecialchars($row['PRICE']) ?></td>
                                    <td><?= htmlspecialchars($row['SIZE']) ?></td>
                                    <td><?= htmlspecialchars($row['STATUS']) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No properties found!</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
