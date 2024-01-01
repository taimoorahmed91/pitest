<?php
// Database configuration
$db_config = [
    "host" => "127.0.0.1",
    "user" => "root",
    "password" => "C1sc0123@", // Change to your actual password
    "database" => "pihole"
];

// Create connection
$conn = new mysqli($db_config["host"], $db_config["user"], $db_config["password"], $db_config["database"]);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch multiple records from the database for the graph
$query = "SELECT `recorded_at`, `domains_being_blocked`, `dns_queries_today`, `ads_blocked_today` FROM `pihole_stats` ORDER BY `recorded_at` DESC LIMIT 10";
$result = $conn->query($query);

$piholeData = [];
while($row = $result->fetch_assoc()) {
    $piholeData[] = $row;
}

$conn->close();

// Convert data to JSON format
echo json_encode(array_reverse($piholeData)); // array_reverse to order the data from oldest to newest
?>

