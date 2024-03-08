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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BigbroPOS</title>
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <script src="jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <!--<link rel="stylesheet" href="jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    
    <!--BOOTSTRAP5-->
    <link rel="stylesheet" href="bootstrap-5.0.2/css/bootstrap.min.css"/>
    <script src="bootstrap-5.0.2/js/bootstrap.min.js"></script>
    
     <!--<script src="jquery.dataTables.min.js"></script>-->
	<style>
    	 .mine{
    	  background-color:#054986 !important;
          }
        	.pw_prompt {
            position:fixed;
            left: 50%;
            top:50%;
            margin-left:-100px;
            padding:15px;
            width:400px;
            border:1px solid black;
        	background-color:#054986;
        	color:white;
        	
        }
        .pw_prompt label {
            display:block; 
            margin-bottom:5px;
        }
        .pw_prompt input {
            margin-bottom:10px;
        }
	</style>
    <script>
        $(document).ready(function(){
			
			setInterval(function(){
        		  location.replace('index.php');
        	  },6000*60*10);
	        $('.totalvalue').hide();
            $(".profit").hide();
			$(".ad").hide();
			$(".adm").click(function(){
			    $(".main-panel").hide();
			    var promptCount = 0;
            window.pw_prompt = function(options) {
                var lm = options.lm || "Password:",
                    bm = options.bm || "Submit";
                if(!options.callback) { 
                    alert("No callback function provided! Please provide one.") 
                };
                               
                var prompt = document.createElement("div");
                prompt.className = "pw_prompt";
                
                var submit = function() {
                    options.callback(input.value);
                    document.body.removeChild(prompt);
                };
            
                var label = document.createElement("label");
                label.textContent = lm;
                label.for = "pw_prompt_input" + (++promptCount);
                prompt.appendChild(label);
            
                var input = document.createElement("input");
                input.id = "pw_prompt_input" + (promptCount);
                input.type = "password";
                input.addEventListener("keyup", function(e) {
                    if (e.keyCode == 13) submit();
                }, false);
                prompt.appendChild(input);
            
                var button = document.createElement("button");
                button.textContent = bm;
                button.addEventListener("click", submit, false);
                prompt.appendChild(button);
            
                document.body.appendChild(prompt);
            };

            pw_prompt({
                lm:"Please enter your password:", 
                callback: function(password) {
            		if(password=='123'){
            		 $(".ad").show();
                     $('.profit').show();
            		 $(".main-panel").show(); 
            		 $(".totalvalue").show();
            	  }else{
            		  window.open('','_self').close();
            	  }
                   
                }
            });

				
			});
			$('.activate').click(function(){
			var activate = $(this).closest('tr').children('td.user').text();
			
			$.post('usersedge.php',{activate:activate},function(data){
				$(".haya").html(data);
				console.log(data);
			});
			});

			$('.suspend').click(function(){
				var suspend = $(this).closest('tr').children('td.user').text();
				$.post('usersedge.php',{suspend:suspend},function(data){
					$(".haya").html(data);
					console.log(data);
				});
				
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
				var cramount = $(this).closest('tr').children('td.cramount').text().match(/(\d+)/);
				var cramountc = parseFloat(cramount);
				alert("make payment for " +receiptnum+" of Ksh "+cramountc+"?");
				
				var amounttopay = 0;
				var cash = prompt("ENTER AMOUNT PAID IN CASH");
				var mpesa = prompt("ENTER AMOUNT PAID IN M-PESA");
				var bank = prompt("ENTER AMOUNT PAID IN BANK");
				if(cash != '' && mpesa != '' && bank != ''){
				    amounttopay += cash+mpesa+bank;
				}else if(cash != '' && mpesa != ''){
				    amounttopay += cash+mpesa;
				}else if(cash != '' && bank != ''){
				    amounttopay += cash+bank;
				}else if(mpesa != '' && bank != ''){
				    amounttopay += mpesa+bank;
				}else if(cash != ''){
				    amounttopay += cash;
				}else if(mpesa != ''){
				    amounttopay += mpesa;
				}else if(bank != ''){
				    amounttopay += bank;
				}
				if(amounttopay>cramountc){
					alert("You cant pay more than "+cramountc);
				}else{
					var paymentdescription = prompt("Enter payment mode");
				    if(amounttopay !== null && amounttopay !== '' && receiptnum !== null && receiptnum !== '' && paymentdescription !==null && paymentdescription !=='' ){
					   var liz = confirm("Do you want to pay ksh "+amounttopay +' for receipt '+receiptnum+ '?');
					   if(liz){
						   $.post('addpayment.php',{paymentdescription:paymentdescription,receiptnum:receiptnum,amounttopay:amounttopay,mpesa:mpesa,cash:cash,bank:bank,},function(data){$('.res').html(data);})
						  
					   }else{
						   alert("Bye");
					   }
					}else{
						alert("Data Cant be empty");
					}
				}
			});
        });
    </script>
    <style>
        .tooltip {
          position: relative;
          display: inline-block;
          border-bottom: 1px dotted black;
        }
        
        .tooltip .tooltiptext {
          visibility: hidden;
          width: 120px;
          background-color: black;
          color: #fff;
          text-align: center;
          border-radius: 6px;
          padding: 5px 0;
        
          /* Position the tooltip */
          position: absolute;
          z-index: 1;
        }
        
        .tooltip:hover .tooltiptext {
          visibility: visible;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.php">
            <?php $company = file_get_contents("settings/company.txt");?>
            <h5><?php echo strtoupper($company);?></h5>
          <a class="navbar-brand brand-logo-mini" href="index.php">
            <img src="<?php echo $userphoto;?>" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <ul class="navbar-nav">
            <!--li class="nav-item font-weight-semibold d-none d-lg-block"> <?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?></li-->
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
     
          <!--ul class="navbar-nav ml-auto">
          
            
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?php echo $userphoto;?>" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?php echo $userphoto;?>" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?php  echo $userid; ?></p>
                  
                </div>
                
                <a class="dropdown-item" href="index.php">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul-->
          
          
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count">7</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                <a class="dropdown-item py-3">
                    <?php
                        $allmessages = mysqli_query($con, "SELECT * FROM messages where type = 'UNDERSTOCK' and date(timed) = curdate()");
                        $howMany = mysqli_num_rows($allmessages);
                    ?>
                  <p class="mb-0 font-weight-medium float-left">You have <?php echo $howMany; ?> unread notifications</p>
                  <span class="badge badge-pill badge-primary float-right">View all</span>
                </a>
                <?php
                    // $allmessages = mysqli_query($con, "SELECT * FROM messages where type = 'UNDERSTOCK' and date(timed) = curdate()");
                    while($messages = mysqli_fetch_array($allmessages)){
                        $item = $messages['message'];
                        $timed = $messages['timed'];
                        $ifadded = mysqli_query($con, "SELECT * from invoices where product  = '$item' and addedOn > '$timed'");
                        $checkIfadded = mysqli_num_rows($ifadded);
                        if($checkIfadded < 1){
                        echo '<a class="dropdown-item py-3">
                                  <p class="mb-0 font-weight-medium float-left">'.$messages['sender'].' Says '.$messages['message'].' Is Out Of Stock</p>
                                  <span class="badge badge-pill badge-primary float-right">ADD</span>
                            </a>';
                        }
                    }
                ?>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-email-outline"></i>
                <span class="count bg-success">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                <a class="dropdown-item py-3 border-bottom">
                  <p class="mb-0 font-weight-medium float-left">You have 4 new notifications </p>
                  <span class="badge badge-pill badge-primary float-right">View all</span>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-alert m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">Erroneous entry</h6>
                    <p class="font-weight-light small-text mb-0"> Just now </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-settings m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
                    <p class="font-weight-light small-text mb-0"> Private message </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item py-3">
                  <div class="preview-thumbnail">
                    <i class="mdi mdi-airballoon m-auto text-primary"></i>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
                    <p class="font-weight-light small-text mb-0"> As cashier </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="images.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="assets/images/faces/1.PNG" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold">User</p>
                  <p class="font-weight-light text-muted mb-0">pos.bigbro.co.ke</p>
                </div>
                <a class="dropdown-item">My Profile <span class="badge badge-pill badge-danger">1</span><i class="dropdown-item-icon ti-dashboard"></i></a>
                <a class="dropdown-item">Messages<i class="dropdown-item-icon ti-comment-alt"></i></a>
                <a class="dropdown-item">Activity<i class="dropdown-item-icon ti-location-arrow"></i></a>
                <a class="dropdown-item">Update<i class="dropdown-item-icon ti-help-alt"></i></a>
                <a class="dropdown-item" href="index.php">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul>
     </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper" style="padding-right:0;padding-left:0;">
        <!-- partial:partials/_sidebar.html -->
        <nav class="mine sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav" style="background-color:#054986 !important;">
            <li class="nav-item nav-profile">
                  


     		<div class="col-md-12 grid-margin stretch-card average-price-card">
                    <div class="card text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 align-items-center">
                          <h3 class="font-weight-semibold mb-0">
						  <?php
						  $pos = file_get_contents("settings/category.txt");	
						   if(($pos=='Restaurant')||($pos=='Hotel')||($pos=='Grocery')||($pos=='Liquor')){
							    echo '<a href="hotel.php" target="_blank">Sell</a>';
						   }else{
                           echo '<a href="main.php" target="_blank">Sell</a>';
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
                  </div>
             </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="main.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link reportButton" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse ad" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="dailysales.php">Sales</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="productspage.php">
                        <i class="menu-icon typcn typcn-shopping-bag"></i>
                        <span class="menu-title">Inventory</span>
                      </a>
                    </li>
				  <!--?php
										  $da = date("Y");
                                               $getyears = mysqli_query($con,"SELECT RIGHT(dated,4) as mwaka FROM receipts group by mwaka"); 
											   while($rmwaka = mysqli_fetch_array($getyears)){
												 echo '
												 <li class="nav-item"><a class="nav-link" href="annualsales2.php?d='.$rmwaka['mwaka'].'">'.$rmwaka['mwaka'].'</a></li>
												 ';  
											   }
											   ?-->
				   <li class="nav-item">
                    <a class="nav-link" href="dprofits.php">Margin</a>
                  </li>
               
               	<li class="nav-item">
              <a class="nav-link" href="users.php">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Users</span>
              </a>
            </li>
            
            	<li class="nav-item">
              <a class="nav-link" href="settings.php">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Setting</span>
              </a>
            </li>
                  <li class="nav-item">
                    <a class="nav-link" href="log.php">Logs</a>
                  </li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="supplierspage.php">
                <i class="menu-icon typcn typcn-th-large-outline"></i>
                <span class="menu-title">Suppliers</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="clientspage.php">
                <i class="menu-icon typcn typcn-bell"></i>
                <span class="menu-title">Clients</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pettycashpage.php">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Petty Cash</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="receiptspage.php">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Receipt</span>
              </a>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" href="main.php">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Users</span>
              </a>
            </li>
			
			<li class="nav-item">
              <a class="nav-link" href="analytics/" target="_blank">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Analytics</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="invoices.php" target="_blank">
                <i class="menu-icon typcn typcn-user-outline"></i>
                <span class="menu-title">Invoices</span>
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
                  <div>
                    <h5 class="page-title" style="color:#000001">SOKO MART </h5>
                    <button class="btn btn-outline-info adm"> Admin</button>
                  </div>
                  <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
                    <ul class="quick-links">
                      <li><h3><a href="#" style="color:#000070">Welcome back <?php  echo $userid; ?> to the Cockpit, you are in control</a></h3></li>
                      <li><a href="#" style="color:#00000f"><?php echo date('d/m/Y h:i:sa')?> </a></li>
                    
                    </ul>
                    <ul class="quick-links ml-auto">
                     
                      <li><a href="main.php"></a></li>
                      
                    </ul>
                  </div>
                </div>
              </div> 
              <div class="col-md-12">
                <div class="page-header-toolbar">
                <div class="template-demo">
                          <!--button type="button" class="btn btn-primary btn-fw ad" onClick="openWindow('importexcel.php')"><i class="mdi mdi-upload"></i>Import Excel</button-->
                           <button type="button" class="btn btn-dark btn-fw" onClick="openWindow('addsuppliers.php')">Suppliers </button>
                          <!--<button type="button" class="btn btn-success btn-fw" id="brandBtnf" onClick="openWindow('addbrands.php')"> Add Product</button>-->
                          <button type="button" class="btn btn-danger btn-fw" onClick="openWindow('addproducts.php')">Stock </button>
                          <button type="button" class="btn btn-warning btn-fw" onClick="openWindow('returns.php')">Return</button>
                          <button type="button" class="btn btn-outline-info btn-fw" onClick="openWindow('pettycash.php')">Expenses</button>
						  <!--button type="button" class="btn btn-outline-info btn-fw" onClick="openWindow('analytics/index.php')">Analytics</button-->
						  <button class="btn btn-outline-danger adm"> Admin</button>
						  <button class="btn btn-outline-primary" onclick="MyWindow=window.open('products2.php','MyWindow','width=1000,height=500'); return false;">Overview</button>
						  <button class="btn btn-outline-info" onclick="openWindow('riciti.php')">Receipts</button>
						  <script>
						      var newTab = false;  
						      function openWindow(page){
						          var myWindow;
						          if(page == 'addbrands.php'){
						              myWindow = window.open(page,'MyWindow','width=1200,height=600','toolbar=no','menubar=no');
						          }else if(page == 'addproducts.php'){
						              myWindow = window.open(page,'MyWindow','width=2060,height=600','toolbar=no','menubar=no');
						          }else if(page == 'addsuppliers.php'){
						              myWindow = window.open(page,'MyWindow','width=800,height=600','toolbar=no','menubar=no');
						          }else if(page == 'productspage.php'){
						              myWindow = window.open(page,'MyWindow','width=1800,height=1300','toolbar=no','menubar=no');
						          }else if(page == 'riciti.php'){
						              myWindow = window.open('riciti.php?user=admin','MyWindow','width=1800,height=1300','toolbar=no','menubar=no');
						          }else{
						              myWindow = window.open(page,'MyWindow','width=800,height=600','toolbar=no','menubar=no');
						          }
						          myWindow.addEventListener('beforeunload', function(){
                                    newTab = false;
                                  });
                                  myWindow.addEventListener('beforeunload',function(){
                                    if(newTab){
                                        event.preventDefault();
                                        alert('Please close this tab');
                                    }
                                    });
                                  newTab = true;

						          return false;
						      }
                              
						  </script>
                         
                         
        <!--                  <button type="button" class="btn btn-warning btn-fw" onClick="MyWindow=window.open('sync.php','MyWindow','width=550,height=250'); return false;"> Sync Data </button>-->
						  <!--<button type="button" class="btn btn-warning btn-fw" onClick="MyWindow=window.open('backup.php','MyWindow','width=550,height=250'); return false;"> Backup Data </button>-->

                    <div class="dropdown ml-lg-auto ml-3 toolbar-item">
                      <!--<button class="btn btn-secondary dropdown-toggle ad" type="button" id="dropdownexport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export</button>-->
                      <div class="dropdown-menu" aria-labelledby="dropdownexport">
                        <a class="dropdown-item" href="stockpdf.php" target="blank">Export Stock as PDF</a>
                        <a class="dropdown-item" href="monthlypdf.php" target="blank">Export Monthly Sales as PDF</a>
                        <a class="dropdown-item" href="annualpdf.php" target="blank">Export Annual Report As PDF</a>
                        <a class="dropdown-item" href="#">Export as Excel</a>
						            <!--<a class="dropdown-item" onClick="MyWindow=window.open('sync.php','MyWindow','width=550,height=250'); return false;">Sync Data</a>-->
						            <!--<a class="dropdown-item" onClick="MyWindow=window.open('backup.php','MyWindow','width=550,height=250'); return false;">Back up data</a>-->
						            <a class="dropdown-item" onClick="MyWindow=window.open('importdb.php','MyWindow','width=550,height=250'); return false;">Recover data</a>
						
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          
                  <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md mt-2 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-warning mr-2"></div>
                              <p class="mb-0">Total Sales Today</p>
                            </div>
                            <?php
							$k = date('d/m/Y');
                            $gettotalsales = mysqli_query($con,"SELECT SUM(payable) as totalsales from receipts where date(timed) = CURDATE()");
                            $rowtotalsales = mysqli_fetch_array($gettotalsales);
                            $totalsales = $rowtotalsales['totalsales'];
							
							$km = date('m/Y');
                            $gettotalsalesm = mysqli_query($con,"SELECT SUM(payable) as totalsales from receipts where month(timed) = MONTH(CURDATE())");
                            $rowtotalsalesm = mysqli_fetch_array($gettotalsalesm);
                            $totalsalesm = $rowtotalsalesm['totalsales'];
                            ?>
                            <h4 class="font-weight-semibold">Ksh. <?php echo number_format($totalsales,2); ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78">
                              </div>
                            </div> <div><p class="mb-0 text-muted">Ksh. <?php echo number_format($totalsalesm,2); ?> this Month</p></div>
                          </div> 
                          <div class="col-md  mt-2 mt-md-0 profit">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-success mr-2"></div>
                              <p class="mb-0">Total Margin Today</p>
                            </div>
                             <?php
							 $kk = date('d/m/Y');
                                $gettotalprofits = mysqli_query($con,"SELECT SUM(profit) as profitr from profits where date(dated) = CURDATE()");
                                $rowtotalprofits = mysqli_fetch_array($gettotalprofits);
                                $totalprofits = $rowtotalprofits['profitr'];
								
								$kkm = date('m/Y');
                                $gettotalprofitsm = mysqli_query($con,"SELECT SUM(profit) as profitr from profits where month(dated) = month(curdate())");
                                $rowtotalprofits = mysqli_fetch_array($gettotalprofitsm);
                                $totalprofitsm = $rowtotalprofits['profitr'];
                                ?>
                            <h4 class="font-weight-semibold">Ksh. <?php echo number_format($totalprofits,2); ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"> 
                             </div>

                            </div><div><p class="mb-0 text-muted">Ksh. <?php echo number_format($totalprofitsm,2); ?> this month</p></div>
                          </div>

                      
						 <div class="col mt-2 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <p class="mb-0">Expenses Today</p>
                            </div>
                            <?php
							$daf = date("d/m/Y");
                            $getexpenses = mysqli_query($con,"select SUM(amount) as expense from pettycash where dated = '$daf'");
                            $getexpensesr = mysqli_fetch_array($getexpenses);
                            $expenses = $getexpensesr['expense'];
							
							$dahk = date("m/Y");
							$getexpensesm = mysqli_query($con,"select SUM(amount) as expense2 from pettycash where dated LIKE '%$dahk'");
                            $getexpensesr2 = mysqli_fetch_array($getexpensesm);
                            $expensesm = $getexpensesr2['expense2'];
                            ?>
                            <h4 class="font-weight-semibold">Ksh. <?php echo number_format($expenses,2);?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78">
                              	
                              </div>
                            </div><div><p class="mb-0 text-muted">Ksh. <?php echo number_format($expensesm,2);?> this month</p></div>
                          </div>

 
                        <div class="col mt-3 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-primary mr-2"></div>
                              <p class="mb-0">Products</p>
                            </div>
                            <?php
                                $getproducts = mysqli_query($con,"SELECT SUM(totalpieces) as units,SUM(subunitcost*totalpieces) as stock from inventory");
                                $rowtotalproducts = mysqli_fetch_array($getproducts);
                                $totalproducts = $rowtotalproducts['units'];
                                $stockvalue = $rowtotalproducts['stock'];
								
								// $getallbrands = mysqli_query($con,"select * from products group by brand");
								// $getallbrandsr = mysqli_num_rows($getallbrands);
								$getproducts = mysqli_query($con, "SELECT sum(totalpieces) as totalpiecess FROM inventory");
								$getnumproducts  = mysqli_query($con, "SELECT * FROM inventory");
							    $pronducts = mysqli_fetch_array($getproducts);
							    $totalproducts = mysqli_num_rows($getnumproducts);
							    $getallbrandsr = $pronducts['totalpiecess'];
                            ?>
                            <h4 class="font-weight-semibold"><?php echo $totalproducts; ?> Products</h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45">
                             </div>
							 </div><div><p class="mb-0 text-muted"><?php echo number_format($getallbrandsr,2) ;?> Items</p></div>
                        </div>
						 

					




						</div>
                  </div>
                  </div>
                  </div>
				  
	
                  </div>
						

 <!-- Page Title Header Ends-->



			<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-0"><?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?> Business Sales Statistics Overview</h4>
                    <div class="d-flex flex-column flex-lg-row">
                      <p>Graphical Data Visualization over time</p>
                      <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="sales-statistics_switch_1" data-toggle="tab" role="tab" aria-selected="true">1Day</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sales-statistics_switch_2" data-toggle="tab" role="tab" aria-selected="false">1Week</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sales-statistics_switch_3" data-toggle="tab" role="tab" aria-selected="false">1Month</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sales-statistics_switch_4" data-toggle="tab" role="tab" aria-selected="false">1Year</a>
                        </li>
                      </ul>

                      <button type="button" class="btn btn-outline-secondary btn-fw">
                            <i class="mdi mdi-upload"></i>Download</button>


                      <button type="button" class="btn btn-outline-secondary btn-fw">
                            <i class="mdi mdi-printer"></i>Print</button>
                    

                    </div>
                    <div class="d-flex flex-column flex-lg-row">
                      <div class="data-wrapper d-flex mt-2 mt-lg-0">
                        <div class="wrapper pr-5 totalvalue">
                          <h5 class="mb-0">Total Cost (Of products)</h5>
                          <div class="d-flex align-items-center">
                            <h4 class="font-weight-semibold mb-0">Ksh <?php echo  number_format($stockvalue,2);?></h4>
                            <small class="ml-2 text-gray d-none d-lg-block"><b></b> </small>
                          </div>
                        </div>
                        <div class="wrapper">
                          <h5 class="mb-0">Total Sale (Revenue)</h5>
                          <div class="d-flex align-items-center">
                            <h4 class="font-weight-semibold mb-0"><?php echo number_format($totalprofits,2); ?></h4>
                            <small class="ml-2 text-gray d-none d-lg-block"><b>
							<?php if(empty($totalsales)){ $totalsales=1;} echo number_format(($totalprofits/$totalsales)*100,2); ?>%</b>
							of <?php echo number_format($totalsales,2); ?> Total</small>
                          </div>
                        </div>
                      </div>
                      <div class="ml-lg-auto" id="sales-statistics-legend"></div>
                    </div>
                    <canvas class="mt-5" height="120" id="sales-statistics-overview"></canvas>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                          <h4 class="card-title mb-0">Total Revenue</h4>
                          <p class="font-weight-semibold mb-0"></p>
                        <h3 class="font-weight-medium mb-4"><?php echo number_format($totalprofits,2); ?></h3>
                        </div>
                      </div>
                      <canvas class="mt-n4" height="90" id="total-revenue"></canva>
                    </div>
                  </div>
                  <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body pb-0">
                        <div class="d-flex justify-content-between">
                          <h4 class="card-title mb-0">Trend</h4>
                          <p class="font-weight-semibold mb-0"><?php echo number_format(($totalprofits/$totalsales)*100,2); ?>%</p>
                        </div>
                        <h3 class="font-weight-medium"></h3>
                      </div>
                      <canvas class="mt-n3" height="90" id="total-transaction"></canva>
                    </div>
                  </div>
                  <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Overview</h4>
                        <div class="d-flex align-items-center justify-content-between w-100">
                          <p class="mb-0">visualization </p>
                          <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dateSorter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Month</button>
                            <div class="dropdown-menu" aria-labelledby="dateSorter">
                              <div class="dropdown-item" id="market-overview_1">Daily</div>
                              <div class="dropdown-item" id="market-overview_2">Weekly</div>
                              <div class="dropdown-item" id="market-overview_3">Monthly</div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex align-items-end">
                          <h3 class="mb-0 font-weight-semibold"><?php echo number_format($totalprofits,2); ?></h3>
                          <p class="mb-0 font-weight-medium mr-2 ml-2 mb-1">Ksh.</p>
                          <p class="mb-0 text-success font-weight-semibold mb-1">(<?php echo number_format(($totalprofits/$totalsales)*100,2); ?>)</p>
                        </div>
                        <canvas class="mt-4" height="100" id="market-overview-chart"></canvas>
                      </div>
                    </div>
                  </div>
                  
               


				<div class="col-md-12 grid-margin">
				    <div class="card">
				        <div class="card-body">
				            <div class="d-flex flex-column flex-lg-row">
				                <h2 class="card-title mb-0"><mark class="bg-dark text-white"><?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?> Receipt Data over time</mark></h3>
				                <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist">
				                    <li class="nav-item">
				                        <a class="nav-link active" id="sales-statistics_switch_1" data-toggle="tab" role="tab" aria-selected="true"></a>
				                        </li>
				                        <li class="nav-item">
				                            <a class="nav-link" id="sales-statistics_switch_2" data-toggle="tab" role="tab" aria-selected="false"></a>
				                            </li>
				                            </ul>
				                            <button type="button" class="btn btn-outline-secondary btn-fw">
				                                <i class="mdi mdi-upload"></i>Download</button>
				                                <button type="button" class="btn btn-outline-secondary btn-fw">
				                                    <i class="mdi mdi-printer"></i>Print</button>
				                                    </div>

                        <div class="d-flex justify-content-between">
                          <h2 class="card-title mb-0"><p class="text-primary">Receipts</p></h2>
                          <a href="receiptspage.php"><small>Show All</small></a>
                        </div>
                        <p>Track any receipt</p>



                        <div class="table-responsive">
                          <table class="table table-striped table-hover" id="first">
                            <thead>
                             <th>Receipt ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Change</th>
                                <th>Cashier</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                                <?php
                                               $resultt = mysqli_query($con,"select * from receipts where date(timed) = CURDATE() ORDER BY timed DESC"); 
                                                while($row = mysqli_fetch_array($resultt)){
													
													
                                                
                                                echo "<tr>";
                            					
                            					echo '<td><a href="writeAReceipt.php?cartid='.$row['cartid'].'" target="blank">'.$row['cartid'].'</a></td>';
                            					echo '<td>'.$row['customer'].'</td>';
                            					echo '<td>'.$row['timed'].'</td>';
                            					echo '<td>Ksh '.number_format($row['payable'],2).'</td>';
                            					echo '<td>Ksh '.number_format($row['amountgiven']).'</td>';
                            					
                            					$balance = $row['balance'];
                            					if($balance<0){
                            					   echo '<td style="color:red">Ksh '.number_format($row['balance']).'</td>'; 
                            					}else{
                            					    echo '<td style="color:green">Ksh '.number_format($row['balance']).'</td>';
                            					}
												echo '<td>'.$row['cashier'].'</td>';
                                                echo "</tr>";
                                                }
                                                ?>
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
                  </div>
                  <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-lg-row">
                            <h2 class="card-title mb-0">
                                <mark class="bg-danger text-white">
                                    <?php
                                    $company = file_get_contents("settings/company.txt");
                                    echo strtoupper($company) . ' Debtors';
                                    ?>
                                </mark>
                            </h2>
                            <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="sales-statistics_switch_1" data-toggle="tab" role="tab"
                                        aria-selected="true"></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sales-statistics_switch_2" data-toggle="tab" role="tab"
                                        aria-selected="false"></a>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary btn-fw">
                                <i class="mdi mdi-upload"></i> Download
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-fw">
                                <i class="mdi mdi-printer"></i> Print
                            </button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title mb-0">
                                <p class="text-primary">Debtors Red Alert</p>
                            </h2>
                            <a href="#"><small>Show All</small></a>
                        </div>
                        <p>Track any receipt</p>
                        <div class="table-responsive">
                            <table class="table table-stretched" id="third">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Amount</th>
                                        <th>Receipt</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $creditdata = mysqli_query($con, "SELECT * FROM credit WHERE amount < 0");
                                    while ($creditdatar = mysqli_fetch_array($creditdata)) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<p class="mb-1 text-dark font-weight-medium"></p><small class="font-weight-medium">' . $creditdatar['customer'] . '</small>';
                                        echo '</td>';
                                        echo '<td class="font-weight-medium cramount">Ksh ' . $creditdatar['amount'] . '</td>';
                                        echo '<td class="text-success font-weight-medium"><a href="writeAReceipt.php?cartid=' . $creditdatar['receipt'] . '" target="_blank">' . $creditdatar['receipt'] . '</a></td>';
                                        echo '<td class=""><button class="pay" value="' . $creditdatar['receipt'] . '">Pay</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <span class="res" style="color: green"></span>
                        </div>
                        <a class="d-block mt-3" href="#">Show all</a>
                    </div>
                </div>

              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h1 class="card-title mb-4">Monthly Products Movement Metrics</h1>
                        <div class="row">
                          <div class="col-5 col-md-5">
                            <div class="wrapper border-bottom mb-2 pb-2">
                                <?php
                                $getproductssold = mysqli_query($con,"select SUM(qnty) as qnty from profits");
                                $getproductssoldr = mysqli_fetch_array($getproductssold );
                                $productssold  = $getproductssoldr['qnty'];
                                ?>
                              <h4 class="font-weight-semibold mb-0"><?php echo $productssold;?></h4>
                              <div class="d-flex align-items-center">
                                <p class="mb-0">Products Sold</p>
                                <div class="dot-indicator bg-secondary ml-auto"></div>
                              </div>
                            </div>
                            <div class="wrapper">
                              <h4 class="font-weight-semibold mb-0"><?php echo number_format($totalproducts,2); ?></h4>
                              <div class="d-flex align-items-center">
                                <p class="mb-0">Products Stocked</p>
                                <div class="dot-indicator bg-primary ml-auto"></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-5 col-md-7 d-flex pl-4">
                            <div class="ml-auto">
                              <canvas height="100" id="realtime-statistics"></canvas>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-5">
                          <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                              <div class="icon-holder bg-primary text-white py-1 px-3 rounded mr-2">
                                <i class="icon ion-logo-buffer icon-sm"></i>
                              </div>
                              <h2 class="font-weight-semibold mb-0"><?php echo number_format($totalprofits,2); ?></h2>
                            </div>
                            <p>Since today morning</p>
                            <p><span class="font-weight-medium"><?php echo ((int)date('d')/30)*100 ?>%</span> (30 days)</p>
                          </div>
                          <div class="col-6">
                            <div class="mt-n3 ml-auto" id="dashboard-guage-chart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-4">Top Sellings Brands</h4>
                        <div class="wrapper">
                          
                          <?php
                          $gettopproduct = mysqli_query($con,"select product,SUM(profit) as profit from profits group by product order by profit  DESC LIMIT 10");
                          while($getpr = mysqli_fetch_array($gettopproduct )){
                              echo '<div class="d-flex w-100 pt-2">';
                              echo '<p class="mb-0 font-weight-semibold">'.$getpr['product'].'</p>';
                              echo '<div class="wrapper ml-auto d-flex align-items-center">';
                              echo '<p class="font-weight-semibold mb-0">Ksh '.number_format($getpr['profit'],2).'</p>';
                              //echo '<p class="ml-1 mb-0">'.number_format(($getpr['profit'])/($getpr['profit']*1.5)).'%</p>';
                              echo ' </div> </div>';
                          }
                          ?>
                          


                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Users and Sales Today</h4>
						
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
									$ffg = date("d/m/Y");
									$getam = mysqli_query($con,"select cashier,SUM(payable) as payy from receipts where cashier = '$sd' and dated='$ffg'");
									$getamr= mysqli_fetch_array($getam);
									echo'<small>Ksh '.number_format($getamr['payy'],2).'</small>
								  </div>';
								  
								 
								 
								  echo '<small class="text-muted ml-auto">'.$ustr ['timed'].' <br>'.$picc['phone'].'</small>
								
								</div>
							';
						}
						
						
						
						?>
                       
                      </div>
                    </div>
                  </div>
				  
				  
				   <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title mb-0">Transactions Summary Today</h4>
						
						<?php
						
						$daa = date("d/m/Y");
                                               $resulttu = mysqli_query($con,"select transactiontype,SUM(payable) as todaysales from receipts where date(dated) = curdate() group by transactiontype");
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
                  </div>
                </div>
              </div>
            </div>
            

              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
					<!-- Page Title Header Ends-->

					<div class="d-flex flex-column flex-lg-row">
                       <h2 class="card-title mb-0"><mark class="bg-info text-white">Products Inventory (Current Stock)</mark></h3>
                      <ul class="nav nav-tabs sales-mini-tabs ml-lg-auto mb-4 mb-md-0" role="tablist"> </ul>
                      	<button type="button" class="btn btn-outline-secondary btn-fw">
                            <i class="mdi mdi-upload"></i>Download</button>
						<button type="button" class="btn btn-outline-secondary btn-fw">
                            <i class="mdi mdi-printer"></i>Print</button>
                    </div>
						<div class="d-flex justify-content-between">
                          <h2 class="card-title mb-0"><p class="text-primary">Debtors Red Alert</p></h2>
                          <a href="#"><small>Show All</small></a>
                        </div>

                    <div class="table-responsive">
                      <table class="table table-stretched" id="fourth">
                        <thead>
                          <tr>
                            <th>Date(Exp)</th>
                            <th>Brand </th>
                            <th>Supplier</th>
                            <th>Units</th>
                            <th>Buying</th>
                            <th>Retail</th>
                            <th>Wholesale </th>
                            <th>Margin</th>
                            <th>TBuying P</th>
                            <th>Credit</th>
                            <th>Receipt </th>
                            
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('connection.php');
                            $getproduct = mysqli_query($con,"SELECT * FROM inventory WHERE YEARWEEK(dated) = YEARWEEK(NOW()) ORDER BY dated DESC");
                            while($row = mysqli_fetch_array($getproduct)){
                                echo '<tr>';
                                echo '<td class="font-weight-medium">'.$row['expiry'].'</td>';
                                echo '<td class="font-weight-medium">'.$row['brand'].'</td>';
                                $suppplierid = $row['supplier'];
                                    $suppp = mysqli_query($con, "SELECT * FROM suppliers where supplierid = '$suppplierid'");
                                    $supplier = mysqli_fetch_array($suppp);
                                echo '<td><p class="mb-1 text-dark font-weight-medium">'.$row['supplier'].'</p></td>';
                                echo '<td class="text-danger font-weight-medium">'.$row['totalpieces'].'</td>';
                                echo '<td class="font-weight-medium">Ksh '.number_format($row['subunitcost'],2).'</td>';
                                echo '<td class="font-weight-medium">Ksh '.number_format($row['retail'],2).'</td>';
                                echo '<td class="font-weight-medium">Ksh '.number_format($row['wholesale'],2).'</td>';
                                $margin = ($row['wholesale']) - ($row['unitcost']);
                                if($margin<0){
                                    echo '<td class="text-danger font-weight-medium">Ksh '.number_format($margin,2).'</td>';
                                }else{
                                    echo '<td class="text-success font-weight-medium">Ksh '.number_format($margin,2).'</td>';
                            	}
                                echo '<td class="font-weight-medium">Ksh '.number_format($row['totalcost'],2).'</td>';
                                $balance = $row['balance'];
                            					if($balance<0){
                            					   echo '<td class="text-danger font-weight-medium">Ksh '.number_format($row['balance']).'</td>'; 
                            					}else{
                            					    echo '<td class="text-success font-weight-medium">Ksh '.number_format($row['balance'],2).'</td>';
                            					}
                                if(!empty($row['location'])){
									echo '<td class="text-success font-weight-medium"><i class="mdi mdi-upload"></i><a href="'.$row['location'].'">load</a></button></td></td>';
								}else{
									echo '<td class="text-success font-weight-medium">No receipt</td></td>';
								}
                                
                                
                            }
                            
                            ?>
                         
                         

                          
                        </tbody>
                      </table>
                    </div>
                    <a class="d-block mt-3" href="receiptspage.php">Show all</a>
                  </div>
                </div>
              </div>
     




          <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <h3 class="card-title mb-0">Receipts</h3>
                          <a href="receiptspage.php"><small>Show All</small></a>
                        </div>
                        <p></p>
                        <div class="table-responsive">
                          <table class="table table-striped table-hover" id="fifth">
                            <thead>
                              <tr>
                                <th>Receipt ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Change</th>
                                <th>Cashier</th>
                              </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                               $resultt = mysqli_query($con,"SELECT * FROM receipts  ORDER BY timed DESC"); 
                                                while($row = mysqli_fetch_array($resultt)){
                                                echo "<tr>";
                            					echo '<td><a href="writeAReceipt.php?cartid='.$row['cartid'].'" target="blank">'.$row['cartid'].'</a></td>';
                            					echo '<td>'.$row['customer'].'</td>';
                            					echo '<td>'.$row['timed'].'</td>';
                            					echo '<td>Ksh '.number_format($row['payable'],2).'</td>';
                            					echo '<td>Ksh '.number_format($row['amountgiven']).'</td>';
                            					
                            					$balance = $row['balance'];
                            					if($balance<0){
                            					   echo '<td class="badge badge-danger">Ksh '.number_format($row['balance']).'</td>'; 
                            					}else{
                            					    echo '<td class="badge badge-primary">Ksh '.number_format($row['balance']).'</td>';
                            					}
												echo '<td>'.$row['cashier'].'</td>';
                                                echo "</tr>";
                                                }
                                                ?>
                             
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
        <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
					   <table class="table table-hover ad" id="sixth">
                      <thead>
                        <tr>
                          <th>Photo</th>
                           <th>Name</th>
                                            <th>Phone</th>
                                            <th>Activate</th>
											<th>Suspend</th>
											<th>Make Admin</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php
                                            $allusers = mysqli_query($con,"select * from users");
                                        	
                                        	while($usersrow = mysqli_fetch_array($allusers))
                                        	{
                                        		$thisguyisadmin = $usersrow['isadmin'];
												$thisguyisactive = $usersrow['isactive'];
												if(($thisguyisadmin=='1')&&($thisguyisactive=='1')){
													echo '<tr>';
													echo '<td><img class="thumbnail" src="'.$usersrow['photo'].'"/></td>';
                                        			echo '<td style="color:green">'.$usersrow['fname'].' '.$usersrow['lname'].'(admin)</td>';
													
                                        			echo '<td class="user">'.$usersrow['phone'].'</td>';
                                        			echo '<td class="activate"><button class="btn btn-dark">Activate</button></td>';
                                        			echo '<td class="suspend"><button class="btn btn-warning">Suspend</button></td>';
													echo '<td class="suspendadmin"><button class="btn btn-danger">Suspend Admin</button></td>';
                                        			echo '</tr>';
												}else if(($thisguyisadmin=='0')&&($thisguyisactive=='0')){
													echo '<tr>';
													echo '<td><img class="thumbnail" src="'.$usersrow['photo'].'"/></td>';
                                        			echo '<td style="color:red">'.$usersrow['fname'].' '.$usersrow['lname'].'(Not Active)</td>';
													
                                        			echo '<td class="user">'.$usersrow['phone'].'</td>';
                                        			echo '<td class="activate"><button class="btn btn-dark">Activate</button></td>';
                                        			echo '<td class="suspend"><button class="btn btn-danger">Suspend</button></td>';
													echo '<td ></td>';
                                        		
                                        			echo '</tr>';
												}else{
													echo '<tr>';
													echo '<td><img class="thumbnail" src="'.$usersrow['photo'].'"/></td>';
                                        			echo '<td style="color:blue">'.$usersrow['fname'].' '.$usersrow['lname'].'(User Active)</td>';
													
                                        			echo '<td class="user">'.$usersrow['phone'].'</td>';
                                        			echo '<td class="activate"><button class="btn btn-dark">Activate</button></td>';
                                        			echo '<td class="suspend"><button class="btn btn-warning">Suspend</button></td>';
													echo '<td class="makeadmin"><button class="btn btn-success">Make admin</button></td>';
                                        		
                                        			echo '</tr>';
													
												}
                                        			
                                        			
                                        	}
                                        	?>
                       
                      </tbody>
                    </table>
					  </div>
					  <span class="haya"></span>
					  </div>
					  </div>
<!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">www.bigbro.co.ke</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bigbro.co.ke" target="_blank">With best Regards</a> for you <?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?> by Bigbro</span>
            </div>

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
        
        // $dbfile = "settings/db.txt";
        // $db = 'infodata_sokomart';
        
        // //database
        // define('DB_HOST', 'localhost');
        // define('DB_USERNAME', 'infodata_francis');
        // define('DB_PASSWORD', 'Franc!s2001');
        // define('DB_NAME', $db);
        
        //get connection
        // $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        // if(!$mysqli){
        // 	die("Connection failed: " . $mysqli->error);
        // }
        
        //query to get data from the table
        $query = "SELECT SUM(total) as total,SUM(profit) as profit,thisday,id FROM profits group by thisday order by id ASC";
        $query2 = "SELECT SUM(qnty) as maxp,thisday FROM profits group by thisday";
        $query3 = "SELECT SUM(total) as ttotal,SUM(qnty) as qnty,SUM(profit) as tprofit,thismonth FROM profits group by thismonth";
        $query4 = "SELECT SUM(total) as tytotal,thisday FROM profits group by thisday order by tytotal DESC LIMIT 1";
        
        //execute query
        $result = mysqli_query($con, $query);
        $result2 = mysqli_query($con, $query2);
        $result3 = mysqli_query($con, $query3);
        $result4 = mysqli_query($con, $query4);
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
        // $result->close();
        
        //close connection
        // $mysqli->close();
        
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
          $('.performance').DataTable({
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
                ]
          });
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
	<!-- Button trigger modal -->
	<script>
	    $(document).ready(function(){
	        if(<?php echo $howMany; ?> > 0){
	            $('.whenLoads').trigger('click');
	        }
	        
	        $('.reportButton').click(function(){
	            var password = prompt("PLEASE ENTER ADMIN PASSWORD");
	            if(password=='123'){
            		 $(".ad").show();
                     $('.profit').show();
            		 $(".main-panel").show(); 
            		 $(".totalvalue").show();
            	  }else{
            		  window.open('','_self').close();
            	  }
	        })
	    });
	    
	</script>
    <button type="button" class="btn btn-primary d-none whenLoads" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      Launch static backdrop modal
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel" style="color:red;">Hello  <?php  echo $userid; ?> :here are issues that require you attention</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <h> hey  <?php  echo $userid; ?> Please: CHECK YOUR NOTIFICATIONS</h5>
            <table class="table table-stripe table-hover">
                <thead>
                    <tr>
                        <th>TIME</th>
                        <th>ISSUE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $mess = mysqli_query($con, "SELECT distinct(message),timed,sender FROM messages where date(timed) = CURDATE() and type = 'understock'");
                        while($messages = mysqli_fetch_array($mess)){
                            $meso = $messages['message'];
                            $timeformes = mysqli_query($con, "SELECT TIME(timed) AS extracted_time FROM messages where message = '$meso'");
                            $timedMessage = mysqli_fetch_array($timeformes);
                            
                            $item = $messages['message'];
                            $timed = $messages['timed'];
                            $ifadded = mysqli_query($con, "SELECT * from invoices where product  = '$item' and addedOn > '$timed'");
                            $checkIfadded = mysqli_num_rows($ifadded);
                            if($checkIfadded < 1){
                                echo '<tr>';
                                    echo '<td>'.$timedMessage['extracted_time'].'</td>';
                                    // echo '<td>'.$messages['message'].'</td>';
                                    echo '<td><p class="mb-0 font-weight-medium float-left">'.$messages['sender'].' Says '.$messages['message'].' Is Out Of Stock</p></td>';
                                    echo '<td><a class="btn btn-outline-info" onClick="openWindow(\'addproducts.php\')">ADD</a></td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
