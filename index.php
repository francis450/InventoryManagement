<?php
session_start();
ob_start();

require_once 'config.php';
require_once 'init.php';

$file = "settings/db.txt";

$host = 'localhost';

$company = file_get_contents("settings/company.txt");
if (!$company) {
  echo "NO COMPANY NAME";
}
$shop['name'] = $company;
$shop['exp'] = '2024-09-09 00:00';

$db_config = $config['db'];

// $con = new PDO("mysql:host={$db_config['host']};dbname={$db_config['password']}", $db_config['username'], $db_config['password']);
// $con = mysqli_connect($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if (isset($_GET['email'])) {
  $user =  $_GET['email'];
  $pass =  md5($_GET['password']);

  // check if email and password match using pdo connection
  $pdo = 

  // $res = mysqli_query($con, "SELECT *  FROM users WHERE username = '$user'  AND password = '$pass' AND isactive = '1'");

  if (mysqli_num_rows($res) <= 0) {
    $msg = "You are not registered";
    // $activity = "login";
    // $role="Uknown";
    // mysqli_query($con,"insert into logs(user,activity,role)values('$user','$activity','$role')");
  } else {
    $timed = date('d/m/Y h:i:sa');
    mysqli_query($con, "insert into logins(user,timed)values('$user','$timed')");
    $ress = mysqli_fetch_array($res);
    $name = $ress['username'];
    $identity = $ress['password'];
    $gg = $ress['isadmin'];
    $_SESSION['valid'] = true;
    $_SESSION['username'] = $name;
    $_SESSION['identity'] = $identity;
    $msg = 'Welcome ' . $username;
    $activity = "login";

    if ($gg == '1') {
      $activity = "login";
      $role = "Admin";
      mysqli_query($con, "insert into logs(user,activity,role)values('$name','$activity','$role')");
      // header("Location: main.php");
      //header("Location: backups-daily.php?id=main");
      header("Location: main.php");
    } else if ($gg == '2') {
      $activity = "login";
      $role = "Assistant Admin";
      mysqli_query($con, "insert into logs(user,activity,role)values('$name','$activity','$role')");
      if (($pos == 'Restaurant') || ($pos == 'Hotel') || ($pos == 'Grocery') || ($pos == 'Liquor')) {
        //header("Location: hotel.php");
        header("Location: backups-daily.php?id=hotel");
      } else {
        //header("Location: sale3.php");
        // header("Location: backups-daily.php?id=sale3");
        header("Location: sale3.php");
      }
    } else {
      $activity = "login";
      $role = "Cashier";
      mysqli_query($con, "insert into logs(user,activity,role)values('$name','$activity','$role')");
      if (($pos == 'Restaurant') || ($pos == 'Hotel') || ($pos == 'Grocery') || ($pos == 'Liquor')) {
        //header("Location: hotel.php");
        header("Location: backups-daily.php?id=hotel2");
      } else {
        //header("Location: sell2.php");
        //  header("Location: backups-daily.php?id=sell2");
        header("Location: sell2.php");
      }
    }
  }
} else {
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>

  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/shared/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <script src="jquery-3.3.1.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.forgot-password').click(function() {
        var getemail = prompt('Enter your registered email adress');
        if (getemail != '') {
          $.post('changepassword.php', {
            getemail: getemail,
          }, function(data) {
            alert(data);
          });
        } else {
          alert('email cant be empty');
        }

      });
    });
  </script>
</head>

<body>
  <style>
    #background-video {
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      z-index: -1;
    }

    label {
      color: #00ffff;
    }
  </style>

  <div class="container-scroller bx" id="bx">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <video id="background-video" autoplay loop muted poster="../../images/auth/vibe.png">
        <source src="assets/images/auth/tr.mp4" type="video/mp4">
      </video>
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="#">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Username" name="email">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" placeholder="*********" name="password">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> Keep me signed in </label>
                  </div>
                  <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                </div>
                <div class="form-group">
                  <button class="btn btn-block g-login">
                    <h1 style="color:#00ffff"><?php echo strtoupper($company); ?></h1>

                </div>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Not a user ?</span>
                  <a href="register.php" class="text-black text-small">Register</a>
                  <hr>
                  <?php
                  // 	$ppr = "settings/exp.txt";
                  // 	$exp = file_get_contents("settings/exp.txt");
                  $exp = $shop['exp'];
                  $startdate = $exp;
                  $date1 = date_create("{$exp}");
                  // $date23=date("Y/m/d h:m:s");
                  $date23 = date("Y-m-d h:m:s");
                  $date2 = date_create("{$date23}");
                  $diff = date_diff($date2, $date1);
                  $check = $diff->format('%d');



                  ?>
                  <span id="showTime" style="color:#00ffff"></span>

                </div>
              </form>

              <script>
                var wks = 1;
                var numdays = wks * 7;

                var d1 = new Date().getTime();
                var d2 = new Date('<?php echo $startdate; ?>').getTime();

                var date1 = new Date();
                var date2 = new Date('<?php echo $startdate; ?>');
                var diffTime = Math.abs(date2 - date1);
                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                console.log(diffTime + " milliseconds");
                console.log(diffDays + " days");

                document.getElementById("showTime").innerHTML = "You have " + diffDays + " days for your subscription to expire";
              </script>
            </div>
            <ul class="auth-footer">
              <li>
                <a href="#" style="color:#00ffff">Conditions</a>
              </li>
              <li>
                <a href="#" style="color:#00ffff">Help</a>
              </li>
              <li>
                <a href="#" style="color:#00ffff">Terms</a>
              </li>
            </ul>


          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js
    <script src="assets/js/shared/off-canvas.js"></script>
    
    
    <script src="../../assets/js/shared/jquery.cookie.js" type="text/javascript"></script>-->



  <!-- scripts -->
  <script src="js/particles.js"></script>
  <script src="js/app.js"></script>

  <!-- stats.js 
<script src="js/lib/stats.js"></script>-->
  <script>
    var count_particles, stats, update;
    stats = new Stats;
    stats.setMode(0);
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0px';
    stats.domElement.style.top = '0px';
    document.body.appendChild(stats.domElement);
    count_particles = document.querySelector('.js-count-particles');
    update = function() {
      stats.begin();
      stats.end();
      if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
        count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
      }
      requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  </script>
</body>

</html>