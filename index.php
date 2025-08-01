<?php

   

    include 'include/functions.php';

    include 'include/MysqliDb.php';

    include 'include/config.php';
    include 'include/permission.php';


    ?>

<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS</title>
    <?php include 'libraries/libs.php'; ?>
    <?php include 'include/auth.php'; ?>
  </head>

<style>
  .my-custom-scrollbar {
    position: relative;
    height: 600px;
    overflow: auto;
  }
  .table-wrapper-scroll-y {
    display: block;
  }

  .attend{

      background-color: #6da252;

      color:white;

    }

  .not-attend{

    background-color: yellow;



    }

  @media only screen and (min-width: 320px) and (max-width: 480px){

    .col4{

    padding-right: 15px!important;

  }

  .col8{

    padding-left: 15px!important;

  }

  }

  .col4{

    padding-right: 0px;

  }

  .col8{

    padding-left: 0px;

  }

    .set-card-body{

          padding-left: 5px!important;

          padding-right: 5px!important;

          padding-top: 20px!important;

          padding-bottom: 20px!important

    }

    .set-outer{

      padding: 10px;

      background: white;

      border-radius: 6px;

    }

    .search-btn{

      background: #6da252;

      border-color: #6da25200;

      box-shadow: 0 2px 2px 0 rgb(193, 193, 193), 0 3px 1px -2px rgb(241, 241, 241), 0 1px 5px 0 rgb(193, 193, 193);

    }

    .card{

      background-color: #f9fafc;

    }

    .income-box{

      height: 100%;

      background: linear-gradient(87deg, #328aef 0, #66e8ff 100%) !important;

      text-align: center;

      font-size: 73px;

      color: white;

      border-radius: 5px;

    }

    .expenses-box{

      height: 100%;

      background: linear-gradient(87deg, #ef3232 0, #ff7d66 100%) !important;

      text-align: center;

      font-size: 73px;

      color: white;

      border-radius: 5px;

    }

    .profit-box{

      height: 100%;

      background: linear-gradient(87deg, #6da252 0, #b8d3a9 100%) !important;

      text-align: center;

      font-size: 73px;

      color: white;

      border-radius: 5px;

    }

    .customers-box{

      height: 100%;

      background: linear-gradient(87deg, #f6b200 0, #fcce5e87 100%) !important;

      text-align: center;

      font-size: 73px;

      color: white;

      border-radius: 5px;

    }

    .employees-box{

      height: 100%;

      background: linear-gradient(87deg, #58aaaf 0, #82e1a1 100%) !important;

      text-align: center;

      font-size: 73px;

      color: white;

      border-radius: 5px;

    }

    .card .card-title{

      font-size: 16px!important;

      color: black!important;

    }

    .rupe-set{

      font-size: 16px!important

    }

    .form-group{

      margin-bottom: 0.5rem;

    }

    .grid-margin{

        margin-bottom: 0.6rem;

    }

</style>

  <body>

    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->

 <?php include 'libraries/nav.php'; ?>

 

      <!-- partial -->

      <div class="container-fluid page-body-wrapper">

        <!-- partial:partials/_settings-panel.html -->

        

        <!-- partial -->

        <!-- partial:partials/_sidebar.html -->

        <?php include 'libraries/sidebar.php'; ?>

        <!-- partial -->



        <div class="main-panel">

          <div class="content-wrapper">
            <?php 
            $dashboard_view=CheckPermission($permissions,'dashboard_view');
            if($dashboard_view ==1){ ?>

           

            <div class="row">

            <div class="col-md-8">

              <div class="set-outer card-border-color">

              <div class="row">

                <div class="col-lg-12">

                  <div class="d-lg-flex align-items-baseline">
                    

                    <h5 class="text-dark mb-0">Dashboard</h5>

                    <!-- <p class="ml-md-3 font-weight-light mb-0 mt-1">Last login was 23 hours ago. View details</p> -->

                  </div>

                </div>

              </div>

              <!-- 6 Boxed -->

              <?php //if($accessStats == 1){ ?>

              <div class="row mt-4">

                  <div class="col-md-6">

                    <div class="card">

                      <div class="row">

                        <div class="col-md-4 col4">

                          <div class="income-box">

                            <i class="mdi mdi-account-convert"></i>

                          </div>

                        </div>

                        <div class="col-md-8 col8">

                            <div class="card-body set-card-body">

                            <h4 class="card-title"><a href="">SUPPLIERS</a> </h4>

                            <div class="d-flex justify-content-between">

                              <?php

                              $db->where("cus_type","2"); 

                              $totalSupplier=$db->getValue('tbl_customer','COUNT(*)'); ?>

                              <p class="text-dark rupe-set"><?php echo $totalSupplier; ?></p>

                            </div>

                          </div>

                        </div>

                      </div>

                      

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="card">

                      <div class="row">

                        <div class="col-md-4 col4">

                          <div class="expenses-box">

                            <i class="mdi mdi-human-greeting"></i>

                          </div>

                        </div>

                        <div class="col-md-8 col8">

                            <div class="card-body set-card-body">

                            <h4 class="card-title"><a href="">CUSTOMERS</a></h4>

                            <div class="d-flex justify-content-between">

                              <?php

                              $db->where("cus_type","1"); 

                              $totalClient=$db->getValue('tbl_customer','COUNT(*)'); ?>

                              <p class="text-dark rupe-set"><?php echo $totalClient; ?>

                            </div>

                          </div>

                        </div>

                      </div>

                      

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="card">

                      <div class="row">

                        <div class="col-md-4 col4">

                          <div class="profit-box">

                            <i class=" mdi mdi-cash-100"></i>

                          </div>

                        </div>

                        <div class="col-md-8 col8">

                            <div class="card-body set-card-body">

                            <h4 class="card-title"> TOTAL SALE AMOUNT </h4>

                            <div class="d-flex justify-content-between">

                              <?php

                              $currentDate=date("Y-m-d");

                              $db->where("sale_type","1"); 

                              $db->where("p_inv_date",$currentDate);

                              $totalSaleAmount=$db->getValue('tbl_invoice','SUM(grand_total_w_dis)');

                               ?>

                              <p class="text-dark rupe-set">

                                  <?php echo number_format($totalSaleAmount); ?>

                              </p>

                            </div>

                          </div>

                        </div>

                      </div>

                      

                    </div>

                  </div>

                  

                  <div class="col-md-6">

                    <div class="card">

                      <div class="row">

                        <div class="col-md-4 col4">

                          <div class="employees-box">

                            <i class="mdi mdi-account-circle"></i>

                          </div>

                        </div>

                        <div class="col-md-8 col8">

                            <div class="card-body set-card-body">

                            <h4 class="card-title">RETAIL COUNTER </h4>

                            <div class="d-flex justify-content-between">

                              <?php

                              $currentDate=date("Y-m-d");

                              $db->where("sale_type","2"); 

                              $db->where("p_inv_date",$currentDate);

                              $totalSaleAmountRetail=$db->getValue('tbl_invoice','SUM(grand_total_w_dis)');



                               ?>

                              <p class="text-dark rupe-set">

                                  <?php echo number_format($totalSaleAmountRetail); ?>

                              </p>

                            </div>

                          </div>

                        </div>

                      </div>

                      

                    </div>

                  </div>

              </div>

              <?php //}?>

            </div>

              

            </div>

            <div class="col-md-4">

              <div class="row">

                <div class="card set-outer card-border-color">

                  <div class="card-body pb-0">

                    <div class="d-flex flex-wrap justify-content-between">

                      <h5 class="card-title">Accounts</h5>

                    </div>

                  </div>

                  <div class="card-body pl-0 pr-0 pt-0">

                      <div class="table-responsive">

                          <table class="table">

                            <tbody>



                              <?php

                              $ac = 1;

                              $CurrentBalance = 0;

                              $TotalBalance = 0;

                                $accountdata = $db->get("account");

                                foreach ($accountdata as $account) {

                                $account_id = $account['id'];

                                $encrypt = encode($account_id);

                                $account_name = $account['name'];

                                $account_number = $account['account_number'];

                                $bank_name = $account['bank_name'];

                                $account_balance = $account['balance'];

                                $Opening_balance = $account['opening_balance'];

                                

                                $account_status = $account['status'];



                                ///////////////////

              $cols=array("acc.account_number","trs.category","trs.amount",);



              $db->where("acc.id", $account_id);



              $db->join("account acc", "trs.account=acc.id", "INNER");



              $transfersdata = $db->get("transactions trs",null,$cols);

              $Balance = 0;

              foreach($transfersdata as $transfers){

                    if($transfers['category'] == 'sale invoice'){
                          // $receipt = 'Income';
                          $receipt = (float)$transfers['amount'];
                          $Balance += $receipt;
                      }else{
                          $receipt = 0;
                      }
                      if($transfers['category'] == 'receipt voucher'){

                          // $receipt = 'Income';
                          $receipt = (float)$transfers['amount'];
                          $Balance += $receipt;
                      }else{
                          $receipt = 0;
                      }
                      if($transfers['category'] == 'payment voucher'){
                          $payments = (float)$transfers['amount'];
                          $Balance -= $payments;
                      }else{
                          $payments = 0;
                      }
                      if($transfers['category'] == 'Expense'){
                         // $payments = 'Expense';
                          $payments = (float)$transfers['amount'];
                          $Balance -= $payments;
                      }else{
                          $payments = 0;
                      }
                      if($transfers['category'] == 'purchase invoice'){
                          // $payments = 'Expense';
                          $payments = (float)$transfers['amount'];
                          $Balance -= $payments;
                      }else{
                          $payments = 0;
                      }
                      if($transfers['category'] == 'Funds Transfer From'){
                          $transferAmountFrom = (float)$transfers['amount'];
                          $Balance -= $transferAmountFrom;
                      }else{
                          $transferAmountFrom = 0;
                      }
                      if ($transfers['category'] == 'Funds Transfer To') {
                          $transferAmount = (float)$transfers['amount'];
                          $Balance += $transferAmount;
                      }else{
                          $transferAmount = 0;
                      }
                  }    $CurrentBalance = $Balance + $Opening_balance;

                  $TotalBalance += $CurrentBalance;
                  ?>



                                <tr>

                                <td class="border-0 pt-0">

                                  <div class="d-flex">

                                    <div class="mr-3">

                                      <img class="img-sm rounded-circle mb-md-0" src="https://via.placeholder.com/25*25" alt="profile image">

                                    </div>

                                    <div>

                                      <?php echo $account_name;  ?>

                                      <div class="text-muted"><?php echo $account_number;  ?></div>

                                    </div>

                                  </div>

                                </td>

                                <td class="border-0 pt-0">

                                  <div class="text-muted"><?php echo number_format($CurrentBalance);  ?></div>

                                </td>

                              </tr>

                                

                               

                              <?php $ac++; } ?>





                              

                              

                              

                            </tbody>

                          </table>

                        </div>

                  </div>

              </div> 

                

              </div>

            </div>

            <div class="col-md-8">

              <div class="set-outer card-border-color">
                

              <div class="card">
                <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                  <?php 
                                  $domainData=$db->get('tbl_product_domain');
                                  ?>
                                  <select id="domain" class="form-control date_from inp-pad">
                                  <option value="">Select Domain</option>
                                  <?php 
                                    foreach($domainData as $dom){ ?>
                                    <option value="<?php echo $dom['dom_id']; ?>"><?php echo $dom['dom_name']; ?></option>
                                    <?php
                                    }
                                  ?>
                                  </select>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success search_filter btn-saerch" onclick="ShowReOrderStock()" title="click here to search">Search</button>
                        </div>
                    </div>
                </div>
              </div>
                  <div class="card-body pb-0">
                    <div class="d-flex flex-wrap justify-content-between">
                      <h5 class="card-title">RE-ORDER STOCK </h5>
                    </div>
                  </div>
                  
                  <div class="card-body pl-0 pr-0 pt-0">
                      <div class="table-wrapper-scroll-y my-custom-scrollbar">
                          <table class="table">
                            <thead>
                              <tr>
                                <th class="pt-0"> 
                                  PRODUCT NAME
                                </th>
                                <th class="pt-0">QUNTITY LEFT</th>
                                <th class="pt-0">REORDER LEVEL</th>
                                <th class="pt-0">SUPPLIER PRICE</th>
                                <th class="pt-0">SUPPLIER</th>
                              </tr>
                            </thead>
                            <tbody id="re-order-stock">

                              <?php 

                              $lessProData = $db->rawQuery("SELECT pro_name,pro_qty,pro_id,pro_reorder FROM tbl_products as pro WHERE is_delete='0'");

                              

                              foreach($lessProData as $proLess){ 
                                $stockQty=(int) $proLess['pro_qty'];
                                $orderLevel=(int) $proLess['pro_reorder'];
                                if ($orderLevel =='') {
                                  continue;
                                }

                                
                                if ($stockQty > $orderLevel ) {
                                  continue;
                                }


                                ?>
                              <tr class="re-order-stock">
                                <td>
                                   <?php echo $proLess['pro_name']; ?>
                                </td>
                                <td class="text-muted">
                                  <?php echo $proLess['pro_qty']; ?>
                                </td>
                                <td class="text-muted">
                                    <?php echo $proLess['pro_reorder']; ?>
                                </td>
                                <td class="text-muted">
                                    <?php $data=GetProductSupplierDetail($proLess['pro_id'],$db);
                                    echo $data['price'];
                                    ?>
                                </td>
                                <td class="border-0 pt-0">
                                  <div class="d-flex">
                                    <div class="mr-3">
                                      <img class="img-sm rounded-circle mb-md-0" src="https://via.placeholder.com/25*25" alt="profile image">
                                    </div>
                                    <div>
                                    <?php 
                                    echo $data['sup_name'];
                                    ?>
                                    <div class="text-muted"><?php echo $data['contact']; ?></div>
                                    </div>
                                  </div>
                                </td>
                                </tr>

                                <?php

                                  

                              }

                              ?>

                                

                            </tbody>

                          </table>

                        </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="col-md-4">
              

              <div class="row">

                <div class="card set-outer card-border-color">
                  <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                  
                                  <select id="domain-out" class="form-control date_from inp-pad">
                                  <option value="">Select Domain</option>
                                  <?php 
                                    foreach($domainData as $dom){ ?>
                                    <option value="<?php echo $dom['dom_id']; ?>"><?php echo $dom['dom_name']; ?></option>
                                    <?php
                                    }
                                  ?>
                                  </select>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success search_filter btn-saerch" onclick="ShowOutofStock()" title="click here to search">Search</button>
                        </div>
                    </div>
                </div>
              </div>

                  <div class="card-body pb-0">

                    <div class="d-flex flex-wrap justify-content-between">

                      <h5 class="card-title">OUT OF STOCK</h5>

                    </div>

                  </div>

                  <div class="card-body pl-0 pr-0 pt-0">


                      <div class="table-wrapper-scroll-y my-custom-scrollbar">

                          <table class="table">

                            <tbody id='out-of-stock'>

                            <?php 

                            $db->where('is_delete','0');

                            $db->where('pro_qty','0');

                            $products=$db->get('tbl_products');

                            foreach($products as $pro){ ?>

                                

                                

                               

                              <tr class="out-of-stock">

                                <td class="border-0 pt-0">

                                  <div class="d-flex">

                                    

                                    <div>

                                      <?php echo $pro['pro_name'];

                                      $data=GetProductSupplierDetail($pro['pro_id'],$db)

                                      ?>

                                      <div class="text-muted"><?php echo $data['sup_name']; ?></div>

                                    </div>

                                  </div>

                                </td>

                                <td class="border-0 pt-0">

                                  <div class="text-muted"><?php echo $data['price']; ?></div>

                                </td>

                                <td class="border-0 pt-0">

                                  <div class="text-muted"><?php echo $data['contact']; ?></div>

                                </td>

                              </tr>

                              

                               <?php

                            }

                            ?>

                              

                              

                            </tbody>

                          </table>

                        </div>

                  </div>

              </div> 

                

              </div>

            </div>

            <div class="col-md-6">

              <div class="set-outer card-border-color">

              <div class="card">

                  <div class="card-body pb-0">

                    <div class="d-flex flex-wrap justify-content-between">

                      <h5 class="card-title"> TOP SOLD PRODUCTS ( LAST MONTH) </h5>

                      

                    </div>

                    

                  </div>

                  <div class="card-body pl-0 pr-0 pt-0">

                      <div class="table-responsive">

                          <table class="table">

                            <thead>

                              <tr>

                                <th class="pt-0"> 

                                  PRODUCT NAME

                                </th>

                                <th class="pt-0">QUNTITY SOLD</th>

                                <th class="pt-0">AMOUNT</th>

                              </tr>

                            </thead>

                            <tbody>

                              <?php
                              $startDay = date("Y-m-d", strtotime("first day of previous month"));
                              $lastDay =  date("Y-m-d", strtotime("last day of previous month"));

                              $TopProducts = $db->rawQuery("SELECT de.pro_id,SUM(de.pro_qty) as qty FROM tbl_invoice as inv INNER JOIN tbl_invoice_detail AS de ON inv.inv_id=de.inv_id  WHERE inv.p_inv_date BETWEEN '$startDay' AND '$lastDay' GROUP BY de.pro_id ORDER BY qty DESC LIMIT 10");

                              
                              foreach ($TopProducts as $pro) { ?>
                                <tr>
                                  <td>
                                     <?php
                                          $db->where('pro_id',$pro['pro_id']); 
                                     echo $proName=$db->getValue('tbl_products','pro_name'); ?>
                                  </td>
                                  <td class="text-muted">
                                      <?php echo $pro['qty'];  ?>
                                  </td>
                                  <td class="text-muted">
                                    <?php
                                      $db->where('pro_id',$pro['pro_id']); 
                                      $proPrice=$db->getValue('tbl_products','sell_price');
                                      $total_qty=(int) $pro['qty'];

                                      $aftermul=$total_qty * $proPrice;
                                      echo number_format($aftermul);


                                      ?>
                                      
                                  </td>
                                </tr>


                                <?php
                                  
                              } 
                              ?>

                              

                              

                                

                            </tbody>

                          </table>

                        </div>

                  </div>

                </div>

              </div>

            </div>

            <div class="col-md-6">

              <div class="set-outer card-border-color">

              <div class="card">

                  <div class="card-body pb-0">

                    <div class="d-flex flex-wrap justify-content-between">

                      <h5 class="card-title"> MAX SALE DOMAIN (LAST MONTH) </h5>

                      

                    </div>

                    

                  </div>

                  <div class="card-body pl-0 pr-0 pt-0">

                      <div class="table-responsive">

                          <table class="table">

                            <thead>

                              <tr>

                                <th class="pt-0"> 

                                  DOMAIN NAME

                                </th>

                                

                                <th class="pt-0">TOTAL AMOUNT.</th>

                              </tr>

                            </thead>

                            <tbody>
                              <?php

                              $i=1;
                              $domains=array();

                              $TopProducts = $db->rawQuery("SELECT de.pro_id,SUM(de.pro_qty) as qty, pro.retail_price,pro.pro_domain,(SUM(de.pro_qty) * pro.retail_price ) as total_sum FROM tbl_invoice as inv INNER JOIN tbl_invoice_detail AS de ON inv.inv_id=de.inv_id INNER JOIN tbl_products as pro on de.pro_id=pro.pro_id   WHERE inv.p_inv_date BETWEEN '$startDay' AND '$lastDay' GROUP BY de.pro_id ORDER BY qty DESC");

                              foreach($TopProducts as $pro){
                               if (in_array($pro['pro_domain'], $domains))
                                {
                                  continue;
                                }
                                array_push($domains,$pro['pro_domain']);
                              }
                              

                              

                              $index=0;
                              for ($i=0; $i < count($domains); $i++) { 
                                $domainID=$domains[$i];
                                $sum=0;
                                foreach($TopProducts as $pro){
                                  if($pro['pro_domain'] ==$domainID){
                                    $sum+=$pro['total_sum'];
                                  }

                                }
                                ?>

                                <tr>
                                  <td>
                                     <?php
                                      
                                     $db->where('dom_id',$domains[$i]); 
                                     echo $Domain=$db->getValue('tbl_product_domain','dom_name');

                                      ?>
                                  </td>
                                  <td class="text-muted">
                                      <?php echo number_format($sum);  ?>
                                  </td>
                                  
                                </tr> 


                                <?php
                               
                              }
                              

                                

                              
                               

                                
                              

                                

                              ?>

                               

                                


                                

                              

                              

                                

                            </tbody>

                          </table>

                        </div>

                  </div>

                </div>

              </div>

            </div>
          <?php } else{  ?>
            <div class="col-md-12">
              <p class="text-danger"></p>
              
            </div>

            <?php
          } ?>



          </div>

          </div>

          <!--modal-->



          <!--modal-->

          

          

          

          <!-- content-wrapper ends -->

          <!-- partial:partials/_footer.html -->

          <?php include 'libraries/footer.php'; ?>

          <!-- partial -->

        </div>

        <!-- main-panel ends -->

      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->

    <!-- base:js -->

    <?php include 'libraries/js_libs.php'; ?>

    <script>

    $(window).on('load',function(){

    $('#myModal').modal('show');

    });

    function ShowOutofStock(){
      var domian_id_out=$( "#domain-out option:selected" ).val();
      if(domian_id_out != ''){
        $.ajax({
        url: 'pages/ajax/ajax-show-detail.php',
        datatype: 'html',
        type: 'post',
        data: {domian_id: domian_id_out,action:'show_outof_stock'},
        success: function(html){ 

          
          $(".out-of-stock").remove();
          $("#out-of-stock").html(html);
          
        }
        });

      }
    }


    function ShowReOrderStock(){


      var domian_id=$( "#domain option:selected" ).val();
      if(domian_id != ''){
        $.ajax({
        url: 'pages/ajax/ajax-show-detail.php',
        datatype: 'html',
        type: 'post',
        data: {domian_id: domian_id,action:'show_reorder_stock'},
        success: function(html){ 

          
          $(".re-order-stock").remove();
          $("#re-order-stock").html(html);
          
        }
        });

      }
      
      
      
    }

    </script>

  </body>



</html>