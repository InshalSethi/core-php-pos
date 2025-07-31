<?php
    include '../include/config_new.php';
    include '../include/functions.php';
    include '../include/MysqliDb.php';
    include '../include/config.php';


 ?>
<?php 
if (isset($_POST['action'])) {
	$action = $_POST['action'];
	$authkey = $_POST['authkey'];

	//Ajax if account num selected for expense
	if ($action == 'find_account' && $authkey == 'dabdsjjI81sa') {
		$acc_id = $_POST['acc_num'];

		$cols=array("balance","account_number");
		$db->where("id",$acc_id); 
	    $data = $db->get("account",null,$cols);
	    echo json_encode($data);
	}
	//Ajax if to account num selected for transfers
	if ($action == 'find_to_account' && $authkey == 'dabdsjjI81sa') {
		$acc_id = $_POST['to_acc_num'];

		$cols=array("balance","account_number");
		$db->where("id",$acc_id); 
	    $data = $db->get("account",null,$cols);
	    echo json_encode($data);
	}
	//Ajax if exp. type selected for expense
	if ($action == 'find_exp_type' && $authkey == 'dabdsjjI81sa') {
		$exp_type = $_POST['exp_type'];

		$cols=array("type_name","status");
		$db->where("id",$exp_type); 
	    $data = $db->get("exp_type",null,$cols);
	    echo json_encode($data);
	}
	//Ajax if employee selected for salary
	if ($action == 'find_emp_sal' && $authkey == 'dabdsjjI81sa') {
		$employee_id = $_POST['employee_id'];

		$cols=array("name","salary");
		$db->where("employee_id",$employee_id); 
	    $data = $db->get("employee",null,$cols);
	    echo json_encode($data);
	}
}
?>
<?php 
//Add employee here
if(isset($_POST['employeedata'])){
    
	$data = $_POST['employeedata'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action'];

	if($action == 'submit_form_employee' && $authkey=='dabdsjjI81sa' ){

		$employeenamefield = $data[0]['employeenamefield'];
		$srnamefield = $data[0]['srnamefield'];
		$dobfield = $data[0]['dobfield'];
		$qualificationfield = $data[0]['qualificationfield'];
		$usernamefield = $data[0]['usernamefield'];
		$passwordfield = $data[0]['passwordfield'];
		$cnicfield = $data[0]['cnicfield'];
		$phonefield = $data[0]['phonefield'];
		$telephonefield = $data[0]['telephonefield'];
		$emailfield = $data[0]['emailfield'];
		$cityfield = $data[0]['cityfield'];
		$disrtictfield = $data[0]['disrtictfield'];
		$addressfield = $data[0]['addressfield'];
		$gendermale = $data[0]['gendermale'];
		$genderfemale = $data[0]['genderfemale'];
		if ($gendermale != '') {
        	$gender = $gendermale;
        }else{}
        if($genderfemale != ''){
        	$gender = $genderfemale;
        }else{}
		
		$allow_login = $data[0]['allowloginfield'];
		$statusyes = $data[0]['statusyes'];
		$statusno = $data[0]['statusno'];

        if ($statusyes != '') {
        	$status = $statusyes;
        }else{}
        if($statusno != ''){
        	$status = $statusno;
        }else{}
		$created_at = date("Y-m-d");
		$type = 'employee';

    	$ins_employee = array("name"=>$employeenamefield,"sr_name"=>$srnamefield,"gender"=>$gender,"email"=>$emailfield,"phon_no"=>$phonefield,"telephone"=>$telephonefield,"address"=>$addressfield,"district"=>$disrtictfield,"city"=>$cityfield,"cnic"=>$cnicfield,"dob"=>$dobfield,"qualification"=>$qualificationfield,"status"=>$status,"created_at"=>$created_at);
    	
    	$employee_id = $db->insert ('employee', $ins_employee);
 			
		$ins_employee_user = array("employee_id"=>$employee_id,"status"=>$status,"name"=>$usernamefield,"password"=>$passwordfield,"type"=>$type,"allow_login"=>$allow_login);

		$employee_user_id = $db->insert ('user_mac', $ins_employee_user);
	    



	}
     
//Add employee data end here
}
 
////////////// View Modal for accounts query
 			if(isset($_POST['action'])){
				$authkey=$_POST['authkey'];
				$action=$_POST['action'];
 			if ( $action == 'view_account_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$account_id_view = $_POST['account_id_view'];
				$account_id = decode($account_id_view);
 			    $db->where('id',$account_id);
				$account = $db->getOne("account");
				
				$name_view = $account['name'];
				$account_number_view = $account['account_number'];
				$balance_view = $account['balance'];
				$Openingbalance_view = $account['opening_balance'];
				$bank_name_view = $account['bank_name'];
				$bank_phone_view = $account['bank_phone'];
				$bank_address_view = $account['bank_address'];
				$coa_id_view = $account['coa_id'];
				$status_view = $account['status'];
				$default_account_view = $account['default_account'];
				?>
				<div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <input type="text" name="account_name" class="form-control" placeholder="Account Name" value="<?php echo $name_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Number</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-pencil"></i></span>
                                    </div>
                                    <input type="text" name="account_number" class="form-control" placeholder="Account Number" value="<?php echo $account_number_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Opening Balance</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-cash"></i></span>
                                    </div>
                                    <input type="text" name="account_balance" class="form-control" placeholder="Enter Account Balance" value="<?php echo $Openingbalance_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Address</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-google-maps"></i></span>
                                    </div>
                                    <input type="text" name="bank_address" class="form-control" placeholder="Enter Bank Address" value="<?php echo $bank_address_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name" value="<?php echo $bank_name_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Phone</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-phone"></i></span>
                                    </div>
                                    <input type="text" name="bank_phone" class="form-control" placeholder="Enter Bank Phone" value="<?php echo $bank_phone_view; ?>" readonly/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Account GL</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <select name="chrt_acc" class="form-control chrt_accfield" required value="" disabled="">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $coa_id_view){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="col-form-label" style="padding-top: 10px!important;">Default</label>
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <div class='switch'><div class='quality'>
                                    <input <?php if($default_account_view == '1'){ echo 'checked';} ?>  class="default_acc" id='q1' name='default_acc' type='radio' value="1">
                                    <label class="pad-fnt" for='q1'>Yes</label>
                                  </div><div class='quality'>
                                    <input <?php if($default_account_view == '0'){ echo 'checked';} ?> class="default_acc"  id='q2' name='default_acc' type='radio' value="0" id="statusfield">
                                    <label class="pad-fnt" for='q2'>No</label>
                                  </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 no-side-padding-left">
                                <div class="form-group row">
                                  <div class="col-sm-12 set-check-col">
                                    <div class="form-check form-check-flat form-check-primary">
                                      <label class="form-check-label">
                                        Active
                                        <input type="checkbox" name="status" class="form-check-input" <?php if($status_view =='1'){echo "checked";} ?>>
                                      <i class="input-helper"></i></label>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
<?php	}   }   
////////////// Edit Modal for accounts
 			if(isset($_POST['action'])){
				$authkey=$_POST['authkey'];
				$action=$_POST['action'];
 			if ( $action == 'edit_account_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$account_id_edit = $_POST['account_id_edit'];
				$account_id = decode($account_id_edit);
 			    $db->where('id',$account_id);
				$account_data = $db->getOne("account");
				
				$name_edit = $account_data['name'];
				$account_number_edit = $account_data['account_number'];
				$balance_edit = $account_data['balance'];
				$Openingbalance_edit = $account_data['opening_balance'];
				$bank_name_edit = $account_data['bank_name'];
				$bank_phone_edit = $account_data['bank_phone'];
				$bank_address_edit = $account_data['bank_address'];
				$coa_id_edit = $account_data['coa_id'];
				$status_edit = $account_data['status'];
				$default_account_edit = $account_data['default_account'];
				?>
				<div class="col-lg-12">
                 <div class="card card-border-color">
                        <div class="account-success">
                        </div>
                  <div class="card-body">
                    <form id="editaccountform" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <input type="hidden" name="account_id" class="form-control accountidfield" value="<?php echo $account_id; ?>" required/>
                                    <input type="text" name="account_name" class="form-control accountnamefield" placeholder="Account Name" value="<?php echo $name_edit; ?>" required/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Number</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-pencil"></i></span>
                                    </div>
                                    <input type="text" name="account_number" class="form-control accountnumberfield" placeholder="Account Number" value="<?php echo $account_number_edit; ?>" required/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Opening Balance</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-cash"></i></span>
                                    </div>
                                    <input type="text" name="account_balance" class="form-control accountbalancefield" placeholder="Enter Account Balance" value="<?php echo $Openingbalance_edit; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Address</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-google-maps"></i></span>
                                    </div>
                                    <input type="text" name="bank_address" class="form-control bank_addressfield" placeholder="Enter Bank Address" value="<?php echo $bank_address_edit; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <input type="text" name="bank_name" class="form-control bank_namefield" placeholder="Enter Bank Name" value="<?php echo $bank_name_edit; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Phone</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-phone"></i></span>
                                    </div>
                                    <input type="text" name="bank_phone" class="form-control bank_phonefield" placeholder="Enter Bank Phone" value="<?php echo $bank_phone_edit; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Account GL</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <select name="chrt_acc" class="form-control chrt_accfield" required value="">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $coa_id_edit){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="col-form-label" style="padding-top: 10px!important;">Default</label>
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <div class='switch'><div class='quality'>
                                    <input <?php if($default_account_edit == '1'){ echo 'checked';} ?>  class="default_acc" id='q1' name='default_acc' type='radio' value="1">
                                    <label class="pad-fnt" for='q1'>Yes</label>
                                  </div><div class='quality'>
                                    <input <?php if($default_account_edit == '0'){ echo 'checked';} ?> class="default_acc"  id='q2' name='default_acc' type='radio' value="0" id="statusfield">
                                    <label class="pad-fnt" for='q2'>No</label>
                                  </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 no-side-padding-left">
                                <div class="form-group row">
                                  <div class="col-sm-12 set-check-col">
                                    <div class="form-check form-check-flat form-check-primary">
                                      <label class="form-check-label">
                                        Active
                                        <input type="checkbox" name="status" class="form-check-input statusfield" id="statusfield" <?php if($status_edit =='1'){echo "checked";} ?>>
                                      <i class="input-helper"></i></label>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" onclick="edit_account()" name="edit-account" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                    <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
<?php	}   } 
            if(isset($_POST['account_edit_data'])){
            
        	$data = $_POST['account_edit_data'];
        
        	$authkey=$data[0]['authkey'];
        	$action=$data[0]['actioneditaccount'];
        
        	if($action == 'edit_form_account' && $authkey=='dabdsjjI81sa' ){
        	    $acc_id = $data[0]['accountidfield'];
        	    $acc_nam = $data[0]['accountnamefield'];
        	    $acc_num = $data[0]['accountnumberfield'];
        	    $acc_balance = $data[0]['accountbalancefield'];
        	    $bank_adr = $data[0]['bank_addressfield'];
        	    $bank_nam = $data[0]['bank_namefield'];
        	    $bank_ph = $data[0]['bank_phonefield'];
        	    $COA_ID = $data[0]['chrt_accfield'];
        	    $st_ed = $data[0]['statusfield'];
        	    $defaultyes = $data[0]['defaultyes'];
				$defaultno = $data[0]['defaultno'];
				$CountDefault= 0;

		        if ($defaultyes != '') {
		        	$default_acc = $defaultyes;
		        }
		        if($defaultno != ''){
		        	$default_acc = $defaultno;
		        }
        	    $updated_at = date("Y-m-d");

        	    if ($default_acc == 1) {
                  $db->where("default_account",'1');
                  $db->get("account");
                  $CountDefault = $db->count;

                }

                if ($CountDefault <= 0) {
            	$up_account = array("coa_id"=>$COA_ID,"name"=>$acc_nam,"account_number"=>$acc_num,"balance"=>$acc_balance,"opening_balance"=>$acc_balance,"bank_name"=>$bank_nam,"bank_phone"=>$bank_ph,"bank_address"=>$bank_adr,"status"=>$st_ed,"default_account"=>$default_acc,"updated_at"=>$updated_at);
            	// var_dump($up_account);
            	// die();

            	
	            	$db->where('id',$acc_id);
	        
	            	$edit_account_id = $db->update ('account', $up_account);
            	}else{

            	}
        	    
        	    
        	    
        	}
        }
//Edit View For type of Expense
    if(isset($_POST['action'])){
	$authkey=$_POST['authkey'];
	$action=$_POST['action'];
    if ( $action == 'edit_exp_type_modal' && $authkey == 'dabdsjjI81sa'  ) {
	$exp_type_id_view = $_POST['exp_type_id'];
	$exp_type_id = decode($exp_type_id_view);

	$db->where('id',$exp_type_id);
	$exp_type = $db->getOne("exp_type");
	$type_name = $exp_type['type_name'];
	$Coa_id = $exp_type['chrt_id'];
	$status_exp = $exp_type['status'];
	?>
	<div class="col-lg-12">
	    <div class="edit-exp-type">  
	    </div>
        <div class="card card-border-color">
          <div class="card-body">
            <form id="edit_exp_type" action="" method="POST">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <label class="col-form-label">Type of Exp.</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                        </div>
                        <input type="hidden" name="exp_type_id" class="form-control exp_type_idfield" required id="exp_type_idfield" value="<?php echo $exp_type_id; ?>"/>
                        <input type="text" name="exp_type_name" class="form-control exp_type_namefield" required id="exp_type_namefield" placeholder="Enter Type Of Exp." value="<?php echo $type_name; ?>"/>
                      </div>
                    </div>
                  </div>
              	</div>
              	<div class="col-md-5">
	                <div class="form-group row">
	                  <div class="col-sm-12">
	                    <label class="col-form-label">Gl Account (Link this type with COA)</label>
	                    <div class="input-group">
	                      <div class="input-group-prepend">
	                        <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
	                      </div>
	                      <select name="chrt_acc" class="form-control chrt_acc" required value="">
	                        <option value="">Select Any</option>
	                        <?php 
	                          $db->where("status",'1');
	                          $AccGroupData = $db->get("account_group");
	                          foreach ($AccGroupData as $AccGroup) {
	                            $accGroupId = $AccGroup['id'];
	                            $accGroupName = $AccGroup['account_group_name'];
	                        ?>
	                        <optgroup label="<?php echo $accGroupName; ?>">
	                          <?php 
	                            $db->where("acc_group",$accGroupId);
	                            $db->where("status",'1');
	                            $chartAccData = $db->get("chart_accounts");

	                            foreach ($chartAccData as $chartAcc) {
	                              $ChartID = $chartAcc['chrt_id'];
	                              $ChartName = $chartAcc['account_name'];
	                          ?>
	                          <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $Coa_id){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
	                        <?php } ?>
	                        </optgroup>
	                      <?php } ?>
	                      </select>
	                    </div>
	                  </div>
	                </div>
              	</div>
                  <div class="col-md-2">
                    <label class="col-form-label" style="padding-top: 10px!important;">Active</label>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <div class='switch'><div class='quality'>
                          <input class="status q1" id='q1' name='status' type='radio' value="1" <?php if($status_exp == '1'){echo "checked";}  ?>>
                          <label class="pad-fnt" for='q1'>Yes</label>
                        </div><div class='quality'>
                          <input class="status q2"  id='q2' name='status' type='radio' value="0" id="statusfield" <?php if($status_exp == '0'){echo "checked";}  ?>>
                          <label class="pad-fnt" for='q2'>No</label>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <div class="btn-right">
                    <button type="submit" name="add-exp-type" class="btn btn-success btn-mac" onclick="edit_exp_type()" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                    <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
<?php } } 
//Type Of Expense Edit query
if(isset($_POST['exp_type_ar'])){
    
    $data = $_POST['exp_type_ar'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action_exp_type'];

	if($action == 'edit_form_exp_type' && $authkey=='dabdsjjI81sa' ){

		$exp_type_idfield = $data[0]['exp_type_idfield'];
		$exp_type_namefield = $data[0]['exp_type_namefield'];
		$chrt_acc = $data[0]['chrt_acc'];
		$statusyes = $data[0]['statusyes'];
		$statusno = $data[0]['statusno'];

        if ($statusyes != '') {
        	$status2 = $statusyes;
        }else{}
        if($statusno != ''){
        	$status2 = $statusno;
        }else{}
		$updated_at = date("Y-m-d");

    	$up_exp_type = array("chrt_id"=>$chrt_acc,"type_name"=>$exp_type_namefield,"status"=>$status2,"updated_at"=>$updated_at);
    	$db->where('id',$exp_type_idfield);

    	$exp_type_update_id = $db->update ('exp_type', $up_exp_type);
	}
}
// Only view modal expense
        if(isset($_POST['action'])){
		$authkey=$_POST['authkey'];
		$action=$_POST['action'];
 	    if ( $action == 'view_expense_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$expense_id_view = $_POST['expense_id_view'];
				$expense_id = decode($expense_id_view);

				$db->where('id',$expense_id);
				$expenses = $db->getOne("expenses");
				
				$voucher_view = $expenses['voucher'];
				$exp_date_view = $expenses['exp_date'];
				$account_id_view = $expenses['account_id'];
				$account_num_view = $expenses['account_num'];
				$amount_view = $expenses['amount'];
				$exp_type_id_view = $expenses['exp_type_id'];
				$exp_type_name_view = $expenses['exp_type_name'];
				$description_view = $expenses['description'];
				?>
				<div class="col-lg-12">
				    <div class="card card-border-color">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Voucher No.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="text" name="voucher_no" class="form-control" value="<?php echo $voucher_view ; ?>" required id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $newvoucher; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Paid from A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="account_balance" class="form-control " required id="account_balancefield"/>
                                            <input type="hidden" name="account_number" class="form-control " required id="account_numberfield"/>
                                            <select name="acc_num" class="form-control set-drop1 " id="acc_num" disabled>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $acc_data = $db->get("account");
                                                  foreach ($acc_data as $acc) {
                                                      $acc_id = $acc['id'];
                                                      $acc_account_name = $acc['name'];
                                                      $acc_bank = $acc['bank_name'];
                                                      $acc_account_number = $acc['account_number'];
                                                      $acc_balance = $acc['balance'];
                                                      $Opening_balance = $acc['opening_balance'];


                        $cols=array("acc.account_number","trs.category","trs.amount",);

                        $db->where("acc.id", $acc_id);

                        $db->join("account acc", "trs.account=acc.id", "INNER");

                        $transfersdata = $db->get("transactions trs",null,$cols);
                        $Balance = 0;
                        foreach($transfersdata as $transfers){

                          if($transfers['category'] == 'sale invoice'){
                              // $receipt = 'Income';
                              $receipt = $transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }
                          if($transfers['category'] == 'receipt voucher'){
                              // $receipt = 'Income';
                              $receipt = $transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }

                          if($transfers['category'] == 'payment voucher'){
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Expense'){
                              // $payments = 'Expense';
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'purchase invoice'){
                              // $payments = 'Expense';
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Funds Transfer From'){
                            
                              $transferAmountFrom = $transfers['amount'];
                              $Balance -= $transferAmountFrom;
                          }else{
                              $transferAmountFrom = '';
                          }

                          if ($transfers['category'] == 'Funds Transfer To') {

                              $transferAmount = $transfers['amount'];
                              $Balance += $transferAmount;
                          }else{
                              $transferAmount = '';
                          }

                            

                            

                        }
                        $CurrentBalance = $Balance + $Opening_balance;
                                                  ?>
                                                  <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $account_id_view){echo "selected";} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Invoice Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="payment_date" value="<?php echo $exp_date_view; ?>" readonly class="form-control" required id="payment_datefield" placeholder="Enter Payment Date"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Type of Exp.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <select name="exp_type" class="form-control set-drop1 " id="exp_type" disabled>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $exp_type_data = $db->get("exp_type");
                                                  foreach ($exp_type_data as $exp_type) {
                                                      $exp_type_id = $exp_type['id'];
                                                      $exp_type_name = $exp_type['type_name'];
                                                  ?>
                                                  <option value="<?php echo $exp_type_id; ?>" <?php if($exp_type_id == $exp_type_id_view){echo "selected";} ?>><?php echo $exp_type_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--start here-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive pt-3 set-tbl">
                                            <table class="table table-bordered myTable" id="myTable">
                                                <thead>
                                                  <tr>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Type of Exp.
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Description
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Amount
                                                    </th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_type_name" value="<?php echo $exp_type_name_view; ?>" readonly class="form-control" required value="" placeholder="Enter Type of Exp."/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_des" value="<?php echo $description_view; ?>" readonly class="form-control" value="" placeholder="Write Description"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_amount" value="<?php echo $amount_view; ?>" readonly class="form-control" value="0" Placeholder="Enter Amount"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end here-->
                            </form>
                        </div>
                    </div>
				</div>
<?php   }   }
//Edit Modal view for expense
        if(isset($_POST['action'])){
		$authkey=$_POST['authkey'];
		$action=$_POST['action'];
 	    if ( $action == 'edit_expense_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$expe_id_edit = $_POST['expense_edit_id'];
				$ex_id = decode($expe_id_edit);

				$db->where('id',$ex_id);
				$expen = $db->getOne("expenses");
				$voucher_edit = $expen['voucher'];
				$exp_date_edit = $expen['exp_date'];
				$account_id_edit = $expen['account_id'];
				$account_num_edit = $expen['account_num'];
				$amount_edit = $expen['amount'];
				$exp_type_id_edit = $expen['exp_type_id'];
				$exp_type_name_edit = $expen['exp_type_name'];
				$description_edit = $expen['description'];
				$db->where('id',$account_id_edit);
				$account_pr = $db->getOne("account");
				?>
				<div class="col-lg-12">
				    <div class="expense-success">  
				    </div>
				    <div class="card card-border-color">
                        <div class="card-body">
                            <form id="editexpense" action="" method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Voucher No.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="expense_id" value="<?php echo $ex_id; ?>" class="form-control expense_idfield" required id="expense_idfield" readonly/>
                                            <input type="text" name="voucher_no" value="<?php echo $voucher_edit; ?>" class="form-control voucher_nofield" required id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $newvoucher; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Paid from A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="account_balance_old" class="form-control account_balance_old" required id="account_balance_old" value="<?php echo $account_pr['balance']; ?>"/>
                                            <input type="hidden" name="account_balance" class="form-control account_balance" required id="account_balance" value="<?php echo $account_pr['balance']; ?>"/>
                                            <input type="hidden" name="account_number" class="form-control account_number" required id="account_number" value="<?php echo $account_num_edit; ?>"/>
                                            <input type="hidden" name="account_id_old" class="form-control account_id_old" required id="account_id_old" value="<?php echo $account_id_edit; ?>"/>
                                            <select name="acc_num" class="form-control set-drop1 acc_num" id="acc_num" required>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $acc_data = $db->get("account");
                                                  foreach ($acc_data as $acc) {
                                                      $acc_id = $acc['id'];
                                                      $acc_account_name = $acc['name'];
                                                      $acc_bank = $acc['bank_name'];
                                                      $acc_account_number = $acc['account_number'];
                                                      $acc_balance = $acc['balance'];
                                                      $Opening_balance = $acc['opening_balance'];


                        $cols=array("acc.account_number","trs.category","trs.amount",);

                        $db->where("acc.id", $acc_id);

                        $db->join("account acc", "trs.account=acc.id", "INNER");

                        $transfersdata = $db->get("transactions trs",null,$cols);
                        $Balance = 0;
                        foreach($transfersdata as $transfers){

                          if($transfers['category'] == 'sale invoice'){
                              // $receipt = 'Income';
                              $receipt = $transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }
                          if($transfers['category'] == 'receipt voucher'){
                              // $receipt = 'Income';
                              $receipt = $transfers['amount'];
                              $Balance += $receipt;
                          }else{
                              $receipt = '';
                          }

                          if($transfers['category'] == 'payment voucher'){
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Expense'){
                              // $payments = 'Expense';
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'purchase invoice'){
                              // $payments = 'Expense';
                              $payments = $transfers['amount'];
                              $Balance -= $payments;
                          }else{
                              $payments = '';
                          }

                          if($transfers['category'] == 'Funds Transfer From'){
                            
                              $transferAmountFrom = $transfers['amount'];
                              $Balance -= $transferAmountFrom;
                          }else{
                              $transferAmountFrom = '';
                          }

                          if ($transfers['category'] == 'Funds Transfer To') {

                              $transferAmount = $transfers['amount'];
                              $Balance += $transferAmount;
                          }else{
                              $transferAmount = '';
                          }

                            

                            

                        }
                        $CurrentBalance = $Balance + $Opening_balance;
                                                  ?>
                                                  <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $account_id_edit){echo "selected";} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Invoice Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="payment_date" value="<?php echo $exp_date_edit; ?>" class="form-control payment_datefield" required id="payment_datefield" placeholder="Enter Payment Date"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Type of Exp.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <select name="exp_type" class="form-control set-drop1 exp_type" id="exp_type">
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $exp_type_data = $db->get("exp_type");
                                                  foreach ($exp_type_data as $exp_type) {
                                                      $exp_type_id = $exp_type['id'];
                                                      $exp_type_name = $exp_type['type_name'];
                                                  ?>
                                                  <option value="<?php echo $exp_type_id; ?>" <?php if($exp_type_id == $exp_type_id_edit){echo "selected";} ?>><?php echo $exp_type_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--start here-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive pt-3 set-tbl">
                                            <table class="table table-bordered myTable" id="myTable">
                                                <thead>
                                                  <tr>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Type of Exp.
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Description
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Amount
                                                    </th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_type_name" value="<?php echo $exp_type_name_edit; ?>" class="form-control exp_type_name" required value="" placeholder="Enter Type of Exp."/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="exp_des" class="form-control exp_des" value="<?php echo $description_edit; ?>" placeholder="Write Description"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                              <input type="hidden" name="exp_amount_pre" class="form-control exp_amount_pre" value="<?php echo $amount_edit; ?>"/>
                                                            <input type="text" name="exp_amount" class="form-control exp_amount" value="<?php echo $amount_edit; ?>" Placeholder="Enter Amount"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end here-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-right" style="margin-top: 5px;">
                                            <button type="submit" name="add-expense" onclick="edit_expense()" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                            <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
<?php   }   }
//Expense Edit query
if(isset($_POST['expense_edit_data'])){
    
    $data = $_POST['expense_edit_data'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action'];
	

	if($action == 'edit_form_expense' && $authkey=='dabdsjjI81sa' ){

		$expense_idfield = $data[0]['expense_idfield'];
		$voucher_nofield = $data[0]['voucher_nofield'];
		$account_balance_old = $data[0]['account_balance_old'];
		$account_balance = $data[0]['account_balance'];
		$account_number = $data[0]['account_number'];
		$account_id_old = $data[0]['account_id_old'];
		$acc_id = $data[0]['acc_id'];
		$payment_datefield = $data[0]['payment_datefield'];
		$exp_type_id = $data[0]['exp_type_id'];
		$exp_type_name = $data[0]['exp_type_name'];
		$exp_des = $data[0]['exp_des'];
		$exp_amount_pre = $data[0]['exp_amount_pre'];
		$exp_amount = $data[0]['exp_amount'];
		$updated_at = date("Y-m-d");

		//Exp.type table data
      	$db->where('id',$exp_type_id);
      	$ExpTypData = $db->getOne("exp_type");
      	$ExpCOAId = $ExpTypData['chrt_id'];

    	$up_exp = array("chrt_id"=>$ExpCOAId,"voucher"=>$voucher_nofield,"exp_date"=>$payment_datefield,"account_id"=>$acc_id,"account_num"=>$account_number,"amount"=>$exp_amount,"exp_type_id"=>$exp_type_id,"exp_type_name"=>$exp_type_name,"description"=>$exp_des,"updated_at"=>$updated_at);
    	
    	$db->where('id',$expense_idfield);

    	$exp_update_id = $db->update ('expenses', $up_exp);
    	
    	if($account_id_old == $acc_id){
	    	//Update values from account present
	    	$temp_balance = $account_balance + $exp_amount_pre; //old expense amount add into present balance of account
	    	
	    	$new_balance = $temp_balance - $exp_amount; //new expense amount dedect from account balance of temporary above
	    	
	    	$up_account_ex = array("balance"=>$new_balance);
	    	
	    	$db->where('id',$acc_id);

	    	$account_update_id = $db->update ('account', $up_account_ex);
    	
    	}elseif($account_id_old != $acc_id){
    	    // Update values from new account and add old balance to old selected account
    	    $temp_balance_old = $account_balance_old + $exp_amount_pre; //old expense amount add into present balance of account
    	    $up_account_ex_old = array("balance"=>$temp_balance_old);
    	
    	    $db->where('id',$account_id_old);

    	    $account_update_id_old = $db->update ('account', $up_account_ex_old);
    	    
    	    $new_temp = $account_balance - $exp_amount;
    	    
    	    $up_account_ex_new = array("balance"=>$new_temp);
    	
        	$db->where('id',$acc_id);
    
        	$account_update_id_new = $db->update ('account', $up_account_ex_new);
    	    
    	    
    	    
    	}
    	
    	
    	$up_transaction = array("account"=>$acc_id,"date"=>$payment_datefield,"amount"=>$exp_amount,"updated_at"=>$updated_at); 
    	$db->where('exp_id',$expense_idfield);
        $transaction_id = $db->update("transactions",$up_transaction); 

        //Selected Account for COA Account

          $db->where('id',$acc_id);
          $BankAccDpt = $db->getOne("account");
          $AccCoaDptId = $BankAccDpt['coa_id'];


        //Insert dept expense Data into JV

          	$TotalDebit = $exp_amount;
          	$TotalCredit = $exp_amount;

          	$GlSalJVarr = array("date"=>$payment_datefield,"total_debit"=>$TotalDebit,"total_credit"=>$TotalCredit,"updated_at"=>$updated_at);
          	$db->where("expense_id",$expense_idfield);
          	$JVData = $db->update("journal_tbl",$GlSalJVarr);

          	$db->where('expense_id',$expense_idfield);
	        $JvOldDataCli = $db->getOne("journal_tbl");
	        $JIdCli = $JvOldDataCli['j_id'];

	        //Get JVMeta Data for first entry
          	$db->where('j_id',$JIdCli);
          	$db->orderBy ("jm_id","asc");
          	$JvMetaOldDataCli1 = $db->getOne("journal_meta");
          	$JmIdCli1 = $JvMetaOldDataCli1['jm_id'];

        //For Debit Account entry in JV Meta 
          	$JVMetaArrDebit = array("chrt_id"=>$ExpCOAId,"debit"=>$exp_amount,"updated_at"=>$updated_at);
          	$db->where('jm_id',$JmIdCli1);
          	$MetaJvDebitInsert = $db->update("journal_meta",$JVMetaArrDebit);

          	//Get JVMeta Data for second entry
            $db->where('j_id',$JIdCli);
            $db->orderBy ("jm_id","desc");
            $JvMetaOldDataCli2 = $db->getOne("journal_meta");
            $JmIdCli2 = $JvMetaOldDataCli2['jm_id'];

        //For Credit Account entry in JV Meta
          	$JVMetaArrCredit = array("chrt_id"=>$AccCoaDptId,"credit"=>$exp_amount,"updated_at"=>$updated_at);
          	$db->where('jm_id',$JmIdCli2);
          	$MetaJvCreditInsert = $db->update("journal_meta",$JVMetaArrCredit); 
	}
}
// Only view for salary
if(isset($_POST['action'])){
		$authkey=$_POST['authkey'];
		$action=$_POST['action'];
 	    if ( $action == 'view_salary_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$salary_id_view = $_POST['salary_id_view'];
				$salary_id = decode($salary_id_view);

				$db->where('id',$salary_id);
				$employee_salary = $db->getOne("employee_salary");
				
				$employee_id_view = $employee_salary['employee_id'];
				$employee_name_view = $employee_salary['employee_name'];
				$account_id_view = $employee_salary['account_id'];
				$voucher_no_view = $employee_salary['voucher_no'];
				$date_view = $employee_salary['date'];
				$salary_amount_view = $employee_salary['salary_amount'];
				$salary_paid_view = $employee_salary['salary_paid'];
				$balance_view = $employee_salary['balance'];
				$detail_view = $employee_salary['detail'];
				
				$db->where('salary_id',$salary_id);
				$exp_salary = $db->getOne("expenses");
				$exp_typ_id_view = $exp_salary['exp_type_id'];
				?>
				<div class="col-lg-12">
				    <div class="card card-border-color">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Voucher No.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="text" name="voucher_no" class="form-control" id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $voucher_no_view; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Paid from A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="account_balance" class="form-control account_balance" required id="account_balancefield"/>
                                            <input type="hidden" name="account_number" class="form-control account_number" required id="account_numberfield"/>
                                            <select name="acc_id" class="form-control set-drop acc_id" id="acc_id" required disabled>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $acc_data = $db->get("account");
                                                  foreach ($acc_data as $acc) {
                                                      $acc_id = $acc['id'];
                                                      $acc_account_name = $acc['name'];
                                                      $acc_bank = $acc['bank_name'];
                                                      $acc_account_number = $acc['account_number'];
                                                      $acc_balance = $acc['balance'];
                                                  ?>
                                                  <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $account_id_view){echo "selected";} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.$acc_balance.') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="salary_date" class="form-control" required id="salary_datefield" value="<?php echo $date_view; ?>" readonly/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Employee</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <select name="employee_id" class="form-control set-drop employee_id" id="employee_id" required disabled>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $employee_data = $db->get("employee");
                                                  foreach ($employee_data as $employee) {
                                                      $employee_id = $employee['employee_id'];
                                                      $employee_name = $employee['name'];
                                                  ?>
                                                  <option value="<?php echo $employee_id; ?>" <?php if($employee_id == $employee_id_view){echo "selected";} ?>><?php echo $employee_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Type of Exp.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="exp_type_name" class="form-control exp_type_name"/>
                                            <select name="exp_type" class="form-control set-drop exp_type" id="exp_type" disabled>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $exp_type_data = $db->get("exp_type");
                                                  foreach ($exp_type_data as $exp_type) {
                                                      $exp_type_id = $exp_type['id'];
                                                      $exp_type_name = $exp_type['type_name'];
                                                  ?>
                                                  <option value="<?php echo $exp_type_id; ?>" <?php if($exp_type_id == $exp_typ_id_view){echo "selected";} ?>><?php echo $exp_type_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--start here-->
                                <div class="row">
                                            <div class="col-md-12">
                                             <div class="table-responsive pt-3 set-tbl">
                                              <table class="table table-bordered myTable" id="myTable">
                                                <thead>
                                                  <tr>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Employee
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Description
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Salary
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Paid
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Balance
                                                    </th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="employee_name" class="form-control employee_name" required placeholder="Enter Employee Name" value="<?php echo $employee_name_view; ?>" readonly/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="sal_des" class="form-control sal_des" placeholder="Write Description" value="<?php echo $detail_view; ?>" readonly/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="emp_sal_amount" class="form-control emp_sal_amount"  placeholder="Salary Amount" required value="<?php echo $salary_amount_view; ?>" readonly/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="sal_paid" class="form-control sal_paid" placeholder="Salary Paid" required value="<?php echo $salary_paid_view; ?>" readonly/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="sal_balance" class="form-control sal_balance" Placeholder="Remaining Balance" required value="<?php echo $balance_view; ?>" readonly/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end here-->
                                
                            </form>
                        </div>
                    </div>
				</div>
<?php } }
//Edit View for salary
if(isset($_POST['action'])){
		$authkey=$_POST['authkey'];
		$action=$_POST['action'];
 	    if ( $action == 'edit_salaryt_modal' && $authkey == 'dabdsjjI81sa'  ) {
 				$salary_id_edit = $_POST['salary_id_edit'];
				$sal_id = decode($salary_id_edit);

				$db->where('id',$sal_id);
				$employee_salary_edit = $db->getOne("employee_salary");
				
				$employee_id_edit = $employee_salary_edit['employee_id'];
				$employee_name_edit = $employee_salary_edit['employee_name'];
				$account_id_edit = $employee_salary_edit['account_id'];
				$voucher_no_edit = $employee_salary_edit['voucher_no'];
				$date_edit = $employee_salary_edit['date'];
				$salary_amount_edit = $employee_salary_edit['salary_amount'];
				$salary_paid_edit = $employee_salary_edit['salary_paid'];
				$balance_edit = $employee_salary_edit['balance'];
				$detail_edit = $employee_salary_edit['detail'];
				
				$db->where('salary_id',$sal_id);
				$exp_salary_edit = $db->getOne("expenses");
				$exp_typ_id_edit = $exp_salary_edit['exp_type_id'];
				$type_name_edit = $exp_salary_edit['exp_type_name'];
				
				$db->where('id',$account_id_edit);
				$account_sal_edit = $db->getOne("account");
				$account_sal_num = $account_sal_edit['account_number'];
				$account_sal_balance = $account_sal_edit['balance'];
				?>
				<div class="col-lg-12">
				    <div class="card card-border-color">
                        <div class="card-body">
                            <form class="addsalary" id="editsalaryform" action="" method="POST">
                                <div class="row">
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Voucher No.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="salary_id" class="form-control salary_idfield" id="salary_idfield" readonly value="<?php echo $sal_id; ?>"/>
                                            <input type="text" name="voucher_no" class="form-control voucher_nofield" id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $voucher_no_edit; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Paid from A/C</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="old_ac_id" class="form-control old_ac_id" id="old_ac_id" value="<?php echo $account_id_edit; ?>"/>
                                            <input type="hidden" name="account_balance" class="form-control account_balance emp" required id="account_balancefield" value="<?php echo $account_sal_balance; ?>"/>
                                            <input type="hidden" name="account_number" class="form-control account_number emp" required id="account_numberfield" value="<?php echo $account_sal_num; ?>"/>
                                            <select name="acc_id" class="form-control set-drop acc_id" id="acc_id" required>
                                                  <option value="">Select Any</option>
	              <?php
	              
	              $db->where("status",'1');
	              $acc_data = $db->get("account");
	              foreach ($acc_data as $acc) {
	                  $acc_id = $acc['id'];
	                  $acc_account_name = $acc['name'];
	                  $acc_bank = $acc['bank_name'];
	                  $acc_account_number = $acc['account_number'];
	                  $acc_balance = $acc['balance'];
	                  $Opening_balance = $acc['opening_balance'];


                        $cols=array("acc.account_number","trs.category","trs.amount",);

                        $db->where("acc.id", $acc_id);

                        $db->join("account acc", "trs.account=acc.id", "INNER");

                        $transfersdata = $db->get("transactions trs",null,$cols);
                        $Balance = 0;
                        foreach($transfersdata as $transfers){

                          if($transfers['category'] == 'Income'){
                                // $receipt = 'Income';
                                $receipt = $transfers['amount'];
                                $Balance += $receipt;
                            }else{
                                $receipt = '';
                            }

                            if($transfers['category'] == 'Expense'){
                                // $payments = 'Expense';
                                $payments = $transfers['amount'];
                                $Balance -= $payments;
                            }else{
                                $payments = '';
                            }

                            if($transfers['category'] == 'Funds Transfer From'){
                              
                                $transferAmountFrom = $transfers['amount'];
                                $Balance -= $transferAmountFrom;
                            }else{
                                $transferAmountFrom = '';
                            }

                            if ($transfers['category'] == 'Funds Transfer To') {

                                $transferAmount = $transfers['amount'];
                                $Balance += $transferAmount;
                            }else{
                                $transferAmount = '';
                            }

                            

                            

                        }
                        $CurrentBalance = $Balance + $Opening_balance;
                                                  ?>
                                                  <option value="<?php echo $acc_id; ?>" <?php if($acc_id == $account_id_edit){echo "selected";} ?>><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Date</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="date" name="salary_date" class="form-control salary_datefield" required id="salary_datefield" value="<?php echo $date_edit; ?>"/>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Employee</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <select name="employee_id" class="form-control set-drop employee_id" id="employee_id" required>
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $employee_data = $db->get("employee");
                                                  foreach ($employee_data as $employee) {
                                                      $employee_id = $employee['employee_id'];
                                                      $employee_name = $employee['name'];
                                                  ?>
                                                  <option value="<?php echo $employee_id; ?>" <?php if($employee_id == $employee_id_edit){echo "selected";} ?>><?php echo $employee_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group row">
                                        <div class="col-sm-12">
                                          <label class="col-form-label">Type of Exp.</label>
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                            </div>
                                            <input type="hidden" name="exp_type_name" class="form-control exp_type_name" value="<?php echo $type_name_edit; ?>"/>
                                            <select name="exp_type" class="form-control set-drop exp_type" id="exp_type">
                                                  <option value="">Select Any</option>
                                                  <?php
                                                  
                                                  $db->where("status",'1');
                                                  $exp_type_data = $db->get("exp_type");
                                                  foreach ($exp_type_data as $exp_type) {
                                                      $exp_type_id = $exp_type['id'];
                                                      $exp_type_name = $exp_type['type_name'];
                                                  ?>
                                                  <option value="<?php echo $exp_type_id; ?>" <?php if($exp_type_id == $exp_typ_id_edit){echo "selected";} ?>><?php echo $exp_type_name; ?></option>
                                                  <?php } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <!--start here-->
                                <div class="row">
                                            <div class="col-md-12">
                                             <div class="table-responsive pt-3 set-tbl">
                                              <table class="table table-bordered myTable" id="myTable">
                                                <thead>
                                                  <tr>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Employee
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Description
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Salary
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Paid
                                                    </th>
                                                    <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                                      Balance
                                                    </th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="employee_name" class="form-control employee_name" required placeholder="Enter Employee Name" value="<?php echo $employee_name_edit; ?>"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="sal_des" class="form-control sal_des" placeholder="Write Description" value="<?php echo $detail_edit; ?>"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="emp_sal_amount" class="form-control emp_sal_amount"  placeholder="Salary Amount" required value="<?php echo $salary_amount_edit; ?>"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="hidden" name="sal_paid_old" class="form-control sal_paid_old" value="<?php echo $salary_paid_edit; ?>"/>
                                                            <input type="text" name="sal_paid" class="form-control sal_paid" placeholder="Salary Paid" required value="<?php echo $salary_paid_edit; ?>"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                      <td class='set-td-padding bg-white text-center'>
                                                        <div class="form-group row">
                                                          <div class="col-sm-12">
                                                            <input type="text" name="sal_balance" class="form-control sal_balance" Placeholder="Remaining Balance" required value="<?php echo $balance_edit; ?>"/>
                                                          </div>
                                                        </div>
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end here-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-right" style="margin-top: 5px;">
                                            <button type="submit" name="add-salary" onclick="edit_salary()" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                            <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
<?php   }   }
//Salary Edit query
if(isset($_POST['salary_edit_data'])){
    
    $data = $_POST['salary_edit_data'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['actioneditsalary'];
	

	if($action == 'edit_form_salary' && $authkey=='dabdsjjI81sa' ){

		$salary_idfield = $data[0]['salary_idfield'];
		$voucher_nofield = $data[0]['voucher_nofield'];
		$account_balance = $data[0]['account_balance'];
		$account_number = $data[0]['account_number'];
		$old_ac_id = $data[0]['old_ac_id'];
		$acc_id = $data[0]['acc_id'];
		$salary_datefield = $data[0]['salary_datefield'];
		$employee_id = $data[0]['employee_id'];
		$exp_type_name = $data[0]['exp_type_name'];
		$exp_type_id = $data[0]['exp_type_id'];
		$employee_name = $data[0]['employee_name'];
		$sal_des = $data[0]['sal_des'];
		$sal_amount = $data[0]['sal_amount'];
		$sal_paid_old = $data[0]['sal_paid_old'];
		$sal_paid = $data[0]['sal_paid'];
		$sal_balance = $data[0]['sal_balance'];
		$updated_at = date("Y-m-d");
		
		$up_sal = array("employee_id"=>$employee_id,"employee_name"=>$employee_name,"account_id"=>$acc_id,"voucher_no"=>$voucher_nofield,"date"=>$salary_datefield,"salary_amount"=>$sal_amount,"salary_paid"=>$sal_paid,"balance"=>$sal_balance,"detail"=>$sal_des,"updated_at"=>$updated_at);
    	//var_dump($up_sal);
    	
    	$db->where('id',$salary_idfield);

    	$salary_update = $db->update ('employee_salary', $up_sal);
    	
    	$no_salary = $sal_paid - $sal_paid_old;
    	$new_sal = $sal_paid_old + $no_salary;
    	
    	if($acc_id == $old_ac_id){
    	
	    	$acc_old_bl = $account_balance + $sal_paid_old;
	    	$new_ac_balance = $acc_old_bl - $new_sal;
	    	
	    	$up_acc = array("balance"=>$new_ac_balance);
	    	//var_dump($up_acc);
	        $db->where("id",$acc_id);
	        $account_updated = $db->update("account",$up_acc);
        
    	}elseif($acc_id != $old_ac_id){
    	    //put previously paid salary into old account
    	    $db->where('id',$old_ac_id);
			$old_acco = $db->getOne("account");
    	    $oldac_balance = $old_acco['balance'];
    	    $acc_old_bln = $oldac_balance + $sal_paid_old;
    	    $up_acc_old = array("balance"=>$acc_old_bln);
        	//var_dump($up_acc_old);
            $db->where("id",$old_ac_id);
            $account_updated_old = $db->update("account",$up_acc_old);
            
            //put new values into new account
    	    $new_ac_balance = $account_balance - $sal_paid;
            $up_acc_new = array("balance"=>$new_ac_balance);
        	//var_dump($up_acc_new);
            $db->where("id",$acc_id);
            $account_updated_new = $db->update("account",$up_acc_new);
            
            
    	}

        //Check in which GL account we have to insert data
          $GldeptDefault = $db->getOne("gl_items_default");
          $WagesAccount = $GldeptDefault['wages_salary'];

        //Selected Account for COA Account

          $db->where('chrt_id',$WagesAccount);
          $AccWag = $db->getOne("chart_accounts");
          $WageGlId = $AccWag['chrt_id'];
        
        $up_exp = array("chrt_id"=>$WageGlId,"exp_date"=>$salary_datefield,"account_id"=>$acc_id,"account_num"=>$account_number,"amount"=>$new_sal,"exp_type_id"=>$exp_type_id,"exp_type_name"=>$exp_type_name,"description"=>$sal_des,"updated_at"=>$updated_at);
        //var_dump($up_exp);
        $db->where("salary_id",$salary_idfield);
        $exp_id = $db->update("expenses",$up_exp);
        
        $up_transaction = array("account"=>$acc_id,"date"=>$salary_datefield,"amount"=>$sal_paid,"updated_at"=>$updated_at); 
        $db->where("salary_id",$salary_idfield);
        $transaction_id = $db->update("transactions",$up_transaction);
    	//die();

    	//Get Expense Id Using Salary Id
    	$db->where("salary_id",$salary_idfield);
    	$ExpeData = $db->getOne("expenses");
    	$Expen_id = $ExpeData['id'];

    	//Selected Account for COA Account

          $db->where('id',$acc_id);
          $BankAccDpt = $db->getOne("account");
          $AccCoaSaltId = $BankAccDpt['coa_id'];


        //Insert dept expense Data into JV

          	$TotalDebit = $new_sal;
          	$TotalCredit = $new_sal;

          	$GlSalJVarr = array("date"=>$salary_datefield,"total_debit"=>$TotalDebit,"total_credit"=>$TotalCredit,"updated_at"=>$updated_at);
          	$db->where("expense_id",$Expen_id);
          	$JVData = $db->update("journal_tbl",$GlSalJVarr);

          	$db->where('expense_id',$Expen_id);
	        $JvOldDataCli = $db->getOne("journal_tbl");
	        $JIdCli = $JvOldDataCli['j_id'];

	        //Get JVMeta Data for first entry
          	$db->where('j_id',$JIdCli);
          	$db->orderBy ("jm_id","asc");
          	$JvMetaOldDataCli1 = $db->getOne("journal_meta");
          	$JmIdCli1 = $JvMetaOldDataCli1['jm_id'];

        //For Debit Account entry in JV Meta 
          	$JVMetaArrDebit = array("chrt_id"=>$WageGlId,"debit"=>$new_sal,"updated_at"=>$updated_at);
          	$db->where('jm_id',$JmIdCli1);
          	$MetaJvDebitInsert = $db->update("journal_meta",$JVMetaArrDebit);

          	//Get JVMeta Data for second entry
            $db->where('j_id',$JIdCli);
            $db->orderBy ("jm_id","desc");
            $JvMetaOldDataCli2 = $db->getOne("journal_meta");
            $JmIdCli2 = $JvMetaOldDataCli2['jm_id'];

        //For Credit Account entry in JV Meta
          	$JVMetaArrCredit = array("chrt_id"=>$AccCoaSaltId,"credit"=>$new_sal,"updated_at"=>$updated_at);
          	$db->where('jm_id',$JmIdCli2);
          	$MetaJvCreditInsert = $db->update("journal_meta",$JVMetaArrCredit); 
    	
	}
}


//Account Type Edit Modal
if(isset($_POST['action'])){
	$authkey=$_POST['authkey'];
	$action=$_POST['action'];
if ( $action == 'edit_account_type' && $authkey == 'dabdsjjI81sa'  ) {
	$acc_type_id_view = $_POST['acc_type_id'];
	$acc_type_id = decode($acc_type_id_view);

	$db->where('id',$acc_type_id);
	$account_type = $db->getOne("account_type");
	$Accounttype = $account_type['name'];
	
?>
<div class="row">
	<div class="col-lg-12">
		<div class="edit-AccTy"></div>
	  <div class="card card-border-color">
	    <div class="card-body">
	      <form id="edit_AccType" action="" method="POST">
	        <div class="row">
	          <div class="col-md-6">
	            <div class="form-group row">
	              <div class="col-sm-12">
	                <label class="col-form-label">Account Type</label>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
	                  </div>
	                  <input type="hidden" name="account_type_id" id="account_type_idfield" value="<?php echo $acc_type_id; ?>">
	                  <input type="text" name="account_type" class="form-control" required id="accounttypefield" placeholder="Enter Account Type" value="<?php echo $Accounttype; ?>" />
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="row">
	          <div class="col-md-6"></div>
	          <div class="col-md-6">
	            <div class="btn-right">
	              <button type="submit" onclick="edit_accountType()" name="add-account-type" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
	              <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
	            </div>
	          </div>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>
</div>
<?php 
	}
}

//Edit Query Account Type
if(isset($_POST['AccType_ar'])){
    
 	$data = $_POST['AccType_ar'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action'];

	if($action == 'edit_form_AccountType' && $authkey=='dabdsjjI81sa' ){

	 	$accounttypefield = $data[0]['accounttypefield'];
		$account_type_idfield = $data[0]['account_type_idfield'];
		$updated_at = date("Y-m-d");

    	$up_AccType = array("name"=>$accounttypefield,"updated_at"=>$updated_at);

    	$db->where('id',$account_type_idfield);

    	$AccType_update_id = $db->update ('account_type', $up_AccType);
	}
}
//Account group Edit Modal
if(isset($_POST['action'])){
	$authkey=$_POST['authkey'];
	$action=$_POST['action'];
if ( $action == 'edit_account_group' && $authkey == 'dabdsjjI81sa'  ) {
	$acc_group_id_view = $_POST['acc_group_id'];
	$acc_group_id = decode($acc_group_id_view);

	$db->where('id',$acc_group_id);
	$account_group = $db->getOne("account_group");
	$AccountTypeId = $account_group['acc_type_id'];
	$AccountGroupName = $account_group['account_group_name'];
	$status_AccGroup = $account_group['status'];
	?>
	<div class="row">
	    <div class="col-lg-12">
	    	<div class="edit-AccGr"></div>
	      	<div class="card card-border-color">
		        <div class="card-body">
		          <form id="edit_AccGroup" action="" method="POST">
		            <div class="row">
		              <div class="col-md-6">
		                <div class="form-group row">
		                  <div class="col-sm-12">
		                    <label class="col-form-label">Account Group</label>
		                    <div class="input-group">
		                      <div class="input-group-prepend">
		                        <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
		                      </div>
		                      <input type="hidden" name="account_group_id" class="form-control" required id="account_group_idfield" value="<?php echo $acc_group_id;  ?>" />
		                      <input type="text" name="account_group" class="form-control" required id="accountGroupNamefield" placeholder="Enter Account Group" value="<?php echo $AccountGroupName;  ?>" />
		                    </div>
		                  </div>
		                </div>
		              </div>
		              <div class="col-md-3">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Account Type</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
                              </div>
                              <select type="text" name="account_typeid" class="form-control" required id="accountTypeIdfield">
                                <option value="">Select Any</option>
                                <?php
                                  $AccTypeData = $db->get("account_type");
                                  foreach ($AccTypeData as $AccType) {
                                    $AccTypeId = $AccType['id'];
                                    $AccTypeName = $AccType['name'];
                                ?>
                                <option <?php if($AccTypeId == $AccountTypeId){ echo 'selected';} ?> value="<?php echo $AccTypeId; ?>"><?php echo $AccTypeName; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
		              <div class="col-md-3">
		                  <label class="col-form-label" style="padding-top: 10px!important;">Active</label>
		                  <div class="form-group row">
		                    <div class="col-sm-12">
		                      <div class='switch'><div class='quality'>
		                        <input <?php if($status_AccGroup == '1'){ echo "checked";} ?> class="status" id='q1' name='status' type='radio' value="1">
		                        <label class="pad-fnt" for='q1'>Yes</label>
		                      </div><div class='quality'>
		                        <input class="status" <?php if($status_AccGroup == '0'){ echo "checked";} ?>  id='q2' name='status' type='radio' value="0" id="statusfield">
		                        <label class="pad-fnt" for='q2'>No</label>
		                      </div>
		                      </div>
		                    </div>
		                  </div>
		              </div>
		            </div>
		            <div class="row">
		              <div class="col-md-6"></div>
		              <div class="col-md-6">
		                <div class="btn-right">
		                  <button type="submit" onclick="edit_accountGroup()" name="add-account-group" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
		                  <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
		                </div>
		              </div>
		            </div>
		          </form>
		        </div>
	      	</div>
	    </div>
  	</div>
<?php 
}
}
//Edit Query Account Group
if(isset($_POST['AccGroup_ar'])){
    
 	$data = $_POST['AccGroup_ar'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action'];

	if($action == 'edit_form_AccountGroup' && $authkey=='dabdsjjI81sa' ){

	 	$accountGroupNamefield = $data[0]['accountGroupNamefield'];
	 	$accountTypeIdfield = $data[0]['accountTypeIdfield'];
	 	//var_dump($accountGroupNamefield);
		$account_group_idfield = $data[0]['account_group_idfield'];
		$statusyes = $data[0]['statusyes'];
		$statusno = $data[0]['statusno'];

        if ($statusyes != '') {
        	$status2 = $statusyes;
        }else{}
        if($statusno != ''){
        	$status2 = $statusno;
        }else{}
		$updated_at = date("Y-m-d");

    	$up_AccGroup = array("acc_type_id"=>$accountTypeIdfield,"account_group_name"=>$accountGroupNamefield,"status"=>$status2,"updated_at"=>$updated_at);
    	//var_dump($up_AccGroup);

    	$db->where('id',$account_group_idfield);

    	$AccGroup_update_id = $db->update ('account_group', $up_AccGroup);
	}
}

//Edit Modal for chart of accounts
if(isset($_POST['action'])){
	$authkey=$_POST['authkey'];
	$action=$_POST['action'];
	if ( $action == 'edit_chart_account' && $authkey == 'dabdsjjI81sa'  ) {

		$chrtAccId_view = $_POST['chart_acc_id'];
		$chrtAccID = decode($chrtAccId_view);

		$db->where('chrt_id',$chrtAccID);
		$chartAccounts = $db->getOne("chart_accounts");
		$acc_groupID = $chartAccounts['acc_group'];
		$accountName = $chartAccounts['account_name'];
		$status_chrtAcc = $chartAccounts['status'];
		?>
		<div class="row">
		    <div class="col-lg-12">
		    	<div class="edit-ChrAc"></div>
		      	<div class="card card-border-color">
			        <div class="card-body">
						<form id="edit_chrtAcc" action="" method="POST">
					        <div class="row">
					          <div class="col-md-4">
					            <div class="form-group row">
					              <div class="col-sm-12">
					                <label class="col-form-label">Account Group</label>
					                <div class="input-group">
					                  <div class="input-group-prepend">
					                    <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
					                  </div>
					                  <select name="account_group" class="form-control" required id="account_groupfield">
					                    <option value="">Select Account Group</option>
					                  	<?php 
		                                  $AccTypeData = $db->get("account_type");
		                                  foreach ($AccTypeData as $AccType) {
		                                    $accTypeId = $AccType['id'];
		                                    $accTypeName = $AccType['name'];
		                                ?>
		                                <optgroup label="<?php echo $accTypeName; ?>">
		                                  <?php 
		                                    $db->where("acc_type_id",$accTypeId);
		                                    $db->where("status",'1');
		                                    $AccGroupData = $db->get("account_group");

		                                    foreach ($AccGroupData as $AccGroup) {
		                                      $AccGroupID = $AccGroup['id'];
		                                      $AccGroupName = $AccGroup['account_group_name'];
		                                  ?>
		                                  <option value="<?php echo $AccGroupID; ?>" <?php if($AccGroupID == $acc_groupID){ echo 'selected';} ?>><?php echo $AccGroupName; ?></option>
		                                <?php } ?>
		                                </optgroup>
		                              <?php } ?>
					                  </select>
					                </div>
					              </div>
					            </div>
					          </div>
					          <div class="col-md-4">
					            <div class="form-group row">
					              <div class="col-sm-12">
					                <label class="col-form-label">Account Name</label>
					                <div class="input-group">
					                  <div class="input-group-prepend">
					                    <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
					                  </div>
					                  <input type="hidden" name="pre_chrt_id" class="pre_chrt_id" value="<?php echo $chrtAccID; ?>">
					                  <input type="text" name="account_name" class="form-control" required id="account_namefield" placeholder="Enter Account Name" value="<?php echo $accountName; ?>" />
					                </div>
					              </div>
					            </div>
					          </div>
					          <div class="col-md-4">
					              <label class="col-form-label" style="padding-top: 10px!important;">Active</label>
					              <div class="form-group row">
					                <div class="col-sm-12">
					                  <div class='switch'><div class='quality'>
					                    <input <?php if($status_chrtAcc == '1'){ echo 'checked';} ?> class="status" id='q1' name='status' type='radio' value="1">
					                    <label class="pad-fnt" for='q1'>Yes</label>
					                  </div><div class='quality'>
					                    <input <?php if($status_chrtAcc == '0'){ echo 'checked';} ?> class="status"  id='q2' name='status' type='radio' value="0" id="statusfield">
					                    <label class="pad-fnt" for='q2'>No</label>
					                  </div>
					                  </div>
					                </div>
					              </div>
					          </div>
					        </div>
					        <div class="row">
					          <div class="col-md-6"></div>
					          <div class="col-md-6">
					            <div class="btn-right">
					              <button type="submit" onclick="edit_chrtAcc()" name="add-chart-account" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
					              <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
					            </div>
					          </div>
					        </div>
				      	</form>
			      	</div>
		      	</div>
	      	</div>
      	</div>
<?php
	}
}

//Edit Query for chart of accounts
if(isset($_POST['chrtAcc_ar'])){
    
 	$data = $_POST['chrtAcc_ar'];

	$authkey=$data[0]['authkey'];
	$action=$data[0]['action'];

	if($action == 'edit_form_chrtAcc' && $authkey=='dabdsjjI81sa' ){

	 	$account_groupfield = $data[0]['account_groupfield'];
	 	$pre_chrt_id = $data[0]['pre_chrt_id'];
		$account_namefield = $data[0]['account_namefield'];
		$statusyes = $data[0]['statusyes'];
		$statusno = $data[0]['statusno'];

        if ($statusyes != '') {
        	$status2 = $statusyes;
        }else{}
        if($statusno != ''){
        	$status2 = $statusno;
        }else{}
		$updated_at = date("Y-m-d");

    	$up_ChrtAcc = array("acc_group"=>$account_groupfield,"account_name"=>$account_namefield,"status"=>$status2,"updated_at"=>$updated_at);
    	// var_dump($up_ChrtAcc);
    	// die();

    	$db->where('chrt_id',$pre_chrt_id);

    	$Chart_Accounts_id = $db->update('chart_accounts', $up_ChrtAcc);
	}
}
?>