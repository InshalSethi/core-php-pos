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

        @media(min-width: 992px) and (max-width: 1600px){

          .no-dis-big{

            display: none;

        }

    }
    th{
        text-align: center;
    }
    td{
        text-align: center;
    }

</style>



<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">

    <button class="navbar-toggler navbar-toggler align-self-center set-plus-nav-outer no-dis-big" type="button" data-toggle="minimize">

      <span class="mdi mdi-menu"></span>

  </button>

  <?php  







  $companydata = $db->getOne('company');

  $name = $companydata['name'];

  $contact = $companydata['contact'];

  $image = $companydata['image'];

  if($image != ''){

    ?>

    <a class="navbar-brand brand-logo" href="<?php echo baseurl('index.php');?>"><img src="<?php echo baseurl('assets/images/'); echo $image; ?>" alt="<?php echo $name.' Logo'; ?>"/></a>

<?php }else{ ?>

    <a class="navbar-brand brand-logo-mini" href="<?php echo baseurl('index.php');?>"><img src="https://via.placeholder.com/25*25" alt="logo"/></a>

<?php } 

$type = $_SESSION['user_type']; 

$id = $_SESSION['login_id'];

$db->where("id",$id);

$user_data=$db->getOne("users_tbl");

$employee_id = $user_data['employee_id'];

$LoginDate = $_SESSION['LastLoginDate'];

$LoginTime = $_SESSION['LastLoginTime'];







$db->where("employee_id",$employee_id);

$emp_data=$db->getOne("employee");

$employee_name = $emp_data['name'];

$employee_email = $emp_data['email'];

$image = $emp_data['image'];

?>

<div class="nv-cus">

  <h3 class="com-nv com-mn"><?php  echo $name; ?></h3>

  <h3 class="com-nv com-sub"><?php  echo $contact; ?></h3>

</div>

</div>

<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    <div class="no-dis">

      <p class="wel-txt-big">Asalam-O-Alaikum - <?php if($employee_name != ''){ echo $employee_name;}else{ echo $user_data['name'];} ?></p>

      <p class="wel-txt-sm">Last login: <?php echo $LoginDate.' '.$LoginTime; ?></p>

  </div>

  <ul class="navbar-nav navbar-nav-right"> 

    <li class="nav-item d-flex dropdown mr-1 set-plus-nav-outer dropdown1">

      <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center set-plus-nav dropbtn" id="messageDropdown" href="<?php echo baseurl('index.php'); ?>">

        <i class="mdi mdi-home mx-0 nv-ic"></i>

    </a>

</li>

<li class="nav-item d-flex dropdown mr-1">

    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center set-notify" id="notificationDropdown" href="#" data-toggle="dropdown" aria-expanded="true">

      <i class="mdi mdi-bell-outline mx-0 nv-ic"></i>

      <span class="count"><?php echo '0'; ?></span>

  </a>

  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">

      <p class="mb-0 font-weight-normal float-left dropdown-header notification-top set-hr-hd">Notifications</p>

      <div class="scroll">

        <a class="dropdown-item preview-item notification-section no-hr-hit">

            <div class="preview-item-content" style="width: 100%;">

              <h6 class="preview-subject font-weight-normal text-center">No Notifications Yet...</h6>

          </div>

      </a>

  </div>

</div>

</li>

<li class="nav-item d-flex dropdown mr-1 set-plus-nav-outer dropdown1">

    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center set-plus-nav dropbtn" id="messageDropdown" href="#" data-toggle="dropdown">

      <i class="mdi mdi-plus mx-0 nv-ic"></i>

  </a>

  <div class="dropdown-menu1 dropdown-menu-right navbar-dropdown preview-list dropdown-content" aria-labelledby="messageDropdown">

      <div class="container-fluid>">

          <div class="row shortcuts px-4">



            <?php 
            $add_ws_invoice=CheckPermission($permissions,'add_ws_invoice');
            if($add_ws_invoice == 1){ ?>
                <a href="<?php echo baseurl('pages/invoices/add-invoice-wp.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="no-m-r mdi mdi-note-text"></i>
                    </span>
                    <small class="text-info">WS Invoice</small>
                </a>

                <?php

            }

            ?>


            <?php 
            $add_ws_return=CheckPermission($permissions,'add_ws_return');
            if($add_ws_return == 1){ ?>
                <a href="<?php echo baseurl('pages/invoices/add-wp-return.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                        <i class="no-m-r mdi mdi-arrow-bottom-left"></i>
                    </span>
                    <small class="text-danger">WS Return </small>
                </a>

                <?php

            }

            ?>

            <?php 
            $add_rp_invoice=CheckPermission($permissions,'add_rp_invoice');
            if($add_rp_invoice == 1){ ?>
                <a href="<?php echo baseurl('pages/invoices/add-invoice-rp.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="no-m-r mdi  mdi-note-plus-outline"></i>
                    </span>
                    <small class="text-info">RP Invoice</small>
                </a>

                <?php

            }

            ?>


            <?php 
            $add_purchase_invoice=CheckPermission($permissions,'add_purchase_invoice');
            if($add_purchase_invoice == 1){ ?>
                <a href="<?php echo baseurl('pages/invoices/purchase-invoice.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                        <i class="no-m-r mdi  mdi-backburger"></i>
                    </span>
                    <small class="text-danger">Purchase Invoice</small>
                </a>

                <?php

            }

            ?>

            <?php 
            $add_purchase_return=CheckPermission($permissions,'add_purchase_return');
            if($add_purchase_return == 1){ ?>
                <a href="<?php echo baseurl('pages/invoices/purchase-return.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="no-m-r mdi mdi-cart-off"></i>
                    </span>
                    <small class="text-info">Purchase Return</small>
                </a>

                <?php

            }

            ?>



            <?php 
            $product_view=CheckPermission($permissions,'product_view');
            if($product_view == 1){ ?>

                <a href="<?php echo baseurl('pages/product/add-products.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="no-m-r mdi mdi-account"></i>
                    </span>
                    <small class="text-info">Product</small>
                </a>

                <?php
            }

            ?>


            <?php 
            $customer_view=CheckPermission($permissions,'customer_view');
            if($customer_view == 1){ ?>
                <a href="<?php echo baseurl('pages/customers/customer-list.php');?>" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="no-m-r mdi mdi-account"></i>
                    </span>
                    <small class="text-info">Customer</small>
                </a>

                <?php

            }

            ?>








                    <!-- <a href="<?php echo baseurl('pages/supplier/supplier-list.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">

                        <i class="no-m-r mdi mdi-account-convert"></i>

                        </span>

                        <small class="text-info">Supplier</small>

                    </a> -->

                    <?php 
                    $product_domain_view=CheckPermission($permissions,'product_domain_view');
                    if($product_domain_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/product/product-domain-list.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                <i class="no-m-r mdi mdi-disqus-outline"></i>
                            </span>
                            <small class="text-info">Product Domain</small>
                        </a>

                        <?php

                    }

                    ?>

                    <?php 
                    $add_expense=CheckPermission($permissions,'add_expense');
                    if($add_expense == 1){ ?>
                        <a href="<?php echo baseurl('pages/company-register/add-expense.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                <i class="no-m-r mdi mdi-cart "></i>
                            </span>
                            <small class="text-info">Expense</small>
                        </a>

                        <?php

                    }

                    ?>


                    



                    





                   <!--  <a href="<?php echo baseurl('pages/company-register/add-journal.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                        <i class="no-m-r mdi mdi-send  "></i>

                        </span>

                        <small class="text-danger">Journal</small>

                    </a>

                

                

                    <a href="<?php echo baseurl('pages/banking/add-account.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                            <i class="no-m-r mdi mdi-bank  "></i>

                        </span>

                        <small class="text-danger">Account</small>

                    </a> -->





                    <!-- <a href="<?php //echo baseurl('pages/empolyee/add-salary.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                        <i class="no-m-r mdi mdi-square-inc-cash "></i>

                        </span>

                        <small class="text-danger">Salary</small>

                    </a> -->



                </div>

            </div>

        </div>

    </li>

    <li class="nav-item d-flex dropdown mr-1 set-plus-nav-outer dropdown1">

        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center set-plus-nav dropbtn" id="messageDropdown" href="#" data-toggle="dropdown">

          <i class="mdi mdi-chart-bar mx-0 nv-ic"></i>

      </a>

      <div class="dropdown-menu1 dropdown-menu-right navbar-dropdown preview-list dropdown-content" aria-labelledby="messageDropdown">

          <div class="container-fluid>">

              <div class="row shortcuts px-4">

                <?php 
                $add_payment_voucher=CheckPermission($permissions,'add_payment_voucher');
                if($add_payment_voucher == 1){ ?>
                    <a href="<?php echo baseurl('pages/vouchers/cash-payment.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-mac">
                            <i class="no-m-r mdi mdi-cash-usd"></i>
                        </span>
                        <small class="text-mac">Payment Voucher</small>
                    </a>

                    <?php

                }

                ?>




                    <!-- <a href="<?php echo baseurl('pages/vouchers/cash-payment.php'); ?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">

                        <i class="no-m-r mdi mdi-cash-usd"></i>

                        </span>

                        <small class="text-info">Payment Voucher</small>

                    </a> -->


                    <?php 
                    $add_receive_voucher=CheckPermission($permissions,'add_receive_voucher');
                    if($add_receive_voucher == 1){ ?>
                        <a href="<?php echo baseurl('pages/vouchers/cash-received.php'); ?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                <i class="no-m-r mdi mdi-cash"></i>
                            </span>
                            <small class="text-info">Received Voucher</small>
                        </a>

                        <?php

                    }

                    ?>



                    



                   <!--  <a href="<?php echo baseurl('pages/reports/trial-balance.php'); ?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">

                        <i class="no-m-r mdi mdi-chart-arc"></i>

                        </span>

                        <small class="text-info">Trial Balance</small>

                    </a> -->





                    <!-- <a href="<?php echo baseurl('pages/reports/balance-sheet.php'); ?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">

                            <i class="no-m-r mdi mdi-chart-pie"></i>

                        </span>

                        <small class="text-info">Balance Sheet</small>

                    </a>
                -->  


                

                <a href="<?php echo baseurl('pages/reports/profit-loss.php'); ?>" class="col-4 shortcut-item">

                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">

                        <i class="no-m-r mdi mdi-chart-areaspline "></i>

                    </span>

                    <small class="text-info">Profit & Loss</small>

                </a>



            </div>

        </div>

    </div>

</li>

<li class="nav-item d-flex dropdown mr-1 set-plus-nav-outer dropdown1">

    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center set-plus-nav dropbtn" id="messageDropdown" href="#" data-toggle="dropdown">
      <i class="mdi mdi-settings mx-0 nv-ic"></i>
  </a>
  <div class="dropdown-menu1 dropdown-menu-right navbar-dropdown preview-list dropdown-content" aria-labelledby="messageDropdown">
      <div class="container-fluid>">
          <div class="row shortcuts px-4">






                   <!--  <a href="<?php echo baseurl('pages/settings/exp-type.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                        <i class="no-m-r mdi mdi-weight"></i>

                        </span>

                        <small class="text-danger">Type of Exp.</small>

                    </a> -->



                    <!-- <a href="<?php echo baseurl('pages/settings/account-type.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                        <i class="no-m-r mdi mdi-transcribe-close"></i>

                        </span>

                        <small class="text-danger">Account Type</small>

                    </a>

                -->

                   <!--  <a href="<?php echo baseurl('pages/settings/account-group.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">

                        <i class="no-m-r mdi mdi-layers"></i>

                        </span>

                        <small class="text-danger">Account Group</small>

                    </a> -->



                    <!-- <a href="<?php echo baseurl('pages/settings/chart-of-accounts.php');?>" class="col-4 shortcut-item">

                        <span class="shortcut-media avatar rounded-circle bg-gradient-mac">

                        <i class="no-m-r mdi mdi-check-circle"></i>

                        </span>

                        <small class="text-mac">COA</small>

                    </a> -->

                    <?php 
                    $company_view=CheckPermission($permissions,'company_view');
                    if($company_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/settings/company.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-mac">
                                <i class="no-m-r mdi mdi-houzz"></i>
                            </span>
                            <small class="text-mac">Company</small>
                        </a>

                        <?php

                    }

                    ?>

                    

                    <?php 
                    $user_role_view=CheckPermission($permissions,'user_role_view');
                    if($user_role_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/settings/roles.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-mac">
                                <i class="no-m-r mdi mdi-security"></i>
                            </span>
                            <small class="text-mac">Roles</small>
                        </a>

                        <?php

                    }

                    ?>

                    


                    <?php 
                    $units_view=CheckPermission($permissions,'units_view');
                    if($units_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/settings/units-list.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-mac">
                                <i class="no-m-r mdi mdi-google-circles-communities"></i>
                            </span>
                            <small class="text-mac">Units</small>
                        </a>

                        <?php

                    }

                    ?>

                    
                    <a href="<?php echo baseurl('pages/settings/brands.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                            <i class="no-m-r mdi mdi-google-circles-communities"></i>
                        </span>
                        <small class="text-info">Brands</small>
                    </a>

                    <a href="<?php echo baseurl('pages/settings/categories.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                            <i class="no-m-r mdi mdi-google-circles-communities"></i>
                        </span>
                        <small class="text-info">Brand Cat.</small>
                    </a>


                    <?php 
                    $emp_view=CheckPermission($permissions,'emp_view');
                    if($emp_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/empolyee/employee-list.php');?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                <i class="no-m-r mdi mdi-account-key"></i>
                            </span>
                            <small class="text-info">Employees</small>
                        </a>

                        <?php

                    }

                    ?>


                    <?php 
                    $exp_type_view=CheckPermission($permissions,'exp_type_view');
                    if($exp_type_view == 1){ ?>
                        <a href="<?php echo baseurl('pages/settings/exp-type.php'); ?>" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-war">
                                <i class="no-m-r mdi mdi-server"></i>
                            </span>
                            <small class="text-war">Expense Type</small>
                        </a>

                        <?php

                    }

                    ?>

                    <a href="<?php echo baseurl('pages/settings/rate-revision.php'); ?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-war">
                            <i class="no-m-r mdi mdi-backup-restore"></i>
                        </span>
                        <small class="text-war">Rate Revision</small>
                    </a>

                    <a href="<?php echo baseurl('pages/setup/system-setup.php'); ?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-war">
                        <i class="no-m-r mdi mdi-server"></i>
                        </span>
                        <small class="text-war">System Setup</small>
                    </a>
                    
                    <a href="<?php echo baseurl('pages/settings/account-type.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                            <i class="no-m-r mdi mdi-transcribe-close"></i>
                        </span>
                        <small class="text-danger">Account Type</small>
                    </a>

                    <a href="<?php echo baseurl('pages/settings/account-group.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                            <i class="no-m-r mdi mdi-layers"></i>
                        </span>
                        <small class="text-danger">Account Group</small>
                    </a>

                    <a href="<?php echo baseurl('pages/settings/chart-of-accounts.php');?>" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-danger">
                            <i class="no-m-r mdi mdi-check-circle"></i>
                        </span>
                        <small class="text-danger">COA</small>
                    </a>


                    

                    

                    



                    



                </div>

            </div>

        </div>

    </li>

    <li class="nav-item d-flex nav-profile dropdown set-plus-nav-outer">

        <a class="nav-link dropdown-toggle border px-1 py-1 set-plus-nav" href="#" data-toggle="dropdown" id="profileDropdown">

          <span class="nav-status-indicator"></span>

          <?php 





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

  <?php 
  $company_view=CheckPermission($permissions,'company_view');
  if($company_view == 1){ ?>
    <a class="dropdown-item" href="<?php echo baseurl('pages/shop/edit-shop.php');?>">
        <i class="mdi mdi-home text-primary"></i>
        Edit Shop
    </a>

    <?php

}

?>



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





