import RPi.GPIO as GPIO
import time

# Define the GPIO pins that the buttons are connected to
button_pins = [19, 26]

def append_to_file(filename, message):
    """
    Appends a message to the file specified by filename.
    """
    with open(filename, 'a') as file:
        file.write(message + "\n")

def setup_gpio(pins):
    """
    Sets up the GPIO pins as inputs with pull-up resistors.
    """
    GPIO.setmode(GPIO.BCM)
    for pin in pins:
        GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

def check_buttons(pins):
    """
    Checks the buttons and writes to the file when a button is pressed.
    """
    try:
        while True:
            for pin in pins:
                if GPIO.input(pin) == False:  # Button is pressed
                    print(f"Button on GPIO {pin} was pressed")
                    append_to_file('output.txt', f"Button pressed on GPIO {pin}")
                    # Debounce delay
                    time.sleep(0.3)
    except KeyboardInterrupt:
        print("Exiting program")
    finally:
        GPIO.cleanup()

if __name__ == "__main__":
    setup_gpio(button_pins)
    check_buttons(button_pins)

