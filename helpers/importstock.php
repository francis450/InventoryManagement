<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$userid = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
$uiy = date('Y-m-d H:i:s');
$long = strtotime($uiy);
$supplierid = rand(1000, 100000) + $long;

include('../connection.php');
$user = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['headings']) && isset($_POST['ndata'])) {
    $headings = $_POST['headings'];
    $ndata = $_POST['ndata'];

    $count = count($headings);
    $c = count($ndata);
    // echo $count;
    for($i = 0;$i < $c; $i++){
        $exists = false;
        $checkExistence = mysqli_query($con, "SELECT * FROM inventory where brand = '$headings[0]'");
        $brand = $ndata[$i][0];
        if(mysqli_num_rows($checkExistence)>0){
            $exists = true;
        }else{ 
            $insertProduct = mysqli_query($con, "INSERT INTO inventory(`brand`) VALUES('$headings[0]')");
        }
        // var_dump($checkExistence);
        for($j=0;$j<$count;$j++){
            // echo $headings[$j]."--->".$ndata[$i][$j]." "; 
            if($exists){
                $vaa = $ndata[$i][$j];
                $query;
                if($headings[$j] == 'totalpieces'){
                    $query = mysqli_query($con, "UPDATE inventory SET totalpieces = totalpieces + '$vaa'");
                }
                $query = mysqli_query($con,"UPDATE inventory SET $headings[$j] = '$vaa' where brand = '$brand'");
                if($headings[$j] == 'invoicenumber')
            if($query){
                echo "Updated $headings[$j] to $vaa where brand = $brand";
            }else{
                echo "FAiled";
            }
            }
        }
    }
} else {
    echo "Invalid request method or missing parameters";
}
