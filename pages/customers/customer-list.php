<?php 

  

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';



  $page_title='Inventory | Customers List';



  if ( isset($_REQUEST['del_id']) ) {



    $x=$_REQUEST['del_id'];

    $del_id=decode($x);

    $db->where('cus_id',$del_id);

    $db->delete('tbl_customer');

    header("LOCATION:customer-list.php");



  }





  function CheckBalanceCustomer($cus_id,$db){

    $total_received=0;

    $total_receiveAble=0;

    $Balance=0;

    $data = $db->rawQuery("SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' UNION ALL SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL ");

    //echo "----".$db->getLastQuery();

    //var_dump($data);



    foreach($data as $da){ 

      if($da['status'] == 'SALE'){



        $total_receiveAble += (float)($da['total_amount'] ?? 0);

        $total_received += (float)($da['received_amount'] ?? 0);

      } 

      if ($da['status'] == 'CASH_RECEIVED') {

        $total_received += (float)($da['received_amount'] ?? 0);

      }

      if($da['status'] == 'SALE_RETURN'){

        $total_received += (float)($da['received_amount'] ?? 0);

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



        <div class="modal fade" id="customer_detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h3 class="modal-title" id="exampleModalLabel">Customer Detail</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body" id="modal-body" >

                

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>



         <!-- partial -->

      <div class="main-panel" style="width: 100%;">
        <?php 
        

        $customer_view=CheckPermission($permissions,'customer_view');
        if($customer_view ==1){ ?>

        <div class="content-wrapper">

          <div class="card">

            <div class="card-body">

              <div class="row" style="padding: 13px 0px;">

                <div class="col-md-2">
                  <?php 
                  $add_customer=CheckPermission($permissions,'add_customer');
                  if($add_customer == 1){ ?>
                   <a href="add-customer.php" class="btn btn-dark">Add Customer</a>

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

              <h4 class="card-title">Customers</h4>

              <div class="row">

                <div class="col-12">

                  <?php

                  

                  $db->where('cus_type','1');

                  $customers=$db->get('tbl_customer');





                   ?>

                  <div class="table-responsive">

                    <table id="order-listing" class="table">

                      <thead>

                        <tr>

                            <th class="th-set text-center" >NO.</th>

                            <th class="th-set text-center" >Customer Name</th>

                            <th class="th-set text-center">City</th>

                            <th class="th-set text-center" >Contact No.</th>

                            <th class="th-set text-center" >Balance</th>

                            <th class="th-set text-center" style="width: 210px!important;" >Actions</th>

                        </tr>

                      </thead>

                      <tbody>

                        <?php 

                        $totalBalance=0;

                        $i=1;

                        foreach($customers as $sup_da){

                          $enc=encode($sup_da['cus_id']);



                         ?>



                          <tr>

                            <td><?php echo $i ?></td>

                            <td>

                              <a href="<?php echo base_url('pages/customers/customer-details.php'); echo '?cus='.$enc; ?>">

                                <?php echo $sup_da['cus_name']; ?> 

                              </a> 

                            </td>

                            <td><?php echo $sup_da['cus_city']; ?></td>

                            <td><?php echo $sup_da['cus_mobile']; ?></td>

                            <td><?php 

                            $balnceCustomer= CheckBalanceCustomer($sup_da['cus_id'],$db); 

                            echo $balnceCustomer;

                            $totalBalance=$balnceCustomer +$totalBalance;

                            

                            ?></td>

                            

                            

                            <td>

                              <a onclick="ShowCustomerDetail('<?php echo $enc; ?>')" class="btn btn-outline-primary">View</a>

                              <?php 
                              $customer_update=CheckPermission($permissions,'customer_update');
                              if($customer_update == 1){ ?>
                              <a href="edit-customer.php?cus=<?php echo $enc; ?>" class="btn btn-outline-success">Edit</a>

                              <?php } ?>

                              <?php 
                              $customer_delete=CheckPermission($permissions,'customer_delete');
                              if($customer_delete == 1){ ?>
                              <a onclick="Remove_customer('<?php echo $enc; ?>')" class="btn btn-outline-danger">Delete</a>

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

    function ShowCustomerDetail(cus_id){

     // AJAX request

    $.ajax({

    url: '../ajax/ajax-show-detail.php',

    datatype: 'html',

    type: 'post',

    data: {cus_id: cus_id,action:'customer_detail'},

    success: function(html){ 



    $('#modal-body').html(html);

    $('#customer_detailModal').modal('show'); 



    }

    

    });

       

    }

  </script>



  </body>

</html>