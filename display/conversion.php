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
    <meta http-equiv="refresh" content="15;url=welcome.php"> <!-- Page redirects to weather.php after 60 seconds -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversion</title>
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
    <!-- Placeholder for the currency conversion chart -->
    <canvas id="currencyChart"></canvas>
</div>

<div class="box" id="box2">
    <!-- Placeholder for the EUR to PLN conversion chart -->
    <canvas id="europlnChart"></canvas>
</div>


<div class="box" id="box3">
    <!-- Placeholder for the USD to PKR conversion chart -->
    <canvas id="usdpkrChart"></canvas>
</div>

<div class="box" id="box4">
    <!-- Placeholder for the USD to PLN conversion chart -->
    <canvas id="usdplnChart"></canvas>
</div>

    </div>



<script>
    fetch('conversion_plnpkr.php')
        .then(response => response.json())
        .then(data => {
            // Use 'formatted_time' instead of 'time'
            const labels = data.map(item => item.formatted_time);
            const pkrRates = data.map(item => item.pkr);
            
            new Chart(
                document.getElementById('currencyChart'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'PLN to PKR Rate',
                                data: pkrRates,
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
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
        .catch(error => console.error('Error fetching conversion data:', error));
</script>



<script>
    fetch('conversion_usdpkr.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.formatted_time);
            const pkrRates = data.map(item => item.pkr);

            new Chart(
                document.getElementById('usdpkrChart'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'USD to PKR Rate',
                                data: pkrRates,
                                fill: false,
                                borderColor: 'rgb(255, 99, 132)',
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
        .catch(error => console.error('Error fetching USD to PKR conversion data:', error));
</script>

<script>
    fetch('conversion_usdpln.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.formatted_time);
            const plnRates = data.map(item => item.pln);

            new Chart(
                document.getElementById('usdplnChart'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'USD to PLN Rate',
                                data: plnRates,
                                fill: false,
                                borderColor: 'rgb(54, 162, 235)',
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
        .catch(error => console.error('Error fetching USD to PLN conversion data:', error));
</script>

<script>
    fetch('conversion_europln.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.formatted_time);
            const plnRates = data.map(item => item.pln);

            new Chart(
                document.getElementById('europlnChart'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'EUR to PLN Rate',
                                data: plnRates,
                                fill: false,
                                borderColor: 'rgb(153, 102, 255)',
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
        .catch(error => console.error('Error fetching EUR to PLN conversion data:', error));
</script>


</body>
</html>

