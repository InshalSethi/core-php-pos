      <style>
        .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator .count{
            position: absolute;
            left: 42%;
            width: 19px;
            height: 19px;
            border-radius: 100%;
            background: #f2125e;
            top: 0px;
            font-size: 11px;
        }
        .navbar .navbar-brand-wrapper .navbar-brand img{
            max-width: 65%;
            height: 50px;
        }
        .nv-pr-img{
            width: 50%!important;
            height: auto !important;
        }
        .pr-pad{
            padding:20px;
            border-bottom: 1px solid silver;
        }
        .no-hr-hit{
            height:200px;
        }
        .set-hr-hd{
            text-align: center;
            width: 100%;

        }
      </style>
      
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <button class="navbar-toggler navbar-toggler align-self-center set-plus-nav-outer" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <?php  $type = $_SESSION['user_type']; 
            if ($type == 'master') { ?>
        <!--<a class="navbar-brand brand-logo" href="<?php echo baseurl('index.php');?>"><img src="<?php echo baseurl('assets/images/mac-logo.png');?>" alt="logo"/></a>-->
        <a class="navbar-brand brand-logo-mini" href="<?php echo baseurl('index.php');?>"><img src="<?php echo baseurl('assets/images/logo-mini.svg');?>" alt="logo"/></a>
        <?php }elseif ($type == 'admin') { ?>
        <!--<a class="navbar-brand brand-logo" href="<?php echo baseurl('index-admin.php');?>"><img src="<?php echo baseurl('assets/images/mac-logo.png');?>" alt="logo"/></a>-->
        <a class="navbar-brand brand-logo-mini" href="<?php echo baseurl('index-admin.php');?>"><img src="<?php echo baseurl('assets/images/logo-mini.svg');?>" alt="logo"/></a>
        <?php }elseif ($type == 'user') { ?>
          <!--<a class="navbar-brand brand-logo" href="<?php echo baseurl('index-user.php');?>"><img src="<?php echo baseurl('assets/images/mac-logo.png');?>" alt="logo"/></a>-->
        <a class="navbar-brand brand-logo-mini" href="<?php echo baseurl('index-user.php');?>"><img src="<?php echo baseurl('assets/images/logo-mini.svg');?>" alt="logo"/></a>
        <?php } ?>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <!-- <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="search">
              <div class="input-group-append">
                <span class="input-group-text" id="search">
                  <i class="mdi mdi-magnify"></i>
                </span>
              </div>
            </div>
          </li> -->
        </ul>
        <ul class="navbar-nav navbar-nav-right"> 
        <li class="nav-item d-flex dropdown mr-1">
            <?php 
                $type = $_SESSION['user_type']; 
                $id = $_SESSION['login_id'];
                $db->where("id",$id);
                $user_data=$db->getOne("user_mac");
                $user_tbl_id = $user_data['id'];
                $employee_id = $user_data['employee_id'];
                $customer_id = $user_data['customer_id'];
                    
                $today_date_date=date('Y-m-d');
                $db->join("customers cus", "inv.customer_id=cus.customer_id", "INNER");
                $db->join("employee  emp", "inv.employee_id=emp.employee_id", "INNER");
                $db->join("work_status  wor_st", "inv.work_status=wor_st.id", "INNER");
                $db->where('inv.hearing_date', $today_date_date);
                $db->where ('inv.work_status', '8', "!=");
                $invoicedata = $db->get ("invoice inv", null, "inv.*,emp.name as emp_name,wor_st.name as work_st_name,cus.customer_name");
                $total_ntf=$db->count;
            ?>
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center set-notify" id="notificationDropdown" href="#" data-toggle="dropdown" aria-expanded="true">
              <i class="mdi mdi-bell-outline mx-0"></i>
            <span class="count"><?php echo $total_ntf; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header notification-top set-hr-hd">Today Hearings</p>
              
               <?php
               if($total_ntf > 0){
               foreach($invoicedata as $in_da){
                   if($in_da['employee_id'] == $employee_id && $type != 'employee'){
               ?>
               <a class="dropdown-item preview-item notification-section">
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">FileNo <?php echo $in_da['file_no']; ?> -  <?php echo $in_da['customer_name']; ?></h6>
                  <p class="font-weight-light small-text mb-0 text-muted">(<?php echo $in_da['service_name'] ?> - 	<?php echo $in_da['emp_name'] ?>)</p>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    <?php echo $newDate = date("d-m-Y", strtotime($in_da['hearing_date'])); ?> - <?php echo $in_da['work_st_name'];  echo '- '.$in_da['employee_id']; ?>
                  </p>
                </div>
               </a>
               <?php
               }elseif($in_da['employee_id'] == $employee_id && $type != 'master'){
                   ?>
                <a class="dropdown-item preview-item notification-section">
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-normal">FileNo <?php echo $in_da['file_no']; ?> -  <?php echo $in_da['customer_name']; ?></h6>
                      <p class="font-weight-light small-text mb-0 text-muted">(<?php echo $in_da['service_name'] ?> - 	<?php echo $in_da['emp_name'] ?>)</p>
                      <p class="font-weight-light small-text mb-0 text-muted">
                        <?php echo $newDate = date("d-m-Y", strtotime($in_da['hearing_date'])); ?> - <?php echo $in_da['work_st_name'];  echo '- '.$in_da['employee_id']; ?>
                      </p>
                    </div>
                </a>
                <?php }elseif($user_tbl_id == '1'){ ?>
                <a class="dropdown-item preview-item notification-section">
                    <div class="preview-item-content">
                      <h6 class="preview-subject font-weight-normal">FileNo <?php echo $in_da['file_no']; ?> -  <?php echo $in_da['customer_name']; ?></h6>
                      <p class="font-weight-light small-text mb-0 text-muted">(<?php echo $in_da['service_name'] ?> - 	<?php echo $in_da['emp_name'] ?>)</p>
                      <p class="font-weight-light small-text mb-0 text-muted">
                        <?php echo $newDate = date("d-m-Y", strtotime($in_da['hearing_date'])); ?> - <?php echo $in_da['work_st_name'];  echo '- '.$in_da['employee_id']; ?>
                      </p>
                    </div>
                </a>
                <?php   
                }
                else{ ?>
                <a class="dropdown-item preview-item notification-section no-hr-hit">
                    <div class="preview-item-content" style="width: 100%;">
                      <h6 class="preview-subject font-weight-normal text-center">No Hearing Yet For You...</h6>
                    </div>
                </a>
                <?php
                        }
                    }  
                }else{
                ?>
                <a class="dropdown-item preview-item notification-section no-hr-hit">
                <div class="preview-item-content" style="width: 100%;">
                  <h6 class="preview-subject font-weight-normal text-center">No Hearing Yet...</h6>
                </div>
               </a>
              <?php } ?>
            </div>
          </li>
          <li class="nav-item d-flex dropdown mr-1 set-plus-nav-outer dropdown1">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center set-plus-nav dropbtn" id="messageDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-plus mx-0"></i>
            </a>
            <div class="dropdown-menu1 dropdown-menu-right navbar-dropdown preview-list dropdown-content" aria-labelledby="messageDropdown">
              <div class="container-fluid>">
                  <div class="row">
                    <div class="col-md-4">
                        <a class="dropdown-item preview-item border-drop-plus drop-gead-fnt">
                          <div class="preview-item-content flex-grow drop-gead-fnt">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus drop-gead-fnt"><i class="mdi mdi-cash"></i> Income</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/invoice/add-invoice.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Invoice</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/customers/add-customer-only.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Client</p>
                          </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="dropdown-item preview-item border-drop-plus drop-gead-fnt">
                          <div class="preview-item-content flex-grow drop-gead-fnt">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus drop-gead-fnt"><i class="mdi mdi-cart"></i> Expense</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/company-register/add-expense.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Expense</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/company-register/add-journal.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Journal</p>
                          </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="dropdown-item preview-item border-drop-plus drop-gead-fnt">
                          <div class="preview-item-content flex-grow drop-gead-fnt">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus drop-gead-fnt"><i class="mdi mdi-bank"></i> Banking</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/banking/add-account.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Account</p>
                          </div>
                        </a>
                        <a class="dropdown-item preview-item" href="<?php echo baseurl('pages/banking/add-transfer.php');?>">
                          <div class="preview-item-content flex-grow">
                            <p class="font-weight-light small-text text-muted mb-0 font-set-plus">Transfer</p>
                          </div>
                        </a>
                    </div>
                  </div>
                </div>
            </div>
          </li>
          <!-- <li class="nav-item dropdown align-items-center d-lg-flex d-none ml-0 mr-3">
            <a class="dropdown-toggle btn btn-link btn-sm" href="#" data-toggle="dropdown" aria-expanded="false">
            <span class="nav-profile-name">Reports</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
              <a class="dropdown-item">
                <i class="mdi mdi-file-excel text-primary"></i>
                Excel
              </a>
              <a class="dropdown-item">
                <i class="mdi mdi-file-pdf text-primary"></i>
                Pdf
              </a>
            </div>
          </li> -->
          <li class="nav-item d-flex nav-profile dropdown set-plus-nav-outer">
            <a class="nav-link dropdown-toggle border px-1 py-1 set-plus-nav" href="#" data-toggle="dropdown" id="profileDropdown">
              <span class="nav-status-indicator"></span>
                <?php 
                    $type = $_SESSION['user_type']; 
                    $id = $_SESSION['login_id'];
                    $db->where("id",$id);
                    $user_data=$db->getOne("user_mac");
                    $employee_id = $user_data['employee_id'];
                    $customer_id = $user_data['customer_id'];
                    
                    
                        
                    $db->where("employee_id",$employee_id);
                    $emp_data=$db->getOne("employee");
                    $employee_name = $emp_data['name'];
                    $employee_email = $emp_data['email'];
                    $image = $emp_data['image'];
                    
                    if($image != ''){
                ?>
                <img src="<?php echo baseurl('uploads/employee-images/'.$image.''); ?>" alt="<?php echo $employee_name.' Profile Image'; ?>"/>
              <?php }else{ ?>
              <!--<img src="<?php echo baseurl('assets/images/people/9.jpg');?>" alt="profile"/>-->
              <img src="https://via.placeholder.com/30x30" alt="profile"/>
              <?php } ?>
              <span class="nav-profile-name">
              <?php
                    //echo $user_data['name'];
               ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <div class="profile-image text-center pr-pad">
                    <?php if($image != ''){
                ?>
                <img class="img-sm rounded-circle nv-pr-img" src="<?php echo baseurl('uploads/employee-images/'.$image.''); ?>" alt="<?php echo $employee_name.' Profile Image'; ?>"/>
                  <?php }else{ ?>
                  <img class="img-sm rounded-circle nv-pr-img" src="https://via.placeholder.com/25*25" alt="profile"/>
                  <?php } ?>
                  <p class="text-center" style="margin-bottom: 0px;"><?php if($employee_name != ''){ echo $employee_name;}else{ echo $user_data['name'];} ?></p>
                  <small class="text-center"><?php if($employee_email != ''){ echo $employee_email;}else{ echo 'No Email';} ?></small>
                </div>
              <a class="dropdown-item" href="<?php echo baseurl('change-password.php');?>">
                <i class="mdi mdi-settings text-primary"></i>
                Change Password
              </a>
              <a class="dropdown-item" href="<?php echo baseurl('logout.php');?>">
                <i class="mdi mdi-logout text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    
    