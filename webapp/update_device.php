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

// Check if ID is provided
if (isset($_GET['id'])) {
    // Get the ID and escape it to prevent SQL injection
    $id = $conn->real_escape_string($_GET['id']);

    // Get the input data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Check if the necessary data is provided
    if (isset($data['status']) && isset($data['device']) && isset($data['gpio'])) {
        $status = $conn->real_escape_string($data['status']);
        $device = $conn->real_escape_string($data['device']);
        $gpio = $conn->real_escape_string($data['gpio']);

        // Prepare the SQL statement to update the device
        $stmt = $conn->prepare("UPDATE devices SET status = ?, device = ?, gpio = ? WHERE id = ?");
        $stmt->bind_param("ssii", $status, $device, $gpio, $id);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            header("HTTP/1.1 200 OK");
            echo json_encode(array("message" => "Device updated successfully."));
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("message" => "Unable to update device."));
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("message" => "Missing data for update."));
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array("message" => "ID is required."));
}

// Close connection
$conn->close();

