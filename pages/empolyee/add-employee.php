<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Add Employee</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddEmployeeId = 24;

      $accessAddEmp = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddEmployeeId){
            $accessAddEmp =1;
          }
        }  
    ?>
  </head>
  <style>
  .img-ab{
        margin-top: 30px;
  }
  .img-set{
        border: 2px solid #6da252;
        border-radius:5px;
        width: 175px;
        box-shadow: 0 2px 2px 0 rgba(96, 97, 96, 0.14), 0 3px 1px -2px rgba(99, 105, 103, 0.2), 0 1px 5px 0 rgba(98, 107, 104, 0.12);
  }
  .file-up{
      width: 175px;
      padding: 0px!important;
      padding-top: 2px!important;
  }
  .pd-top{
    padding-top: 15px;
  }
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .inner{
          border: 1px solid #8080806b;
          padding: 10px;
          margin-bottom: 5px;
          border-radius: 5px;
    }
    .btm-mr{
      margin-bottom: 20px;
      text-align: center;
    }
    .white{
      color: white!important;
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
            <?php 
              if(isset($_POST['add-employee'])){
                // Add employee Data

                $employee_name = $_POST['employee_name'];
                $sr_name = $_POST['sr_name'];
                $cnic = $_POST['cnic'];
                $email = $_POST['email'];
                $address1 = $_POST['address1'];
                $dob = $_POST['dob'];
                $qualification = $_POST['qualification'];
                $phone = $_POST['phone'];
                $note = $_POST['note'];
                $gender = $_POST['gender'];
                $salary = $_POST['salary'];
                $Role = $_POST['role'];
                $created_at = date("Y-m-d");

                if( $_FILES['profile_img']['name'] ) {
                    list($file_name,$error) = upload('profile_img','../../uploads/employee-images/','jpg,jpeg,gif,png');
                    if($error) print $error;
                }

                $ins_employee = array("name"=>$employee_name,"sr_name"=>$sr_name,"cnic"=>$cnic,"gender"=>$gender,"email"=>$email,"phon_no"=>$phone,"note"=>$note,"salary"=>$salary,"address"=>$address1,"dob"=>$dob,"qualification"=>$qualification,"created_at"=>$created_at,"image"=>$file_name);
                $last_in_id=$db->insert('employee',$ins_employee);

                $user_name = $_POST['user_name'];
                $password = $_POST['password'];
                $allow_login = $_POST['allow_login'];
                $status = $_POST['status'];
                
                if( $status == NULL){
                    $status=0;
                }
                if($allow_login == NULL){
                    $allow_login=0;
                }
                
                $ins_login=array("role_id"=>$Role,"employee_id"=>$last_in_id,"status"=>$status,"name"=>$user_name,"password"=>$password,"type"=>"employee","allow_login"=>$allow_login);
                $employee_id=$db->insert('users_tbl',$ins_login);


                
             
             
//Add empoyee data end here

               if (!empty($employee_id)){
                   echo "<div class='alert alert-success' id='success-alert' role='alert'>Data inserted successfully .</div>";
                } else{
                   echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                }
                ?>
                        <script> window.location.href="<?php echo baseurl('pages/empolyee/employee-list.php'); ?>";</script>
              <?php
              }
               ?>
            <?php if($accessAddEmp == 1){ ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h5 class="text-dark mb-0">
                   Add Empolyee
                  </h5>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="add-emp">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card card-border-color">
                  <div class="card-body">
                    <form id="addemployee" class="form-sample" action="" method="POST" enctype="multipart/form-data" style="width: 100%;">
                        <div class="row">
                            <div class="col-md-9">
                                  <!-- employee info Start -->
                                  <div class="row">
                                    <div class="col-md-8">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Employee Name</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-account-box"></i></span>
                                              </div>
                                            <input type="text" name="employee_name" class="form-control" required id="employeenamefield" placeholder="Employee Name" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">CNIC</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-numeric"></i></span>
                                              </div>
                                            <input type="text" name="cnic" class="form-control" id="cnicfield" placeholder="Employee CNIC" required/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-8">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">S/O, D/O, W/O</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-account-circle"></i></span>
                                              </div>
                                            <input type="text" name="sr_name" class="form-control" id="srnamefield" placeholder="Employee Sr Name" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Email</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-email"></i></span>
                                              </div>
                                            <input type="email" name="email" class="form-control" id="emailfield" placeholder="Employee Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-8">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Address</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-home-map-marker"></i></span>
                                              </div>
                                            <input type="text" name="address1" cols="2" rows="2" class="form-control" id="addressfield" placeholder="Employee Address" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">DOB</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-calendar"></i></span>
                                              </div>
                                            <input type="date" name="dob" class="form-control" required id="dobfield" placeholder="Employee DOB" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Qualification</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-buffer"></i></span>
                                              </div>
                                            <input type="text" name="qualification" class="form-control" id="qualificationfield" placeholder="Enter Qualification" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Phone Number</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-cellphone"></i></span>
                                              </div>
                                            <input type="text" name="phone" class="form-control" id="phonefield" placeholder="Enter Phone Number" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">User Name</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                              </div>
                                            <input type="text" name="user_name" class="form-control" required id="usernamefield" placeholder="Enter User Name" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Note</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-clipboard-text"></i></span>
                                              </div>
                                            <input type="text" name="note" class="form-control" id="notefield" placeholder="Write Note" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Salary</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-square-inc-cash"></i></span>
                                              </div>
                                            <input type="text" name="salary" class="form-control" id="salaryfield" placeholder="Enter Salary" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Password</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-apps"></i></span>
                                              </div>
                                            <input type="text" name="password" class="form-control" required id="passwordfield" placeholder="Employee Password" />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Role</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text in-grp"><i class="mdi mdi-account-check"></i></span>
                                              </div>
                                            <select name="role" class="form-control" id="rolefield" required>
                                              <option value="">Select Role</option>
                                            <?php 
                                              $RolesData = $db->get("roles"); 
                                              foreach ($RolesData as $Roles) {
                                                $RolID = $Roles['id'];
                                                $RolName = $Roles['name'];
                                            ?>
                                              <option value="<?php echo $RolID; ?>"><?php echo $RolName; ?></option>
                                            <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="img-ab">
                                            <img class="img-set" src="<?php echo baseurl('assets/images/people/user-avater.png'); ?>" alt="Employee profile image"/>
                                            <input type="file" name="profile_img" id="profile_imgfield" class="file-up"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <div class="form-group row">
                                        <label class="col-form-label"></label>
                                          <div class="form-check-inline">
                                            <label class="form-check-label" for="radio1">
                                              <input type="radio" class="form-check-input" id="gendermale" name="gender" checked value="Male">Male
                                            </label>
                                          </div>
                                          <div class="form-check-inline">
                                            <label class="form-check-label" for="radio2">
                                              <input type="radio" class="form-check-input" id="genderfemale" name="gender" value="Female">Female
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12 set-check-col">
                                              <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                  Allow Login
                                                  <input type="checkbox" name="allow_login" class="form-check-input" id="allowloginfield" value="1">
                                                <i class="input-helper"></i></label>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12 set-check-col">
                                              <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                  Active
                                                  <input type="checkbox" name="status" class="form-check-input status" id="statusfield" value="1">
                                                <i class="input-helper"></i></label>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pd-top">
                                    <div class="col-md-12">
                                      <div class="" id="btnsuccess">
                                        <button type="submit" name="add-employee" class="btn btn-success btn-set btn-save-color" title="click here to save data" id="btnsuccess"><i class="mdi mdi-content-save">Save</i></button>
                                        <!--<button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>-->
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!-- user info end -->
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
    $(document).ready(function(){
//   $("#addemployee").submit(function(){
//   var employeenamefield = $("#employeenamefield").val();
//   var srnamefield = $("#srnamefield").val();
//   var dobfield = $("#dobfield").val();
//   var qualificationfield = $("#qualificationfield").val();
//   var usernamefield = $("#usernamefield").val();
//   var passwordfield = $("#passwordfield").val();
//   var cnicfield = $("#cnicfield").val();
//   var gendermale = $("#gendermale").val();
//   if ($('#gendermale').is(':checked')) {gendermale = 'Male'}else{gendermale = ''}
//   var genderfemale = $("#genderfemale").val();
//   if ($('#genderfemale').is(':checked')) {genderfemale = 'Female'}else{genderfemale = ''}
//   var phonefield = $("#phonefield").val();
//   var telephonefield = $("#telephonefield").val();
//   var emailfield = $("#emailfield").val();
//   var cityfield = $("#cityfield").val();
//   var disrtictfield = $("#disrtictfield").val();
//   var addressfield = $("#addressfield").val();
//   var statusyes = $("#q1").val();
//   if ($('#q1').is(':checked')) {statusyes = '1'}else{statusyes = ''}

//   var statusno = $("#q2").val();
//   if ($('#q2').is(':checked')) {statusno = '0'}else{statusno = ''}

//   var allowloginfield = $("#allowloginfield").val();
//   if ($('#allowloginfield').is(':checked')) {allowloginfield = '1'}else{allowloginfield = '0'}

//   var aremp= [];

//   aremp.push({

//       authkey:'dabdsjjI81sa',
//       action:'submit_form_employee',
//       employeenamefield:employeenamefield,
//       srnamefield:srnamefield,
//       dobfield:dobfield,
//       qualificationfield:qualificationfield,
//       usernamefield:usernamefield,
//       passwordfield:passwordfield,
//       cnicfield:cnicfield,
//       gendermale,gendermale,
//       genderfemale:genderfemale,
//       phonefield:phonefield,
//       telephonefield:telephonefield,
//       emailfield:emailfield,
//       cityfield:cityfield,
//       disrtictfield:disrtictfield,
//       addressfield:addressfield,
//       statusyes:statusyes,
//       statusno:statusno,
//       allowloginfield:allowloginfield


//   });
//   // AJAX Code To Submit Form.
//   $.ajax({
//   type: "POST",
//   url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
//   data: {employeedata:aremp},
//   cache: false,
//   success: function(result){
//   $("#btnsuccess").fadeTo(200, 500).slideUp(500, function(){
//   $("#btnsuccess").slideUp(500);
//   $("#btnsuccess").remove();
//   });
//   $(".add-emp").append("<div class='alert alert-success' id='success' role='alert'>Employee data inserted successfully .</div>");
//   }
//   });
//   return false;
//   });
});
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
  </script>
</html>