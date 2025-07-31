<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | Add Receipt</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
  </head>
  <style>
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
        <?php
          $db->orderBy("id","Desc");
          $recipt_voucherData = $db->get("recipt_voucher",1);
          foreach ($recipt_voucherData as $recipt_voucher) {
            $previousreceiptid = $recipt_voucher['id'];
            $previousvoucher = $recipt_voucher['voucher'];
            
          }
          if(!empty($previousvoucher)){
            $newvoucher = $previousvoucher+1;
          }else{
            $newvoucher = 1;
          }
          
    ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-3 set-mr-btm">
                    <div class="d-lg-flex align-items-baseline set-mr-btm">
                      <h4 class="card-title">Add Receipt</h4>
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
                          if (isset($_POST['add-receipt'])) {
                              
                            $voucher_no = $_POST['voucher_no'];
                            $account_balance = $_POST['account_balance'];
                            $acc_id = $_POST['acc_num'];
                            $account_number = $_POST['account_number'];
                            $payment_date = $_POST['payment_date'];
                            $recipient_name = $_POST['recipient_name'];
                            $receipt_des = $_POST['receipt_des'];
                            $receipt_amount = $_POST['receipt_amount'];
                            $created_at = date("Y-m-d");
                            
                            $cat = 'Income';
                            
                            $ins_receipt = array("voucher"=>$voucher_no,"account_id"=>$acc_id,"account_number"=>$account_number,"payment_date"=>$payment_date,"recipient_name"=>$recipient_name,"description"=>$receipt_des,"amount"=>$receipt_amount,"created_at"=>$created_at);
                            //var_dump($ins_receipt);
                            //die();
                            
                            $receipt_id = $db->insert("recipt_voucher",$ins_receipt);
                            
                            $account_new_balance = $account_balance + $receipt_amount;
                            // var_dump($account_new_balance);
                            // die();
                            //here new balance for selected account after receipt ammount is added in account balance
                            $up_acc = array("balance"=>$account_new_balance);
                            $db->where("id",$acc_id);
                            $account_updated = $db->update("account",$up_acc);
                            
                            $ins_transaction = array("recp_id"=>$receipt_id,"account"=>$acc_id,"category"=>$cat,"date"=>$payment_date,"amount"=>$receipt_amount,"created_at"=>$created_at); 
                            $transaction_id = $db->insert("transactions",$ins_transaction); 
            
                            if (!empty($receipt_id)){
                                  echo "<div class='alert alert-success' id='success-alert' role='alert'>Receipt Voucher data inserted successfully .</div>";
                                  ?>
                                  <script>
                                      window.location.href="<?php echo baseurl('pages/company-register/add-receipt-voucher.php'); ?>";
                                  </script>
                                  <?php
                                    } else{
                                      echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                                    }
                          }
               ?>
                    <div class="card card-border-color">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Voucher No.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="text" name="voucher_no" class="form-control" required id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $newvoucher; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Received In A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="account_balance" class="form-control account_balance" required id="account_balancefield"/>
                                            <input type="hidden" name="account_number" class="form-control account_number" required id="account_numberfield"/>
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
                                                  <option value="<?php echo $acc_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.$acc_balance.') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Received Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="payment_date" class="form-control" required id="payment_datefield" placeholder="Enter Received Date"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Recipient Name</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="text" name="recipient_name" class="form-control recipient_name" required id="recipient_namefield" placeholder="Enter Recipient Name"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--start here-->
                                <div class="row">
                                            <div class="col-md-12">
                                             <div class="table-responsive pt-3 set-tbl">
                                              <table class="table table-bordered myTable" id="myTable">
                                                <thead>
                                                  <tr>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Description
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Amount
                                                    </th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="receipt_des" class="form-control receipt_des" value="" placeholder="Write Description"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="receipt_amount" class="form-control receipt_amount" value="0" Placeholder="Enter Amount"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end here-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-right" style="margin-top: 5px;">
                                            <button type="submit" name="add-receipt" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                            <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
 
  </script>
  <script>
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
</script>
</html>