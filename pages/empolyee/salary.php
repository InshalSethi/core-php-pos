<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';

    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {

    $db->where("salary_id",$x);
    $exp_data = $db->getOne('expenses');
    $Exp_id = $exp_data['id'];

    //Fetch Data from Journal_table to get J_Id for Journal_meta table

    $db->where("expense_id",$Exp_id);
    $JvOldDataCli = $db->getOne("journal_tbl");
    $JIdCli = $JvOldDataCli['j_id'];

    //Delete this entry from JV Table
    $db->where("j_id",$JIdCli);
    $db->delete('journal_meta');

    //Delete this entry from JV Table
    $db->where("expense_id",$x);
    $db->where("j_id",$JIdCli);
    $db->delete('journal_tbl');

    $db->where("id",$x);
    $employee_salary_data = $db->getOne('employee_salary');
    $acc_id = $employee_salary_data['account_id'];
    $salary_paid = $employee_salary_data['salary_paid'];

    $db->where("id",$acc_id);
    $account_data = $db->getOne('account');
    $balance = $account_data['balance'];

    $new_balance = $balance + $salary_paid;

    $up_acc = array("balance"=>$new_balance);
    $db->where("id",$acc_id);
    $account_updated = $db->update("account",$up_acc);
     

    $db->where("salary_id",$x);
    $db->delete('transactions');

    $db->where("salary_id",$x);
    $db->delete('expenses');

    $db->where("id",$x);
    $db->delete('employee_salary');
    ?>
<script>
  window.location.href="salary.php";
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
    <title>MAC | Salary</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddSalaryId = 28;
      $ReadSalaryId = 29;
      $UpdateSalaryId = 30;
      $DeleteSalaryId = 31;

      $accessAddSal = 0;
      $accessReadSal = 0;
      $accessUpdateSal = 0;
      $accessDeleteSal = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddSalaryId){
            $accessAddSal =1;
          }
          if($UsrPer['permission_id'] == $ReadSalaryId){
            $accessReadSal =1;
          }
          if($UsrPer['permission_id'] == $UpdateSalaryId){
            $accessUpdateSal =1;
          }
          if($UsrPer['permission_id'] == $DeleteSalaryId){
            $accessDeleteSal =1;
          }
        }  
    ?>

  </head>
  <style>
  .text-cli{
    text-decoration: none;
    color: black;
    cursor: pointer;
  }
  .text-cli:hover{
    color: black;
  }
  #nagative-zero{
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
    .bold{
      font-weight: 600;
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
              <div class="col-lg-12 set-mr-btm">
                <h4 class="card-title">Employees Salary</h4>
                <?php if($accessAddSal == 1){ ?>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-salary.php'"><i class="mdi mdi-plus"></i> Add New</button>
                <?php } ?>
              </div> 
              <div class="col-lg-12">
                <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="order-listing" class="table table-striped">
                            <thead>
                              <tr>
                                  <th class="th-set text-center">V No.</th>
                                  <th class="th-set text-center">Date</th>
                                  <th class="th-set text-center">Employee</th>
                                  <th class="th-set text-center">Ph#</th>
                                  <th class="th-set text-center">Paid From A/C</th>
                                  <th class="th-set text-center">Description</th>
                                  <th class="th-set text-center">Salary</th>
                                  <th class="th-set text-center">Paid</th>
                                  <th class="th-set text-center">Balance</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $TotalPaid = 0;
                              $TotalBalance = 0;
                              $salaryData = $db->get("employee_salary");
                                foreach ($salaryData as $salary) {
                                  $sal_id = $salary['id'];
                                  $encrypt = encode($sal_id);
                                  $employee_id = $salary['employee_id'];
                                  $EmplEncode = encode($employee_id);

                                  $db->where("employee_id",$employee_id);
                                  $employeeData = $db->getOne("employee");
                                  $Empname = $employeeData['name'];

                                  $employee_name = $salary['employee_name'];
                                  $voucher_no = $salary['voucher_no'];
                                  $date = $salary['date'];
                                  $salary_amount = $salary['salary_amount'];
                                  $account_id = $salary['account_id'];
                                  $detail = $salary['detail'];
                                  $salary_paid = $salary['salary_paid'];
                                  $TotalPaid += $salary['salary_paid'];
                                  $balance = $salary['balance'];
                                  $TotalBalance += $salary['balance'];
                                  $db->where("employee_id",$employee_id);
                                  $employeData = $db->getOne("employee");
                                  $phon_no = $employeData['phon_no'];

                                  $db->where("id",$account_id);
                                  $accountData = $db->getOne("account");
                                  $account_number = $accountData['account_number'];
                              ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $voucher_no; ?></td>
                                  <td class="td-set text-center"><?php echo date("d-m-Y", strtotime($date)); ?></td>
                                  <td class="td-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/employee-expenses.php'); echo '?emp_id='.$EmplEncode; ?>"><?php echo $Empname; ?></a></td>
                                  <td class="td-set text-center"><?php echo $phon_no; ?></td>
                                  <td class="td-set text-center"><?php echo $account_number; ?></td>
                                  <td class="td-set text-center"><?php echo $detail; ?></td>
                                  <td class="td-set text-center"><?php echo number_format($salary_amount); ?></td>
                                  <td class="td-set text-center"><?php echo number_format($salary_paid); ?></td>
                                  <td class="td-set text-center"><?php echo number_format($balance); ?></td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessReadSal == 1){ ?>
                                        <a class="dropdown-item" onclick="viewmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>
                                        <?php }if($accessUpdateSal == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteSal == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $sal_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php } ?>
                              <tr>
                                <td class="td-set text-center bold" colspan="7">Total</td>
                                <td class="td-set text-center bold"><?php echo number_format($TotalPaid); ?></td>
                                <td class="td-set text-center bold"><?php echo number_format($TotalBalance); ?></td>
                                <td class="td-set text-center bold"></td>
                              </tr>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Salary
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="salary-success">
                              
                          </div>
                        <div class="edit-salary">
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
                        <h5 class="modal-title" id="viewModalLabel">View Salary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="view-salary">
                          
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
function myFunction(clicked_id) {
var txt;
var r = confirm(" Are you sure you want to delete this Salary data ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;


window.location = "salary.php?id="+clicked_id; 

} else {


}

}
///////view
function viewmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {salary_id_view:id,action:'view_salary_modal',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(viewresult){
  $('.view-salary').html(viewresult);
  
  }
  });
}
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {salary_id_edit:id,action:'edit_salaryt_modal',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-salary').html(result);
  autofil();
  }
  });
}
function edit_salary(){
  $("#editsalaryform").submit(function(){
    var salary_idfield = $(".salary_idfield").val();
    var voucher_nofield = $(".voucher_nofield").val();
    var account_balance = $(".account_balance").val();
    var account_number = $(".account_number").val();
    var old_ac_id = $(".old_ac_id").val();
    var acc_id = $(".acc_id").val();
    var salary_datefield = $(".salary_datefield").val();
    var employee_id = $(".employee_id").val();
    var exp_type_name = $(".exp_type_name").val();
    var exp_type_id = $(".exp_type").val();
    var employee_name = $(".employee_name").val();
    var sal_des = $(".sal_des").val();
    var sal_amount = $(".emp_sal_amount").val();
    var sal_paid_old = $(".sal_paid_old").val();
    var sal_paid = $(".sal_paid").val();
    var sal_balance = $(".sal_balance").val();
    
    var ary_salary= [];

    ary_salary.push({

       authkey:'dabdsjjI81sa',
       actioneditsalary:'edit_form_salary',
       salary_idfield:salary_idfield,
       voucher_nofield:voucher_nofield,
       account_balance:account_balance,
       account_number:account_number,
       old_ac_id:old_ac_id,
       acc_id:acc_id,
       salary_datefield:salary_datefield,
       employee_id:employee_id,
       exp_type_name:exp_type_name,
       exp_type_id:exp_type_id,
       employee_name:employee_name,
       sal_des:sal_des,
       sal_amount:sal_amount,
       sal_paid_old:sal_paid_old,
       sal_paid:sal_paid,
       sal_balance:sal_balance
    


  });
    // AJAX Code To Submit Form.
    $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {salary_edit_data:ary_salary},
    cache: false,
    success: function(result){
    $(".salary-success").html("<div class='alert alert-success' id='success' role='alert'>Salary Data Updated Successfully .</div>");
    $("#success").fadeTo(2500, 500).slideUp(500, function(){
    $("#success").slideUp(500);
    $("#success").remove();
    });
    setTimeout(function(){
    $('#exampleModal').modal('toggle');
    }, 3500);
    }
    });
  return false;

  });
  }
  function autofil(){
      $('.acc_id').change(function() {
    var acc_num = $(".acc_id option:selected").val();
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
            if(check > 0){
             $('.account_balance').val(obj[0].balance);
             $('.account_number').val(obj[0].account_number);
            }else{
               $("#nagative-zero").show(); 
               setTimeout(function() {
                        $("#nagative-zero").hide();
                    }, 3500);
                    $('.addsalary').trigger("reset");
                    $('.emp').val('')
               
            }

            },
            complete:function(data){
              
              $(".no-loader").hide();
             },
            
        });
     },1000);
    }
  });
  
  $('.employee_id').change(function() {
    var employee_id = $(".employee_id option:selected").val();
    var paid = 0;
    var balance = 0;
    //alert(employee_id);
    if(employee_id) {
      $(".no-loader").show();
      setTimeout(function(){
        $.ajax({

            url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
            type: "POST",

            dataType: 'json',

            data: {employee_id:employee_id,action:'find_emp_sal',authkey:'dabdsjjI81sa'},

            success: function(result) { 

            var obj = JSON.parse(JSON.stringify(result)); 
            
             $('.employee_name').val(obj[0].name);
             $('.emp_sal_amount').val(obj[0].salary);
             $('.sal_paid').val(paid);
             $('.sal_balance').val(balance);
             

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
  ///
  $('.sal_paid').keyup(function() {
      var sal_paid = this.value;
      var sal_amount = $('.emp_sal_amount').val();
      if(sal_amount != ''){
      var balance = sal_amount - sal_paid;
      $('.sal_balance').val(balance);
      }
  });
  }
</script>
</html>