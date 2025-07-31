<?php 

include '../../include/functions.php';
include '../../include/MysqliDb.php';
include '../../include/config.php';
include '../../include/permission.php';

$page_title='Inventory | Rate Revision';
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
						if ( isset($_POST['submit']) ) {

							$pro_domain=$_POST['pro_domain'];
							$company=$_POST['company'];
							$category=$_POST['category'];
							$type=$_POST['type'];
							$method=$_POST['method'];
							$rate=$_POST['rate'];

							$time_zone = date_default_timezone_set("Asia/Karachi");
							$date = date("Y-m-d");

							$db->where("pro_domain",$pro_domain);
							$db->where("company_name",$company);
							$db->where("category_id",$category);
      						$products = $db->get("tbl_products");

							if($type == "increase")
							{
								if($method == "flat"){
									
		      						foreach ($products as $product) {
		      							$sellPrice = 0;
		      							$retailPrice = 0;

		      							$sellPrice = $product['sell_price']+$rate;
		      							$retailPrice = $product['retail_price']+$rate;

		      							// var_dump($sellPrice,$retailPrice);die();

		      							$up_arr = array(
											"sell_price"=>$sellPrice,
											"retail_price"=>$retailPrice,
											"last_update"=>$date,
										);
		      							$db->where("id",$product['id']);
										$db->update("tbl_products",$up_arr);
		      						}
								}else{
									foreach ($products as $product) {
		      							$sellPrice = 0;
		      							$retailPrice = 0;

		      							$sellPrice = (($rate / 100) * $product['sell_price'])+$product['sell_price'];
		      							$retailPrice = (($rate / 100) * $product['retail_price'])+$product['retail_price'];

		      							// var_dump($sellPrice,$retailPrice);die();

		      							$up_arr = array(
											"sell_price"=>$sellPrice,
											"retail_price"=>$retailPrice,
											"last_update"=>$date,
										);
		      							$db->where("id",$product['id']);
										$db->update("tbl_products",$up_arr);
		      						}
								}
							}else{
								if($method == "flat"){

		      						foreach ($products as $product) {
		      							$sellPrice = 0;
		      							$retailPrice = 0;

		      							$sellPrice = $product['sell_price']-$rate;
		      							$retailPrice = $product['retail_price']-$rate;

		      							// var_dump($sellPrice,$retailPrice);die();

		      							$up_arr = array(
											"sell_price"=>$sellPrice,
											"retail_price"=>$retailPrice,
											"last_update"=>$date,
										);
		      							$db->where("id",$product['id']);
										$db->update("tbl_products",$up_arr);
		      						}
								}else{
									foreach ($products as $product) {
		      							$sellPrice = 0;
		      							$retailPrice = 0;

		      							$sellPrice = $product['sell_price']-(($rate / 100) * $product['sell_price']);
		      							$retailPrice = $product['retail_price']-(($rate / 100) * $product['retail_price']);

		      							// var_dump($sellPrice,$retailPrice);die();

		      							$up_arr = array(
											"sell_price"=>$sellPrice,
											"retail_price"=>$retailPrice,
											"last_update"=>$date,
										);
		      							$db->where("id",$product['id']);
										$db->update("tbl_products",$up_arr);
		      						}
								}
							}
							
							echo "<div class='alert alert-fill-success' role='alert'><i class='mdi mdi-alert-circle'></i>Data Updated Successfully.</div>";

						}
						?>



						<div class="col-12 grid-margin">
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">Rate Revision</h4>
									<form action=""  method="POST" class="form-sample">

										<div class="row mb-4">
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Domain <i class="text-danger">*</i></label>
														<select name="pro_domain" class="form-control" required>
															<option value="" >Select Domain</option>
															<?php
															$db->orderBy("dom_name",'asc');
															$sup_Data=$db->get('tbl_product_domain');
															foreach($sup_Data as $s_da){ ?>

																<option value="<?php echo $s_da['dom_id']; ?>" ><?php echo $s_da['dom_name']; ?></option>
																<?php
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Company <i class="text-danger">*</i></label>
														<select name="company" class="form-control" required>
															<option value="" >Select Company</option>
															<?php
															$db->where ("deleted_at", NULL, 'IS');
															$db->orderBy("name",'asc');
															$brands=$db->get('brands');
															foreach($brands as $brand){ 
																?>

																<option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
															<?php } ?>

														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Category <i class="text-danger">*</i></label>
														<select name="category" class="form-control" required>
															<option value="" >Select Category</option>
															<?php
															$db->where ("deleted_at", NULL, 'IS');
															$db->orderBy("name",'asc');
															$categories=$db->get('categories');
															foreach($categories as $category){ 
																?>

																<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
															<?php } ?>

														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Increase/Decrease <i class="text-danger">*</i></label>
														<select name="type" class="form-control" required>
															<option value="" >Select Type</option>
															<option value="increase" >Increase</option>
															<option value="decrease" >Decrease</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Method <i class="text-danger">*</i></label>
														<select name="method" class="form-control" required>
															<option value="" >Select Method</option>
															<option value="flat" >Flat</option>
															<option value="percentage" >Percentage</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group row">
													<div class="col-sm-12">
														<label class="col-form-label">Rate <i class="text-danger">*</i></label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
															</div>
															<input type="number" min="0" name="rate" class="form-control" required placeholder="Enter Number"/>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6"></div>
											<div class="col-md-6">
												<div class="btn-right">
													<button type="submit" name="submit" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Submit</i></button>
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