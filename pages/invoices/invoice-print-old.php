<?php
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

    $page_title='Inventory | Print';

    $in_id=decode($_REQUEST['ci']);
    $x=encode( $in_id);
    $db->where('inv_id',$in_id);
    $in_data=$db->getOne('tbl_invoice');

    $db->where('inv_id',$in_id);
    $item_data=$db->get('tbl_invoice_detail');



    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $page_title; ?></title>
    <!-- base:css -->
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" media="print" href="<?php echo base_url('assets/css/print.css'); ?>">
     <link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/screen.css'); ?>">
  </head>
  <style>
    .pd-l{
      padding-left: 0px; 
    }
    .pd-r{
      padding-right: 0px;
    }
    .pd-both{
      padding-right: 0px;
      padding-left: 0px;
    }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
    
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
       
        
        <div class="main-panel" style="width: 100%;">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-8">
                <div class="d-lg-flex align-items-baseline">
                  <button onclick="myFunction()" class="btn btn-info noprint"><i class="fa fa-print"></i> Print</button>

                  

                  <a href="edit-invoice-wp.php?in=<?php echo $x; ?>" class="btn btn-info noprint" style="margin-left: 15px;" ><i class="fa fa-print"></i>Edit</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $db->where('shop_id','1');
                    $shop_data=$db->getOne('tbl_shop');

                    ?>
                    <tr>
                      <td class="no-br-tp no-pad">
                        <h1>
                        <span class=""><?php echo $shop_data['shop_name']; ?></span>
                        <span class="fl-r">INVOICE</span>
                      </h1>
                      <h6>
                        <span class=""><?php echo $shop_data['shop_address']; ?></span> <br>
                        <span class="">Contact # <?php echo $shop_data['shop_contact']; ?></span> 
                      </h6>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="no-br-tp no-pad">
                        <p><span class="fn-w fn-h">Invoice No. :</span><span class="fn-co"><?php echo $in_data['inv_id']; ?></span></p>
                      </td>
                      <td class="no-br-tp no-pad">
                        <p><span class="fn-w fn-h">Invoive Date: </span><span class="fn-co"><?php echo $newDate = date("d-m-Y", strtotime($in_data['p_inv_date'])); ?></span></p>
                      </td>
                    </tr>
                    <tr>
                      <td class="no-br-tp no-pad">
                        <p><span class="fn-w fn-h">Customer :</span><span class="fn-co"><?php $db->where('cus_id',$in_data['cus_name']); $cusName=$db->getOne('tbl_customer'); echo $cusName['cus_name']; ?></span></p>
                      </td>
                      <td class="no-br-tp no-pad">
                        <p><span class="fn-w fn-h">Address: </span><span class="fn-co"><?php echo $cusName['cus_city']; ?></span></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row rw-h">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="no-pad text-center fn-w fn-h">Product</th>
                      <th class="no-pad text-center fn-w fn-h">Quantity</th>
                      <th class="no-pad text-center fn-w fn-h">Price</th>
                      
                      <th class="no-pad text-center fn-w fn-h">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($item_data as $it_da){ ?>

                      <tr>
                      <td class="no-pad">
                        <p class="text-center mr-btm"><span class="fn-co"><?php echo $it_da['pro_name']; ?></span></p>
                      </td>
                      <td class="no-pad">
                        <p class="text-center mr-btm"><span class="fn-co"><?php echo $it_da['pro_qty']; ?></span></p>
                      </td>
                      <td class="no-pad">
                        <p class="text-center mr-btm"><span class="fn-co"><?php echo $it_da['pro_rate']; ?></span></p>
                      </td>
                      
                      <td class="no-pad">
                        <p class="text-center mr-btm"><span class="fn-co"><?php echo $it_da['total_price']; ?></span></p>
                      </td>
                    </tr>


                      <?php

                    }

                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="table-responsive" style="overflow-x: hidden;">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="no-pad">
                        <p class="mr-btm fn-w fl-r"><span class="fn-h" style="margin-right: 10px;">Total</span></p>
                      </td>
                      <td class="no-pad" style="border-right: 2px solid #4f4f4f !important;">
                        <p class="text-center mr-btm fn-w"><span class="fn-co"><?php echo $in_data['grand_total']; ?></span></p>
                      </td>
                    </tr>
                    
                    <tr>
                      <td class="no-pad">
                        <p class="mr-btm fn-w fl-r"><span class="fn-h" style="margin-right: 10px;">Received </span></p>
                      </td>
                      <td class="no-pad" style="border-right: 2px solid #4f4f4f !important;">
                        <p class="text-center mr-btm fn-w"><span class="fn-co"><?php echo $in_data['paid_amount']; ?></span></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row" style="margin-top: 30px;">
              <div class="table-responsive" style="overflow-x: hidden;overflow-y: hidden;">
                <table class="table">
                  <thead>
                    <tr>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="no-br-tp no-pad">
                        <p class="mr-btm fn-w" ><span class="fn-h txt-de">Signature: </span><span>_______________</span></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
  <?php include '../../libraries/footer.php'; ?>
    <!-- End custom js for this page-->
  </body>
  <script>
  function myFunction() {
      window.print();
  }

  function PrintInvoice(inv_id) {

    if(inv_id != ''){

      $.ajax({
      type:'POST',
      url:'ajax-print.php', 
      data:{ action:'print_invoice', inv_id:inv_id   },
      success:function(responce){

      }
      });

    }

    


  }
</script>
</html>