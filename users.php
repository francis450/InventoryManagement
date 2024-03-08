<?php
session_start();
$userid = $_SESSION['username'];
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}
include('connection.php');
$userdetails = mysqli_query($con,"SELECT * FROM users where username = '$userid'");
 
 if($userdetails){
      while($rowuser = mysqli_fetch_array($userdetails)){
     
      $usename = $rowuser['username'];
	  $userphoto = $rowuser['photo'];
 }
 }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bigbro</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="jquery.dataTables.min.css">
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
    <script src="jquery-3.3.1.min.js"></script>
     <script src="jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
			
			$('.activate').click(function(){
    			var activate = $(this).closest('tr').children('td.user').text();
    			let conf = confirm("Do You Want To Activate "+ activate);
    			if(conf){
    			    $.post('usersedge.php',{activate:activate},function(data){
        				$(".haya").html(data);
        				console.log(data);
        			});
    			}
			});

			$('.suspend').click(function(){
				var suspend = $(this).closest('tr').children('td.user').text();
				let conf = confirm("Do You Want To Suspend "+ suspend);
				if(conf){
				    $.post('usersedge.php',{suspend:suspend},function(data){
					$(".haya").html(data);
    					console.log(data);
    				});
				}
				
			});


			 $('.supri').change(function(){
				  var ha = $(this).val();
				  $.post('getbrands.php',{ha:ha,},function(data){
					  $('.sehemu').html(data);
					  console.log(data);
				  });
			  });
			  
			  $('.makeadmin').click(function(){
				var thisadmin = $(this).closest('tr').children('td.user').text();
				
				$.post('makeadmin.php',{thisadmin:thisadmin},function(data){
					$(".haya").html(data);
					console.log(data);
				});
			});
			
			 $('.assist').click(function(){
				var thisassist = $(this).closest('tr').children('td.user').text();
				
				$.post('makeadmin.php',{thisassist:thisassist},function(data){
					$(".haya").html(data);
					console.log(data);
				});
			})

			$('.suspendadmin').click(function(){
				var suspendadmin = $(this).closest('tr').children('td.user').text();
				
				$.post('makeadmin.php',{suspendadmin:suspendadmin},function(data){
					$(".haya").html(data);
					console.log(data);
				});
			});
			
			$('.pay').click(function(){
				var receiptnum = $(this).val();
				alert(receiptnum);
				
				var amounttopay = prompt("Enter amount the client is payaing");
				if(amounttopay !== null && amounttopay !== '' && receiptnum !== null && receiptnum !== ''){
					   var liz = confirm("Do you want to pay ksh "+amounttopay +' for receipt '+receiptnum+ '?');
					   if(liz){
						   $.post('addpayment.php',{receiptnum:receiptnum,amounttopay:amounttopay,},function(data){$('.res').html(data);})
						  
					   }else{
						   alert("Bye");
					   }
					}else{
						alert("Data Cant be empty");
					}
			
			
			});
              
          
        });
    </script>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="main.html">
            <!--<img class="thumbnail"  height="100px" width="20px" src="<?php echo $userphoto;?>" alt="logo" /> </a>-->
            <?php $company = file_get_contents("settings/company.txt");?>
            <h1><?php echo strtoupper($company);?></h1>
          <a class="navbar-brand brand-logo-mini" href="main.html">
            <img src="images.png" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block"> <?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?></li>
            <li class="nav-item dropdown language-dropdown">
              <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="d-inline-flex mr-0 mr-md-3">
                  <div class="flag-icon-holder">
                    <i class="flag-icon flag-icon-ke"></i>
                  </div>
                </div>
                <span class="profile-text font-weight-medium d-none d-md-block"><?php  echo $userid; ?></span>
              </a>
            </li>
          </ul>
     
          <ul class="navbar-nav ml-auto">
          
            
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="images.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="images.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?php  echo $userid; ?></p>
                  
                </div>
                
                <a class="dropdown-item" href="index.php">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
                  


     		<!--div class="col-md-12 grid-margin stretch-card average-price-card">
                    <div class="card text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 align-items-center">
                          <h3 class="font-weight-semibold mb-0">
						  <?php
						  $pos = file_get_contents("settings/category.txt");	
						   if(($pos=='Restaurant')||($pos=='Hotel')||($pos=='Grocery')||($pos=='Liquor')){
							    echo '<a href="hotel.php" target="_blank">Sell</a>';
						   }else{
                           echo '<a href="sell.php" target="_blank">Sell</a>';
						   }
						  ?>
						  
						  
						  </h3>
                          <div class="icon-holder">
                            <i class="mdi mdi-bell-outline"></i>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="font-weight-semibold mb-0">(Front End)</h5>
                        </div>
                      </div>
                    </div>
                  </div-->




            </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="main.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
           
           
           
			
			
           
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->
            <div class="row page-title-header">
              <div class="col-12">
                <div class="page-header">
                  <h5 class="page-title">The <?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?> </h5>
                  <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                    <ul class="quick-links">
                      <li><h3><a href="#">Welcome back <?php  echo $userid; ?> to the Cockpit, you are in control</a></h3></li>
                      <li><a href="#"><?php echo date('d/m/Y h:i:sa')?> </a></li>
                    
                    </ul>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="page-header-toolbar">
               
                </div>
              </div>
              <div class="col-md-12 grid-margin stretch-card">
			        <div class="card">
					    <div class="card-header">
					        <h5>SUSPENDED</h5>
					    </div>
					    <div class="card-body">
					        <table id="cashier" class="table table-stripe table-hover">
					            <thead>
					                <tr>
                                      <th>Photo</th>
                                       <th>Name</th>
                                       <th>UserName</th>
                                       <th>Phone</th>
                                       <th>Activate</th>
                                    </tr>
					            <tbody>
					                <?php
					                    
                                            $allofthem = mysqli_query($con,"select * from users");
                                        	
                                        	while($userrows = mysqli_fetch_array($allofthem))
                                        	{
                                        	    $thisguyisadmin = $userrows['isadmin'];
												$thisguyisactive = $userrows['isactive'];
												if(($thisguyisactive == 0)){
													echo '<tr>';
													echo '<td><img class="thumbnail" src="images.png"/></td>';
                                        			echo '<td>'.$userrows['fname'].' '.$userrows['lname'].'</td>';
													echo '<td>'.$userrows['username'].'</td>';
                                        			echo '<td class="user">'.$userrows['phone'].'</td>';
                                        			echo '<td class="activate"><button class="btn btn-dark">Activate</button></td>';
                                        		
                                        			echo '</tr>';
												}
                                        	}
					                ?>
					            </tbody>
					        </table>
					    </div>
					</div>
			    </div>
			    <div class="col-md-12 grid-margin stretch-card">
			        <div class="card">
					    <div class="card-header">
					        <h5>ADMINS</h5>
					    </div>
					    <div class="card-body">
					        <table id="admins" class="table table-stripe table-hover">
					            <thead>
					                <tr>
                                      <th>Photo</th>
                                       <th>Name</th>
                                       <th>UserName</th>
                                       <th>Phone</th>
                                       <th>Activate</th>
                                       <th>Suspend</th>
                                       <th>Suspend Admin</th>
                                    </tr>
					            <tbody>
					                <?php
					                    
                                            $all = mysqli_query($con,"select * from users");
                                        	
                                        	while($usersroww = mysqli_fetch_array($all))
                                        	{
                                        	    $thisguyisadmin = $usersroww['isadmin'];
												$thisguyisactive = $usersroww['isactive'];
												if(($thisguyisadmin=='1')&&($thisguyisactive=='1')){
													echo '<tr>';
													echo '<td><img class="thumbnail" src="images.png"/></td>';
                                        			echo '<td>'.$usersroww['fname'].' '.$usersroww['lname'].'(admin)</td>';
													echo '<td>'.$usersroww['username'].'</td>';
                                        			echo '<td class="user">'.$usersroww['phone'].'</td>';
                                        			echo '<td class="activate"><button class="btn btn-dark">Activate</button></td>';
                                        			echo '<td class="suspend"><button class="btn btn-warning">Suspend</button></td>';
													echo '<td class="suspendadmin"><button class="btn btn-danger">Suspend Admin</button></td>';
                                        			echo '</tr>';
												}
                                        	}
					                ?>
					            </tbody>
					        </table>
					    </div>
					</div>
			    </div>
			    <!--CASHIER-->
			    <div class="col-md-12 grid-margin stretch-card">
			        <div class="card">
					    <div class="card-header">
					        <h5>CASHIERS</h5>
					    </div>
					    <div class="card-body">
					        <table id="cashiers" class="table table-stripe table-hover">
					            <thead>
					                <tr>
                                      <th>Photo</th>
                                       <th>Name</th>
                                       <th>UserName</th>
                                       <th>Phone</th>
                                       <th>Suspend</th>
                                       <th>Make Admin</th>
                                    </tr>
					            <tbody>
					                <?php
					                    
                                            $alll = mysqli_query($con,"select * from users");
                                        	
                                        	while($usersrowww = mysqli_fetch_array($alll))
                                        	{
                                        	    $thisguyisadmin = $usersrowww['isadmin'];
												$thisguyisactive = $usersrowww['isactive'];
												if(($thisguyisadmin == 0)&&($thisguyisactive==1)){
													echo '<tr>';
													echo '<td><img class="thumbnail" src="images.png"/></td>';
                                        			echo '<td>'.$usersrowww['fname'].' '.$usersrowww['lname'].'</td>';
													echo '<td>'.$usersrowww['username'].'</td>';
                                        			echo '<td class="user">'.$usersrowww['phone'].'</td>';
                                        			echo '<td class="suspend"><button class="btn btn-warning">Suspend</button></td>';
													echo '<td class="assist"><button class="btn btn-primary">Make Assitant Admin</button></td>';
                                        		
                                        			echo '</tr>';
												}
                                        	}
					                ?>
					            </tbody>
					        </table>
					    </div>
					</div>
			    </div>
			    <!--CASHIER-->
			    
			    <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header"><h5>ALL USERS</h5></div>
                      <div class="card-body">
                        <table class="table table-hover" id="sixth">
                            <thead>
                                <tr>
                                  <th>Photo</th>
                                   <th>Name</th>
                                   <th>UserName</th>
                                   <th>Phone</th>
                                   <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                            $allusers = mysqli_query($con,"select * from users");
                                        	
                                        	while($usersrow = mysqli_fetch_array($allusers))
                                        	{
													echo '<tr>';
													echo '<td><img class="thumbnail" src="images.png"/></td>';
                                        			echo '<td>'.$usersrow['fname'].' '.$usersrow['lname'].'(admin)</td>';
													echo '<td>'.$usersrow['username'].'</td>';
                                        			echo '<td class="user">'.$usersrow['phone'].'</td>';
                                        			echo '<td class="user">'.$usersrow['email'].'</td>';
                                        			echo '</tr>';
                                        			
                                        	}
                                    ?>
                       
                      </tbody>
                        </table>
                        
					  </div>
					  <span class="haya"></span>
					</div>
			    </div>
			</div>
						

 <!-- Page Title Header Ends-->



			
            <div class="row">
            



              <div class="col-md-12">
                <div class="row">
           
               
                  <div class="col-md-7 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Users and Sales</h4>
						
						<?php
						
						$ust = mysqli_query($con,"select user,MAX(timed) as timed from logins group by user");
						while($ustr = mysqli_fetch_array($ust)){
							
							$huyu = $ustr['user'];
							 $gethead = mysqli_query($con,"select *  from users where username='$huyu'");
							 $picc = mysqli_fetch_array($gethead);
							 $pic = $picc['photo'];
							echo '
							 <div class="d-flex mt-3 py-2 border-bottom">
							 
							 
								  <img class="img-sm rounded-circle" src="images.png" alt="profile image">
								  <div class="wrapper ml-2">
									<p class="mb-n1 font-weight-semibold">'.$ustr['user'].'</p>';
									
									$sd = $ustr['user'];
									$getam = mysqli_query($con,"select cashier,SUM(payable) as payy from receipts where cashier = '$sd'");
									$getamr= mysqli_fetch_array($getam);
									echo'<small><b>Ksh '.number_format($getamr['payy'],2).'</b></small></br>';
									echo '
									 <table class="table table-hover" id="'.$sd.'">
									  <thead>
										<tr>
										  
															<th>Date</th>
															<th>Transaction Type</th>
															<th>Amount</th>
															
										</tr>
									  </thead>
									  <tbody>
									';
									   $resulttuy = mysqli_query($con,"select transactiontype,dated,SUM(payable) as todaysales from receipts where cashier ='$sd' group by transactiontype,dated");
												 while($rowuy = mysqli_fetch_array($resulttuy)){
												//echo '<small> Date '.$rowuy['dated'].' :'.$rowuy['transactiontype'].' : Ksh '.number_format($rowuy['todaysales'],2).' </small></br>';
													echo '<tr>';
													echo '<td>'.$rowuy['dated'].'</td>';
													echo '<td>'.$rowuy['transactiontype'].'</td>';
													echo '<td>Ksh '.number_format($rowuy['todaysales'],2).'</td>';
													echo '</tr>';
												}
												
										echo '<tbody></table>';
										
										echo '<script>$("#'.$sd.'").DataTable();</script>';
									
									
								  echo '</div>';
								  
								 
								 
								  echo '<small class="text-muted ml-auto">'.$ustr ['timed'].' <br>'.$picc['phone'].'</small>
								
								</div>
							';
						}
						
						
						
						?>
                       
                      </div>
                    </div>
                  </div>
				  
				  
				   <div class="col-md-5 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Transactions Summary</h4>
						
						<?php
						
						$daa = date("d/m/Y");
                                               $resulttu = mysqli_query($con,"select transactiontype,SUM(payable) as todaysales from receipts where dated ='$daa' group by transactiontype");
						 while($rowu = mysqli_fetch_array($resulttu)){
						
							echo '
							 <div class="d-flex mt-3 py-2 border-bottom">
							 
							 
								  <img class="img-sm rounded-circle" src="money.png" alt="profile image">
								  <div class="wrapper ml-2">
									<p class="mb-n1 font-weight-semibold">'.$rowu['transactiontype'].'</p>';
									
									echo'<small>Ksh '.number_format($rowu['todaysales'],2).'</small>
								  </div>';
								  
								 
								 
								  echo '<small class="text-muted ml-auto">'.$daa.' <br></small>
								
								</div>
							';
						}
						
						
						
						?>
                       
                      </div>
                    </div>
					
					   <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Users and Sales</h4>
						
						<?php
						
						$ust = mysqli_query($con,"select user,MAX(timed) as timed from logins group by user");
						while($ustr = mysqli_fetch_array($ust)){
							
							$huyu = $ustr['user'];
							 $gethead = mysqli_query($con,"select *  from users where username='$huyu'");
							 $picc = mysqli_fetch_array($gethead);
							 $pic = $picc['photo'];
							echo '
							 <div class="d-flex mt-3 py-2 border-bottom">
							 
							 
								  <img class="img-sm rounded-circle" src="images.png" alt="profile image">
								  <div class="wrapper ml-2">
									<p class="mb-n1 font-weight-semibold">'.$ustr['user'].'</p>';
									
									$sd = $ustr['user'];
									$getam = mysqli_query($con,"select cashier,SUM(payable) as payy from receipts where cashier = '$sd'");
									$getamr= mysqli_fetch_array($getam);
									echo'<small><b>Ksh '.number_format($getamr['payy'],2).'</b></small></br>';
									   $resulttuy = mysqli_query($con,"select transactiontype,SUM(payable) as todaysales from receipts where cashier ='$sd' group by transactiontype");
												 while($rowuy = mysqli_fetch_array($resulttuy)){
												echo '<small>'.$rowuy['transactiontype'].' : Ksh '.number_format($rowuy['todaysales'],2).' </small></br>';
													
												}
								  echo '</div>';
								  echo '<small class="text-muted ml-auto">'.$ustr ['timed'].' <br>'.$picc['phone'].'</small>
								</div>
							';
						}
						
						
						
						?>
                       
                      </div>
                    </div>
					
                  </div>
				  
				  
				  
				  
                </div>
              </div>
            </div>
          
              

            
                  




            

                
               

 
            
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
           
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <?php
//setting header to json
//header('Content-Type: application/json');

$dbfile = "settings/db.txt";
$db = file_get_contents("settings/db.txt");

//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'infodata_francis');
define('DB_PASSWORD', 'Franc!s2001');
define('DB_NAME', $db);

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("SELECT SUM(total) as total,SUM(profit) as profit,thisday FROM profits group by thisday");
$query2 = sprintf("SELECT SUM(qnty) as maxp,thisday FROM profits group by thisday");
$query3 = sprintf("SELECT SUM(total) as ttotal,SUM(qnty) as qnty,SUM(profit) as tprofit,thismonth FROM profits group by thismonth");
$query4 = sprintf("SELECT SUM(total) as tytotal,thisday FROM profits group by thisday order by tytotal DESC LIMIT 1");

//execute query
$result = $mysqli->query($query);
$result2 = $mysqli->query($query2);
$result3 = $mysqli->query($query3);
$result4 = $mysqli->query($query4);
//loop through the returned data
$data = array();
$data2 = array();
$data3 = array();
$data4 = array();

$data6 = array();

$data7 = array();
$data8 = array();
$data9 = array();
foreach ($result as $row) {
	$data[] = $row['total'];
	$data2[] = $row['thisday'];
	$data3[] = $row['profit'];
	
}
foreach ($result2 as $rowr) {
	$data4[] = $rowr['thisday'];
	
	$data6[] = $rowr['maxp'];
	
}

foreach ($result3 as $rowrr) {
	$data7[] = $rowrr['qnty'];
	
	$data8[] = $rowrr['thismonth'];
	$data9[] = $rowrr['tprofit'];
	$data10[] = $rowrr['ttotal'];
	
}

foreach ($result4 as $row4rr) {
	$data11[] = $row4rr['tytotal'];	
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
//print json_encode($data);
//print json_encode($data3);
// print  json_encode($data11[0]);
 //print preg_replace("/[^0-9]+/", "", json_encode($data11[0]));
?>

<script>
	  $('#first').DataTable();
          $('#second').DataTable();
          $('#third').DataTable();
          $('#fourth').DataTable();
          $('#fifth').DataTable();
          $('#sixth').DataTable();
           $('#admins').DataTable();
           $('#cashiers').DataTable();
           $('#cashier').DataTable();
	</script>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="assets/js/shared/off-canvas.js"></script>
    <script src="assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
   <!-- <script src="assets/js/demo_1/dashboard.js">-->
    <script>
        (function ($) {
  'use strict';
  $(function () {
    var lineStatsOptions = {
      scales: {
        yAxes: [{
          display: false
        }],
        xAxes: [{
          display: false
        }]
      },
      legend: {
        display: false
      },
      elements: {
        point: {
          radius: 0
        },
        line: {
          tension: 0
        }
      },
      stepsize: 100
    }
    if ($('#sales-statistics-overview').length) {
      var salesChartCanvas = $("#sales-statistics-overview").get(0).getContext("2d");
      var gradientStrokeFill_1 = salesChartCanvas.createLinearGradient(0, 0, 0, 450);
      gradientStrokeFill_1.addColorStop(1, 'rgba(255,255,255, 0.0)');
      gradientStrokeFill_1.addColorStop(0, 'rgba(102,78,235, 0.2)');
      var gradientStrokeFill_2 = salesChartCanvas.createLinearGradient(0, 0, 0, 400);
      gradientStrokeFill_2.addColorStop(1, 'rgba(255, 255, 255, 0.01)');
      gradientStrokeFill_2.addColorStop(0, '#14c671');
      var data_1_1 = <?php echo  json_encode($data3);?>;
      var data_1_2 = <?php echo  json_encode($data);?>;

      var data_2_1 = [130, 145, 155, 60, 75, 65, 130, 110, 145, 149, 170];
      var data_2_2 = [0, 70, 52, 90, 25, 20, 40, 70, 49, 94, 110, 135];

      var data_3_1 = [130, 75, 65, 130, 110, 145, 155, 60, 145, 149, 170];
      var data_3_2 = [0, 70, 52, 94, 110, 135, 90, 25, 20, 40, 70, 49];

      var data_4_1 = [130, 145, 65, 130, 75, 145, 149, 170, 110, 155, 60];
      var data_4_2 = [0, 70, 90, 25, 40, 20, 94, 110, 135, 70, 49, 52];
      var areaData = {
          labels: <?php echo  json_encode($data2);?>,
        //labels: ["Jan 1", "Jan 7", "Jan 14", "Jan 21", "Jan 28", "Feb 4", "Feb 11", "Feb 18"],
        datasets: [{
          label: 'Revenue',
          data: data_1_1,
          borderColor: infoColor,
          backgroundColor: gradientStrokeFill_1,
          borderWidth: 2
        }, {
          label: 'Sales',
          data: data_1_2,
          borderColor: successColor,
          backgroundColor: gradientStrokeFill_2,
          borderWidth: 2
        }]
      };
      var areaOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        elements: {
          point: {
            radius: 3,
            backgroundColor: "#fff"
          },
          line: {
            tension: 0
          }
        },
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        legend: false,
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            console.log(chart.data.datasets[i]); // see what's inside the obj.
            text.push('<li>');
            text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
        scales: {
          xAxes: [{
            display: false,
            ticks: {
              display: false,
              beginAtZero: false
            },
            gridLines: {
              drawBorder: false
            }
          }],
          yAxes: [{
            ticks: {
              max: <?php  print preg_replace("/[^0-9]+/", "", json_encode($data11[0]))?>,
              min: 0,
              stepSize: <?php  $ffu =preg_replace("/[^0-9]+/", "", json_encode($data11[0])); print (int)$ffu/10?>,
              fontColor: "#858585",
              beginAtZero: false
            },
            gridLines: {
              color: '#e2e6ec',
              display: true,
              drawBorder: false
            }
          }]
        }
      }
      var salesChart = new Chart(salesChartCanvas, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
      document.getElementById('sales-statistics-legend').innerHTML = salesChart.generateLegend();

      $("#sales-statistics_switch_1").click(function () {
        var data = salesChart.data;
        data.datasets[0].data = data_1_1;
        data.datasets[1].data = data_1_2;
        salesChart.update();
      });
      $("#sales-statistics_switch_2").click(function () {
        var data = salesChart.data;
        data.datasets[0].data = data_2_1;
        data.datasets[1].data = data_2_2;
        salesChart.update();
      });
      $("#sales-statistics_switch_3").click(function () {
        var data = salesChart.data;
        data.datasets[0].data = data_3_1;
        data.datasets[1].data = data_3_2;
        salesChart.update();
      });
      $("#sales-statistics_switch_4").click(function () {
        var data = salesChart.data;
        data.datasets[0].data = data_4_1;
        data.datasets[1].data = data_4_2;
        salesChart.update();
      });
    }
    if ($("#net-profit").length) {
      var marksCanvas = document.getElementById("net-profit");
      var marksData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
        datasets: [{
          label: "Sales",
          backgroundColor: 'rgba(88, 208, 222,0.8)',
          borderColor: 'rgba(88, 208, 222,0.8)',
          borderWidth: 0,
          fill: true,
          radius: 0,
          pointRadius: 0,
          pointBorderWidth: 0,
          pointBackgroundColor: 'rgba(88, 208, 222,0.8)',
          pointHoverRadius: 10,
          pointHitRadius: 5,
          data: [54, 45, 60, 70, 54, 75, 60, 54]
        }, {
          label: "Orders",
          backgroundColor: 'rgba(150, 77, 247,1)',
          borderColor: 'rgba(150, 77, 247,1)',
          borderWidth: 0,
          fill: true,
          radius: 0,
          pointRadius: 0,
          pointBorderWidth: 0,
          pointBackgroundColor: 'rgba(150, 77, 247,1)',
          pointHoverRadius: 10,
          pointHitRadius: 5,
          data: [65, 75, 70, 80, 60, 80, 36, 60]
        }]
      };

      var chartOptions = {
        scale: {
          ticks: {
            beginAtZero: true,
            min: 0,
            max: 100,
            stepSize: 20,
            display: false,
          },
          pointLabels: {
            fontSize: 14
          },
          angleLines: {
            color: '#e9ebf1'
          },
          gridLines: {
            color: "#e9ebf1"
          }
        },
        legend: false,
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            console.log(chart.data.datasets[i]); // see what's inside the obj.
            text.push('<li>');
            text.push('<span style="background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
      };

      var radarChart = new Chart(marksCanvas, {
        type: 'radar',
        data: marksData,
        options: chartOptions
      });
      document.getElementById('net-profit-legend').innerHTML = radarChart.generateLegend();
    }
    if ($('#total-revenue').length) {
      var ctx = document.getElementById('total-revenue').getContext("2d");
      var data = {
        labels: <?php echo  json_encode($data2);?>,
        datasets: [{
          label: 'Total Revenue',
          data: <?php echo  json_encode($data3);?>,
          borderColor: '#9B86F1',
          backgroundColor: '#f2f2ff',
          borderWidth: 3,
          fill: 'origin'
        }]
      };
      var lineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
          scales: {
            yAxes: [{
              display: false
            }],
            xAxes: [{
              display: false
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            },
            line: {
              tension: 0
            }
          },
          stepsize: 100
        }
      });
    }
    if ($('#total-transaction').length) {
      var ctx = document.getElementById('total-transaction').getContext('2d');
      var gradientStrokeFill_1 = ctx.createLinearGradient(0, 100, 200, 0);
      gradientStrokeFill_1.addColorStop(0, '#fa5539');
      gradientStrokeFill_1.addColorStop(1, '#fa3252');
      var areaData = {
        labels: <?php echo  json_encode($data4);?>,
        datasets: [{
          label: 'Number of products',
          data: <?php echo  json_encode($data6);?>,
          backgroundColor: gradientStrokeFill_1,
          borderColor: '#fa394e',
          borderWidth: 0,
          pointBackgroundColor: "#fa394e",
          pointRadius: 7,
          pointBorderWidth: 3,
          pointBorderColor: '#fff',
          pointHoverRadius: 7,
          pointHoverBackgroundColor: "#fa394e",
          pointHoverBorderColor: "#fa394e",
          pointHoverBorderWidth: 2,
          pointHitRadius: 7,
        }]
      };
      var areaOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        elements: {
          point: {
            radius: 0
          }
        },
        layout: {
          padding: {
            left: -10,
            right: 0,
            top: 0,
            bottom: -10
          }
        },
        legend: false,
        scales: {
          xAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              display: false
            }
          }],
          yAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              display: false
            }
          }]
        }
      }
      var revenueChart = new Chart(ctx, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
    }
    if ($("#market-overview-chart").length) {
      var MarketingChartCanvas = $("#market-overview-chart").get(0).getContext("2d");
      var Marketing_data_1_1 = <?php echo  json_encode($data7);?>;
      var Marketing_data_1_2 = <?php echo  json_encode($data9);?>;
      var Marketing_data_1_3 = <?php echo  json_encode($data10);?>;
      

      var Marketing_data_2_1 = [125, 138, 108, 193, 102, 200, 290, 204];
      var Marketing_data_2_2 = [330, 380, 230, 400, 309, 430, 340, 310];
      var Marketing_data_2_3 = [375, 440, 284, 450, 386, 480, 400, 365];
      var Marketing_data_2_4 = [425, 480, 324, 490, 426, 520, 440, 405];

      var Marketing_data_1_1 = [145, 238, 148, 293, 242, 235, 256, 334];
      var Marketing_data_1_2 = [330, 380, 230, 400, 309, 430, 340, 310];
      var Marketing_data_1_3 = [375, 440, 284, 450, 386, 480, 400, 365];
      var Marketing_data_1_4 = [425, 480, 324, 490, 426, 520, 440, 405];

      var MarketingChart = new Chart(MarketingChartCanvas, {
        type: 'bar',
        data: {
          labels: <?php echo  json_encode($data8);?>,
          datasets: [{
              label: 'Qnty Sold',
              data: Marketing_data_1_1,
              backgroundColor: '#826af9',
              borderColor: '#826af9',
              borderWidth: 0
            }, {
              label: 'Profits',
              data: Marketing_data_1_2,
              backgroundColor: '#9e86ff',
              borderColor: '#9e86ff',
              borderWidth: 0
            },
            {
              label: 'Sales',
              data: Marketing_data_1_3,
              backgroundColor: '#d0aeff',
              borderColor: '#d0aeff',
              borderWidth: 0
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                max: 400,
                display: true,
                beginAtZero: true,
                fontColor: "#212529",
                stepSize: 100
              },
              gridLines: {
                display: false,
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true,
                fontColor: "#212529"
              },
              gridLines: {
                color: "#e9ebf1",
                display: true
              },
              barPercentage: 0.2
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          }
        }
      });
      $("#market-overview_1").click(function () {
        var data = MarketingChart.data;
        data.datasets[0].data = Marketing_data_1_1;
        data.datasets[1].data = Marketing_data_1_2;
        data.datasets[2].data = Marketing_data_1_2;
        data.datasets[3].data = Marketing_data_1_2;
        MarketingChart.update();
      });
      $("#market-overview_2").click(function () {
        var data = MarketingChart.data;
        data.datasets[0].data = Marketing_data_2_1;
        data.datasets[1].data = Marketing_data_2_2;
        data.datasets[2].data = Marketing_data_2_2;
        data.datasets[3].data = Marketing_data_2_2;
        MarketingChart.update();
      });
      $("#market-overview_3").click(function () {
        var data = MarketingChart.data;
        data.datasets[0].data = Marketing_data_3_1;
        data.datasets[1].data = Marketing_data_3_2;
        data.datasets[2].data = Marketing_data_3_2;
        data.datasets[3].data = Marketing_data_3_2;
        MarketingChart.update();
      });
    }
    if ($("#realtime-statistics").length) {
      var realtimeChartCanvas = $("#realtime-statistics").get(0).getContext("2d");
      var realtimeChart = new Chart(realtimeChartCanvas, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: 'Profit',
              data: [330, 380, 230, 400, 309, 530, 340],
              backgroundColor: "#0f5bff",
              borderColor: '#0f5bff',
              borderWidth: 0
            },
            {
              label: 'Target',
              data: [600, 600, 600, 600, 600, 600, 600],
              backgroundColor: '#e5e9f2',
              borderColor: '#e5e9f2',
              borderWidth: 0
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 25,
              top: 0,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              display: false,
              gridLines: {
                display: false
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                display: false,
                beginAtZero: true,
                fontColor: "#354168"
              },
              gridLines: {
                color: "rgba(0, 0, 0, 0)",
                display: false
              },
              barPercentage: 0.5,
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          }
        }
      });
    }
    if ($("#dashboard-vmap").length) {
      $('#dashboard-vmap').vectorMap({
        map: 'world_mill_en',
        panOnDrag: true,
        backgroundColor: 'transparent',
        focusOn: {
          x: 0.5,
          y: 0.5,
          scale: 1,
          animate: true
        },
        series: {
          regions: [{
            scale: ['#2d99ff'],
            normalizeFunction: 'polynomial',
            values: {
              "AF": 16.63,
              "AL": 11.58,
              "DZ": 158.97,
              "AO": 85.81,
              "AG": 1.1,
              "AR": 351.02,
              "AM": 8.83,
              "AU": 1219.72,
              "AT": 366.26,
              "AZ": 52.17,
              "BS": 7.54,
              "BH": 21.73,
              "BD": 105.4,
              "BB": 3.96,
              "BY": 52.89,
              "BE": 461.33,
              "BZ": 1.43,
              "BJ": 6.49,
              "BT": 1.4,
              "BO": 19.18,
              "BA": 16.2,
              "BW": 12.5,
              "BR": 2023.53,
              "BN": 11.96,
              "BG": 44.84,
              "BF": 8.67,
              "BI": 1.47,
              "KH": 11.36,
              "CM": 21.88,
              "CA": 1563.66,
              "CV": 1.57,
              "CF": 2.11,
              "TD": 7.59,
              "CL": 199.18,
              "CN": 5745.13,
              "CO": 283.11,
              "KM": 0.56,
              "CD": 12.6,
              "CG": 11.88,
              "CR": 35.02,
              "CI": 22.38,
              "HR": 59.92,
              "CY": 22.75,
              "CZ": 195.23,
              "DK": 304.56,
              "DJ": 1.14,
              "DM": 0.38,
              "DO": 50.87,
              "EC": 61.49,
              "EG": 216.83,
              "SV": 21.8,
              "GQ": 14.55,
              "ER": 2.25,
              "EE": 19.22,
              "ET": 30.94,
              "FJ": 3.15,
              "FI": 231.98,
              "FR": 2555.44,
              "GA": 12.56,
              "GM": 1.04,
              "GE": 11.23,
              "DE": 3305.9,
              "GH": 18.06,
              "GR": 305.01,
              "GD": 0.65,
              "GT": 40.77,
              "GN": 4.34,
              "GW": 0.83,
              "GY": 2.2,
              "HT": 6.5,
              "HN": 15.34,
              "HK": 226.49,
              "HU": 132.28,
              "IS": 12.77,
              "IN": 1430.02,
              "ID": 695.06,
              "IR": 337.9,
              "IQ": 84.14,
              "IE": 204.14,
              "IL": 201.25,
              "IT": 2036.69,
              "JM": 13.74,
              "JP": 5390.9,
              "JO": 27.13,
              "KZ": 129.76,
              "KE": 32.42,
              "KI": 0.15,
              "KR": 986.26,
              "KW": 117.32,
              "KG": 4.44,
              "LA": 6.34,
              "LV": 23.39,
              "LB": 39.15,
              "LS": 1.8,
              "LR": 0.98,
              "LY": 77.91,
              "LT": 35.73,
              "LU": 52.43,
              "MK": 9.58,
              "MG": 8.33,
              "MW": 5.04,
              "MY": 218.95,
              "MV": 1.43,
              "ML": 9.08,
              "MT": 7.8,
              "MR": 3.49,
              "MU": 9.43,
              "MX": 1004.04,
              "MD": 5.36,
              "MN": 5.81,
              "ME": 3.88,
              "MA": 91.7,
              "MZ": 10.21,
              "MM": 35.65,
              "NA": 11.45,
              "NP": 15.11,
              "NL": 770.31,
              "NZ": 138,
              "NI": 6.38,
              "NE": 5.6,
              "NG": 206.66,
              "NO": 413.51,
              "OM": 53.78,
              "PK": 174.79,
              "PA": 27.2,
              "PG": 8.81,
              "PY": 17.17,
              "PE": 153.55,
              "PH": 189.06,
              "PL": 438.88,
              "PT": 223.7,
              "QA": 126.52,
              "RO": 158.39,
              "RU": 1476.91,
              "RW": 5.69,
              "WS": 0.55,
              "ST": 0.19,
              "SA": 434.44,
              "SN": 12.66,
              "RS": 38.92,
              "SC": 0.92,
              "SL": 1.9,
              "SG": 217.38,
              "SK": 86.26,
              "SI": 46.44,
              "SB": 0.67,
              "ZA": 354.41,
              "ES": 1374.78,
              "LK": 48.24,
              "KN": 0.56,
              "LC": 1,
              "VC": 0.58,
              "SD": 65.93,
              "SR": 3.3,
              "SZ": 3.17,
              "SE": 444.59,
              "CH": 522.44,
              "SY": 59.63,
              "TW": 426.98,
              "TJ": 5.58,
              "TZ": 22.43,
              "TH": 312.61,
              "TL": 0.62,
              "TG": 3.07,
              "TO": 0.3,
              "TT": 21.2,
              "TN": 43.86,
              "TR": 729.05,
              "TM": 0,
              "UG": 17.12,
              "UA": 136.56,
              "AE": 239.65,
              "GB": 2258.57,
              "US": 14624.18,
              "UY": 40.71,
              "UZ": 37.72,
              "VU": 0.72,
              "VE": 285.21,
              "VN": 101.99,
              "YE": 30.02,
              "ZM": 15.69,
              "ZW": 5.57
            }
          }]
        }
      });
    }
    if ($('#stats-line-graph-1').length) {
      var lineChartCanvas = $("#stats-line-graph-1").get(0).getContext("2d");
      var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(0, 0, 0, 50);
      gradientStrokeFill_1.addColorStop(0, 'rgba(131, 144, 255, 0.5)');
      gradientStrokeFill_1.addColorStop(1, '#fff');
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
          labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
          datasets: [{
            label: 'Profit',
            data: [7, 6, 9, 7, 8, 6, 8, 5, 7, 8, 6, 7, 7],
            borderColor: '#6d7cfc',
            backgroundColor: gradientStrokeFill_1,
            borderWidth: 3,
            fill: true
          }]
        },
        options: lineStatsOptions
      });
    }
    if ($('#stats-line-graph-2').length) {
      var lineChartCanvas = $("#stats-line-graph-2").get(0).getContext("2d");
      var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(0, 0, 0, 50);
      gradientStrokeFill_1.addColorStop(0, 'rgba(131, 144, 255, 0.5)');
      gradientStrokeFill_1.addColorStop(1, '#fff');
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
          labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
          datasets: [{
            label: 'Profit',
            data: [7, 6, 8, 5, 7, 8, 6, 7, 7, 6, 9, 7, 8],
            borderColor: '#6d7cfc',
            backgroundColor: gradientStrokeFill_1,
            borderWidth: 3,
            fill: true
          }]
        },
        options: lineStatsOptions
      });
    }
    if ($('#stats-line-graph-3').length) {
      var lineChartCanvas = $("#stats-line-graph-3").get(0).getContext("2d");
      var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(0, 0, 0, 50);
      gradientStrokeFill_1.addColorStop(0, 'rgba(131, 144, 255, 0.5)');
      gradientStrokeFill_1.addColorStop(1, '#fff');
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
          labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
          datasets: [{
            label: 'Profit',
            data: [8, 6, 7, 8, 5, 7, 9, 7, 8, 7, 6, 7, 6],
            borderColor: '#6d7cfc',
            backgroundColor: gradientStrokeFill_1,
            borderWidth: 3,
            fill: true
          }]
        },
        options: lineStatsOptions
      });
    }
    if ($('#stats-line-graph-4').length) {
      var lineChartCanvas = $("#stats-line-graph-4").get(0).getContext("2d");
      var gradientStrokeFill_1 = lineChartCanvas.createLinearGradient(0, 0, 0, 50);
      gradientStrokeFill_1.addColorStop(0, 'rgba(131, 144, 255, 0.5)');
      gradientStrokeFill_1.addColorStop(1, '#fff');
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
          labels: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7", "Day 8", "Day 9", "Day 10", "Day 11", "Day 12", "Day 13"],
          datasets: [{
            label: 'Profit',
            data: [7, 6, 8, 5, 8, 6, 8, 7, 8, 6, 9, 7, 7],
            borderColor: '#6d7cfc',
            backgroundColor: gradientStrokeFill_1,
            borderWidth: 3,
            fill: true
          }]
        },
        options: lineStatsOptions
      });
    }
    if ($('#dashboard-guage-chart').length) {
      var g3 = new JustGage({
        id: 'dashboard-guage-chart',
        value: 65,
        min: 0,
        max: 100,
        symbol: '%',
        pointer: true,
        gaugeWidthScale: 1,
        customSectors: [{
          color: '#ff0000',
          lo: 50,
          hi: 100
        }, {
          color: '#00ff00',
          lo: 0,
          hi: 50
        }],
        counter: true
      });
    }
  });
})(jQuery);
    </script>
    <!-- End custom js for this page-->
    <!--<script src="assets/js/shared/jquery.cookie.js" type="text/javascript"></script>-->
	
  </body>
</html>