<?php
include 'db.php';

if (isset($_GET['requirement_id'])) {
    $requirement_id = $_GET['requirement_id'];

    // Fetch requirement details
    $requirement_query = "SELECT * FROM REQUIREMENT WHERE REQUIREMENT_ID = '$requirement_id'";
    $requirement_result = mysqli_query($conn, $requirement_query);
    $requirement = mysqli_fetch_assoc($requirement_result);

    if ($requirement) {
        $loc = $requirement['LOC'];
        $prop_type = $requirement['PROP_TYPE'];
        $cost = $requirement['COST'];
        $area = $requirement['AREA'];

        // Modify the query to match properties with at least one condition
        $property_query = "SELECT * FROM PROPERTY WHERE 
                           (LOCATION = '$loc' OR PROPERTY_TYPE = '$prop_type' OR 
                            PRICE = '$cost' OR SIZE = '$area') 
                           AND STATUS = 'Available'";

        // Debugging the SQL query (Remove this for production)
        // echo "SQL Query: $property_query<br>";

        $property_result = mysqli_query($conn, $property_query);

        // Array to hold matched properties
        $matched_properties = [];

        while ($property = mysqli_fetch_assoc($property_result)) {
            // Debugging each matched property (Remove this for production)
            // echo "Checking Property: " . $property['PROPERTY_ID'] . "<br>";

            // Insert match into the MATCHES table
            $property_id = $property['PROPERTY_ID'];
            $match_query = "INSERT IGNORE INTO MATCHES (REQUIREMENT_ID, PROPERTY_ID) 
                            VALUES ('$requirement_id', '$property_id')";
            mysqli_query($conn, $match_query);

            // Add matched property to the array
            $matched_properties[] = $property;
        }

        // Debugging matched properties (Remove this for production)
        // echo "<pre>";
        // print_r($matched_properties);
        // echo "</pre>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matched Properties</title>
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
        .property-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease-in-out;
        }
        .property-card:hover {
            transform: scale(1.05);
        }
        .buy-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .buy-btn:hover {
            background-color: #218838;
            transform: translateY(-3px);
        }
        .property-card h5 {
            font-size: 1.25rem;
            font-weight: 500;
        }
        .property-card p {
            font-size: 1rem;
            color: #555;
        }
        .no-matches {
            font-size: 1.2rem;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Matched Properties</h1>

    <?php if (!empty($matched_properties)) { ?>
        <div class="row">
            <?php foreach ($matched_properties as $property) { ?>
                <div class="col-md-4">
                    <div class="property-card">
                        <h5>Property ID: <?= $property['PROPERTY_ID'] ?></h5>
                        <p><strong>Type:</strong> <?= $property['PROPERTY_TYPE'] ?></p>
                        <p><strong>Location:</strong> <?= $property['LOCATION'] ?></p>
                        <p><strong>Price:</strong> ₹<?= number_format($property['PRICE'], 2) ?></p>
                        <p><strong>Size:</strong> <?= $property['SIZE'] ?> sq. ft.</p>
                        <p><strong>Status:</strong> <?= $property['STATUS'] ?></p>
                        <a href="buys.php?property_id=<?= $property['PROPERTY_ID'] ?>" class="buy-btn">Buy Now</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="no-matches">No properties match your requirements at the moment.</p>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
