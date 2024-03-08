<?php
session_start();
include('connection.php');
$userid = $_SESSION['username'];
$cartid = $_POST['cartid'];

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

    
        
        if (true) {
            mysqli_query($con, "TRUNCATE table tempcart");
        } else {
            echo "Table Not Truncated";
        }
    }

    $receiptstored = true;
    


    if ($balance < 0) {
        mysqli_query($con, "INSERT INTO credit(receipt, customer, amount) VALUES ('$cartid', '$customer', '$balance')");
    }

    if ($receiptstored) {
        $msgg = "Transaction complete";

        // Update profits
        $resultt = mysqli_query($con, "SELECT * FROM receipts WHERE date(timed) = CURDATE()");

        while ($row = mysqli_fetch_array($resultt)) {
            $yuii = $row['cartid'];
            $yuiit = mysqli_query($con, "SELECT * FROM cart WHERE salesid ='$yuii'");
            mysqli_error($con);
            while ($rowg = mysqli_fetch_array($yuiit)) {
                $ppp = $rowg['product'];
                $pppr = $rowg['qnty'];
                $pppp = mysqli_query($con, "SELECT * FROM inventory WHERE brand ='$ppp'");
                $p4 = mysqli_fetch_array($pppp);
                $s6 = $p4['subunitprice'];
                $s7 = $rowg['retail'];

                $p = $rowg['product'];
                $bp = $p4['subunitcost'];
                $sp = $rowg['price'];
                $qnty = $rowg['qnty'];
                $total = $rowg['total'];
                $initialbalance = $_POST['cashbalance'];
                $profit = ($sp - $bp) * $qnty;
                $dated = $rowg['dated'];
                $identity = $p . $dated;

                if (($timestamp = strtotime($dated)) !== false) {
                    $thismonth = date("m/Y", $timestamp);
                    $thisday = date("d/m/Y", $timestamp);
                }

                mysqli_query($con, "INSERT INTO profits(`product`,`bp`,`sp`,`qnty`,`total`,`profit`,`dated`,`identity`,`thismonth`,`thisday`)
                    VALUES('$p','$bp','$sp','$qnty','$total','$profit','$dated','$identity','$thismonth','$thisday')");
                    mysqli_error($con);
                    $usert = $_SESSION['username'];
                
                // $activity = "Completed Sale : " . $cartid;
                // $getrole = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE username = '$usert'"));
                // $role = "Cashier";
        
                // mysqli_query($con, "INSERT INTO logs(user,activity,role) VALUES ('$usert','$activity','$role')");
                    }
                }
    }

?>
