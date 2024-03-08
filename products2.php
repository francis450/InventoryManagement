 <?php 
 include('connection.php');?>
   <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		/* var pin = prompt("Enter password");
	  if(pin=='12345'){
		  alert("Welcome Admin");
	  }else{
		  window.open('','_self').close();
	  }*/
	  
	  
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
        			var b = prompt("Enter new Buying Price");
        			 $(this).closest('tr').children('td.bp').text(b);
        			 var thisbrand = $(this).closest('tr').children('td.brandname').text();
        			 var s = prompt("Enter new Retail Price");
        			 $(this).closest('tr').children('td.spr').text(s)
        			 var w = prompt("Enter new Wholesale Price");
        			 $(this).closest('tr').children('td.spw').text(w);
        			 
        			$(this).closest('tr').children('td.editcommit').show();	
        
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
         $('#first').DataTable();
          $('#second').DataTable();
              
          });
      
  </script>
  

                           <div class="col-12 grid-margin">
                             <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Products</h4>
                                <table class="table .table-striped" id="first">
                                    <thead>
                                        <tr>
                                          
                    						<th>Brand</th>
                    					    <th>Barcode</th>
                    						<th>Quantity</th>
											<th>Retail Price</th>
                    						<th>Wholesale Price</th>
											
                    						<th>Category</th>
											<th>Sub Category</th>
											<th>Shelf</th>
                    						
                    						
                    					
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                               $resultt = mysqli_query($con,"select * from inventory where totalpieces > 0"); 
                                               
                                                while($row = mysqli_fetch_array($resultt)){
    												echo "<tr>";
                                    					echo '<td class="brandname">'.$row['brand'].'</td>';
                                    					echo '<td>'.$row['barcode'].'</td>';
                                    					echo '<td>'.$row['totalpieces'].'</td>';
                                    					echo '<td>'.$row['retail'].'</td>';
                                    					echo '<td>'.$row['wholesale'].'</td>';
        												echo '<td>'.$row['category'].'</td>';
        												echo '<td>'.$row['subcategory'].'</td>';
        												echo '<td>'.$row['shelf'].'</td>';
                                                    echo "</tr>";
                                                }
                                                ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                             </div>
                              </div>
                            
                            
                      