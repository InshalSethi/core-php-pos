<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';


    if (isset($_REQUEST['id'])) {
      $x=$_REQUEST['id'];

    if ( $x != '') {

    $db->where("id",$x);
    $exp_data = $db->getOne('expenses');

    $SalaryId = $exp_data['salary_id'];
    $acc_id = $exp_data['account_id'];
    $exp_amount = $exp_data['amount'];
    // var_dump($exp_data);
    // die();

    //Fetch Data from Journal_table to get J_Id for Journal_meta table

    $db->where("expense_id",$x);
    $JvOldDataCli = $db->getOne("journal_tbl");
    $JIdCli = $JvOldDataCli['j_id'];

    //Delete this entry from JV Table
    $db->where("j_id",$JIdCli);
    $db->delete('journal_meta');

    //Delete this entry from JV Table
    $db->where("expense_id",$x);
    $db->where("j_id",$JIdCli);
    $db->delete('journal_tbl');
  

    $db->where("exp_id",$x);
    $db->delete('transactions');

//If User Delete the Salary Data
    if(!empty($SalaryId)){

      $db->where("id",$SalaryId);
      $db->delete('employee_salary');

    }
//If User Delete the Dept Exp. Data
 
    
    $db->where("id",$x);
    $db->delete('expenses');
    ?>
    }
<script>
  window.location.href="expence-management.php";
</script>
<?php
    }      
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Expenses | Inventory</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddExpenseId = 73;
      $ReadExpenseId = 74;
      $UpdateExpenseId = 75;
      $DeleteExpenseId = 76;

      $accessAddExp = 0;
      $accessReadExp = 0;
      $accessUpdateExp = 0;
      $accessDeleteExp = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddExpenseId){
            $accessAddExp =1;
          }
          if($UsrPer['permission_id'] == $ReadExpenseId){
            $accessReadExp =1;
          }
          if($UsrPer['permission_id'] == $UpdateExpenseId){
            $accessUpdateExp =1;
          }
          if($UsrPer['permission_id'] == $DeleteExpenseId){
            $accessDeleteExp =1;
          }
        }  
    ?>
    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">

  </head>
  <style>
  #nagative-zero{
      display:none; 
  }
  .free-cus{
      color:blue;
  }
  .cus-inactive{
      color:red;
  }
  .today-hear{
      background-color:#6da252!important;
      color: white;
  }
  .td1-set{
  padding: 5px!important;
  font-size: 13px!important;
  
    }
  .inactive-alert{
      display:none; 
  }
  .ui-autocomplete{
    z-index: 9999999999!important;
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
    .set-drop{
        height: 31px;
        margin-top: 1px;
    }
    .set-drop1{
        height: 34px;
        margin-top: 1px;
    }
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
    }
    .no-mar-btm{
      margin-bottom: 0px!important;
    }
    .clr{
      color: white!important;
    }
    .advance-search-main{
      background: #ecf0f8;
      padding: 5px;
      margin-bottom: 5px;
      border-radius: 5px;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
    }
    .advance-search-row{
      margin-bottom: 5px;
    }
    .advance-lable-padding{
      padding: 0px!important;
    }
    .advance-input-padding{
      padding: 5px!important;
    }
    .advance-search-radio{
      margin-left: 25px;
      margin-top: 5px;
    }
    .no-side-padding{
      padding-left: 0px!important;
      padding-right: 0px!important;
    }
    .no-side-padding-first{
      padding-right: 0px!important;
    }
    .no-side-padding-last{
      padding-left: 0px!important;
    }
    .wdt-st{
      width: 16%;
    }
    .text-cli{
      text-decoration: none;
      color: black;
      cursor: pointer;
    }
    .text-cli:hover{
      color: black;
    }
    @media only screen and (min-width: 320px) and (max-width: 480px){
      .no-side-padding{
      padding-left: 15px!important;
      padding-right: 15px!important;
    }
    .no-side-padding-first{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
    .no-side-padding-last{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
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
          <?php  
          $Total_exp_amount = 0;
          $expensesValData = $db->get("expenses");
            foreach ($expensesValData as $expensesVal) {
            $Total_exp_amount += (float)$expensesVal['amount'];
          }
          ?>


          <?php 
            $expenses_view=CheckPermission($permissions,'expenses_view');
            if($expenses_view == 1){ ?>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <h4 class="card-title">Expenses</h4>
                <?php if($accessAddExp == 1){ ?>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-expense.php'"><i class="mdi mdi-plus"></i> Add New</button>
                <?php } ?>
                <a class="btn btn-success btn-mac" id="expence-filters"><i class="mdi mdi-magnify"></i> Search</a>
                <a class="btn btn-success btn-mac" onclick="PrinExpensesWindow()" title="Click here to print"><i class="mdi mdi-printer"></i> Print</a>
              </div> 
              <div class="col-lg-12">
                <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="advance-search-main">
                          <form>
                            <div class="row advance-search-row">
                              <div class="col-md-2 no-side-padding-first">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input  type="text" id="voucher_no_adsr" name="voucher_no_adsr" class="form-control" placeholder="Voucher No." />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="" name="" class="form-control" placeholder="" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <select class="form-control set-drop" id="paid_from_adsr">
                                              <option value="">Paid From</option>
                    <?php 
                                                $account_data = $db->get('account');
                                                foreach ($account_data as $ac_data) {
                                                    
                                                  $account_id = $ac_data['id'];
                                                  $acc_account_name = $ac_data['name'];
                                                  $acc_bank = $ac_data['bank_name'];
                                                  $acc_account_number = $ac_data['account_number'];
                                                  $acc_balance = $ac_data['balance'];
                                                  $Opening_balance = $ac_data['opening_balance'];


                                                  $cols=array("acc.account_number","trs.category","trs.amount",);

                                                  $db->where("acc.id", $account_id);

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
                                                 <option value="<?php echo $account_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                               <?php } ?>
                                              
                                          </select>
                                          
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <select class="form-control set-drop" id="expense_type_adsr" >
                                              <option value="">Exp. Type</option>
                                              <?php 
                                                $exp_data = $db->get('exp_type');
                                                foreach ($exp_data as $ex_da) {
                                                    
                                                  $expence_id = $ex_da['id'];
                                                  $expence_name = $ex_da['type_name'];
                                                  
                                                 ?>
                                                 <option value="<?php echo $expence_id; ?>"><?php echo $expence_name; ?></option>
                                               <?php } ?>
                                              
                                          </select>
                                          
                                      </div>
                                    </div>
                                  </div>
                              </div> 
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="amount_from_adsr" name="amount_from_adsr" class="form-control" placeholder="Amount From" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding-last">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="amount_to_adsr" name="amount_to_adsr" class="form-control" placeholder="Amount To" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row advance-search-row">
                              <div class="col-md-2 no-side-padding-first">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date From</label>
                                      <div class="input-group">
                                          <input type="date" id="date_from_adsr" name="date_from_adsr" class="form-control advance-input-padding" placeholder=""/>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date to</label>
                                      <div class="input-group">
                                          <input type="date" id="date_to_adsr" name="date_to_adsr" class="form-control advance-input-padding" placeholder=""/>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <label class="col-form-label advance-lable-padding no-mar-btm">Total Amount</label>
                                      <div class="input-group">
                                          <input type="text" id="total_amount_adsr" name="total_amount" class="form-control advance-input-padding" placeholder="" readonly="" value="<?php echo number_format($Total_exp_amount); ?>" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="order-listing" class="table table-striped">
                            <thead>
                              <tr>
                                  <th class="th-set text-center">Voucher No.</th>
                                  <th class="th-set text-center">Date</th>
                                  <th class="th-set text-center">Employee</th>
                                  <th class="th-set text-center">Exp. Type</th>
                                  <th class="th-set text-center">Exp. Detail</th>
                                  <th class="th-set text-center">Paid from</th>
                                  <th class="th-set text-center">Amount</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody class="table-body">
                                      
                                <?php
                                    $expensesdata = $db->get("expenses");
                                    foreach ($expensesdata as $expenses) {
                                    $expense_id = $expenses['id'];
                                    $encrypt = encode($expense_id);
                                    $exp_voucher = $expenses['voucher'];
                                    $client_id = $expenses['client_id'];
                                    $CliEncode = encode($client_id);
                                    $SalId = $expenses['salary_id'];
                                    $exp_name = $expenses['exp_type_name'];
                                    $exp_description = $expenses['description'];
                                    $exp_date = $expenses['exp_date'];
                                    $exp_acc_id = $expenses['account_id'];
                                    $AccEncode = encode($exp_acc_id);
                                    $exp_acc_num = $expenses['account_num'];
                                    $exp_amount = $expenses['amount'];
                                    $exp_type_id = $expenses['exp_type_id'];
                                    $ExpTyEncode = encode($exp_type_id);
                                    $exp_category = $expenses['category'];
                                    $db->where("id",$exp_type_id);
                                    $exp_typedata = $db->getOne("exp_type");
                                    $exp_type_name = ($exp_typedata && isset($exp_typedata['type_name'])) ? $exp_typedata['type_name'] : 'Unknown Type';


                                    $db->where("id",$exp_acc_id);
                                    $AccData = $db->getOne("account");
                                    $AccNumber = ($AccData && isset($AccData['account_number'])) ? $AccData['account_number'] : '';

                                    $db->where("id",$SalId);
                                    $SalaryData = $db->getOne("employee_salary");
                                    $EmplId = ($SalaryData && isset($SalaryData['employee_id'])) ? $SalaryData['employee_id'] : null;
                                    $EmplEncode = $EmplId ? encode($EmplId) : '';

                                    if ($EmplId) {
                                        $db->where("employee_id",$EmplId);
                                        $EmplData = $db->getOne("employee");
                                        $EmplName = ($EmplData && isset($EmplData['name'])) ? $EmplData['name'] : 'Unknown Employee';
                                    } else {
                                        $EmplName = '';
                                    }
                                    
                                    
                                    
                                ?>
                                <tr>
                                  <td class="td1-set text-center"><?php echo $exp_voucher;?></td>
                                  <td class="td1-set text-center"><?php echo date("d-m-Y", strtotime($exp_date)); ?></td>
                                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/employee-expenses.php'); echo '?emp_id='.$EmplEncode; ?>"><?php echo $EmplName;?></a></td>
                                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/type-wise-expenses.php'); echo '?type_id='.$ExpTyEncode; ?>"><?php echo $exp_type_name.'  '.'<span class="text-success"> '.'('.$exp_category.')'.'</span>'; ?></a></td>
                                  <td class="td1-set text-center wdt-st"><?php echo $exp_description; ?></td>
                                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/account-wise-expenses.php'); echo '?acc_id='.$AccEncode; ?>"><?php if ($AccNumber == '') { echo $exp_acc_num; }else{echo $AccNumber;  } ?></a></td>
                                  <td class="td1-set text-center"><?php echo number_format($exp_amount); ?></td>
                                  <td class="td1-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        
                                        <a class="dropdown-item" onclick="viewmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>
                                        
                                        
                                        <?php 
                                        $expenses_update=CheckPermission($permissions,'expenses_update');
                                        if($expenses_update == 1){ ?>
                                       <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>

                                        <?php } ?>
                                        
                                        <?php 
                                        $expenses_delete=CheckPermission($permissions,'expenses_delete');
                                        if($expenses_delete == 1){ ?>
                                       <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $expense_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>

                                        <?php } ?>
                                        
                                        
                                        
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Edit-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Expense 
                            <span id="nagative-zero" class="alert alert-warning">
                                Selected Account balance is negative or zero! 
                            </span>
                        </h5>
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
                          <!--<div id="inactive-alert" class="alert alert-danger inactive-alert">-->
                          <!--  Selected Account Is Inactive! -->
                          <!--</div>-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-file">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- View -->
                <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">View Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="view-expense-file">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>

          <?php } else{
        echo "<h2 class='text-danger'>You Don't have permission to use this page contact with admin. Thank You</h2>";
        } ?>



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
      var view_per='<?php echo $accessReadExp; ?>';
      var edit_per='<?php echo $accessUpdateExp; ?>';
      var del_per='<?php echo $accessDeleteExp; ?>';

        function SetDataTable() {
      
      $('#order-listing').DataTable({
        "aLengthMenu": [
          [50, 100, 150, -1],
          [50, 100, 150, "All"]
        ],
        "iDisplayLength": 50,
        "language": {
          search: ""
        }
      });

      $('#order-listing').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
      });
      
        }
        var paid_from = '';
        var expense_type = '';

  
    $("#expence-filters").click(function(){

            var voucher_no=$("#voucher_no_adsr").val();

            // $("#paid_from_adsr").change(function(){
            // paid_from = $(this).children("option:selected").val();
            
            // });
            paid_from = $('#paid_from_adsr option:selected').val();
            // $("#expense_type_adsr").change(function(){
            // expense_type = $(this).children("option:selected").val();
             
            // });
            expense_type = $('#expense_type_adsr option:selected').val();
            
            var amount_from=$("#amount_from_adsr").val();
           
            var amount_to=$("#amount_to_adsr").val();
            
            var date_from=$("#date_from_adsr").val();
            
            var date_to=$("#date_to_adsr").val();
            


            $.ajax({
                type: "POST",
                url: "../../libraries/ajaxsearch.php",
                data: { 
                        view_permission:view_per,
                        edit_permission:edit_per,
                        delete_permission:del_per,
                        voucher_no:voucher_no,
                        paid_from:paid_from,
                        expense_type:expense_type,
                        amount_from:amount_from,
                        amount_to:amount_to,
                        date_from:date_from,
                        date_to:date_to,
                        action:'expense_search',
                        authkey:'dabdsjjI81sa'
                },
                cache: false,
                success: function(result){
                    
                    $(".table").remove();
                    $(".table-responsive").html(result);
                    
                    
                    
                }
                
                
                
            });
          
          
          
         
          
            
            
            
            
            
            
        
        
        });
  
  
    function myFunction(clicked_id) {
    var txt;
    var r = confirm(" Are you sure you want to delete this expense data ?");
    if (r == true) { 
    txt = "You pressed OK!";
    
    var stateID = clicked_id;
    
    
    window.location = "expence-management.php?id="+clicked_id; 
    
    } else {
    
    
    }
    
    }
    ///////view
    function viewmodal(id){
      $.ajax({
      type: "POST",
      url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
      data: {expense_id_view:id,action:'view_expense_modal',authkey:'dabdsjjI81sa'},
      cache: false,
      success: function(viewresult){
      $('.view-expense-file').html(viewresult);
      
      }
      });
    }
    //////////edit
    function editmodal(id){
      $.ajax({
      type: "POST",
      url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
      data: {expense_edit_id:id,action:'edit_expense_modal',authkey:'dabdsjjI81sa'},
      cache: false,
      success: function(result){
      $('.edit-file').html(result);
      autofetch();
      
      }
      });
    }
    function edit_expense(){
      $("#editexpense").submit(function(){
        var expense_idfield = $(".expense_idfield").val();
        var voucher_nofield = $(".voucher_nofield").val();
        var account_balance_old = $(".account_balance_old").val();
        var account_balance = $(".account_balance").val();
        var account_number = $(".account_number").val();
        var account_id_old = $(".account_id_old").val();
        var acc_id = $(".acc_num").val();
        var payment_datefield = $(".payment_datefield").val();
        var exp_type_id = $(".exp_type").val();
        var exp_type_name = $(".exp_type_name").val();
        var exp_des = $(".exp_des").val();
        var exp_amount_pre = $(".exp_amount_pre").val();
        var exp_amount = $(".exp_amount").val();
    
        var ary_expen= [];
    
        ary_expen.push({
    
           authkey:'dabdsjjI81sa',
           action:'edit_form_expense',
           expense_idfield:expense_idfield,
           voucher_nofield:voucher_nofield,
           account_balance_old:account_balance_old,
           account_balance:account_balance,
           account_number:account_number,
           account_id_old:account_id_old,
           acc_id:acc_id,
           payment_datefield:payment_datefield,
           exp_type_id:exp_type_id,
           exp_type_name:exp_type_name,
           exp_des:exp_des,
           exp_amount_pre:exp_amount_pre,
           exp_amount:exp_amount
      });
        // AJAX Code To Submit Form.
        $.ajax({
        type: "POST",
        url: "../../libraries/ajaxsubmit.php",
        data: {expense_edit_data:ary_expen},
        cache: false,
        success: function(result){
        $(".expense-success").html("<div class='alert alert-success' id='success' role='alert'>Expense Data Updated Successfully .</div>");
        $("#success").fadeTo(2500, 500).slideUp(500, function(){
        $("#success").slideUp(500);
        $("#success").remove();
        });
        }
        });
      return false;
    
      });
      }
  ///
    function autofetch(){
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
            //         $('#editexpense').trigger("reset");
               
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
  }

  ////////////////
  //////////////////////Print Invoices List/////////////////////////
  function PrinExpensesWindow(){

        var baseurl = '';
        var url = '';
        var voucher_no = '';
        var paid_from = '';
        var expense_type = '';
        var amount_from = '';
        var amount_to = '';
        var date_from = '';
        var date_to = '';

            voucher_no=$("#voucher_no_adsr").val();

            // $("#paid_from_adsr").change(function(){
            // paid_from = $(this).children("option:selected").val();
            
            // });
            paid_from = $('#paid_from_adsr option:selected').val();
            // $("#expense_type_adsr").change(function(){
            // expense_type = $(this).children("option:selected").val();
             
            // });
            expense_type = $('#expense_type_adsr option:selected').val();
            
            amount_from=$("#amount_from_adsr").val();
           
            amount_to=$("#amount_to_adsr").val();
            
            date_from=$("#date_from_adsr").val();
            
            date_to=$("#date_to_adsr").val();
        

        baseurl = '<?php echo baseurl('pages/company-register/print-expenses.php'); ?>';
        url = baseurl + '?voucher_no=' + voucher_no + '&paid_from=' + paid_from + '&expense_type=' + expense_type + '&amount_from=' + amount_from + '&amount_to=' + amount_to + '&date_from=' + date_from + '&date_to=' + date_to;

        window.open(url,'GoogleWindow', 'width=1366, height=768');
  }
  //////////////////////////////////////////////////////////////////
  //Open New Window
  function NewWindow(url){
    window.open(url,'GoogleWindow', 'width=1366, height=768');
  }
  function printWindow(url){
    window.open(url,'GoogleWindow', 'width=1366, height=768');
  }
</script>
</html>