<?php
// Database credentials
$host = '127.0.0.1';
$username = 'root';
$password = 'C1sc0123@';
$dbname = 'currency';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch data and format the time
$sql = "SELECT usd, pln, DATE_FORMAT(time, '%Y-%m-%d %H:%i') AS formatted_time FROM usdpln";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode($data);

$conn->close();
?>

