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
    <title>MAC | Transactions</title>
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
                <h4 class="card-title">Transactions</h4>
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
                                  <th class="th-set text-center">Sr#</th>
                                  <th class="th-set text-center">Date</th>
                                  <th class="th-set text-center">Account</th>
                                  <th class="th-set text-center">Category</th>
                                  <th class="th-set text-center">Amount</th>
                              </tr>
                            </thead>
                            <tbody class="table-body">
                                  
                              <?php
                                $trns = 1;
                                $db->orderBy("transaction_id","DESC");
                                $transfersdata = $db->get("transactions");
                                foreach ($transfersdata as $transfers) {
                                  $account = $transfers['account'];
                                  $category = $transfers['category'];
                                  $date = $transfers['date'];
                                  $amount = $transfers['amount'];

                                  $db->where('id',$account);
                                  $accountdata = $db->getOne("account");

                                  $account_num = $accountdata['account_number'];

                                ?>
                                
                                <tr>
                                    <td class="td1-set text-center"><?php echo $trns; ?></td>
                                    <td class="td1-set text-center"><?php echo date("d-m-Y", strtotime($date));  ?></td>
                                    <td class="td1-set text-center"><?php echo $account_num; ?></td>
                                    <td class="td1-set text-center"><?php echo $category; ?></td>
                                    <td class="td1-set text-center"><?php echo $amount; ?></td>
                              </tr>
                              <?php $trns++; } ?>
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
</html>