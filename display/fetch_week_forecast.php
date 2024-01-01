<?php
// fetch_week_forecast.php

function getWeeklyWeatherForecast($apiKey, $city) {
    $url = "http://api.openweathermap.org/data/2.5/forecast?q={$city}&units=metric&appid={$apiKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// This check ensures that the script only runs in response to an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $apiKey = '84bfec10e9167a7f218a880df1ce621b'; // Replace with your actual API key
    $city = 'Krakow,PL';

    $forecastData = getWeeklyWeatherForecast($apiKey, $city);

    $chartData = [
        'labels' => [],
        'temp_min' => [],
        'temp_max' => [],
        'feels_like' => [],
        'rainData' => [], // Add rain data
        'windData' => [], // Add wind data
        'snowData' => [] // Add snow data
    ];

    foreach ($forecastData['list'] as $timeSlot) {
        $chartData['labels'][] = date('D ga', $timeSlot['dt']);
        $chartData['temp_min'][] = $timeSlot['main']['temp_min'];
        $chartData['temp_max'][] = $timeSlot['main']['temp_max'];
        $chartData['feels_like'][] = $timeSlot['main']['feels_like'];

        // Check if rain data is available
        if (isset($timeSlot['rain']['3h'])) {
            $chartData['rainData'][] = $timeSlot['rain']['3h'];
        } else {
            $chartData['rainData'][] = 0; // No rain data, so set it to 0
        }

        // Check if snow data is available
        if (isset($timeSlot['snow']['3h'])) {
            $chartData['snowData'][] = $timeSlot['snow']['3h'];
        } else {
            $chartData['snowData'][] = 0; // No snow data, so set it to 0
        }

        // Add wind data
        $chartData['windData'][] = $timeSlot['wind']['speed'];
    }

    header('Content-Type: application/json');
    echo json_encode($chartData);
    exit();
}
?>

