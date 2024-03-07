<?php
require_once('TCPDF/tcpdf.php');
include('connection.php');
if (!$con) {
    var_dump($con);
}
$username = $_SEESSION['username'];
$sample = $_GET['cartid'];

// Set the custom width in pixels
$customWidth = 70.66;

// Create a new PDF instance with custom width and larger height
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array($customWidth, 130), true, 'UTF-8', false);
// $barcode = new TCPDFBarcode($sample, 'C128');
// $pdf->write1DBarcode($barcode, 'C128', '', '', '', 18, 0.4);

$pdf->SetMargins(2, 2, 2); 
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('SOKO MINIMART');
$pdf->SetSubject('Receipt for Purchase');


$today = date('Y-m-d H:i:s');   
// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('courier', 'B', 11);

// Add the header details
$pdf->setBarcode(date('Y-m-d H:i:s'));
// $pdf->Cell(0, 0, 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9', 0, 1);
$getshop = mysqli_query($con, 'SELECT * FROM shop');
$shop = mysqli_fetch_assoc($getshop);
if($shop['showLogo']){
    // $imagePath = 'assets/images/logominimart.png';
    $imagePath = $shop['logo'];
    // echo $shop['logo'];
    $imageX = 20;
    $imageY = 5;
    $imageWidth = 30;
    $imageHeight = 0;
    $pdf->Image($imagePath, $imageX, $imageY, $imageWidth, $imageHeight);
    $pdf->Ln(12);
}else{
    $shopname = $shop['name'];
    $pdf->Cell(0, 5, $shopname, 0, 1, 'C');
    $pdf->Ln(4);
}

// $pdf->Cell(0, 5, 'SOKO MART', 0, 1, 'C');
if($shop['showLocation']){
    $pdf->Cell(0, 5, $shop['location'], 0, 1, 'C');
}

$pdf->SetFont('courier', 'B', 9);
if($shop['showPin'] && $shop['pin'] != ''){
    $pdf->Cell(0, 5, $shop['pin'], 0, 1, 'C');
}
// 
if($shop['showPhone'] && $shop['phone'] != ''){
    $pdf->Cell(0, 3, $shop['phone'], 0, 1, 'C');
}

$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetPageWidth() - $pdf->GetX(), $pdf->GetY());
$pdf->Cell(0, 3, "Receipt No. ".$sample, 0, 1, 'C');
if($shop['showTill']){
    $pdf->Cell(0, 3, "Till No. ".$shop['till'],0, 1, 'C');
}
$quer = mysqli_query($con, "SELECT * FROM `receipts` WHERE cartid = '$sample'");
$getDate = mysqli_fetch_assoc($quer);
$pdf->Cell(0, 3, "Date: ".$getDate['timed'], 0, 1, 'C');
$pdf->Cell(0, 3, "DUPLICATE RECEIPT", 0, 0, 'C' );
$pdf->Cell(0, 3, '', 0, 1); // Add an empty line
$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));
$pdf->SetFont('courier', 'B', 7);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetPageWidth() - $pdf->GetX(), $pdf->GetY());
$pdf->Cell(2, 5, "# ", 0, 0, 'L');
$pdf->Cell(45, 5, "ITEM", 0, 0, 'L');
$pdf->Cell(4, 5, "QTY", 0, 0, 'C');
$pdf->Cell(7, 5, "UNIT", 0, 0, 'C');
$pdf->Cell(12, 5, "TOTAL", 0, 0, 'C');
//Move down before drawing the next line
$pdf->Ln(4); // Adjust the spacing as needed0

// Second Horizontal Line
$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetPageWidth() - $pdf->GetX(), $pdf->GetY());


// Execute the SQL query
$query = mysqli_query($con, "SELECT * FROM `cart` WHERE salesid = '$sample'");
$count = 0;
$qnts = [];
$subtotal = [];
$tax = [];
while($row = mysqli_fetch_array($query)){ 
    $qnts[] = $row['qnty'];
    $subtotal[] = $row['total'];
    if($row['tax'] == 1){
        $tax[] = 0.16 * $row['total'];
    }else{
        $tax[] = 0;
    }
    $count += 1;
    
    $pdf->Cell(2, 5, $count.". ", 0, 0, 'L');
    $pdf->MultiCell(45, 5, $row['product'], 0, 'L');

    $pdf->Cell(4, 5, $row['qnty']." x ", 0, 0, 'C');
    $pdf->Cell(7, 5, number_format($row['price'],2), 0, 0, 'C');
    $pdf->Cell(12, 5, number_format($row['total'],2), 0, 1, 'C');

} 
$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));

// check items with tax
// foreach($products as $product){
//     $allproducts = mysqli_query($con, "SELECT * FROM `inventory` where brand = '$product'");
// }
$taxx = array_sum($tax);
$startX = $pdf->GetX() + ($pdf->GetPageWidth() - $pdf->GetX()) / 2; 
$pdf->Line($startX, $pdf->GetY(), $pdf->GetPageWidth(), $pdf->GetY());
$pdf->Cell(45, 5,"SubTotal: ", 0, 0, 'R');
$pdf->Cell(8, 5,array_sum($qnts), 0, 0, 'C');
$pdf->Cell(14, 5,number_format(array_sum($subtotal)-$taxx,2), 0, 1, 'R'); 

$pdf->Cell(45, 3,"Additional(VAT): ", 0, 0, 'R');
// $pdf->Cell(3, 3,number_format($taxx,2), 0, 0, 'R');
$pdf->Cell(22, 5,$taxx, 0, 1, 'R');

$pdf->Cell(45, 3,"Total :", 0, 0, 'R');
// $pdf->Cell(3, 3,number_format(array_sum($qnts),2), 0, 0, 'R');
$pdf->Cell(22, 5,number_format(array_sum($subtotal),2), 0, 0, 'R');
    $pdf->SetFont('courier', 'B', 9);
$pdf->Ln(5); // Add a little space between heading details and content
$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetPageWidth() - $pdf->GetX(), $pdf->GetY());
$pdf->Cell(0, 0,"PAYMENT DETAILS", 0, 1, 'C');
$pdf->SetLineStyle(array(
    'width' => 0.2,   // Line width in points
    'color' => array(0, 0, 0)  // Line color as RGB values
));
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetPageWidth() - $pdf->GetX(), $pdf->GetY());

// var_dump($receipts);
$balance;
$cashier;
$receipts = mysqli_query($con, "SELECT * FROM receipts where cartid = '$sample'");
while($receipt = mysqli_fetch_array($receipts)){ 
    // $pdf->Ln();
    $balance = $receipt['balance'];
    $cashier = $receipt['cashier'];
    $pdf->Cell(0, 0, $receipt['transactiontype'].": ", 0, 0, 'L');
    $pdf->Cell(0, 0, "Kshs. ".number_format($receipt['amountgiven']), 0, 1, 'R');
}

$pdf->Cell(0, 0, "Balance:", 0, 0, 'L');
$pdf->Cell(0,0,"Kshs. ".number_format($balance),0,1,'R');
if($shop['showcashier']){
    $pdf->Cell(0, 0, "You Were Served By:", 0, 0, 'L');
    $pdf->Cell(0,0,$cashier,0,1,'R');
}

$pdf->Ln(5);

$barcodeWidth = 9; // Original width
$barcodeHeight = 0.2; // Original height

$pageWidth = $pdf->GetPageWidth(); // Get the width of the page
$center = $pageWidth-$barcodeWidth;
$xCenter = ($pageWidth)/4; // Calculate X position for centering

$pdf->SetX($xCenter); 
$pdf->write1DBarcode($sample, 'C39', '', '', '', $barcodeWidth, $barcodeHeight, $style, 'N');


$pdf->Ln();
$pdf->Cell(0, 2, "Receipt No. ".$sample, 0, 1, 'C');
$contentHeight = $pdf->GetY();
// $pdf->SetPageFormat(array($customWidth, $contentHeight + 10)); // Add some padding
$pdf->Cell(0, 2, "Thank you for shopping with Us.", 0, 1, 'C');
$pdf->SetFont('courier', 'B', 7);
$pdf->Cell(0, 2, "System Powered By Bigbro(www.bigbro.co.ke)", 0, 1, 'C');
// Output the PDF

// $pdf->Output('kuitti'.$ordernumber.'.pdf', 'F');
$pdf->Output('receipt.pdf', 'I'); // 'I' to display inline

// Close the database connection
$pdo = null;
