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
    <title>MAC | Add Expense</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddExpenseId = 73;
      $accessAddExp = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddExpenseId){
            $accessAddExp =1;
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
        <?php
          $newvoucher = GetExpenseVoucherNumber($db);
          
    ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <?php if($accessAddExp == 1){ ?>
            <div class="row">
                <div class="col-lg-6 set-mr-btm">
                    <div class="d-lg-flex align-items-baseline set-mr-btm">
                      <h4 class="card-title">
                          Add Expense
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
                          if (isset($_POST['add-expense'])) {
                              
                            $voucher_no = $_POST['voucher_no'];
                            $account_balance = $_POST['account_balance'];
                            $acc_id = $_POST['acc_num'];
                            $account_number = $_POST['account_number'];
                            $payment_date = $_POST['payment_date'];
                            $exp_type_id = $_POST['exp_type'];
                            $exp_type_name = $_POST['exp_type_name'];
                            $exp_des = $_POST['exp_des'];
                            $exp_amount = $_POST['exp_amount'];
                            $cat = 'Expense';
                            $created_at = date("Y-m-d");

                            //Exp.type table data
                              $db->where('id',$exp_type_id);
                              $ExpTypData = $db->getOne("exp_type");
                              $ExpCOAId = $ExpTypData['chrt_id'];
                            
                            $ins_expenses = array("chrt_id"=>$ExpCOAId,"category"=>$cat,"voucher"=>$voucher_no,"exp_date"=>$payment_date,"account_id"=>$acc_id,"account_num"=>$account_number,"amount"=>$exp_amount,"exp_type_id"=>$exp_type_id,"exp_type_name"=>$exp_type_name,"description"=>$exp_des,"created_at"=>$created_at);

                            // var_dump($ins_expenses);
                            // die();
                            
                            $expenses_id = $db->insert("expenses",$ins_expenses);
                            
                            
                            //here new balance for selected account after expence is detected from account balance

                            $account_new_balance = $account_balance - $exp_amount;

                            $up_acc = array("balance"=>$account_new_balance);
                            $db->where("id",$acc_id);
                            $account_updated = $db->update("account",$up_acc);
                            
                            $ins_transaction = array("exp_id"=>$expenses_id,"account"=>$acc_id,"category"=>$cat,"date"=>$payment_date,"amount"=>$exp_amount,"created_at"=>$created_at); 
                            $transaction_id = $db->insert("transactions",$ins_transaction);


                            //Selected Account for COA Account

                              $db->where('id',$acc_id);
                              $BankAccDpt = $db->getOne("account");
                              $AccCoaDptId = $BankAccDpt['coa_id'];


                            //Get Voucher number for JV
                              $newJVvoucher = GetJvVoucherNumber($db);

                            //Insert dept expense Data into JV

                              $TotalDebit = $exp_amount;
                              $TotalCredit = $exp_amount;

                              $GlSalJVarr = array("expense_id"=>$expenses_id,"gl_type"=>'2',"voucher_no"=>$newJVvoucher,"date"=>$payment_date,"total_debit"=>$TotalDebit,"total_credit"=>$TotalCredit,"created_at"=>$created_at);
                              $JVData = $db->insert("journal_tbl",$GlSalJVarr);

                            //For Debit Account entry in JV Meta 
                              $JVMetaArrDebit = array("j_id"=>$JVData,"chrt_id"=>$ExpCOAId,"debit"=>$exp_amount,"created_at"=>$created_at);
                              $MetaJvDebitInsert = $db->insert("journal_meta",$JVMetaArrDebit);

                            //For Credit Account entry in JV Meta
                              $JVMetaArrCredit = array("j_id"=>$JVData,"chrt_id"=>$AccCoaDptId,"credit"=>$exp_amount,"created_at"=>$created_at);
                              $MetaJvCreditInsert = $db->insert("journal_meta",$JVMetaArrCredit); 

                            if (!empty($expenses_id)){
                                  echo "<div class='alert alert-success' id='success-alert' role='alert'>Expense data inserted successfully .</div>";
                                  ?>
                                  <script>
                                      window.location.href="<?php echo baseurl('pages/company-register/add-expense.php'); ?>";
                                  </script>
                                  <?php
                                    } else{
                                      echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                                    }
                          }
               ?>
                    <div class="card card-border-color">
                        <div class="card-body">
                            <form class="addexpenses" action="" method="POST">
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
                                          <label class="col-form-label">Paid from A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="account_balance" class="form-control account_balance emp" required id="account_balancefield"/>
                                            <input type="hidden" name="account_number" class="form-control account_number emp" required id="account_numberfield"/>
                                            <select name="acc_num" class="form-control set-drop acc_num " id="acc_num" required>
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

                          if($transfers['category'] == 'sale invoice'){
                              // $receipt = 'Income';
                              $receipt = (float)$transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }
                          if($transfers['category'] == 'receipt voucher'){
                              // $receipt = 'Income';
                              $receipt = (float)$transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }

                          if($transfers['category'] == 'payment voucher'){
                              $payments = (float)$transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Expense'){
                              // $payments = 'Expense';
                              $payments = (float)$transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'purchase invoice'){
                              // $payments = 'Expense';
                              $payments = (float)$transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Funds Transfer From'){

                              $transferAmountFrom = (float)$transfers['amount'];
                              $Balance -= $transferAmountFrom;
                          }else{
                              $transferAmountFrom = '';
                          }

                          if ($transfers['category'] == 'Funds Transfer To') {

                              $transferAmount = (float)$transfers['amount'];
                              $Balance += $transferAmount;
                          }else{
                              $transferAmount = '';
                          }





                        }
                        $CurrentBalance = $Balance + (float)$Opening_balance;
                                                  ?>
                                                  <option value="<?php echo $acc_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Payment Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="payment_date" class="form-control" required id="payment_datefield" placeholder="Enter Payment Date" value="<?php  echo date("Y-m-d"); ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Type of Exp.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <select name="exp_type" class="form-control set-drop exp_type" id="exp_type">
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $exp_type_data = $db->get("exp_type");
                                                  foreach ($exp_type_data as $exp_type) {
                                                      $exp_type_id = $exp_type['id'];
                                                      $exp_type_name = $exp_type['type_name'];
                                                  ?>
                                                  <option value="<?php echo $exp_type_id; ?>"><?php echo $exp_type_name; ?></option>
                                                  <?php } ?>
                                            </select>
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
                                                      Type of Exp.
                                                    </th>
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
                                                            <input type="text" name="exp_type_name" class="form-control exp_type_name" required value="" placeholder="Enter Type of Exp."/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_des" class="form-control exp_des" value="" placeholder="Write Description"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_amount" class="form-control exp_amount" value="0" Placeholder="Enter Amount"/>
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
                                            <button type="submit" name="add-expense" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                            <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
            //         $('.addexpenses').trigger("reset");
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
  
    $('.exp_type').change(function() {
    var exp_type = $(".exp_type option:selected").val();
    if(exp_type) {
      $(".no-loader").show();
      setTimeout(function(){
        $.ajax({

            url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
            type: "POST",

            dataType: 'json',

            data: {exp_type:exp_type,action:'find_exp_type',authkey:'dabdsjjI81sa'},

            success: function(result) { 

            var obj = JSON.parse(JSON.stringify(result)); 
            
             $('.exp_type_name').val(obj[0].type_name);
             

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