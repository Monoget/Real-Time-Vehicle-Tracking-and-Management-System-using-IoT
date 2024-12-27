# Real Time Vehicle Tracking and Management System using IoT

# GPS Module Setup on Raspberry Pi

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

## Setting Up a Systemd Service for Python Script

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


# WEB Setup for IoT-Based Vehicle Tracking and Management System

To set up and run the web-based user interface for the IoT-Based Vehicle Tracking and Management System, follow the steps below to install and configure XAMPP, which provides a local web server environment with Apache, MySQL, and PHP support.

## Prerequisites

- **XAMPP**: XAMPP is a free and open-source cross-platform web server solution stack package that includes Apache, MySQL, and PHP.
- **Operating System**: These steps are applicable for Windows, macOS, and Linux operating systems.

## Step-by-Step Installation and Setup

### 1. Download and Install XAMPP

- Visit the official XAMPP website: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
- Download the appropriate version of XAMPP for your operating system.
- Follow the installation instructions:
    - **Windows**: Run the installer and follow the on-screen instructions.
    - **macOS**: Open the `.dmg` file and follow the installation instructions.
    - **Linux**: Download the `.tar.gz` file and follow the instructions on the website for installation.

### 2. Start XAMPP Control Panel (Windows) or XAMPP Manager (macOS/Linux)

- Open the **XAMPP Control Panel** (on Windows) or **XAMPP Manager** (on macOS/Linux).
- Start the **Apache** and **MySQL** services by clicking the "Start" buttons next to each.

### 3. Configure PHP for Server-Side Scripting

- Navigate to the XAMPP installation directory.
    - **Windows**: Typically located in `C:\xampp\php\`
    - **macOS/Linux**: Typically located in `/opt/lampp/etc/php.ini`

- Open the `php.ini` file in a text editor and ensure that the following configurations are enabled:
    - Uncomment the line `extension=mysqli` (remove the `;` at the beginning of the line) to enable MySQLi extension for PHP.
    - If needed, adjust the `upload_max_filesize` and `post_max_size` to accommodate larger file uploads (optional for your application).

### 4. Set Up MySQL Database

1. **Access phpMyAdmin**:
    - Open your web browser and navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
    - phpMyAdmin is a web interface to manage your MySQL databases.

2. **Create a New Database**:
    - In phpMyAdmin, click on the "Databases" tab.
    - Create a new database for your project, for example, `gps_tracker`.

### 5. Place Your PHP and Web Files in the XAMPP Directory

- Move your project files (HTML, CSS, JavaScript, PHP) into the `htdocs` folder located inside the XAMPP installation directory:
    - **Windows**: `C:\xampp\htdocs\`
    - **macOS/Linux**: `/opt/lampp/htdocs/`

- For example, if your project is named `gps_tracker`, create a folder inside `htdocs` called `gps_tracker` and place all your project files there.

### 6. Update Database Connection in PHP

In your PHP scripts, update the database connection details to match your MySQL configuration. For example, modify the following variables:
```php
$servername = "localhost";
$username = "root";    // default username for MySQL
$password = "";        // default password is empty
$dbname = "vehicle_tracking_system";  // your database name
