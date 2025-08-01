<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';



    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | Print Expenses List</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" media="print" href="<?php echo baseurl('assets/css/vertical-layout-light/exp-print-list.css');?>">
    <link rel="stylesheet" media="screen" href="<?php echo baseurl('assets/css/vertical-layout-light/exp-screen-list.css');?>">
  </head>
  <style>
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
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
      <div class="noprint">
        <?php //include '../../libraries/nav.php'; ?>
      </div>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
      <div class="noprint">
        <?php //include '../../libraries/sidebar.php'; ?>
      </div>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row noprint set-mr-btm">
              <div class="col-md-12">
                <button onclick="myFunction()" class="btn btn-success btn-mac"><i class="mdi mdi-printer"></i> Print</button>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 head"></div>
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="invoice-heading">
                      <h1 class="text-center black-color">Expenses</h1>
                      <p class="black-color">
                        <span class="bold">Filtered By:</span>
                        <?php if ( isset($_REQUEST['voucher_no'])  && $_REQUEST['voucher_no'] != '' ) { ?>
                        <span>Voucher No. </span>
                        <span><?php echo $_REQUEST['voucher_no']; ?>, </span>
                        <?php }?>
                        <?php if ( isset($_REQUEST['paid_from'])  && $_REQUEST['paid_from'] != '' ) { ?>
                        <span>Paid From: </span>
                        <span><?php
                        $db->where("id",$_REQUEST['paid_from']);
                        $AccData = $db->getOne("account");
                        $AccountNumber = $AccData['account_number'];
                         echo $AccountNumber; 
                         ?>, </span>
                        <?php }?>
                        <?php if ( isset($_REQUEST['expense_type'])  && $_REQUEST['expense_type'] != '' ) { ?>
                        <span>Exp. Type: </span>
                        <span><?php
                        $db->where("id",$_REQUEST['expense_type']);
                        $ExpTypeData = $db->getOne("exp_type");
                        $TypName = $ExpTypeData['type_name'];
                         echo $TypName; 
                         ?>, </span>
                        <?php }?>
                        <?php if ( $_REQUEST['amount_from'] != '' &&  $_REQUEST['amount_to'] != ''  ) { ?>
                        <span>Amount From: </span>
                        <span><?php echo number_format($_REQUEST['amount_from']); ?>, </span>
                        <span>Amount To: </span>
                        <span><?php echo number_format($_REQUEST['amount_to']); ?>, </span>
                        <?php }?>
                        <?php if ( $_REQUEST['date_from'] != '' &&  $_REQUEST['date_to'] != ''  ) { ?>
                        <span>Date From: </span>
                        <span><?php echo date("d-m-Y", strtotime($_REQUEST['date_from'])); ?>, </span>
                        <span>Date To: </span>
                        <span><?php echo date("d-m-Y", strtotime($_REQUEST['date_to'])); ?>, </span>
                        <?php }?>
                      </p>
                    </div>
                    <div class="customer-basic">

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="set-padd text-center tbl-head bold">Voucher No.</td>
                              <td class="set-padd text-center tbl-head bold">Date</td>
                              <td class="set-padd text-center tbl-head bold">Client</td>
                              <td class="set-padd text-center tbl-head bold">Employee</td>
                              <td class="set-padd text-center tbl-head bold">Exp. Type</td>
                              <td class="set-padd text-center tbl-head bold">Details</td>
                              <td class="set-padd text-center tbl-head bold">Paid From</td>
                              <td class="set-padd text-center tbl-head bold">Amount</td>
                            </tr>
<?php 

          if( $_REQUEST['voucher_no'] != '' ){
                $db->where('voucher',$_REQUEST['voucher_no']);
            }
            if( $_REQUEST['paid_from'] != '' ){
                $db->where('account_id',$_REQUEST['paid_from']);
            }
            if( $_REQUEST['expense_type'] != '' ){
                $db->where('exp_type_id',$_REQUEST['expense_type']);
            }
            if( $_REQUEST['amount_from'] != '' &&  $_REQUEST['amount_to'] != '' ){
                
                $am_from=$_REQUEST['amount_from'];
                $am_to=$_REQUEST['amount_to'];
                $db->where ("amount BETWEEN ".$am_from." AND ".$am_to."  ");
                
            }
            if( $_REQUEST['date_from'] != '' &&  $_REQUEST['date_to'] != '' ){
                
                $date_from=$_REQUEST['date_from'];
                $date_to=$_REQUEST['date_to'];
                $db->where('exp_date', Array ($date_from, $date_to ), 'BETWEEN');
            }
            $Total_exp_amount = 0;
            $count = 0;
            $expensesValdata = $db->get("expenses");
            foreach ($expensesValdata as $expensesVal) {
              $Total_exp_amount += $expensesVal['amount'];
              $count++;
            }

            if( $_REQUEST['voucher_no'] != '' ){
                $db->where('voucher',$_REQUEST['voucher_no']);
            }
            if( $_REQUEST['paid_from'] != '' ){
                $db->where('account_id',$_REQUEST['paid_from']);
            }
            if( $_REQUEST['expense_type'] != '' ){
                $db->where('exp_type_id',$_REQUEST['expense_type']);
            }
            if( $_REQUEST['amount_from'] != '' &&  $_REQUEST['amount_to'] != '' ){
                
                $am_from=$_REQUEST['amount_from'];
                $am_to=$_REQUEST['amount_to'];
                $db->where ("amount BETWEEN ".$am_from." AND ".$am_to."  ");
                
            }
            if( $_REQUEST['date_from'] != '' &&  $_REQUEST['date_to'] != '' ){
                
                $date_from=$_REQUEST['date_from'];
                $date_to=$_REQUEST['date_to'];
                $db->where('exp_date', Array ($date_from, $date_to ), 'BETWEEN');
            }
            $db->orderBy("id",'asc');
            $expensesdata = $db->get("expenses");

            foreach( $expensesdata as $expenses ){
                
                $expense_id = $expenses['id'];
                $encrypt = encode($expense_id);
                $exp_voucher = $expenses['voucher'];
                $client_id = $expenses['client_id'];
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
                $exp_type_name = ($exp_typedata && isset($exp_typedata['type_name'])) ? $exp_typedata['type_name'] : 'Unknown Type';

                $db->where("cus_id",$client_id);
                $customers = $db->getOne("tbl_customer");
                $customer_name = ($customers && isset($customers['cus_name'])) ? $customers['cus_name'] : 'Unknown Customer';

                $db->where("id",$SalId);
                $SalaryData = $db->getOne("employee_salary");
                $EmplId = ($SalaryData && isset($SalaryData['employee_id'])) ? $SalaryData['employee_id'] : null;

                if ($EmplId) {
                    $db->where("employee_id",$EmplId);
                    $EmplData = $db->getOne("employee");
                    $EmplName = ($EmplData && isset($EmplData['name'])) ? $EmplData['name'] : 'Unknown Employee';
                } else {
                    $EmplName = 'Unknown Employee';
                }
?>
                            <tr>
                              <td class="set-padd text-center tbl-con voucher-no"><?php  echo $exp_voucher;?></td>
                              <td class="set-padd text-center tbl-con date-dv"><?php echo date("d-m-Y", strtotime($exp_date));?></td>
                              <td class="set-padd text-center tbl-con cl-nm"><div class=""><?php echo $customer_name;?></div></td>
                              <td class="set-padd text-center tbl-con"><?php echo $EmplName;?></td>
                              <td class="set-padd text-center tbl-con typ-dv"><?php echo $exp_type_name.'  '.'<span class="text-success"> '.'('.$exp_category.')'.'</span>'; ?></td>
                              <td class="set-padd text-center tbl-con remark-dv"><?php echo $exp_description;?></td>
                              <td class="set-padd text-center tbl-con"><?php echo $exp_acc_num;?></td>
                              <td class="set-padd text-center tbl-con"><?php echo number_format($exp_amount);?></td>
                            </tr>
<?php  }  ?>
                            <tr>
                              <td class="set-padd text-center tbl-con bold" colspan="4"><?php echo 'Showing '.$count.' entries';?></td>
                              <td class="set-padd text-center tbl-con bold" colspan="3"><?php echo 'Total';?></td>
                              <td class="set-padd text-center tbl-con bold"><?php echo number_format($Total_exp_amount);?></td>
                            </tr>

                          </tbody>
                        </table>
<script>
  SetDataTable();
</script>
                      </div>
                      <?php 
                          $companydata = $db->getOne('company');
                          $company_name = $companydata['name']; 
                       ?>
                      <div class="fot-set">
                        <div class="inline">
                          <div class="pr-date">
                            <p class="no-mr-btm text-center black-color"><?php echo date("d-m-Y");?></p>
                            <p class="border-tp text-center black-color">Print Date</p>
                          </div>
                        </div>
                        <div class="inline flot-rt">
                          <div class="sign">
                            <p class="no-mr-btm white-clr">.</p>
                            <p class="border-tp text-center black-color"><?php echo $company_name; ?></p>
                          </div>
                        </div>
                        <!-- <div class="text-center">
                          <p class="black-color"><?php //echo $tag_line = $companydata['tag_line']; ?></p>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            
              
           
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
        <div class="noprint">
          <?php include '../../libraries/footer.php'; ?>
        </div>
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
function myFunction() {
    window.print();
}
</script>
</html>