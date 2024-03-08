<?php
session_start();
include('connection.php');
$userid = $_SESSION['username'];
$cartid = $_POST['cartid'];
$receiptstored = false;
if (isset($_POST['payable']) && isset($_POST['amountGivenValue']) && isset($_POST['balanceValue'])) {
    $transactiontype = $_POST['transtype'];
    $transactiondescription = $_POST['transdesc'];
    $da = date("d/m/Y");
    $cashier = $userid;

    $payable = $_POST['payable'];
    $totalAmtGiven = $_POST['amountGivenValue'];
    $balance = $_POST['balanceValue'];
    $transactionTypeValue = $_POST['transactionTypeValue'];
    $discount = $_POST['discountValue'];
    $transactionDescValue = $_POST['transactionDescValue'];
    $customer = $_POST['customer'];
    
    if ($transactionTypeValue != '') {
        $activity = "Made a sale Receipt No, " . $cartid;
        $role = "Cashier";
        mysqli_query($con, "INSERT INTO `logs`(`type`, `user`, `activity`, `role`) VALUES ('Sales','$userid','$activity','$role')");
        mysqli_error($con);
        $query = "INSERT INTO receipts(cartid, payable, amountgiven, balance, dated, cashier, discount, transactiontype, transactiondescription, customer)
                  VALUES('$cartid', '$payable', '$totalAmtGiven', '$balance', '$da', '$cashier', '$discount', '$transactionTypeValue', '$transactiondescription', '$customer')";
                  
        if ($result = mysqli_query($con, $query)) {
            
            $receiptstored = true;
            $gettaxable = mysqli_query($con, "SELECT SUM(qnty) as qnty from tempcart where salesid = '$cartid'");
            mysqli_error($con);
            $taxableamountr = mysqli_fetch_array($gettaxable);
            $taxableamount = $taxableamountr['qnty'];
            mysqli_error($con);
            if ($taxableamount > 0 && $discount > 0) {
                $taxableunit = $discount / $taxableamount;
                mysqli_query($con, "UPDATE TEMPCART SET price = price - '$taxableunit' where salesid = '$cartid'");
                mysqli_error($con);
                mysqli_query($con, "UPDATE TEMPCART SET total = price * qnty  where salesid = '$cartid'");
                mysqli_error($con);
            }
        
            
            if ($anza = mysqli_query($con, "INSERT INTO cart (SELECT * FROM tempcart where salesid = '$cartid')")) {
                mysqli_error($con);
                $why = mysqli_query($con, "SELECT * FROM tempcart where salesid = '$cartid'");
                mysqli_error($con);
                $mmmhh = false;
        
                while ($rowwhy = mysqli_fetch_array($why)) {
                    $whyproduct = $rowwhy['product'];
                    $whynumber = $rowwhy['qnty'];
                    $bm = "UPDATE inventory SET totalpieces = totalpieces - '$whynumber' where brand = '$whyproduct'";
                    
                    if (mysqli_query($con, $bm)) {
                        $mmmhh = true;
                    }else{
                        mysqli_error($con);
                    }
                }
                
            }else{
                mysqli_error($con);
            }
        }else{
            mysqli_error($con);
        }
    } else {
        // Handle case where no transaction type is selected
    }
    echo $receiptstored;
}