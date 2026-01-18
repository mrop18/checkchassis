<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Check Chassis</title>
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src='https://kit.fontawesome.com/f2e915867a.js' crossorigin='anonymous'></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1335824760537566"
     crossorigin="anonymous"></script>
     <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
</script>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7BY7SLP8W6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7BY7SLP8W6');
</script>


<body>
    <amp-auto-ads type="adsense"
        data-ad-client="ca-pub-1335824760537566">
</amp-auto-ads>
  <?php include 'components/_navbar.php' ?>
  <div class="container vdcon">
    <div class="container_new">
      <div class="input-container">
        <h1>VIN Decoder</h1>

        <!-- Form to input chassis number -->
        <form action="process.php" method="post">
          <label for="chassisNumber">Enter Chassis Number:</label>
          <input type="text" id="chassisNumber" name="chassisNumber" required>
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
      </div>
    </div>
    <div class="sctable">

      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">Sr.No.</th>
            <th scope="col">Recently Searched Chassis Numbers</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'components/_dbconnect.php';
          $sql = "SELECT * FROM `searcheddata` ORDER BY sno DESC LIMIT 100";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $sno = $row['sno'];
            $searchedChassisNumber = $row['searchedChassisNumber'];
            echo '
              
              <tr>
              <th scope="row">' . $sno . '</th>
              <td>' . $searchedChassisNumber . '</td>
              </tr>
              ';
          }

          ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include 'components/_footer.php' ?>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
  <script>
    new DataTable('#myTable', {
      searching: false,
      info: false,
      paging: false,
      scrollx: false,
      scrollY: '300px',
      order: [[0, 'desc']],
      "columnDefs": [
      { "targets": [0, 1], "orderable": false }
  ],

  
      
    });
    
  </script>




</body>

</html>