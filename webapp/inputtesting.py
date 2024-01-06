import RPi.GPIO as GPIO
import time

def append_to_file(filename, message):
    """
    Appends a message to the file specified by filename.
    """
    with open(filename, 'a') as file:
        file.write(message + "\n")

def button_callback(channel):
    """
    Callback function that is called when the button is pressed.
    """
    print("Button was pressed!")
    append_to_file('output.txt', 'hello')

def setup():
    """
    Sets up the GPIO pin and event detection.
    """
    buttonPin = 26  # GPIO pin the button is attached to
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(buttonPin, GPIO.IN, pull_up_down=GPIO.PUD_UP)
    GPIO.add_event_detect(buttonPin, GPIO.FALLING, callback=button_callback, bouncetime=200)

def main():
    try:
        setup()
        message = "Press the button to append 'hello' to output.txt. Press CTRL+C to exit."
        print(message)
        while True:
            # Just waiting for button press
            time.sleep(1)
    except KeyboardInterrupt:
        print("Exiting program")
    finally:
        GPIO.cleanup()

if __name__ == "__main__":
    main()

