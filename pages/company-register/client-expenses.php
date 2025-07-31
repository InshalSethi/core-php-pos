<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';

    if (isset($_REQUEST['cu_id'])) {
    $x=$_REQUEST['cu_id'];
    $decode_client = decode($x);
    $db->where("customer_id",$decode_client);
    $clientsData = $db->getOne("customers");
    $cl_name = $clientsData['customer_name'];
    $cl_file_no = $clientsData['file_no'];
    $cl_ph_num = $clientsData['ph_num'];
    $cl_cell_num = $clientsData['cell_num'];
    $cl_cnic = $clientsData['cnic'];
    $cl_ntn_no = $clientsData['ntn_no'];
    $cl_strn_no = $clientsData['strn_no'];
    $cl_user_id = $clientsData['user_id'];
    $cl_user_password = $clientsData['user_password'];
    $cl_address = $clientsData['address'];
    $cl_contact_person = $clientsData['contact_person'];
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | <?php echo $cl_name.' Expenses'; ?></title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" href="<?php echo baseurl('assets/vendors/jquery-toast-plugin/jquery.toast.min.css');?>">
<style>
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
    /**/
  .inactive-cus{
      color: red;
  }
  .free-cus{
      color: blue;
  }
  .drop-set{
      margin-top: 1px;
      height: 31px;
  }
  .mr-btm{
      margin-bottom: 20px;
  }
  .brd-btm{
      border-bottom: 1px solid silver;
  }
  .fnt-h{
      font-size: 15px;
      font-weight: 500;
      color: black!important;
  }
  .fnt-c{
      font-size: 14px;
      color: #5d8fcc!important;
  }
  @media only screen and (min-width: 320px) and (max-width: 480px){
  .col4{
      padding-right: 15px!important;
  }
  .col8{
      padding-left: 15px!important;
  }
  }
  .col4{
      padding-right: 0px;
  }
  .col8{
      padding-left: 0px;
  }
  .set-card-body{
    padding-left: 5px!important;
    padding-right: 5px!important;
    padding-top: 20px!important;
    padding-bottom: 20px!important
  }
  .income-box{
    height: 100%;
    background: #00c0ef !important;
    text-align: center;
    font-size: 73px;
    color: white;
  }
  .expenses-box{
    height: 100%;
    background: #dd4b39 !important;
    text-align: center;
    font-size: 73px;
    color: white;
  }
  .profit-box{
    height: 100%;
    background: #6da252 !important;
    text-align: center;
    font-size: 73px;
    color: white;
  }
  .customers-box{
    height: 100%;
    background: #f39c12  !important;
    text-align: center;
    font-size: 73px;
    color: white;
  }
  .employees-box{
    height: 100%;
    background: #58aaaf !important;
    text-align: center;
    font-size: 73px;
    color: white;
  }
  .sm-bx-fn{
      font-size: 12px!important;
      font-weight: 500;
  }
  .sm-am-fn{
      font-size: 19px!important;
      font-weight: 500;
  }
  .pd-sd{
      padding-top: 10px;
      padding-bottom: 10px;
  }
  .pd-tp{
      padding-top: 0px!important;
  }
  .pd-bt{
      padding-bottom: 0px!important;
  }
  .th-pd{
      padding-top: 5px!important;
      padding-bottom: 5px!important;
      padding-left:3px!important;
      padding-right:3px!important;
  }
  .td-pd{
      padding-top: 3px!important;
      padding-bottom: 3px!important;
      padding-left:2px!important;
      padding-right:2px!important;
  }
  .pd-st{
      padding-bottom: 1px;
      padding-top: 1px;

  }
  .min-ht{
      min-height: 200px;
  }
  .tra-pd{
      padding:10px;
  }
  .no-mr-bt{
      margin-bottom:0px!important;
  }
  .no-sd-pad{
      padding-left: 5px!important;
      padding-right: 5px!important;
  }
  .td-date{
      width:85px;
  }
</style>

  </head>
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
                        <div class="col-lg-12 set-mr-btm">
                            <h4 class="card-title"><?php echo $cl_file_no.'-'.$cl_name; ?></h4>
                        </div> 
                        <div class="col-lg-2">
                            <div class="card card-border-color mr-btm">
                                
                                <div class="col-lg-12 pd-sd brd-btm">
                                  <div class="d-lg-flex align-items-baseline">
                                    <h5 class="text-dark mb-0">Profile</h5>
                                  </div>
                                </div>
                                <div class="card-body pd-tp no-sd-pad">
                                    <div class="py-4 pd-tp pd-bt">
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            Cell
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_cell_num; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            Phone
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_ph_num; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            CNIC
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_cnic; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            NTN
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_ntn_no; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            STRN
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_strn_no; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            Address
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_address; ?>
                                          </span>
                                        </p>
                                        <p class="clearfix brd-btm pd-st">
                                          <span class="float-left fnt-h">
                                            Contact Person
                                          </span><br>
                                          <span class="text-muted fnt-c">
                                            <?php echo $cl_contact_person; ?>
                                          </span>
                                        </p>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="row">
<?php
  $db->where("client_id",$decode_client);
  $expensesdata = $db->get("expenses");
  $TotalExpense = 0;
  foreach ($expensesdata as $expenses) {
  $exp_amount = $expenses['amount']; 
  $TotalExpense +=$exp_amount; 
  } 
  
?>
                                <div class="col-12 col-sm-6 col-md-6 col-xl-4 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="row">
                                        <div class="col-md-4 col4">
                                          <div class="expenses-box">
                                            <i class="mdi mdi-cart"></i>
                                          </div>
                                        </div>
                                        <div class="col-md-8 col8">
                                            <div class="card-body set-card-body">
                                            <h4 class="card-title sm-bx-fn">Total Expense</h4>
                                            <div class="d-flex justify-content-between">
                                              <p class="text-dark sm-am-fn">Rs <?php echo number_format($TotalExpense); ?> </p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-border-color mr-btm min-ht" style="width: 100%;">
                                        <h4 class="card-title tra-pd no-mr-bt">Expenses</h4>
                                        <div class="card-body pd-tp pd-bt">
                                            <div class="table-responsive min-ht">
                                                <table id="order-listing" class="table table-striped">
                                                  <thead>
                                                    <tr>
                                                      <th class="text-center th-pd">Voucher No.</th>
                                                      <th class="text-center th-pd">Date</th>
                                                      <th class="text-center th-pd">Exp. Type</th>
                                                      <th class="text-center th-pd">Exp. Detail</th>
                                                      <th class="text-center th-pd">Paid from</th>
                                                      <th class="text-center th-pd">Amount</th>
                                                    </tr>
                                                  </thead>

                                                  <tbody class="table-body">
<?php
  $db->where("client_id",$decode_client);
  $expensesdata = $db->get("expenses");
  foreach ($expensesdata as $expenses) {
  $expense_id = $expenses['id'];
  $encrypt = encode($expense_id);
  $exp_voucher = $expenses['voucher'];
  $SalId = $expenses['salary_id'];
  $exp_name = $expenses['exp_type_name'];
  $exp_description = $expenses['description'];
  $exp_date = $expenses['exp_date'];
  $exp_acc_id = $expenses['account_id'];
  $exp_acc_num = $expenses['account_num'];
  $exp_amount = $expenses['amount'];
  $exp_type_id = $expenses['exp_type_id'];
  $exp_category = $expenses['category'];
  $db->where("id",$exp_type_id);
  $exp_typedata = $db->getOne("exp_type");
  $exp_type_name = $exp_typedata['type_name'];

  $db->where("id",$exp_acc_id);
  $AccData = $db->getOne("account");
  $AccNumber = $AccData['account_number'];

  $db->where("id",$SalId);
  $SalaryData = $db->getOne("employee_salary");
  $EmplId = $SalaryData['employee_id'];

  $db->where("employee_id",$EmplId);
  $EmplData = $db->getOne("employee");
  $EmplName = $EmplData['name'];
  
  
  
?>
                                                    <tr>
                                                      <td class="text-center td-pd"><?php echo $exp_voucher; ?></td>
                                                      <td class="text-center td-pd td-date"><?php echo $newDate = date("d-m-Y", strtotime($exp_date)); ?></td>
                                                      <td class="text-center td-pd"><?php echo $exp_type_name.'  '.'<span class="text-success"> '.'('.$exp_category.')'.'</span>'; ?></td>
                                                      <td class="text-center td-pd"><?php echo $exp_description; ?></td>
                                                      <td class="text-center td-pd"><?php if ($AccNumber == '') { echo $exp_acc_num; }else{echo $AccNumber;  } ?></td>
                                                      <td class="text-center td-pd"><?php echo number_format($exp_amount); ?></td>
                                                    </tr>
<?php  }  ?>
                                                  </tbody>
                                                </table>
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
    </div>
    <!-- base:js -->
    <?php include '../../libraries/js_libs.php'; ?>
    <script src="<?php echo baseurl('assets/vendors/jquery-toast-plugin/jquery.toast.min.js'); ?>"></script>
    <script src="<?php echo baseurl('libraries/add_new_partner.js'); ?>"></script>

  </body>
</html>