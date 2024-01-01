<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url=sample.php">
    <title>Device Control Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Database connection details
    $host = 'localhost';
    $username = 'root'; 
    $password = 'C1sc0123@';  // Database password
    $database = 'automation';

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch device status and gpio from the database
    $sql = "SELECT id, device, status, gpio FROM devices";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <div class="box" id="box1">
            <h1 class="heading">Devices</h1>
            <div class="device-controls">
                <?php 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $checked = ($row["status"] == "on") ? "checked" : "";
                        echo '<div class="device">
                                <span>'. htmlspecialchars($row["device"]) .':</span>
                                <label class="switch">
                                    <input type="checkbox" data-device-id="'. $row["id"] .'" '. $checked .' onclick="toggleDeviceStatus('. $row["id"] .', this.checked, '. $row["gpio"] .')">
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
    <h1 class="heading">Button Controls</h1>
    <div class="button-controls">
        <?php 
        // Creating a new connection for Box 2
        $conn2 = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error);
        }

        // Fetch button status from the database
        $sqlButtons = "SELECT id, device, status FROM buttons";
        $resultButtons = $conn2->query($sqlButtons);

        if ($resultButtons->num_rows > 0) {
            while($row = $resultButtons->fetch_assoc()) {
                $buttonColor = ($row["status"] == "on") ? "green" : "red";
                echo '<div class="button-device">
                        <span>'. htmlspecialchars($row["device"]) .':</span>
                        <button style="background-color: '. $buttonColor .';">'. ucfirst($row["status"]) .'</button>
                      </div>';
            }
        } else {
            echo "0 results in buttons";
        }

        // Close the second connection
        $conn2->close();
        ?>
    </div>
</div>






    </div>

<script>
    function toggleDeviceStatus(deviceId, status, gpio) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_device_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                console.log(this.responseText);
            }
        }
        
        // Send deviceId, status, and gpio in the request
        xhr.send("deviceId=" + deviceId + "&status=" + status + "&gpio=" + gpio);
    }
</script>

</body>
</html>

