<?php
// Start the session
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "C1sc0123@";
$dbname = "speedtest"; // Using the provided database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape user inputs for security
$name = $conn->real_escape_string($_POST['name']);
$ipAddress = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (signedup, ip_address) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $ipAddress);

// Execute and check
if ($stmt->execute()) {
    // Set session variable to indicate the user has signed up
    $_SESSION['signed_up'] = true;

    // Redirect to welcome.php
    header("Location: welcome.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

