import RPi.GPIO as GPIO
import time
import mysql.connector

# Database configuration
db_config = {
    'user': 'root',
    'password': 'C1sc0123@',
    'host': 'localhost',  # or the IP if your database is on a different machine
    'database': 'automation'
}

# List of GPIO pins to use
gpio_pins = [22, 10, 9, 11, 0, 5, 6, 13, 19, 26]

# Setup GPIO mode
GPIO.setmode(GPIO.BCM)  # Use BCM numbering

# Set up each pin as an output
for pin in gpio_pins:
    GPIO.setup(pin, GPIO.OUT)

# Function to turn on an LED, print its GPIO number, and then turn it off
def turn_on_led(pin):
    GPIO.output(pin, GPIO.HIGH)  # Turn on LED
    print(f"LED on GPIO {pin} turned on")
    time.sleep(1)  # Keep the LED on for 1 second
    GPIO.output(pin, GPIO.LOW)  # Turn off LED

# Update device status in database
def update_device_status():
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("UPDATE `devices` SET `status`='off' WHERE 1;")
        conn.commit()
        print("Database updated: All device statuses set to 'off'.")
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

# Main execution loop
try:
    for pin in gpio_pins:
        turn_on_led(pin)
    update_device_status()  # Update the database after turning off all LEDs
finally:
    GPIO.cleanup()  # Clean up GPIO state

print("All LEDs have been turned on and off sequentially.")

