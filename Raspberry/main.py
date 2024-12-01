import serial
import time
import http.client
import urllib.parse
from threading import Thread

# Configuration for GPS and server connection
vehicle_id = 1
port = "/dev/ttyAMA0"
baudrate = 9600
server_url = "gps.monoget.com.bd"
server_endpoint = "/insert-data.php"

# Function to parse latitude and longitude from NMEA sentence
def parse_coordinates(nmea_sentence):
    try:
        parts = nmea_sentence.split(',')
        if parts[2] == 'A':  # 'A' means data is valid
            lat = float(parts[3][:2]) + float(parts[3][2:]) / 60.0
            if parts[4] == 'S':
                lat = -lat
            lon = float(parts[5][:3]) + float(parts[5][3:]) / 60.0
            if parts[6] == 'W':
                lon = -lon
            return lat, lon
    except (IndexError, ValueError) as e:
        print("Parsing error:", e)
    return None, None

# Function to send GPS data to the server asynchronously
def send_data_to_server(vehicle_id, lat, lon):
    def send():
        try:
            params = urllib.parse.urlencode({'vid': vehicle_id, 'lat': lat, 'lon': lon})
            headers = {"Content-type": "application/x-www-form-urlencoded"}
            conn = http.client.HTTPConnection(server_url)
            conn.request("GET", f"{server_endpoint}?{params}", headers=headers)
            response = conn.getresponse()
            print(f"Server response: {response.status}, {response.reason}")
            conn.close()
        except Exception as e:
            print("Error sending data:", e)
    Thread(target=send).start()  # Run send function in a separate thread

# Main function to read GPS data
def read_gps_data():
    try:
        with serial.Serial(port, baudrate=baudrate, timeout=0.1) as ser:
            print("Starting GPS data read...")
            while True:
                if ser.in_waiting > 0:
                    line = ser.readline().decode('ascii', errors='ignore').strip()
                    if line.startswith("$GPRMC") or line.startswith("$GNRMC"):
                        print("Received NMEA sentence:", line)
                        lat, lon = parse_coordinates(line)
                        if lat is not None and lon is not None:
                            print(f"Latitude: {lat}, Longitude: {lon}")
                            send_data_to_server(vehicle_id, lat, lon)  # Send data immediately
                    else:
                        time.sleep(0.1)  # Shorter wait time when no valid data
    except serial.SerialException as e:
        print("Serial Exception:", e)
        print("Reconnecting in 5 seconds...")
        time.sleep(5)
        read_gps_data()  # Retry on connection loss

# Start reading GPS data
read_gps_data()
