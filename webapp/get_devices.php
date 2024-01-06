<?php
// Database connection settings
$host = 'localhost';
$user = 'root';
$pass = 'C1sc0123@';
$dbname = 'automation';

// Connect to the database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start building the SQL query
$sql = "SELECT * FROM devices WHERE 1=1";

// Add device filter if set
if (isset($_GET['device'])) {
    $deviceName = $conn->real_escape_string($_GET['device']);
    $sql .= " AND device = '$deviceName'";
}

// Add gpio filter if set
if (isset($_GET['gpio'])) {
    $gpio = $conn->real_escape_string($_GET['gpio']);
    $sql .= " AND gpio = '$gpio'";
}

// Add status filter if set
if (isset($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $sql .= " AND status = '$status'";
}

$result = $conn->query($sql);
$devices = [];

// Fetch all devices
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $devices[] = $row;
    }
}

// Close connection
$conn->close();

// Set header to return JSON
header('Content-Type: application/json');

// Output the JSON data
echo json_encode($devices);

