<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Items</title>
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/icheck/skins/all.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.mr-2').click(function(){
            var receipt = $('.rec').val();
            $('.cal').val(receipt);
            if(receipt === ""){
                alert("Cannot be empty");
            }else{
                $.post('getreturns.php',{receipt:receipt,},function(data){
                    $('.res').html(data);
                });
                $('.cal').val(receipt);
            }
        });
        
        $('.cal').click(function(){
            var b = $(this).val();
            $.post('processreturn.php',{b:b,},function(data){
                $('.res').html(data); 
            })
        });
    });
    </script>
</head>
<body>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">ACCEPT SALE RETURNS</h4>
                            <div class="forms-sample" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                <label for="exampleInputName1">Enter Receipt Number</label>
                                <input type="text" class="form-control rec" id="exampleInputName1" name ="suppliername" placeholder="RECEIPT N0#" required>
                                </div>
                                <button class="btn btn-success mr-2">Query</button>
                                <span class="res"></span>
                                <button class="btn btn-primary cal">Click here to cancel the sale</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>