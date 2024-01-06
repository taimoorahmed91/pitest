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
button_pins = [19, 26]

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
    Checks the buttons and updates the database when a button is pressed.
    """
    try:
        while True:
            for pin in pins:
                if GPIO.input(pin) == False:  # Button is pressed
                    print(f"Button on GPIO {pin} was pressed")
                    update_device_status(pin, 'on')
                    # Debounce delay
                    time.sleep(0.3)
    except KeyboardInterrupt:
        print("Exiting program")
    finally:
        GPIO.cleanup()

if __name__ == "__main__":
    setup_gpio(button_pins)
    check_buttons(button_pins)
