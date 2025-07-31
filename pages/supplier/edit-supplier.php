<?php 
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

$page_title='Inventory | Edit Supplier';

  $x=$_REQUEST['sup'];
  $sup_id=decode($x);

if ( isset($_POST['edit_supplier']) ) {


  
  
  $sup_name=$_POST['sup_name'];
  $sup_discription=$_POST['sup_discription'];
  $sup_contact_name=$_POST['sup_contact_name'];
  $sup_contact_num=$_POST['sup_contact_num'];
  $sup_address=$_POST['sup_address'];
  $sup_email=$_POST['sup_email'];
  


  $supplier_array=array( 
                        "cus_name"=>$sup_name,
                        "cus_des"=>$sup_discription,
                        "con_person"=>$sup_contact_name,
                        "cus_phone"=>$sup_contact_num,
                        "cus_city"=>$sup_address,
                        "cus_email"=>$sup_email
                      );

  $db->where('cus_id',$sup_id);
  $db->update('tbl_customer',$supplier_array);

  header("LOCATION:edit-supplier.php?sup=$x");









  
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
            $db->where('cus_id',$sup_id);
            $sup_data=$db->getOne('tbl_customer');

            ?>
            
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Supplier</h4>
                  <form action=""  method="POST" class="form-sample">
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Supplier Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_name" class="form-control" value="<?php echo $sup_data['cus_name']; ?>" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                            <textarea type="text" name="sup_discription" rows="6" class="form-control"><?php echo $sup_data['cus_des']; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact Person</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_contact_name" value="<?php echo $sup_data['con_person']; ?>" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact No.</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_contact_num" value="<?php echo $sup_data['cus_phone']; ?>" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Supplier Address</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_address" class="form-control" value="<?php echo $sup_data['cus_city']; ?>" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Email</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_email" class="form-control" value="<?php echo $sup_data['cus_email']; ?>" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-12">
                        <div class="text-center">
                          <input class="btn btn-primary" name="edit_supplier" type="submit" value="Update">
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