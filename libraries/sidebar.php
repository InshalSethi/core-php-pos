<style>

  .scroll{

    overflow-y: scroll;

    width: 100%;

    height: 270px;

  }

  .sidebar{
    width: 96px;
  }

  .sidebar .nav .nav-item .nav-link .menu-title{

    font-size: 13px;

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

      min-width: 275px!important;

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

  .dropdown-content a:hover {background-color: white;}



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

    .sidebar .nav .nav-item.active > .nav-link .menu-title:after{

      width: 100%;

          background: #6da252;

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

      background: white!important;

    }

    .navbar .navbar-menu-wrapper{

      background: #6da252!important;

    }

    .navbar .navbar-brand-wrapper .navbar-toggler{

      color: white!important;

      display: none;

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

    .dropdown-menu2{

      min-width: 185px!important;

    }

  }

  @media only screen and (min-width: 990px) and (max-width: 1600px){

  .dropdown-menu1{

      min-width: 275px!important;

    }

    .dropdown-menu2{

      min-width: 185px!important;

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

    top: 70px;

    background: white;

    border: 1px solid #c1c1c1;

    border-radius: 5px;

    box-shadow: 0 2px 2px 0 rgb(193, 193, 193), 0 3px 1px -2px rgb(241, 241, 241), 0 1px 5px 0 rgb(193, 193, 193);

  }

  @media only screen and (min-width: 990px) and (max-width: 1600px){

  .page-body-wrapper{

      padding-top: 70px;

  }

  .navbar .navbar-menu-wrapper{

      height: 70px;

      width: calc(100% - 400px);

      padding-left: 0px;

  }

  .navbar .navbar-brand-wrapper{

      height: 70px;

      width: 400px;

      padding: 0px 0rem;

  }

  }

  @media only screen and (min-width: 1600px) and (max-width: 1920px){

    .navbar .navbar-menu-wrapper{

        height: 70px;

        width: calc(100% - 370px);

        padding-left: 0px;

    }

    .navbar .navbar-brand-wrapper{

        height: 70px;

        width: 370px;

        padding: 0px 0rem;

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

  .sidebar .nav:not(.sub-menu) > .nav-item:hover > .nav-link .menu-title:after{

    width: 100%;

    background: #6da252;

  }

  .sidebar .nav:not(.sub-menu) > .nav-item{

    margin: 0rem 0.125rem 0.5rem 0.125rem;

  }

  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator{

    padding:0rem 0.1rem;

  }

  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator i{

    font-size: 35px;

  }

  .nv-cus{

    height: 100%;

    width: 100%;

    margin-right: -89px;

    /* margin-left: 30px; */

    transform: skew(-32deg, -0deg);

    background: white !important;

  }

  .com-mn{

    margin-top: 5px;

  }

  .com-sub{

    margin-left: 18px;

    font-size: 19.9px;

  }

  .com-nv{

    padding-left: 10px;

    padding-right: 10px;

    color: black;

    text-align: left;

    transform: skew(32deg, 0deg);

  }

  @media(min-width: 320px) and (max-width: 1024px){

    .nv-cus{

      display: none;

    }

    .com-nv{

      display: none;

    }

    .navbar .navbar-brand-wrapper{

      background: #6da252 !important;



    }

    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator i{

      font-size: 18px;

    }

    .no-dis{

      display: none;

    }

  }

  @media(min-width: 1600px) and (max-width: 1920px){

    .ic-nv-cs1{

      border-radius: 45px !important;

      width: 100% !important;

      padding: 32px !important;

    }

    .ic-nv-cs2{

      border-radius: 45px !important;

      width: 100% !important;

      padding: 32px !important;

    }

  }

  .wel-txt-big{

    color: white;

    font-size: 18px;

    margin-left: 125px;

  }

  .wel-txt-sm{

    color: white;

    font-size: 14px;

    margin-left: 125px;

  }

  .st-sd{

    text-align: center;

    width: 100%;

    margin-bottom: 0px;

  }

  .ic-cm{

    font-size: 23px;

    line-height: 1;

  }

  .ic-nv-cs1{

    border-radius: 35px;

    width: 100%;

    padding: 17px;

    color: white;

    background: linear-gradient(87deg, #328aef 0, #66afff 100%) !important;

  }

  .ic-nv-cs2{

    border-radius: 35px;

    width: 100%;

    padding: 17px;

    color: white;

    background: linear-gradient(87deg, #ef3232 0, #ff6666 100%) !important;

  }

  .no-m-r{

    margin-right: 0px !important;

    font-size: 30px !important;

  }



  /*Top menu New*/

  .pl-4, .px-4 {

    padding-left: 1.5rem!important;

  }

  .pr-4, .px-4 {

    padding-right: 1.5rem!important;

  }

  .dropdown-menu-dark .h1, .dropdown-menu-dark .h2, .dropdown-menu-dark .h3, .dropdown-menu-dark .h4, .dropdown-menu-dark .h5, .dropdown-menu-dark .h6, .dropdown-menu-dark a {

    color: #fff;

  }

  .shortcut-item {

    padding-top: 1rem;

    padding-bottom: 1rem;

    text-align: center;

  }

  .bg-gradient-info {

    background: linear-gradient(87deg, #328aef 0, #66afff 100%) !important;

  }

  .bg-gradient-danger {

    background: linear-gradient(87deg, #ef3232 0, #ff6666 100%) !important;

  }

  .bg-gradient-mac {

    background: linear-gradient(87deg, #6da252 0, #b8d3a9 100%) !important;

  }

  .bg-gradient-war {

    background: linear-gradient(87deg, #f6b200 0, #fcce5e87 100%) !important;

  }

  .shortcut-media {

    -webkit-transition: all .15s cubic-bezier(.68,-.55,.265,1.55);

    transition: all .15s cubic-bezier(.68,-.55,.265,1.55);

  }

  .avatar {

    color: #fff;

    background-color: #adb5bd;

    display: -webkit-inline-box;

    display: -ms-inline-flexbox;

    display: inline-flex;

    -webkit-box-align: center;

    -ms-flex-align: center;

    align-items: center;

    -webkit-box-pack: center;

    -ms-flex-pack: center;

    justify-content: center;

    font-size: 1rem;

    height: 48px;

    width: 48px;

  }

  .avatar.rounded-circle img, .rounded-circle {

    border-radius: 50%!important;

  }

  .shortcut-item small {

    display: block;

    margin-top: .75rem;

    font-size: .8125rem;

    font-weight: 600;

  }

  .text-info {

    color: #328aef !important;

  }

  .text-danger {

    color: #ef3232 !important;

  }

  .text-mac {

    color: #6da252 !important;

  }

  .text-war {

    color: #f6b200 !important;

  }

</style>

<nav class="sidebar sidebar-offcanvas" id="sidebar">

          <ul class="nav">

            <!--<li class="nav-item nav-profile">

              <a href="<?php echo baseurl('index.php');?>" class="nav-link d-block text-center">

                <div class="profile-image">

                  <?php 

                    $companydata = $db->getOne('company');

                    $name = $companydata['name'];

                    $image = $companydata['image'];

                    if($image != ''){ 

                   ?>

                  <img class="img-sm" src="<?php echo baseurl('assets/images/'); echo $image; ?>" alt="<?php echo $name.' Logo'; ?>">

                  <?php }else{ ?>

                  <img class="img-sm" src="https://via.placeholder.com/25*25" alt="Company Logo"/>

                  <?php } ?>

                </div>

                <div class="text-wrapper">

                  <p class="profile-name"><?php $type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';

                    $id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : 0;

                    $db->where("id",$id);

                    $user_data=$db->getOne("users_tbl");

                   ?></p>

                </div>

              </a>

             

            </li>-->

            

            <?php if (isset($_SESSION['login_id']) && $_SESSION['login_id']) { ?>


            <?php 
            $product_view=CheckPermission($permissions,'product_view');
            if($product_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-tag-multiple"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/product/all-products.php');?>">
                <p class="menu-title st-sd">Products</p>
                </a>
              </li>

              <?php

            }

            ?>

            <?php 
            $customer_view=CheckPermission($permissions,'customer_view');
            if($customer_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-account-multiple menu-icon"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/customers/customer-list.php');?>">
                <p class="menu-title st-sd">Customers</p>
                </a>
              </li>

              <?php

            }

            ?>

            <?php 
            $supplier_view=CheckPermission($permissions,'supplier_view');
            if($supplier_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-account-convert"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/supplier/supplier-list.php');?>">
                <p class="menu-title st-sd">Supplier</p>
                </a>
              </li>

              <?php

            }

            ?>

            <?php 
            $sale_invoices_view=CheckPermission($permissions,'sale_invoices_view');
            if($sale_invoices_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-note-text menu-icon"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/invoices/all-invoices.php');?>">
                <p class="menu-title st-sd">Sale <br> Invoices</p>
                </a>
              </li>

              <?php

            }

            ?>


            <?php 
            $purchase_invoices_view=CheckPermission($permissions,'purchase_invoices_view');
            if($purchase_invoices_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-basket-fill"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/invoices/purchase-invoices.php');?>">
                <p class="menu-title st-sd">Purchase <br> Invoices</p>
                </a>
              </li>

              <?php

            }

            ?>


            <?php 
            $add_payment_voucher=CheckPermission($permissions,'add_payment_voucher');
            if($add_payment_voucher == 1){ ?>
              <!-- <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-cash-usd"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/vouchers/cash-payment.php');?>">
              <p class="menu-title st-sd">Payment  <br> Voucher</p>
              </a>
            </li> -->

              <?php

            }

            ?>

            <?php 
            $add_receive_voucher=CheckPermission($permissions,'add_receive_voucher');
            if($add_receive_voucher == 1){ ?>
              <!-- <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-cash"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/vouchers/cash-received.php');?>">
                <p class="menu-title st-sd">Received  <br> Voucher</p>
                </a>
              </li> -->

              <?php

            }

            ?>

            <?php 
            $transaction_view=CheckPermission($permissions,'transaction_view');
            if($transaction_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-receipt menu-icon"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/banking/transactions.php');?>">
                <p class="menu-title st-sd">Transactions</p>
                </a>
              </li>

              <?php

            }

            ?>


            <?php 
            $accounts_view=CheckPermission($permissions,'accounts_view');
            if($accounts_view == 1){ ?>
              <li class="nav-item side-margin">
                <div class="text-center ic-cm"><i class="mdi mdi-bank menu-icon"></i></div>
                <a class="nav-link side-padding" href="<?php echo baseurl('pages/banking/accounts-list.php');?>">
                <p class="menu-title st-sd">Accounts</p>
                </a>
              </li>

              <?php

            }

            ?>

            <?php 
            $cash_payments_view=CheckPermission($permissions,'cash_payments_view');
            if($cash_payments_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-cash-usd"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/vouchers/all-cash-payment.php');?>">
              <p class="menu-title st-sd">Cash <br> Payments</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $sale_return_view=CheckPermission($permissions,'sale_return_view');
            if($sale_return_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-arrow-bottom-left"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/invoices/all-sale-return.php');?>">
              <p class="menu-title st-sd">Sale <br> Return</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $purchase_return_view=CheckPermission($permissions,'purchase_return_view');
            if($purchase_return_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-cart-off"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/invoices/all-purchase-return.php');?>">
              <p class="menu-title st-sd">Purchase <br> Return</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $cash_received_view=CheckPermission($permissions,'cash_received_view');
            if($cash_received_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-cash-multiple"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/vouchers/all-cash-received.php');?>">
              <p class="menu-title st-sd">Cash <br> Received</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $expenses_view=CheckPermission($permissions,'expenses_view');
            if($expenses_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-cash-multiple"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/company-register/expence-management.php');?>">
              <p class="menu-title st-sd">Expenses</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $journal_view=CheckPermission($permissions,'journal_view');
            if($journal_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-send menu-icon"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/company-register/journals.php');?>">
              <p class="menu-title st-sd">Journal</p>
              </a>
            </li>

              <?php

            }

            ?>

            <?php 
            $transfers_view=CheckPermission($permissions,'transfers_view');
            if($transfers_view == 1){ ?>
             <li class="nav-item side-margin">
              <div class="text-center ic-cm"><i class="mdi mdi-transfer menu-icon"></i></div>
              <a class="nav-link side-padding" href="<?php echo baseurl('pages/banking/transfers.php');?>">
              <p class="menu-title st-sd">Transfers</p>
              </a>
            </li>

              <?php

            }

            ?>
            

            

            

            


            


            



            

            

            

            

            

          <?php  } ?>

          </ul>

        </nav>