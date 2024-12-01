<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="ai-icon" href="Dashboard" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <?php
            if ($_SESSION['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-controls-3"></i>
                        <span class="nav-text">Vehicle</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="Add-Vehicle">Add Vehicle</a></li>
                        <li><a href="Vehicle-List">Vehicle List</a></li>
                    </ul>
                </li>
                <?php
            }

            if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Passenger') {
                ?>
                <li>
                    <a href="Show-Bus" aria-expanded="false">
                        <i class="flaticon-381-infinity"></i>
                        <span class="nav-text">Show Bus</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-archive"></i>
                        <span class="nav-text">Booking</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="Book-Bus">Book Bus</a></li>
                        <li><a href="My-Booking">My Booking</a></li>
                        <li><a href="Book-Distance">My Booking Distance</a></li>
                    </ul>
                </li>
                <?php
            }

            if ($_SESSION['role'] == 'Driver') {
                ?>
                <li>
                    <a href="Passenger-Location" aria-expanded="false">
                        <i class="flaticon-381-infinity"></i>
                        <span class="nav-text">View Passenger Location</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['role'] == 'Admin') {
                ?>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">User</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="Add-User">Add User</a></li>
                        <li><a href="User-List">User List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="Log" aria-expanded="false">
                        <i class="flaticon-381-internet"></i>
                        <span class="nav-text">Pi Log</span>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>