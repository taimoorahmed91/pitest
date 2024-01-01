<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deviceId']) && isset($_POST['status']) && isset($_POST['gpio'])) {
    $deviceId = $_POST['deviceId'];
    $status = $_POST['status'] == 'true' ? 'on' : 'off'; // Assuming 'true' for 'on' and anything else for 'off'
    $gpio = $_POST['gpio'];

    // Database connection details
    $host = 'localhost';
    $username = 'root';
    $password = 'C1sc0123@';
    $database = 'automation';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update only the device status in the database
    $stmt = $conn->prepare("UPDATE devices SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $deviceId);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Run Python script
    $pythonScriptPath = './demo.py'; // Relative path to the Python script
    $command = escapeshellcmd("python3 " . $pythonScriptPath . " " . escapeshellarg($deviceId) . " " . escapeshellarg($status) . " " . escapeshellarg($gpio));
    exec($command, $output, $return_var);

    echo "Device status updated and Python script executed.";
} else {
    echo "Invalid request";
}



?>

