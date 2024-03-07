<?php
include('connection.php');
if(isset($_POST['expenseamount'])){
					$datedh = date("d/m/Y");
					  $csupplier = $_POST['expensedescription'];
					  $cdetails = $_POST['expenseaccount'];
					  $camount = $_POST['expenseamount'];
					  
					  mysqli_query($con,"insert into pettycash(account,description,amount,dated)values('$cdetails','$csupplier','$camount','$datedh')");
				  }
				  
				  if(isset($_POST['accountname'])){
					  $accountname= $_POST['accountname'];
					  
					  
					  mysqli_query($con,"insert into pettycashaccount(account,storeid)values('$accountname')");
				  }
				  
?>
<link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    
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
	<script>
	$(document).ready(function(){
		$('.addaccount').click(function(){
			var accountname = prompt("Enter Account name");
			if(accountname===""){
				alert("Account cant be empty!");
			}else{
				
				$.post('addpettycashaccout.php',{accountname:accountname,},function(data){
					$('.expenseaccount').html(data);
				});
			}
			
		});
	});
	</script>
    <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                   
<form class="form" method="post" enctype="multipart/form-data">
				  <div class="form-row">
					<div class="form-group">
					  <label for="expensedescription">Expense  Description</label>
					  <input type="text" class="form-control" id="expensedescription" name="expensedescription" placeholder="Expense description" required>
					</div>
				  </div>
				  
				   <div class="form-row">
					
					<div class="form-group">
					  <label for="expenseaccount">Choose Account</label>
					  <select class="expenseaccount" name="expenseaccount" id="expenseaccount">
					  <?php
					  $brandsuppliers = mysqli_query($con,"SELECT * FROM pettycashaccount");
					  while($brandsupplier=mysqli_fetch_array($brandsuppliers )){
						  echo '<option>'.$brandsupplier['account'].'</option>';
					  }
					  ?>
					  </select>
					  <span class="addaccount" style="color:green; font-size:2em;">+</span>
					</div>
					
				  </div>
				  
				  <div class="form-row">
					<div class="form-group">
					  <label for="expenseamount">Amount</label>
					  <input type="text" class="form-control" id="expenseamount" name="expenseamount" placeholder="Expense Amount" required>
					</div>
				  </div>

				  <button type="submit" class="btn btn-primary" >Submit</button>
				  
				</form>
				</div>
				</div>
				</div>