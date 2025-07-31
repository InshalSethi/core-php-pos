<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';



  ## Read value

	$draw = $_POST['draw'];

	$row = $_POST['start'];

	$rowperpage = $_POST['length']; // Rows display per page

	$columnIndex = $_POST['order'][0]['column']; // Column index

	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name

	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

	$searchValue = $_POST['search']['value']; // Search value





  if (isset($_POST['action'])) {



    $action=$_POST['action'];



    if ($action == 'purchase_return_table') {



      // Get Data for Count the Result

      $totalRecords=0;

      $grand_total=0;

      $cols=array("pur_re_id","grand_total");

      $db->join("tbl_customer t_sup", "ret.supplier_id=t_sup.cus_id", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

        $db->where("ret.in_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("t_sup.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("ret.pur_re_id","desc");

      $result=$db->get('tbl_purchase_return ret',null,$cols);



      foreach($result as $res){

        $grand_total +=$res['grand_total'];

        $totalRecords++;;

      }



      // Get Data for Show the Result In Table



      $db->join("tbl_customer t_sup", "ret.supplier_id=t_sup.cus_id", "INNER");



      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

        $db->where("ret.in_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("t_sup.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("ret.pur_re_id","desc");

      $invoice_data=$db->get('tbl_purchase_return ret',Array ($row, $rowperpage),'*');



      $data = array();

      $i=1;



      



      foreach( $invoice_data as $in_da ){



        

        $enc=encode($in_da['pur_re_id']);



        $html='<a onclick="ShowPurchaseReturn('.$in_da['pur_re_id'].')" class="btn btn-outline-primary">View</a>';

        $sale_return_update=CheckPermission($permissions,'sale_return_update');
        if($sale_return_update == 1){

          $html.='<a href="edit-purchase-return.php?in='.$in_da['pur_re_id'].'" class="btn btn-outline-warning">Edit</a>';
        

         } 

         $sale_return_delete=CheckPermission($permissions,'sale_return_delete');
        if($sale_return_delete == 1){

          $html.='<a onclick=DeletePurchaseReturn('.$in_da['pur_re_id'].') class="btn btn-outline-danger">Delete</a>';
        

         }



        $data[] = array(



                        "serial_no"=>$i,

                        "invoice_no"=>$in_da['pur_re_id'],

                        "sup_name"=>$in_da['cus_name'],

                        "inv_date"=> ChangeFormate($in_da['in_date']) ,

                        "total_amount"=>number_format($in_da['grand_total']),

                        "action"=>$html



                       );

        $i++;



      }





      // Return the json encode Data



      $response = array(

        "draw" => intval($draw),

        "iTotalRecords" =>  $totalRecords,

        "iTotalDisplayRecords" => $totalRecords,

        "data" => $data,

        "grand_total"=>number_format($grand_total)

      );

      echo json_encode($response);



    }



    if ($action == 'sale_return_table') {



      // Get Data for Count the Result

      $grand_total=0;

      $totalRecords=0;

      $cols=array("inv_id","grand_total");

      $db->join("tbl_customer cus", "cus.cus_id=sale.cus_name", "INNER");



      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("sale.sale_re_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("cus.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("sale.inv_id","desc");

      $result=$db->get('tbl_salereturn_invoice sale',null,$cols);

      foreach($result as $res){

        $totalRecords++;

        $grand_total +=$res['grand_total']; 

      }



      // Get Data for Show the Result In Table



      $db->join("tbl_customer cus", "cus.cus_id=sale.cus_name", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("sale.sale_re_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("cus.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("sale.inv_id","desc");

      $sale_return_data=$db->get('tbl_salereturn_invoice sale',Array ($row, $rowperpage),'*');



      $data = array();

      $i=1;



      



      foreach( $sale_return_data as $in_da ){





          

          

          



         $enc=encode($in_da['inv_id']);

         $encrypt_cus = encode($in_da['cus_id']);



         



         $name_html='<a href="'.baseurl('pages/party-ledger.php?cus='.$encrypt_cus.'').'">'.$in_da['cus_name'].'</a>';



        $html='<a onclick="ShowSaleReturn('.$in_da['inv_id'].')" class="btn btn-outline-primary bdg-tbl">View</a>';

        $sale_return_update=CheckPermission($permissions,'sale_return_update');
        if($sale_return_update == 1){

          $html.='<a href="edit-sale-return.php?inv='.$in_da['inv_id'].'" class="btn btn-outline-warning bdg-tbl">Edit</a>';
        

         } 

         $sale_return_delete=CheckPermission($permissions,'sale_return_delete');
        if($sale_return_delete == 1){

          $html.='<a  onclick="DeleteSaleReturn('.$in_da['inv_id'].')" class="btn btn-outline-danger bdg-tbl">Delete</a>';
        

         }



        $data[] = array(



          "serial_no"=>$i,

          "name"=>$name_html,

          "date"=>ChangeFormate($in_da['p_inv_date']),

          "total"=>number_format($in_da['grand_total']),

          "action"=>$html,



        );

        $i++;



      }



      $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "grand_total"=>number_format($grand_total),

      );

      echo json_encode($response);  

    }



    if ($action == 'sale_order_table') {



      // Get Data for Count the Result

      $grand_total=0;

      $totalRecords=0;

      $cols=array("order_id","grand_total");

      $db->join("tbl_customer cus", "cus.cus_id=ord.cus_name", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("ord.order_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("cus.cus_name", '%'.$searchValue.'%', 'like');

      }

      if (isset($_POST['status_val']) && $_POST['status_val'] != '' ) {



        $status_value=$_POST['status_val'];

        $status_arr=explode(",",$status_value);

        $count=count($status_arr);

        $whereCon="";



        if ($count ==1) {

          for ($i=0; $i <$count ; $i++) { 

            $whereCon.="ord.order_status = '".$status_arr[$i]."'";

          }

          

        } elseif($count >=2 ){

          for ($i=0; $i <$count ; $i++) { 

            if ($i ==0) {

              $whereCon.="ord.order_status = '".$status_arr[$i]."' ";

            } else{

              $whereCon.=" OR ord.order_status = '".$status_arr[$i]."' ";

            }

            

          }

        }

        $db->where($whereCon);



      }

      $db->orderBy("ord.order_id","desc");

      $result=$db->get('tbl_sale_orders ord',null,$cols);

      foreach($result as $res){

        $grand_total+=(int)$res['grand_total'];

        $totalRecords++;

      }





      // Get Data To show in table

      

      $db->join("tbl_customer cus", "cus.cus_id=ord.cus_name", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("ord.order_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("cus.cus_name", '%'.$searchValue.'%', 'like');

      }

      if (isset($_POST['status_val']) && $_POST['status_val'] != '' ) {



        $status_value=$_POST['status_val'];

        $status_arr=explode(",",$status_value);

        $count=count($status_arr);

        $whereCon="";



        if ($count ==1) {

          for ($i=0; $i <$count ; $i++) { 

            $whereCon.="ord.order_status = '".$status_arr[$i]."'";

          }

          

        } elseif($count >=2 ){

          for ($i=0; $i <$count ; $i++) { 

            if ($i ==0) {

              $whereCon.="ord.order_status = '".$status_arr[$i]."' ";

            } else{

              $whereCon.=" OR ord.order_status = '".$status_arr[$i]."' ";

            }

            

          }

        }

        $db->where('('.$whereCon.')');



      }



      $db->orderBy("ord.order_id","desc");

      $orders_data=$db->get('tbl_sale_orders ord',Array ($row, $rowperpage),'*');





      $data = array();

      $i=1;



     



      foreach( $orders_data as $order ){



        $status='';



        $enc=encode($order['order_id']);

        



        if( $order['order_status'] == 'p' ){

          $status = "Pending ";

        } elseif( $order['order_status'] == 's_c' ){

          $status = "Semi Complete ";

        } elseif( $order['order_status'] == 'c' ){

          $status = "Complete";

        } elseif( $order['order_status'] == 'e' ){

          $status = "Expire";

        }





        $html='<div class="set-action"><a href="delivery-print.php?ci='.$enc.'" target="_blank" title="Print Delivery Challan" ><i style="font-size: 20px;" class="mdi mdi-printer icon-sm text-warning"></i></a><a onclick="ShowOrderDetail('.$order['order_id'].')" class="btn btn-outline-primary bdg-tbl">View</a><a href="edit-sale-order-invoice.php?in='.$enc.'" class="btn btn-outline-success bdg-tbl">Edit</a><a  onclick="DeleteOrder('.$order['order_id'].')" class="btn btn-outline-danger bdg-tbl">Delete</a></div>';



        $invoice='<div class="set-in"><a href="sale-order-invoice.php?in='.$enc.'" title="Create Invoice Of This Order" class="btn btn-outline-warning bdg-tbl">Create Invoice</a></div>';



        $name_html='<div class="set-name">'.$order['cus_name'].'</div>';







        $data[] = array(



          "serial_no"=>$i,

          "cus_name"=>$name_html,

          "status"=>$status,

          "date"=> ChangeFormate($order['order_date']),

          "total"=>number_format($order['grand_total']),

          "invoice"=>$invoice,

          "action"=>$html



        );



        $i++;



      }



      $response = array(



      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "grand_total"=>number_format($grand_total)



      );

      echo json_encode($response); 

      

    }





    if ($action == 'assets_table') {





    // Get Data for Count the Result

    $cols=array(" COUNT(as_id) as total_count ");

    $db->join("tbl_assets_type ass_t", "ass_t.type_id=ass.as_type", "INNER");



    if( isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] ){

    $db->where("ass.as_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

    }



    if (isset($_POST['asset_type']) && $_POST['asset_type'] != '' ) {

      $db->where( "ass_t.type_id",$_POST['asset_type'] );

    }



    $result=$db->get('tbl_assets ass',null ,$cols);



    foreach($result as $res){

      $totalRecords=$res['total_count'];

    }



    // Get Data for Show the Result In Table

    $db->join("tbl_assets_type ass_t", "ass_t.type_id=ass.as_type", "INNER");



    if( isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] ){

    $db->where("ass.as_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

    }



    if (isset($_POST['asset_type']) && $_POST['asset_type'] != '' ) {

      $db->where( "ass_t.type_id",$_POST['asset_type'] );

    }



    $db->orderBy("ass.as_date","desc");

    $assets_data=$db->get('tbl_assets ass',Array ($row, $rowperpage) ,'*');



    $data = array();

    $i=1;

    $total_assets=0;

    foreach ($assets_data as $pro) {



      $enc=encode($pro['as_id']);

      $html=" <a href='edit-assets.php?exp=".$enc."' class='btn btn-outline-primary'>Edit</a><a onclick='Remove_Asset(".$pro['as_id'].")' class='btn btn-outline-danger'>Delete</a>";

      $data[] = array(

          "serial_no"=>$i,

          "asset_name"=>$pro['as_name'],

          "asset_type"=>$pro['type_name'] ,

          "asset_amount"=>number_format($pro['as_amount']),

          "asset_date"=>ChangeFormate($pro['as_date']),

          "action"=>$html

      );

      $total_assets+=$pro['as_amount'];

      $i++;

    }



    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "total_assets"=>number_format($total_assets)



    );

    echo json_encode($response);



    }









    if ($action == 'purchase_invoice_table') {



      // Get Data for Count the Result

      $grand_total=0;

      $total_paid=0;

      

      $total_pending=0;

      $totalRecords=0;

      $cols=array("pur_in_id","grand_total","paid_amount","total_due","cus_id");

      $db->join("tbl_customer t_sup", "t_p_in.supplier_id=t_sup.cus_id", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

        $db->where("t_p_in.in_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("t_sup.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("t_p_in.pur_in_id","desc");

      $result=$db->get('tbl_purchase_invoice t_p_in',null,$cols);



      foreach($result as $res){

        $totalRecords++;

        $grand_total +=$res['grand_total'];        

        $total_paid+=$res['paid_amount'];

        $total_pending+=$res['total_due'];

      }



      // Get Data for Show the Result In Table



      $db->join("tbl_customer t_sup", "t_p_in.supplier_id=t_sup.cus_id", "INNER");

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

        $db->where("t_p_in.in_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("t_sup.cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("t_p_in.pur_in_id","desc");

      $invoice_data=$db->get('tbl_purchase_invoice t_p_in',Array ($row, $rowperpage),'*');



      $data = array();

      $i=1;



      



      foreach( $invoice_data as $in_da ){



        





        $enc=encode($in_da['pur_in_id']);

        $cus_enc=encode($in_da['cus_id']);

        $customer_html='<a href="'.base_url('pages/supplier/supplier-detail.php?cus=').''.$cus_enc.'">'.$in_da['cus_name'].'</a>';

        $html='<a href="purchase-print.php?in='.$enc.'" target="_blank"><i style="font-size: 20px;" class="mdi mdi-printer icon-sm text-warning"></i></a><a onclick="ShowInvoiceDetail('.$in_da['pur_in_id'].')" class="btn btn-outline-primary">View</a>';

        $purchase_invoices_update=CheckPermission($permissions,'purchase_invoices_update');
        if($purchase_invoices_update == 1){

          $html.='<a href="edit-purchase-invoice.php?in='.$enc.'" class="btn btn-outline-success">Edit</a>';
        

         } 

         $purchase_invoices_delete=CheckPermission($permissions,'purchase_invoices_delete');
        if($purchase_invoices_delete == 1){

          $html.='<a onclick=DeletePurchaseInvoice('.$in_da['pur_in_id'].') class="btn btn-outline-danger">Delete</a>';
        

         }



        $data[] = array(

          "serial_no"=>$i,

          "invoice_no"=>$in_da['invoice_num'],

          "sup_name"=>$customer_html,

          "inv_date"=> ChangeFormate($in_da['in_date']) ,

          "total_amount"=>number_format($in_da['grand_total']),

          "paid_amount"=>number_format($in_da['paid_amount']),

          "pending_amount"=>number_format($in_da['total_due']),

          "action"=>$html

        );



        $i++;



      }





      // Return the json encode Data



      $response = array(

        "draw" => intval($draw),

        "iTotalRecords" =>  $totalRecords,

        "iTotalDisplayRecords" => $totalRecords,

        "data" => $data,

        "grand_total"=>number_format($grand_total),

        "total_paid"=>number_format($total_paid),

        "total_pending"=>number_format($total_pending)

      );

      echo json_encode($response);



    }



    if ($action == 'packages_invoice_table') {



      // Get Data for Count the Result

      $totalRecords=0;

      $grand_total=0;

      $total_paid=0;

      $total_discount=0;

      $total_pending=0;

      $cols=array("inv_id","grand_total_w_dis","paid_amount","total_dis","total_due");

      //$db->join("tbl_customer cus", "cus.cus_id=pkg.cus_name", "INNER");

      if (isset($_POST['inv_type']) && $_POST['inv_type'] != '') {

         $db->where("pkg.sale_type",$_POST['inv_type']);

      }

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("pkg.p_inv_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("pkg.re_cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("pkg.inv_id","desc");

      $result=$db->get('tbl_invoice pkg',null,$cols);

      foreach($result as $res){

        $totalRecords++;

        if($res['grand_total_w_dis'])

        $grand_total +=$res['grand_total_w_dis'];  

        if($res['paid_amount'])      

        $total_paid+=$res['paid_amount'];

        if($res['total_dis'])

        $total_discount+=$res['total_dis'];

        if($res['total_due'])

        $total_pending+=$res['total_due'];

      }

      // Get Data for Show the Result In Table



      //$db->join("tbl_customer cus", "cus.cus_id=pkg.cus_name", "INNER");

      if (isset($_POST['inv_type']) && $_POST['inv_type'] != '') {

         $db->where("pkg.sale_type",$_POST['inv_type']);

      }

      if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {

         $db->where("pkg.p_inv_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

      }

      if ($searchValue != '') {

        $db->where ("pkg.re_cus_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("pkg.inv_id","desc");

      $invoice_data=$db->get('tbl_invoice pkg',Array ($row, $rowperpage),'*');



      $data = array();

      $i=1;



      



      foreach( $invoice_data as $in_da ){



         $enc=encode($in_da['inv_id']);



         if ($in_da['cus_name'] == '') {

          $name_html='<a>'.$in_da['re_cus_name'].'</a>';

           

         } else{

          $cusEnc=encode($in_da['cus_name']);

          $db->where('cus_id',$in_da['cus_name']);

          $customer_name=$db->getValue('tbl_customer','cus_name');

          $name_html='<a href="'.base_url('pages/customers/customer-details.php?cus=').'.'.$cusEnc.'" >'.$customer_name.'</a>';

         }

          $editBtn = '';
          $deleteBtn = '';
          $printBtn = '<a class="dropdown-item" href="invoice-print.php?ci='.$enc.'" target="_blank" >Print</a>';
          $viewBtn = '<a class="dropdown-item" onclick="ShowPkgInvoiceDetail('.$in_da['inv_id'].')" class="btn btn-outline-primary bdg-tbl">View</a>';
         

         // $html='<a href="invoice-print.php?ci='.$enc.'" target="_blank" ><i style="font-size: 20px;" class="mdi mdi-printer icon-sm text-warning"></i></a><a onclick="ShowPkgInvoiceDetail('.$in_da['inv_id'].')" class="btn btn-outline-primary bdg-tbl">View</a>';

          
        $sale_invoices_update=CheckPermission($permissions,'sale_invoices_update');
        if($sale_invoices_update == 1){

          // $html.='<a href="edit-invoice-wp.php?in='.$enc.'" class="btn btn-outline-success bdg-tbl">Edit</a>';
          $editBtn = '<a class="dropdown-item" href="edit-invoice-wp.php?in='.$enc.'">Edit</a>';
        

         } 

         $sale_invoices_delete=CheckPermission($permissions,'sale_invoices_delete');
        if($sale_invoices_delete == 1){

          // $html.='<a  onclick="DeletePackageInvoice('.$in_da['inv_id'].')" class="btn btn-outline-danger bdg-tbl">Delete</a>';
          $deleteBtn = '<a class="dropdown-item" onclick="DeletePackageInvoice('.$in_da['inv_id'].')">Delete</a>';
        

         }



         

        

        
        $html = '<div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                '.$printBtn.'
                                                '.$viewBtn.'
                                                '.$editBtn.'
                                                '.$deleteBtn.'
                                            </div>
                                        </div>';


        



        $data[] = array(



          "serial_no"=>$i,

          "name"=>$name_html,

          "date"=>ChangeFormate($in_da['p_inv_date']),

          "total"=>number_format($in_da['grand_total']),

          "discount"=>number_format($in_da['total_dis']),

          "paid"=>number_format($in_da['paid_amount']),

          "pending"=>number_format($in_da['total_due']),

          "action"=>$html,



        );

        $i++;



      }



      $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "grand_total"=>number_format($grand_total),

      "total_paid"=>number_format($total_paid),

      "total_discount"=>number_format($total_discount),

      "total_pending"=>number_format($total_pending)

      );

      echo json_encode($response);  

    }



    if ($action == 'packages_table') {



      // Get Data for Count the Result

      $cols=array("COUNT(pkg_id) as total_count");

      $db->where('is_delete','0');

      if ($searchValue != '') {

       $db->where ("pkg_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("pkg_id","desc");

      $result=$db->get('tbl_package',null,$cols);



      foreach($result as $res){

        $totalRecords=$res['total_count'];

      }



      // Get Data for Show the Result In Table

      $db->where('is_delete','0');

      if ($searchValue != '') {

       $db->where ("pkg_name", '%'.$searchValue.'%', 'like');

      }

      $db->orderBy("pkg_id","desc");

      $packages=$db->get('tbl_package',Array ($row, $rowperpage),'*');

      $data = array();

      $i=1;



      foreach( $packages as $pro ){



        $enc=encode($pro['pkg_id']);



        $html='<a onclick="ShowPackageDetail('.$pro['pkg_id'].')" class="btn btn-outline-primary">View</a><a href="edit-package.php?pkg='.$enc.'" class="btn btn-outline-success">Edit</a><a onclick="DeletePackage('.$pro['pkg_id'].')" class="btn btn-outline-danger">Delete</a>';



        $stock_html=ChcekInStockPackages($pro['pkg_id'],$db);





        $data[] = array(

          "serial_no"=>$i,

          "package_name"=>$pro['pkg_name'],

          "available_qty"=> $stock_html ,

          "price"=>$pro['pkg_price'],

          "total_items"=>$pro['total_items'],

          "action"=>$html

        );

        $i++;



      }

      // return the json formate data for datatable

      $response = array(

        "draw" => intval($draw),

        "iTotalRecords" =>  $totalRecords,

        "iTotalDisplayRecords" => $totalRecords,

        "data" => $data

      );

      echo json_encode($response);



    }

    if ($action == 'product_table_profit') {



    // Get Data for Count the Result

    $totalRecords=0;

    $stockAmount=0;

    $cols=array("pro_id","pro_qty","supplier_price");

    $db->join("tbl_product_domain tb_s", "tb_p.pro_domain=tb_s.dom_id", "LEFT");

    if ($searchValue != '') {

      $db->where ("tb_p.pro_name", '%'.$searchValue.'%', 'like');

    }

    $db->where('is_delete','0');

    if($_POST['domain_id'] != ''){

        $db->where('tb_p.pro_domain',$_POST['domain_id']  );

        

    }

    $db->orderBy("pro_id","desc");

    $result=$db->get('tbl_products tb_p',null,$cols);

    foreach($result as $res){



      $totalStock= $res['pro_qty'] *  $res['supplier_price'];

      //echo $totalStock."<br>";

      $stockAmount +=  $totalStock;

      $totalRecords++;

    }



    // Get Data for Show the Result In Table


    $cols=array('tb_p.pro_id','tb_p.pro_name','tb_s.dom_name','tb_p.pro_qty','tb_p.pro_qty','tb_p.retail_price','tb_p.supplier_price','(SELECT sum(pro_qty) FROM tbl_invoice_detail where pro_id=tb_p.pro_id) as sold');
    $db->join("tbl_product_domain tb_s", "tb_p.pro_domain=tb_s.dom_id", "LEFT");

    $db->where('is_delete','0');

    if ($searchValue != '') {

      $db->where ("tb_p.pro_name", '%'.$searchValue.'%', 'like');

    }

    if($_POST['domain_id'] != ''){

        $db->where('tb_p.pro_domain',$_POST['domain_id']  );

        

    }

    $db->orderBy("sold","desc");

    $ProductData=$db->get('tbl_products tb_p',Array ($row, $rowperpage),$cols);
    



    

    $data = array();

    $i=1;

    foreach( $ProductData as $pro ){



      $profit=0;
      $enc=encode($pro['pro_id']);
      if($pro['sold'] > 0 ){

      	$diff=$pro['supplier_price']-$pro['retail_price'];
      	if ($diff > 0) {
      		$profit= $diff * $pro['sold'];
      	}else{
      		$profit=0;
      	}
      	


      } else{

      	$profit=0;

      }



      



      



      $data[] = array(

        "serial_no"=>$i,

        "product_name"=>$pro['pro_name'],

        "met_name"=>$pro['dom_name'] ,

        "qty"=>$pro['sold'],

        "sell_price"=>$pro['retail_price'],

        "supplier_price"=>$pro['supplier_price'],

        "profit"=>$profit

      );



      $i++;

    }



    // return the json formate data for datatable

    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "stock_amount"=>number_format($stockAmount)

    );

    echo json_encode($response);



    }



    if ($action == 'product_table') {



    // Get Data for Count the Result

    $totalRecords=0;

    $stockAmount=0;

    $cols=array("pro_id","pro_qty","supplier_price");

    $db->join("tbl_product_domain tb_s", "tb_p.pro_domain=tb_s.dom_id", "LEFT");

    $db->join("brands br", "tb_p.company_name=br.id", "LEFT");

    $db->join("categories cat", "tb_p.category_id=cat.id", "LEFT");

    if ($searchValue != '') {

      $db->where ("tb_p.pro_name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("cat.name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_s.dom_name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("br.name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_p.pro_qty", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_p.retail_price", '%'.$searchValue.'%', 'like');

    }

    $db->where('is_delete','0');

    if($_POST['domain_id'] != ''){

        $db->where('tb_p.pro_domain',$_POST['domain_id']  );

        

    }

    if($_POST['category_id'] != ''){

        $db->where('tb_p.category_id',$_POST['category_id']  );

        

    }

    if($_POST['brand_id'] != ''){

        $db->where('tb_p.company_name',$_POST['brand_id']  );

        

    }

    $db->orderBy("pro_id","desc");

    $result=$db->get('tbl_products tb_p',null,$cols);

    foreach($result as $res){


      if($res['pro_qty'] && $res['supplier_price'])
      $totalStock= $res['pro_qty'] *  $res['supplier_price'];

      //echo $totalStock."<br>";

      $stockAmount +=  $totalStock;

      $totalRecords++;

    }


    // Get Data for Show the Result In Table



    $db->join("tbl_product_domain tb_s", "tb_p.pro_domain=tb_s.dom_id", "LEFT");

    $db->join("brands br", "tb_p.company_name=br.id", "LEFT");

    $db->join("categories cat", "tb_p.category_id=cat.id", "LEFT");

    $db->where('is_delete','0');

    if ($searchValue != '') {

      $db->where ("tb_p.pro_name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("cat.name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_s.dom_name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("br.name", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_p.pro_qty", '%'.$searchValue.'%', 'like');

      $db->orWhere ("tb_p.retail_price", '%'.$searchValue.'%', 'like');

    }

    if($_POST['domain_id'] != ''){

        $db->where('tb_p.pro_domain',$_POST['domain_id']  );

        

    }

    if($_POST['category_id'] != ''){

        $db->where('tb_p.category_id',$_POST['category_id']  );

        

    }

    if($_POST['brand_id'] != ''){

        $db->where('tb_p.company_name',$_POST['brand_id']  );

        

    }

    $db->orderBy("pro_id","desc");

    $ProductData=$db->get('tbl_products tb_p',Array ($row, $rowperpage),[
      'tb_p.*',
      'tb_s.dom_name',
      'br.name as brand_name',
      'cat.name as cat_name'
    ]);



    // var_dump($ProductData);die();

    $data = array();

    $i=1;

    foreach( $ProductData as $pro ){



      $enc=encode($pro['pro_id']);



      



      $html='<a onclick="ShowProductDetail('.$pro['pro_id'].')" class="btn btn-outline-primary">View</a><a href="edit-product.php?pro='.$enc.'" class="btn btn-outline-success">Edit</a><a onclick="DeleteProduct('.$pro['pro_id'].')" class="btn btn-outline-danger">Delete</a>';



      $data[] = array(

        "serial_no"=>$i,

        "product_name"=>$pro['pro_name'],

        "category_name"=>$pro['cat_name'],

        "met_name"=>$pro['dom_name'] ,

        "company"=>$pro['brand_name'] ,

        "qty"=>$pro['pro_qty'],

        "retail_price"=>$pro['retail_price'],

        "action"=>$html

      );



      $i++;

    }



    // return the json formate data for datatable

    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "stock_amount"=>number_format($stockAmount)

    );

    echo json_encode($response);



    }



    if ($action == 'expense_table') {





    // Get Data for Count the Result

    $totalRecords=0;

    $total_expense=0;

    $cols=array("exp_id","exp_amount");

    $db->join("tbl_expense_type ex_t", "ex_t.type_id=exp.exp_type", "INNER");

    if( isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] ){

    $db->where("exp.exp_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

    }

    if (isset($_POST['exp_type']) && $_POST['exp_type'] != '' ) {

      $db->where("exp.exp_type",$_POST['exp_type']);

    }

    $result=$db->get('tbl_expense exp',null ,$cols);



    foreach($result as $res){

      $totalRecords++;

      $total_expense+=$res['exp_amount'];

    }



    // Get Data for Show the Result In Table

    $db->join("tbl_expense_type tb_ex_ty", "tb_ex_ty.type_id=tb_ex.exp_type", "INNER");

    if( isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] ){

    $db->where("tb_ex.exp_date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

    }

    if (isset($_POST['exp_type']) && $_POST['exp_type'] != '' ) {

      $db->where("tb_ex.exp_type",$_POST['exp_type']);

    }

    $db->orderBy("tb_ex.exp_date","desc");

    $exp_data=$db->get('tbl_expense tb_ex',Array ($row, $rowperpage) ,'*');



    $data = array();

    $i=1;

    

    foreach ($exp_data as $pro) {



      $enc=encode($pro['exp_id']);

      $html=" <a href='edit-expense.php?exp=".$enc."' class='btn btn-outline-primary'>Edit</a><a onclick='Remove_Expense(".$pro['exp_id'].")' class='btn btn-outline-danger'>Delete</a>";

      $data[] = array(

          "serial_no"=>$i,

          "exp_name"=>$pro['exp_name'],

          "exp_type"=>$pro['type_name'] ,

          "exp_amount"=>number_format($pro['exp_amount']),

          "exp_date"=>ChangeFormate($pro['exp_date']),

          "action"=>$html

      );

      

      $i++;

    }



    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "total_expense"=>number_format($total_expense)



    );

    echo json_encode($response);



    }



    if ($action == 'cash_received_table') {



    $grand_total=0;

    $totalRecords=0;

    $cols=array("id","amount");

    $db->join("tbl_customer cus", "cus.cus_id=rec.client_id", "INNER");

    if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {



      $db->where("rec.date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');



    }

    $result=$db->get('client_payments rec',null ,$cols);

    foreach($result as $res){

      $totalRecords++;

      $grand_total += (int) $res['amount'];

    }



    $db->join("tbl_customer cus", "cus.cus_id=rec.client_id", "INNER");

    if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {



      $db->where("rec.date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');

    }

    $db->orderBy("rec.id","desc");

    $CashPayment=$db->get('client_payments rec',Array ($row, $rowperpage) ,'*');

    $data = array();

    $i=$row+1;

    foreach ($CashPayment as $pro) {

      $enc=encode($pro['id']);

      $html='';
      $html.='<div class="dropdown">
        <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">';

      $html.="<a class='dropdown-item' onclick='ShowCashReceivedVoucher(".$pro['id'].")' ><i class='mdi mdi-eye text-dark'></i>View</a>";
      $html.="<a class='dropdown-item' href='print-cash-received.php?cash=".$pro['id']."' ><i class='mdi mdi-printer text-dark'></i>Print</a>";


      $cash_received_update=CheckPermission($permissions,'cash_received_update');
        if($cash_received_update == 1){

          $html.="<a class='dropdown-item' href='edit-cash-received.php?cash=".$pro['id']."' ><i class='mdi mdi-pencil text-dark'></i>Edit</a>";
        

         } 

         $cash_received_delete=CheckPermission($permissions,'cash_received_delete');
        if($cash_received_delete == 1){

          
        $html.="<div class='dropdown-divider'></div><a class='dropdown-item' onclick='CashRecDeleteVoucher(".$pro['id'].")' ><i class='mdi mdi-delete text-dark'></i>Delete</a>";
        

        }

      $data[] = array(

          "voc_num"=>$i,

          "party_name"=>$pro['cus_name'],

          "date"=>ChangeFormate($pro['date']),

          "note"=>$pro['payment_note'],

          "total_amount"=>number_format($pro['amount']),

          "action"=>$html,

        );

      $i++;

    }

    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "grand_total" =>number_format($grand_total)



    );

    echo json_encode($response);



    }





    if ($action == 'cash_payment_table') {



    $grand_total=0;

    $totalRecords=0;





    $cols=array("id","amount");

    $db->join("tbl_customer cus", "cus.cus_id=pay.supplier_id", "INNER");

    if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {



      $db->where("pay.date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');



    }

    $result=$db->get('supplier_payments pay',null ,$cols);

    foreach($result as $res){

      $totalRecords++;

      $grand_total+=(int) $res['amount'];

    }





    $db->join("tbl_customer cus", "cus.cus_id=pay.supplier_id", "INNER");

    if (isset($_POST['from_date']) && $_POST['from_date'] != '' && isset($_POST['to_date']) && $_POST['to_date'] != ''  ) {



      $db->where("pay.date",Array ($_POST['from_date'], $_POST['to_date']), 'BETWEEN');



    }

    $db->orderBy("pay.id","desc");

    $CashPayment=$db->get('supplier_payments pay',Array ($row, $rowperpage) ,'*');



    $data = array();

    $i=$row+1;

    foreach ($CashPayment as $pro) {

      



      $enc=encode($pro['id']);

      $html='';
      $html.='<div class="dropdown">
        <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">';

      $html.="<a class='dropdown-item' onclick='ShowCashVoucher(".$pro['id'].")' ><i class='mdi mdi-eye text-dark'></i>View</a>";
      $html.="<a class='dropdown-item' href='print-cashpayment.php?cash=".$pro['id']."' ><i class='mdi mdi-printer text-dark'></i>Print</a>";




      
                                        
      



      

      $cash_payments_update=CheckPermission($permissions,'cash_payments_update');
        if($cash_payments_update == 1){

          $html.="<a class='dropdown-item' href='edit-cash-payment.php?cash=".$pro['id']."' ><i class='mdi mdi-pencil text-dark'></i>Edit</a>";
        

         } 

         $cash_payments_delete=CheckPermission($permissions,'cash_payments_delete');
        if($cash_payments_delete == 1){

          $html.="<div class='dropdown-divider'></div><a class='dropdown-item' onclick='CashDeleteVoucher(".$pro['id'].")' ><i class='mdi mdi-delete text-dark'></i>Delete</a>";

    
         }

      $data[] = array(



          "voc_num"=>$i,

          "party_name"=>$pro['cus_name'],

          "date"=>ChangeFormate($pro['date']),

          "total_amount"=>number_format($pro['amount']),

          "note"=>$pro['payment_note'],

          "action"=>$html,



        );



      $i++;

    }



    $response = array(

      "draw" => intval($draw),

      "iTotalRecords" =>  $totalRecords,

      "iTotalDisplayRecords" => $totalRecords,

      "data" => $data,

      "grand_total" => number_format($grand_total)

    );

    echo json_encode($response);   

    }


    if ($action == 'supplier_detail_table') {

      $cus_id=$_POST['cus_id'];



      // Get Data for Count the Result

      $totalRecords=0;
      $total_received=0;
      $total_receiveAble=0;
      $Balance=0;

      if ( $_POST['date_from'] != '' && $_POST['date_to'] != ''  ) {

        $date_from=$_POST['date_from'];
        $date_to=$_POST['date_to'];

        $result = $db->rawQuery("SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' AND in_date BETWEEN '$date_from' AND '$date_to' UNION ALL SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' AND in_date  BETWEEN '$date_from' AND '$date_to' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL AND date BETWEEN '$date_from' AND '$date_to' ");

      } else{

        $result = $db->rawQuery("SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' UNION ALL SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL ");

      }

      foreach($result as $da){ 
        $totalRecords++;

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
      




      // Get Data for Show the Result In Table

      if ( $_POST['date_from'] != '' && $_POST['date_to'] != ''  ) {

        $date_from=$_POST['date_from'];
        $date_to=$_POST['date_to'];

        $invoice_data = $db->rawQuery(" (SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' AND in_date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage)  UNION ALL (SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' AND in_date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage) UNION ALL (SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL AND date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage) LIMIT $row, $rowperpage ");


      } else{

        $invoice_data = $db->rawQuery(" (SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' LIMIT $row, $rowperpage)  UNION ALL (SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' LIMIT $row, $rowperpage) UNION ALL (SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL LIMIT $row, $rowperpage) LIMIT $row, $rowperpage ");

      }

      



      

      
      $data = array();
      $i=1;

      foreach( $invoice_data as $da ){

        $Newbalance= (int)$da['total_amount'] - (int)$da['received_amount'];

        $data[] = array(
          "inv_no"=>$da['invoice_id'],
          "inv_type"=>$da['status'],
          "inv_date"=>ChangeFormate($da['date']),
          "total_amount"=>number_format((float)$da['total_amount'], 2, '.', ''),
          "paid_amount"=>$da['received_amount'],
          "balance"=>$Newbalance,
        );

        $i++;
      }



      $response = array(

      "draw" => intval($draw),
      "iTotalRecords" =>  $totalRecords,
      "iTotalDisplayRecords" => $totalRecords,
      "data" => $data,
      "total_amount"=>number_format($total_receiveAble),
      "total_paid"=>number_format($total_received),
      "total_balance"=>number_format($Balance)
      );

      echo json_encode($response);  

    }



    if ($action == 'customer_detail_table') {

      $cus_id=$_POST['cus_id'];



      // Get Data for Count the Result

      $totalRecords=0;
      $total_received=0;
      $total_receiveAble=0;
      $Balance=0;

      if ( $_POST['date_from'] != '' && $_POST['date_to'] != ''  ) {

        $date_from=$_POST['date_from'];
        $date_to=$_POST['date_to'];


        $result= $db->rawQuery("SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' AND p_inv_date BETWEEN '$date_from' AND '$date_to' UNION ALL SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' AND p_inv_date BETWEEN '$date_from' AND '$date_to' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL AND date BETWEEN '$date_from' AND '$date_to' ");



      } else{

        $result= $db->rawQuery("SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' UNION ALL SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL ");

        

      }

      foreach($result as $da){ 
        $totalRecords++;
        if($da['status'] == 'SALE'){
          $total_receiveAble+=$da['total_amount'];
          $total_received+=$da['received_amount'];
        } 
        if ($da['status'] == 'CASH_RECEIVED') {
          $total_received+=$da['received_amount'];
        }
        if($da['status'] == 'SALE_RETURN'){
          $total_received+=$da['received_amount'];
        }
      }

      $Balance=$total_receiveAble-$total_received;
      




      // Get Data for Show the Result In Table

      if ( $_POST['date_from'] != '' && $_POST['date_to'] != ''  ) {

        $date_from=$_POST['date_from'];
        $date_to=$_POST['date_to'];


        $invoice_data= $db->rawQuery(" (SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' AND p_inv_date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage ) UNION ALL (SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' AND p_inv_date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage ) UNION ALL ( SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL AND date BETWEEN '$date_from' AND '$date_to' LIMIT $row, $rowperpage )  ");



      } else{


        $invoice_data= $db->rawQuery(" (SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' LIMIT $row, $rowperpage ) UNION ALL (SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' LIMIT $row, $rowperpage ) UNION ALL ( SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL LIMIT $row, $rowperpage ) ");
        



      }

      



      

      
      $data = array();
      $i=1;

      foreach( $invoice_data as $da ){

        $Newbalance= (int)$da['total_amount'] - (int)$da['received_amount'];

        $data[] = array(
          "inv_no"=>$da['invoice_id'],
          "inv_type"=>$da['status'],
          "inv_date"=>ChangeFormate($da['date']),
          "total_amount"=>number_format((float)$da['total_amount'], 2, '.', ''),
          "paid_amount"=>$da['received_amount'],
          "balance"=>$Newbalance,
        );

        $i++;
      }



      $response = array(

      "draw" => intval($draw),
      "iTotalRecords" =>  $totalRecords,
      "iTotalDisplayRecords" => $totalRecords,
      "data" => $data,
      "total_amount"=>number_format($total_receiveAble),
      "total_paid"=>number_format($total_received),
      "total_balance"=>number_format($Balance)
      );

      echo json_encode($response);  

    }



   

  }





    

?>