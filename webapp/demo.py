import sys
import subprocess

def write_args_to_file(args, filename="args.txt"):
    with open(filename, "w") as file:
        file.write(" ".join(args) + "\n")

if __name__ == "__main__":
    if len(sys.argv) == 4:
        device_id = sys.argv[1]
        status = sys.argv[2].lower()
        gpio = sys.argv[3]

        # Write arguments to args.txt
        write_args_to_file(sys.argv[1:])

        if status == "on":
            # Run on_script.py with device_id and gpio as arguments
            subprocess.run(["python3", "on_script.py", device_id, gpio])
        elif status == "off":
            # Run off_script.py with device_id and gpio as arguments
            subprocess.run(["python3", "off_script.py", device_id, gpio])
        else:
            print("Invalid status argument. Please use 'on' or 'off'.")
    else:
        print("Please provide exactly three arguments.")

