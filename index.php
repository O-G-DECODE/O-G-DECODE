<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Training</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to External CSS -->
</head>
<body>
    <!-- Navigation Menu -->
    <nav>
        <ul class="nav-left">
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
        </ul>
        <ul class="nav-right">
            <li><span>Contact: 7736975433</span></li>
            <li><span>Email: arjunps@gmail.com</span></li>
            <li><a href="login.php" class="btn-login-nav">Login</a></li>
        </ul>
    </nav>

    <!-- Home Section with Video Background and Centered Logo + Text -->
    <section id="home" class="home-section">
        <!-- Video Background -->
        <video autoplay muted loop id="background-video">
            <source src="fitnesss.mp4" type="video/mp4"> <!-- Add your video file here -->
            Your browser does not support the video tag.
        </video>

        <!-- Centered Logo and Text -->
        <div class="centered">
            <img src="logo.png" alt="Fitness Logo" class="center-logo"> <!-- Add your logo image here -->
            <h1 class="content">Fitness Training</h1>
            <br><br><br> 
            <a href="login.php" class="btn-register">LOGIN</a>
        </div>
    </section>
</body>
</html>
