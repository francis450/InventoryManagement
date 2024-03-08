<?php
session_start();
include('connection.php');

$userid = $_SESSION['username'];

if(isset($_POST['brandforstock'])){
    $brand = $_POST['brandforstock'];
    $chekQuery = "SELECT totalpieces FROM inventory WHERE brand = '$brand' or barcode = '$brand'";
	$checkCount = mysqli_query($con, $chekQuery);
	$totalCount = mysqli_fetch_array($checkCount);
	echo $totalCount['totalpieces'];
	if($totalCount['totalpieces'] < 0){
	    $sender = $userid;
	    $type = 'UNDERSTOCK';
	   // $message = $sender." Says ".$brand." Is Out Of Stock. Please Add Stock";
        $query = "INSERT INTO `messages`( `message`,`type`) VALUES ('$brand','$type')";
        if(mysqli_query($con, $query)){
            // echo "Notification Sent";
        }else{
            mysqli_error($con);
        }
	}
}
if(isset($_POST['brandtocart'])&&isset($_POST['qntytocart'])&&isset($_POST['cartid'])){
	$brandtocart = $_POST['brandtocart'];
	$pricetocart = $_POST['pricetocart'];
	$qntytocart = $_POST['qntytocart'];
	$totaltocart = $_POST['totaltocart'];
	$cartid  = $_POST['cartid'];
	
	$gettax=mysqli_query($con,"select * from inventory where brand='$brandtocart'");
	$gettaxr= mysqli_fetch_array($gettax);
	$taxable = $gettaxr['taxable'];
	
	$checkintempcart = mysqli_query($con, "SELECT * FROM tempcart WHERE product = '$brandtocart'");
$brandexists = mysqli_fetch_assoc($checkintempcart);

if ($brandexists) {
    $newQuantity = $brandexists['qnty'] + $qntytocart;
    $newTotal = $newQuantity * $brandexists['price'];
    $updateQuery = "UPDATE tempcart SET qnty = $newQuantity, total = $newTotal WHERE product = '$brandtocart'";
    $ty = mysqli_query($con, $updateQuery);
} else {
    $insertQuery = "INSERT INTO tempcart (salesid, product, price, qnty, total, tax) VALUES ('$cartid', '$brandtocart', '$pricetocart', '$qntytocart', '$totaltocart', '$taxable')";
    $ty = mysqli_query($con, $insertQuery);
}


	if($ty){
	    $ian =mysqli_query($con,"SELECT SUM(total) as totalpayable from tempcart where salesid='$cartid'");
											$rowian = mysqli_fetch_array($ian);
		 
                                            $allusers = mysqli_query($con,"select * from tempcart where salesid='$cartid' ORDER BY `id` DESC");
                                        	
                                        	while($usersrow = mysqli_fetch_array($allusers))
                                        	{
                                        		
                                        			echo '<tr>';
                                        			echo '<td>'.$usersrow['id'].'</td>';
                                        			echo '<td><button class="btn btn-outline" style=" white-space: normal;padding:0;
                                                    max-width: 200px;">'.$usersrow['product'].'</button></td>';
                                        			echo '<td>'.$usersrow['qnty'].'</td>';
                                        			echo '<td>'.$usersrow['price'].'</td>';
                                        			echo '<td>'.$usersrow['total'].'</td>';
													echo '<td><button class="removebtn" value="'.$usersrow['id'].'">DELETE</button></td>';
                                        		
                                        			echo '</tr>';
                                        			
                                        	}
											
											
											
								// 			 echo ' <tr>
								// 	  <td></td>
								// 	  <td></td>
								// 	  <td>Total</td>
								// 	  <td>'.$rowian['totalpayable'].'</td>
								// 	  </tr>';
                                        	
	}else{
		echo mysqli_error($con);
	}
	
}

if(isset($_POST['barcode'])&&isset($_POST['cartid2'])){
	$barcode = $_POST['barcode'];
	
	$getbrand = mysqli_query($con,"select * from inventory where barcode = '$barcode'");
	if(mysqli_num_rows($getbrand)>0){
		$getbrandr = mysqli_fetch_array($getbrand);
	$brandtocart = $getbrandr['brand'];
	$pricetocart = $getbrandr['subunitcost'];
	$qntytocart = 1;
	$totaltocart = $pricetocart;
	$cartid  = $_POST['cartid2'];
	
	$gettax=mysqli_query($con,"select taxable from inventory where brand='$brandtocart'");
	
	$gettaxr= mysqli_fetch_array($gettax);
	$taxable = $getbrandr['taxable'];
	
	
	$ty = mysqli_query($con,"INSERT INTO tempcart(salesid,product,price,qnty,total,tax)values('$cartid','$brandtocart','$pricetocart','$qntytocart','$totaltocart','$taxable')");
	
	if($ty){
	    $ian =mysqli_query($con,"SELECT SUM(total) as totalpayable from tempcart where salesid='$cartid'");
	    $rowian = mysqli_fetch_array($ian);
	    $allusers = mysqli_query($con,"select * from tempcart where salesid='$cartid'  ORDER BY `id` DESC");
	    while($usersrow = mysqli_fetch_array($allusers))
	    {
	        echo '<tr>';
	        echo '<td>'.$usersrow['id'].'</td>';
	        echo '<td><button class="btn btn-outline" style=" white-space: normal;padding:0;
  max-width: 200px;">'.$usersrow['product'].'</button></td>';
	        echo '<td>'.$usersrow['qnty'].'</td>';
	        echo '<td>'.$usersrow['price'].'</td>';
	        echo '<td>'.$usersrow['total'].'</td>';
	        echo '<td><button class="removebtn" value="'.$usersrow['id'].'">DELETE</button></td>';
	        echo '</tr>';
	   }
	}else{
		echo mysqli_error($con);
	}
	}
}
?>