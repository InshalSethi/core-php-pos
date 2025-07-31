<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';
  



  $page_title='Inventory | Suppliers List';



  if ( isset($_REQUEST['del_id']) ) {

    

    $x=$_REQUEST['del_id'];

    $del_id=decode($x);



    $db->where('cus_id',$del_id);

    $db->delete('tbl_customer');



    header("LOCATION:supplier-list.php");

  }





  function CheckBalanceSuppplier($cus_id,$db){

    $total_received=0;

    $total_receiveAble=0;

    $Balance=0;

    $data = $db->rawQuery("SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' UNION ALL SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL ");

    //echo "----".$db->getLastQuery();

    //var_dump($data);



    foreach($data as $da){ 

    if($da['status'] == 'PURCHASE'){



      $total_receiveAble+=$da['total_amount'];

      $total_received+=$da['received_amount'];

    } 

    if ($da['status'] == 'CASH_PAYMENT') {

      $total_received+=$da['received_amount'];

    }

    if($da['status'] == 'PURCHASE_RETURN'){

      $total_received+=$da['received_amount'];

    }



  }

  $Balance=$total_receiveAble-$total_received;

    return (int)$Balance;



  }

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $page_title; ?></title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <style>

      table.dataTable td {

    padding: 1px!important;

    font-size: 14px!important;

    text-align: center !important;

    }

    .th-set{

        padding: 3px!important;

      }

    </style>



  </head>

  <body>

    <div class="container-scroller">

   <?php include '../../libraries/nav.php'; ?>

      <div class="container-fluid page-body-wrapper">

        <?php include '../../libraries/sidebar.php'; ?>

      <div class="main-panel" style="width: 100%;">
        <?php 
        

        $supplier_view=CheckPermission($permissions,'supplier_view');
        if($supplier_view ==1){ ?>

        <div class="content-wrapper">

          <div class="card">

            <div class="card-body">

              <div class="row" style="padding: 13px 0px;">

                <div class="col-md-2">
                  <?php 
                  $add_supplier=CheckPermission($permissions,'add_supplier');
                  if($add_supplier == 1){ ?>
                   <a href="add-supplier.php" class="btn btn-dark">Add  Supplier</a>

                    <?php

                  }

                  ?>

                  

                </div>

                <div class="col-md-8">

                  <div class="float-right">

                    <h3>Total Balance : <span id="total_balance" style="color: red;"></span></h3>

                  </div>

                </div>

                

              </div>

              <h4 class="card-title">Suppliers</h4>

              <div class="row">

                <div class="col-12">

                  <?php

                  $db->where("cus_type","2");

                  $sup_data=$db->get('tbl_customer');



                   ?>

                  <div class="table-responsive">

                    <table id="order-listing" class="table">

                      <thead>

                        <tr>

                            <th>NO.</th>

                            <th>Supplier Name</th>

                            <th>Contact Person</th>

                            <th>Contact No.</th>

                            <th>Address</th>

                            <th>Balance</th>

                            <th>Actions</th>

                        </tr>

                      </thead>

                      <tbody>

                        <?php 

                        $totalBalance=0;

                        $i=1;

                        foreach($sup_data as $sup_da){

                          $enc=encode($sup_da['cus_id']);



                         ?>



                          <tr>

                            <td><?php echo $i ?></td>

                            <td><a href="supplier-detail.php?cus=<?php echo $enc; ?>"><?php echo $sup_da['cus_name']; ?></a></td>

                            <td><?php echo $sup_da['con_person']; ?></td>

                            <td><?php echo $sup_da['cus_phone']; ?></td>

                             <td><?php echo $sup_da['cus_city']; ?></td>

                             <td><?php 

                             

                             $balnceCustomer= CheckBalanceSuppplier($sup_da['cus_id'],$db);

                             echo $balnceCustomer;

                            $totalBalance=$balnceCustomer +$totalBalance;

                             ?></td>

                            

                            

                            <td>

                              
                              <?php 
                              $supplier_update=CheckPermission($permissions,'supplier_update');
                              if($supplier_update == 1){ ?>
                              <a href="edit-supplier.php?sup=<?php echo $enc; ?>" class="btn btn-outline-success">Edit</a>

                              <?php } ?>

                              <?php 
                              $supplier_delete=CheckPermission($permissions,'supplier_delete');
                              if($supplier_delete == 1){ ?>
                              <a onclick="Remove_Supplier('<?php echo $enc; ?>')" class="btn btn-outline-danger">Delete</a>

                              <?php } ?>
                              

                              

                            </td>

                          </tr>





                          <?php

                          $i++;

                        }





                        ?>

                        

                        

                      </tbody>

                    </table>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

        <?php } else{
        echo "<h2 class='text-danger'>You Don't have permission to use this page contact with admin. Thank You</h2>";
        } ?>


        <!-- content-wrapper ends -->

        <!-- partial:../../partials/_footer.html -->

         <?php include '../../libraries/footer.php'; ?>

        <!-- partial -->

      </div>

      <!-- main-panel ends -->

      

        



        



      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->

 <?php include '../../libraries/js_libs.php'; ?>

  <script>

      var total_balnce='<?php echo $totalBalance; ?>';

    $('#total_balance').text(total_balnce);

  </script>



  </body>

</html>