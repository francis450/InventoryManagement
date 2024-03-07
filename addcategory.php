<?php
include('connection.php');
// $con = mysqli_connect("localhost","infodata_francis","Franc!s2001","infodata_bigbroke")
if(isset($_POST['invoiceid'])){
    $invoiceid = $_POST['invoiceid'];
    // echo $invoiceid;
    $query = "UPDATE invoices SET approved = '1' WHERE id = '$invoiceid'";
    if(mysqli_query($con, $query)){
        echo true;
    }else{
        echo false;
    }
}

if(isset($_POST['productforstock'])){
    $productforstock = $_POST['productforstock'];
    $checkcategory = mysqli_query($con, "SELECT totalpieces FROM inventory WHERE brand = '$productforstock'");
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['totalpieces'];
    } 
}
if(isset($_POST['productformeasure'])){
    $productformeasure = $_POST['productformeasure'];
    $checkcategory = mysqli_query($con, "SELECT measure FROM inventory WHERE brand = '$productformeasure'");
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['measure'];
    } 
}
if(isset($_POST['productforretail'])){
    $productforretail = $_POST['productforretail'];
    $checkcategory = mysqli_query($con, "SELECT retail FROM inventory WHERE brand = '$productforretail'");
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['retail'];
    } 
}
if(isset($_POST['productforwholesale'])){
    $productforwholesale = $_POST['productforwholesale'];
    $checkcategory = mysqli_query($con, "SELECT wholesale FROM inventory WHERE brand = '$productforwholesale'");
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['wholesale'];
    } 
}

if(isset($_POST['productforshelf'])){
    $productforshelf = $_POST['productforshelf'];
    $checkcategory = mysqli_query($con, "SELECT shelf FROM inventory WHERE brand = '$productforshelf'");
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['shelf'];
    } 
}

if(isset($_POST['productforsupplier'])){
    $productforsupplier = $_POST['productforsupplier'];
    $checkcategory = mysqli_query($con, "SELECT supplier FROM inventory WHERE brand = '$productforsupplier'");
    
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['supplier'];
    } 
}

if(isset($_POST['productforsubcategory'])){
    $productforsubcategory = $_POST['productforsubcategory'];
    $checkcategory = mysqli_query($con, "SELECT subcategory FROM inventory WHERE brand = '$productforsubcategory'");
    
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['subcategory'];
    }
}

if(isset($_POST['productforcategory'])){
    $productforcategory = $_POST['productforcategory'];
    $checkcategory = mysqli_query($con, "SELECT category FROM inventory WHERE brand = '$productforcategory'");
    
    if(mysqli_num_rows($checkcategory)>0){
        $category = mysqli_fetch_array($checkcategory);
        echo $category['category'];
    }else{
        echo 'category';
    }
}

if(isset($_POST['productforbarcode'])){
    $productforbarcode = $_POST['productforbarcode'];
    $checkbarcode = mysqli_query($con, "SELECT * FROM `inventory` WHERE brand = '$productforbarcode'");
    
    $code = mysqli_fetch_array($checkbarcode);
    if(mysqli_num_rows($checkbarcode) > 0){
        echo $code['barcode'];
    }else{
        echo '';
    }
}
if(isset($_POST['newsupplier'])){
    $supplier = $_POST['newsupplier'];
    $uiy = date('Y-m-d H:i:s');
    $long = strtotime($uiy);
    $supplierid = rand(1000, 100000) + $long;
    
    // Assuming $con is your database connection
    // Also, make sure the column names in the SQL query match your database schema
    $query = "INSERT INTO suppliers (supplierid, supplier) VALUES ('$supplierid', '$supplier')";
    $newsupplier = mysqli_query($con, $query);

    if($newsupplier){
        $allsupplier = mysqli_query($con, "SELECT  DISTINCT * FROM suppliers ORDER BY supplier ASC");
        while($allsuppliers = mysqli_fetch_array($allsupplier)){
            echo '<option value="'.$allsuppliers['supplierid'].'">'.$allsuppliers['supplier'].'</option>';
        }
    }
}

if(isset($_POST['product'])){
    $product = $_POST['product'];
    
    // Insert into inventory
    $query = "INSERT INTO `inventory`(`brand`)VALUES ('$product')";
    $productadded = mysqli_query($con, $query);
    
    if($productadded){
        $prod = mysqli_query($con, "SELECT distinct * FROM inventory order by `brand` ASC");
        while($prods = mysqli_fetch_array($prod)){
            echo '<option value = '.$prods['barcode'].'>'.$prods['brand'].'</option>';
        }
    }
    
}

if(isset($_POST['measure'])){
    $measure = $_POST['measure'];
    $m = mysqli_query($con, "INSERT INTO `categories`(`measure`)values('$measure')");
    // var_dump($m);
    if($m){
        $measures = mysqli_query($con, "SELECT  DISTINCT * FROM categories WHERE measure != '' ORDER BY measure ASC");
        while($allmeasures = mysqli_fetch_array($measures)){
            echo '<option>'.$allmeasures['measure'].'</option>';
        }
    }else{
        echo "Not added";
        echo mysqli_error($con);
    }
}
if (isset($_POST['catuppercase'])) {
	$category = $_POST['catuppercase'];
	$f = mysqli_query($con,"insert into categories(category)values('$category')");
	if ($f) {
		$d = mysqli_query($con,"select * from categories where category != '' order by category ASC");
		while($row=mysqli_fetch_array($d)){
			echo '<option>'.$row['category'].'</option>';
		}
		}else{
			echo mysqli_error($con);
		}
	
	
}
if (isset($_POST['subcatuppercase'])) {
	$category = $_POST['maincategory'];
	$subcategory = $_POST['subcatuppercase'];
	$code = $category.$subcategory;
	$f = mysqli_query($con,"INSERT INTO `categories`(`subcategory`) VALUES ('$subcategory') ");
	if ($f) {
		$d = mysqli_query($con,"select * from categories where subcategory != '' order by subcategory ASC");
		while($row=mysqli_fetch_array($d)){
			echo '<option>'.$row['subcategory'].'</option>';
		}
		}else{
			echo mysqli_error($con);
		}
}
if(isset($_POST['shelf'])){
    $shelf = $_POST['shelf'];
    $shelf = strtoupper($shelf);  // Corrected line

    $query = mysqli_query($con, "INSERT INTO categories (`shelf`) VALUES ('$shelf')");
    
    if($query){
        $ret = mysqli_query($con, "SELECT * FROM categories WHERE shelf != '' ORDER BY shelf ASC");  // Corrected order by clause
        while($rets = mysqli_fetch_array($ret)){
            echo '<option>'.$rets['shelf'].'</option>';
        }
    }
}


if (isset($_POST['thiscategory'])) {
	$category = $_POST['thiscategory'];
	
	
	$d = mysqli_query($con,"select * from categories where category = '$category' ");
		while($row=mysqli_fetch_array($d)){
			echo '<option>'.$row['subcategory'].'</option>';
		}
	
}
?>