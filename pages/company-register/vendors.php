<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';

    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {

    $db->where("id",$x);
    $db->delete('vendors');
    ?>
<script>
  window.location.href="vendors.php";
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
    <title>MAC | Vendors</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">

  </head>
  <style>
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
                <h4 class="card-title">Vendors</h4>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-vendor.php'"><i class="mdi mdi-plus"></i> Add New</button>
              </div> 
              <div class="col-lg-12">
                <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                          
                          
                        <div class="table-responsive">
                          <table id="order-listing" class="table">
                            <thead>
                              <tr>
                                  <th class="th-set text-center">SR#</th>
                                  <th class="th-set text-center">Name</th>
                                  <th class="th-set text-center">Email</th>
                                  <th class="th-set text-center">Phone</th>
                                  <th class="th-set text-center">Status</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody class="table-body">
                                  
                              <?php
                              $v = 1;
                                $vendorsdata = $db->get("vendors");
                                foreach ($vendorsdata as $vendors) {
                                $vendors_id = $vendors['id'];
                                $encrypt = encode($vendors_id);
                                $vendor_name = $vendors['name'];
                                $vendor_email = $vendors['email'];
                                $vendor_phone = $vendors['phone'];
                                $vendor_status = $vendors['status'];
                                ?>
                                
                                <tr>
                                    <td class="td1-set text-center"> <?php echo $v;  ?></td>
                                    <td class="td1-set text-center"> <?php echo $vendor_name;  ?></td>
                                    <td class="td1-set text-center"> <?php echo $vendor_email;  ?></td>
                                    <td class="td1-set text-center"> <?php echo $vendor_phone;  ?></td>
                                    <td class="td1-set text-center">
                                       <?php if ($vendor_status=='1') { ?>
                                    <button type="button" class="mac-badge">Active</button>
                                    <?php }elseif($vendor_status=='0'){ ?>
                                    <button type="button" class="mac-badge-inactive">Inactive</button>
                                    <?php } ?>
                                    </td>
                                    <td class="td1-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <a class="dropdown-item" href="view-vendor.php?vn=<?php echo $encrypt; ?>"><i class="mdi mdi-eye text-dark"></i>View</a>
                                        <a class="dropdown-item" href="edit-vendor.php?vn=<?php echo $encrypt; ?>"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $vendors_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $v++; } ?>
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
var r = confirm(" Are you sure you want to delete this vendor ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;


window.location = "vendors.php?id="+clicked_id; 

} else {


}

}
</script>
</html>