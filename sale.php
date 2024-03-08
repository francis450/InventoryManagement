<?php
				session_start();
				$userid = $_SESSION['username'];
				if(!isset($_SESSION['username'])){
					header("Location: index.php");
				}
				// echo $userid;
				
						$cartid= $_GET['id'];
				include('connection.php');
						if(isset($_POST['toa'])){
											$rowData = [];
                                            $subtotal = 0;
                                            $dated;
                                            $transtype;
                                            $amount;
                                            $balance;
                                            $cashier;
                                            $total=0;
                                            $tax = 0;
                                            $qq = "SELECT * FROM cart where salesid = '$cartid'";
                                            if($cartq = mysqli_query($con, $qq)){
                                                    while($cart = mysqli_fetch_array($cartq)){
                                                        $rowData[] = [
                                                             'item' => $cart['product'],
                                                             'qty' => $cart['qnty'],
                                                             'price' => number_format($cart['price'],2),
                                                             'total' => number_format($cart['total'],2)
                                                        ];
                                                        // $total += $cart['total'];
                                                        $dated = $cart['dated'];
                                                        
                                                    }
                                                    
                                                    $receipts = mysqli_query($con, "SELECT * FROM receipts where cartid = '$cartid'");
                                                    $thisreceipt = mysqli_fetch_array($receipts);
                                                    $transtype = $thisreceipt['transactiontype'];
                                                    $amount = $thisreceipt['amountgiven'];
                                                    $balance = $thisreceipt['balance'];
                                                    $cashier = $thisreceipt['cashier'];
                                                    $total = $thisreceipt['payable'];
                                                    if($cart['tax']){
                                                            $tax += (0.16*$total);
                                                    }
                                                    $subtotal = $total - $tax;
                                                    
                                            }else{
                                                echo mysqli_error($con);
                                            }
											echo '<div class="card" style="    display: flex;flex-direction: row;justify-content: space-evenly;margin-bottom: 20px;" >';
											echo '<p>';
    											echo '<a onClick="make()">';
    											echo '<img src="assets/images/pic.jpg"  width="150px" height="50"/>';
    											echo '</a>';
											echo '</p>';
											echo '<p id="printButton""';
    											echo '<a onClick="make()">';
    											echo '<img src="assets/images/A4.png" width="150px" height="50"/>';
    											echo '</a>';
											echo '</p>';
											echo '<script>window.parent.opener.location.reload();</script>';
											echo '</div>';								
								// 			echo 'X-Response-Time: ' . (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . ' seconds';
											
										}else{
											$msgg = mysqli_error($con);
											echo $msgg;
										}
									
									?>
									
		<html>
		<head>
			<link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
		<link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
		<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
		<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
  <script src='pdfmake/build/pdfmake.min.js'></script>
  <script src='pdfmake/build/vfs_fonts.js'></script>
  <script src='jsbarcode/dist/JsBarcode.all.min.js'></script>
		<!-- endinject -->
		<!-- plugin css for this page -->
		<!-- End plugin css for this page -->
		<!-- inject:css -->
		<link rel="stylesheet" href="assets/css/shared/style.css">
		<!-- endinject -->
		<!-- Layout styles -->
		<link rel="stylesheet" href="assets/css/demo_1/style.css">
		<!-- End Layout styles -->
		<link rel="shortcut icon" href="assets/images/favicon.ico" />
		<script src="jquery-3.3.1.min.js"></script>
		<script src="jquery.dataTables.min.js"></script>
		<!--<script src="Print.js/src/js/print.js"></script>-->
		<script>
          
          function make(){
              function generateBarcodeDataUrl(value) {
                  var canvas = document.createElement('canvas');
                  JsBarcode(canvas, value);
                  return canvas.toDataURL(); // Convert canvas to data URL
              }
              var barcodeDataUrl = generateBarcodeDataUrl(<?php echo $cartid;?>);
              var rowData = <?php echo json_encode($rowData); ?>;
              var dd = {
                pageMargins: [3, 3, 3, 3],
                pageSize: {
                  width: 210,
                  height: 'auto'
                },
            
            	content: [
            	    {image:'data:image/png;base64,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',alignment: 'center',margin: [0, 5, 0, 0] , width:100},
            		{text: 'GITHUNGURI TOWN, UTAWALA', style: 'header',lineHeight: 2},
            		{text: "Tel No : 0700-893204", alignment: 'center', fontSize: 8},
            		{text: "ORIGINAL RECEIPT", alignment: 'center', fontSize: 8,lineHeight: 1},
                    {canvas: [
                        {
                          type: 'line',
                          x1: 0, y1: 5,
                          x2: 190, y2: 5,
                          lineWidth: 1,
                          lineColor: 'black'
                        },
                    ]   
                    },
            		{text: "Till No. 5151469 ", alignment: 'center', fontSize: 8,lineHeight: 1},
            		{
            		    columns:[
            		        {text: "Date: <?php echo $dated; ?>", alignment: 'Right', fontSize: 7},
            		        {text: "Receipt No. <?php echo $cartid;?>", alignment: 'Left', fontSize: 7},
            		    ],
            		},
            		{canvas: [
                        {
                          type: 'line',
                          x1: 0, y1: 5,
                          x2: 190, y2: 5,
                          lineWidth: 1,
                          lineColor: 'black'
                        },
                     ]   
                    },
                    {
                        table: {
                            widths: [7, 70, 'auto', 'auto','auto'],
                            headerRows: 1,
                            body: [
                              // Header row with bottom borders
                              [{text: '#',fontSize: 8},{ text: 'Item',fontSize: 8}, { text: 'Qty', style: 'headerCell' ,fontSize: 8}, { text: 'Price', style: 'headerCell',fontSize: 8 },{text:'Total',fontSize: 8}],
                              ...rowData.map((row, index) => [
                                  { text: (index + 1).toString() + ".", fontSize: 8 },
                                  { text: row.item, fontSize: 8 },
                                  { text: row.qty, fontSize: 8 },
                                  { text: row.price, fontSize: 8 },
                                  { text: row.total, fontSize: 8 }
                                ])
                            ]
                    },
                        layout: {
                            hLineWidth: function(i, node) {
                              if (i === 0) {
                                return 1; 
                              }
                              return 0; 
                            },
                            vLineWidth: function(i, node) {
                              return 0; 
                            },
                    },
                    },
                    {
                        columns: [
                          {text:'SubTotal', fontSize: 8},
                          { text: 'Kshs. <?php echo number_format($subtotal); ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {
                        columns: [
                          {text:'Total Tax', fontSize: 8},
                          { text: 'Kshs. <?php echo $tax ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {
                        columns: [
                          {text:'Total', fontSize: 8},
                          { text: 'Kshs. <?php echo number_format($total); ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {canvas: [
                        {
                          type: 'line',
                          x1: 0, y1: 5,
                          x2: 190, y2: 5,
                          lineWidth: 1,
                          lineColor: 'black'
                        },
                     ]   
                    },
                    {text: "PAYMENT DETAILS", alignment: 'center', fontSize: 9},
                    {canvas: [
                        {
                          type: 'line',
                          x1: 0, y1: 0,
                          x2: 190, y2: 0,
                          lineWidth: 1,
                          lineColor: 'black'
                        },
                     ]   
                    },
                    {
                        columns: [
                          {text:'<?php echo $transtype; ?>', fontSize: 8, lineHeight: 1},
                          { text: 'Kshs. <?php echo number_format($amount,2); ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {
                        columns: [
                          {text:'Balance', fontSize: 8},
                          { text: 'Kshs. <?php echo number_format($balance,2); ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {
                        columns: [
                          {text:'You Were Served By', fontSize: 8},
                          { text: '<?php echo $cashier; ?>', width:53, alignment: 'left', fontSize: 8}
                        ],
                        
                    },
                    {
                    image : barcodeDataUrl,
                    width: 100,
                    height: 50,
                    alignment: 'center'
                    },
                    {text:"Thank You For Shopping With Us.", fontSize: 8, alignment:"center"},
                    {text:"System Powered By Bigbro(www.bigbro.co.ke)", fontSize: 6, alignment:"center"}
            	],
            	styles: {
            		header: {
            			fontSize: 10,
            			bold: true,
            			margin: [0, 0, 0, 0],
            			alignment: 'center'
            		}
            	},
            }
            pdfMake.createPdf(dd).print();
            setTimeout(function() {
                window.top.close();
            }, 2000);
            
          }
          
        </script>

		<script>
		
			$(document).ready(function(){
			 //   $('.print').hide();
					$('.sellbtn').hide();
					$('.getmpesapayment').hide();
			$('.selectbtn').change(function(){
				$('.sellbtn').show(); 
				
				if($(this).val()=="---"){$('.sellbtn').hide();}
			});
			$('#unitcost').keyup(function(){
				var thisunitcost = $(this).val();
				var thisitemunit = $("#itemunit").val();
				var thistotalunitcost = thisunitcost*thisitemunit;
				$("#totalunitcost").val(thistotalunitcost);
			
				var thissubunits = ($("#subunits").val())*thisitemunit;
				$("#subunitcost").val(thistotalunitcost/thissubunits);
				});


			$('#paid').keyup(function(){
				var thispaid = $(this).val();
				var thistotalunitcost2 = $("#totalunitcost").val();
				var ball = thispaid  - thistotalunitcost2;
				$("#balance").val(ball);
			});

		
			$(".editbtn").click(function(){
			
				var thisbrand = $(this).closest('tr').children('td.brandname').text();
				var s = prompt("Enter new Retail Price");
				$(this).closest('tr').children('td.spr').text(s)
				var w = prompt("Enter new Wholesale Price");
				$(this).closest('tr').children('td.spw').text(w);
					

			});
			
			$(".editcommit").click(function(){
			
				var editbrand = $(this).closest('tr').children('td.brandname').text();
				
				var editspr= $(this).closest('tr').children('td.spr').text()
				
				var editspw = $(this).closest('tr').children('td.spw').text();
				
				$.post('editprices.php',{editbrand:editbrand,editspr:editspr,editspw:editspw,},function(data){
					$(this).html(data);
					console.log(data);
				});
					

			});
			
			
			
			<!--$(".bei").change(function(){ var thisprice = $(this).val();$(this).closest('tr').children('td.beii').val(thisprice);});
			-->
			$(".ngapi").change(function(){
			
			var thisprice = $(this).closest('tr').children('td.beii').text();
			
			var thismuch = $(this).val();
			
			
			var thistotal = parseInt(thisprice) * parseInt(thismuch);
			
			$(this).closest('tr').children('td.sote').text(thistotal);
				$(this).closest('tr').children('td.addtocart').trigger("click");	

			});
			
			
			$(".addtocart").click(function(){
				
			
				var brandtocart = $(this).closest('tr').children('td.brandname').text();
				
				var pricetocart = $(this).closest('tr').children('td.beii').text();
				
				var qntytocart = $(this).closest('tr').children('td').find('select.ngapi').val();
				var totaltocart = $(this).closest('tr').children('td.sote').text();
				var cartid = "<?php echo $cartid ;?>";
				
				$.post('addtotempcart.php',{brandtocart:brandtocart,pricetocart:pricetocart,qntytocart:qntytocart,totaltocart:totaltocart,cartid :cartid,},function(data){
					
					$(".cartcallback").html(data);
					$.post('gettotalprice.php',{cartid :cartid,},function(data2){
					$(".gu").text(data2);    
					console.log(data2);
					$(".gottotalprice").val(data2);
					
				});
				});
				
				
					

			});
			
			
			
			$(".amountgiven").keyup(function(){
				$('.sellbtn').hide();
				var receivedmoney = $(this).val();
				var jumla = $(".gottotalprice").val();
				var disc = $(".discount").val()||0;
				
				
				var baki = parseInt(receivedmoney )- parseInt(jumla) + parseInt(disc);
				$(".bakii").val(baki);
				
				
				
				if(disc==0){
					$(".discount").val(0)
				}
				
			});
			
			
			
			
			
			
			$(".cartcallback").on('click','.removebtn',function(){
				var braxton = $(this).val();
				var cartid = "<?php echo $cartid?>";
				var boy = "<?php echo $cartid?>";
				$.post('removefromcart.php',{braxton:braxton,boy:boy,},function(data){
					$(".cartcallback").html(data);
					$.post('gettotalprice.php',{cartid :cartid,},function(data2){
					console.log(data2);
					$(".gottotalprice").val(data2);
				});
				});
			
			});
			


			
			function printthis(){
				$(this).trigger("click");
				
				}
			
			$('.addcustomer').click(function(){
				var cname = prompt("Enter customer name");
				var cphone = prompt("Enter customer phone number");
				if(cname !== null && cname !== '' && cphone !== null && cphone !== ''){
				var liz = confirm("Do you want to add "+cname+','+cphone+ ' as a customer?');
				if(liz){
					$.post('addcustomer.php',{cname:cname,cphone:cphone,},function(data){$('.customer').html(data);})
				}else{
					alert("Bye");
				}
				}else{
					alert("Data Cant be empty");
				}
			});
			
	});
			

			
		</script>
		</head>
		<body style="font-weight: 800;font-family: inherit;">
			<!--<iframe id="pdfFrame" style="display:none;" src="<?php echo 'writeAReceipt?cartid=$cartid'; ?>"></iframe>-->
			<?php
			$ian =mysqli_query($con,"SELECT SUM(total) as totalpayable from tempcart where salesid='$cartid'");
			$rowian = mysqli_fetch_array($ian);
			$totalpayablef = $rowian['totalpayable'];
			$dc = $totalpayablef * 0.25;
			
			?>
			<!--<h1>Payable  Ksh: <?php echo number_format($totalpayablef,2); ?></h1>-->
			<div class="col-12 grid-margin">
					<div class="card">
					<div class="card-body">
						<!--<h4 class="card-title">Add Brands</h4>-->
																<script>
																	$(document).ready(function() {
																		var payable = $('#payable').val();
																	
																$('.cashbtn').click(function() {
																			var amtgiven = prompt("Enter Amount Given");
																			if (amtgiven !== null && amtgiven !== '') {
																				$('#amountgiven').val(amtgiven);
																				$('#transtype').val("CASH"); // Fixed the selector and removed the $
																				$('.bakii').val(amtgiven - payable);
																				if($('.bakii').val() >= 0 && payable > 0){
																				    $('.sellbtn').show();
																				}else{
																				    $('.sellbtn').hide();
																				}
																			} else {
																				alert("Amount Cannot Be Empty");
																			}
																		});

																		$('.mpesabtn').click(function() {
																			var amtgiven = prompt("Enter Amount Given");
																			if (amtgiven !== null && amtgiven !== '') {
																				$('#amountgiven').val(amtgiven);
																				$('#transtype').val("MPESA"); // Fixed the selector and removed the $
																				$('.bakii').val(amtgiven - payable);
																				if($('.bakii').val() >= 0 && payable > 0){
																				    $('.sellbtn').show();
																				}else{
																				    $('.sellbtn').hide();
																				}
																			} else {
																				alert("Amount Cannot Be Empty");
																			}
																		});

																		$('.bankbtn').click(function() {
																			var amtgiven = prompt("Enter Amount Given");
																			if (amtgiven !== null && amtgiven !== '') {
																				$('#amountgiven').val(amtgiven);
																				$('#transtype').val("BANK"); // Fixed the selector and removed the $
																				$('.bakii').val(amtgiven - payable);
																				if($('.bakii').val() >= 0 && payable > 0){
																				    $('.sellbtn').show();
																				}else{
																				    $('.sellbtn').hide();
																				}
																			} else {
																				alert("Amount Cannot Be Empty");
																			}
																		});

																		$('.creditbtn').click(function() {
																			var cashamt = prompt("Enter Amount Paid in Cash (If Any)");
																			var mpesamt = prompt("Enter Amount Paid in Mpesa (If Any)");
																			var bankamt = prompt("Enter Amount Paid in Bank (If Any)");
																			
																			// Convert string amounts to integers
																			cashamt = cashamt !== '' ? parseInt(cashamt) : 0;
																			mpesamt = mpesamt !== '' ? parseInt(mpesamt) : 0;
																			bankamt = bankamt !== '' ? parseInt(bankamt) : 0;
																			
																			var totalAmount = cashamt + mpesamt + bankamt;
																			
																			if (cashamt !== 0 && mpesamt !== 0 && bankamt !== 0) {
																				$('#transtype').val('Cash');
																				$('#transtype1').val('Mpesa');
																				$('#transtype2').val('Bank');
																				$('#amt1given').val(mpesamt);
																				$('#amt2given').val(bankamt);
																				$('#amt3given').val(cashamt);
																			} else if (cashamt !== 0 && mpesamt !== 0) {
																				$('#transtype').val('cash');
																				$('#transtype1').val('mpesa');
																				$('#amt1given').val(mpesamt);
																				$('#amt2given').val(bankamt);
																			} else if (cashamt !== 0 && bankamt !== 0) {
																				$('#transtype').val('cash');
																				$('#transtype1').val('bank');
																				$('#amt2given').val(bankamt);
																				$('#amt3given').val(cashamt);
																			} else if (mpesamt !== 0 && bankamt !== 0) {
																				$('#transtype').val('mpesa');
																				$('#transtype1').val('bank');
																				$('#amt2given').val(bankamt);
																				$('#amt3given').val(mpesamt);
																			}
																		$('#amountgiven').val(totalAmount);
																		var amt = $('#amountgiven').val();
																		
																		$('.bakii').val((cashamt+mpesamt+bankamt) - payable);
																		
																		    $('.sellbtn').show();
																		
																	});
																	$('.sellbtn').click(function() {
																		var payableValue = $('#payable').val();
																		var amount1GivenValue = $('#amt1given').val();
																		var amount2GivenValue = $('#amt2given').val();
																		var amount3GivenValue = $('#amt3given').val();
																		var amountGivenValue = $('#amountgiven').val();
																		var balanceValue = $('#bakii').val();
																		var transactionTypeValue = $('#transtype').val();
																		var transactionType1Value = $('#transtype1').val();
																		var transactionType2Value = $('#transtype2').val();
																		var discountValue = $('#discount').val();
																		var transactionDescValue = $('#transdesc').val();
																		var customer  = $('#customer').val();
																		var cartid = <?php echo $cartid; ?>;
																		
																		$.post('savereceipt.php',
																		{
																		    cartid:cartid,
																			payable:payableValue,
																			amount1GivenValue:amount1GivenValue,
																			amount2GivenValue:amount2GivenValue,
																			amount3GivenValue:amount3GivenValue,
																			amountGivenValue:amountGivenValue,
																			balanceValue:balanceValue,
																			transactionTypeValue:transactionTypeValue,
																			transactionType1Value:transactionType1Value,
																			transactionType2Value:transactionType2Value,
																			discountValue:discountValue,
																			transactionDescValue:transactionDescValue,
																			customer:customer,
																		},
																		function(data){
																		        if(data = true){
    																		        var toa = true;
    																		        $.post('',{toa:toa},function(res){
    																		            document.open();
    																			        document.write(res);
    																			        $.post('salehandler.php'
    																			        ,{
    																			            cartid:cartid,
                																			payable:payableValue,
                																			amount1GivenValue:amount1GivenValue,
                																			amount2GivenValue:amount2GivenValue,
                																			amount3GivenValue:amount3GivenValue,
                																			amountGivenValue:amountGivenValue,
                																			balanceValue:balanceValue,
                																			transactionTypeValue:transactionTypeValue,
                																			transactionType1Value:transactionType1Value,
                																			transactionType2Value:transactionType2Value,
                																			discountValue:discountValue,
                																			transactionDescValue:transactionDescValue,
                																			customer:customer,
    																			        }
    																			        ,function(data){
    																			            
    																			        }
    																			        )
    																		        });
																		        }
																		})
																	});

																});
																</script>
															<div class="container">
																		<div class="row" style="justify-content:center">
																			<div class="form-group" style="display:flex;gap:20px">
																				<button class="btn btn-lg btn-success cashbtn">Cash</button>
																				<button class="btn btn-lg btn-info mpesabtn">M-PESA</button>
																				<button class="btn btn-lg btn-warning bankbtn">Bank</button>
																				<button class="btn btn-lg btn-secondary creditbtn">Other</button>
																				<select style="width:100px" class="form-control customer" id="customer" name="customer" required>
																					<option>Customer</option>
																					<?php
    																					$sunday = mysqli_query($con,"select * from customers");
    																					while($customerrow=mysqli_fetch_array($sunday )){
    																						echo '<option>'.$customerrow['code'].'</option>';
    																					}
																					?>
																				</select>
																				<div><span style="cursor:pointer"class="addcustomer">+</span></div>
																			</div>
																		</div>
																		<div class="form-row">
																			<div class="form-group col-md-4">	
																				<label for="payable">Payable</label>
																				<input type="text" class="form-control gottotalprice" id="payable" name="cashpayable" value="<?php echo $totalpayablef; ?>" readonly required/>
																			</div>
																			<div class="form-group col-md-4">
																				<input type="hidden" name="amt1given" id="amt1given">
																				<input type="hidden" name="amt2given" id="amt2given">
																				<input type="hidden" name="amt3given" id="amt3given">
																				<label class="amountgiventext" for="amountgiven">Amount Paid</label>
																				<input type="number" class="form-control amountgiven" id="amountgiven" readonly name="cashgiven" required/>
																			</div>
																			<div class="form-group col-md-4">
																				<label for="bakii">Balance</label>
																				<input type="text" class="form-control bakii" id="bakii" name="cashbalance" readonly required/>
																			</div>
																			
																		</div>
																		
																		<div class="form-row">																						
																			
																			<div class="form-group col-md-4">
																				<label for="transtype">Transaction type</label>
																				<input type="hidden" name="transtype1" id="transtype1">
																				<input type="hidden"  name = "transtype2" id="transtype2">
																				<input  class="form-control transtype selectbtn" readonly id="transtype" readon name="transtype"/>
																			</div>
																		
																			<div class="form-group col-md-4">
																				<label for="discount">Discount</label>
																				<input type="number" class="form-control discount" id="discount" name="discount" min="0" max="<?php echo $dc;?>" placeholder="Max Discount <?php echo $dc;?> allowed" required/>
																			</div>
																			<div class="form-group col-md-4">
																				<label for="transdesc"><span class="tran">Transaction description</span></label>
																				<input type="text" class="form-control transdesc" id="transdesc" name="transdesc"/>
																			</div>
																		
																		</div>
																		
																		
																		<div class="form-row">
																			<!-- <div class="form-group col-md-4">
																				<label for="customer">Customer&nbsp&nbsp<span style="cursor:pointer"class="addcustomer">+</span></label>
																				<select class="form-control customer" id="customer" name="customer" required>
																					<option>Walk in</option>
																					<?php
																					$sunday = mysqli_query($con,"select * from customers");
																					while($customerrow=mysqli_fetch_array($sunday )){
																						echo '<option>'.$customerrow['code'].'</option>';
																					}
																					?>
																				</select>
																				
																			</div> -->
																			<div class="form-group col-md-4" style="display: flex;align-items: end;">
																				<button type="submit" class="btn btn-lg btn-warning sellbtn" >Sell</button>
																			</div>
																			<div class="form-group col-md-4" style="display: flex; align-items: end">
																			    
																			    
																			</div>
																		</div>
																		
																
																</div> 
																</div>
																<div class="classy"></div>
					</div>
				</div>
		</body>
	</html>
																		