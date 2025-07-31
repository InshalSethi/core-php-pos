<?php 

include '../../include/functions.php';
include '../../include/MysqliDb.php';
include '../../include/config.php';
include '../../include/permission.php';

$page_title='Inventory | Add Category';
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

</head>
<body>
	<div class="container-scroller">
		<?php include '../../libraries/nav.php'; ?>
		<div class="container-fluid page-body-wrapper">
			<?php include '../../libraries/sidebar.php'; ?>
			<div class="main-panel" style="width: 100%;">        
				<div class="content-wrapper">
					<div class="row">
						<?php 
						if ( isset($_POST['save']) ) {

							$name=$_POST['name'];
							$unit_id=$_POST['unit_id'];
							$package_qty=$_POST['package_qty'];
							$purchase_price=$_POST['purchase_price'];
							$wholesale_price=$_POST['wholesale_price'];
							$retail_price=$_POST['retail_price'];
							if (isset($_POST['status'])) {
								$status = $_POST['status'];
							}

							$time_zone = date_default_timezone_set("Asia/Karachi");
							$date = date("Y-m-d h:i:s");

							$db->where ("deleted_at", NULL, 'IS');
							$db->where('name',$name);
							$check = $db->getOne("categories");
							if(empty($check))
							{
								$ins_arr = array(
									"name"=>$name,
									"unit_id"=> empty($unit_id) ? null : $unit_id,
									"package_qty"=> empty($package_qty) ? null : $package_qty,
									"purchase_price"=> empty($purchase_price) ? null : $purchase_price,
									"wholesale_price"=> empty($wholesale_price) ? null : $wholesale_price,
									"retail_price"=> empty($retail_price) ? null : $retail_price,
									"status"=>$status,
									"created_at"=>$date,
								);
								$insert = $db->insert("categories",$ins_arr);
								// echo $db->getLastQuery();
								// var_dump($insert);die();
								
								if (!empty($insert)){
									echo "<div class='alert alert-fill-success w-100' role='alert'><i class='mdi mdi-alert-circle'></i>Data Saved Successfully.</div>";
									?>
									<script>window.location.href="<?php echo baseurl('pages/settings/categories.php'); ?>";</script>
									<?php
								}else{
									echo "<div class='alert alert-fill-danger w-100' role='alert'><i class='mdi mdi-alert-circle'></i>Alert! Data Not Saved.</div>";
								}
							}else{
								echo "<div class='alert alert-fill-danger w-100' role='alert'><i class='mdi mdi-alert-circle'></i>".$name." Already Exist!</div>";
							}

						}
						?>



						<div class="col-12 grid-margin">
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">Add Category</h4>
									<form action=""  method="POST" class="form-sample">

										<div class="row">
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Name</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="text" name="name" class="form-control" required placeholder="Enter category Name"/>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Unit</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<select name="unit_id" class="form-control">
																<option value=""> Select Any</option>
																<?php 
																// $db->orderBy("id",'desc');
																$tbl_units = $db->get("tbl_units"); 
																foreach ($tbl_units as $unit) {
																	$Id = $unit['un_id'];
																	$name = $unit['unit_name'];
																	?>
																	<option value="<?php echo $Id; ?>"> <?php echo $name; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Unit QTY.</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="number" name="package_qty" class="form-control" placeholder="Enter Unit Quantity"  step="any" pattern="^\d*\.?\d*$"/>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Purchase Price</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="number" name="purchase_price" class="form-control" placeholder="Enter Purchase Price"  step="any" pattern="^\d*\.?\d*$"/>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Wholesale Price</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="number" name="wholesale_price" class="form-control" placeholder="Enter Wholesale Price"  step="any" pattern="^\d*\.?\d*$"/>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Retail Price</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="number" name="retail_price" class="form-control" placeholder="Enter Retail Price"  step="any" pattern="^\d*\.?\d*$"/>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<label class="col-form-label" style="padding-top: 10px!important;">Active</label>
												<div class="form-group row">
													<div class="col-sm-12">
														<div class='switch'><div class='quality'>
															<input checked class="status" id='q1' name='status' type='radio' value="1">
															<label class="pad-fnt" for='q1'>Yes</label>
														</div><div class='quality'>
															<input class="status"  id='q2' name='status' type='radio' value="0" id="statusfield">
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
												<button type="submit" name="save" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
												<button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
											</div>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>

				</div>
			</div>
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
</body>
</html>