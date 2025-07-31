<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    
    if (isset($_REQUEST['tra'])) {
        
        $tra_id = $_REQUEST['tra'];
        $transfer_id = decode($tra_id);
        $db->where('id',$transfer_id);
        $transfers = $db->getOne("transfers");
        
        $from_account_id = $transfers['from_account'];
        $to_account_id = $transfers['to_account'];
        $amount = $transfers['amount'];
        $date = $transfers['date'];
        $description = $transfers['description'];
        $reference = $transfers['reference'];
        
        //From Account Data
        $db->where("id","$from_account_id");
        $fr_account = $db->getOne("account");
        $pre_fr_acc_balance = $fr_account['balance'];
        $pre_fr_account_number = $fr_account['account_number'];
        
        // To Account Data
        $db->where("id","$to_account_id");
        $to_account = $db->getOne("account");
        $pre_to_acc_balance = $to_account['balance'];
        $pre_to_account_number = $to_account['account_number'];
        
    }
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Edit Transfer</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $UpdateTransferId = 21;

      $accessUpdateTrans = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $UpdateTransferId){
            $accessUpdateTrans =1;
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
            <?php if($accessUpdateTrans == 1){ ?>
            <div class="row">
                <div class="col-lg-6 set-mr-btm">
                    <div class="d-lg-flex align-items-baseline set-mr-btm">
                      <h4 class="card-title">
                          Edit Transfer
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
              if (isset($_POST['edit-transfer'])) {
                
                $from_old_account_balance = $_POST['from_old_account_balance'];
                $account_balance = $_POST['account_balance'];
                $from_acc_id = $_POST['acc_num'];
                $account_number = $_POST['account_number'];
                
                $to_old_account_balance = $_POST['to_old_account_balance'];
                $to_account_balance = $_POST['to_account_balance'];
                $to_acc_id = $_POST['to_acc_num'];
                $to_account_number = $_POST['to_account_number'];
                
                $tr_amount = $_POST['tr_amount'];
                $tr_date = $_POST['tr_date'];
                $tr_description = $_POST['tr_description'];
                $tr_reference = $_POST['tr_reference'];
                    
                $updated_at = date("Y-m-d");
                if($from_acc_id != $to_acc_id){
                $up_transfer = array("from_account"=>$from_acc_id,"to_account"=>$to_acc_id,"amount"=>$tr_amount,"date"=>$tr_date,"description"=>$tr_description,"reference"=>$tr_reference,"updated_at"=>$updated_at);
                // var_dump($ins_transfer);
                // die();
                $db->where("id",$transfer_id);
                $transfers = $db->update("transfers",$up_transfer);
                
                //Edit transaction for from account

                $up_transaction1 = array("account"=>$from_acc_id,"date"=>$tr_date,"amount"=>$tr_amount,"updated_at"=>$updated_at); 
                $db->where("transfer_id",$transfer_id);
                $db->where("account",$from_account_id);
                $transaction_id1 = $db->update("transactions",$up_transaction1); 

                // Edit transaction for to account

                $up_transaction2 = array("account"=>$to_acc_id,"date"=>$tr_date,"amount"=>$tr_amount,"updated_at"=>$updated_at); 
                $db->where("transfer_id",$transfer_id);
                $db->where("account",$to_account_id);
                $transaction_id2 = $db->update("transactions",$up_transaction2);

////////////////////////////////////////////////////////////////////////////////////
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

                $GlSalJVarr = array("date"=>$tr_date,"total_debit"=>$TotalDebit,"total_credit"=>$TotalCredit,"updated_at"=>$updated_at);
                $db->where("transfer_id",$transfer_id);
                $JVData = $db->update("journal_tbl",$GlSalJVarr);

                $db->where('transfer_id',$transfer_id);
                $JvOldDataCli = $db->getOne("journal_tbl");
                $JIdCli = $JvOldDataCli['j_id'];

                //Get JVMeta Data for first entry
                  $db->where('j_id',$JIdCli);
                  $db->orderBy ("jm_id","asc");
                  $JvMetaOldDataCli1 = $db->getOne("journal_meta");
                  $JmIdCli1 = $JvMetaOldDataCli1['jm_id'];

              //For Debit Account entry in JV Meta 
                $JVMetaArrDebit = array("chrt_id"=>$ToChrtId,"debit"=>$tr_amount,"updated_at"=>$updated_at);
                $db->where('jm_id',$JmIdCli1);
                $MetaJvDebitInsert = $db->update("journal_meta",$JVMetaArrDebit);

                //Get JVMeta Data for second entry
                $db->where('j_id',$JIdCli);
                $db->orderBy ("jm_id","desc");
                $JvMetaOldDataCli2 = $db->getOne("journal_meta");
                $JmIdCli2 = $JvMetaOldDataCli2['jm_id'];

              //For Credit Account entry in JV Meta
                $JVMetaArrCredit = array("chrt_id"=>$FromChrtId,"credit"=>$tr_amount,"updated_at"=>$updated_at);
                $db->where('jm_id',$JmIdCli2);
                $MetaJvCreditInsert = $db->update("journal_meta",$JVMetaArrCredit);
///////////////////////////////////////////////////////////////////////////////////
                
                // Deduction of payment ammount from selected account
                
                    //if account was not changed by user to edit transfer
                if($from_acc_id == $from_account_id && $to_acc_id == $to_account_id){
                    
                    $temp_fr_bal = $pre_fr_acc_balance + $amount;
                    
                    $account_new_balance = $temp_fr_bal - $tr_amount;
                    
                    $up_acc_from = array("balance"=>$account_new_balance);
                    $db->where("id",$from_acc_id);
                    
                    $from_account_updated = $db->update("account",$up_acc_from);
                    
                    // Add amount into selected account
                    
                    $temp_to_bal = $pre_to_acc_balance - $amount;
                    
                    $to_account_new_balance = $temp_to_bal + $tr_amount;
                    
                    $up_acc_to = array("balance"=>$to_account_new_balance);
                    $db->where("id",$to_acc_id);
                    
                    $to_account_updated = $db->update("account",$up_acc_to);
                    
                }elseif($from_acc_id != $from_account_id && $to_acc_id == $to_account_id){
                    
                    //add old deducted amount into old slected account (from)
                    $fr_acc_bal = $pre_fr_acc_balance + $amount;
                    
                    $up_acc_from_ol = array("balance"=>$fr_acc_bal);
                    $db->where("id",$from_account_id);
                    $db->update("account",$up_acc_from_ol);
                    
                    //Deduction of ammount from new selected account 
                    
                    $account_new_balance = $account_balance - $tr_amount;
                
                    $up_acc_from = array("balance"=>$account_new_balance);
                    $db->where("id",$from_acc_id);
                    
                    $from_account_updated = $db->update("account",$up_acc_from);
                    
                }elseif($from_acc_id == $from_account_id && $to_acc_id != $to_account_id){
                    
                    //Deduction of ammount from old selected account (To)
                    $to_acc_bal = $pre_to_acc_balance - $amount;
                    
                    $up_acc_to_ol = array("balance"=>$to_acc_bal);
                    $db->where("id",$to_account_id);
                    $db->update("account",$up_acc_to_ol);
                    
                    //Add Old amount into new selected account (To)
                    
                    $to_account_new_balance = $to_account_balance + $tr_amount;
                
                    $up_acc_to = array("balance"=>$to_account_new_balance);
                    $db->where("id",$to_acc_id);
                    
                    $to_account_updated = $db->update("account",$up_acc_to);
                    
                }elseif($from_acc_id != $from_account_id && $to_acc_id != $to_account_id){
                    
                    //add old deducted amount into old slected account (from)
                    $fr_acc_bal = $pre_fr_acc_balance + $amount;
                    
                    $up_acc_from_ol = array("balance"=>$fr_acc_bal);
                    $db->where("id",$from_account_id);
                    $db->update("account",$up_acc_from_ol);
                    
                    //Deduction of ammount from new selected account (form)
                    
                    $account_new_balance = $account_balance - $tr_amount;
                
                    $up_acc_from = array("balance"=>$account_new_balance);
                    $db->where("id",$from_acc_id);
                    
                    $from_account_updated = $db->update("account",$up_acc_from);
                    
                    //Deduction of ammount from old selected account (To)
                    $to_acc_bal = $pre_to_acc_balance - $amount;
                    
                    $up_acc_to_ol = array("balance"=>$to_acc_bal);
                    $db->where("id",$to_account_id);
                    $db->update("account",$up_acc_to_ol);
                    
                    //Add Old amount into new selected account (To)
                    
                    $to_account_new_balance = $to_account_balance + $tr_amount;
                
                    $up_acc_to = array("balance"=>$to_account_new_balance);
                    $db->where("id",$to_acc_id);
                    
                    $to_account_updated = $db->update("account",$up_acc_to);
                    
                }
                
                if (!empty($transfers)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Amount successfully transfered.</div>";
                      ?>
                      <script>window.location.href="<?php echo baseurl('pages/banking/transfers.php'); ?>";</script>
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
                                    <input type="hidden" name="voucher_no" class="form-control" required id="voucher_nofield" value="<?php echo $newvoucher; ?>"/>
                                    <input type="hidden" name="from_old_account_balance" class="form-control from_old_account_balance" required id="from_old_account_balancefield" value="<?php echo $pre_fr_acc_balance; ?>"/>
                                    <input type="hidden" name="account_balance" class="form-control account_balance emp" required id="account_balancefield"/>
                                    <input type="hidden" name="account_number" class="form-control account_number emp" required id="account_numberfield" value="<?php echo $pre_fr_account_number; ?>"/>
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


                        $cols=array("acc.account_number","trs.category","trs.amount",);

                        $db->where("acc.id", $acc_id);

                        $db->join("account acc", "trs.account=acc.id", "INNER");

                        $transfersdata = $db->get("transactions trs",null,$cols);
                        $Balance = 0;
                        foreach($transfersdata as $transfers){

                          if($transfers['category'] == 'Income'){
                                // $receipt = 'Income';
                                $receipt = $transfers['amount'];
                                $Balance += $receipt;
                            }else{
                                $receipt = '';
                            }

                            if($transfers['category'] == 'Expense'){
                                // $payments = 'Expense';
                                $payments = $transfers['amount'];
                                $Balance -= $payments;
                            }else{
                                $payments = '';
                            }

                            if($transfers['category'] == 'Funds Transfer From'){
                                // $payments = 'Expense';
                                $transferAmountFrom = $transfers['amount'];
                                $Balance -= $transferAmountFrom;
                            }else{
                                $transferAmountFrom = '';
                            }

                            if ($transfers['category'] == 'Funds Transfer To') {

                                $transferAmount = $transfers['amount'];
                                $Balance += $transferAmount;
                            }else{
                                $transferAmount = '';
                            }

                            

                            

                        }
                        $CurrentBalance = $Balance + $Opening_balance;
                                          ?>
                                          <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $from_account_id){ echo 'selected';} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
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
                                    <input type="hidden" name="to_old_account_balance" class="form-control to_old_account_balance" required id="to_old_account_balancefield" value="<?php echo $pre_to_acc_balance; ?>"/>
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


                        $cols=array("acc.account_number","trs.category","trs.amount",);

                        $db->where("acc.id", $acc_id);

                        $db->join("account acc", "trs.account=acc.id", "INNER");

                        $transfersdata = $db->get("transactions trs",null,$cols);
                        $Balance = 0;
                        foreach($transfersdata as $transfers){

                          if($transfers['category'] == 'Income'){
                                // $receipt = 'Income';
                                $receipt = $transfers['amount'];
                                $Balance += $receipt;
                            }else{
                                $receipt = '';
                            }

                            if($transfers['category'] == 'Expense'){
                                // $payments = 'Expense';
                                $payments = $transfers['amount'];
                                $Balance -= $payments;
                            }else{
                                $payments = '';
                            }

                            if($transfers['category'] == 'Funds Transfer From'){
                                // $payments = 'Expense';
                                $transferAmountFrom = $transfers['amount'];
                                $Balance -= $transferAmountFrom;
                            }else{
                                $transferAmountFrom = '';
                            }

                            if ($transfers['category'] == 'Funds Transfer To') {

                                $transferAmount = $transfers['amount'];
                                $Balance += $transferAmount;
                            }else{
                                $transferAmount = '';
                            }

                            

                            

                        }
                        $CurrentBalance = $Balance + $Opening_balance;
                                          ?>
                                          <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $to_account_id){ echo 'selected';} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
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
                                    <input type="text" name="tr_amount" class="form-control" id="tr_amountfield" placeholder="Enter Amount" value="<?php echo $amount; ?>"/>
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
                                    <input type="date" name="tr_date" class="form-control" required id="tr_datefield" value="<?php echo $date; ?>"/>
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
                                    <input type="text" name="tr_description" class="form-control" id="tr_descriptionfield" placeholder="Enter Description" value="<?php echo $description; ?>"/>
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
                                    <input type="text" name="tr_reference" class="form-control" id="tr_referencefield" placeholder="Enter Reference" value="<?php echo $reference; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" name="edit-transfer" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
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