import RPi.GPIO as GPIO
import time

# List of GPIO pins to use
gpio_pins = [ 22, 10, 9, 11, 0, 5, 6, 13, 19, 26]

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

# Main execution loop
try:
    for pin in gpio_pins:
        turn_on_led(pin)
finally:
    GPIO.cleanup()  # Clean up GPIO state

print("All LEDs have been turned on and off sequentially.")

