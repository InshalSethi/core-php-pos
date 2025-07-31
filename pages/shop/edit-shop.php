<?php 

 include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

  $page_title='Inventory | Edit Shop';

  if ( isset($_POST['add_expense_type']) ) {
    
    $shop_name=$_POST['shop_name'];
    $shop_address=$_POST['shop_address'];
    $shop_contact=$_POST['shop_contact'];
    $shop_array=array( 
                        "shop_name"=>$shop_name,
                        "shop_address"=>$shop_address,
                        "shop_contact"=>$shop_contact
                        
                      );

    $db->where('shop_id','1');
    $db->update('tbl_shop',$shop_array);
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
    $db->where('shop_id','1');
    $shop_data=$db->getOne('tbl_shop');

    ?>  
            
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Shop Detail</h4>
          <form action=""  method="POST" class="form-sample">
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Shop Name</label>
                  <div class="col-sm-9">
                    <input type="text" name="shop_name" value="<?php echo $shop_data['shop_name']; ?>" placeholder="Shop Name" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Shop Address</label>
                  <div class="col-sm-9">
                    <textarea type="text" name="shop_address" rows="6" class="form-control"><?php echo $shop_data['shop_address']; ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Shop Contact</label>
                  <div class="col-sm-9">
                    <input type="text" name="shop_contact" value="<?php echo $shop_data['shop_contact']; ?>" placeholder="Shop Name" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>


            <div class="row" style="margin-top: 30px;">
              <div class="col-md-12">
                <div class="text-center">
                  <input class="btn btn-primary" name="add_expense_type" type="submit" value="Add">
                  
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