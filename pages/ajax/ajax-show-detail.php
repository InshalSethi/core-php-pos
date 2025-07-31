<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';






  if ( isset($_POST['action']) ) {



    $action=$_POST['action'];

    if($action == 'get_category_info'){

      $id= (int) $_POST['id'];

      $db->where ("deleted_at", NULL, 'IS');
      $db->where('id',$id);
      $category = $db->getOne("categories");
      // var_dump($category);die();
      echo json_encode($category);
    }

    if($action == 'show_outof_stock'){

      $domain_id= (int) $_POST['domian_id'];

      $db->where('is_delete','0');
      $db->where('pro_domain',$domain_id);
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

                          


    }


    if($action =='show_reorder_stock'){

      $domain_id= (int) $_POST['domian_id'];
      

      $lessProData = $db->rawQuery("SELECT pro_name,pro_qty,pro_id,pro_reorder FROM tbl_products as pro WHERE pro.is_delete='0' and pro.pro_domain ='".$domain_id."'");
      
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



    }



    if ($action == 'get_dropdownvalue') {



      $type=$_POST['type_val'];



      $db->where("cus_type",$type);

      $data=$db->get("tbl_customer");



      ?>

      <option class="drop-val" value="">Select Party</option>



      <?php

      foreach($data as $da){ 

        $enc=encode($da['cus_id']);



        ?>

         <option class="drop-val" value="<?php echo $enc; ?>"><?php echo $da['cus_name'] ?></option>

        <?php

      }





      

    }

    



    if ($action == 'show_cash_received_voucher') {

      

     

      $voc_id=$_POST['voc_id'];



      $db->where("id",$voc_id);

      $data=$db->getOne("client_payments");



      $db->where("cus_id",$data['client_id']);

      $cus=$db->getOne("tbl_customer");

      ?>



      <div class="row">

        <div class="col-md-12">

          <div class="text-center">

            <h2><span style='color:red;'>Cash Received Voucher <?php echo ChangeFormate($data['date']); ?></span></h2>

          </div>

        </div>

      </div>



      <div class="row">

        <div class="col-sm-4 col-xs-6">

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total:</b> </span>

            <span class="float-xs-right">Rs <?php echo $data['amount']; ?></span>

          </div>

          <hr class="hr">                                                          

        </div>

      </div>



      <div class="row">

        <div class="col-md-12">

          <table class="table table-bordered table-primary">

            <thead>

              <tr>

                <th>SR. No#</th>                                        

                <th >Account Name</th>
                <th >Note</th>

                <th >Amount</th>                                    

              </tr>

            </thead>

            <tbody>

              <tr>

                <td><?php echo '1'; ?></td>

                <td><?php echo $cus['cus_name']; ?></td>

                <td><?php echo $data['payment_note']; ?></td>

                <td>Rs <?php echo $data['amount']; ?></td>

              </tr>                                                                  

            </tbody>

          </table>

        </div>

      </div>

      <?php







    }







    if ($action == 'show_cash_payment_voucher') {

      

      

      $voc_id=$_POST['voc_id'];



      $db->where("id",$voc_id);

      $data=$db->getOne("supplier_payments");

      $db->where("cus_id",$data['supplier_id']);

      $cus=$db->getOne("tbl_customer");



       $i=1;









      ?>



      <div class="row">

        <div class="col-md-12">

          <div class="text-center">

            <h2><span style='color:red;'>Cash Payment Voucher <?php echo ChangeFormate($data['date']); ?></span></h2>

          </div>

        </div>

      </div>



      <div class="row">

        <div class="col-sm-4 col-xs-6">

            

          

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total:</b> </span>

            <span class="float-xs-right">Rs <?php echo $data['amount']; ?></span>                     

          </div>

            <hr class="hr">

                                                                     

        </div>

      </div>



      <div class="row">

        



        <div class="col-md-12">

          <table class="table table-bordered table-primary">

            <thead>

              <tr>

                <th>SR. No#</th>                                        

                <th >Supplier Name</th>
                <th >Note</th>

                <th >Amount</th>

                                                    

              </tr>

            </thead>

            <tbody>

              <tr>

                <td><?php echo $i; ?></td>

                <td><?php echo $cus['cus_name']; ?></td>
                <td><?php echo $data['payment_note']; ?></td>

                <td>Rs <?php echo $data['amount']; ?></td>

              </tr>



              

                                                                                

            </tbody>

          </table>

        </div>



      </div>









      <?php







    }



    if ($action == 'package_delivery') {



      $check=0;

      $pac_id=$_POST['pac_id'];



      // get order invoice  qty

      $cols=array("pkg_qty","pkg_id","pkg_name");

      $db->where("pkg_in_id",$pac_id);

      $data=$db->get("tbl_pkg_invoice_detail");

      // check the stock is available or not

      foreach($data as $da){



          $req_pkg_qty=$da['pkg_qty'];

          $result=ChcekInStockPackagesInvoice($da['pkg_id'],$db);

          if ( $req_pkg_qty > $result ) {

            echo $result."  "."<b>".$da['pkg_name']."</b>"." Left In Stock! Update Stock To Delivered Order!"; 

            $check=0;

            break;

          } else{

            $check=1;

          }

          



      }



      if ($check == '1') {





        foreach($data as $da){

          //remove the items from stock

          RemovePackageItems($da['pkg_id'],$da['pkg_qty'],$db);

        }



        $del_date=$_POST['del_date'];

        $arr=array("delivery_status"=>'1',"delivery_date"=>$del_date);

        $db->where("pkg_in_id",$pac_id);

        $db->update("tbl_pkg_invoice",$arr);

        echo '1';

        

      } else{



      }



      

    }





    if($action == 'show_sale_order'){



      

      $or_id=$_POST['id'];



      $db->where("order_id",$or_id);

      $pkg_invoice_detail=$db->get("tbl_sale_orders_detail");

 

      $db->join("tbl_customer cus", "cus.cus_id=ord.cus_name", "INNER");

      $db->where("ord.order_id",$or_id);

      $pkg_invoice_data=$db->get("tbl_sale_orders ord");

      foreach($pkg_invoice_data as $invoice_data ){



      





      ?>

      

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

          <h5>Order To:</h5>

            <h6><b>Name:</b>   <?php echo $invoice_data['cus_name']; ?></h6>

            <h6><b>Address:</b>   <?php echo $invoice_data['cus_address']; ?></h6>

            <h6><b>Phone:</b>   <?php echo $invoice_data['cus_mobile']; ?></h6>



                              

        </div>

        <div class="col-sm-4 col-xs-6">

          

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total:</b> </span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

          </div>

          <hr class="hr">                                                          

        </div>

      </div>

      



      <?php

      } ?>

      <div class="row">

        



        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Pack Name</th> 

                <th>Color</th>                                        

                <th >Order Quantity</th>

                <th >Deliverd Quantity</th>

                <th >Available Quantity (Stock) </th>

                <th >Rate</th>

                <th >Total</th>                                        

              </tr>

            </thead>

            <tbody>

              <?php

              foreach ($pkg_invoice_detail as $pro_da) { ?>



              <tr>

                <td><?php echo $pro_da['pkg_name']; ?></td>

                <td><?php echo $pro_da['pkg_color']; ?></td>

                <td><?php echo $pro_da['pkg_qty']; ?></td>

                <td><?php if ($pro_da['pkg_del_qty'] =='') {

                  echo 0;

                } else{

                  echo $pro_da['pkg_del_qty'];

                } ?></td>

                <td>

                  <?php 

                  $res= ChcekInStockPackagesInvoice($pro_da['pkg_id'],$db);

                  if ( $pro_da['pkg_qty'] > $res   ) {

                     

                     echo "<b style='color:red;'>".$res."</b>";

                  } else{

                    echo "<b>".$res."</b>";

                  }

                  ?>

                    

                </td>

                <td>Rs <?php echo $pro_da['pkg_rate']; ?> </td>

                <td>Rs <?php echo $pro_da['total_price']; ?></td>

              </tr>



              <?php   

              } ?>

                                                                                

            </tbody>

          </table>

        </div>



      </div>



      <?php







    }



    if($action == 'show_sale_return'){



      

      $pkg_in=$_POST['in_id'];



      $db->where("inv_id",$pkg_in);

      $pkg_invoice_detail=$db->get("tbl_salereturn_detail");

 

      $db->join("tbl_customer cus", "cus.cus_id=sale.cus_name", "INNER");

      $db->where("sale.inv_id",$pkg_in);

      $pkg_invoice_data=$db->get("tbl_salereturn_invoice sale");

      foreach($pkg_invoice_data as $invoice_data ){



      





      ?>

      

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

          <h5>Invoice To:</h5>

            <h6><b>Name:</b>   <?php echo $invoice_data['cus_name']; ?></h6>

            <h6><b>Address:</b>   <?php echo $invoice_data['cus_address']; ?></h6>

            <h6><b>Phone:</b>   <?php echo $invoice_data['cus_mobile']; ?></h6>

            <h6><b>Date:</b>   <?php echo ChangeFormate($invoice_data['p_inv_date']); ?></h6>



                              

        </div>

        <div class="col-sm-4 col-xs-6">

            

            <h5>Payment Details:</h5>

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total:</b> </span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

          </div>

            <hr class="hr">

                                                                     

        </div>

      </div>

      



      <?php

      } ?>

      <div class="row">

        



        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Pack Name</th>                                        

                <th >Order Quantity</th>

                <th >Rate</th>

                <th >Total</th>                                        

              </tr>

            </thead>

            <tbody>

              <?php

              foreach ($pkg_invoice_detail as $pro_da) { ?>



              <tr>

                <td><?php echo $pro_da['pro_name']; ?></td>

                <td><?php echo $pro_da['pro_qty']; ?></td>

                

                <td>Rs <?php echo number_format($pro_da['pro_rate']); ?> </td>

                <td>Rs <?php echo number_format($pro_da['total_price']); ?></td>

              </tr>



              <?php   

              } ?>

                                                                                

            </tbody>

          </table>

        </div>



      </div>



      <?php







    }





    if($action == 'show_invoice_pkg'){



      

      $pkg_in=$_POST['in_id'];



      $db->where("inv_id",$pkg_in);

      $pkg_invoice_detail=$db->get("tbl_invoice_detail");

 

      $db->join("tbl_customer cus", "cus.cus_id=pkg.cus_name", "INNER");

      $db->where("pkg.inv_id",$pkg_in);

      $pkg_invoice_data=$db->get("tbl_invoice pkg");

      foreach($pkg_invoice_data as $invoice_data ){



      





      ?>

      

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

          <h5>Invoice To:</h5>

            <h6><b>Name:</b>   <?php echo $invoice_data['cus_name']; ?></h6>

            <h6><b>Address:</b>   <?php echo $invoice_data['cus_address']; ?></h6>

            <h6><b>Phone:</b>   <?php echo $invoice_data['cus_mobile']; ?></h6>



                              

        </div>

        <div class="col-sm-4 col-xs-6">

            

            <h5>Payment Details:</h5>

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total:</b> </span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

          </div>

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Discount:</b> </span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['total_dis']; ?></span>                     

          </div>



           <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Grand Total (After Discount):</b> </span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total_w_dis']; ?></span>                     

          </div>



          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Paid Total:</b> </span>   

            <span class="float-xs-right">Rs <?php echo $invoice_data['paid_amount']; ?></span>                     

          </div>

          <div class="clearfix mb-0-25">

            <span class="float-xs-left"><b>Total Due:</b></span>

            <span class="float-xs-right">Rs <?php echo $invoice_data['total_due']; ?></span>

          </div>

            <hr class="hr">

                                                                     

        </div>

      </div>

      



      <?php

      } ?>

      <div class="row">

        



        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Product Name</th>  

                                                    

                <th > Quantity</th>

                <th >Rate</th>

                <th >Total</th>                                        

              </tr>

            </thead>

            <tbody>

              <?php

              foreach ($pkg_invoice_detail as $pro_da) { ?>



              <tr>

                <td><?php echo $pro_da['pro_name']; ?></td>

                

                <td><?php echo $pro_da['pro_qty']; ?></td>

                

                <td>Rs <?php echo number_format($pro_da['pro_rate']); ?> </td>

                <td>Rs <?php echo number_format($pro_da['total_price']); ?></td>

              </tr>



              <?php   

              } ?>

                                                                                

            </tbody>

          </table>

        </div>



      </div>



      <?php







    }





    if ($action == 'get_pack_qty' ) {



      $pac_id=$_POST['pac_id'];

      $result=ChcekInStockPackagesInvoice($pac_id,$db);

      echo $result;

    }





    if ( $action == 'get_customer_data' ) {

      $cus_id=$_POST['cus_id'];

      $db->where("cus_id",$cus_id);

      $customer=$db->getOne("tbl_customer");

      $cus_arr=array();



      $cus_arr['customer_mobile']=$customer['cus_mobile'];

      $cus_arr['customer_city']=$customer['cus_city'];





      echo json_encode($cus_arr);

    }





    if ( $action == 'show_package_avl') {



        $pac_id =$_POST['pkg_id'];

        $db->where("pkg_id",$pac_id);

        $packages=$db->getOne("tbl_package");



        $db->where("pkg_id",$pac_id);

        $pkg_details=$db->get("tbl_package_detail");

        ?>

        <div class="row">

          <div class="col-sm-8 col-xs-6">

              <p>Package Name : <?php echo $packages['pkg_name']; ?></p>

              <p>Description : <?php echo $packages['pkg_des']; ?></p>

              <p>Price : <?php echo number_format($packages['pkg_price']); ?></p>

              <p>Total Items : <?php echo $packages['total_items']; ?></p>                    

          </div>

        </div>

        <div class="row">

        <div class="col-md-12">

          <h5>Items Detail</h5>

        </div>

        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Item Name</th>                                        

                <th>Quantity</th>   

                <th>Available Quantity</th>                                

              </tr>

            </thead>

            <tbody>

              <?php

              foreach ($pkg_details as $pkg_da) {

                $db->where("pro_id",$pkg_da['pro_id']);

                $stock_pro_qty = $db->getValue ("tbl_products", "pro_qty");



               ?>

              <tr>

               

                <td><?php echo $pkg_da['pro_name']; ?></td>

                <td><?php echo $pkg_da['pro_qty']; ?></td>

                <td><?php echo $stock_pro_qty; ?></td>

              </tr>

              <?php

                

              } ?>

                                                                                

            </tbody>

          </table>

        </div>

      </div>





        <?php

    }





    if ($action == 'customer_detail') {



      $x=$_POST['cus_id'];

      $cus_id=decode($x);

      $db->where("cus_id",$cus_id);

      $customer=$db->getOne("tbl_customer");  

      ?>

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

            <p><b>Customer Name :</b> <?php echo $customer['cus_name']; ?></p>

            <p><b>Description :</b> <?php echo $customer['cus_des']; ?></p>

            <p><b>Concerned Person :</b> <?php echo $customer['con_person']; ?></p>

            <p><b>City :</b> <?php echo $customer['cus_city']; ?></p>

            <p><b>Phone No :</b> <?php echo $customer['cus_phone']; ?></p>

            <p><b>Mobile No :</b> <?php echo $customer['cus_mobile']; ?></p>

            <p><b>Website :</b> <?php echo $customer['cus_web']; ?></p>

            <p><b>Email :</b> <?php echo $customer['cus_email']; ?></p>

            <p><b>Register Date :</b> <?php echo ChangeFormate($customer['reg_date']); ?></p>                   

        </div>

      </div>





      <?php

      

    }





    if( $action == 'show_package' ){



      

      $pac_id =$_POST['pkg_id'];

      $db->where("pkg_id",$pac_id);

      $packages=$db->getOne("tbl_package");





      $db->where("pkg_id",$pac_id);

      $pkg_details=$db->get("tbl_package_detail");



      ?>

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

          

            <p>Package Name  : <?php echo $packages['pkg_name']; ?>   </p>

            <p>Description : <?php echo $packages['pkg_des']; ?></p>

            <p>Price : <?php echo number_format($packages['pkg_price']); ?></p>

            <p>Total Items : <?php echo $packages['total_items']; ?></p>



                              

        </div>

        <div class="col-sm-2">

          <span><a href="package-print.php?pkg=<?php echo $pac_id; ?>" class="btn btn-primary" target="_blank">Print</a></span>

          

        </div>

      </div>

      <div class="row">

        <div class="col-md-12">

          <h5>Items Detail</h5>

        </div>

        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>NO. # </th>

                <th>Item Name</th>                                        

                <th >Quantity</th>                                  

              </tr>

            </thead>

            <tbody>

              <?php

              $i=1;

              foreach ($pkg_details as $pkg_da) { ?>

              <tr>

                <td><?php echo $i; ?></td>

                <td><?php echo $pkg_da['pro_name']; ?></td>

                <td><?php echo $pkg_da['pro_qty']; ?></td>

              </tr>

              <?php

               $i++; 

              } ?>

                                                                                

            </tbody>

          </table>

        </div>



                </div>





      <?php







    }









    if ($action == 'show_invoice' ) {





      $x=$_POST['in_id'];

      $invoice_id=decode($x);

      $db->where('in_id',$invoice_id);

      $invoice_data=$db->getOne('tbl_invoice');



      $db->where('in_id',$invoice_id);

      $in_pro_data=$db->get('tbl_invoice_products');



      $db->where('in_id',$invoice_id);

      $pro_return=$db->get('tbl_invoice_products_return');



      ?>

      <div class="row">

                  <div class="col-sm-8 col-xs-6">                   

                    <h5>Invoice To:</h5>

                      <p><?php echo $invoice_data['cus_name']; ?></p>

                      <p><?php echo $invoice_data['cus_address']; ?></p>

                      <p>Phone: <?php echo $invoice_data['cus_contact']; ?></p>



                                        

                  </div>

                  <div class="col-sm-4 col-xs-6">

                      

                      <h5>Payment Details:</h5>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Grand Total: </span>

                      <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Paid Total: </span>   

                      <span class="float-xs-right">Rs <?php echo $invoice_data['paid_amount']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Total Due:</span>

                      <span class="float-xs-right"><?php echo $invoice_data['total_due']; ?></span>

                    </div>

                      <hr class="hr">

                                                                               

                  </div>

                </div>

                <div class="row">



                  <div class="col-md-12">

                    <h5>Products Detail</h5>

                  </div>



                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">

                      <thead>

                        <tr>

                          <th>Item Information</th>                                        

                          <th >Quantity</th>

                          <th >Rate</th>

                          <th >Discount</th>

                          <th >Total</th>                                        

                        </tr>

                      </thead>

                      <tbody>

                        <?php

                        foreach ($in_pro_data as $pro_da) { ?>



                        <tr>

                          <td><?php echo $pro_da['pro_name']; ?></td>

                          <td><?php echo $pro_da['pro_qty']; ?></td>

                          <td>Rs <?php echo $pro_da['pro_price']; ?> </td>

                          <td>Rs <?php echo $pro_da['discount_amount']; ?></td>

                          <td>Rs <?php echo $pro_da['total_price']; ?></td>

                        </tr>









                        <?php

                          

                        }



                         ?>

                                                                                          

                      </tbody>

                    </table>

                  </div>



                </div>

                <?php

                if( !empty($pro_return) ){ ?>



                  <div class="row" style="margin-top: 35px;">

                  <div class="col-md-12">

                    <h5>Products Return</h5>

                  </div>



                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">

                      <tbody>

                        <?php

                        foreach ($pro_return as $pro_re) { ?>



                        <tr>

                          <td><?php echo $pro_re['pro_name']; ?></td>

                          <td><?php echo $pro_re['pro_qty']; ?></td>

                          <td>Rs <?php echo $pro_re['pro_price']; ?> </td>

                          <td>Rs <?php echo $pro_re['discount_amount']; ?></td>

                          <td>Rs <?php echo $pro_re['total_price']; ?></td>

                        </tr>









                        <?php

                          

                        }



                         ?>

                                                                                          

                      </tbody>

                    </table>

                  </div>

                  

                </div>







                  <?php



                }

                ?>

                





      <?php



    }



    if ($action == 'show_return_invoice' ) {





      $x=$_POST['in_id'];

      $invoice_id=decode($x);

      $db->where('in_id',$invoice_id);

      $invoice_data=$db->getOne('tbl_return_invoice');



      $db->where('in_id',$invoice_id);

      $in_pro_data=$db->get('tbl_invoice_return_products');



      



      ?>

      <div class="row">

                  <div class="col-sm-8 col-xs-6">                   

                    <h5>Invoice To:</h5>

                      <p><?php echo $invoice_data['cus_name']; ?></p>

                      <p><?php echo $invoice_data['cus_address']; ?></p>

                      <p>Phone: <?php echo $invoice_data['cus_contact']; ?></p>



                                        

                  </div>

                  <div class="col-sm-4 col-xs-6">

                      

                      <h5>Payment Details:</h5>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Grand Total: </span>

                      <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Paid Total: </span>   

                      <span class="float-xs-right">Rs <?php echo $invoice_data['paid_amount']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left">Total Due:</span>

                      <span class="float-xs-right"><?php echo $invoice_data['total_due']; ?></span>

                    </div>

                      <hr class="hr">

                                                                               

                  </div>

                </div>

                <div class="row">



                  <div class="col-md-12">

                    <h5>Products Detail</h5>

                  </div>



                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">

                      <thead>

                        <tr>

                          <th>Item Information</th>                                        

                          <th >Quantity</th>

                          <th >Rate</th>

                          <th >Discount</th>

                          <th >Total</th>                                        

                        </tr>

                      </thead>

                      <tbody>

                        <?php

                        foreach ($in_pro_data as $pro_da) { ?>



                        <tr>

                          <td><?php echo $pro_da['pro_name']; ?></td>

                          <td><?php echo $pro_da['pro_qty']; ?></td>

                          <td>Rs <?php echo $pro_da['pro_price']; ?> </td>

                          <td>Rs <?php echo $pro_da['discount_amount']; ?></td>

                          <td>Rs <?php echo $pro_da['total_price']; ?></td>

                        </tr>









                        <?php

                          

                        }



                         ?>

                                                                                          

                      </tbody>

                    </table>

                  </div>



                </div>

                

                





      <?php



    }



     if ($action == 'show_purchase_return' ) {





      

      $invoice_id=$_POST['in_id'];



      $db->join("tbl_customer t_sup", "ret.supplier_id=t_sup.cus_id", "INNER");

      $db->where('ret.pur_re_id',$invoice_id);

      $invoice_data=$db->getOne('tbl_purchase_return ret');



      $db->where('pur_re_id',$invoice_id);

      $in_pro_data=$db->get('tbl_purchase_return_detail');



      



      ?>

      <div class="row">

                  <div class="col-sm-8 col-xs-6">                   

                    

                    <h5>Invoice Date: <?php  echo $newDate = date("d-m-Y", strtotime($invoice_data['in_date']));   ?></h5>

                      <p><strong>Supplier Name :</strong> <?php echo $invoice_data['cus_name']; ?></p>

                      <p> <strong>Detail :</strong> <?php echo $invoice_data['bill_detail']; ?></p>

                      



                                        

                  </div>

                  <div class="col-sm-4 col-xs-6">

                      

                    <h5>Payment Details:</h5>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left"><strong>Grand Total:</strong> </span>

                      <span class="float-xs-right">Rs <?php echo number_format($invoice_data['grand_total']); ?></span>                     

                    </div>

                      <hr class="hr">

                                                                               

                  </div>

                </div>

                <div class="row">



                  <div class="col-md-12">

                    <h5>Products Detail</h5>

                  </div>



                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">

                      <thead>

                        <tr>

                          

                          <th>Product Name</th>                                        

                          <th >Available Qty</th>

                         

                          <th >Supplier Price</th>

                          <th >Return Qty</th> 

                          <th >Total</th>                                       

                        </tr>

                      </thead>

                      <tbody>

                        <?php

                        foreach ($in_pro_data as $pro_da) { ?>



                        <tr>

                          

                          <td><?php echo $pro_da['pro_name']; ?></td>

                          <td><?php echo $pro_da['last_avl_qty']; ?></td>

                          

                          <td>Rs <?php echo $pro_da['supplier_price']; ?></td>

                          <td> <?php echo $pro_da['return_qty']; ?></td>

                          <td>Rs <?php echo $pro_da['pro_total']; ?></td>

                        </tr>









                        <?php

                          

                        }



                         ?>

                                                                                          

                      </tbody>

                    </table>

                  </div>



                </div>



      <?php



    }



    if ($action == 'show_purchase_invoice' ) {





      

      $invoice_id=$_POST['in_id'];



      $db->join("tbl_customer t_sup", "t_p_in.supplier_id=t_sup.cus_id", "INNER");

      $db->where('t_p_in.pur_in_id',$invoice_id);

      $invoice_data=$db->getOne('tbl_purchase_invoice t_p_in');



      $db->where('pur_in_id',$invoice_id);

      $in_pro_data=$db->get('tbl_purchase_invoice_pro');



      



      ?>

      <div class="row">

                  <div class="col-sm-8 col-xs-6">                   

                    <h5>Invoice To:</h5>

                    <h5>Invoice Date: <?php  echo $newDate = date("d-m-Y", strtotime($invoice_data['in_date']));   ?></h5>

                      <p><strong>Supplier Name :</strong> <?php echo $invoice_data['cus_name']; ?></p>

                      <p> <strong>Detail :</strong> <?php echo $invoice_data['bill_detail']; ?></p>

                      <p><strong>Invoice :</strong> <?php echo $invoice_data['invoice_num']; ?></p>



                                        

                  </div>

                  <div class="col-sm-4 col-xs-6">

                      

                      <h5>Payment Details:</h5>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left"><strong>Grand Total:</strong> </span>

                      <span class="float-xs-right">Rs <?php echo $invoice_data['grand_total']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left"><strong>Paid Total:</strong> </span>   

                      <span class="float-xs-right">Rs <?php echo $invoice_data['paid_amount']; ?></span>                     

                    </div>

                    <div class="clearfix mb-0-25">

                      <span class="float-xs-left"><strong>Total Due :</strong></span>

                      <span class="float-xs-right"><?php echo $invoice_data['total_due']; ?></span>

                    </div>

                      <hr class="hr">

                                                                               

                  </div>

                </div>

                <div class="row">



                  <div class="col-md-12">

                    <h5>Products Detail</h5>

                  </div>



                  <div class="col-md-12">

                    <table class="table table-bordered table-hover">

                      <thead>

                        <tr>

                          <th>Product Name</th>                                        

                          <th >Available Qty</th>

                          <th >Sell Price</th>

                          <th >Supplier Price</th>

                          <th >Add Qty</th> 

                          <th >Total</th>                                       

                        </tr>

                      </thead>

                      <tbody>

                        <?php

                        foreach ($in_pro_data as $pro_da) { ?>



                        <tr>

                          <td><?php echo $pro_da['pro_name']; ?></td>

                          <td><?php echo $pro_da['last_avl_qty']; ?></td>

                          <td>Rs <?php echo $pro_da['sell_price']; ?> </td>

                          <td>Rs <?php echo $pro_da['supplier_price']; ?></td>

                          <td> <?php echo $pro_da['new_add_qty']; ?></td>

                          <td>Rs <?php echo $pro_da['pro_total']; ?></td>

                        </tr>









                        <?php

                          

                        }



                         ?>

                                                                                          

                      </tbody>

                    </table>

                  </div>



                </div>



      <?php



    }





    if ($action=='show_product') {

      

      

      $product_id=$_POST['pro_id'];

      $db->where('pro_id',$product_id);

      $product=$db->getOne('tbl_products');

      ?>

      <div class="row">

        <div class="col-sm-8 col-xs-6">                   

         

          <p>Product Name: <b><?php echo $product['pro_name']; ?></b> </p>

          <p>Description: <b><?php echo $product['pro_description']; ?></b> </p>

          <p>Code: <b><?php echo $product['pro_code']; ?></b> </p>

          <p>Rack No: <b><?php echo $product['rack_num']; ?></b> </p>

          <p>Row No: <b><?php echo $product['row_num']; ?></b> </p>

                                

      </div>

        

      </div>

      <div class="row">



        <div class="col-md-12">

          <h5>Products Detail</h5>

        </div>

        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Stock Qty</th>   

                <th>Supplier Price</th>                                     

                <th>Whole Sale Price</th>

                <th>Retail Sale Price</th>

                <th>Rack</th>

                <th>Row</th>

                                                    

              </tr>

            </thead>

            <tbody>

              <tr>

                <td><?php echo $product['pro_qty']; ?></td>

                <td> <?php echo $product['supplier_price']; ?> </td>

                <td><?php echo $product['sell_price']; ?></td>

                <td> <?php echo $product['retail_price']; ?></td>

                

                <td> <?php  echo $product['rack_num']; ?></td>

                <td> <?php  echo $product['row_num']; ?></td>

              </tr>                                                                                      

            </tbody>

          </table>

        </div>



      </div>







      <?php

    }



    if ( $action == 'get_barcode' ) {



      $barcode=GetBarCode($db);



      echo $barcode;



      

    }



    if ( $action == 'delete_invoice' ) {



     

      $in_id=$_POST['in_id'];



      $db->where("in_id",$in_id);

      $db->delete("tbl_invoice");





      $db->where("in_id",$in_id);

      $db->delete("tbl_invoice_products");



      

    }



    if ( $action == 'delete_return_invoice' ) {



     

      $in_id=$_POST['in_id'];



      $db->where("in_id",$in_id);

      $db->delete("tbl_return_invoice");





      $db->where("in_id",$in_id);

      $db->delete("tbl_invoice_return_products");



      

    }





    if ($action == 'show_stock' ) {





      $x=$_POST['sup_id'];

      $supplier_id=decode($x);



      $cols=array("tb_p.pro_name","tb_p.sell_price","tb_p.pro_qty","tb_p.sell_price * tb_p.pro_qty as total_value","tb_s.sup_name");

      $db->join("tbl_products tb_p", "tb_s.sup_id=tb_p.pro_supplier", "INNER");

      $db->where("tb_s.sup_id",$supplier_id);

      $data = $db->get ("tbl_supplier tb_s", null, $cols);

      $total_amount=0;

      foreach ($data as $pro_da) {

        $sup_name=$pro_da['sup_name'];

        $total_amount+= (int)$pro_da['total_value'];

      }



      

      



      ?>

      <div class="row">

                  <div class="col-sm-8 col-xs-6">                   

                    <h5>Supplier Name: <span style="color: red;"> <?php echo $sup_name; ?></span></h5>                 

                  </div>

                  <div class="col-sm-4 col-xs-6">

                      

                    <h5>Total Amount : <span style="color:green;"><?php echo number_format($total_amount); ?> </span></h5>

                    <hr class="hr">

                                                                               

                  </div>

      </div>

      <div class="row">



        <div class="col-md-12">

          <h5>Supplier Product  Detail</h5>

        </div>



        <div class="col-md-12">

          <table class="table table-bordered table-hover">

            <thead>

              <tr>

                <th>Item Information</th>                                        

                <th >Quantity</th>

                <th >Rate</th>

                <th >Total</th>                                        

              </tr>

            </thead>

            <tbody>

              <?php

              foreach ($data as $pro_da) { ?>



              <tr>

                <td><?php echo $pro_da['pro_name']; ?></td>

                <td><?php echo $pro_da['pro_qty']; ?></td>

                <td>Rs <?php echo $pro_da['sell_price']; ?> </td>

                <td>Rs <?php echo $pro_da['total_value']; ?></td>

              </tr>









              <?php

                

              }



               ?>

                                                                                

            </tbody>

          </table>

        </div>



      </div>

                

                





      <?php



    }











    











    

  }





?>