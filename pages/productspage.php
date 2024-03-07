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
    <title>Products Page</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
	 <link rel="stylesheet" href="jquery.dataTables.min.css">
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
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="jquery-3.3.1.min.js"></script>
    <script src="jquery.dataTables.min.js"></script>
     <!-- Include DataTables Buttons and its dependencies -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
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
    .point{
        cursor:pointer;
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
        $(".editcommit").hide();

        $(".editbtn").click(function () {
            var editButton = $(this);
        
            var editbrand = $(this).closest('tr').find('#brandbutton').text();
            var bp = prompt("Enter new Buying Price for " + editbrand);
            var editspr = prompt("Enter new Retail Price for " + editbrand);
            var editspw = prompt("Enter new Wholesale Price for " + editbrand);
            // console.log(editbrand+bp+editspr+editspw)
            if ((bp !== null && bp !== '') || (editspw !== null && editspw !== '') || (editspr !== null && editspr !== '')) {
                $.post('editprices.php', {
                    editbrand: editbrand,
                    editspr: editspr,
                    editspw: editspw,
                    bp: bp,
                }, function (data) {
                        $(editButton).closest('tr').find('td.bp').text(bp);
                        // console.log('->'+$(editButton).closest('tr').find('td.bp').text())
                        $(editButton).closest('tr').find('td.spr').text(editspr);
                        // console.log('-->'+$(editButton).closest('tr').find('td.spr').text())
                        $(editButton).closest('tr').find('td.spw').text(editspw);
                });
            } else {
                alert("You didn't enter some data");
            }
        });

		
		$(".brandbutton").click(function(){
		    var brandbutton = $(this);
            var editt = $(this).text();
            var brand = confirm("Do you want to edit " + $(this).text() + "?");
            var editedbrand;
            if(brand){
                editedbrand = prompt("Enter New Name ",$(this).text());
            }
            if (editedbrand) {
                $.post('editprices.php',{editedbrand:editedbrand,editt:editt},function(data){
                    // $('.hapa').html(data);
                    // console.log(data);
                    $(brandbutton).closest('tr').find('#brandbutton').text(editedbrand)
                });
            } else {
                console.log("Product Cannot Be Empty");
            }
        });
                $(".qt").click(function(){
                    var qnty = $(this);
					 var thisbrand = $(this).closest('tr').find('#brandbutton').text();
					 var qnt  =$(this).text();
        			var b = prompt("Current " + thisbrand + " count is " + qnt+". Kindly enter the new count");
					
					 if(b !== null && b !== ''){
					   var lizy = confirm("Do you want to add "+ b +' count to '+ thisbrand+'?');
					   if(lizy){
						   $.post('addqnty.php',{b:b,thisbrand:thisbrand,},function(data){ 
    						   alert("Added");
    						  // $('.hapa').html(data);
    						  $(qnty).closest('tr').find('.qt').text(b);
						   });
					   }else{
						   alert("Bye");
					   }
					}else{
						alert("Data Cant be empty");
					}
        		});
        		$(".bar").click(function(){ 
        		    var bar = $(this);
        		     var brand = $(this).closest('tr').find('#brandbutton').text();
        		     console.log("Brand: ",brand);
        		     var currentBar = $(this).text();
        		     // console.log("Barcode ",currentBar);
        		     var newbar;
        		     if (currentBar) {
        		         one = alert("Do You Want to Change "+brand+" Barcode?");
        		         newbar = prompt("Enter Barcode to replace: "+currentBar);
        		      } else {
        		          var two = alert("Do you want to add a barcode to "+ brand);
        		          newbar = prompt("Enter Barcode: ");
        		      }
        		      console.log(newbar); 
        		      if(newbar)
        		      $.post("editprices.php",{brand:brand, currentBar:currentBar, newbar:newbar,},function(data){
        		          //$('.hapa').html(data);
        		          $(bar).closest('tr').find('.bar').text(newbar);
        		      });
        		  });
        		
        		
        		$('.shelf').click(function(){
                    var thisCell = $(this);  // Store a reference to the clicked cell
                    var thisbrand = thisCell.closest('tr').find('#brandbutton').text();
                    var shelf = thisCell.text();
                    var b = prompt(thisbrand + " is in " + shelf + ". Kindly enter the new shelf");
                    if (b !== null && b !== '') {
                        b = b.toUpperCase()
                        var lizy = confirm("Do you want to add " + thisbrand + ' to shelf ' + b + '?');
                        if (lizy) {
                            $.post('addqnty.php', { shelf: b, thisbrand: thisbrand }, function (data) {
                                // Update the content of the clicked cell with the response data
                                thisCell.text(data);
                            });
                        } else {
                            alert("Bye");
                        }
                    } else {
                        alert("Data can't be empty");
                    }
                });


                $('.category').click(function(){
                    var thisCell = $(this);  // Store a reference to the clicked cell
                    var thisbrand = thisCell.closest('tr').find('#brandbutton').text();
                    var category = thisCell.text();
                    var b = prompt(thisbrand + " is a " + category + ". Kindly enter the new category");
                
                    if (b !== null && b !== '') {
                        b = b.toUpperCase()
                        var lizy = confirm("Do you want to add " + thisbrand + ' to category ' + b + '?');
                        if (lizy) {
                            $.post('addqnty.php', { category: b, thisbrand: thisbrand }, function (data) {
                                // Update the content of the clicked cell with the response data
                                thisCell.text(data);
                            });
                        } else {
                            alert("Bye");
                        }
                    } else {
                        alert("Data can't be empty");
                    }
                });

        		$('.subcategory').click(function(){
                    var thisCell = $(this);  // Store a reference to the clicked cell
                    var thisbrand = thisCell.closest('tr').find('#brandbutton').text();
                    var subcategory = thisCell.text();
                    var b = prompt(thisbrand + " is a " + subcategory + ". Kindly enter the new subcategory");
                
                    if (b !== null && b !== '') {
                        b = b.toUpperCase()
                        var lizy = confirm("Do you want to add " + thisbrand + ' to subcategory ' + b + '?');
                        if (lizy) {
                            $.post('addqnty.php', { subcategory: b, thisbrand: thisbrand }, function (data) {
                                // Update the content of the clicked cell with the response data
                                thisCell.text(data);
                            });
                        } else {
                            alert("Bye");
                        }
                    } else {
                        alert("Data can't be empty");
                    }
                });


        		$('.measure').click(function(){
                    var thisCell = $(this);  // Store a reference to the clicked cell
                    var thisbrand = thisCell.closest('tr').find('#brandbutton').text();
                    var measure = thisCell.text();
                    var b = prompt(thisbrand + " is in " + measure + "'s. Kindly enter the new measure");
                
                    if (b !== null && b !== '') {
                        b = b.toUpperCase()
                        var lizy = confirm("Do you want to add " + thisbrand + ' to measure ' + b + '?');
                        if (lizy) {
                            $.post('addqnty.php', { measure: b, thisbrand: thisbrand }, function (data) {
                                // Update the content of the clicked cell with the response data
                                thisCell.text(data);
                            });
                        } else {
                            alert("Bye");
                        }
                    } else {
                        alert("Data can't be empty");
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
				$('.delbtn').click(function () {
                      var row = $(this).closest('tr'); // Get the row to delete
                      var todelete = row.find('#brandbutton').text();
                    
                      var z = confirm("Do you want to delete " + todelete);
                      if (z) {
                        $.post('editprices.php', { todelete: todelete }, function (data) {
                          // Assuming your AJAX request was successful, remove the row from the DataTable
                          console.log("DELETE: "+data)
                          if (data != '') {
                            var table = $('#first').DataTable(); // Get the DataTable instance
                            table.row(row).remove().draw(); // Remove the row and redraw the table
                          } else {
                            alert("Error deleting product");
                          }
                        });
                      } else {
                        alert("Product will exist");
                      }
                    });
				$('.tax').click(function(){ 
				    var tax = $(this);
    				var taxv = $(this).val();
    				var taxablebrand = $(this).closest('tr').find('#brandbutton').text();
    				if(taxv){
    				    var zt = confirm("Do you want to make "+taxablebrand + " taxable?");
    				}else{
    				    var zt= confirm("Do you want to make "+taxablebrand + " Untaxable?");
    				}
    				if(zt){
    					if(taxv==0){ var tax=1;}else{var tax=0;}
    						 $.post('editprices.php',{tax :tax ,taxablebrand:taxablebrand,},function(data){
            				 if(taxv){
            				     $(tax).closest('tr').find('.tax').text(tax);
            				 }
            				 
            			    });
    				
    				}else{
    						alert(taxablebrand+" will remain "+taxv);
    				}
				
				});
				
				
				
         $('#first').DataTable({
             dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                        
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        },
                        customize: function (doc) {
                            // Check if doc.content is an array, and initialize it if necessary
                            if (!Array.isArray(doc.content)) {
                                doc.content = [];
                            }
        
                            doc.content.unshift({
                                // console.log(in here)
                                text: 'Custom Header',
                                fontSize: 16,
                                alignment: 'center',
                                margin: [0, 0, 0, 12] // Adjust margin as needed
                            });
                            console.log('doc'+ doc);
                        }
                    }
                ]
         });
          $('#second').DataTable({
              dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    }
                ]
          });
          $('#third').DataTable({
              dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    }
                ]
          });
          $('#fourth').DataTable({
              dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    }
                ]
          });
          $('#fifth').DataTable({
              dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2]
                        }
                        
                    }
                ]
          });
          });
      
  </script>
  </head>
  <body>
      <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <!-- partial:partials/_navbar.html -->
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
              <a class="nav-link" href="addsupplierstoproducts.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Add Suppliers to products</span>
              </a>
            </li>
            
          </ul>
        </nav>
        <style>
            #brandbutton{
                width: 180px;
                max-width: 210px;
                white-space: normal;
            }
        </style>
        <script>
            
        </script>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <span class="res"></span>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                     <div class="card-header" style="display: flex;align-items: center;padding: 10px 10px;justify-content: space-between;">
                         <h2>Products </h2> </h3><b style="color:red">Note:POSITIVE STOCK ONLY</b></h3>
                         <div style="">
                         <a href="thermalinventory.php" class="btn btn-warning generateInventory">THERMAL INVENTORY</a>
                         <a href="inventorypdf.php" class="btn btn-info generateInventory">A4 INVENTORY</a>
                         <a href="stocktaking.php" class="btn btn-dark generateInventory">STOCK TAKING<br>INVENTORY</a>
                         </div>
                     </div>
                     
                     
                    
                    <p><b style="color:red">Note:</b> To edit quantities, click on the quantity you want to edit</p>
                    
                          <table class="table .table-striped" id="first">
                                    <thead>
                                        <tr>
                    						<th>Brand</th>
                    						<th>Barcode</th>
                    						<th>B.Price</th>
                    						<th>QTY</th>
											<th>R.PRICE</th>
                    						<th>W.Price</th>
											<th>Profit</th>
											<th>Tax?</th>
                    						<th>Edit</th>
											<th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                               $resultt = mysqli_query($con,"select * from inventory where totalPieces > 0"); 
                                               
                                                while($row = mysqli_fetch_array($resultt)){
													$profitmargin = ((($row['retail']) - ($row['cost']))/$row['subunitcost'])*100;
                                                    if($row['retail'] > 0 && $row['subunitcost'] > 0){
                                                        $profit = number_format(
                                                            (($row['retail'] - $row['subunitcost']) / $row['subunitcost']) * 100,
                                                            2
                                                        );
                                                    }else{
                                                        $profit = 0;
                                                    }
                                                    
													$margin = $row['retail'] - $row['subunitcost'];
                                                    echo "<tr>";
                                                    // brand
                                                    echo '<td><button class="btn btn-success btn-outline point brandbutton" id="brandbutton" value="">'.$row['brand'].'</button></td>';
    												// BArcode
    												echo '<td class="bar point">'.$row['barcode'].'</td>';
                                					// B.Price
                                                    echo '<td class="bp">'.number_format($row['subunitcost']).'</td>';
                                                    // QTY
                                                    if($row['brand'] === 'ATM FRESH MILK 1L'){
                                                        echo '<td class="qt point">'.number_format($row['totalpieces'],2).'</td>';
                                                    }else{
                                                        echo '<td class="qt point">'.$row['totalpieces'].'</td>';
                                                    }
                                                    
                                                    // R.PRICE
                                					echo '<td class="spr">'.number_format($row['retail']).'</td>';
                                                    // W.Price
                                                    echo '<td class="spw">'.number_format($row['wholesale']).'</td>';
                                                    // Profit
                                                    echo '<td>'.$profit."%".'</td>';
                                                    $tax = $row['taxable'];
                                                    // Tax?
                                                    echo '<td class="tax point primaryvalue="'.$taxableb.'">'.$tax.'</td>';
                                                    // Edit
                                                    echo '<td><span style="cursor:pointer;" class="editbtn">&#9998;</span></td>';
                                                    // Delete
                                                    echo '<td><span style="color:red;font-size:1.5em;cursor:pointer;" class="delbtn">&#128465;<span></td>';
                                					if($tax==1){ $taxable="taxable";}else{$taxable="not taxable";}
    												if($tax==1){ $taxableb="not taxable";}else{$taxableb="taxable";}
                                                    
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
                 <div class="card-header" style="display: flex;align-items: center;padding: 10px 10px;justify-content: space-between;">
                         <h2>Products </h2> <h3><b style="color:red">Note:ALL UNDERSTOCKED</b></h3>
                         <div style="">
                         <a href="" class="btn btn-warning generateInventory">THERMAL INVENTORY</a>
                         <a href="" class="btn btn-info generateInventory">A4 INVENTORY</a>
                         <a href="" class="btn btn-dark generateInventory">STOCK TAKING<br>INVENTORY</a>
                         </div>
                     </div>
                    
                    <p><b style="color:red">Note:</b> All Products with Zero StocK and Negatives, To edit quantities</p>
                    <table class="table table-bordered" id="second">
                      <thead>
                        <tr>
                          <th> PRODUCT </th>
                          <th>BARCODE</th>
                          <th>B.P</th>
                          <th>S.P</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              $resultty = mysqli_query($con,"select * from inventory where totalpieces <= 0"); 
                              while($rowy = mysqli_fetch_array($resultty)){
    								if($rowy['retail'] > 0 && $rowy['subunitcost'] > 0){
    									$profitmargin = ( ( ($rowy['retail']) - ($rowy['subunitcost']) )/$rowy['subunitcost'] ) * 100;  
    								}else{
    									$profitmargin = 0;
    								}
    								echo "<tr>";
        								$total = $rowy['units']*$rowy['subunits'];
        								echo '<td class="brandname" id="brandbutton">'.$rowy['brand'].'</td>';
        								echo '<td>'.$rowy['barcode'].'</td>';
        								echo '<td>'.$rowy['subunitcost'].'</td>';
        								echo '<td>'.$rowy['retail'].'</td>';
        								echo '<td><span style="color:red;font-size:1.5em;cursor:pointer;" class="delbtn">&#128465;<span></td>';
    								echo "</tr>";
                                  
                              }
                        ?>
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                     <div class="card-header" style="display: flex;align-items: center;padding: 10px 10px;justify-content: space-between;">
                         <h2>Products </h2> <h3><b style="color:red">Note:NO BARCODE</b></h3>
                         <div style="">
                         <a href="" class="btn btn-dark generateInventory"><br>INVENTORY</a>
                         </div>
                     </div>
                     <p><b style="color:red">Note:</b> To ADD BARCODE to edit, Please note this are products are unscannable</p>
                    <table class="table table-bordered" id="third">
                      <thead>
                        <tr>
                          <th>PRODUCT</th>
                          <th>CATEGORY</th>
                          <th>SUBCATEGORY</th>
                          <th>B.P</th>
                          <th>S.P</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              $resultty = mysqli_query($con,"SELECT * FROM `inventory` WHERE barcode IS NULL"); 
                              while($rowy = mysqli_fetch_array($resultty)){
    								if($rowy['retail'] > 0 && $rowy['subunitcost'] > 0){
    									$profitmargin = ( ( ($rowy['retail']) - ($rowy['subunitcost']) )/$rowy['subunitcost'] ) * 100;  
    								}else{
    									$profitmargin = 0;
    								}
    								echo "<tr>";
        								$total = $rowy['units']*$rowy['subunits'];
        								echo '<td class="brandname" id="brandbutton">'.$rowy['brand'].'</td>';
        								echo '<td>'.$rowy['category'].'</td>';
        								echo '<td>'.$rowy['subcategory'].'</td>';
        								echo '<td>'.$rowy['subunitcost'].'</td>';
        								echo '<td>'.$rowy['retail'].'</td>';
        								echo '<td class="bar" style="cursor:pointer;">ADD BARCODE</td>';
    								echo "</tr>";
                                  
                              }
                        ?>
                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                     <div class="card-header" style="display: flex;align-items: center;padding: 10px 10px;justify-content: space-between;">
                         <h2>Products </h2> <h3><b style="color:red">Note:ALL STOCK</b></h3>
                         <div style="">
                         <a href="thermalinventory.php" class="btn btn-warning generateInventory">THERMAL INVENTORY</a>
                         <a href="inventorypdf.php" class="btn btn-info generateInventory">A4 INVENTORY</a>
                         <a href="stocktaking.php" class="btn btn-dark generateInventory">STOCK TAKING<br>INVENTORY</a>
                         </div>
                     </div>
                    
                    <p><b style="color:red">Note:</b> To edit quantities, click on the quantity you want to edit</p>
                    
                          <table class="table .table-striped" id="fourth">
                                    <thead>
                                        <tr>
                    						<th>Brand</th>
                    						<th>Barcode</th>
                    						<th>B.Price</th>
                    						<th>QTY</th>
											<th>R.PRICE</th>
                    						<th>W.Price</th>
											<th>Profit</th>
											<th>Tax?</th>
                    						<th>Edit</th>
											<th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                               $resultt = mysqli_query($con,"select * from inventory"); 
                                               
                                                while($row = mysqli_fetch_array($resultt)){
													$profitmargin = ((($row['retail']) - ($row['cost']))/$row['subunitcost'])*100;
                                                    if($row['retail'] > 0 && $row['subunitcost'] > 0){
                                                        $profit = number_format(
                                                            (($row['retail'] - $row['subunitcost']) / $row['subunitcost']) * 100,
                                                            2
                                                        );
                                                    }else{
                                                        $profit = 0;
                                                    }
                                                    
													$margin = $row['retail'] - $row['subunitcost'];
                                                    echo "<tr>";
                                                    // brand
                                                    echo '<td><button class="btn btn-success btn-outline point brandbutton" id="brandbutton" value="">'.$row['brand'].'</button></td>';
    												// BArcode
    												echo '<td class="bar point">'.$row['barcode'].'</td>';
                                					// B.Price
                                                    echo '<td class="bp">'.number_format($row['subunitcost']).'</td>';
                                                    // QTY
                                                    echo '<td class="qt point">'.number_format($row['totalpieces'],2).'</td>';
                                                    // R.PRICE
                                					echo '<td class="spr">'.number_format($row['retail']).'</td>';
                                                    // W.Price
                                                    echo '<td class="spw">'.number_format($row['wholesale']).'</td>';
                                                    // Profit
                                                    echo '<td>'.$profit."%".'</td>';
                                                    $tax = $row['taxable'];
                                                    // Tax?
                                                    echo '<td class="tax point primaryvalue="'.$taxableb.'">'.$tax.'</td>';
                                                    // Edit
                                                    echo '<td><span style="cursor:pointer;" class="editbtn">&#9998;</span></td>';
                                                    // Delete
                                                    echo '<td><span style="color:red;font-size:1.5em;cursor:pointer;" class="delbtn">&#128465;<span></td>';
                                					if($tax==1){ $taxable="taxable";}else{$taxable="not taxable";}
    												if($tax==1){ $taxableb="not taxable";}else{$taxableb="taxable";}
                                                    
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
                     <div class="card-header" style="display: flex;align-items: center;padding: 10px 10px;justify-content: space-between;">
                         <h2>Edit Products Details</h2>
                     </div>
                    
                    <p><b style="color:red">Note:</b> Click any value to edit shelf, category, sub-category, measure for all products</p>
                    
                          <table class="table .table-striped" id="fifth">
                                    <thead>
                                        <tr>
                    						<th>Brand</th>
                    						<th>Shelf</th>
                    						<th>Category</th>
                    						<th>Sub Category</th>
											<th>measure</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                               $resultt = mysqli_query($con,"select * from inventory"); 
                                               
                                                while($row = mysqli_fetch_array($resultt)){
                                                    echo "<tr>";
                                                    // brand
                                                    echo '<td><button class="btn btn-success btn-outline point brandbutton" id="brandbutton" value="">'.$row['brand'].'</button></td>';
    												// shelf
    												echo '<td class="point shelf">'.$row['shelf'].'</td>';
                                					// category
                                                    echo '<td class="point category">'.$row['category'].'</td>';
                                                    // sub-category
                                                    echo '<td class="point subcategory">'.$row['subcategory'].'</td>';
                                                    // measure
                                                    echo '<td class="point measure">'.$row['measure'].'</td>';
                                                    echo "</tr>";
                                                }
                                                ?>
                                    </tbody>
                                </table>
								<span class="hapa"></span>
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