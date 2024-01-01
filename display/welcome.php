<?php
// Start the session
session_start();

// Check if the user is not signed up, then redirect to signup page
if (!isset($_SESSION['signed_up'])) {
    header("Location: signup.php");
    exit();
}

// Rest of your page content follows
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="60;url=weather.php"> <!-- Page redirects to weather.php after 60 seconds -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
        body {
            background-color: #282828; /* Dark grey background */
            margin: 0;
            padding: 0;
            color: #fff; /* White text */
            font-family: 'Roboto Mono', monospace; /* Monospaced font for better readability */
        }
        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            height: 100vh;
            grid-gap: 10px;
            padding: 10px;
        }
        .box {
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center content vertically */
            align-items: center; /* Center content horizontally */
            border: 1px solid #3a3a3a; /* Soft grey border */
            border-radius: 15px; /* Rounded edges for the boxes */
            font-size: 1.5em; /* Adjusted font size for visibility */
            padding: 20px;
            box-sizing: border-box;
            background-color: #1a1a1a; /* Slightly lighter grey background for the boxes */
        }
        #box1 {
            color: #e6e6e6; /* Soft white color text */
            font-size: 5em; /* Large font for the digital clock display */
            font-weight: 700; /* Bold font weight for clarity */
        }
        #box1 .date {
            font-size: 1em; /* Smaller font for the date */
            margin-top: 0.5em; /* Space from the time */
        }
        #box1 .day {
            font-size: 1em; /* Font size for the day */
            margin-top: 0.25em; /* Space from the date */
        }
        /* Additional styles can be added for other boxes as needed */
    </style>
</head>
<body>
    <div class="container">
        <div class="box" id="box1">
            <?php
            // Set the time zone to Central European Time (CET)
            date_default_timezone_set('CET');
            // Display current time with AM or PM, date, and day on separate lines
            echo "<div>" . date('h:i A') . "</div>"; // Time with AM/PM
            echo "<div class='date'>" . date('d F') . "</div>"; // Date in the format "24 December"
            echo "<div class='day'>" . date('l') . "</div>"; // Day in the format "Sunday"
            ?>
        </div>




<div class="box" id="box2">
    <!-- Placeholder for the Pi-hole chart -->
    <canvas id="piholeChart"></canvas>
</div>

<div class="box" id="box3">
    <!-- Placeholder for the speedtest chart -->
    <canvas id="speedtestChart"></canvas>
</div>


<div class="box" id="box4">
</div>

    </div>





<script>
    // Fetch speedtest data using AJAX
    fetch('speedtest_data.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.testtime);
            const downloadSpeeds = data.map(item => item.download_speed);
            const uploadSpeeds = data.map(item => item.upload_speed);

            // Initialize the speedtest chart
            new Chart(
                document.getElementById('speedtestChart'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Download Speed (Mbit/s)',
                                data: downloadSpeeds,
                                fill: false,
                                borderColor:  'rgb(75, 192, 192)',
                                tension: 0.1
                            },
                            {
                                label: 'Upload Speed (Mbit/s)',
                                data: uploadSpeeds,
                                fill: false,
                                borderColor: 'rgb(255, 159, 64)', 
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                }
            );
        })
        .catch(error => console.error('Error fetching speedtest data:', error));
</script>

<script>
    fetch('pihole_data.php')
        .then(response => response.json())
        .then(data => {
            const recordedAt = data.map(item => item.recorded_at);
            const dnsQueries = data.map(item => item.dns_queries_today);
            const adsBlocked = data.map(item => item.ads_blocked_today);
            const domainsBlocked = data.map(item => item.domains_being_blocked);

            new Chart(document.getElementById('piholeChart'), {
                type: 'line',
                data: {
                    labels: recordedAt,
                    datasets: [
                        {
                            label: 'DNS Queries Today',
                            data: dnsQueries,
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)', // Blue
                            tension: 0.1
                        },
                        {
                            label: 'Ads Blocked Today',
                            data: adsBlocked,
                            fill: false,
                            borderColor: 'rgb(255, 99, 132)', // Red
                            tension: 0.1
                        },
                        {
                            label: 'Domains Being Blocked',
                            data: domainsBlocked,
                            fill: false,
                            borderColor: 'rgb(153, 102, 255)', // Purple
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching Pi-hole data:', error));
</script>


</body>
</html>

