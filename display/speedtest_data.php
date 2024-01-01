<?php
// Database configuration
$db_config = [
    "host" => "127.0.0.1",
    "user" => "root",
    "password" => "C1sc0123@",
    "database" => "speedtest"
];

// Create connection
$conn = new mysqli($db_config["host"], $db_config["user"], $db_config["password"], $db_config["database"]);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$query = "SELECT `download_speed`, `upload_speed`, `testtime` FROM `speedtesting`  ORDER BY `testtime` DESC LIMIT 15;";
$result = $conn->query($query);

$speedtestData = [];
while($row = $result->fetch_assoc()) {
    $speedtestData[] = $row;
}

$conn->close();

// Convert data to JSON format
echo json_encode($speedtestData);
?>

