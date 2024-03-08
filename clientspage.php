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

if(isset($_POST['delsupplier'])){ $msg=$_POST['delsupplier'];
							 $deletesupplier = mysqli_query($con,"DELETE from suppliers where supplierid='$msg'");
							 if($deletesupplier){
								 echo "Supplier ".$msg . " deleted";
							 }}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Suppliers</title>
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
	  $(".errorMessage").hide();
$(".deleteworker").click(function(){
	
	var todel =$(this).closest('tr').children('td.name').text();
	$.post('deleteworker.php',{
	todel:todel,
	},
	function(data){
		$(".errorMessage").show();
		$(".errorMessage").html(data);
		}).success(function(){
			$(".loadcontent").load('personallife.php');
			
		});
});
$("#addModal").hide();
$("#editModal").hide();
$(".addNew").click(function(){
	$("#addModal").show();
});
$(".editNew").click(function(){
	$("#editModal").show();
	
	var editname = $(this).closest('tr').children('td.name').text();
	$("#editname").val(editname);
	
	var editphone = $(this).closest('tr').children('td.phone').text();
	$("#editphone").val(editphone);
	
	var editadress = $(this).closest('tr').children('td.adress').text();
	$("#editadress").val(editadress);
	
	var editproffession = $(this).closest('tr').children('td.proffesion').text();
	$("#editproffession").val(editproffession);
	
	var editidcard = $(this).closest('tr').children('td.idcard').text();
	$("#editidcard").val(editidcard);
	
	var editnhif = $(this).closest('tr').children('td.nhif').text();
	$("#editnhif").val(editnhif);
	
	var editnssf = $(this).closest('tr').children('td.nssf').text();
	$("#editnssf").val(editnssf);
	
	var editaccount= $(this).closest('tr').children('td.account').text();
	$("#editaccount").val(editaccount);
	
	var editdesgnition = $(this).closest('tr').children('td.desgnition').text();
	$("#editdesgnition").val(editdesgnition);
	
	var editwage = $(this).closest('tr').children('td.wage').text();
	$("#editwage").val(editwage);
	
	var identity= $(this).closest('tr').children('td.identity').text();
	$("#identity").val(identity);
	
	
	
	
});

$("#editWorkerr").click(function(){
	var editname = $("#editname").val();
	var editphone = $("#editphone").val();
	var editadress = $("#editadress").val();
	var editproffession = $("#editproffession").val();
	var editidcard = $("#editidcard").val();
	var editnhif = $("#editnhif").val();
	var editnssf = $("#editnssf").val();
	var editaccount = $("#editaccount").val();
	var editdesgnition = $("#editdesgnition").val();
	var editwage = $("#editwage").val();
	var identity = $("#identity").val();
	
	
	
	
	$.post('editworker.php',
	{
		editname:editname,
		editphone:editphone,
		editadress:editadress,
		editproffession:editproffession,
		editidcard:editidcard,
		editnhif:editnhif,
		editnssf:editnssf,
		editaccount:editaccount,
		editdesgnition:editdesgnition,
		editwage:editwage,
		identity:identity,
	},
	function(data){
		$("#errorMessage3").html(data);
		console.log(data);
	}).success(function(){
			$(".loadcontent").load('personallife.php');
			$("#editModal").hide();
			
		});
});

$(".close").click(function(){
	$("#addModal").hide();
	$("#editModal").hide();
});

$("#addNewWorkerr").click(function(){
	
	var name = $("#name").val();
	var id = $("#userid").val();
	var phone = $("#phone").val();
	var adress = $("#adress").val();
	var location = $("#location").val();
	var proffession = $("#proffession").val();
	var idcard = $("#idcard").val();
	var cv = $("#cv").val();
	var nhif = $("#nhif").val();
	var nssf = $("#nssf").val();
	var account = $("#account").val();
	var desgnition = $("#desgnition").val();
	var wage = $("#wage").val();
	
	$.post('addworker.php',{
	name:name,id:id,phone:phone,adress:adress,location:location,proffession:proffession,idcard:idcard,cv:cv,nhif:nhif,nssf:nssf,account:account,desgnition:desgnition,wage:wage,
	},
	function(data){
		
		$(".errorMessage2").html(data);
		$("#modal").hide();
		console.log(data);
		
		}).success(function(){
			
			$("#modal").hide();
				
			
		});
});

$("#desgnition").change(
function(){
	var profiled = $("#desgnition").val();
	
	if(profiled=="permanent"){
		$("#profiler").text("MONTHLY WAGE");
	}else{
		$("#profiler").text("DAILY WAGE");
	}
}
);


$('#unitcost').keyup(function(){
	var thisunitcost = $(this).val();
	var thisitemunit = $("#itemunit").val();
	var thistotalunitcost = thisunitcost*thisitemunit;
	$("#totalunitcost").val(thistotalunitcost);
	
	var thissubunits = ($("#subunits").val())*thisitemunit;
	$("#subunitcost").val(thistotalunitcost/thissubunits);
});


$('#paid').keyup(function(){
	var thispaid = $(this).val();
	var thistotalunitcost2 = $("#totalunitcost").val();
	var ball = thispaid  - thistotalunitcost2;
	$("#balance").val(ball);
});




$('.activate').click(function(){
	var activate = $(this).closest('tr').children('td.user').text();
	
	$.post('usersedge.php',{activate:activate},function(data){
		$(".haya").html(data);
	});
});

$('.suspend').click(function(){
	var suspend = $(this).closest('tr').children('td.user').text();
	$.post('usersedge.php',{suspend:suspend},function(data){
		$(".haya").html(data);
	});
	
});

$(".editbtn").click(function(){
		 
			 var thisbrand = $(this).closest('tr').children('td.brandname').text();
			 var s = prompt("Enter Amount you want to pay");
			 $(this).closest('tr').children('td.spr').text(s)
			 
				

		});
		
	 $(".editcommit").click(function(){
		 
			 var editbrand = $(this).closest('tr').children('td.brandname').text();
			 
			var editspr= $(this).closest('tr').children('td.spr').text()
			
			 
			 
			 $.post('editsupplierdebts.php',{editbrand:editbrand,editspr:editspr},function(data){
				 $('.res').html(data);
				 console.log(data);
				 window.parent.opener.location.reload(); 
			 });
				

		});


$('#first').dataTable();
			$('#second').dataTable();
			
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
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
         <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html">
            <!--<img class="thumbnail"  height="100px" width="20px" src="<?php echo $userphoto;?>" alt="logo" /> </a>-->
            <?php $company = file_get_contents("settings/company.txt");?>
            <h1><?php echo strtoupper($company);?></h1>
          <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="<?php echo $userphoto;?>" alt="logo" /> </a>
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
                <img class="img-xs rounded-circle" src="<?php echo $userphoto;?>" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?php echo $userphoto;?>" alt="Profile image">
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
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
				<?php $company = file_get_contents("settings/company.txt"); echo strtoupper($company);?>
                 
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php  echo $userid; ?></p>
                 
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="main.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
			 <li class="nav-item">
              <a class="nav-link" href="customerspdf.php" target="blank_">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Customers PDF</span>
              </a>
            </li>
        
            
          </ul>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
               
              <div class="col-lg-12 grid-margin stretch-card">
                 
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Clients</h4>
                    
                    
                          <table class="table .table-striped" id="first">
                                    <thead>
                                        <tr>
										<th>#</th>
                                          <th>Customer</th>
										  <th>Photo</th>
                    					 <th>Shopping amount</th>
                                            <th>Discounts</th>
                                            <th>Debts</th>
                                            <th>Phone</th>
											<th>Edit</th>
											
                    						
                    					
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $allsuppliers = mysqli_query($con,"select customer,SUM(payable) as payable, SUM(discount) as discount,SUM(balance) as balance from receipts group by customer");
                                        	
                                        	while($suppliersrow = mysqli_fetch_array($allsuppliers))
                                        	{
												
                                        			echo '<tr>';
													$cus = preg_replace("/[^a-zA-Z]+/", "", $suppliersrow['customer']);
													$phone = preg_replace("/[^0-9]+/", "", $suppliersrow['customer']);
													
													
													$bet = $suppliersrow['customer'];
													$getcid = mysqli_query($con,"select * from customers where code='$bet'");
													$getcidr = mysqli_fetch_array($getcid);
													if(isset($getcidr['id'])){
														$getcidd = $getcidr['id'];
													}else{
														$getcidd = "N/A";
													}
													
												
													echo '<td class="cusid">'.$getcidd.'</td>';
                                        			echo '<td>'.$cus.'</td>';
													if(isset($getcidr['location'])){
														echo '<td><img src="'.$getcidr['location'].'"/></td>';
													}else{
														echo '<td><img src="users/a.ico"/></td>';
													}
													
													
                                        			echo '<td>'.$suppliersrow['payable'].'</td>';
													echo '<td>'.$suppliersrow['discount'].'</td>';
                                        			echo '<td>'.$suppliersrow['balance'].'</td>';
													echo '<td>'.$phone.'</td>';
													echo '<td><span class="editcusinfo">&#9998;</span></td>';
                                        			echo '</tr>';
                                        			
                                        	}
                                        	?>
                                        
                                    </tbody>
                                </table>
								
								
								<script>
								$('.editcusinfo').click(function(){
									var _id = $(this).closest('tr').children('td.cusid').text();
									
									location.replace('customeredit.php?id='+_id);
									
								});
								</script>
                        
                  </div>
                </div>
              </div>
             
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Debt payment</h4>
					<h2><button type="button" class="btn btn-success btn-fw res" >
                  </button></h2>
                    <table class="table .table-striped" id="second">
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
												$creditdata = mysqli_query($con,"select * from credit where amount<0");
												while($creditdatar = mysqli_fetch_array($creditdata)){
													echo '<tr>';
													echo '<td>
												  <p class="mb-1 text-dark font-weight-medium"></p><small class="font-weight-medium">'.$creditdatar['customer'].'</small>
												</td>';
												echo '<td class="font-weight-medium">Ksh '.$creditdatar['amount'].'</td>';
												echo '<td class="text-success font-weight-medium"><a href="writereceipt.php?cartid='.$creditdatar['receipt'].'" target="blank">'.$creditdatar['receipt'].'</a></td>';
												echo '<td class=""><button class="pay" value="'.$creditdatar['receipt'].'">Pay</button></td>';
												echo '</tr>';
												}
												
												?>
                                        
                                    </tbody>
                                    </table>
                  </div>
				  <span class="res"></span>
                </div>
              </div>
                       
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2021</span>
             
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
   
    <!-- End custom js for this page-->
  </body>
</html>