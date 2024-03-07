<?php
session_start();
error_reporting(0);
$userid = $_SESSION['username'];
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css"> 
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <script src="jquery-3.3.1.min.js"></script>
    <!--<script src="jquery.dataTables.min.js"></script-->
     <!--<link rel="stylesheet" href="jquery.dataTables.min.css"> -->
     <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
     <link rel="stylesheet" href="jquery.dataTables.min.css">
    <!--<link href="DataTables/datatables.min.css" rel="stylesheet">-->
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
    
    <title>ADD STOCK</title>
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
            div.dataTables_wrapper {
                width: 1200px;
                margin: 0 auto;
                margin-bottom: 50px;
            }
			select {
				width: 100px;
			}
			.must{
			    color:red;
			}
			.table td, .table th {
                vertical-align: middle;
                font-size: 0.875rem;
                line-height: 1;
                white-space: nowrap;
                padding: 12px 15px;
                height: 50px;
            }
	    </style>
</head>
<body style="">
    <div class="content-wrapper" style="background:#ffffff">
        <div class="">
            <div class="card-header" style="display: flex;align-items: center;gap: 900px;">
                    <h4>ADD STOCK</h4>
					<div style="display: flex; align-items: center; gap: 50px">
						<button onclick = "myWindow = window.open('importstock.php','MyWindow','width=800,height=600','toolbar=no','menubar=no');"class="btn btn-warning">
							 Import Stock
						</button>
						<button class="btn btn-success add">ADD</button>
					</div>
                </div>
            <div>
           
						<script>
                            $(document).ready(function() {
                                $('#product').change( function(){
                                    var productforbarcode = $('#product').val();
                                    var productforcategory = $('#product').val();
                                    var productforsubcategory = $('#product').val();
                                    var productforsupplier = $('#product').val();
                                    var productforshelf = $('#product').val();
                                    var productformeasure = $('#product').val(); 
                                    var productforretail = $('#product').val();
                                    var productforwholesale = $('#product').val();
                                    var productforstock = $('#product').val();
                                    $.post('addcategory.php',{productforstock:productforstock,},function(data){
                                            console.log("stock:",data);
                                            $('#stock').val(data);
                                        }
                                    );
                                    $.post('addcategory.php',{productforretail:productforretail,},function(data){
                                            console.log(data);
                                            $('#retail').val(data);
                                        }
                                    );
                                    $.post('addcategory.php',{productforwholesale:productforwholesale,},function(data){
                                            console.log(data);
                                            $('#wholesale').val(data);
                                        }
                                    );
                                    $.post('addcategory.php',{productformeasure:productformeasure,},function(data){
                                            console.log(data);
                                            $('#measure').val(data);
                                        }
                                    );
                                    
                                    $.post('addcategory.php',{productforshelf:productforshelf,},function(data){
                                            console.log(data);
                                            $('#shelf').val(data);
                                        }
                                    );
                                    
                                    $.post('addcategory.php',{productforsupplier:productforsupplier,},function(data){
                                            console.log("supplier: ",data);
                                            $('#supplier').val(data);
                                        }
                                    );
                                    
                                    $.post('addcategory.php',{productforbarcode:productforbarcode,},function(data){
                                            console.log(data);
                                            $('#barcode').val(data);
                                        }
                                    );
                                    
                                    $.post('addcategory.php',{productforcategory:productforcategory,},function(data){
                                        console.log(data);
                                         $('#category').val(data);
                                    });
                                    
                                    $.post('addcategory.php',{productforsubcategory:productforsubcategory,},function(data){
                                        console.log(data);
                                         $('#subcategory').val(data);
                                    });
                                });
                            });
                                      // Function to calculate and update total pieces
                                      function updateTotalPieces() {
                                        var units = parseInt(document.getElementById('units').value);
                                        var subunits = parseInt(document.getElementById('subunits').value);
										var cost = parseInt(document.getElementById('cost').value);

                                        // Check if units and subunits are valid numbers
                                        if (!isNaN(units) && !isNaN(subunits)) {
                                          var totalPieces = units * subunits;
                                            console.log(totalPieces);
                                          // Update the "totalpieces" input field with the calculated value
                                          document.getElementById('totalPieces').value = totalPieces;
										  if(!isNaN(cost)){
											var costPerUnit = parseFloat((cost/units).toFixed(2));
											var costPerSubUnit = parseFloat((cost/totalPieces).toFixed(2));
											document.getElementById('costUnit').value = costPerUnit;
											document.getElementById('costSubUnit').value = costPerSubUnit;
										  }
                                        }
                                      }
									  function updateBalance(){
										var amtPaid = parseInt(document.getElementById('paidToSupplier').value);
										var balance = document.getElementById('balanceToSupplier');
										var cost = parseInt(document.getElementById('cost').value);

										if(!isNaN(amtPaid) && !isNaN(cost)){
											var toPay = cost - amtPaid;

											balance.value = toPay;
										}

									  }
									  document.getElementById('paidToSupplier').addEventListener('input', updateBalance);
                                      // Attach event listeners to "units" and "subunits" input fields
                                      document.getElementById('units').addEventListener('input', updateTotalPieces);
                                      document.getElementById('subunits').addEventListener('input', updateTotalPieces);


                                    </script>
						<script>
							$(document).ready(function() {
							    console.log('ready');
								document.querySelector('.add').addEventListener('click', function (){
								    console.log("Clicked");
									// Extract data from the first row
									var supplier = $('#supplier option:selected').text();
									var invoiceNumber = $('#innvoice').val();
									var invoiceDate = $('#invoiceDate').val();
									var cost = $('#cost').val();
									var paidToSupplier = $('#paidToSupplier').val();
									var balanceToSupplier = $('#balanceToSupplier').val();
									var taxable = $('#taxable').prop('checked');

									// Extract data from the second row
									var product = $('#product option:selected').text();
									var barcode = $('#barcode').val();
									var serialNumber = $('#serialnumber').val();
									var category = $('#category option:selected').text();
									var subcategory = $('#subcategory option:selected').text();
									var units = $('#units').val();
									var subunits = $('#subunits').val();
									var totalPieces = $('#totalPieces').val();

									// Extract data from the third row
									var costUnit = $('#costUnit').val();
									var reorder = $('#reorder').val();
									var costSubUnit = $('#costSubUnit').val();
									var measure = $('#measure option:selected').text();
									var expiryDate = $('#expiry').val();
									var retailPrice = $('#retail').val();
									var wholesalePrice = $('#wholesale').val();
									var shelf = $('#shelf option:selected').text();

									$.post('helpers/insertproducts.php', 
										{
											supplier : supplier,
											invoiceNumber : invoiceNumber,
											invoiceDate : invoiceDate,
											cost : cost,
											paidToSupplier : paidToSupplier,
											balanceToSupplier :                     balanceToSupplier,
											taxable : taxable,
											product : product,
											barcode : barcode,
											serialNumber :serialNumber,
											category : category,
											subcategory : subcategory,
											units : units,
											subunits :  subunits,
											totalPieces : totalPieces,
											costUnit : costUnit,
											reorder : reorder,
											costSubUnit : costSubUnit,
											measure : measure,
											expiryDate : expiryDate,
											retailPrice : retailPrice,
											wholesalePrice : wholesalePrice,
											shelf : shelf
										}, 
										function(data) {
										    alert(data);
										    
										        
										        setTimeout(function() {
                                                  location.reload();
                                                }, 1500); // 2000 milliseconds = 2 seconds
										    
										    
										}
									);

								});
							});								
							
						</script>
            </div>
        </div>
        <div class="mt-4">
            <div class="card-heading">
                STOCK ADDED TODAY
            </div>
            <div>
                <table id="existingStock" class="table table-stripe">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Barcode</th>
                            <th>Supplier</th>
							<th>Invoice No.</th>
							<th>Time</th>
							<th>Units</th>
							<th>Subunits</th>
							<th>Total Cost</th>
							<th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
					       	<?php
							$stock = mysqli_query($con, "SELECT * FROM  invoices WHERE DATE(addedOn) = CURDATE() ORDER BY addedon DESC");
					 		$count = 0; 
					 		while($items = mysqli_fetch_array($stock) ){ 
					 		    $code = $items['barCode'];
					 		    $supplierid = $items['supplierid'];
					 			$invoice = mysqli_query($con, "SELECT * FROM  inventory WHERE barcode = '$code' OR brand = '$code'"); 
					 			$invoices = mysqli_fetch_array($invoice); 
					 			$count++; 
					 			echo "<tr>"; 
					 			echo '<td>'.$count.'</td>'; 
								// product
					 			echo '<td>'.$items['product'].'</td>'; 
					 			echo '<td>'.$items['barCode'].'</td>';
					 		    // 	Supplier
					 		    $supp = mysqli_query($con, "SELECT * FROM suppliers where supplierid = '$supplierid'");
					 		    $supplier = mysqli_fetch_array($supp);
					 		    echo '<td>'.$supplier['supplier'].'</td>';
								// Invoice Number
					 			echo '<td>'.$items['invoicenumber'].'</td>'; 
								// Invoice Date
					 			echo '<td>'.$items['addedOn'].'</td>'; 
								// Units
					 			echo '<td>'.$items['units'].'</td>'; 
								// subunits
					 			echo '<td>'.$items['subunits'].'</td>'; 
								// Total Cost
					 			echo '<td>'.$items['totalcost'].'</td>'; 
					 			echo '<td><button class="btn btn-outline-warning" data-confirm = "'.$items['id'].'">Approve</button></td>';
					 			echo '</tr>'; 
					 		} 
						?>
					</tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
				// Get the table by its ID
		var table = document.getElementById("example");

		// Loop through each row in the table
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.classList.add("row"); // Add the "row" class to each <tr> element
			
			// Loop through each cell (td) in the row
			for (var j = 0; j < row.cells.length; j++) {
				var cell = row.cells[j];
				cell.classList.add("col"); // Add the "col" class to each <td> element
			}
		}

        $(document).ready(function(){
			$('.addsupplier').click(function() {
				// Get supplier's name
				var newsupplier = prompt("Enter Supplier's Name");
				
				if (newsupplier !== null && newsupplier.trim() !== "") {
					if (confirm("Confirm you want to add " + newsupplier + " to suppliers")) {
						$.post('addcategory.php', { newsupplier: newsupplier }, function(data) {
							// Remove available suppliers
							$('#supplier').empty();
							// Put the new list of suppliers
							$('#supplier').append(data);
						});
					}
				} else {
					alert("Supplier Name Cannot Be Empty");
				}
			});

			$('.addproduct').click(function() {
				// Get product's name
				let product = prompt("Enter Product's Name");
				if(product.length >= 40){
				    alert("PRODUCT NAME IS TOO LONG. PLEASE ENTER A SHORTER NAME");
				}else{
    				if (product !== null && product.trim() !== "") {
    					if (confirm("Confirm you want to add " + product + " to products")) {
    						// Perform further actions here, like sending data to the server
    						$.post('addcategory.php',{product:product}, function(data){
    							console.log(data);
    							$('#product').empty();
    
    							$('#product').append(data);
    						});
    						// and updating the product list
    					}
    				} else {
    					alert("Product Name Cannot Be Empty");
    				}
				}
			});

			$('.addshelf').click(function() {
				// Get shelf's name
				let shelf = prompt("Enter Shelf's Name:");
				
				if (shelf !== null && shelf.trim() !== "") {
					if (confirm("Confirm you want to add " + shelf + " to shelves")) {
						// Perform further actions here, like sending data to the server
						$.post('addcategory.php',{shelf:shelf}, function(data){
							console.log(data);
							$('#shelf').empty();

							$('#shelf').append(data);
						});
						// and updating the shelf list
					}
				} else {
					alert("Shelf Name Cannot Be Empty");
				}
			});

			$('#addMeasure').click(function() {
				// Get measurement input from the user
				var measure = prompt('Enter A Measurement (e.g. kilograms, litres)');
				
				if (measure !== null && measure.trim() !== "") {
					if (confirm("Confirm you want to add " + measure + " to measurements")) {
						// Perform further actions here, like sending data to the server
						// and updating the measurement list
						$.post('addcategory.php',{measure:measure},function(data){
							$('#measure').empty();
							$('#measure').append(data);
						})					
					}
				} else {
					alert("Measurement Name Cannot Be Empty");
				}
			});

					$('.addcategory').click(function(){
                                  var cat = prompt("Enter category name");
                                  var catuppercase = cat.toUpperCase();
                                  if (confirm("Do you want to add "+catuppercase ) == true) {
									  $.post('addcategory.php',{catuppercase:catuppercase,},function(data){
											$('#category').empty();
											$('#category').append(data);
									  });
									} else {
									   alert( "You pressed no");
									}
                                });
								
								$('.addsubcategory').click(function(){
									var cat = prompt("Enter the sub category name");
                                  var subcatuppercase = cat.toUpperCase();
                                  if (confirm("Do you want to add "+subcatuppercase) == true) {
									  $.post('addcategory.php',{subcatuppercase:subcatuppercase,},function(data){
											$('#subcategory').empty();
											$('#subcategory').append(data);
									  });
									} else {
									   alert( "You pressed no");
									}
								
                                  
                                });
								
								// $('#category').change(function(data){
								// 	var thiscategory = $(this).val();
								// 	$.post('addcategory.php',{thiscategory :thiscategory,},function(data){
								// 		  $('#subcategory').html(data);
								// 		  console.log(data);
								// 	  });
								// });
								
								
            $('#unitcost').keyup(function(){
            	var thisunitcost = $(this).val();
            	var thisitemunit = $("#itemunit").val();
            	var thistotalunitcost = thisunitcost*thisitemunit;
            	$("#totalunitcost").val(thistotalunitcost);
            	
            	var thissubunits = ($("#subunits").val())*thisitemunit;
            	$("#subunitcost").val(thistotalunitcost/thissubunits);
            });
			
			$('.bk').hide();
            
            
            $('#paid').keyup(function(){
            	var thispaid = $(this).val();
            	var thistotalunitcost2 = $("#totalunitcost").val();
            	var ball = thispaid  - thistotalunitcost2;
            	$("#balance").val(ball);
            });
			
			$('#itemsupplier').change(function(){ 
			var sup = $(this).val(); 
    			$.post('getproduct.php',{sup:sup,},function(data){
    				$("#itembrand").html(data);
    				$('.bk').show();
    				var gid = 'bulk.php?gid='+sup;
    				var url = '<button type="button" class="btn btn-danger btn-fw bk" onClick="MyWindow=window.open(\''+gid+'\',\'MyWindow\',\'width=800,height=600\'); return false;">Add Products in bulk </button>';
    				$('.cute').html(url);
				});
			});
			
        });
    
        $(document).ready(function(){
            $('#existingStock').DataTable();
            // $('#example').DataTable({scrollX:true,"searching": false,"bLengthChange" : false,"info":false});
            
        });
    </script>
    
    <!--<script src="DataTables/datatables.min.js"></script>-->
    <script>
        
        let inactivityTimer;
        const inactivityTime = 2 * 60 * 1000; // 2 minutes in milliseconds
    
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
</body>
</html>