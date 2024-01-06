import sys
import RPi.GPIO as GPIO

def append_to_file(filename, message):
    """
    Appends a message to the file specified by filename.
    """
    with open(filename, 'a') as file:
        file.write(message + "\n")

def setup_gpio(pin):
    """
    Sets up a GPIO pin as an output.
    """
    GPIO.setmode(GPIO.BCM)  # Use the Broadcom SOC Pin numbers
    GPIO.setup(pin, GPIO.OUT)

def turn_on_gpio(pin):
    """
    Turns on a GPIO pin.
    """
    GPIO.output(pin, GPIO.HIGH)

if __name__ == "__main__":
    if len(sys.argv) == 3:
        device_name = sys.argv[1]
        gpio = int(sys.argv[2])  # Convert GPIO argument to an integer
        setup_gpio(gpio)  # Setup GPIO

        # Control the GPIO pin as needed
        turn_on_gpio(gpio)  # Turn on GPIO

        message = f"{device_name} (GPIO {gpio}) was turned ON"
        append_to_file('output.txt', message)
    else:
        print("Please provide exactly two arguments: device name and GPIO.")
    
    # Clean up GPIO at the end of the script
   # GPIO.cleanup()
