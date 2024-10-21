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

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $weight = (float)$_POST['weight'];
    $height = (float)$_POST['height'];
    $level = $_POST['level'];

    // Prepare the SQL statement to update the user data
    $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ?, weight = ?, height = ?, level = ? WHERE id = ?");
    $updateStmt->bind_param("ssdssi", $name, $email, $weight, $height, $level, $userId);

    if ($updateStmt->execute()) {
        $success_message = "Profile updated successfully!";
        
        // Redirect based on user level
        if ($level === 'beginner') {
            header('Location: bignner.php'); // Redirect to beginner page
        } else {
            header('Location: advance.php'); // Redirect to advanced page
        }
        exit; // Ensure no further code is executed
    } else {
        $error_message = "Error updating profile: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .message {
            margin-bottom: 20px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <?php
    if (isset($success_message)) {
        echo "<div class='message'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>
    <form action="edit_profile.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="weight">Weight (kg):</label>
        <input type="number" step="0.1" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" required>

        <label for="height">Height (m):</label>
        <input type="number" step="0.01" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>

        <label for="level">Level:</label>
        <select id="level" name="level" required>
            <option value="beginner" <?php echo ($user['level'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
            <option value="advanced" <?php echo ($user['level'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
        </select>

        <input type="submit" value="Update Profile">
    </form>
</div>

</body>
</html>
