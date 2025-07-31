<?php 
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

$page_title='Inventory | Add Supplier';

if ( isset($_POST['add_supplier']) ) {


  $current_date=date("Y-m-d");
  
  $sup_name=$_POST['sup_name'];
  $sup_discription=$_POST['sup_discription'];
  $sup_contact_name=$_POST['sup_contact_name'];
  $sup_contact_num=$_POST['sup_contact_num'];
  $sup_address=$_POST['sup_address'];
  $sup_email=$_POST['sup_email'];
  


  $supplier_array=array( 
                        "cus_name"=>$sup_name,
                        "cus_type"=>'2',
                        "cus_des"=>$sup_discription,
                        "con_person"=>$sup_contact_name,
                        "cus_phone"=>$sup_contact_num,
                        "cus_city"=>$sup_address,
                        "cus_email"=>$sup_email,
                        "reg_date"=>$current_date,



                      );


  $db->insert('tbl_customer',$supplier_array);

  header("LOCATION:supplier-list.php");









  
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
            
            
            
            
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Supplier</h4>
                  <form action=""  method="POST" class="form-sample">
                    <p class="card-description">
                      Supplier info
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Supplier Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_name" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                            <textarea type="text" name="sup_discription" rows="6" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact Person</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_contact_name" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact No.</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_contact_num" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Supplier Address</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_address" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Email</label>
                          <div class="col-sm-9">
                            <input type="text" name="sup_email" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    

                    

    

    <div class="row" style="margin-top: 30px;">
      <div class="col-md-12">
        <div class="text-center">
          <input class="btn btn-primary" name="add_supplier" type="submit" value="Add">
          
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