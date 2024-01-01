<?php
// Start the session
session_start();

// Check if the user is already signed up, then redirect
if (isset($_SESSION['signed_up'])) {
    header("Location: welcome.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('image.png') no-repeat center center fixed; /* Updated with the generated image */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-container {
            background: rgba(255, 255, 255, 0.8); /* Slight transparency */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #22a7f0;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #199fdb;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Welcome</h2>
        <form action="submit.php" method="post">
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>

