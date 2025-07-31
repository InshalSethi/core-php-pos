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
    <title>POS | Add Transfer</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddTransferId = 19;

      $accessAddTrans = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddTransferId){
            $accessAddTrans =1;
          }
        }  
    ?>
  </head>
  <style>
  #nagative-zero{
      display:none; 
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
            <?php if($accessAddTrans == 1){ ?>
            <div class="row">
                <div class="col-lg-6 set-mr-btm">
                    <div class="d-lg-flex align-items-baseline set-mr-btm">
                      <h4 class="card-title">Add Transfer
                        <span id="nagative-zero" class="alert alert-warning">
                                Selected Account balance is negative or zero! 
                        </span>
                      </h4>
                    </div>
                </div>
                <div class="col-lg-6">
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
              if (isset($_POST['add-transfer'])) {
                  
                
                $account_balance = $_POST['account_balance'];
                $from_acc_id = $_POST['acc_num'];
                $account_number = $_POST['account_number'];
                
                $to_account_balance = $_POST['to_account_balance'];
                $to_acc_id = $_POST['to_acc_num'];
                $to_account_number = $_POST['to_account_number'];
                
                $tr_amount = $_POST['tr_amount'];
                $tr_date = $_POST['tr_date'];
                $tr_description = $_POST['tr_description'];
                $tr_reference = $_POST['tr_reference'];
                
                $cat_from = 'Funds Transfer From';
                $cat_to = 'Funds Transfer To';
                    
                $created_at = date("Y-m-d");
                if($from_acc_id != $to_acc_id){
                $ins_transfer = array("from_account"=>$from_acc_id,"to_account"=>$to_acc_id,"amount"=>$tr_amount,"date"=>$tr_date,"description"=>$tr_description,"reference"=>$tr_reference,"created_at"=>$created_at);
                // var_dump($ins_transfer);
                // die();
                $transfers = $db->insert("transfers",$ins_transfer);
                
                //add transaction for from account

                $ins_transaction1 = array("transfer_id"=>$transfers,"account"=>$from_acc_id,"category"=>$cat_from,"date"=>$tr_date,"amount"=>$tr_amount,"created_at"=>$created_at); 
                $transaction_id1 = $db->insert("transactions",$ins_transaction1); 

                // add transaction for to account

                $ins_transaction2 = array("transfer_id"=>$transfers,"account"=>$to_acc_id,"category"=>$cat_to,"date"=>$tr_date,"amount"=>$tr_amount,"created_at"=>$created_at); 
                $transaction_id2 = $db->insert("transactions",$ins_transaction2);

//////////////////////////////////////////////////////////////////////////////////////////////

                //Insert Data into JV table

                //Selected From Account for COA Account

                $db->where('id',$from_acc_id);
                $FromCOA = $db->getOne("account");
                $FromChrtId = $FromCOA['coa_id']; 

                //Selected To Account for COA Account

                $db->where('id',$to_acc_id);
                $ToCOA = $db->getOne("account");
                $ToChrtId = $ToCOA['coa_id'];

                //Get Voucher number for JV
                  $newJVvoucher = GetJvVoucherNumber($db);

//////////////////Insert Transfer From Account Data into Jv As Funds Transfer/////////////////

                $TotalDebit = $tr_amount;
                $TotalCredit = $tr_amount;

                $GlSalJVarr = array("gl_type"=>'4',"transfer_id"=>$transfers,"voucher_no"=>$newJVvoucher,"date"=>$tr_date,"total_debit"=>$TotalDebit,"total_credit"=>$TotalCredit,"created_at"=>$created_at);
                $JVData = $db->insert("journal_tbl",$GlSalJVarr);

              //For Debit Account entry in JV Meta 
                $JVMetaArrDebit = array("j_id"=>$JVData,"chrt_id"=>$ToChrtId,"debit"=>$tr_amount,"created_at"=>$created_at);
                $MetaJvDebitInsert = $db->insert("journal_meta",$JVMetaArrDebit);

              //For Credit Account entry in JV Meta
                $JVMetaArrCredit = array("j_id"=>$JVData,"chrt_id"=>$FromChrtId,"credit"=>$tr_amount,"created_at"=>$created_at);
                $MetaJvCreditInsert = $db->insert("journal_meta",$JVMetaArrCredit);

/////////////////////////////////////////////////////////////////////////////////////////////                
                
                // Deduction of payment ammount from selected From account
                
                $account_new_balance = $account_balance - $tr_amount;
                
                $up_acc_from = array("balance"=>$account_new_balance);
                $db->where("id",$from_acc_id);
                
                $from_account_updated = $db->update("account",$up_acc_from);
                
                // Add amount into selected To account 
                
                $to_account_new_balance = $to_account_balance + $tr_amount;
                
                $up_acc_to = array("balance"=>$to_account_new_balance);
                $db->where("id",$to_acc_id);
                
                $to_account_updated = $db->update("account",$up_acc_to);

                if (!empty($to_account_updated)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Amount successfully transfered.</div>";
                      ?>
                      <script>window.location.href="<?php echo baseurl('pages/banking/add-transfer.php'); ?>";</script>
                      <?php 
                        } else{
                          echo "<div class='alert alert-danger' id='danger-alert' role='alert'>Alert! Amount not transfered.</div>";
                        }
                }
                elseif($from_acc_id == $to_acc_id){
                    echo "<div class='alert alert-danger' id='danger-alert' role='alert'>Alert! Both accounts should not be same, please select different accounts.</div>";
                }
              }
               ?>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form class="addtransfer" action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">From Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <input type="hidden" name="account_balance" class="form-control account_balance emp" required id="account_balancefield"/>
                                    <input type="hidden" name="account_number" class="form-control account_number emp" required id="account_numberfield"/>
                                    <select name="acc_num" class="form-control set-drop acc_num" id="acc_num" required>
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
                          $Opening_balance = $acc['opening_balance'];


                        
                        $CurrentBalance =GetAccountBalance($acc_id,$Opening_balance,$db);
                                          ?>
                                          <option value="<?php echo $acc_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                          <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">To Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <input type="hidden" name="to_account_balance" class="form-control to_account_balance" required id="to_account_balancefield"/>
                                    <input type="hidden" name="to_account_number" class="form-control to_account_number" required id="to_account_numberfield"/>
                                    <select name="to_acc_num" class="form-control set-drop to_acc_num" id="to_acc_num" required>
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
                          $Opening_balance = $acc['opening_balance'];


                        $CurrentBalance =GetAccountBalance($acc_id,$Opening_balance,$db);
                        
                                          ?>
                                          <option value="<?php echo $acc_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
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
                                  <label class="col-form-label">Amount</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-cash-usd"></i></span>
                                    </div>
                                    <input type="text" name="tr_amount" class="form-control" id="tr_amountfield" placeholder="Enter Amount"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Date</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    <input type="date" name="tr_date" class="form-control" required id="tr_datefield"/>
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
                                    <input type="text" name="tr_description" class="form-control" id="tr_descriptionfield" placeholder="Enter Description"/>
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
                                    <input type="text" name="tr_reference" class="form-control" id="tr_referencefield" placeholder="Enter Reference"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" name="add-transfer" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
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
        <?php }else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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
//   From account
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
            var check = obj[0].balance;
            $('.account_balance').val(obj[0].balance);
            $('.account_number').val(obj[0].account_number);

            // if(check > 0){
            //  $('.account_balance').val(obj[0].balance);
            //  $('.account_number').val(obj[0].account_number);
            // }else{
            //    $("#nagative-zero").show(); 
            //    setTimeout(function() {
            //             $("#nagative-zero").hide();
            //         }, 3500);
            //         $('.addtransfer').trigger("reset");
            //         $('.emp').val('')
               
            // }

            },
            complete:function(data){
              
              $(".no-loader").hide();
             },
            
        });
     },1000);
    }
  });
  
//   To Account
$('.to_acc_num').change(function() {
    var to_acc_num = $(".to_acc_num option:selected").val();
    if(to_acc_num) {
      $(".no-loader").show();
      setTimeout(function(){
        $.ajax({

            url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
            type: "POST",

            dataType: 'json',

            data: {to_acc_num:to_acc_num,action:'find_to_account',authkey:'dabdsjjI81sa'},

            success: function(result) { 

            var obj = JSON.parse(JSON.stringify(result));
            
             $('.to_account_balance').val(obj[0].balance);
             $('.to_account_number').val(obj[0].account_number);
             

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
    
    $("#danger-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#danger-alert").slideUp(500);
    $("#danger-alert").hide();
    });
</script>
</html>