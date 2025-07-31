<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';

    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {

    //Get Salary Id to delete data from expense table

    $db->where("employee_id",$x);
    $SalaryData = $db->get('employee_salary');
    foreach ($SalaryData as $Salary) {
      $SalaryId = $Salary['id'];

      $db->where("salary_id",$SalaryId);
      $ExpenseData = $db->getOne("expenses");
      $ExpenseId = $ExpenseData['id'];

      //Delete From Transactions
      $db->where("salary_id",$SalaryId);
      $db->delete('transactions');

      //For JV And Meta Deletion 
      $db->where("expense_id",$ExpenseId);
      $JVData = $db->getOne("journal_tbl");
      $JVId = $JVData['j_id'];

      //Delete From Journal Meta table
      $db->where("j_id",$JVId);
      $db->delete('journal_meta');

      //Delete From JV Table
      $db->where("expense_id",$ExpenseId);
      $db->where("j_id",$JVId);
      $db->delete('journal_tbl');

      //Delete from expenses table

      $db->where("salary_id",$SalaryId);
      $db->delete('expenses');
    }

    $db->where("employee_id",$x);
    $db->delete('employee_salary');

    $db->where("employee_id",$x);
    $db->delete('employee');

    $db->where("employee_id",$x);
    $db->delete('users_tbl');
    ?>
<script>
  window.location.href="employee-list.php";
</script>
<?php
     }      
   }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Employees</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddEmployeeId = 24;
      $UpdateEmployeeId = 26;
      $DeleteEmployeeId = 27;

      $accessAddEmp = 0;
      $accessUpdateEmp = 0;
      $accessDeleteEmp = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddEmployeeId){
            $accessAddEmp =1;
          }
          if($UsrPer['permission_id'] == $UpdateEmployeeId){
            $accessUpdateEmp =1;
          }
          if($UsrPer['permission_id'] == $DeleteEmployeeId){
            $accessDeleteEmp =1;
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
                <h4 class="card-title">Employees</h4>
                <?php if($accessAddEmp == 1){ ?>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-employee.php'"><i class="mdi mdi-plus"></i> Add New</button>
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
                                  <th class="th-set text-center">SR#</th>
                                  <th class="th-set text-center">Name</th>
                                  <th class="th-set text-center">CNIC</th>
                                  <th class="th-set text-center">DOB</th>
                                  <th class="th-set text-center">Qualification</th>
                                  <th class="th-set text-center">Email</th>
                                  <th class="th-set text-center">Phone No.</th>
                                  <th class="th-set text-center">Role</th>
                                  <th class="th-set text-center">Status</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $e = 1; 
                              $employeeData = $db->get("employee");
                                foreach ($employeeData as $employee) {
                                  $id = $employee['employee_id'];
                                  $encrypt = encode($id);
                                  $name = $employee['name'];
                                  $cnic = $employee['cnic'];
                                  $dob = $employee['dob'];
                                  $qualification = $employee['qualification'];
                                  $email = $employee['email'];
                                  $phon_no = $employee['phon_no'];

                                  $db->where("employee_id",$id);
                                  $employeeuserData = $db->getOne("users_tbl");
                                  $RoleId = $employeeuserData['role_id'];
                                  $status = $employeeuserData['status'];

                                  $db->where("id",$RoleId);
                                  $RolesData = $db->getOne("roles");
                                  $RoleName = $RolesData['name'];
                              ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $e; ?></td>
                                  <td class="td-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/employee-expenses.php'); echo '?emp_id='.$encrypt; ?>"><?php echo $name; ?></a></td>
                                  <td class="td-set text-center"><?php echo $cnic; ?></td>
                                  <td class="td-set text-center"><?php echo date("d-m-Y", strtotime($dob)); ?></td>
                                  <td class="td-set text-center"><?php echo $qualification; ?></td>
                                  <td class="td-set text-center"><?php echo $email; ?></td>
                                  <td class="td-set text-center"><?php echo $phon_no; ?></td>
                                  <td class="td-set text-center">
                                     <button type="button" class="mac-badge"><?php echo $RoleName; ?></button> 
                                  </td>
                                  <td class="td-set text-center">
                                    <?php if ($status=='1') { ?>
                                    <button type="button" class="mac-badge">Active</button>
                                    <?php }elseif($status=='0'){ ?>
                                    <button type="button" class="mac-badge-inactive">Inactive</button>
                                    <?php } ?>
                                  </td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        
                                        <?php if($accessUpdateEmp == 1){ ?>
                                        <a class="dropdown-item" href="edit-employee.php?em=<?php echo $encrypt; ?>"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteEmp == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $e++; } ?>
                            </tbody>
                          </table>
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
var r = confirm(" Are you sure you want to delete this Employee data ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;


window.location = "employee-list.php?id="+clicked_id; 

} else {


}

}
</script>
</html>