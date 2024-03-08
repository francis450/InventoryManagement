<?php
session_start();
$userid = $_SESSION['username'];
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}
include('connection.php');
if(isset($_POST['suppliername'])&&isset($_POST['supplieremail'])&&isset($_POST['supplierphone'])&&isset($_POST['supplieraccount'])&&isset($_POST['supplieraddress'])){
    $supplier = $_POST['suppliername'];
    $email = $_POST['supplieremail'];
    $phone = $_POST['supplierphone'];
    $account = $_POST['supplieraccount'];
    $address = $_POST['supplieraddress'];
    $suppliercode = $email.$phone;
    $uiy = date('Y-m-d H:i:s');
    $long = strtotime($uiy);
    
        $file=$_FILES['img']['tmp_name'];
		$receipt= addslashes(file_get_contents($_FILES['img']['tmp_name']));
		$receipt_name= addslashes($_FILES['img']['name']);
		move_uploaded_file($_FILES["img"]["tmp_name"],"suppliers/" . $_FILES["img"]["name"]);
		$location="suppliers/" . $_FILES["img"]["name"];

    $supplierid = rand(1000,100000) + $long;
     $addsupplier= mysqli_query($con,"insert into suppliers(supplier,email,phone,account,address,suppliercode,supplierid,location)values('$supplier','$email','$phone','$account','$address','$suppliercode','$supplierid','$location')");
     if($addsupplier){
         echo $supplier. " added successifully";
		 $user = $_SESSION['username'];
								$activity = "Added Supplier: ".$supplier.", Contact ".$phone;
						   $role="Admin";
						   mysqli_query($con,"insert into logs(user,activity,role)values('$user','$activity','$role')");
     }else{
         echo mysqli_error($con);
     }
    
}


?>

 <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/icheck/skins/all.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <!--  <div class="col-md-6 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Default form</h4>
                        <p class="card-description"> Basic form layout </p>
                        <form class="forms-sample">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                          </div>
                          <button type="submit" class="btn btn-success mr-2">Submit</button>
                          <button class="btn btn-light">Cancel</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Horizontal Form</h4>
                        <p class="card-description"> Horizontal form layout </p>
                        <form class="forms-sample">
                          <div class="form-group row">
                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                            </div>
                          </div>
                          <button type="submit" class="btn btn-success mr-2">Submit</button>
                          <button class="btn btn-light">Cancel</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>-->
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Suppliers</h4>
                    <p class="card-description"> Add a new supplier </p>
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Supplier Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" name ="suppliername" placeholder="Name" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Supplier Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" name="supplieremail" placeholder="Email" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Supplier Phone Number</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" name="supplierphone" placeholder="Phone" required>
                      </div>
                      <div class="form-group">
                        <label>Supplier Image</label>
                        <input type="file" name="img" class="form-control">
                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Address</label>
                        <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location" name="supplieraddress" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Supplier Payment / Account details</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="2" name="supplieraccount" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
              <script>
                let inactivityTimer;
                const inactivityTime = 60 * 1000; // 2 minutes in milliseconds
            
                function resetInactivityTimer() {
                  clearTimeout(inactivityTimer); // Clear the previous timer
                  inactivityTimer = setTimeout(closeTab, inactivityTime); // Set a new timer
                }
            
                function closeTab() {
                  // Close the tab (will only work if the tab was opened by a script)
                  window.close();
            
                  // Alternatively, you can redirect the user to a different page
                  // window.location.href = 'closing-page.html';
                }
            
                // Add event listeners to reset the inactivity timer on user interaction
                window.addEventListener('mousemove', resetInactivityTimer);
                window.addEventListener('keydown', resetInactivityTimer);
                window.addEventListener('click', resetInactivityTimer);
              </script>
              <!--
              <div class="col-md-5 d-flex align-items-stretch">
                <div class="row flex-grow">
                  <div class="col-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Basic input groups</h4>
                        <p class="card-description"> Basic bootstrap input groups </p>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                              <span class="input-group-text">.00</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">$</span>
                            </div>
                            <div class="input-group-prepend">
                              <span class="input-group-text">0.00</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Colored input groups</h4>
                        <p class="card-description"> Input groups with colors </p>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend bg-info">
                              <span class="input-group-text bg-transparent">
                                <i class="mdi mdi-shield-outline text-white"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="colored-addon1">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend bg-primary border-primary">
                              <span class="input-group-text bg-transparent">
                                <i class="mdi mdi mdi-menu text-white"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="colored-addon2">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="colored-addon3">
                            <div class="input-group-append bg-primary border-primary">
                              <span class="input-group-text bg-transparent">
                                <i class="mdi mdi-menu text-white"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend bg-primary border-primary">
                              <span class="input-group-text bg-transparent text-white">$</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append bg-primary border-primary">
                              <span class="input-group-text bg-transparent text-white">.00</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Input size</h4>
                    <p class="card-description"> This is the default bootstrap form layout </p>
                    <div class="form-group">
                      <label>Large input</label>
                      <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label>Default input</label>
                      <input type="text" class="form-control" placeholder="Username" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label>Small input</label>
                      <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username">
                    </div>
                  </div>
                  <div class="card-body">
                    <h4 class="card-title">Selectize</h4>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Large select</label>
                      <select class="form-control form-control-lg" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Default select</label>
                      <select class="form-control" id="exampleFormControlSelect2">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect3">Small select</label>
                      <select class="form-control form-control-sm" id="exampleFormControlSelect3">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Checkbox Controls</h4>
                    <p class="card-description">Checkbox and radio controls</p>
                    <form class="forms-sample">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"> Default </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked> Checked </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" disabled> Disabled </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" disabled checked> Disabled checked </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="" checked> Option one </label>
                            </div>
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2"> Option two </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="form-radio disabled">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios3" value="option3" disabled> Option three is disabled </label>
                            </div>
                            <div class="form-radio disabled">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optionsRadio2" id="optionsRadios4" value="option4" disabled checked> Option four is selected and disabled </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Checkbox Flat Controls</h4>
                    <p class="card-description">Checkbox and radio controls with flat design</p>
                    <form class="forms-sample">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-check form-check-flat">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"> Default </label>
                            </div>
                            <div class="form-check form-check-flat">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked> Checked </label>
                            </div>
                            <div class="form-check form-check-flat">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" disabled> Disabled </label>
                            </div>
                            <div class="form-check form-check-flat">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" disabled checked> Disabled checked </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="form-radio form-radio-flat">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="flatRadios1" id="flatRadios1" value="" checked> Option one </label>
                            </div>
                            <div class="form-radio form-radio-flat">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="flatRadios2" id="flatRadios2" value="option2"> Option two </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="form-radio form-radio-flat disabled">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="flatRadios3" id="flatRadios3" value="option3" disabled> Option three is disabled </label>
                            </div>
                            <div class="form-radio form-radio-flat disabled">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="flatRadios4" id="flatRadios4" value="option4" disabled checked> Option four is selected and disabled </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Horizontal Two column</h4>
                    <form class="form-sample">
                      <p class="card-description"> Personal info </p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-9">
                              <select class="form-control">
                                <option>Male</option>
                                <option>Female</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date of Birth</label>
                            <div class="col-sm-9">
                              <input class="form-control" placeholder="dd/mm/yyyy" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                              <select class="form-control">
                                <option>Category1</option>
                                <option>Category2</option>
                                <option>Category3</option>
                                <option>Category4</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Membership</label>
                            <div class="col-sm-4">
                              <div class="form-radio">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked> Free </label>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-radio">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2"> Professional </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <p class="card-description"> Address </p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Address 1</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Address 2</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Postcode</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                              <select class="form-control">
                                <option>America</option>
                                <option>Italy</option>
                                <option>Russia</option>
                                <option>Britain</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>-->