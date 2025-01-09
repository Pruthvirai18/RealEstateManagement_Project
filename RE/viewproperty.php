<?php
include 'db.php';

// Fetch Properties
$result = $conn->query("SELECT * FROM PROPERTY");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Properties</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f5f7;
        }
        .container {
            margin-top: 50px;
            animation: fadeInUp 1s ease-in-out;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: #343a40;
        }
        table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: 500;
        }
        td {
            font-size: 0.9rem;
            color: #495057;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .btn-buy {
            background-color: #28a745;
            color: white;
            font-weight: 500;
        }
        .btn-buy:hover {
            background-color: #218838;
            color: white;
        }
        .badge-sold {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center"><i class="fas fa-building"></i> Properties List</h1>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Owner ID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['PROPERTY_ID'] ?></td>
                                <td><?= $row['PROPERTY_TYPE'] ?></td>
                                <td><?= $row['LOCATION'] ?></td>
                                <td>₹<?= number_format($row['PRICE'], 2) ?></td>
                                <td><?= $row['SIZE'] ?> sqft</td>
                                <td><?= $row['OWNER_ID'] ?></td>
                                <td><?= $row['STATUS'] ?></td>
                                <td>
                                    <?php if ($row['STATUS'] === 'Available') { ?>
                                        <a href="buys.php?property_id=<?= $row['PROPERTY_ID'] ?>" class="btn btn-buy btn-sm">Buy</a>
                                    <?php } else { ?>
                                        <span class="badge badge-sold">Sold</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer>
            &copy; <?= date("Y") ?> Property Management System. All Rights Reserved.
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
