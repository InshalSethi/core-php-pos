<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    if (isset($_REQUEST['pay'])) {
        
        $pay_id = $_REQUEST['pay'];
        $payment_id = decode($pay_id);
        $db->where('id',$payment_id);
        $payments = $db->getOne("payments");
        
        $vendor_id_pay = $payments['vendor'];
        $acc_id_pay = $payments['acc_id'];
        $date = $payments['date'];
        $amount = $payments['amount'];
        $description = $payments['description'];
        $reference = $payments['reference'];
        $prefile = $payments['file'];
        
        $db->where("id","$acc_id_pay");
        $account = $db->getOne("account");
        $pre_acc_balance = $account['balance'];
        $pre_account_number = $account['account_number'];
        
    }
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | View Payment</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
  </head>
  <style>
  .img-ven{
        border: 2px solid #6da252;
        border-radius: 5px;
        width: 175px;
        box-shadow: 0 2px 2px 0 rgba(96, 97, 96, 0.14), 0 3px 1px -2px rgba(99, 105, 103, 0.2), 0 1px 5px 0 rgba(98, 107, 104, 0.12);
    }
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
    }
        .inactive-alert{
      display:none; 
  }
  .setting-loader{
    border: none!important;
  }
  .dot-opacity-loader{
    width: 100%;
    height: auto;
    text-align: right;
  }
  .dot-opacity-loader span{
    margin: 2px 5px;
    background-color: #6da252;
  }
  .loader-demo-box{
    height: auto;
  }
  .no-loader{
    display: none;
  }
  .small-space{
    padding: 20px!important;
  }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
 <?php include '../../libraries/nav.php'; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <?php include '../../libraries/sidebar.php'; ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-3 set-mr-btm">
                    <div class="d-lg-flex align-items-baseline set-mr-btm">
                      <h4 class="card-title">View Payment</h4>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="no-loader">
                      <div class="loader-demo-box setting-loader">
                        <div class="dot-opacity-loader">
                          <span></span>
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                      </div>
                    </div>
                </div>
              <div class="col-lg-12">
                  <div class="col-lg-12">
                     <div class="card card-border-color">
                      <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Date</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                                <input type="date" name="pay_date" class="form-control" required id="pay_datefield" readonly value="<?php echo $date; ?>"/>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Amount</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-cash-usd"></i></span>
                                                </div>
                                                <input type="text" name="pay_amount" class="form-control" id="pay_amountfield" placeholder="Enter Amount" readonly value="<?php echo $amount; ?>"/>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Account</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                                </div>
                                                <select name="acc_num" class="form-control set-drop acc_num" id="acc_num" disabled>
                                                      <option value="">Select Any</option>
                                                      <?php
                                                      
                                                      $db->where("status",'1');
                                                      $acc_data = $db->get("account");
                                                      foreach ($acc_data as $acc) {
                                                          $acc_id = $acc['id'];
                                                          $acc_account_name = $acc['name'];
                                                          $acc_bank = $acc['bank_name'];
                                                          $acc_account_number = $acc['account_number'];
                                                          $acc_balance = $acc['balance'];
                                                      ?>
                                                      <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $acc_id_pay){echo 'selected';} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.$acc_balance.') '; ?></option>
                                                      <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Vendor</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-account"></i></span>
                                                </div>
                                                <select name="pay_vendor" class="form-control pay_vendor" id="pay_vendor" disabled>
                                                      <option value="">Select Any</option>
                                                      <?php
                                                      
                                                      $db->where("status",'1');
                                                      $vendors_data = $db->get("vendors");
                                                      foreach ($vendors_data as $vendor) {
                                                          $vendor_id = $vendor['id'];
                                                          $vendor_name = $vendor['name'];
                                                      ?>
                                                      <option value="<?php echo $vendor_id; ?>" <?php if($vendor_id == $vendor_id_pay){echo 'selected';} ?>><?php echo $vendor_name; ?></option>
                                                      <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Description</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-note-text"></i></span>
                                                </div>
                                                <input type="text" name="pay_description" class="form-control" id="pay_descriptionfield" placeholder="Enter Description" readonly value="<?php echo $description; ?>"/>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <label class="col-form-label">Reference</label>
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text in-grp"><i class="mdi mdi-note-text"></i></span>
                                                </div>
                                                <input type="text" name="pay_reference" class="form-control" id="payreferencefield" placeholder="Enter Reference" readonly value="<?php echo $reference; ?>"/>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($prefile != ''){ ?>
                                                <img class="img-ven" src="../../assets/images/payments/<?php  echo $prefile; ?>" />
                                                <?php }else{  ?>
                                                <img class="img-ven" src="../../assets/images/vendors/im-not-found.png" />
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>
                  </div>
              </div>
            
              
           
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php include '../../libraries/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <?php include '../../libraries/js_libs.php'; ?>
  </body>
  <script>
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
</script>
</html>