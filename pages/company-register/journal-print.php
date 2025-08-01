<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';



    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | Print Journal List</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" media="print" href="<?php echo baseurl('assets/css/vertical-layout-light/exp-print-list.css');?>">
    <link rel="stylesheet" media="screen" href="<?php echo baseurl('assets/css/vertical-layout-light/exp-screen-list.css');?>">
  </head>
  <style>
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
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
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <div class="noprint">
        <?php //include '../../libraries/nav.php'; ?>
      </div>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
      <div class="noprint">
        <?php //include '../../libraries/sidebar.php'; ?>
      </div>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row noprint set-mr-btm">
              <div class="col-md-12">
                <button onclick="myFunction()" class="btn btn-success btn-mac"><i class="mdi mdi-printer"></i> Print</button>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 head"></div>
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="invoice-heading">
                      <h1 class="text-center black-color">Journal Voucher</h1>
                      <p class="black-color">
                        <span class="bold">Filtered By:</span>
                        <?php if ( isset($_REQUEST['voucher'])  && $_REQUEST['voucher'] != '' ) { ?>
                        <span>Voucher No. </span>
                        <span><?php echo $_REQUEST['voucher']; ?>, </span>
                        <?php  } ?>
                        <?php if ( isset($_REQUEST['acc_dec'])  && $_REQUEST['acc_dec'] != '' ) { ?>
                        <span>A/C Description: </span>
                        <span><?php
                        $db->where("chrt_id",$_REQUEST['acc_dec']);
                        $COAData = $db->getOne("chart_accounts");
                        $COAName = ($COAData && isset($COAData['account_name'])) ? $COAData['account_name'] : 'Unknown Account';
                         echo $COAName; 
                         ?>, </span>
                        <?php  } ?>
                        <?php if ( $_REQUEST['date_from'] != '' &&  $_REQUEST['date_to'] != ''  ) { ?>
                        <span>Date From: </span>
                        <span><?php echo date("d-m-Y", strtotime($_REQUEST['date_from'])); ?>, </span>
                        <span>Date To: </span>
                        <span><?php echo date("d-m-Y", strtotime($_REQUEST['date_to'])); ?>, </span>
                        <?php } ?>
                        <?php if ( isset($_REQUEST['search'])  && $_REQUEST['search'] != '' ) { ?>
                        <span>Search By: </span>
                        <span><?php echo $_REQUEST['search']; ?>, </span>
                        <?php  } ?>
                      </p>
                    </div>
                    <div class="customer-basic">

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="set-padd text-center tbl-head bold">Voucher No.</td>
                              <td class="set-padd text-center tbl-head bold">Type</td>
                              <td class="set-padd text-center tbl-head bold">Date</td>
                              <td class="set-padd text-center tbl-head bold">A/C Description</td>
                              <td class="set-padd text-center tbl-head bold">Debit</td>
                              <td class="set-padd text-center tbl-head bold">Credit</td>
                            </tr>
<?php 

    $cols=array("COUNT(jt.j_id) as total_count");
    $db->join("journal_meta jm", "jt.j_id=jm.j_id", "INNER");
    $db->join("gl_type gl_ty", "gl_ty.id=jt.gl_type", "INNER"); 
    $db->join("chart_accounts ca", "jm.chrt_id=ca.chrt_id", "INNER");
    if( isset($_REQUEST['voucher'])  && $_REQUEST['voucher'] != ''){
            $db->where("jt.voucher_no",$_REQUEST['voucher']);
    }
    if (isset($_REQUEST['search']) && $_REQUEST['search'] != '') {
        $db->where("gl_ty.type", '%'.$_REQUEST['search'].'%', 'like');
    }
    if( isset($_REQUEST['acc_dec'])  && $_REQUEST['acc_dec'] != ''){
            $db->where("jm.chrt_id",$_REQUEST['acc_dec']);
    } 
    if( isset($_REQUEST['date_from'])  && $_REQUEST['date_from'] != '' && isset($_REQUEST['date_to'])  &&  $_REQUEST['date_to'] != ''  ){
        
        $from_date=$_REQUEST['date_from'];
        $to_date=$_REQUEST['date_to'];
        
        $db->where('jt.date', Array ($from_date, $to_date ), 'BETWEEN');
    }  
    $JVdata_new = $db->get("journal_tbl jt", null, $cols);
    
    foreach($JVdata_new as $jd){
        $totalRecords = $jd['total_count'];
    }
    // die();


    


    $cols=array("jt.voucher_no","jt.date","jm.debit","jm.credit","ca.account_name","jt.j_id","jt.gl_type","gl_ty.type");
    $db->join("gl_type gl_ty", "jt.gl_type=gl_ty.id", "INNER"); 
    $db->join("journal_meta jm", "jt.j_id=jm.j_id", "INNER"); 
    $db->join("chart_accounts ca", "jm.chrt_id=ca.chrt_id", "INNER"); 
    if( isset($_REQUEST['voucher'])  && $_REQUEST['voucher'] != ''){
            $db->where("jt.voucher_no",$_REQUEST['voucher']);
    }
    if (isset($_REQUEST['search']) && $_REQUEST['search'] != '') {
        $db->where("gl_ty.type", '%'.$_REQUEST['search'].'%', 'like');
    }
    if( isset($_REQUEST['acc_dec'])  && $_REQUEST['acc_dec'] != ''){
            $db->where("jm.chrt_id",$_REQUEST['acc_dec']);
    } 
    if( isset($_REQUEST['date_from'])  && $_REQUEST['date_from'] != '' && isset($_REQUEST['date_to'])  &&  $_REQUEST['date_to'] != ''  ){
        
        $from_date=$_REQUEST['date_from'];
        $to_date=$_REQUEST['date_to'];
        
        $db->where('jt.date', Array ($from_date, $to_date ), 'BETWEEN');
    } 
    $JVdata = $db->get ("journal_tbl jt", null, $cols);
    

    $data = array();

    
    $total_debit=0;
    $total_cedit=0;
    foreach ($JVdata as $JV) {


        $total_debit+=(float)$JV['debit'];
        $total_cedit+=(float)$JV['credit'];

        $JV_id = $JV['j_id'];
        $encrypt = encode($JV_id);
        $voucher_no = $JV['voucher_no'];
        $type = $JV['type'];
        $date = $JV['date'];
        $accName = $JV['account_name'];
        $debit = (float)$JV['debit'];
        $credit = (float)$JV['credit'];
?>
                            <tr>
                              <td class="set-padd text-center tbl-con voucher-no"><?php  echo $voucher_no;?></td>
                              <td class="set-padd text-center tbl-con cl-nm"><div class=""><?php echo $type;?></div></td>
                              <td class="set-padd text-center tbl-con date-dv"><?php echo date("d-m-Y", strtotime($date));?></td>
                              <td class="set-padd text-center tbl-con"><?php echo $accName;?></td>
                              <td class="set-padd text-center tbl-con"><?php echo number_format($debit);?></td>
                              <td class="set-padd text-center tbl-con"><?php echo number_format($credit);?></td>
                            </tr>
<?php } ?>
                            <tr>
                              <td class="set-padd text-center tbl-con bold" colspan="2"><?php echo 'Showing '.$totalRecords.' entries';?></td>
                              <td class="set-padd text-center tbl-con bold" colspan="2"><?php echo 'Total';?></td>
                              <td class="set-padd text-center tbl-con bold"><?php echo number_format((float)$total_debit);?></td>
                              <td class="set-padd text-center tbl-con bold"><?php echo number_format((float)$total_cedit);?></td>
                            </tr>

                          </tbody>
                        </table>
                      </div>
                      <?php
                          $companydata = $db->getOne('company');
                          $company_name = ($companydata && isset($companydata['name'])) ? $companydata['name'] : 'Company Name';
                       ?>
                      <div class="fot-set">
                        <div class="inline">
                          <div class="pr-date">
                            <p class="no-mr-btm text-center black-color"><?php echo date("d-m-Y");?></p>
                            <p class="border-tp text-center black-color">Print Date</p>
                          </div>
                        </div>
                        <div class="inline flot-rt">
                          <div class="sign">
                            <p class="no-mr-btm white-clr">.</p>
                            <p class="border-tp text-center black-color"><?php echo $company_name; ?></p>
                          </div>
                        </div>
                        <!-- <div class="text-center">
                          <p class="black-color"><?php //echo $tag_line = $companydata['tag_line']; ?></p>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            
              
           
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
        <div class="noprint">
          <?php include '../../libraries/footer.php'; ?>
        </div>
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
function myFunction() {
    window.print();
}
</script>
</html>