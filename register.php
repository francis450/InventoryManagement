<?php
ob_start();
   session_start();
include('connection.php');



if(isset($_POST['username'])){
   $username =  $_POST['username'];
   $password =  md5($_POST['password']);
   $fname =  $_POST['fname'];
   $lname =  $_POST['lname'];
   $phone =  $_POST['phone'];
   $email =  $_POST['email'];
   
   $file=$_FILES['receipt']['tmp_name'];
		
	$receipt= addslashes(file_get_contents($_FILES['receipt']['tmp_name']));
		$receipt_name= addslashes($_FILES['receipt']['name']);
		move_uploaded_file($_FILES["receipt"]["tmp_name"],"users/" . $_FILES["receipt"]["name"]);
		$location="users/" . $_FILES["receipt"]["name"];
		
   
   
$res = mysqli_query($con,"INSERT INTO users(fname,lname,phone,email,username,password,photo)values('$fname','$lname','$phone','$email','$username','$password','$location')");
/*
$to = $email;
$subject = "Account Activation";
$txt = 'http://store.romtecxtechnologies.com/confirm.php?code='.$code.'&email='.$email;
$headers = "From: Romtecx Inc" . "\r\n" .
"CC: warukenya@gmail.com.com";


$ress = mail($to,$subject,$txt,$headers);*/
                    
    if($res) {
                       //$msg ="An email with a code has been sent to ".$email." follow the link to activate your acount";
					   echo "<script>location.replace('index.php')</script>";
                    } else {
                      echo mysqli_error($con);
                       
                  
                    }
}else{
    
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
	<script src="jquery-3.3.1.min"></script>
	<script>
	$(document).ready(function(){});
	</script>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <h2 class="text-center mb-4">Register</h2>
              <div class="auto-form-wrapper">
                <form action="#" method="POST"  enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="first name" name="fname" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="last name" name="lname" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Username" name="username" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="phone" name="phone" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				   <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="email" name="email" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" class="form-control" placeholder="Password" name="password" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" class="form-control" placeholder="Confirm Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  
				  
				   <div class="form-row">
                             <div class="input-group">
                              
                              <!--<input type="file" class="form-control" id="receipt" name="receipt" required>-->
							  <div class="input-group-append">
									<span class="input-group-text">
									  <i class="mdi mdi-check-circle-outline"></i>
									</span>
								  </div>
                            </div>
                         
                    </div>
                  <div class="form-group d-flex justify-content-center">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> I agree to the terms </label>
                    </div>
                  </div>
				  
				  <div class="form-group d-flex justify-content-center">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                  
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Already have and account ?</span>
                    <a href="index.php" class="text-black text-small">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../assets/js/shared/off-canvas.js"></script>
    <script src="../../assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <script src="../../assets/js/shared/jquery.cookie.js" type="text/javascript"></script>
  </body>
</html>