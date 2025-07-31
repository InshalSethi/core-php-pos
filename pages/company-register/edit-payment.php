<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
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
    <title>MAC | Edit Payment</title>
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
                      <h4 class="card-title">Edit Payment</h4>
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
              <?php 
              if (isset($_POST['add-payment'])) {
                  
                $voucher_no = $_POST['voucher_no'];
                $pay_date = $_POST['pay_date'];
                $pay_amount = $_POST['pay_amount'];
                $account_balance = $_POST['account_balance'];
                $account_balance_old = $_POST['account_balance_old'];
                $acc_id = $_POST['acc_num'];
                $account_number = $_POST['account_number'];
                $pay_vendor = $_POST['pay_vendor'];
                $pay_description = $_POST['pay_description'];
                $pay_reference = $_POST['pay_reference'];
                
                if($_FILES['pay_file']['name']) {
                    list($file,$error) = upload('pay_file','../../assets/images/payments','jpg,jpeg,gif,png');
                    if($error) print $error;
                    }  
                $updated_at = date("Y-m-d");
                
                if (isset($file)) {
                    $up_payment = array("vendor"=>$pay_vendor,"acc_id"=>$acc_id,"date"=>$pay_date,"amount"=>$pay_amount,"description"=>$pay_description,"reference"=>$pay_reference,"file"=>$file,"updated_at"=>$updated_at);
                    if($prefile != ''){
                    $Path = '../../assets/images/payments/'.$prefile;
                    if (file_exists($Path)){
                        if (unlink($Path)) {   
                            //echo "success";
                        } else {
                            echo "Failed to unlink previous image";    
                        }   
                    } else {
                        echo "Unlinked file does not exist";
                    }
                    }
                }else{
                    $up_payment = array("vendor"=>$pay_vendor,"acc_id"=>$acc_id,"date"=>$pay_date,"amount"=>$pay_amount,"description"=>$pay_description,"reference"=>$pay_reference,"updated_at"=>$updated_at);
                
                }
                
                $db->where("id",$payment_id);
                $payment = $db->update("payments",$up_payment);
                
                // update Payment amount into expenses table for sortable record
                
                $up_exp = array("exp_date"=>$pay_date,"account_id"=>$acc_id,"account_num"=>$account_number,"amount"=>$pay_amount,"description"=>$pay_description,"updated_at"=>$updated_at);
                
                $db->where("payment_id",$payment_id);
                $payment_exp = $db->update("expenses",$up_exp);
                
                // Deduction of payment ammount from selected account
                
                if($acc_id_pay == $acc_id){
                    
                    $temp_acc_bal = $pre_acc_balance + $amount;//old expense amount add into present balance of account
                    
                	$new_balance = $temp_acc_bal - $pay_amount; //new expense amount dedect from account balance of temporary above
                	
                	$up_account_pay = array("balance"=>$new_balance);
                	
                	$db->where('id',$acc_id);
            
                	$account_update_id = $db->update ('account', $up_account_pay);
                }elseif($acc_id_pay != $acc_id){
                    // Update values from new account and add old balance to old selected account
            	    $temp_balance_old = $account_balance_old + $amount; //old expense amount add into present balance of account
            	    $up_account_pay_old = array("balance"=>$temp_balance_old);
            	
            	    $db->where('id',$acc_id_pay);
        
            	    $account_update_id_old = $db->update ('account', $up_account_pay_old);
            	    
            	    $new_temp = $account_balance - $pay_amount;
            	    
            	    $up_account_pay_new = array("balance"=>$new_temp);
            	
                	$db->where('id',$acc_id);
            
                	$account_update_id_new = $db->update ('account', $up_account_pay_new);
                }

                if (!empty($payment)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Payment data inserted successfully .</div>";
                      ?>
                      <script>window.location.href="<?php echo baseurl('pages/company-register/payments.php'); ?>";</script>
                      <?php 
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                        }
              }
               ?>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Date</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input type="date" name="pay_date" class="form-control" required id="pay_datefield" value="<?php echo $date; ?>"/>
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
                                    <input type="text" name="pay_amount" class="form-control" id="pay_amountfield" placeholder="Enter Amount" value="<?php echo $amount; ?>"/>
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
                                    <input type="hidden" name="account_balance_old" class="form-control account_balance_old" required id="account_balance_oldfield" value="<?php echo $pre_acc_balance; ?>"/>
                                    <input type="hidden" name="account_balance" class="form-control account_balance" required id="account_balancefield"/>
                                    <input type="hidden" name="account_number" class="form-control account_number" required id="account_numberfield" value="<?php echo $pre_account_number; ?>"/>
                                    <select name="acc_num" class="form-control set-drop acc_num" id="acc_num">
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
                                    <select name="pay_vendor" class="form-control pay_vendor" id="pay_vendor">
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
                                    <input type="text" name="pay_description" class="form-control" id="pay_descriptionfield" placeholder="Enter Description" value="<?php echo $description; ?>"/>
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
                                    <input type="text" name="pay_reference" class="form-control" id="payreferencefield" placeholder="Enter Reference" value="<?php echo $reference; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Picture</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-folder-image"></i></span>
                                    </div>
                                    <input type="file" name="pay_file" class="form-control" id="pay_filefield" value="<?php  echo $prefile; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php if($prefile != ''){ ?>
                                    <img class="img-ven" src="../../assets/images/payments/<?php  echo $prefile; ?>" />
                                    <?php }else{  ?>
                                    <img class="img-ven" src="../../assets/images/vendors/im-not-found.png" />
                                    <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" name="add-payment" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                    <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                </div>
                            </div>
                        </div>
                    </form>
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
     $('.acc_num').change(function() {
    var acc_num = $(".acc_num option:selected").val();
    if(acc_num) {
      $(".no-loader").show();
      setTimeout(function(){
        $.ajax({

            url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
            type: "POST",

            dataType: 'json',

            data: {acc_num:acc_num,action:'find_account',authkey:'dabdsjjI81sa'},

            success: function(result) { 

            var obj = JSON.parse(JSON.stringify(result));
            
             $('.account_balance').val(obj[0].balance);
             $('.account_number').val(obj[0].account_number);
             

            },
            complete:function(data){
              
              $(".no-loader").hide();
             },
            
        });
     },1000);
    }
  });
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
</script>
</html>