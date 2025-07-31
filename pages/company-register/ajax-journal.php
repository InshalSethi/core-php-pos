<?php 

	

	include '../../include/config_new.php';

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



    // get the permission



    $view =$_POST['view_permission'];

    $edit= $_POST['edit_permission'];

    $delete=$_POST['delete_permission'];



    //Search Start

    



    $cols=array("COUNT(jt.j_id) as total_count"," SUM(jm.debit) as total_deb","SUM(jm.credit) as total_cre");

    $db->join("journal_meta jm", "jt.j_id=jm.j_id", "INNER");

    $db->join("gl_type gl_ty", "gl_ty.id=jt.gl_type", "INNER"); 

    $db->join("chart_accounts ca", "jm.chrt_id=ca.chrt_id", "INNER");

    if( isset($_POST['voucher'])  && $_POST['voucher'] != ''){

            $db->where("jt.voucher_no",$_POST['voucher']);

    }

    if (isset($searchValue) && $searchValue != '') {

        $db->where("gl_ty.type", '%'.$searchValue.'%', 'like');

    }

    if( isset($_POST['acc_dec'])  && $_POST['acc_dec'] != ''){

            $db->where("jm.chrt_id",$_POST['acc_dec']);

    } 

    if( isset($_POST['date_from'])  && $_POST['date_from'] != '' && isset($_POST['date_to'])  &&  $_POST['date_to'] != ''  ){

        

        $from_date=$_POST['date_from'];

        $to_date=$_POST['date_to'];

        

        $db->where('jt.date', Array ($from_date, $to_date ), 'BETWEEN');

    }  

    $JVdata_new = $db->get("journal_tbl jt", null, $cols);

    // echo '------'.$db->getLastQuery();

    // die();

    $total_debit=0;

    $total_cedit=0;

    foreach($JVdata_new as $jd){

        $totalRecords = $jd['total_count'];

        $total_debit = $jd['total_deb'];

        $total_cedit = $jd['total_cre'];

    }

    // die();





    





    $cols=array("jt.voucher_no","jt.date","jm.debit","jm.credit","ca.account_name","jt.j_id","jt.gl_type","gl_ty.type");

    $db->join("gl_type gl_ty", "jt.gl_type=gl_ty.id", "INNER"); 

    $db->join("journal_meta jm", "jt.j_id=jm.j_id", "INNER"); 

    $db->join("chart_accounts ca", "jm.chrt_id=ca.chrt_id", "INNER"); 

    if( isset($_POST['voucher'])  && $_POST['voucher'] != ''){

            $db->where("jt.voucher_no",$_POST['voucher']);

    }

    if (isset($searchValue) && $searchValue != '') {

        $db->where("gl_ty.type", '%'.$searchValue.'%', 'like');

    }

    if( isset($_POST['acc_dec'])  && $_POST['acc_dec'] != ''){

            $db->where("jm.chrt_id",$_POST['acc_dec']);

    } 

    if( isset($_POST['date_from'])  && $_POST['date_from'] != '' && isset($_POST['date_to'])  &&  $_POST['date_to'] != ''  ){

        

        $from_date=$_POST['date_from'];

        $to_date=$_POST['date_to'];

        

        $db->where('jt.date', Array ($from_date, $to_date ), 'BETWEEN');

    } 

    $JVdata = $db->get ("journal_tbl jt", Array ($row, $rowperpage), $cols);

    



    $data = array();



    

    

    foreach ($JVdata as $JV) {



    	$JV_id = $JV['j_id'];

        $encrypt = encode($JV_id);

        $voucher_no = $JV['voucher_no'];

        $type = $JV['type'];

        $date = $JV['date'];

        $accName = $JV['account_name'];

        $debit = $JV['debit'];

        $credit = $JV['credit'];



        $view_html='';

        $delete_html='';

        $edit_html='';



        

        $view_html='<a class="dropdown-item" onclick="viewmodal(\''.$encrypt.'\')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>';

        

        $journal_update=CheckPermission($permissions,'journal_update');
        if($journal_update == 1){

          $edit_html='<a class="dropdown-item" href="edit-journal.php?jv='.$encrypt.' " ><i class="mdi mdi-pencil text-dark"></i>Edit</a>';
        

         }

         $journal_delete=CheckPermission($permissions,'journal_delete');
        if($journal_delete == 1){

          $delete_html='<a class="dropdown-item" onclick="myFunction(\''.$JV_id.'\')"><i class="mdi mdi-delete text-dark"></i>Delete</a>';
        

         }



        



        



        $html_action='<div class="dropdown"><button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> </button><div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">'.$view_html.''.$edit_html.'<div class="dropdown-divider"></div>'.$delete_html.'</div></div>';



        $data[] = array(



        	"voucher_no"=>$voucher_no,

            "type"=>$type,

        	"date"=>$date,

            "acc_desc"=>$accName,

        	"debit"=>number_format($debit),

            "credit"=>number_format($credit),

        	"action"=>$html_action,







        );













    }



    

    $response = array(

    "draw" => intval($draw),

    "iTotalRecords" => $totalRecords,

    "iTotalDisplayRecords" => $totalRecords,

    "data" => $data,

    "total_debit"=>$total_debit,

    "total_cedit"=>$total_cedit



	);



	echo json_encode($response);



?>