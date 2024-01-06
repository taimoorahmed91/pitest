import mysql.connector
import RPi.GPIO as GPIO
import time

# Database configuration
db_config = {
    'user': 'root',
    'password': 'C1sc0123@',  # Replace with your actual password
    'host': 'localhost',
    'database': 'automation',
    'raise_on_warnings': True
}

# Define the GPIO pins that the buttons are connected to
button_pins = [2,3,4,17,27]

def append_to_file(filename, message):
    """
    Appends a message to the file specified by filename.
    """
    with open(filename, 'a') as file:
        file.write(message + "\n")

def update_device_status(gpio, status):
    """
    Updates the device status in the database for the given GPIO pin.
    """
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        query = "UPDATE buttons SET status = %s, timechange = NOW() WHERE gpio = %s"
        cursor.execute(query, (status, gpio))
        connection.commit()
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if 'cursor' in locals():
            cursor.close()
        if 'connection' in locals() and connection.is_connected():
            connection.close()

def setup_gpio(pins):
    """
    Sets up the GPIO pins as inputs with pull-up resistors.
    """
    GPIO.setmode(GPIO.BCM)
    for pin in pins:
        GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

def check_buttons(pins):
    """
    Checks the buttons and updates the database and output.txt when a button is pressed or released.
    """
    try:
        previous_states = {pin: True for pin in pins}  # Initialize previous states as True (unpressed)
        while True:
            for pin in pins:
                current_state = GPIO.input(pin)
                # Check if button state has changed from previous state
                if current_state != previous_states[pin]:
                    if current_state == False:
                        # Button was pressed
                        update_device_status(pin, 'on')
                        append_to_file('output.txt', f"Button on GPIO {pin} was pressed")
                    else:
                        # Button was released
                        update_device_status(pin, 'off')
                        append_to_file('output.txt', f"Button on GPIO {pin} was released")
                    # Update the previous state
                    previous_states[pin] = current_state
                time.sleep(0.1)  # Small delay to avoid bouncing
    except KeyboardInterrupt:
        print("Exiting program")
    finally:
        GPIO.cleanup()

if __name__ == "__main__":
    setup_gpio(button_pins)
    check_buttons(button_pins)

