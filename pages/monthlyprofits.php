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
    <title>sales</title>
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
        
        	 
        	 $(".editbtn").click(function(){
        		 
        			 var thisbrand = $(this).closest('tr').children('td.brandname').text();
        			 var s = prompt("Enter new Retail Price");
        			 $(this).closest('tr').children('td.spr').text(s)
        			 var w = prompt("Enter new Wholesale Price");
        			 $(this).closest('tr').children('td.spw').text(w);
        				
        
        		});
        		
        	 $(".editcommit").click(function(){
        		 
        			 var editbrand = $(this).closest('tr').children('td.brandname').text();
        			 
        			var editspr= $(this).closest('tr').children('td.spr').text()
        			
        			 var editspw = $(this).closest('tr').children('td.spw').text();
        			 
        			 $.post('editprices.php',{editbrand:editbrand,editspr:editspr,editspw:editspw,},function(data){
        				 $(this).html(data);
        				 console.log(data);
        			 });
        				
        
        		});
         $('#first').DataTable();
          $('#second').DataTable();
		  $('#secondr').DataTable();
              
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
              <a class="nav-link" href="dprofits.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Daily Analysis</span>
              </a>
            </li>
			
			
        
            
          </ul>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
		
			  <!-- Taxes starts here-->
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   
                                                
                                                
                                                <table class="table  table-striped table-bordered table-hover" id="secondr">
                                   
                                    <thead>
                                        <tr>
                                          
                    						<th>Month</th>
                    						<th>Sold</th>
                    						<th>BP</th>
											<th>SP</th>
											<th>Total Sale</th>
                    						<th>Profit</th>
											<th>Expenses</th>
											<th>In Stock</th>
											<th>Report</th>
                    						
                    						
                    					
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
										 $warukenyajohn = date("m/Y");
                                               $resultt = mysqli_query($con,"select thismonth,SUM(qnty) as qnty,SUM(bp) as bp,SUM(sp) as sp,SUM(total) as sales,SUM(profit)as profit from profits group by thismonth order by profit DESC"); 
                                                while($row = mysqli_fetch_array($resultt)){
													
													
                                                
                                                echo "<tr>";
                            					echo '<td>'.$row['thismonth'].'</td>';
                            					echo '<td>'.$row['qnty'].'</td>';
                            					echo '<td>'.$row['bp'].'</td>';
                            					echo '<td>'.$row['sp'].'</td>';
												echo '<td>ksh '.number_format($row['sales'],2).'</td>';
												echo '<td> Ksh '.number_format($row['profit'],2).'</td>';
												
												$leo = $row['thismonth'];
                                                $allsuppliers = mysqli_query($con,"select SUM(amount) as expenses from pettycash where dated LIKE '%$leo%'");
												$suppliersrow = mysqli_fetch_array($allsuppliers);
												echo '<td>'.$suppliersrow['expenses'].'</td>';
												$getq = mysqli_query($con,"select SUM(units) as units from products");
												$getqq = mysqli_fetch_array($getq);
												$yui = $row['profit'];
												$uyii = $row['sales'];
												
												$perce = ($yui/$uyii)*100;
                                                /*echo '<td>'.$getqq['units'].'</td>';*/
												echo '<td>'.number_format($perce,2).' %</td>';
												echo '<td><a href="thismonthpdf.php?m='.$row['thismonth'].'&exp='.$suppliersrow['expenses'].'">print here</a></td>';
                                                echo "</tr>";
                                                }
                                                ?>
                                        
                                    </tbody>
                                </table>
                  </div>
                </div>
              </div>
			  
			  <!--taxes end here-->
					 
            </div>
			
			
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
           
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