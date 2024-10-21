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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // If password matches, start a session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['level'] = $user['level']; // Store user level in session

            // Redirect based on the user's level
            if ($user['level'] === 'Beginner') {
                header('Location: bignner.php');
            } elseif ($user['level'] === 'Advanced') {
                header('Location: advance.php');
            }
            exit; // Make sure to exit after redirecting
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('gym-background.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        /* Light overlay effect */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Adds a slight dark overlay */
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
       
        .login-box {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent box */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }
         
        label {
            display: block;
            text-align: left;
            color: #555;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background: #218838;
        }
        
        .text {
            text-decoration: none;
            color: blue;
            font-family: Georgia;
        }

        .text:hover {
            text-decoration: underline;
            color: purple;
        }
        
        /* Mobile responsive design */
        @media (max-width: 600px) {
            .login-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <a href="register.php" class="text">Don't have an account? Register here</a><br><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
