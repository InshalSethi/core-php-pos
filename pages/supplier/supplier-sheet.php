<?php

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';

    include '../../include/permission.php';


    $x=$_REQUEST['cus'];
    $cus_id=decode($x);
    $db->where('cus_id',$cus_id);
    $Customer=$db->getOne('tbl_customer');

    if ( $_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != ''  ) {

        $date_from=$_REQUEST['date_from'];
        $date_to=$_REQUEST['date_to'];


        $invoice_data = $db->rawQuery(" (SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id' AND in_date BETWEEN '$date_from' AND '$date_to')  UNION ALL (SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' AND in_date BETWEEN '$date_from' AND '$date_to' ) UNION ALL (SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL AND date BETWEEN '$date_from' AND '$date_to' ) ");



      } else{

         $invoice_data = $db->rawQuery(" (SELECT pur_in_id as invoice_id,in_date as date,paid_amount as received_amount,grand_total as total_amount,CASE WHEN pur_in_id != '' THEN 'PURCHASE' END as status FROM tbl_purchase_invoice WHERE supplier_id='$cus_id')  UNION ALL (SELECT pur_re_id as invoice_id,in_date as date,grand_total as received_amount,CASE WHEN pur_re_id != '' THEN grand_total END as total_amount,CASE WHEN pur_re_id != '' THEN 'PURCHASE_RETURN' END as status FROM tbl_purchase_return WHERE supplier_id='$cus_id' ) UNION ALL (SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_PAYMENT' END as status FROM supplier_payments WHERE supplier_id='$cus_id' AND purchase_invoice_id IS NULL )  ");

        

      }




    ?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $Customer['cus_name'].' Statement Print'; ?></title>

    <!-- base:css -->

    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>

    <link rel="stylesheet" media="print" href="<?php echo base_url('assets/css/sheet-print.css'); ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/sheet-screen.css'); ?>">

  </head>

  <body>

  	<div class="outer">

  		<button onclick="myFunction()" class="btn btn-info noprint"><i class="mdi mdi-printer"></i> Print</button>

  	<div class="row">

      <div class="col-md-12">

        <h1 class="text-center pg-head">GSS</h1>

      </div>

  		<div class="col-md-12">

  			<h4 class="text-center pg-head"><?php echo $Customer['cus_name']; ?>-Ledger</h4>

  		</div>

  		<div class="col-md-12">

  			<!-- <div class="flt-l">

  				<span class="bold hd-u">Party: </span><span class="tx-co"><?php echo $Name; ?></span>

  			</div> -->

        

  			<div class="flt-r">





          <?php 

            if (isset($_REQUEST['date_from']) && $_REQUEST['date_from']!='' ) {

          ?>

  				<span class="bold hd-u">From </span><span class="tx-co"><?php echo ChangeFormate($_REQUEST['date_from']); ?></span>

  				<span class="bold hd-u">To </span><span class="tx-co"><?php echo ChangeFormate($_REQUEST['date_to']); ?></span>

          <?php } ?>





  			</div>

  		</div>

  		<div class="col-md-12">

  			<div class="table-responsive pt-3">

	            <table class="table table-bordered">

	              <thead>

	                <tr>

                  <th class="st-th text-center">Invoice No.</th>

                  <th class="st-th text-center">Invoice Type</th>

                  <th class="st-th text-center">Invoice Date</th>

                  <th class="st-th text-center">Total Amount</th>

                  <th class="st-th text-center">Paid Amount</th>

                  <th class="st-th text-center">Balance</th>

	                </tr>

	              </thead>

	               <tbody>
                  <?php 
                  foreach( $invoice_data as $da ){

                    $Newbalance= (int)$da['total_amount'] - (int)$da['received_amount'];

                    ?>

                  <tr>
                    <td class="text-center st-td"><?php echo $da['invoice_id']; ?></td>
                    <td class="text-center st-td"><?php echo $da['status']; ?></td>
                    <td class="text-center st-td"><?php echo ChangeFormate($da['date']); ?></td>
                    <td class="text-center st-td"><?php echo number_format((float)$da['total_amount'], 2, '.', ''); ?></td>
                    <td class="text-center st-td"><?php echo $da['received_amount']; ?></td>
                    <td class="text-center st-td"><?php echo number_format($Newbalance); ?></td>
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

  </body>

  <script>

  function myFunction() {

      window.print();

  }

</script>

</html>