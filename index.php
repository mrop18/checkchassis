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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1335824760537566"
     crossorigin="anonymous"></script>
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
  <?php include 'components/_navbar.php' ?>
  <?php include 'components/_dbconnect.php' ?>

  
  <div style="justify-content:center; color:#01162e;" class="container mt-5 d-flex">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h1 style="color: #01162e;"><em>Find Month and Year of Manufacturing of your vehicle</em></h1>
          <p style="margin-top: 20px; color: #01162e;">Check chassis number with our VIN Decoder</p>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-lg-4 d-flex">
          <div class="logo-image">
            <div class="logo"></div>
          </div>
        </div>
        <div class="col-lg-8 text-center">
          <div class="input-container">
            <?php include '_decoder.php' ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="container-fluid mt-2">
    <div class="row">
      <div class="text-col-1">100+ vehicle manufacturers</div>
      <div class="text-col-2">History of 25+ years</div>
      <div class="text-col-3">Tested by experts</div>
    </div>
  </div>




  <div style="justify-content: center;" class="container-fluid d-flex ">
    <div style="width: 100%;" class="services">
      <div class="row">
        <a class="ser-col-1" href="" target="_blank" rel="noopener noreferrer">Sell Your Car</a>
        <a class="ser-col-2" href="" target="_blank" rel="noopener noreferrer">Buy Used Car</a>
        <a class="ser-col-3" href="#vehicleinsurance">Get Car Insurance</a>
        <a class="ser-col-4">Apply for Loan</a>
      </div>
    </div>
  </div>
 
  <div style="width: 70%;margin-top: 5rem; border-bottom: 3px solid black;" class="container text-center">
    <div class="row">
      <div class="col-lg-4">
        <div class="sec2-col">
          <div class="acc-num">4,61,312</div>
          <div class="acc-text">Road accidents reported in India during 2022</div>
          <div class="acc-blog-link"><a style="text-decoration: none;" href="">Learn more about road safety</a></div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="sec2-col">
          <div class="acc-num">1,10,027</div>
          <div class="acc-text">Accidents happened due to over-speed</div>
          <div class="acc-blog-link"><a style="text-decoration: none;" href="">Learn more about risky driving</a></div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="sec2-col">
          <div class="acc-num">1,68,491</div>
          <div class="acc-text">Persons killed in road accidents during 2022</div>
          <div class="acc-blog-link"><a style="text-decoration: none;" href="">Learn more about road safety</a></div>
        </div>
      </div>

    </div>
  </div>


  <?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'components/_dbconnect.php';
    $form = $_POST['form'];

    if ($form == "vehinsenq") {
      $insurance_type = $_POST['insurance_type'];
      $registration_number = $_POST['registration_number'];
      $mobile_number = $_POST['mobile_number'];
      $customer_email = $_POST['customer_email'];

      $sql = "INSERT INTO `vehicleinsenq` (`insurance_type`, `registration_number`, `mobile_number`, `customer_email`, `req_time`) VALUES ('$insurance_type', '$registration_number', '$mobile_number', '$customer_email', current_timestamp());";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() { 
                var successMessage = 'Thankyou for connecting with us. Your request for $insurance_type insurance of $registration_number submitted.';
                document.getElementById('successMessage').innerText = successMessage;
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show(); 
            });
        </script>";
      }

    } elseif ($form == "helinsenq") {
      $customer_name = $_POST['customer_name'];
      $age = $_POST['age'];
      $mobile_number = $_POST['mobile_number'];

      $sql = "INSERT INTO `healthinsenq` (`customer_name`, `age`, `mobile_number`, `req_time`) VALUES ('$customer_name', '$age', '$mobile_number', current_timestamp());";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() { 
                var successMessage = 'Thankyou for connecting with us. Your request for health insurance is submitted.';
                document.getElementById('successMessage').innerText = successMessage;
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show(); 
            });
        </script>";
      }

    }

    
    
}
  
  
  ?>


  <div class="container m-0 p-0 mt-5">
    <div class="ins-sec1" id="vehicleinsurance">
      <h1>Get <b>Affordable</b> and <b>Reliable</b> Insurance Policy:<br>
        Protect Your <i>Car, Family</i> and <i>Life</i></h1>
    </div>
    <div class="fm-sec">
      <form id="vehinsenq" action="home" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="form" value="vehinsenq">
        <div class="ins-cat">
          <div class="ins-tp-opt">
            <input type="radio" name="insurance_type" value="BIKE" id="bike">
            <div class="radio-title">
              <i class="fa-solid fa-motorcycle"></i>
              <label for="bike">Bike</label>
            </div>
          </div>
          <div class="ins-tp-opt">
            <input type="radio" name="insurance_type" value="CAR" id="car">
            <div class="radio-title">
              <i class="fa-solid fa-car-side"></i>
              <label for="car">Car</label>
            </div>
          </div>
          <div class="ins-tp-opt">
            <input type="radio" name="insurance_type" value="CV" id="cv">
            <div class="radio-title">
              <i class="fa-solid fa-truck-pickup"></i>
              <label for="cv">CV</label>
            </div>
          </div>
          <div class="ins-tp-opt">
            <input type="radio" name="insurance_type" value="TRACTOR" id="tractor">
            <div class="radio-title">
              <i class="fa-solid fa-tractor"></i>
              <label for="tractor">Tractor</label>
            </div>
          </div>
        </div>
        <div class="input-sec">
          <div class="inpcon">
            <input type="text" id="registration_number" name="registration_number" placeholder="Registration Number*">
            <div id="reg-error" class="error-message">Invalid registration number.</div>
          </div>
          <div class="inpcon">
            <input type="tel" id="mobile_number_veh" name="mobile_number" placeholder="Mobile number*">
            <div id="mobile-error-veh" class="error-message">Invalid mobile number. It should be 10 digits.</div>
          </div>
          <div class="inpcon">
            <input type="email" id="customer_email" name="customer_email" placeholder="Email*">
            <div id="email-error" class="error-message">Invalid email address.</div>
          </div>
          <button type="submit">Get quote</button>
        </div>
      </form>
    </div>

    

    <div class="ins-sec2">
      <div class="h-ins1" id="healthinsurance">
        <div class="l1">Discover Health & Life Insurance    <strong style="font-size: 24px;">></strong></div>
        <div class="l2">Best Insurance <br>For Your Bright <br>Future</div>
        <div class="l3">Live up your life!, While knowing that your loved ones and <br> you are protected.</div>
        <form id="helinsenq" action="home" method="post" onsubmit="return validateHealthForm()">
          <input type="hidden" name="form" value="helinsenq">
          <div class="inpcon">
            <input type="text" id="customer_name" name="customer_name" placeholder="Your Name*">
            <div id="name-error" class="error-message">Name is required and should only contain alphabets.</div>
          </div>
          <div class="inpcon">
            <input type="number" id="age" name="age" placeholder="Your Age*" min="1" max="60">
            <div id="age-error" class="error-message">Age must be between 1 and 60.</div>
          </div>
          <div class="inpcon">
            <input type="tel" id="mobile_number_health" name="mobile_number" placeholder="Mobile number*">
            <div id="mobile-error-health" class="error-message">Invalid mobile number. It should be 10 digits.</div>
          </div>
          <button type="submit">Get Quote</button>
        </form>
      </div>
      <div class="h-ins2">
        <div class="im"></div>
      </div>
    </div>

    <div class="modal" id="successModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Success</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="successMessage"></p>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div> -->
        </div>
      </div>
    </div>


    <div class="ins-sec3">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/63/SBI_Life_Insurance_Company_Limited.svg/1200px-SBI_Life_Insurance_Company_Limited.svg.png" alt="">
      <img src="https://seeklogo.com/images/D/digit-insurance-logo-8CF7EA3424-seeklogo.com.png" alt="">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Reliance_General_Insurance.svg/1200px-Reliance_General_Insurance.svg.png" alt="">
      <img src="https://iconape.com/wp-content/files/sg/209743/svg/209743.svg" alt="">
      <img src="https://healthysure.in/wp-content/uploads/2023/07/png-clipart-logo-brand-public-relations-product-icici-lombard-travel-insurance-text-public-relations-removebg-preview.png" alt="">
    </div>
    <div class="ins-sec4">
      <div class="serh1">
        <div class="b1">
          <img src="https://smcinsurance.com/SocialImages/PillarImages/Motor/Nov-2023/third-party-insurance.jpg" alt="">
          <div class="l1">Third-Party Cover</div>
          <div class="l2">Covers third-party injury and property damage</div>
        </div>
        <div class="b1">
          <img src="https://im.rediff.com/getahead/2016/nov/04carinsurance.jpg?w=670&h=900" alt="">
          <div class="l1">Own Damage Cover</div>
          <div class="l2">Comprehensive or own-damage provides coverage for the loss incurred by the insured four-wheeler</div>
        </div>
        <div class="b1">
          <img src="https://smcinsurance.com/SocialImages/2024/February/zero-depreciation-add-on-for-car-insurance.jpg" alt="">
          <div class="l1">Car Insurance Add-ons</div>
          <div class="l2">A number of add ons available like zero depreciation </div>
        </div>
        <div class="b1">
          <img src="https://images.pexels.com/photos/7140013/pexels-photo-7140013.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
          <div class="l1">Personal Accident Cover</div>
          <div class="l2">Up to INR 15 lakhs</div>
        </div>
        
      </div>
      <div class="serh1">
        <div class="b1">
          <img src="https://navi.com/blog/wp-content/uploads/2022/06/cashless-mediclaim-policy.jpg" alt="">
          <div class="l1">Mediclaim Policy</div>
          <div class="l2">An indemnity product that compensates the policyholder for the costs incurred on the treatment up to the sum assured</div>
        </div>
        <div class="b1">
          <img src="https://images.pexels.com/photos/4021775/pexels-photo-4021775.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
          <div class="l1">Health Insurance</div>
          <div class="l2">A benefit product that provides a lump sum amount to the insured as specified in the policy</div>
        </div>
        <div class="b1">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7iUsEGI0wCr7TmORjS5PnqRdb4iHGn6skAg&s" alt="">
          <div class="l1">Health Suraksha</div>
          <div class="l2">Hospital daily allowance for senior citizens, Sum insured recharge benefit </div>
        </div>
        <div class="b1">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT53poW8YWU8QxJRvXK01MzEOwALz_5jCqJdw&s" alt="">
          <div class="l1">Care Plan</div>
          <div class="l2">Wide range of coverage variants to get the best fit, Free annual health check-ups</div>
        </div>
        
      </div>
    </div>
    <div class="ins-sec5">
      <div class="is5-s1">
        <div class="l1">Together we can build a healthier world</div>
        <div class="l2">let's build a healthier world with us, get a right health insurance plans for your family. A health insurance policy, therefore, covers your medical expenses and gives you financial relief.</div>
        <a href="#customer_name">Get Health Insurance</a>
      </div>
      <div class="is5-s2"></div>
    </div>
    
    

  </div>

  <?php include 'components/_footer.php' ?>







  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

    <script>
      function validateForm() {
        var isValid = true;

        // Validate Registration Number
        var regNumber = document.getElementById("registration_number").value;
        var regError = document.getElementById("reg-error");
        var regPattern = /^[A-Za-z]{2}[0-9]{2}[A-Za-z]{1,2}[0-9]{1,4}$/;
        if (!regPattern.test(regNumber)) {
          regError.style.display = "block";
          isValid = false;
        } else {
          regError.style.display = "none";
        }

        // Validate Mobile Number
        var mobileNumber = document.getElementById("mobile_number_veh").value;
        var mobileError = document.getElementById("mobile-error-veh");
        if (!/^[0-9]{10}$/.test(mobileNumber)) {
          mobileError.style.display = "block";
          isValid = false;
        } else {
          mobileError.style.display = "none";
        }

        // Validate Email
        var email = document.getElementById("customer_email").value;
        var emailError = document.getElementById("email-error");
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
          emailError.style.display = "block";
          isValid = false;
        } else {
          emailError.style.display = "none";
        }

        return isValid;
      }
    </script>

<script>
    function validateHealthForm() {
      var isValid = true;

      // Validate Name
      var name = document.getElementById("customer_name").value;
      var nameError = document.getElementById("name-error");
      var namePattern = /^[A-Za-z\s]+$/;
      if (!namePattern.test(name)) {
        nameError.style.display = "block";
        isValid = false;
      } else {
        nameError.style.display = "none";
      }

      // Validate Age
      var age = document.getElementById("age").value;
      var ageError = document.getElementById("age-error");
      if (age < 1 || age > 60) {
        ageError.style.display = "block";
        isValid = false;
      } else {
        ageError.style.display = "none";
      }

      // Validate Mobile Number
      var mobileNumber = document.getElementById("mobile_number_health").value;
      var mobileError = document.getElementById("mobile-error-health");
      if (!/^[0-9]{10}$/.test(mobileNumber)) {
        mobileError.style.display = "block";
        isValid = false;
      } else {
        mobileError.style.display = "none";
      }

      return isValid;
    }
  </script>


</body>

</html>