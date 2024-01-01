<?php

// Function to get weather data from OpenWeatherMap API
function getWeatherData($apiKey, $city) {
    $url = "http://api.openweathermap.org/data/2.5/forecast?q=$city&units=metric&appid=$apiKey";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

// Function to process and structure weather data for charting
function processWeatherData($weatherData) {
    $chartData = [
        'labels' => [],
        'temperatureData' => [],
        'humidityData' => []
    ];

    // Loop through each forecast entry and extract the date and temperature
    foreach ($weatherData['list'] as $timeSlot) {
        $time = date('D, ga', $timeSlot['dt']); // Format the date as 'Day, Hour am/pm'
        $chartData['labels'][] = $time;
        $chartData['temperatureData'][] = $timeSlot['main']['temp'];
        $chartData['humidityData'][] = $timeSlot['main']['humidity'];
    }

    return $chartData;
}

// Your OpenWeatherMap API Key
$apiKey = '84bfec10e9167a7f218a880df1ce621b'; // Replace with your actual API key
$city = 'Krakow,PL';

// Get the weather data
$weatherData = getWeatherData($apiKey, $city);

// Check if the data was fetched successfully
if ($weatherData && isset($weatherData['list'])) {
    // Process the data for charting
    $chartData = processWeatherData($weatherData);
} else {
    // Return an empty array or handle the error as needed
    $chartData = ['error' => 'Could not fetch weather data'];
}
?>

