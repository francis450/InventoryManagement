<?php
session_start();
include("../connection.php");
// error_reporting(0);
$userid = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header("Location: index.php");
}
// include('connection.php');


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$err = [];
$err = array();
$success = array();
$supplierako = false;
$brand;
$product;

if(isset($_POST['product'])){
    if($_POST['product'] == '--select--'){
        $err[] = "Product Cannot Be Null";
    }else{
        $product = $_POST['product'];
        $brand = $product;
        $success[] = "Product: $product";
    }
}

if(isset($_POST['supplier'])){
    if($_POST['supplier'] == '--select--'){
        $supplier = "SUPPLIER";
        $supplierid = "001";
        array_push($err, "Supplier Cannot Be Null");
        // $defsupp = mysqli_query($con, "INSERT INTO `suppliers`(`supplier`,`supplierid`) VALUES ('$supplier', '$supplierid')");
    }else{
        $supplierako = true;
        $supplier = $_POST['supplier'];
        $supplier = mysqli_real_escape_string($con, $supplier); // Escape user input
        $querysuppliers = mysqli_query($con, "SELECT * FROM `suppliers` WHERE supplier = '$supplier'");
        if(!$querysuppliers){
            echo "suppliersquery: ";
            // var_dump($querysuppliers);
        }
        $allsuppliers = mysqli_fetch_array($querysuppliers);
        $supplierid = $allsuppliers['supplierid'];
    }

}

$isthereinvoice = false;


// invoiceNumber
$invoiceNumber;
if(isset($_POST['invoiceNumber']) && $_POST['invoiceNumber'] != ''){
    $isthereinvoice = true;
    $invoiceNumber = $_POST['invoiceNumber'];
    $success[] = "InvoiceNo. $invoiceNumber added";
}else{
    array_push($err, "Invoice Number Cannot Be Null");
}

// invoiceDate
if(isset($_POST['invoiceDate']) && $isthereinvoice){
    $invoiceDate = $_POST['invoiceDate'];
    $success[] = "InvoiceDate: $invoiceDate";
} else if($isthereinvoice){
    array_push($err, "Invoice Date Cannot be null");
}

// cost
if(isset($_POST['cost'])){ // Use $_POST['cost'] instead of $_POST['invoiceDate']
    $cost = $_POST['cost'];
    $success[] = "Amt: $cost Addded";
} else {
    array_push($err, "Cost Cannot Be Null");
}

// paidToSupplier
if(isset($_POST['paidToSupplier']) ){
    $paidToSupplier = $_POST['paidToSupplier'];
    $success[] = "$paidToSupplier is paid to supplier";
} else if($isthereinvoice){
    array_push($err, "Amount Paid To Supplier Cannot Be Null");
} else {
    $paidToSupplier = 0;
}

 

if(isset($_POST['balanceToSupplier']) && is_numeric($_POST['balanceToSupplier']) && $_POST['balanceToSupplier'] >= 0){
    $balanceToSupplier = $_POST['balanceToSupplier'];
    $success[] = "Suppier Balance: $balanceToSupplier";
} else if($isthereinvoice){
    array_push($err, "Balance to Supplier Cannot Be Null or Negative");
} else {
    $balanceToSupplier = 0;
}
// category
if(isset($_POST['category']) && $_POST['category'] == '--select--'){
    $category = "Category";
}else{
    $category = $_POST['category'];
    $success[] = "category: $category";
}
// subcategory
if(isset($_POST['subcategory']) && $_POST['subcategory'] == '--select--'){
    $subcategory = "subCategory";
}else{
    $subcategory = $_POST['subcategory'];
    $success[] = "Subcategory: $subcategory";
}
// serialNumber
if(isset($_POST['serialNumber'])){
    $serial = $_POST['serialNumber'];
    $success[] = "S.No.: $serial";
}else{
    $serial = "$subcategory.''.$product";
}
// units
$units = 0; // Default value

if(isset($_POST['units']) && $_POST['units'] > 0){
    $units = $_POST['units'];
    $success[] = "Units: $units";
} else if(isset($_POST['units']) && $_POST['units'] == 0){
    array_push($err, "Units cannot be zero");
} else if(isset($_POST['units']) && $_POST['units'] < 0){
    array_push($err, "Units Cannot Be Negative");
}

$subunits = 0; // Default value

if(isset($_POST['subunits']) && $_POST['subunits'] > 0){
    $subunits = $_POST['subunits'];
    $success[] = "Subunits: $subunits";
} else if(isset($_POST['subunits']) && $_POST['subunits'] == 0){
    array_push($err, "Subunits cannot be zero");
} else if(isset($_POST['subunits']) && $_POST['subunits'] < 0){
    array_push($err, "Subunits Cannot Be Negative");
}

// totalPieces
if(isset($_POST['totalPieces']) && $_POST['totalPieces'] > 0){
    $totalPieces = $_POST['totalPieces'];
    $success[] = "Pieces: $totalPieces";
}else if($_POST['totalPieces'] == 0){
    array_push($err,"totalPieces cannot be zero");
}else if($_POST['totalPieces'] < 0){
    array_push($err, "totalPieces Cannot Be Negative");
}
// costUnit
$costUnit = 0; // Default value

if(isset($_POST['costUnit']) && $_POST['costUnit'] > 0){
    $costUnit = $_POST['costUnit'];
    $success[] = "Cost/Unit: $costUnit";
} else if(isset($_POST['costUnit']) && $_POST['costUnit'] < 1){
    array_push($err, "Invalid Data Entered");
}

// costSubUnit
$costSubUnit = 0; // Default value

if(isset($_POST['costSubUnit']) && $_POST['costSubUnit'] > 0){
    $costSubUnit = $_POST['costSubUnit'];
    $success[] = "costSubUnit: $costSubUnit";
} else if(isset($_POST['costSubUnit']) && $_POST['costSubUnit'] < 1){
    array_push($err, "Invalid Data Entered");
}

// measure
if(isset($_POST['measure'])){
    $measure = $_POST['measure'];
}else{
    $measure = 'units';
}
// expiryDate
if(isset($_POST['expiryDate'])){
    $expiryDate = $_POST['expiryDate'];
} else {
    $expiryDate = NULL; // No expiry date set
}

// retailPrice
$retailPrice = 0; // Default value

if(isset($_POST['retailPrice']) && $_POST['retailPrice'] > 0){
    $retailPrice = $_POST['retailPrice'];
    $success[] = "Retail: $retailPrice";
} else if(isset($_POST['retailPrice']) && $_POST['retailPrice'] < $costSubUnit){
    array_push($err, "Retail Price Cannot Be Less Than Cost per subunit");
} else if(!isset($_POST['retailPrice'])){
    array_push($err, "Retail Price Cannot Be Null");
}

// wholesalePrice
$wholesalePrice = 0; // Default value

if(isset($_POST['wholesalePrice']) && $_POST['wholesalePrice'] > 0){
    $wholesalePrice = $_POST['wholesalePrice'];
    $success[] = "Wholesale: $wholesalePrice";
} else if(isset($_POST['wholesalePrice']) && $_POST['wholesalePrice'] < $costSubUnit){
    array_push($err, "Wholesale Price Cannot Be Less Than Cost per subunit");
} else if(!isset($_POST['wholesalePrice'])){
    array_push($err, "Wholesale Price Cannot Be Null");
}
if(isset($_POST['reorder'])){
    $reorder = $_POST['reorder'];
    
}

// shelf
if(isset($_POST['shelf']) && $_POST['shelf']){
    $shelf = $_POST['shelf'];
}else{
    $shelf = 'Shelf';
}

///barcode
$barcode;
if(isset($_POST['barcode'])){
    $barcode = $_POST['barcode'];
}

$today = date('Y-m-d H:i:s');
//Check the role of the user
$userr = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE `username` = '$userid'"));
// var_dump($userr);
if($userr['isadmin'] == 1){
    $role =  'Admin';
}else{
    $role = "User";
}
// echo $role;

// Store product's critical details
if(count($err) <= 0){
    //Get initial values from the product
    $getproducts = mysqli_query($con, "SELECT * FROM `inventory` where brand = '$product'");
    // var_dump($getproducts);
    if($getproducts){
        $success[] = "got products";
    }else{
        echo "Products Query: ";
        // var_dump($getproducts);
        die("Query failed: " . mysqli_error($con));;
    }
    // echo mysqli_error($con);
    
    // var_dump($allproductsdetails);
    // for2each ($allproductsdetails as $key -> $value) {
        // echo $key -> $value." ";
        // if($value == $product){
        //     echo "Found: ";
        //     echo $value." ".$product;
        // }else{
        //      echo "Not: ";
        //     echo $value." and ".$product;
        // }
    // }
    // if($allproductsdetails['brand'] == $product){
    //     echo $product;
    // }else{
    //     echo $allproductsdetails;
    // }
    // echo $allproductsdetails['barcode'];
    // echo "Product ".$allproductdetails['product'];
    
    
    if(mysqli_num_rows($getproducts) > 0){
        $allproductsdetails = mysqli_fetch_array($getproducts);
        // echo "inside";
        if(($allproductsdetails['retail'] == 0 && $allproductsdetails['wholesale'] == 0) && ($allproductsdetails['retail'] != $retailPrice && $allproductsdetails['wholesale'] != $wholesalePrice)){
            
            $insertRetail = mysqli_query($con, "UPDATE `inventory` SET `retail`='$retailPrice',`wholesale`='$wholesalePrice' WHERE brand = '$product' OR barcode = '$barcode'");
            $t = "Price Setting";
            $activity = "Set Retail to $retailPrice and wholesale to $wholesalePrice";
            if($insertRetail){
                mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$t','$userid','$activity','$today','$role')");
            }else{
                // var_dump($insertRetail);
                array_push($err, mysqli_error($con));
                array_push($err, "Price Not Set");
            }
        }else {
            $activity = "Changed Retail and wholesale prices of $product from " . $allproductsdetails['retail'] . " to $retailPrice and " . $allproductsdetails['wholesale'] . " to $wholesalePrice";
            $priceUpdate = mysqli_query($con, "UPDATE `inventory` SET `retail`='$retailPrice', `wholesale`='$wholesalePrice' WHERE brand = '$product' OR barcode = '$barcode'");
            $t = "Price Change";
            if ($priceUpdate) {
                // mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$t', '$userid', '$activity', '$today', '$role')");
                $success[] = "Retail updated";
            } else {
                // var_dump($priceUpdate);
                array_push($err, mysqli_error($con));
                array_push($err, "Prices Not Updated");
            }
        }
        if($allproductsdetails['barcode']  == '' || $allproductsdetails['barcode'] == NULL){
            $qq = "UPDATE `inventory` SET `barcode` = '$barcode' where  `brand` = '$product'";
            
            $ttaa = "BARCODE UPDATE";
            $actit = "Update $product SET barcode = '$barcode'";
            $setBarcode;
            if($setBarcode = mysqli_query($con,$qq)){
                mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$ttaa','$userid','$actit','$today')");
            }else{
                echo "Barcode Query: ";
                // var_dump($qq);
            }
        }
        $taxable = 0;
        if(isset($_POST['taxable'])){
            if($_POST['taxable'] == true || $_POST['taxable'] == 1){
                $taxable = 1;
            }else{
                $taxable = 0;
            }
        }
        if ($allproductsdetails['units'] <= 0 || $allproductsdetails['subunits'] <= 0) {
            $ty = "Stocking";
            $a = "Added $units units and $subunits subunits to product $product";
        
            $restock = mysqli_query($con, "UPDATE `inventory` SET `expiry` = '$expiryDate',`reorder` = '$reorder', `totalpieces` = `totalpieces`+'$totalPieces', `units` = '$units', `subunits` = '$subunits' WHERE brand = '$product' OR barcode = '$barcode'");
        
            if ($restock) {
                $logQuery = "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$ty', '$userid', '$a', '$today', '$role')";
                mysqli_query($con, $logQuery);
                $success[] = "Stocked";
            } else {
                echo "Restocking Query";
                // var_dump($restock);
                array_push($err, mysqli_error($con));
                array_push($err, "Stock not added");
            }
        }else {
            // RESTOCKING
            $res = "Restocking";
            $act = "Added $units units ($subunits subunits) to the existing ".$allproductsdetails['units']." units (".$allproductsdetails['subunits'].")";
        
            $stocking = mysqli_query($con, "UPDATE `inventory` SET `totalpieces` = `totalpieces`+'$totalPieces',`units` = `units` + '$units', `subunits` = `subunits` + '$subunits' WHERE brand = '$product' OR barcode = '$barcode'");
            // $trigger = "CREATE TRIGGER calculate_total_price
            //     AFTER INSERT ON `inventory`
            //     FOR EACH ROW
            //     BEGIN
            //         UPDATE products
            //         SET totalpieces = NEW.quantity * NEW.price
            //         WHERE id = NEW.id;
            //     END";

            if ($stocking) {
                $logQuery = "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$res', '$userid', '$act', '$today', '$role')";
                mysqli_query($con, $logQuery);
                $success[] = "Restocked";
            } else {
                echo "STcoking error";
                // var_dump($stocking);
                array_push($err, mysqli_error($con));
                array_push($err, "Restocking failed");
            }
        }

        if ($supplierako) {
            if($supplierid != $allproductsdetails['supplier']){
                $taipp = "Supplier Addition";
                $actionn = "Added Supplier $supplier";
                $addSuppl = mysqli_query($con, "UPDATE `inventory` SET `supplier` = '$supplierid' WHERE brand = '$product' OR barcode = '$barcode' ");

                if($addSuppl){
                    mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES ('$taipp','$user','$actionn','$today','$role')");
                }else{
                    $err[] = mysqli_error($con);
                    echo "Adding Supplier Error";
                    var_dump($addSuppl);
                }
            }
            // Supplier payment
            $actio = "Supplier Payment";
            $activ = "Paid Supplier $supplierid, $paidToSupplier for $totalPieces of $Product";
            if(!$invoiceNumber){
                $invoiceNumber = "INV001";
            }
        
            $paid = mysqli_query($con, "INSERT INTO `supplierpayment`(`details`, `amount`, `invoicenumber`, `dated`, `supplier`) VALUES ('$totalPieces','$paidToSupplier','$invoiceNumber','$today','$supplierid')");

            if ($paid) {
                $ress = "Supplier Payment";
                $actt = "Paid $paidToSupplier to Supplier $supplierid for $totalPieces Invoice($invoiceNumber)";
            
                mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES ('$ress','$userid','$actt','$today','$role')");
                $success[] = "Supplier Paid";
            } else {
                echo "SUpp payment error";
                // var_dump($paid);
                array_push($err, mysqli_error($con));
                array_push($err, "Supplier Not Paid");
            }

        
            if (($cost - $paidToSupplier) > 0) {
                // Supplier Debt
                $resss = "Supplier Debt";
                $debt = $cost - $paidToSupplier;
                $acttt = "$debt is owed to $supplierid";
        
                mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES('$resss','$userid','$acttt','$today','$role')");
                $success[] = "Supplier Debt Added";
            }
            
        
            // INVOICE 
            if (isset($_POST['invoiceNumber'])) {
                $taip = "Invoices";
                $activiti = "Added invoice $invoiceNumber to invoices";
                $insertInvoice;
                if($barcode  == ''){
                    $insertInvoice =  "INSERT INTO `invoices`(`invoicenumber`, `invoicedate`, `supplierid`, `product`, `units`, `subunits`, `totalcost`, `amountpaid`) 
                                                    VALUES ('$invoiceNumber','$invoiceDate','$supplierid','$product','$units','$subunits','$cost','$paidToSupplier')";
                }else{
                    $insertInvoice =  "INSERT INTO `invoices`(`invoicenumber`, `invoicedate`, `supplierid`, `barCode`, `product`, `units`, `subunits`, `totalcost`, `amountpaid`) 
                                                    VALUES ('$invoiceNumber','$invoiceDate','$supplierid','$barcode', '$product','$units','$subunits','$cost','$paidToSupplier')";
                }
                if (mysqli_query($con, $insertInvoice)) {
                    mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `timed`, `role`) VALUES ('$taip','$userid','$activiti','$today','$role')");
                    $success[] = "Invoice Added";
                } else {
                    echo "INVOICE error";
                    // var_dump($insertInvoice);
                    array_push($err, mysqli_error($con));
                    array_push($err, "Invoice Not Added");
                }
            }
        }
        if($category && $subcategory){
            $updateCat = mysqli_query($con, "UPDATE `inventory` SET `measure` = '$measure',`shelf` = '$shelf' ,`category`='$category',`subcategory`='$subcategory' WHERE brand = '$product' OR barcode = '$barcode'");
            $ac = "Added Category and SubCategory to $product";
            $typee = "Categorization";

            if($updateCat){
                mysqli_query($con, "INSERT INTO `logs` (`type`, `user`, `activity`, `timed`, `role`) VALUES('$typee','$userid','$ac','$today','$role')");
            }else{
                // var_dump($updateCat);
            }
        }
        if($shelf){
            $updateShelf = "UPDATE `inventory` SET `shelf` = `$shelf` WHERE brand = '$product' OR barcode = '$barcode'";
        }
        
        if($costUnit && $costSubUnit){
            $updateCostUnit = "UPDATE `inventory` SET `taxable` = '$taxable', `unitcost` = $costUnit, `subunitcost` = '$costSubUnit' WHERE brand = '$product' OR barcode = '$barcode'";

            if(mysqli_query($con, $updateCostUnit)){
                $success[] = "UnitCost And SubunitCost Updated";
                
            }else{
                // var_dump($updateCostUnit);
                $err[] = mysqli_error($con);
            }
        }
    }
    if(count($err) > 0){
        echo "Error: ";
        foreach ($err as $error) {
            echo $error;
        } 
    }else if(count($success) > 0){
        echo "$product Details Updated Successfully";
    }else{
        echo "Iko Empty";
    }
}else{
    foreach ($err as $value) {
        echo $value . "<br>";
    }
    
}

// store invoice data if available
// Log every change in the db by type of change
// Store supplier payments 
///Store supplier debt if any
