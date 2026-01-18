<?php
echo '

<nav style="background-color: #f4fefe; " class="navbar navbar-expand-lg">
    <div class="container" style="padding-left: 100px; padding-right: 100px; ">
        <a style="font-weight: 600; color: #01162e;" class="navbar-brand" href="../index">Check Chassis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div style="width: 73%; justify-content: center;" class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a style="color: #01162e;" class="nav-link active" aria-current="page" href="../index">Home</a>
                </li>
                <li class="nav-item">
                    <a style="color: #01162e;" class="nav-link" href="../vin_decoder">VIN Decoder</a>
                </li>

                <li class="nav-item dropdown">
                    <a style="color: #01162e;" class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Get Insurance
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../index#vehicleinsurance">2W/Bike Insurance</a></li>
                        <li><a class="dropdown-item" href="../index#vehicleinsurance">Motor/Car Insurance</a></li>
                        <li><a class="dropdown-item" href="../index#healthinsurance">Insurance for Life</a></li>
                        <li><a class="dropdown-item" href="../index#healthinsurance">Money Back Insurance</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a style="color: #01162e;" class="nav-link" href="../blogs">Blogs</a>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Get Loan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="get_loan.php">Personal Loan</a></li>
                        <li><a class="dropdown-item" href="get_loan.php">Business Loan</a></li>
                        <li><a class="dropdown-item" href="get_loan.php">2W/Bike Loan</a></li>
                        <li><a class="dropdown-item" href="get_loan.php">Car Loan</a></li>
                    </ul>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="../contactus.php">Contact Us</a>
                </li> -->
            </ul>

        </div>
        <span style="justify-content: right; width: max-content;" class="collapse navbar-collapse"
            id="navbarNavDropdown">

            <!-- <button class="btn btn-outline" type="login"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button> -->
            <a href="../index#contactus"><button class="navbtn">Contact Us</button></a>
            

        </span>

    </div>
</nav>
';

// include 'components/_login.php';




?>