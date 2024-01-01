#!/bin/bash

# Replace with your actual API key
API_KEY="84bfec10e9167a7f218a880df1ce621b"
CITY="Krakow,PL"
URL="http://api.openweathermap.org/data/2.5/forecast?q=$CITY&units=metric&appid=$API_KEY"

# Fetch the weather forecast data
weather_forecast_data=$(curl -s "$URL")

# Print the data
echo $weather_forecast_data | jq .
