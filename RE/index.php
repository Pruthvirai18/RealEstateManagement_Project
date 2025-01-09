<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Management</title>
    
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://img.freepik.com/premium-vector/city-skyscraper-view-cityscape-background-skyline-silhouette-with-copy-space_48369-11705.jpg?semt=ais_hybrid');
          
            background-size: cover;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #343a40;
            padding: 15px 20px;
        }

        .navbar h1 {
            color: #ffc107;
            margin: 0;
            font-size: 2.5em;
            font-weight: 600;
        }

        .nav-button {
            color: #ffc107;
            margin-left: 20px;
            font-size: 1.2em;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-button:hover {
            color: #ffffff;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.8), rgba(108, 117, 125, 0.8));
            color: #fff;
            padding: 50px;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            width: 30%;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .hero h2 {
            font-size: 2.5em;
            font-weight: 700;
        }

        .hero p {
            margin-top: 10px;
            font-size: 1.2em;
        }

        /* Button Styles */
        .btn-primary, .btn-warning {
            font-size: 1.1em;
            padding: 10px 20px;
            border-radius: 5px;
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

        /* Footer */
        /* Footer */
footer {
    background-color: #343a40;
    color: #ffffff;
    padding: 20px;
    text-align: center;
    position: absolute;
    bottom: 0;
    width: 100%;
    height: auto; /* Optional, adjusts the height as needed */
}

    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="navbar d-flex justify-content-between align-items-center">
            <h1>Real Estate Management</h1>
            <nav>
                <!-- Links to login pages -->
                <a href="client/login.php" class="nav-button">Clients</a>
                <a href="owner/login.php" class="nav-button">Owners</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>Your Trusted Real Estate Partner</h2>
        <p>Connecting buyers, sellers, and renters with ease.</p>
    </section>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Footer Section -->
    <footer>
        <p>Real Estate Management © 2024. All Rights Reserved.</p>
    </footer>
</body>
</html>
