import sys

def append_to_file(filename, message):
    """
    Appends a message to the file specified by filename.
    """
    with open(filename, 'a') as file:
        file.write(message + "\n")

if __name__ == "__main__":
    if len(sys.argv) == 3:
        device_name = sys.argv[1]
        gpio = sys.argv[2]
        message = f"{device_name} (GPIO {gpio}) was turned ON"
        append_to_file('output.txt', message)
    else:
        print("Please provide exactly two arguments: device name and GPIO.")

