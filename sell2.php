<?php
    session_start();
    $userid = $_SESSION['username'];
    if(!isset($_SESSION['username'])){
        header("Location: index.php");
    }
    include('connection.php');
    $uiy = date('Y-m-d H:i:s');
    $long = strtotime($uiy);
    $cartid= rand(1000,100000) + $long;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bigbro</title>
    <!-- plugins:css -->
    <!--<link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">-->
    <!--<link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">-->
    <!--<link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">-->
    <!--<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">-->
    <!--<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">-->
    <link rel="stylesheet" href="jquery.dataTables.min.css">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="jquery.dataTables.min.js"></script>
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
    <style>
      .removebtn {
            background: red;
            border: none;
            border-radius: 5px;
            height: 25px;
            color: white;
      }
      table.dataTable thead .sorting {
    background-image: url("assets/images/sort_both.png");
    }
    
    table.dataTable thead .sorting_asc {
        background-image: url("assets/images/sort_asc.png") !important;
    }
    
    table.dataTable thead .sorting_desc {
        background-image: url("assets/images/sort_desc.png") !important;
    }
    
    table.dataTable thead .sorting_asc_disabled {
        background-image: url("assets/images/sort_asc_disabled.png");
    }
    
    table.dataTable thead .sorting_desc_disabled {
        background-image: url("assets/images/sort_desc_disabled.png");
    }
    </style>
     <?php
        if(isset($_POST['truncate'])){
            $checkcart = mysqli_query($con, "SELECT * FROM tempcart");
            if(mysqli_num_rows($checkcart)>0){
                mysqli_query($con, "TRUNCATE tempcart");
            }
        }
    ?>
    <script>
            $(document).ready(function(){
                    // while($('.cartcallback').children().length === 0){
                    //     $('.gu').val('');
                    // }
                 // Function to update the clock
                 var truncate = true;
                $.post('',{truncate:truncate},function(){
                   console.log("table truncated"); 
                });
              function updateClock() {
                var now = new Date();
                var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                
                var dayOfWeek = daysOfWeek[now.getDay()];
                var day = now.getDate();
                var month = months[now.getMonth()];
                var year = now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();

                // Add leading zero if single digit
                hours = (hours < 10 ? "0" : "") + hours;
                minutes = (minutes < 10 ? "0" : "") + minutes;
                seconds = (seconds < 10 ? "0" : "") + seconds;

                // Display the day, date, and time in the clock element
                $("#clock").html(dayOfWeek + ", " + month + " " + day + ", " + year + "<br>" + hours + ":" + minutes + ":" + seconds);
              }

              // Update the clock every second
              setInterval(updateClock, 1000);

              // Initial update
              updateClock();
                
                
                $('.sellbtn').hide();
              $('.ad').hide();
                $('.selectbtn').change(function(){
                $('.sellbtn').show(); 
                });
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
        
        
        
        $(".bei").change(function(){ var thisprice = $(this).val();$(this).closest('tr').children('td.beii').val(thisprice);});
        $(".ngapi").change(function(){
        
        var thisprice = $(this).closest('tr').children('td.beii').text();
        
        var thismuch = $(this).val();
        
        var txx = $(this).closest('tr').children('td').find('select.taxi').val();
        var tyx  = parseInt(thisprice) * parseInt(thismuch)*parseInt(txx)*parseFloat(0.16);
        //var thistotal = (parseInt(thisprice) * parseInt(thismuch))+tyx;
        var thistotal = (parseInt(thisprice) * parseInt(thismuch));
        
        $(this).closest('tr').children('td.sote').text(thistotal);
          $(this).closest('tr').children('td.addtocart').trigger("click");	

        });
        
        
        $(".addtocart").click(function(){
          
        
          var brandtocart = $(this).closest('tr').children('td.brandname').text();
          
          var pricetocart = $(this).closest('tr').children('td.beii').text();
          var tx = $(this).closest('tr').children('td').find('select.taxi').val();
          var qntytocart = $(this).closest('tr').children('td').find('select.ngapi').val();
          var totaltocart = $(this).closest('tr').children('td.sote').text();
          var cartid = "<?php echo $cartid ;?>";
          
          $.post('addtotempcart.php',{brandtocart:brandtocart,pricetocart:pricetocart,qntytocart:qntytocart,totaltocart:totaltocart,cartid :cartid,tx:tx,},function(data){
            
            $(".cartcallback").html(data);
            console.log(" --",data,"-- ");
              $.post('gettotalprice.php',{cartid :cartid,},function(data2){
              $(".gu").text(data2);    
                console.log(data2);
                // $(".gottotalprice").val(data2);
                $('.ad').show();
          });
          });
          
          
            

        });
        $("div.dataTables_filter input").keyup(function(){
          var barcode = $(this).val();
          
          if(barcode!=""&&barcode.length>6){
            
            var cartid2 = "<?php echo $cartid ;?>";
          
          $.post('addtotempcart.php',{barcode:barcode,cartid2 :cartid2,},function(data){
            
            $(".cartcallback").html(data);
              $.post('gettotalprice.php',{cartid :cartid2,},function(data2){
                $(".gu").text(data2);    
                console.log(data2);
                // $(".gottotalprice").val(data2);
                $('.ad').show();
                $('.barcodescanner').text("");
          });
          });
          }
          
        });
        
        
        
        $(".amountgiven").keyup(function(){
          
          var receivedmoney = $(this).val();
          var jumla = $(".gottotalprice").val();
          var disc = $(".discount").val()||0;
          
          
          var baki = parseInt(receivedmoney )- parseInt(jumla) + parseInt(disc);
          $(".bakii").val(baki);
          
          if(disc==0){
            $(".discount").val(0)
          }
          
        });
        
        
        
        $(".cartcallback").on('click','.removebtn',function(){
          var braxton = $(this).val();
          var cartid = "<?php echo $cartid?>";
          var boy = "<?php echo $cartid?>";
          $.post('removefromcart.php',{braxton:braxton,boy:boy,},function(data){
            $(".cartcallback").html(data);
            $.post('gettotalprice.php',{cartid :cartid,},function(data2){
                $('.gu').html(data2)
            console.log(data2);
            // $(".gottotalprice").val(data2);
          });
          });
        
        });
        
        $('.transtype').change(function(){
          var transactiontype= $(this).val();
          
          if(transactiontype=='Equity bank'){
            var msg = "Please enter bank details below";
            $('.tran').text(msg);
          }else if(transactiontype=='Absa bank'){
            var msg = "Please enter bank details below";
            $('.tran').text(msg);
            
          }else if(transactiontype=='mpesa'){
            var msg = "Please enter phone number below";
            $('.tran').text(msg);
            
          }else if(transactiontype=='Credit'){
            var msg = "Please enter full creditors details below";
            $('.tran').text(msg);
            
          }else{
            var msg = "Please enter descriptive details below";
            $('.tran').text(msg);
          }
          
        });
        
        
        function printthis(){ 
          $(this).trigger("click");
          
          }
          
          }); 
          
              $(document).ready(function(){
                var table = $('#uza').DataTable({
                    columnDefs: [{ width: 200, targets: 0 }],
                        fixedColumns: true,
                //   paging: false, 
                "lengthMenu": [7,10,15,25,50],
                  scrollCollapse: true,
                  scrollX: true, 
                  "pageLength": 7,
                  "search": {
                    "return": true
                  }
                });
                table.column( 2 ).visible( false );
                
                $('#uza').on('search.dt', function() {
                    var value = $('.dataTables_filter input').val();
                    // console.log("VAlue: ",value);
                    var TableResults = table.rows({ filter: 'applied' }).data();
                    // console.log(TableResults[0][2]);
                    if(table.rows({ filter: 'applied' }).length == 1 && value === TableResults[0][2]){
                        // console.log(TableResults[0])
                          var zote = TableResults[0];
                          var brandtocart = zote[0];
                          var tempElement = document.createElement('div');

                            // Set the innerHTML of the temporary element to the content of brandtocart
                            tempElement.innerHTML = brandtocart;
                            
                            // Get the text content of the temporary element
                            brandtocart = tempElement.textContent;
                          var pricetocart = parseInt(zote[1]);
                          var qntytocart = 1;
                          var totaltocart = parseInt(zote[1]);
                          var cartid = "<?php echo $cartid ;?>";
                          $.post('addtotempcart.php',{brandforstock: brandtocart},function(res){
                              if(res > 0){
                                  console.log('Res: '+res);
                                  $.post('addtotempcart.php',{brandtocart:brandtocart,pricetocart:pricetocart,qntytocart:qntytocart,totaltocart:totaltocart,cartid :cartid,},
                                      function(data){
                                          $(".cartcallback").html(data);
                                          $.post('gettotalprice.php',{cartid :cartid,},function(data2){
                                              $(".gu").text(data2);
                                              $('.ad').show();
                                          });
                                      }
                                  );
                              }else{
                                //   var sender = 
                                //   console.log(sender);
                                //   $.post('notify.php',{brand:brandtocart,sender:sender},function(data){
                                //       console.log(data);
                                      
                                //   })
                                  alert(brandtocart+" IS OUT OF STOCK. PLEASE NOTIFY ADMIN ");
                              }
                          });
                          $('.dataTables_filter input').val('')
                    }
                });  


                
                $('#cartTable').DataTable({
                  paging: false,
                  scrollCollapse: true,
                //   scrollY: '400px',
                //   scrollX: true;
                  "pageLength": 7, 
                  bFilter : false,
                  "info" : false,
                  
                });
                $('div.dataTables_filter input', table.table().container()).focus();
              })
    </script>

  </head>
  <body style="background: #f1ecec94;height:100vh">
      <div class="col-12">
            <nav class="navbar default-layout col-lg-12 col-6 fixed-top d-flex flex-row" style="background:#f0ecf9">
                <div style="display:flex; gap:10px;position:relative;left:4em;background-color:powderblue;">
                  <button class="btn btn-dark" id="clock"></button>   
                  <!--<a  onClick="MyWindow=window.open('sync.php','MyWindow','width=550,height=250'); return false;"><img src="sync.png" width="50px"/></a>-->
                  <!--<a href="#"> <?php echo date('d/m/Y h:m:s');?></a>-->
                               
                </div>
                
                <div style="display:flex; gap:10px; position: relative;right: 4em;">
                    <button class="btn btn-outline-warning"><?php echo $userid; ?></button>
                    <button type="button" class="btn btn-outline-info btn-fw" onClick="MyWindow=window.open('pettycash.php','MyWindow','width=780,height=270'); return false;">Add Expenses</button>
                    <button class="btn btn-success" onClick="MyWindow=window.open('riciti.php','MyWindow','width=1037,height=596'); return false;">RECEIPTS</button>
                    <button class="btn btn-info" onclick= "myWindow = window.location.href('sell2.php') return false">WHOLESALE</button>
                    <button class="btn btn-primary" onClick="MyWindow=window.open('products2.php','MyWindow','width=1000,height=500'); return false;">OVERVIEW</button> 
                    <button type="button" class="btn btn-outline-primary btn-fw" onClick="MyWindow=window.open('approveStock.php','MyWindow','width=1300,height=1300'); return false;">
                        APPROVE<br>NEW STOCK
                    </button>
                   
                      <button id ="reloadButton" class="btn btn-outline-success d-flex" style="
                            display: flex;
                            align-items: center;
                            flex-direction: column;
                        "><img src="assets/images/reloadImage.png" style="
                            height: 20px;
                            width: 20px;
                        ">Refresh
                        </button>
                    <button class="btn btn-outline-danger" id="logout">LOG OUT</button>
                    
                    <script>
                      var logout ='logout';
                      $('document').ready(
                        
                          function(){
                              $('#logout').click(function(){
                                  $.post("logout.php", { logout: true }, function(data) {
                                      // Handle the response if needed (e.g., show a message)
                                      alert("Logged out successfully!");
                                      // Redirect the user to the login page or elsewhere
                                      window.location.href = "index.php";
                                  });
                              });
                          }
                      );
                    </script>
                </div>
            </nav>

            <div class="row" style="margin-top:5em">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="col-6 card">
                    <!-- <input type="text" style="display:100%" class="barcodescanner" id="barcodescanner" /> -->
                    <div class="card-body" style="padding:1em 1em">
                        <table class="table table-hover table-stripe" id="uza">
                      <thead>
                        <tr>
                          <th>Brand</th>
                          <th>Price</th>
						  <th>Barcode</th>
                          <th>Quantity</th>
                          <th>Total</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                                     <?php
                                               $resultt = mysqli_query($con,"select * from inventory"); 
                                                while($row = mysqli_fetch_array($resultt)){
                                                echo "<tr>";
                            					$limit = 40;
                                                $limitedString = (mb_strlen($row['brand']) > $limit) ? mb_substr($row['brand'], 0, $limit) . "..." : $row['brand'];

                                                echo '<td class="brandname"value='.$row['brand'].'>'.$limitedString.'</td>';
                                                echo '<td class="beii" value='.$row['retail'].'>'.$row['retail'].'</td>';
                                                // $tax=$row['taxable'];
                                                // if($tax==0){
                                                //   echo'<td><select class="taxi"><option value="0">0</option><option value="1">16%</option></select></td>';
                                                // }else{
                                                //   echo'<td><select class="taxi"><option value="1">16%</option><option value="0">0</option></select></td>';
                                                // }
                                                echo '<td>'.$row['barcode'].'</td>';
                                                              $qtyu = $row['totalpieces'];
                                                echo '<td class="ngapii" ><select class="ngapi">';
                                                for($i=0;$i<$qtyu +1;$i++){
                                                  echo '<option>'.$i.'</option>';	
                                                }
                                                echo '</select></td>';
                                  
                                                echo '<td class="sote"></td>';
                                                echo '<td class="addtocart"></td>';
                                                
                                                echo "</tr>";
                                                }
                                        ?>
                       


                        </tr>
                      </tbody>
			
                    </table>
                    </div>
                </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="col-6 card">
                    <div class="card-header" style="padding: 10px 10px">
                       <button type="button" class="btn btn-secondary btn-fw">
                      <h5 style="font-size: xx-large">Total: Ksh. <span class="gu"></span>/=</h5></button>
                    
                      <button type="button" class="btn btn-outline-primary btn-fw ad" onClick="MyWindow=window.open('sale.php?id=<?php echo $cartid;?>','MyWindow','width=793,height=421'); return false;">
                      <h5 style="font-size: large">Tap to Sell</h5></button>
                      
                      </div>
                      <div class="card-body" style="padding:1em 1em">
                        <table class="table table-bordered" id="cartTable">
                          <thead>
                            <tr>
                              <th> # </th>
                              <th> Product </th>
                              <th> Units </th>
                              <th> Unit Price </th>
                              <th> Total Price </th>
                              <th> Remove </th>
                            </tr>
                          </thead>
                          <tbody class="cartcallback">           
                          </tbody>
                        </table>
                    </div>
                </div>         
                </div>
            </div>
      </div>
      <div class="col-12">

      </div>
      <script>
                        // Get a reference to the button element by its id
                        const reloadButton = document.getElementById('reloadButton');
                    
                        // Add a click event listener to the button
                        reloadButton.addEventListener('click', function() {
                            // Use the location object to reload the page
                            location.reload();
                        });
                    </script>
      <script>
          $(document).ready(function () {
            // Use event delegation to handle click events on elements with class 'brandname'
            $(document).on('click', '.brandname', function () {
                var qntytocart = prompt('Enter Quantity');
                if (qntytocart > 0) {
                    var brandtocart = $(this).closest('tr').children('td.brandname').text();
                    var pricetocart = $(this).closest('tr').children('td.beii').text();
                    var tx = $(this).closest('tr').children('td').find('select.taxi').val();
                    var totaltocart = parseFloat(qntytocart) * parseFloat(pricetocart);
                    var cartid = "<?php echo $cartid; ?>";
                    $.post('addtotempcart.php',{brandforstock: brandtocart},function(res){
                        if(res > 0){
                            $.post('addtotempcart.php', {
                                brandtocart: brandtocart,
                                pricetocart: pricetocart,
                                qntytocart: qntytocart,
                                totaltocart: totaltocart,
                                cartid: cartid,
                                tx: tx,
                            }, function (data) {
                                $(".cartcallback").html(data);
                                $.post('gettotalprice.php', {
                                    cartid: cartid,
                                }, function (data2) {
                                    $(".gu").text(data2);
                                    $('.ad').show();
                                });
                            });
                        }else{
                            alert(brandtocart+" IS OUT OF STOCK. PLEASE NOTIFY THE ADMIN");
                        }
                    })
                } else {
                    alert('Quantity Cannot Be Null');
                }
            });
        });

      </script>
  </body>
</html>