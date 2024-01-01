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
    <meta http-equiv="refresh" content="15;url=conversion.php"> <!-- Page redirects to weather.php after 60 seconds -->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
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
    <canvas id="rainChartCanvas"></canvas> <!-- Canvas element for rain chart -->
</div>


<div class="box" id="box2">
    <canvas id="windChartCanvas"></canvas> <!-- Canvas element for wind speed chart -->
</div>



<div class="box" id="box3">
    <canvas id="snowChartCanvas"></canvas> <!-- Canvas element for snow chart -->
</div>

<div class="box" id="box4">
    <canvas id="forecastChart"></canvas>
</div>

    </div>






<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script> <!-- Include Chart.js Annotation plugin -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_week_forecast.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Log the data to see if it's correctly structured
        console.log('Forecast data:', data);

        // Get the context of the canvas element we want to select
        const ctx = document.getElementById('forecastChart').getContext('2d');
        const forecastChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Min Temperature (°C)',
                        data: data.temp_min,
                        borderColor: 'rgb(127, 179, 213)',
                        fill: false
                    },
                    {
                        label: 'Max Temperature (°C)',
                        data: data.temp_max,
                        borderColor: 'rgb(229, 152, 102)',
                        fill: false
                    },
                    {
                        label: 'Feels Like (°C)',
                        data: data.feels_like,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                    }
                },
                maintainAspectRatio: false,
                plugins: {
                    annotation: {
                        annotations: {
                            zeroLine: {
                                type: 'line',
                                mode: 'horizontal',
                                scaleID: 'y',
                                value: 0,
                                borderColor: 'rgba(200, 200, 200, 0.5)', // Grey color for zero line
                                borderWidth: 2, // Adjust line width as needed
                                borderDash: [2], // Dotted line style
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching forecast data:', error);
        // Optionally alert the user
        // alert('Error fetching forecast data: ' + error.message);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_week_forecast.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Ensure that the element ID here matches the ID of the canvas element
        const ctx = document.getElementById('windChartCanvas').getContext('2d');

        // Initialize the wind speed chart
        const windSpeedChart = new Chart(ctx, {
            type: 'line', // Change to 'bar' for a bar chart if you prefer
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Wind Speed (m/s)',
                    data: data.windData,
                    borderColor: 'rgb(54, 162, 235)', // Choose any color you like
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Optional: for area under line chart
                    fill: false // Change to true if you want the area under the line filled
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Change to false if you don't want the scale to start from zero
                    }
                },
                maintainAspectRatio: false // Set to true if you want to maintain aspect ratio
            }
        });
    })
    .catch(error => {
        console.error('Error fetching forecast data:', error);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_week_forecast.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Ensure that the element ID here matches the ID of the canvas element
        const ctx = document.getElementById('snowChartCanvas').getContext('2d');

        // Initialize the snow chart
        const snowChart = new Chart(ctx, {
            type: 'line', // Change to 'bar' for a bar chart if you prefer
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Snow (mm)',
                    data: data.snowData.map(snowAmount => snowAmount || 0), // Convert null/undefined to 0
                    borderColor: 'rgb(175, 238, 238)', // Choose a color representative of snow
                    backgroundColor: 'rgba(175, 238, 238, 0.5)', // Optional: for area under line chart
                    fill: false // Change to true if you want the area under the line filled
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true, // Ensures the scale starts at zero
                        ticks: {
                            // Ensure decimal values are handled gracefully
                            callback: function(value, index, values) {
                                return value.toFixed(2); // Formats the y-axis values to 2 decimal places
                            }
                        }
                    }
                },
                maintainAspectRatio: false // Set to true if you want to maintain aspect ratio
            }
        });
    })
    .catch(error => {
        console.error('Error fetching forecast data:', error);
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('fetch_week_forecast.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Ensure that the element ID here matches the ID of the canvas element
        const ctx = document.getElementById('rainChartCanvas').getContext('2d');

        // Initialize the rain chart
        const rainChart = new Chart(ctx, {
            type: 'bar', // Bar chart to represent rainfall amounts
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Rain (mm)',
                    data: data.rainData.map(rainAmount => rainAmount || 0), // Convert null/undefined to 0
                    borderColor: 'rgb(54, 162, 235)', // Blue color for rain
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue color with opacity
                    fill: true // Fill the bars for better visual impact
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true, // Ensures the scale starts at zero
                        ticks: {
                            // Ensure decimal values are handled gracefully
                            callback: function(value, index, values) {
                                return value.toFixed(2); // Formats the y-axis values to 2 decimal places
                            }
                        }
                    }
                },
                maintainAspectRatio: false // Set to true if you want to maintain aspect ratio
            }
        });
    })
    .catch(error => {
        console.error('Error fetching forecast data:', error);
    });
});
</script>


</body>
</html>

