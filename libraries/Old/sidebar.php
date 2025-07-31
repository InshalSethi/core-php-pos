<style>
  .sidebar{
      width: 200px;
  }
  .main-panel{
      width: 100% !important;
  }
  /*Load modal*/
  .nav-modal{
      background: #6da252;
      padding: 3px;
      color: white;
      border-radius: 3px;
      margin-top: 5px;
  }
  .hd-mol{
      color:#6da252;
  }
  .pr-mol{
      font-size: 16px;
      margin: 0px;
      margin-left: 10px;
      margin-right: 10px;
  }
  .pr2-mol{
      font-size: 14px;
      margin: 0px;
      margin-left: 10px;
      margin-right: 10px;
  }
  /*Notification navbar setting*/
  .notification-top{
      font-size:16px;
      font-weight: 500!important;
      color: #6da252;
  }
  .set-notify{
     border:none!important; 
  }
  .notification-section{
      border-top:1px solid #ecf0f8;
  }
  /*content wraper sides padding*/
  .content-wrapper{
        padding-left: 15px!important;
        padding-right: 15px!important;
        padding-top: 15px!important;
        padding-bottom: 15px!important;
      }
  /* data table content setting start*/
  .td-set{
    padding: 5px!important;
    font-size: 13px!important;
  }
  .th-set{
    padding: 5px!important;
  }
  /* data table content setting end*/
   .btn-mac{
      background: #6da252!important;
      color: white!important;
      padding: 5px!important;
      padding-bottom: 7px!important;
      padding-top: 7px!important;
      border-color: #6da252;
      font-size: 13px;
   }
   .btn-mac:hover{
      background: #5a8047!important;
      color: white!important;
      padding: 5px!important;
      padding-bottom: 7px!important;
      padding-top: 7px!important;
      border-color: #6da252;
      font-size: 13px;
   }
   .btn-remove{
      background: #6c7293;
      border-color: #6c7293;
      padding: 5px!important;
      padding-bottom: 7px!important;
      padding-top: 7px!important;
      font-size: 13px;
   }
   .btn-remove:hover{
      background: #cc0000;
      border-color: #cc0000;
      padding: 5px!important;
      padding-bottom: 7px!important;
      padding-top: 7px!important;
      font-size: 13px;
   }
   .btn-cancel{
      background: #6c7293;
      border-color: #6c7293;
      padding: 5px!important;
      padding-bottom: 7px!important;
      padding-top: 7px!important;
      font-size: 13px;
   }
   .mac-badge-inactive{
      background: red!important;
      color: white!important;
      padding: 2px!important;
      padding-left: 5px!important;
      padding-right: 5px!important;
      font-size: 11px;
      line-height: 1.3;
      font-weight: 600;
      border:none;
      border-radius: 3px!important;
      border-color: #6da252;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
   }
   .mac-badge{
      background: #6da252!important;
      color: white!important;
      padding: 2px!important;
      padding-left: 5px!important;
      padding-right: 5px!important;
      font-size: 11px;
      line-height: 1.3;
      font-weight: 600;
      border:none;
      border-radius: 3px!important;
      border-color: #6da252;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
   }
   .btn-mac-action{
      background: #c1c1c19c!important;
      color: black!important;
      padding-left: 10px!important;
      padding-right: 10px!important;
      padding-bottom: 3px!important;
      padding-top: 3px!important;
      border-color: #c1c1c19c;
      font-size: 13px;
      line-height: 1.3;
      font-weight: 600;
      border: none;
      border-radius: 3px!important;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
   }
  /*card top color*/
    .card-border-color{
      border-top: 3px solid #6da252;
    }
    .card-title{
      color: #000000b5!important;
      display: inline-block;
      margin-right: 20px;
      margin-bottom: 8px;
    }
  /*side-menu-padding and margins*/
  .side-margin{
    margin-top: 5px!important;
  }
  .side-padding{
    padding-top: 7px!important;
    padding-bottom: 7px!important;
  }
  /* Dropdown Button hoverable */
  .dropbtn {
    background-color: #6da252;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
  }

  /* The container <div> - needed to position the dropdown content */
  .dropdown1 {
    position: relative;
    display: inline-block;
  }

  /* Dropdown Content (Hidden by Default) */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }
  /*for large screen and zoom out*/
  @media screen and (min-width: 1602px) {
    .dropdown-content {
      min-width: 461px!important;
    }
    }

  /* Links inside the dropdown */
  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  /* Change color of dropdown links on hover */
  .dropdown-content a:hover {background-color: #ddd;}

  /* Show the dropdown menu on hover */
  .dropdown1:hover .dropdown-content {display: block;}

  /* Change the background color of the dropdown button when the dropdown content is shown */
  .dropdown1:hover .dropbtn {background-color: #64964b;}
  /*new dropdown end*/
  /*plus on nav*/
  .set-plus-nav{
    border:none!important;
  }
  .set-plus-nav-outer:hover{
    background: #64964b!important;
  }
  /*plus on nav end*/
    .sidebar .nav .nav-item.nav-profile .profile-name{
      color: black!important;
    }
    .sidebar .nav .nav-item.nav-profile .designation{
      color: black!important;
    }
    .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow{
      color: black!important;
      font-weight: 500;
    }
    .sidebar .nav .nav-item .nav-link .menu-title{
      color: black!important;
      font-weight: 500;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link:hover{
      color: #6da252!important;
      font-weight: 500;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link{
      color: black!important;
      font-weight: 500;
    }
    .sidebar .nav.sub-menu .nav-item .nav-link.active{
      background: #6da252!important;
      color: white!important;
      font-weight: 500;
    }
    .sidebar {
      /*background: linear-gradient(to bottom, #006517, #2a9643, #006517)!important;*/
      background: #f9fafc!important;
    }
    .sidebar .nav .nav-item .nav-link i.menu-icon{
      color: black!important;
    }
    .sidebar .nav .nav-item .nav-link i.menu-arrow{
      color: black!important;
    }
    .navbar .navbar-brand-wrapper{
      background: #6da252!important;
    }
    .navbar .navbar-menu-wrapper{
      background: #6da252!important;
    }
    .navbar .navbar-brand-wrapper .navbar-toggler{
      color: white!important;
    }
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link{
      color: white!important;
    }
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .btn-link{
      color: white!important;
    }
    @media (min-width: 992px){
      .sidebar-icon-only .sidebar .nav .nav-item.hover-open .nav-link:hover .menu-title{
        background: #f9fafc!important;
      }
      .sidebar-icon-only .sidebar .nav .nav-item.hover-open .collapse, .sidebar-icon-only .sidebar .nav .nav-item.hover-open .collapsing{
        background: #f9fafc!important;
      }
      .sidebar-icon-only .sidebar .nav .nav-item.hover-open .nav-link .menu-title{
        background: #f9fafc!important;
      }
    }
    .font-set-plus{
      font-weight: 500!important;
    }
    @media only screen and (min-width: 320px) and (max-width: 480px){
    .dropdown-menu1{
      min-width: 185px!important;
    }
  }
  @media only screen and (min-width: 990px) and (max-width: 1600px){
  .dropdown-menu1{
      min-width: 520px!important;
    }
  }
  .border-drop-plus{
    border-bottom: 0px solid #80808087;
    box-shadow: 0 2px 2px 0 rgb(193, 193, 193), 0 3px 1px -2px rgb(241, 241, 241), 0 1px 5px 0 rgb(193, 193, 193);
  }
  .border-drop-plus{
     background: #6da252  !important;
  }
  .drop-gead-fnt{
    color: white!important;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown{
    top: 38px;
    background: white;
    border: 1px solid #c1c1c1;
    border-radius: 5px;
    box-shadow: 0 2px 2px 0 rgb(193, 193, 193), 0 3px 1px -2px rgb(241, 241, 241), 0 1px 5px 0 rgb(193, 193, 193);
  }
  @media only screen and (min-width: 990px) and (max-width: 1600px){
  .page-body-wrapper{
      padding-top: 38px;
  }
  .navbar .navbar-menu-wrapper{
      height: 38px;
  }
  .navbar .navbar-brand-wrapper{
      height: 38px;
  }
  }
  /*checkbox style*/
  .form-check-primary.form-check label input[type="checkbox"]:checked + .input-helper:before, .form-check-primary.form-check label input[type="radio"]:checked + .input-helper:before{
      background: #6da252!important;
  }
  .form-check .form-check-label input[type="checkbox"]:checked + .input-helper:before{
      background: #6da252!important;
  }
  .form-check .form-check-label input[type="checkbox"] + .input-helper:before{
      border: 2px solid #6da252!important;
  }
  /*input border color*/
  .form-control:focus, .asColorPicker-input:focus, .dataTables_wrapper select:focus, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=text]:focus, .jsgrid .jsgrid-table .jsgrid-filter-row select:focus, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=number]:focus, .select2-container--default .select2-selection--single:focus, .select2-container--default .select2-selection--single .select2-search__field:focus, .typeahead:focus, .tt-query:focus, .tt-hint:focus{
      border-color: #6da252!important;
  }
  .form-control, .asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=text], .jsgrid .jsgrid-table .jsgrid-filter-row select, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=number], .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field, .typeahead, .tt-query, .tt-hint{
      border-color: #d2d6de;
  }
  .input-group-append .input-group-text, .input-group-prepend .input-group-text{
    border-color: #d2d6de;
  }

  select.form-control, select.asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row select, .select2-container--default select.select2-selection--single, .select2-container--default .select2-selection--single select.select2-search__field, select.typeahead, select.tt-query, select.tt-hint{
    outline: 1px solid #d2d6de;
  }
  /*pagination color start*/
  .pagination .page-item.active .page-link, .jsgrid .jsgrid-pager .page-item.active .page-link, .jsgrid .jsgrid-pager .active.jsgrid-pager-nav-button .page-link, .jsgrid .jsgrid-pager .active.jsgrid-pager-page .page-link, .pagination .page-item.active .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .page-item.active .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item.active a, .jsgrid .jsgrid-pager .active.jsgrid-pager-nav-button a, .pagination .page-item.active .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .page-item.active .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item.active a, .jsgrid .jsgrid-pager .active.jsgrid-pager-page a, .pagination .page-item:hover .page-link, .jsgrid .jsgrid-pager .page-item:hover .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:hover .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-page:hover .page-link, .pagination .page-item:hover .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .page-item:hover .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item:hover a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:hover a, .pagination .page-item:hover .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .page-item:hover .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item:hover a, .jsgrid .jsgrid-pager .jsgrid-pager-page:hover a, .pagination .page-item:focus .page-link, .jsgrid .jsgrid-pager .page-item:focus .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:focus .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-page:focus .page-link, .pagination .page-item:focus .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .page-item:focus .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item:focus a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:focus a, .pagination .page-item:focus .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .page-item:focus .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item:focus a, .jsgrid .jsgrid-pager .jsgrid-pager-page:focus a, .pagination .page-item:active .page-link, .jsgrid .jsgrid-pager .page-item:active .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:active .page-link, .jsgrid .jsgrid-pager .jsgrid-pager-page:active .page-link, .pagination .page-item:active .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .page-item:active .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item:active a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button:active a, .pagination .page-item:active .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .page-item:active .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item:active a, .jsgrid .jsgrid-pager .jsgrid-pager-page:active a{
    background: #6da252 !important;
    border-color: #6da252 !important;
  }
  .img-sm{
    width: 100px;
    height: 90px;
  }
  /*pagination color end*/

  /*Datatable styles*/
  div.dataTables_wrapper div.dataTables_filter label{
    width: 100%;
  }
  div.dataTables_wrapper div.dataTables_filter input{
    margin-left: 0px!important;
    width: 100%;
  }
  div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:first-child{
    padding-right: 0px;
  }
  div.dataTables_wrapper div.dataTables_length label{
    width: 100%;
  }
  div.dataTables_wrapper div.dataTables_length select{
    width: 99%;
  }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="<?php echo baseurl('index.php');?>" class="nav-link d-block text-center">
                <div class="profile-image">
                  <?php 
                    $companydata = $db->getOne('company');
                    $name = $companydata['name'];
                    $image = $companydata['image'];
                    if($image != ''){ 
                   ?>
                  <img class="img-sm" src="<?php echo baseurl('assets/images/'); echo $image; ?>" alt="profile image">
                  <?php }else{ ?>
                  <img class="img-sm" src="https://via.placeholder.com/25*25" alt="Company Logo"/>
                  <?php } ?>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php $type = $_SESSION['user_type'];
                    $id = $_SESSION['login_id'];
                    $db->where("id",$id);
                    $user_data=$db->getOne("user_mac");
                   // echo $user_data['name'];
                   //echo $name;
                   ?></p>
                  <!--<p class="designation">Online <span class="dot-indicator bg-success"></span></p>-->
                </div>
              </a>
             
            </li>
            
            <?php if ($_SESSION['login_id']) { ?>
            <!--<li class="nav-item side-margin">-->
            <!--  <a class="nav-link side-padding" href="<?php //echo baseurl('index.php');?>">-->
            <!--  <i class="mdi mdi-speedometer menu-icon"></i>-->
            <!--  <span class="menu-title">Dashboard</span>-->
            <!--  </a>-->
            <!--</li>-->
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/customers/customers-list1.php');?>">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Clients</span>
              </a>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/invoice/invoice-list1.php');?>">
              <i class="mdi mdi-cash-100 menu-icon"></i>
              <span class="menu-title">Invoices</span>
              </a>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/company-register/expence-management.php');?>">
              <i class="mdi mdi-cart menu-icon"></i>
              <span class="menu-title">Expenses</span>
              </a>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/company-register/journals.php');?>">
              <i class="mdi mdi-send menu-icon"></i>
              <span class="menu-title">Journal</span>
              </a>
            </li>
            <!--<li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="mdi mdi-chart-areaspline menu-icon"></i>
              <span class="menu-title">General Ledger</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php //echo baseurl('pages/company-register/recipt_vouchers.php');?>">Receipt Vouchers</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php //echo baseurl('pages/company-register/expence-management.php');?>">Payment Vouchers</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php //echo baseurl('pages/company-register/payments.php');?>" style="display:none;">Payments</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php //echo baseurl('pages/company-register/vendors.php');?>" style="display:none;">Vendors</a></li>
                  
                </ul>
              </div>
            </li>-->
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <i class="mdi mdi-bank menu-icon"></i>
              <span class="menu-title">Banking</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/banking/accounts-list.php');?>">Accounts</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/banking/transfers.php');?>">Transfers</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/banking/transactions.php');?>">Transactions</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
              <i class="mdi mdi-account-multiple-plus menu-icon"></i>
              <span class="menu-title">Employee</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-advanced">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/empolyee/employee-list.php');?>">Employee</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/empolyee/salary.php');?>">Salary</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#maps" aria-expanded="false" aria-controls="maps">
              <i class="mdi mdi-chart-bar menu-icon"></i>
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="maps">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/reports/trial-balance.php'); ?>">Trial Balance</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/reports/balance-sheet.php'); ?>">Balance Sheet</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/reports/profit-loss.php'); ?>">Profit & Loss</a></li>
                  
                </ul>
              </div>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
              <i class="mdi mdi-settings menu-icon"></i>
              <span class="menu-title">Settings</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="editors">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/services.php');?>">Services</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/category.php');?>">Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/careoff.php');?>">CareOff</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/work-status.php');?>">Work Status</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/exp-type.php');?>">Type of Exp.</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/account-type.php');?>">Account Type</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/account-group.php');?>">Account Group</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/chart-of-accounts.php');?>">Chart Of Account</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/company.php');?>">Company</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/settings/roles.php');?>">Roles</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item side-margin">
              <a class="nav-link side-padding" data-toggle="collapse" href="#setup" aria-expanded="false" aria-controls="maps">
              <i class="mdi mdi-wrench menu-icon"></i>
              <span class="menu-title">Setup</span>
              <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="setup">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo baseurl('pages/setup/system-setup.php'); ?>">System Setup</a></li>
                  
                </ul>
              </div>
            </li>
          <?php  } ?>
          </ul>
        </nav>