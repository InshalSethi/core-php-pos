<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    $x=$_REQUEST['em'];
    $emp_id=decode($x);
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Edit Employee</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $UpdateEmployeeId = 26;

      $accessUpdateEmp = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $UpdateEmployeeId){
            $accessUpdateEmp =1;
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
                
                if( $_FILES['profile_img']['name'] =='' ){
                    
                    $ins_employee = array("name"=>$employee_name,"sr_name"=>$sr_name,"cnic"=>$cnic,"gender"=>$gender,"email"=>$email,"phon_no"=>$phone,"note"=>$note,"salary"=>$salary,"address"=>$address1,"dob"=>$dob,"qualification"=>$qualification,"last_update"=>$created_at);
                    
                } else{
                    
                    
                    if( $_FILES['profile_img']['name'] ) {
                        list($file_name,$error) = upload('profile_img','../../uploads/employee-images/','jpg,jpeg,gif,png');
                        if($error) print $error;
                    }
                    
                    $ins_employee = array("name"=>$employee_name,"sr_name"=>$sr_name,"cnic"=>$cnic,"gender"=>$gender,"email"=>$email,"phon_no"=>$phone,"note"=>$note,"salary"=>$salary,"address"=>$address1,"dob"=>$dob,"qualification"=>$qualification,"last_update"=>$created_at,"image"=>$file_name);
                }

                

                $db->where('employee_id',$emp_id);
                $db->update('employee',$ins_employee);

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
                
                //$ins_login=array("status"=>$status,"name"=>$user_name,"password"=>$password,"type"=>"employee","allow_login"=>$allow_login);
                $ins_login=array("role_id"=>$Role,"status"=>$status,"name"=>$user_name,"password"=>$password,"allow_login"=>$allow_login);
                $db->where('employee_id',$emp_id);
                


                
             
             
//Add empoyee data end here

               if ( $db->update('users_tbl',$ins_login) ){
                   echo "<div class='alert alert-success' id='success-alert' role='alert'>Data Updated successfully .</div>";
                } else{
                   echo "<div class='alert alert-danger' role='alert'>Alert! Data not Updated.</div>";
                }
                
              }
               ?>
            <?php if($accessUpdateEmp == 1){ ?>
            <div class="row">
              <div class="col-lg-12">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h5 class="text-dark mb-0">
                   Edit Empolyee
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
                    <?php  
                    $db->where('employee_id',$emp_id);
                    $emp_data = $db->getOne('employee');
                    
                    $db->where('employee_id',$emp_id);
                    $login_data = $db->getOne('users_tbl');

                    $RoleOldId = $login_data['role_id'];
                    ?>
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
                                            <input type="text" name="employee_name" class="form-control" required id="employeenamefield" placeholder="Employee Name" value="<?php echo $emp_data['name']; ?>" />
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
                                            <input type="text" name="cnic" class="form-control" id="cnicfield" placeholder="Employee CNIC" value="<?php echo $emp_data['cnic']; ?>" required/>
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
                                            <input type="text" name="sr_name" class="form-control" id="srnamefield" placeholder="Employee Sr Name" value="<?php echo $emp_data['sr_name']; ?>" />
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
                                            <input type="email" name="email" class="form-control" id="emailfield" placeholder="Employee Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required value="<?php echo $emp_data['email']; ?>" />
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
                                            <input type="text" name="address1" cols="2" rows="2" class="form-control" id="addressfield" placeholder="Employee Address" value="<?php echo $emp_data['address']; ?>" />
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
                                            <input type="date" name="dob" class="form-control" required id="dobfield" placeholder="Employee DOB" value="<?php echo $emp_data['dob']; ?>" />
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
                                            <input type="text" name="qualification" class="form-control" id="qualificationfield" placeholder="Enter Qualification" value="<?php echo $emp_data['qualification']; ?>" />
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
                                            <input type="text" name="phone" class="form-control" id="phonefield" placeholder="Enter Phone Number" value="<?php echo $emp_data['phon_no']; ?>"  />
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
                                            <input type="text" name="user_name" class="form-control" required id="usernamefield" placeholder="Enter User Name" value="<?php echo $login_data['name'];  ?>" />
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
                                            <input type="text" name="note" class="form-control" id="notefield" placeholder="Write Note" value="<?php echo $emp_data['note']; ?>" />
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
                                            <input type="text" name="salary" class="form-control" id="salaryfield" placeholder="Enter Salary" value="<?php echo $emp_data['salary']; ?>" />
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
                                            <input type="text" name="password" class="form-control" required id="passwordfield" placeholder="Employee Password" value="<?php echo $login_data['password'];  ?>" />
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
                                              <option value="<?php echo $RolID; ?>" <?php if($RolID == $RoleOldId){ echo 'selected';} ?>><?php echo $RolName; ?></option>
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
                                            <?php
                                            if( $emp_data['image'] != '' ){ ?>
                                            
                                            <img class="img-set" src="<?php echo baseurl('uploads/employee-images/'.$emp_data['image'].''); ?>" alt="Employee profile image"/>
                                            <?php
                                                
                                            } else{  ?>
                                            
                                            <img class="img-set" src="<?php echo baseurl('assets/images/people/user-avater.png'); ?>" alt="Employee profile image"/>
                                            
                                            
                                            <?php
                                                
                                            }
                                            ?>
                                            
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
                                              <input type="radio" class="form-check-input" id="gendermale" name="gender"  value="Male" <?php if($emp_data['gender']=='Male'){ echo "checked";} ?>  >Male
                                            </label>
                                          </div>
                                          <div class="form-check-inline">
                                            <label class="form-check-label" for="radio2">
                                              <input type="radio" class="form-check-input" id="genderfemale" name="gender" value="Female" <?php if($emp_data['gender']=='Female'){ echo "checked";} ?> >Female
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
                                                  <input type="checkbox" name="allow_login" class="form-check-input" id="allowloginfield" value="1" <?php if($login_data['allow_login']=='1'){ echo "checked";} ?> >
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
                                                  <input type="checkbox" name="status" class="form-check-input status" id="statusfield" value="1" <?php if($login_data['status']=='1'){ echo "checked";} ?> >
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
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
</script>
</html>