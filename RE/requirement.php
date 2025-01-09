<?php
session_start();
include 'db.php';

// Redirect if not logged in or if the user is not a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// CREATE
if (isset($_POST['create'])) {
    $loc = $_POST['loc'];
    $prop_type = $_POST['prop_type'];
    $cost = $_POST['cost'];
    $area = $_POST['area'];
    $client_id = $user_id; // Use logged-in client's ID

    $sql = "INSERT INTO REQUIREMENT (LOC, PROP_TYPE, COST, AREA, CLIENT_ID) 
            VALUES ('$loc', '$prop_type', '$cost', '$area', '$client_id')";
    mysqli_query($conn, $sql);
}

// READ: Fetch only the requirements of the logged-in client
$result = mysqli_query($conn, "SELECT * FROM REQUIREMENT WHERE CLIENT_ID = '$user_id'");

// DELETE
if (isset($_GET['delete'])) {
    $requirement_id = $_GET['requirement_id'];
    mysqli_query($conn, "DELETE FROM REQUIREMENT WHERE REQUIREMENT_ID='$requirement_id' AND CLIENT_ID='$user_id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirement Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS for animations -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h2, h3 {
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.5s ease-in-out;
        }
        .record-container {
            margin-top: 20px;
            animation: slideIn 1s ease-in-out;
        }
        .btn-delete {
            color: #ff0000;
            font-weight: bold;
        }
        .btn-delete:hover {
            color: #c70000;
        }
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Form for creating a new requirement -->
    <div class="form-container">
        <h2>Add New Requirement</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="loc" class="form-label">Location</label>
                <input type="text" class="form-control" name="loc" required>
            </div>
            <div class="mb-3">
                <label for="prop_type" class="form-label">Property Type</label>
                <input type="text" class="form-control" name="prop_type" required>
            </div>
            <div class="mb-3">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" class="form-control" name="cost" required>
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Area (sq. ft.)</label>
                <input type="number" class="form-control" step="0.01" name="area" required>
            </div>
            <button type="submit" class="btn btn-primary" name="create">Add Requirement</button>
        </form>
    </div>

    <!-- Display existing requirements in a table -->
    <h3 class="mt-5">Your Requirements</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">Requirement ID</th>
                    <th scope="col">Location</th>
                    <th scope="col">Property Type</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Area (sq. ft.)</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['REQUIREMENT_ID']; ?></td>
                        <td><?php echo $row['LOC']; ?></td>
                        <td><?php echo $row['PROP_TYPE']; ?></td>
                        <td><?php echo $row['COST']; ?></td>
                        <td><?php echo $row['AREA']; ?></td>
                        <td>
                            <a href="matches.php?requirement_id=<?php echo $row['REQUIREMENT_ID']; ?>" class="btn btn-info btn-sm">View Matches</a> |
                            <a href="?delete=1&requirement_id=<?php echo $row['REQUIREMENT_ID']; ?>" class="btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS, Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
