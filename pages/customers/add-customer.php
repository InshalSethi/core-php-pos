<?php 
  
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

$page_title='Inventory | Add Customer';

if ( isset($_POST['add_customer']) ) {


  $current_date=date("Y-m-d");
  
  $customer_name=$_POST['cus_name'];
 $discription=$_POST['cus_discription'];  
  
  $cus_city=$_POST['cus_city'];
  $contact_num=$_POST['contact_num'];
  $mobile_num=$_POST['mobile_num'];
  $cus_website=$_POST['cus_website'];
  $cus_email=$_POST['cus_email'];
  


  $cus_array=array( 
                    "cus_name"=>$customer_name,
                    "cus_type"=>'1',
                    "cus_des"=>$discription,
                    "cus_city"=>$cus_city,
                    "cus_phone"=>$contact_num,
                    "cus_mobile"=>$mobile_num,
                    "cus_web"=>$cus_website,
                    "cus_email"=>$cus_email,
                    "reg_date"=>$current_date,
                  );


  $db->insert('tbl_customer',$cus_array);

  header("LOCATION:customer-list.php");

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
                  <h4 class="card-title">Add Customer</h4>
                  <form action=""  method="POST" class="form-sample">
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="cus_name" class="form-control" autocomplete="off" required >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                            <textarea type="text" name="cus_discription" rows="6" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>


                    
                   
                   <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input type="text" name="cus_city" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Phone No.</label>
                          <div class="col-sm-9">
                            <input type="text" name="contact_num" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile No.</label>
                          <div class="col-sm-9">
                            <input type="text" name="mobile_num" class="form-control" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Website</label>
                          <div class="col-sm-9">
                            <input type="text" name="cus_website" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Email</label>
                          <div class="col-sm-9">
                            <input type="text" name="cus_email" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-12">
                        <div class="text-center">
                          <input class="btn btn-primary" name="add_customer" type="submit" value="Add">
                          
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