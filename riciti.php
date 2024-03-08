<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

    include('connection.php');

    $userid = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECEIPTS</title>
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="jquery.dataTables.min.css">

    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="jquery-3.3.1.min.js"></script>
    <script src="jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            /* var pin = prompt("Enter password");
            if(pin=='12345'){
                alert("Welcome Admin");
            }else{
                window.open('','_self').close();
            }*/

            $('#unitcost').keyup(function () {
                var thisunitcost = $(this).val();
                var thisitemunit = $("#itemunit").val();
                var thistotalunitcost = thisunitcost * thisitemunit;
                $("#totalunitcost").val(thistotalunitcost);

                var thissubunits = ($("#subunits").val()) * thisitemunit;
                $("#subunitcost").val(thistotalunitcost / thissubunits);
            });

            $('#paid').keyup(function () {
                var thispaid = $(this).val();
                var thistotalunitcost2 = $("#totalunitcost").val();
                var ball = thispaid - thistotalunitcost2;
                $("#balance").val(ball);
            });

            $(".editcommit").hide();

            $(".editbtn").click(function () {
                var b = prompt("Enter new Buying Price");
                $(this).closest('tr').children('td.bp').text(b);
                var thisbrand = $(this).closest('tr').children('td.brandname').text();
                var s = prompt("Enter new Retail Price");
                $(this).closest('tr').children('td.spr').text(s)
                var w = prompt("Enter new Wholesale Price");
                $(this).closest('tr').children('td.spw').text(w);

                $(this).closest('tr').children('td.editcommit').show();
            });

            $(".editcommit").click(function () {

                var editbrand = $(this).closest('tr').children('td.brandname').text();

                var editspr = $(this).closest('tr').children('td.spr').text()

                var editspw = $(this).closest('tr').children('td.spw').text();
                var bp = $(this).closest('tr').children('td.bp').text();

                $.post('editprices.php', {
                    editbrand: editbrand,
                    editspr: editspr,
                    editspw: editspw,
                    bp: bp,
                }, function (data) {
                    $(this).html(data);
                    console.log(data);
                });


            });
            $('#first').DataTable();
            $('#second').DataTable();

        });
    </script>
</head>
<body>
    <div class=row>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header" style="display: flex;justify-content:space-between;gap: 20px;">
                    <h4 style="font-size:bold;">RECEIPTS</h4>
                    <?php
                        if (isset($_GET['user'])) {
                            $pesaQuery = mysqli_query($con, "select sum(payable) as total from receipts where date(timed) = curdate()");
                            $paymentType = mysqli_query($con, "SELECT transactiontype, sum(payable) as amt from receipts where date(timed) = curdate() group by transactiontype");
                        } else {
                            $pesaQuery = mysqli_query($con, "select sum(payable) as total from receipts where cashier = '$userid' and date(timed) = curdate()");
                            $paymentType = mysqli_query($con, "SELECT transactiontype, sum(payable) as amt from receipts where date(timed) = curdate() and cashier = '$userid' group by transactiontype");
                        }
                        $pesaQuery = mysqli_query($con, "select sum(payable) as total from receipts where date(timed) = curdate()");
                        $takeArray = mysqli_fetch_array($pesaQuery);
                        $total = $takeArray['total'];
                        
                        $keyValueArray = array();

                        

                    ?>
                    <div style="display:flex;gap:10px;">
                        <button class="btn btn-outline-primary" style="font-size:16px"><span style="font-size:bold;">TOTAL SALES:</span><?php  echo "  <br>Kshs. ".number_format($total,2); ?></button>
                        <?php
                            while ($row = mysqli_fetch_array($paymentType)) {
                                $key = $row['transactiontype'];
                                $value = $row['amt'];
                                $keyValueArray[$key] = $value;
                                echo '<button class="btn btn-outline-info" style="font-size:16px">' . $key . ':<br> Kshs. ' . number_format($value, 2) . '</button>';
                            }
                            
                        ?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table .table-striped" id="first">
                        <thead>
                            <tr>
                                <th>Receipt No.</th>
                                <th>Payable(Kshs.)</th>
                                <th>Received(Kshs.)</th>
                                <th>Balance(Kshs.)</th>
                                <th>Transaction Type</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['user'])) {
                                $resultt = mysqli_query($con, "SELECT * FROM `receipts` where DATE(timed) = CURDATE() ORDER BY `timed` DESC");
                            } else {
                                $resultt = mysqli_query($con, "SELECT * FROM `receipts` where cashier = '$userid' AND DATE(timed) = CURDATE() ORDER BY `timed` DESC");
                            }
                            $count = 0;
                            while ($row = mysqli_fetch_array($resultt)) {
                                $count += 1;
                                echo "<tr>";
                                $timed = $row['timed'];
                                list($datePart, $timePart) = explode(' ', $timed);
                                echo '<td> <a href="writeAReceipt.php?cartid=' . $row['cartid'] . '">' . $row['cartid'] . '</a></td>';
                                echo '<td>' . $row['payable'] . '</td>';
                                echo '<td>' . $row['amountgiven'] . '</td>';
                                echo '<td>' . $row['balance'] . '</td>';
                                echo '<td>' . $row['transactiontype'] . '</td>';
                                echo '<td>' . $datePart . '</td>';
                                echo '<td>' . $timePart . '</td>';
                                echo '<td>' . $row['customer'] . '</td>';
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>