<form action="process.php" method="post">
    <!-- <label for="chassisNumber">Enter Chassis Number:</label> -->
    <input type="text" id="chassisNumber" name="chassisNumber" placeholder="Enter Chassis Number" required>
    <button type="submit">Submit</button>
    <p>Disclaimer: The chassis number is decoded using publicly available data and logic. </p>
</form>

<!-- Display results or error message -->
<?php
if (isset($_SESSION['chassisResult'])) {
    if (isset($_SESSION['chassisResult']['error'])) {
        echo "<p class='error'>{$_SESSION['chassisResult']['error']}</p>";
    } else {
        echo "<p>Manufacturer: {$_SESSION['chassisResult']['manufacturer']}</p>";
        echo "<p>Manufacturing Month: {$_SESSION['chassisResult']['manufacturingMonth']}</p>";
        echo "<p>Manufacturing Year: {$_SESSION['chassisResult']['manufacturingYear']}</p>";
    }

    // Clear the session result to avoid displaying it again on refresh
    unset($_SESSION['chassisResult']);
}

?>