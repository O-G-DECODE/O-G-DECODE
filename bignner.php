<?php
// Start a session
session_start();

// Database connection details
$host = 'localhost';
$dbname = 'registration_db';
$username = 'root';
$password = '';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch user data
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, weight, height, level FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beginner Fitness Training</title>
    <link rel="stylesheet" href="bign.css"> <!-- Link to external CSS -->
    <style>
        .profile-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        .profile-logo {
            cursor: pointer;
            width: 50px; /* Adjust size */
            height: 50px; /* Adjust size */
        }

        .profile-details {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
    </style>
</head>
<body>

    <!-- Heading -->
    <h1 class="heading">Beginner Fitness Training</h1>

    <!-- Profile Section -->
    <div class="profile-container">
        <img src="profile-logo.png" alt="Profile Logo" class="profile-logo" id="profileLogo">
        <div class="profile-details" id="profileDetails">
            <h2>User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Weight:</strong> <?php echo htmlspecialchars($user['weight']); ?> kg</p>
            <p><strong>Height:</strong> <?php echo htmlspecialchars($user['height']); ?> m</p>
            <p><strong>Level:</strong> <?php echo htmlspecialchars($user['level']); ?></p>
            <a href="edit.php" class="edit-profile">Edit Profile</a>
        </div>
    </div>

    <!-- Days Section -->
    <div class="day-container">
        <div class="day-box">
            <a href="#day1" class="day-link">Day 1</a>
        </div>
        <div class="day-box">
            <a href="#day2" class="day-link">Day 2</a>
        </div>
        <div class="day-box">
            <a href="#day3" class="day-link">Day 3</a>
        </div>
        <div class="day-box">
            <a href="#day4" class="day-link">Day 4</a>
        </div>
        <div class="day-box">
            <a href="#day5" class="day-link">Day 5</a>
        </div>
        <div class="day-box">
            <a href="#day6" class="day-link">Day 6</a>
        </div>
        <div class="day-box">
            <a href="#day7" class="day-link">Day 7</a>
        </div>
    </div>
    
    <!-- Diet Plans Section -->
    <div class="diet-box-container">
        <div class="diet-box">
            <a href="#diet1" class="day-link">Diet Plan 1</a>
        </div>
        <div class="diet-box">
            <a href="#diet2" class="day-link">Diet Plan 2</a>
        </div>
        <div class="diet-box">
            <a href="#diet3" class="day-link">Diet Plan 3</a>
        </div>
        <div class="diet-box">
            <a href="#diet4" class="day-link">Diet Plan 4</a>
        </div>
        <div class="diet-box">
            <a href="#diet5" class="day-link">Diet Plan 5</a>
        </div>
        <div class="diet-box">
            <a href="#diet6" class="day-link">Diet Plan 6</a>
        </div>
        <div class="diet-box">
            <a href="#diet7" class="day-link">Diet Plan 7</a>
        </div>
    </div>

    <script>
        document.getElementById('profileLogo').onclick = function() {
            var details = document.getElementById('profileDetails');
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        };
    </script>
</body>
</html>
