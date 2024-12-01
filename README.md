# IOT Based Vehicle Tracking and Management System

## GPS Module Setup on Raspberry Pi

This guide walks through setting up a GPS module (such as the Neo 6M) with a Raspberry Pi using the latest Raspbian
OS.

## Prerequisites

- A Raspberry Pi with a compatible GPS module (Neo 6M or M8N)
- MicroSD card with at least 8GB capacity
- Card reader to flash Raspbian OS
- Power supply for the Raspberry Pi
- 4G Modem
- SMA to U.FL Adapter RF Cable - Female 100mm (Optional)
- GPS Antenna 1575.42 MHz (Optional)

## Modem Connect to Internet

- Buy a suitable internet pack that will suit
- Connect with Raspberry Pi
- Install modem software
- Then connect to the Internet

## Installation Steps

1. **Install the Latest Raspbian OS**
    - Download and install the latest Raspbian OS on a microSD card. Detailed instructions are available at
      the [official Raspberry Pi documentation](https://www.raspberrypi.org/documentation/installation/installing-images/).
    - Insert the microSD card into the Raspberry Pi and power it on.

2. **Configure Raspbian for GPS Module**

   ### Edit `/boot/firmware/config.txt` file:
    - Open the file in a text editor, for example, using `nano`:
      ```
      sudo nano /boot/firmware/config.txt
      ```
    - Add the following lines at the end of the file:
      ```
      dtparam=spi=on
      dtoverlay=pi3-disable-bt
      core_freq=250
      enable_uart=1
      force_turbo=1
      ```
    - Save the file by pressing `CTRL + X`, then `Y` and `Enter`.

   ### Edit `/boot/cmdline.txt` file:
    - Make a backup of the file for safety:
      ```
      sudo cp /boot/firmware/cmdline.txt /boot/firmware/cmdline_backup.txt
      ```
    - Open the file in a text editor:
      ```
      sudo nano /boot/cmdline.txt
      ```
    - Replace all content with the following line:
      ```
      dwc_otg.lpm_enable=0 console=tty1 root=/dev/mmcblk0p2 rootfstype=ext4 elevator=deadline fsck.repair=yes rootwait quiet splash plymouth.ignore-serial-consoles
      ```
    - Save the file by pressing `CTRL + X`, then `Y` and `Enter`.

3. **Reboot the Raspberry Pi**
   ```
   sudo reboot
    ```
4. **Verify GPS Module Operation**

- Ensure the GPS module’s blue LED is blinking. This indicates the GPS is receiving data correctly.
- Note: If the LED does not blink after five minutes, try positioning the module near a window or outside where it has
  a clearer view of the sky.

5. **Read GPS Data**
   ```
   sudo cat /dev/ttyAMA0
    ```

# Setting Up a Systemd Service for Python Script

This guide shows how to create a systemd service to automatically start a Python script at boot on Linux system. The service will restart if the script fails, but it will not restart if the script completes successfully.

## Steps

1. **Create the Service File**
    - Open the terminal and create a new service file:
      ```
      sudo nano /etc/systemd/system/myscript.service
      ```
    - Replace the contents with the following configuration:

      ```
      [Unit]
      Description=Run Python Script at Startup
      After=network-online.target
      Wants=network-online.target
 
      [Service]
      ExecStart=/usr/bin/python3 /path/to/script.py
      Restart=on-failure
      RestartSec=5
 
      [Install]
      WantedBy=multi-user.target
      ```

   ### Explanation of Configuration
    - `Restart=on-failure`: The script restarts only if it exits with a non-zero exit status (indicating an error).
    - `RestartSec=5`: If an error causes a restart, the system waits 5 seconds before attempting to restart. This delay prevents rapid, repeated restarts in case of persistent issues.

    - **Save and exit the editor** by pressing `CTRL + X`, then `Y`, and `Enter`.

2. **Enable and Start the Service**
    - To enable and start the service, use the following commands:
      ```
      sudo systemctl enable myscript.service
      sudo systemctl start myscript.service
      ```

3. **Testing and Monitoring the Service**
    - This setup ensures the script runs once at boot and only restarts if it fails. Now can check the status of the service anytime with:
      ```
      sudo systemctl status myscript.service
      ```
    - **Note**: This script will restart only if an error occurs during execution.

---

This setup is now complete, and Python script will run at startup and restart only on failure.


After Complete all process check the web server log its sent data or not.


