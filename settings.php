<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&amp;display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  <link rel="stylesheet" href="assets/css/settings.css" />
  <title>Settings</title>
</head>
<style>
    .scrollable-content {
      max-height: 100vh; /* Adjust the max-height as needed */
      overflow-y: auto;
    }
    .scrollable-content::-webkit-scrollbar {
      width: 0; /* Hide Chrome/WebKit scrollbar */
    }
    /* CSS for the loading overlay */
    .loading-overlay {
      position: absolute;
      top: 50vh;
      left: 50vw;
      width: 100vw;
      height: 100vh;
      background: rgba(255, 255, 255, 0.7);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    .loader {
      border: 6px solid #f3f3f3;
      border-top: 6px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>
<body>
  <div class="app-container d-flex flex-row w-100 mw-100 h-100 mh-100">
    <!--<div class="sidebar">-->
    <!--  <div class="sidebar-icon-container">-->
        
    <!--  </div>-->
    <!--</div>-->
    <div class="main d-flex flex-grow-1 flex-column overflow-hidden">
      <div class="top-nav flex-grow-1">
        <div class="flex-grow-1">
          <div id="navbar">
            <nav class="navbar p-0 navbar-expand-lg" id="navbar2">
              <div id="breadcrumbs-collapse" class="border-top border-bottom navbar-collapse collapse" style="display: none"></div>
            </nav>
          </div>
          <style lang="scss" scoped="">
            .separator {
              border-right: 1px solid rgb(227, 231, 236);
              height: 30px;
              margin-left: 0.5rem;
              margin-right: 1rem;
            }
          </style>
        </div>
      </div>

      <div class="flex-grow-1 d-flex flex-column overflow-hidden h-100" id="mainbody">
        <div id="main" class="main flex-grow-1 h-100 overflow-auto py-3">
          <div id="editCss" class="container-fluid px-3">
            <div role="document" class="row d-flex justify-content-center">
              <div class="col-11">
                <div class="card border-top-0 primary-container">
                  <div class="card-body p-3 border-top-0">
                    <div>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-2 sidebar-col collapse show d-md-flex pl-0" id="sidebar">
                            <nav class="nav flex-column flex-nowrap overflow-hidden">
                              <div class="nav" id="nav-tab" role="tablist">
                                
                                <a class="nav-item nav-link nav-link-upper" id="scripts-tab" href="main.php" role="tab" aria-selected="false">
                                  <i class=" fa nav-icon fa-arrow-left">&nbsp DASHBOARD</i>
                                </a>
                                <a class="nav-item nav-link nav-link-upper active font-bolder" id="scripts-tab" data-toggle="tab" href="#docusign-pane" role="tab" aria-controls="nav-contact" aria-selected="false">
                                  General</a>
                                <a class="nav-item nav-link nav-link-upper" id="scripts-tab" data-toggle="tab" href="#ldap-pane" role="tab" aria-controls="nav-contact" aria-selected="false">
                                  <b>Receipt</b></a>
                                  <a class="nav-item nav-link nav-link-upper" id="scripts-tab" data-toggle="tab" href="#cashiers-pane" role="tab" aria-controls="nav-contact" aria-selected="false">
                                  <b>Cashiers</b></a>
                                <a class="nav-item nav-link nav-link-upper" id="scripts-tab" data-toggle="tab" href="#generic-pane" role="tab" aria-controls="nav-contact" aria-selected="false">
                                  <b>System</b></a>
                              </div>
                            </nav>
                          </div>
                          <div class="col-9">
                            <div class="scrollable-content">
                                <div class="export-header ml-2">
                                  <h2>
                                    <span id="page-title" class="font-weight-normal">Receipt Settings</span>
                                  </h2>
                                  <span class="text-secondary" style="display:flex;justify-content:space-between;">
                                      <!--Add/Edit information to be displayed on the receipt.-->
                                      <!--<a class="" href="writeAReceipt.php" target="_blank"><i class="fas fa-external-link-alt"></i>-->
                                      <!--    View Receipt Outline-->
                                      <!--  </a>-->
                                  </span>
                                  <hr class="ml-2" />
                                </div>
    
                                <div class="tab-content" id="nav-tabContent">
                                  <!-- //NEW TAB -->
                                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="col pt2">
                                      <h3 class="font-weight-normal">Tasks</h3>
                                    </div>
                                  </div>
                                    
                                  <!-- //NEW TAB -->
                                  <div class="tab-pane fade active show" id="docusign-pane" role="tabpanel" aria-labelledby="nav-contact-tab">
                                      <div class="text-secondary mb-4">
                                        Edit Shop Details Below.
                                      </div>
                                    <form class="settings-group pl-3 pr-3" id='shop-details' action="editShop.php" method="post">
                                        <!--GET SHOP DETAILS-->
                                        <?php
                                            $details = mysqli_query($con, "SELECT * FROM shop");
                                            $shop = mysqli_fetch_assoc($details);
                                        ?>
                                      <div class="form">
                                        <div class="form-group">
                                          <label for="" class="font-bold">SHOP NAME</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" aria-describedby="" placeholder="" name = "shopName" value='<?php echo $shop['name'] ?>' />
                                          </span>
    
                                          <small class="form-text text-muted">Enter Desired Shop Name.</small>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-bold" for="">KRA PIN</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" name="kraPin" aria-describedby="" placeholder="" value='<?php echo $shop['pin'] ?>'/>
                                          </span>
    
                                          <small class="form-text text-muted">Enter/Edit The Mart's KRA PIN</small>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-bold" for="">PHONE</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" name="phone" aria-describedby="" placeholder="" value='<?php echo $shop['phone']; ?>'/>
                                          </span>
    
                                          <small class="form-text text-muted">Enter/Edit The Mart's Service Phone</small>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-bold" for="">LOCATION</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" name="location" aria-describedby="" placeholder="" value='<?php echo $shop['location']; ?>'/>
                                          </span>
    
                                          <small class="form-text text-muted">Where Is The Shop Located</small>
                                        </div>
                                        <div class="form-group">
                                          <label class="font-bold" for="">MPESA TILL NUMBER</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" name="till" aria-describedby="" placeholder="" value='<?php echo $shop['till'] ?>'/>
                                          </span>
    
                                          <small class="form-text text-muted">Enter Mart's Common Buy Goods & Services Till Number</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-bold" for="">LOGO</label>
                                            <div class="upload-container">
                                              <div class="form-group">
                                                <div class="input-group upload-group dotted d-flex justify-content-center">
                                                  <div class="inner d-flex flex-column justify-content-center text-center m-3">
                                                    <i class="fas fa-file-upload modal-upload-icon-small mb-2 mt-2"></i>
                                                    <span>Drag file here</span>
                                                    <span class="">- or -</span>
                                                    <!-- <button class="btn btn-info">Select file</button> -->
                                                    <span>
                                                      <input type="file" class="btn" name = "logo"></input>
                                                    </span>
                                                  </div>
                                                </div>
                                                <small class="form-text text-muted">Upload An Image That Should Appear As Your Logo And Possibly Receipt Logo</small>
                                              </div>
                                            </div>
                                          </div>
                                        <div class="form-group">
                                          <label class="font-bold" for="">SLOGAN</label>
                                          <span class="d-flex flex-row">
                                            <input type="text" class="form-control" name="slogan" aria-describedby="" placeholder="" value='<?php echo $shop['slogan'] ?>'/>
                                          </span>
    
                                          <small class="form-text text-muted">Enter The Footer Note For The Mart's Receipt</small>
                                        </div>
                                      </div>
                                      <div class="settings-control-container d-flex flex-row-reverse">
                                        <button type="submit" class="btn btn-primary" id="submit-button">
                                          SAVE CHANGES
                                        </button>
                                      </div>
                                    </form>
                                  </div>
                                  <!-- //TAB PANE END -->
                                  
                                  <!--NEW TAB-->
                                  <div class="tab-pane fade" id="cashiers-pane" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="text-secondary mb-4">
                                            Set Everything About Cashiers
                                        </div>
                                        <div class="settings-group pl-3 pr-3">
                                            <div class="mt-4 header-container">
                                              <h5>General</h5>
                                              <hr />
                                            </div>
                                            <div>
                                                <!--Closing Time-->
                                                <div class="form-group">
                                                  <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                                    <div class="d-flex flex-column col-6">
                                                      <span class="mt-2">Close Time</span>
                                                      <small class="text-secondary mt-1">select the time cashier's should enter the closing amount.</small>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse col-1">
                                                      <div class="form-group mt-3">
                                                        <input type="time" class="form-control customInput" name="closeTime" id="closeTime" value='<?php echo $shop['closeTime']; ?>'/>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!--Closing Time-->
                                                <div class="settings-control-container d-flex flex-row-reverse" >
                                                    <button class="btn btn-primary closeTime">
                                                      SAVE
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4 header-container">
                                              <h5>Permissions</h5>
                                              <hr />
                                            </div>
                                            <div>
                                                <!--Return Items-->
                                                <div class="form-group">
                                                  <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                                    <div class="d-flex flex-column col-6">
                                                      <span class="mt-2">Return Items</span>
                                                      <small class="text-secondary mt-1"> Enable To Allow Cashier's To Process Returned Items and Issue Refunds</small>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse col-1">
                                                      <div class="custom-control custom-switch mt-3">
                                                        <input type="checkbox" class="custom-control-input customInput" name="showReturn" id="showReturn" <?php if($shop['showReturn']){echo 'checked';} ?>/>
                                                        <label class="custom-control-label visible-label pl-1 font-bold" for="showReturn">
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!--Return Items-->
                                                
                                                <!--DISCOUNTING-->
                                                <div class="form-group">
                                                  <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                                    <div class="d-flex flex-column col-6">
                                                      <span class="mt-2">Discount</span>
                                                      <small class="text-secondary mt-1"> Check the box to enable product discounts by cashiers</small>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse col-1">
                                                      <div class="custom-control custom-switch mt-3">
                                                        <input type="checkbox" class="custom-control-input customInput" name="showdiscount" id="showdiscount" <?php if($shop['showdiscount']){echo 'checked';} ?> />
                                                        <label class="custom-control-label visible-label pl-1 font-bold" for="showdiscount">
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                                <!--DISCOUNTING-->
                                                
                                                <!--View Receipts-->
                                                <div class="form-group">
                                                  <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                                    <div class="d-flex flex-column col-6">
                                                      <span class="mt-2">View Receipts</span>
                                                      <small class="text-secondary mt-1"> Check the box to enable cashiers to view receipts</small>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse col-1">
                                                      <div class="custom-control custom-switch mt-3">
                                                        <input type="checkbox" class="custom-control-input customInput" name="showreceipts" id="showreceipts" <?php if($shop['showreceipts']){echo 'checked';} ?> />
                                                        <label class="custom-control-label visible-label pl-1 font-bold" for="showreceipts">
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                                <!--View Receipts-->
                                                
                                                <!--View Receipts-->
                                                <div class="form-group">
                                                  <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                                    <div class="d-flex flex-column col-6">
                                                      <span class="mt-2">View Overview</span>
                                                      <small class="text-secondary mt-1"> Check the box to enable cashiers to view all stock in the system</small>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse col-1">
                                                      <div class="custom-control custom-switch mt-3">
                                                        <input type="checkbox" class="custom-control-input customInput" name="showOverview" id="showOverview" <?php if($shop['showOverview']){echo 'checked';} ?> />
                                                        <label class="custom-control-label visible-label pl-1 font-bold" for="showOverview">
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                                <!--View Receipts-->
                                                
                                                <div class="settings-control-container d-flex flex-row-reverse" >
                                                    <button class="btn btn-primary permissions">
                                                      SAVE
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                  </div>
                                  <!--TAB PANE END-->
                                  
                                  <!-- //NEW TAB -->
                                  <div class="tab-pane fade" id="ldap-pane" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="menu-header pt-1 pl-2">
                                      <div class="text-secondary mb-4">
                                        Edit Receipt Options/Details Below.
                                      </div>
                                    </div>
                                    <div class="settings-group pl-2 pr-3 ">
                                      <div class="form">
                                        <div class="mt-4 header-container">
                                          <h5>Receipt Heading Settings</h5>
                                          <hr />
                                        </div>
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Company Logo</span>
                                              <small class="text-secondary mt-1"> Enable To 
                                                Display Of The Company Logo On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showLogo" id="includeLogo" <?php if($shop['showLogo']){echo 'checked';} ?>/>
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includeLogo">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Shop's KRA PIN</span>
                                              <small class="text-secondary mt-1"> Click To Display The Shop's KRA PIN On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showPin" id="includePin" <?php if($shop['showPin']){echo 'checked';} ?> />
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includePin">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Till Number</span>
                                              <small class="text-secondary mt-1"> Enable To Display The Till Number On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showTill" id="includeTill" <?php if($shop['showTill']){echo 'checked';} ?>/>
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includeTill">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Phone Number</span>
                                              <small class="text-secondary mt-1"> Enable To Display The Shop's Phone Number On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showPhone" id="includePhone" <?php if($shop['showPhone']){echo 'checked';} ?> />
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includePhone">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Shop Location</span>
                                              <small class="text-secondary mt-1"> Click To Display The Shop's Location On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showLocation" id="includeLocation" <?php if($shop['showLocation']){echo 'checked';} ?> />
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includeLocation">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div> 
                                        
                                         
    
                                        <div class="mt-4 header-container">
                                          <h5>Receipt Body Settings </h5>
                                          <hr />
                                        </div>
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Display Cashier Name</span>
                                              <small class="text-secondary mt-1"> Enable To Display The Active Cashier's Name On The Sales Receipt</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="showCashier" id="includeCashier" <?php if($shop['showcashier']){echo 'checked';} ?>/>
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="includeCashier">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="settings-control-container d-flex flex-row-reverse" >
                                        <button type="submit" class="btn btn-primary receipt">
                                          SAVE SETTINGS
                                        </button>
                                      </div>
                                    </div>
                                    <!-- card end -->
                                  </div>
                                  <!-- //TAB PANE END -->
                                  
                                  <!-- //NEW TAB -->
                                  <div class="tab-pane fade" id="generic-pane" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="menu-header pt-1 pl-2">
                                      <div class="text-secondary mb-4">
                                        Edit Other Options/Details Below.
                                      </div>
                                    </div>
                                    <form class="settings-group pl-2 pr-3">
                                      <div class="generic-form">
                                        <div class="mt-4 header-container">
                                          <h5>Generic Settings</h5>
                                          <hr />
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Sub-Zero Selling</span>
                                              <small class="text-secondary mt-1">Items Will Sell Even After They Are Out of Stock In The System</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <input type="checkbox" class="custom-control-input customInput" name="subzero" id="subzero" <?php if($shop['subzero']){echo 'checked';} ?> />
                                                <label class="custom-control-label visible-label pl-1 font-bold" for="subzero">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <div class="mt-4 header-container">
                                          <h5>Backup Settings</h5>
                                          <hr />
                                        </div>
                                        
                                        <div class="form-group">
                                          <div class="d-flex mb-2 mt-1" style="justify-content: space-between;">
                                            <div class="d-flex flex-column col-6">
                                              <span class="mt-2">Back-Up Frequency</span>
                                              <small class="text-secondary mt-1">Choose How Frequent The DataBase Is Backed</small>
                                            </div>
                                            <div class="d-flex flex-row-reverse col-1">
                                              <div class="custom-control custom-switch mt-3">
                                                <select id="backupFrequency" name="backupFrequency">
                                                    <option value="continuous">Continuous</option>
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="bi-weekly">Bi-Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="settings-control-container d-flex flex-row-reverse">
                                            <button type="submit" class="btn btn-primary save-system">
                                              SAVE CHANGES
                                            </button>
                                          </div>
                                        <div class="mt-4 header-container">
                                          <h5>Reset System Admin Password</h5>
                                          <hr />
                                        </div>
                                        <div class="form-group">
                                            <label id="lblPassword" for="password">
                                                Password
                                            </label>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <input size="15" type="password" autocomplete="off" name="pass" id="password" class="form-control">
                                                </div>
                                                <div id="password_error" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cjt_validation_error" style="width: 16px; height: 16px;" title="">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="lblPassword2" for="password2">
                                                Password (Again)
                                            </label>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <input type="password" autocomplete="off" size="15" name="pass2" id="password2" class="form-control">
                                                </div>
                                                <div id="password2_error" class="d-none" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <p style="color:red;" >Passwords do not match</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Change Password" class="btn btn-primary" id="change_admin_password">
                                        </div>
                                      </div>
                                      
                                    </form>
    
                                    <!-- card end -->
                                  </div>
                                  <!-- //TAB PANE END -->
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Loading overlay -->
  <div class="loading-overlay" id="loader">
    <div class="loader"></div>
  </div>
  <!-- Loading overlay -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="assets/js/settings.js"></script>
  <script>
      $(document).ready(function(){
            $("#password2").on("input", function() {
                var password1 = $("#password").val();
                var password2 = $(this).val();
                console.log(password2);
                var password2Error = $("#password2_error");
        
                if (password1 !== password2 || password2 == null) {
                    password2Error.removeClass("d-none"); // Remove the "d-none" class to show the error message
                } else {
                    password2Error.addClass("d-none"); // Add the "d-none" class to hide the error message
                }
        });
            var targetValue = "<?php echo $shop['backupFrequency']; ?>"; 
            
            $("#backupFrequency option").each(function() {
                if ($(this).val() === targetValue) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
            $(".save-system").click(function(event) {
                event.preventDefault();
                // Get the value of the checkbox
                var subzero = $("#subzero").prop("checked") ? 1 : 0;
                var backupFrequency = $("#backupFrequency").val();
                $.post("editShop.php",{subzero: subzero,backupFrequency:backupFrequency,},function(data){
                //   console.log(data);
                });
            });
            $(".receipt").click(function (event) {
              event.preventDefault();
              $("#loader").show();
              var includeLogo = $("#includeLogo").prop("checked") ? 1 : 0;
              var includeTill = $("#includeTill").prop("checked") ? 1 : 0;
              var includePhone = $("#includePhone").prop("checked") ? 1 : 0;
              var includeCashier = $("#includeCashier").prop("checked") ? 1 : 0;
              var includeLocation = $("#includeLocation").prop("checked") ? 1 : 0;
              var includePin = $("#includePin").prop("checked") ? 1 : 0;
              $.post("editShop.php",{showLogo: includeLogo,showTill:includeTill,showPhone:includePhone,showCashier:includeCashier,showLocation:includeLocation,showPin:includePin},function(data){
                //   console.log(data);
                $("#loader").hide();
              });
            });
            $('.permissions').click(function(){
                $("#loader").show();
                var showReturn = $("#showReturn").prop("checked") ? 1 : 0;
                var showdiscount = $("#showdiscount").prop("checked") ? 1 : 0;
                var showreceipts = $("#showreceipts").prop("checked") ? 1 : 0;
                var showOverview = $("#showOverview").prop("checked") ? 1 : 0;
                $.post("editShop.php",{showReturn: showReturn,showdiscount:showdiscount,showreceipts:showreceipts,showOverview:showOverview,},function(data){

                        $("#loader").hide();
                });
            });
            $('.closeTime').click(function(){
                $("#loader").show();
                var showReturn = $("#closeTime").val();
                $.post("editShop.php",{showReturn: showReturn,},function(data){

                        $("#loader").hide();
                });
            })
      })
  </script>
</body>

</html>