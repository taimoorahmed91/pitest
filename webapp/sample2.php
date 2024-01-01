<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    // Database connection details
    $host = 'localhost';
    $username = 'root'; // Database username
    $password = 'C1sc0123@'; // Database password
    $database = 'automation';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch device status from the database
    $sql = "SELECT id, device, status FROM devices";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <div class="box" id="box1">
            <h1 class="heading">Devices</h1>
            <div class="device-controls">
                <?php 
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $checked = ($row["status"] == "on") ? "checked" : "";
                        echo '<div class="device">
                                <span>'. htmlspecialchars($row["device"]) .':</span>
                                <label class="switch">
                                    <input type="checkbox" '. $checked .'>
                                    <span class="slider round"></span>
                                </label>
                            </div>';
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </div>
        </div>
        <div class="box" id="box2">
            <h1 class="heading">Buttons</h1>
            <!-- Additional content for Buttons can be added here -->
        </div>
    </div>
</body>
</html>

