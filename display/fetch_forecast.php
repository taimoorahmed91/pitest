<?php
// Function to fetch weather forecast data from OpenWeatherMap API
function getWeatherForecast($apiKey, $city) {
    $url = "http://api.openweathermap.org/data/2.5/forecast?q={$city}&units=metric&appid={$apiKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Your OpenWeatherMap API Key
$apiKey = '84bfec10e9167a7f218a880df1ce621b'; // Replace with your actual API key
$city = 'Krakow,PL';

// Get the weather forecast data
$forecastData = getWeatherForecast($apiKey, $city);

// Prepare an array to hold the processed data
$chartData = [
    'labels' => [],
    'temp_min' => [],
    'temp_max' => [],
    'feels_like' => []
];

// Extract data for each time slot
foreach ($forecastData['list'] as $timeSlot) {
    $chartData['labels'][] = date('D ga', $timeSlot['dt']); // Format: Day Hour am/pm
    $chartData['temp_min'][] = $timeSlot['main']['temp_min'];
    $chartData['temp_max'][] = $timeSlot['main']['temp_max'];
    $chartData['feels_like'][] = $timeSlot['main']['feels_like'];
}

// Output the data for the frontend to use
echo json_encode($chartData);
?>
