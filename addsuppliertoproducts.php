<?php
session_start();
error_reporting(0);
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
	<style>
	.pw_prompt {
    position:fixed;
    left: 50%;
    top:50%;
    margin-left:-100px;
    padding:15px;
    width:400px;
    border:1px solid black;
	background-color:black;
	color:white;
	
}
.pw_prompt label {
    display:block; 
    margin-bottom:5px;
}
.pw_prompt input {
    margin-bottom:10px;
}

.tax{
	font-size:0.75em;
}
	</style>
      <script>
     $(document).ready(function(){
		 /*
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
		if(password=='12345'){
		 $(".main-panel").show();
	  }else{
		  window.open('','_self').close();
	  }
       
    }
});

	*/  
	  
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
        
        	 
        	
        		
        		$(".editcommit").hide();
        	 
        	 $(".editbtn").click(function(){
        	      var thisbrand = $(this).closest('tr').children('td.brandname').text();
        			var b = prompt("Enter new Buying Price for "+thisbrand);
        			 $(this).closest('tr').children('td.bp').text(b);
        			
        			 var s = prompt("Enter new Retail Price for "+thisbrand);
        			 $(this).closest('tr').children('td.spr').text(s)
        			 var w = prompt("Enter new Wholesale Price for "+ thisbrand);
        			 $(this).closest('tr').children('td.spw').text(w);
					 
					 if((s !== null && s !== '')||(b !== null && b !== '')||(w !== null && w !== '')){
						$(this).closest('tr').children('td.editcommit').show();	 
					 }else{
						 alert("You didn't enter some data");
					 }
        			 
        			
        
        		});
				
				 $(".qt").click(function(){
					 var thisbrand = $(this).closest('tr').children('td.brandname').text();
					 var qnt  =$(this).text();
        			var b = prompt("Current " + thisbrand + " count is " + qnt+". Kindly enter the new count");
					
					 if(b !== null && b !== ''){
					   var lizy = confirm("Do you want to add "+ b +' count to '+ thisbrand+'?');
					   if(lizy){
						   $.post('addqnty.php',{b:b,thisbrand:thisbrand,},function(data){ 
						   alert("Added");
						   $('.hapa').html(data);
						   });
					   }else{
						   alert("Bye");
					   }
					}else{
						alert("Data Cant be empty");
					}
					
        			 
        			 
        			 
        
        		});
        		
        	 $(".editcommit").click(function(){
        		 
        			 var editbrand = $(this).closest('tr').children('td.brandname').text();
        			 
        			var editspr= $(this).closest('tr').children('td.spr').text()
        			
        			 var editspw = $(this).closest('tr').children('td.spw').text();
        			 var bp = $(this).closest('tr').children('td.bp').text();
        			 
        			 $.post('editprices.php',{editbrand:editbrand,editspr:editspr,editspw:editspw,bp:bp,},function(data){
        				 $(this).html(data);
        				 console.log(data);
        			 });
        				
        
        		});
				
				$('.delbtn').click(function(){
					var todelete = $(this).closest('tr').children('td.brandname').text();
					
					var z = confirm("Do you want to delete "+todelete);
					if(z){
						 $.post('editprices.php',{todelete :todelete ,},function(data){
        				 
        				 console.log(data);
						 $('.res').html(data);
        			 });
					}else{
						alert("Product will exist");
					}
					
				});
				
				$('.tax').click(function(){ 
				var taxv = $(this).val();
				
				var taxablebrand = $(this).closest('tr').children('td.brandname').text();
				var zt = confirm("Do you want to make "+taxablebrand + " "+taxv);
				if(zt){
					if(taxv=="taxable"){ var tax=1;}else{var tax=0;}
						 $.post('editprices.php',{tax :tax ,taxablebrand:taxablebrand,},function(data){
        				 
        				 console.log(data);
						 $('.res').html(data);
        			 });
					}else{
						alert(taxablebrand+" will remain "+taxv);
					}
				
				});
				
				
				
         $('#first').DataTable();
          $('#second').DataTable();
              
          });
      
  </script>
  </head>
  <body>
      <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html">
            <img class="thumbnail"  height="100px" width="20px" src="<?php echo $userphoto;?>" alt="logo" /> </a>
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
              <a class="nav-link" href="productsexcel.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Export To Excel</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="stockpdf.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Export Stock as pdf</span>
              </a>
            </li>
            
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <span class="res"></span>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h2>Products</h2>
                    <p><b>Note:</b> To edit quantities, click on the quantity you want to edit</p>
                    <table class="table .table-striped" id="first">
                                    <thead>
                                        <tr>
                                          
                    						<th>Brand</th>
                    						<th>Buying Price</th>
                    						<th>Quantity</th>
											<th>Retail Price</th>
                    						<th>Best Price</th>
											
											<th>Profit</th>
                    						<th>Edit</th>
											<th>Delete</th>
                    						<th>Submit</th>
                    						
                    					
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                               $resultt = mysqli_query($con,"select * from products"); 
                                                while($row = mysqli_fetch_array($resultt)){
													
													$profitmargin = ((($row['spw']) - ($row['bp']))/$row['bp'])*100;
                                                
                                                echo "<tr>";
                            					
                            					echo '<td class="brandname">'.$row['brand'].'</td>';
                            					echo '<td class="bp">'.number_format($row['bp'],2).'</td>';
                            					echo '<td class="qt">'.$row['units'].'</td>';
                            					echo '<td class="spr">'.$row['spr'].'</td>';
                            					echo '<td class="spw">'.$row['spw'].'</td>';
                            					$tax = $row['taxable'];
                            					if($tax==1){ $taxable="taxable";}else{$taxable="not taxable";}
												if($tax==1){ $taxableb="not taxable";}else{$taxableb="taxable";}
												//echo '<td><button class="tax primary" value="'.$taxableb.'">'.number_format($profitmargin,2).' %<br>'.$taxable.'</br>(click here to make it '.$taxableb.')</button></td>';
												echo '<td><button type="button" class="btn btn-dark btn-fw" onClick="MyWindow=window.open(\'addbrands2.php?brand='.$row['brand'].'\',\'MyWindow\',\'width=800,height=700\'); return false;">Add Suppliers </button></td>';
												echo '<td><span class="editbtn">&#9998;</span></td>';
												echo '<td><span style="color:red;font-size:1.5em;" class="delbtn">&#128465;<span></td>';
                            				    echo '<td class="editcommit btn">&#x267B;</td>';
                                                
                                                echo "</tr>";
                                                }
                                                ?>
                                        
                                    </tbody>
                                </table>
                         
								<span class="hapa"></span>
                        
                  </div>
                </div>
              </div>
             
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Under Stocked Products</h4>
                    
                    <table class="table table-bordered" id="second">
                      <thead>
                        <tr>
                         
                          <th> Product </th>
                          <th> Stock </th>
                          <th> Profit Margin </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                                               $resultty = mysqli_query($con,"select * from products where units<=100"); 
                                                while($rowy = mysqli_fetch_array($resultty)){
													
													$profitmargin = ((($rowy['spw']) - ($rowy['bp']))/$rowy['bp'])*100;
                                                
                                                echo "<tr>";
                            					
                            					echo '<td class="brandname">'.$rowy['brand'].'</td>';
                            					echo '<td>'.$rowy['units'].'<div class="progress">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: '.$rowy['units'].'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="50"></div>
                            </div></td>';
                            					
												echo '<td>'.number_format($profitmargin,2).' % including VAT</td>';
												
                                                
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
   
    <!-- End custom js for this page-->
  </body>
</html>