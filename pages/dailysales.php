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

?><!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Products</title>
    <!-- plugins:css -->
    <!-- Include jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Include DataTables Buttons and its dependencies -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

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
    <!--<script src="jquery-3.3.1.min.js"></script>-->
    <!--<script src="jquery.dataTables.min.js"></script>-->
    <style>
        .dt-buttons {
            float: left; 
        }
    </style>
    
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
            $('#first').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('#second').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            var dataTable = $('#fourth').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            dataTable.order([3, 'desc']).draw();

		    var secondy = $('#secondy').DataTable({
		        dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
		    });
		    
		    secondy.on('footerCallback', function(row, data, start, end, display) {
                var api = this.api();
                
                // Calculate the total for the "sales" column (assuming it's in the second column, index 1)
                var salesTotal = api.column(1, { page: 'current' }).data().sum();
                
                // Calculate the total for the "expenses" column (assuming it's in the third column, index 2)
                var taxTotal = api.column(2, { page: 'current' }).data().sum();;
                // Update the footer row with the calculated totals
                $(api.column(1).footer()).html('Total Sales: ' + salesTotal);
                $(api.column(2).footer()).html('Total Expenses: ' + taxTotal);
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
                    <a class="nav-link" href="dailysales.php">Daily</a>
                  </li>
               
                  <li class="nav-item">
                    <a class="nav-link" href="monthlysales.php">Monthly</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="annualsales.php">Annual</a>
                  </li>
        
            
          </ul>
		   <button type="button" class="btn btn-outline-info btn-fw" onClick="MyWindow=window.open('analytics/dailysales.php','MyWindow','width=1200,height=1080'); return false;">Analytics</button>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const generateButton = document.querySelector(".generate-sales");
                        const generateZ = document.querySelector(".generatez");
                        
                        generateButton.addEventListener("click", function(event) {
                            event.preventDefault();
                    
                            const startDateInput = document.querySelector(".sale-start");
                            const endDateInput = document.querySelector(".sale-end");
                    
                            const startDateValue = startDateInput.value;
                            const endDateValue = endDateInput.value;
                    
                            // Check if both dates are entered
                            if (!startDateValue || !endDateValue) {
                                alert("Please enter both start and end dates.");
                                return;
                            }
                    
                            const startDate = new Date(startDateValue);
                            const endDate = new Date(endDateValue);
                    
                            // Check if end date is later than start date
                            if (startDate > endDate) {
                                alert("End date must be later than start date.");
                                return;
                            }
                            // console.log(startDate+" "+endDate);
                            const encodedStartDate = encodeURIComponent(startDateValue);
                            const encodedEndDate = encodeURIComponent(endDateValue);
                            
                            const newUrl = `zreceipt.php?start_date=${encodedStartDate}&end_date=${encodedEndDate}`;
                            console.log(encodedStartDate+" "+encodedEndDate);
                    
                            // Redirect to the new URL
                            window.location.href = newUrl;
                        });
                        
                        generateZ.addEventListener("click", function(event) {
                            event.preventDefault();
                    
                            const startDateInput = document.querySelector(".zstart");
                            const endDateInput = document.querySelector(".zend");
                    
                            const startDateValue = startDateInput.value;
                            const endDateValue = endDateInput.value;
                    
                            // Check if both dates are entered
                            if (!startDateValue || !endDateValue) {
                                alert("Please enter both start and end dates.");
                                return;
                            }
                    
                            const startDate = new Date(startDateValue);
                            const endDate = new Date(endDateValue);
                    
                            // Check if end date is later than start date
                            if (startDate > endDate) {
                                alert("End date must be later than start date.");
                                return;
                            }
                    
                            const encodedStartDate = encodeURIComponent(startDateValue);
                            const encodedEndDate = encodeURIComponent(endDateValue);
                    
                            const newUrl = `pesapdf.php?start_date=${encodedStartDate}&end_date=${encodedEndDate}`;
                            console.log(newUrl);
                    
                            // Redirect to the new URL
                            window.location.href = newUrl;
                        });
                    });
                    </script>
              <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-header" style="display:flex;gap:10px">
                        <div class="card" >
                            <div class="card-header" style="padding:12px 20px"><h3>Sales Reports</h3></div>
                            <div style="flex-direction: row"class="card-body">
                                <!--<div class="card-heading">Sales Report</div>-->
        				        <input type="datetime-local" class="sale-start" name="start_date"/>
        				        <span>to</span>
        				        <input type="datetime-local" class="sale-end" name="end_date"/>
        				        <button class="btn btn-warning generate-sales">Generate</button>
    				        </div>
				        </div>
				        <div class="card" >
                            <div class="card-header" style="padding:12px 20px"><h3>Z-Report</h3></div>
                            <div style="flex-direction: row"class="card-body">
                                <!--<div class="card-heading">Sales Report</div>-->
        				        <input type="datetime-local" class="zstart" name="start_date"/>
        				        <span>to</span>
        				        <input type="datetime-local" class="zend" name="end_date"/>
        				        <button class="btn btn-info generatez">Generate</button>
    				        </div>
				        </div>
				    </div>
                    <div class="card-body">
                         <h4 class="card-title">Products Sold Today</h4>
                        <div class="card-heading"></div>
                    
                          <table class="table .table-striped" id="first">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qnty</th>
                                            <th>Total</th>
                    						<th>Date</th>
											<th>Cashier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										  $da = date("d/m/Y");
                                               $resultt = mysqli_query($con, "SELECT * FROM cart WHERE date(dated) = CURDATE() ORDER BY dated DESC"); 
                                                while($row = mysqli_fetch_array($resultt)){
                                                    
                                                    echo "<tr>";
                                                    // Product
                                					echo '<td>'.$row['product'].'</td>';
                                				    // 	Price
                                				    echo '<td>'.$row['price'].'</td>';
                                				    // Qnty
                                				    echo '<td>'.$row['qnty'].'</td>';
                                				    // Total
                                				    echo '<td>'.$row['total'].'</td>';
                                				    // Date
                                				    echo '<td>'.$row['dated'].'</td>';
                                				    $cartid = $row['salesid'];
                                				    $cashiers = mysqli_query($con, "SELECT cashier FROM receipts WHERE cartid = '$cartid'");
                                				    $cashier = mysqli_fetch_array($cashiers);
                                				    // Cashier 
                                				    echo '<td>'.$cashier['cashier'].'</td>';
                                                    echo "</tr>";
                                                }
                                                ?>
                                        
                                    </tbody>
                                </table
                  </div>
                </div>
                </div>
              <div class="mt-3">
                <div class="card">
                    <div class="card-header">
                    <h4 class="card-title">Products Performance Today</h4>
                    </div>
                  <div class="card-body">
                      <table class="table  table-striped table-bordered table-hover" id="second">
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Qnty</th>
                                    <th>B.P</th>
                                    <th>S.P</th>
                                  <th>Margin</th>
                                  <th>profit</th>
                                </tr>
                        </thead>
                        <tbody>
                                         <?php
										  $da = date("d/m/Y");
										       $productsqquery = "SELECT 
                                                product,
                                                SUM(profit) AS profit,
                                                SUM(qnty) AS quantity,
                                                STR_TO_DATE(thisday, '%d/%m/%Y') = CURDATE() AS thismonth,
                                                SUM(bp) AS cost,
                                                bp,
                                                sp
                                            FROM profits
                                            WHERE STR_TO_DATE(thisday, '%d/%m/%Y') = CURDATE()
                                            GROUP BY product
                                            ORDER BY profit DESC;
                                            ";
                                               $resultt = mysqli_query($con,$productsqquery);
                                                while($rowg = mysqli_fetch_array($resultt)){
														 echo "<tr>";
														    $cost = 0;
														    if($rowg['profit'] != 0 && $rowg['cost'] != 0)
														    $cost = ($rowg['profit']/$rowg['cost'])*100;
														    echo '<td>'.$rowg['product'].'</td>';
														    echo '<td>'.$rowg['quantity'].'</td>';
														    echo '<td>'.$rowg['bp'].'</td>';
														    echo '<td>'.$rowg['sp'].'</td>';
														    echo '<td>'.number_format($rowg['profit'],2).'</td>';
														    echo '<td>'.number_format($cost,0).'%</td>';
														 echo "</tr>";
                                                }
                                                ?>
												</tbody>
												</table>
												
												
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Taxes today <?php echo date("Y-m-d");?> is Ksh. 
                     <?php
										  $da = date("Y-m-d");
                                               
													
													
													$yuiit = mysqli_query($con,"select SUM(total) as total from cart where dated LIKE '%$da%' and tax='1'");
													while($rowg = mysqli_fetch_array($yuiit)){
														 
                            					
														$taxs = $rowg['total']*0.16;
														echo number_format($taxs,2);
														
													}
                                                
                                               
                                                
                                                ?></h4>
                   
                                                
                                                
                                                <table class="table  table-striped table-bordered table-hover" id="secondy">
                                    <thead>
                                        <tr>
                                          
                    						
                    						<th>Product</th>
                    						<th>Total</th>
											<th>Tax</th>
											<th>Time</th>
                    						
                    						
                    					
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
										  $da = date("Y-m-d");
                                               
													
													
													$yuiit = mysqli_query($con,"select * from cart where dated LIKE '%$da%' and tax='1'");
													while($rowg = mysqli_fetch_array($yuiit)){
														 echo "<tr>";
                            					
														$tax = $rowg['total']*0.16;
														echo '<td>'.$rowg['product'].'</td>';
														echo '<td>Ksh '.number_format($rowg['total'],2).'</td>';
														echo '<td class="pr">Ksh '.number_format($tax,2).'</td>';
														echo '<td>'.$rowg['dated'].'</td>';
														echo "</tr>";
														
													}
                                                
                                               
                                                
                                                ?>
                                        
                                    </tbody>
                                </table>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Best Seller Today is  
                     <?php
										  $da = date("Y-m-d");
													$yuiit = mysqli_query($con,"select product,SUM(profit) as profit,bp,sp from profits where date(dated)=curdate() group by product order by profit DESC LIMIT 1");
													while($rowg = mysqli_fetch_array($yuiit)){
														 
                            					
														$taxs = $rowg['product'];
														echo $taxs;
														
													}
                                                
                                               
                                                
                                                ?></h4>
                                <table class="table  table-striped table-bordered table-hover" id="fourth">
                                    <thead>
                                        <tr>
                    						<th>Product</th>
                    						<th>B.Price</th>
                    						<th>Retail</th>
                    						<th>Qnty</th>
                    						<th>Margin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
										  $da = date("Y-m-d");
                                               
													$gettopproduct = mysqli_query($con,"select product,sum(qnty) as qnty,SUM(profit) as profit,bp,sp from profits where date(dated)=curdate() group by product order by profit DESC");
                                                    while($getpr = mysqli_fetch_array($gettopproduct )){
                                                        echo '<tr>';
                                                            echo '<td>'.$getpr['product'].'</td>';
                                                            echo '<td>'.$getpr['bp'].'</td>';
                                                            echo '<td>'.$getpr['sp'].'</td>';
                                                            echo '<td>'.$getpr['qnty'].'</td>';
                                                            echo '<td>'.number_format($getpr['profit'],2).'</td>';
                                                        echo '</tr>';
                                                    }
                                                ?>
                                        
                                    </tbody>
                                </table>
                  </div>
                </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
                
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
    <script src="productsfilter.js"></script>
  </body>
</html>