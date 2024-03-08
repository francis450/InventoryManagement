<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
}else{
    $userid = $_SESSION['username'];
}

include('connection.php'); 
error_reporting(0);


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php  echo $userid; ?></title>
    <!-- Core CSS - Include with every page -->
    <link href="gassets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="gassets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="gassets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="gassets/css/style.css" rel="stylesheet" />
    <link href="gassets/css/main-style.css" rel="stylesheet" />
    <link href="jquery.dataTables.min.css" rel="stylesheet" />
        <script src="gassets/plugins/jquery-1.10.2.js"></script>
    <script src="jquery.dataTables.min.js"></script>
    <!-- Page-Level CSS -->
    <link href="gassets/plugins/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/9985d5505c.js" crossorigin="anonymous"></script>
    <style>
    body{
        background-color: #054986;
    }
    .panel {
        margin-top: 20px;
    }
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
          bottom: 100%;
          left: 50%;
          margin-left: -60px;
        }
        
        .tooltip:hover .tooltiptext {
          visibility: visible;
        }
        .dash {
               position: relative;
                top: 10px;
                color: white;
                left: 15px;
                font-size: 18px;
        }
</style>
   </head>
<body>
    <li class="nav-item">
        <a class="nav-link dash" href="main.php">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Dashboard</span>
            </a>
            </li>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        
        <!-- end navbar side -->
        <!--  page-wrapper -->
      <div id="page-wrapper">
      

			
			
			
			
<!--End Info Pannel, Warning Panel And Danger Panel   -->
<!--Wet Stock - Forecourt Sales Panel   -->
<!--Wet Stock - Forecourt Sales   -->	
			
      
    <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-default">
         <div class="panel-heading">RECEIPTS</div>
         <div class="panel-body">
			<ul class="nav nav-tabs">
                 <li class="active"><a href="#home" data-toggle="tab">TODAY</a></li>
				 <li><a href="#profile" data-toggle="tab">THIS WEEK</a></li>
                 <li><a href="#messages" data-toggle="tab">THIS MONTH</a></li>
                 <li><a href="#settings" data-toggle="tab">THIS YEAR</a></li>
                 
                 <li><a href="#test" data-toggle="tab">Tests</a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane fade in active" id="home">
            <h4>Total Sales for <?php echo date('Y-d-m');?></h4>
            <?php $payment = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'cash' and date(timed) = curdate()");  $cash = mysqli_fetch_array($payment); ?>
            <button class="btn btn-info btn-outline">Cash: &nbsp<?php echo number_format($cash['total'],2); ?> </button>
            <?php $paymentt = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'Mpesa' and date(timed) = curdate()");  $mpesa = mysqli_fetch_array($paymentt); ?>
			<button class="btn btn-warning btn-outline">M-Pesa:&nbsp<?php echo number_format($mpesa['total'],2); ?> </button>
			<?php $paymenttt = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'Bank' and date(timed) = curdate()");  $mpesa = mysqli_fetch_array($paymenttt); ?>
			<button class="btn btn-danger btn-outline">Bank:&nbsp<?php echo number_format($mpesa['total'],2); ?> </button>
									
			<p><div class="col-lg-12">
               
                <div class="panel panel-default">
                    <div class="panel-heading">
                               <?php
                                        $d = date('Y-m-d');
                                        $grts = mysqli_query($con,"select SUM(total) as amount from cart where dated like '%$d%'");
                                        $grtsrs= mysqli_fetch_array($grts);
                                        $df= $grtsrs['amount'];
                                        echo 'Total Sales = Ksh '.number_format($df,2);
                          ?>
							<div class="pull-right">
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="othersalestodaypdf.php" target="_blank">Download PDF</a>
                                        </li>
                                        <li><a href="#">Download Excel</a>
                                        </li>
                                        <li><a href="#">Print PDF</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Send to Mail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
										</tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $d = date('Y-m-d');
                                        $grts = mysqli_query($con,"SELECT * FROM receipts WHERE DATE(timed) = CURDATE()");
                                        // var_dump($grts);
                                        while($grtsr= mysqli_fetch_array($grts)){
                                            $dateString = $grtsr['timed'];
                                            $dateTime = new DateTime($dateString);
                                            $date = $dateTime->format('Y-m-d'); // Extract the date part
                                            $time = $dateTime->format('H:i:s'); // Extract the time part
                                            
                                            // echo "Date: $date<br>";
                                            // echo "Time: $time";
                                            echo '<tr>';
                                            echo '<td><a href="writeAReceipt.php?cartid='.$grtsr['cartid'].'" target="blank">'.$grtsr['cartid'].'</a></td>';
                                            echo '<td>'.$grtsr['payable'].'</td>';
                                            echo '<td>'.$grtsr['amountgiven'].'</td>';
                                            echo '<td>'.$grtsr['balance'].'</td>';
                                            echo '<td>'.$grtsr['transactiontype'].'</td>';
                                            echo '<td>'.$time.'</td>';
                                            echo '<td>'.$grtsr['customer'].'</td>';
                                            echo '<td>'.$grtsr['cashier'].'</td>';
                                            $empl = $grtsr['employee'];
                                            $getsumtotal = mysqli_query($con,"select SUM(amount) as tamount from sales where employee ='$empl' and dated = '$d'");
                                            $getsumtotalr = mysqli_fetch_array($getsumtotal);
                                            
                                            // echo '<td>'.$getsumtotalr['tamount'].'</td>';
                                        }
                                        ?>
                                       
                                           
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
			</p>
          </div>
          <div class="tab-pane fade" id="profile">
          <h4>Week <?php $dr = date('Y-m-d'); echo date("W", $dr)?> of <?php echo date('Y-m');?> </h4>
             <p>
				<div class="col-lg-12">
                     
                    <div class="panel panel-default">
                      <div class="panel-heading">
                             <?php
                                        $d = date('Y-m');
                                        $grts = mysqli_query($con,"select SUM(total) as amount from cart WHERE  YEARWEEK(`dated`, 1) = YEARWEEK(CURDATE(), 1)");
                                        $grtsrs= mysqli_fetch_array($grts);
                                        $df= $grtsrs['amount'];
                                        echo 'Total Sales = Ksh '.number_format($df,2);
                            ?>
							<div class="pull-right">
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="othersalesweeklypdf.php" target="_blank">Download PDF</a>
                                        </li>
                                        <li><a href="#">Download Excel</a>
                                        </li>
                                        <li><a href="#">Print PDF</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Send to Mail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                               <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
										</tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                        $d = date('Y-m-d');
                                        $grts = mysqli_query($con,"select * from receipts WHERE YEARWEEK(`timed`, 1) = YEARWEEK(CURDATE(), 1)");
                                        while($grtsr= mysqli_fetch_array($grts)){
                                            $dateString = $grtsr['timed'];
                                            $dateTime = new DateTime($dateString);
                                            $date = $dateTime->format('Y-m-d'); // Extract the date part
                                            $time = $dateTime->format('H:i:s'); // Extract the time part
                                            echo '<tr>';
                                            echo '<td><a href="writeAReceipt.php?cartid='.$grtsr['cartid'].'" target="blank">'.$grtsr['cartid'].'</a></td>';
                                            echo '<td>'.$grtsr['payable'].'</td>';
                                            echo '<td>'.$grtsr['amountpaid'].'</td>';
                                            echo '<td>'.$grtsr['balance'].'</td>';
                                            echo '<td>'.$grtsr['transactiontype'].'</td>';
                                            echo '<td>'.$date.'</td>';
                                            echo '<td>'.$time.'</td>';
                                            echo '<td>'.$grtsr['customer'].'</td>';
                                             echo '<td>'.$grtsr['cashier'].'</td>';
                                            $empl = $grtsr['employee'];
                                            $getsumtotal = mysqli_query($con,"select SUM(amount) as tamount from sales where YEARWEEK(`dated`, 1) = YEARWEEK(CURDATE(), 1) and employee ='$empl'");
                                            $getsumtotalr = mysqli_fetch_array($getsumtotal);
                                            
                                            // echo '<td>'.$getsumtotalr['tamount'].'</td>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div></p>
				</div>
    
	
	<div class="tab-pane fade" id="messages">
     <h4>Monthly Sales for <?php echo date('Y-m')?></h4>
        <?php $payment = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'cash' and YEAR(timed) = YEAR(CURDATE()) AND MONTH(timed) = MONTH(CURDATE())");  $cash = mysqli_fetch_array($payment); ?>
            <button class="btn btn-info btn-outline">Cash: &nbsp<?php echo number_format($cash['total'],2); ?> </button>
            <?php $paymentt = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'Mpesa' and date(timed) = curdate()");  $mpesa = mysqli_fetch_array($paymentt); ?>
			<button class="btn btn-warning btn-outline">M-Pesa:&nbsp<?php echo number_format($mpesa['total'],2); ?> </button>
			<?php $paymenttt = mysqli_query($con, "SELECT SUM(amountgiven) as total FROM receipts where transactiontype = 'Bank' and date(timed) = curdate()");  $mpesa = mysqli_fetch_array($paymenttt); ?>
			<button class="btn btn-danger btn-outline">Bank:&nbsp<?php echo number_format($mpesa['total'],2); ?> </button>
							
        <p>
									
		<div class="col-lg-12">
                    
                    <div class="panel panel-default">
                      <div class="panel-heading">
                             <?php
                                        $d = date('Y-m');
                                        $grts = mysqli_query($con,"select SUM(total) as amount from cart WHERE YEAR(dated) = YEAR(CURDATE()) AND MONTH(dated) = MONTH(CURDATE())");
                                        $grtsrs= mysqli_fetch_array($grts);
                                        $df= $grtsrs['amount'];
                                        echo 'Total Sales = Ksh '.number_format($df,2);
                             ?>
							<div class="pull-right">
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="othersalesmonthlypdf.php" target="_blank">Download PDF</a>
                                        </li>
                                        <li><a href="#">Download Excel</a>
                                        </li>
                                        <li><a href="#">Print PDF</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Send to Mail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
										</tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $d = date('Y-m');
                                        $grts = mysqli_query($con,"select * from receipts WHERE YEAR(timed) = YEAR(CURDATE()) AND MONTH(timed) = MONTH(CURDATE());");
                                        while($grtsr= mysqli_fetch_array($grts)){
                                            $dateString = $grtsr['timed'];
                                            $dateTime = new DateTime($dateString);
                                            $date = $dateTime->format('Y-m-d'); // Extract the date part
                                            $time = $dateTime->format('H:i:s'); // Extract the time part
                                            echo '<tr>';
                                            echo '<td><a href="writeAReceipt.php?cartid='.$grtsr['cartid'].'" target="blank">'.$grtsr['cartid'].'</a></td>';
                                            echo '<td>'.$grtsr['payable'].'</td>';
                                            echo '<td>'.$grtsr['amountpaid'].'</td>';
                                            echo '<td>'.$grtsr['balance'].'</td>';
                                            echo '<td>'.$grtsr['transactiontype'].'</td>';
                                            echo '<td>'.$date.'</td>';
                                            echo '<td>'.$time.'</td>';
                                            echo '<td>'.$grtsr['customer'].'</td>';
                                             echo '<td>'.$grtsr['cashier'].'</td>';
                                            $empl = $grtsr['employee'];
                                            $getsumtotal = mysqli_query($con,"select SUM(amount) as tamount from sales where YEARWEEK(`dated`, 1) = YEARWEEK(CURDATE(), 1) and employee ='$empl'");
                                            $getsumtotalr = mysqli_fetch_array($getsumtotal);
                                            
                                            // echo '<td>'.$getsumtotalr['tamount'].'</td>';
                                        }
                                        ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div></p>
          </div>
		  
		  
   <div class="tab-pane fade" id="settings">
         <h4>Annual Sales for <?php echo date('Y');?></h4>
             <p><div class="col-lg-12">
                     
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <?php
                          $d = date('Y');
                                        $grts = mysqli_query($con,"SELECT SUM(total) as amount FROM `cart` WHERE YEAR(`dated`) = YEAR(CURRENT_DATE())");
                                        $grtsrs= mysqli_fetch_array($grts);
                                        $df= $grtsrs['amount'];
                                        echo 'Total Sales = Ksh '.number_format($df,2);
                          ?>
                            
                        
						<div class="pull-right">
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="othersalesannualpdf.php" target="_blank">Download PDF</a>
                                        </li>
                                        <li><a href="#">Download Excel</a>
                                        </li>
                                        <li><a href="#">Print PDF</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Send to Mail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
										</tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                        $d = date('Y');
                                        $grts = mysqli_query($con,"select * from receipts WHERE YEAR(timed) = YEAR(CURDATE())");
                                        while($grtsr= mysqli_fetch_array($grts)){
                                            $dateString = $grtsr['timed'];
                                            $dateTime = new DateTime($dateString);
                                            $date = $dateTime->format('Y-m-d'); // Extract the date part
                                            $time = $dateTime->format('H:i:s'); // Extract the time part
                                            echo '<tr>';
                                            echo '<td><a href="writeAReceipt.php?cartid='.$grtsr['cartid'].'" target="blank">'.$grtsr['cartid'].'</a></td>';
                                            echo '<td>'.$grtsr['payable'].'</td>';
                                            echo '<td>'.$grtsr['amountpaid'].'</td>';
                                            echo '<td>'.$grtsr['balance'].'</td>';
                                            echo '<td>'.$grtsr['transactiontype'].'</td>';
                                            echo '<td>'.$date.'</td>';
                                            echo '<td>'.$time.'</td>';
                                            echo '<td>'.$grtsr['customer'].'</td>';
                                             echo '<td>'.$grtsr['cashier'].'</td>';
                                            $empl = $grtsr['employee'];
                                            $getsumtotal = mysqli_query($con,"select SUM(amount) as tamount from sales where YEARWEEK(`dated`, 1) = YEARWEEK(CURDATE(), 1) and employee ='$empl'");
                                            $getsumtotalr = mysqli_fetch_array($getsumtotal);
                                            
                                            // echo '<td>'.$getsumtotalr['tamount'].'</td>';
                                        }
                                        ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
				</div></p>
                                </div>
   
        <div class="tab-pane fade" id="test">
         <h4>Annual Sales for <?php echo date('Y');?></h4>
             <p><div class="col-lg-12">
                     
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <?php
                          $d = date('Y');
                                        $grts = mysqli_query($con,"select SUM(amount) as amount from sales WHERE dated like '%$d%' and department!='wetstock'");
                                        $grtsrs= mysqli_fetch_array($grts);
                                        $df= $grtsrs['amount'];
                                        echo 'Total Sales = Ksh '.number_format($df,2);
                          ?>
                            
                        
						<div class="pull-right">
							<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Download PDF</a>
                                        </li>
                                        <li><a href="#">Download Excel</a>
                                        </li>
                                        <li><a href="#">Print PDF</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Send to Mail</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <script>
                                    /* Formatting function for row details - modify as you need */
                                            function format(d) {
                                                // `d` is the original data object for the row
                                                return (
                                                    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                                                    '<tr>' +
                                                    '<td>Product:</td>' +
                                                    '<td>' +
                                                    d.employee +
                                                    '</td>' +
                                                    '</tr>' +
                                                    '<tr>' +
                                                    '<td>Extension number:</td>' +
                                                    '<td>' +
                                                    d.department +
                                                    '</td>' +
                                                    '</tr>' +
                                                    '<tr>' +
                                                    '<td>Extra info:</td>' +
                                                    '<td>'+d.department+'</td>' +
                                                    '</tr>' +
                                                    '</table>'
                                                );
                                            }
                                             
                                            $(document).ready(function () {
                                                var table = $('#example').DataTable({
                                                    ajax: 'objects.php',
                                                    columns: [
                                                        {
                                                            className: 'dt-control',
                                                            orderable: false,
                                                            data: null,
                                                            defaultContent: '',
                                                        },
                                                        { data: 'id' },
                                                        { data: 'dated' },
                                                        { data: 'shift' },
                                                        { data: 'fuel' },
                                                        { data: 'qnty' },
                                                        { data: 'amount' },
                                                    ],
                                                    order: [[1, 'asc']],
                                                });
                                             
                                                // Add event listener for opening and closing details
                                                $('#example tbody').on('click', 'td.dt-control', function () {
                                                    var tr = $(this).closest('tr');
                                                    var row = table.row(tr);
                                             
                                                    if (row.child.isShown()) {
                                                        // This row is already open - close it
                                                        row.child.hide();
                                                        tr.removeClass('shown');
                                                    } else {
                                                        // Open this row
                                                        row.child(format(row.data())).show();
                                                        tr.addClass('shown');
                                                    }
                                                });
                                            });
                                            
                                            
                                </script>
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Receipt No.</th>
											<th>Payable</th>
											<th>Received</th>
                                            <th>Balance</th>
                                            <th>Transaction<br> Type</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>customer</th>
											<th>Cashier</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
				</div></p>
                                </div>
                            </div>
                        </div>
           </div>
				
							
			
<!--Start Info Pannel, Warning Panel And Danger Panel   -->

<!--Sample table Sales Panel   -->

</div>
        </div>
        <!-- end page-wrapper -->
    </div>
    <script>$('.table').DataTable();</script>
    <script src="gassets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="gassets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="gassets/plugins/pace/pace.js"></script>
    <script src="gassets/scripts/siminta.js"></script>

</body>

</html>
