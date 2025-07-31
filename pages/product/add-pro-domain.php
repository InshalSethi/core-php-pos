<?php 

  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

  $page_title='Inventory | Add Product Doamin';

  if ( isset($_POST['add_unit']) ) {
    $unit_name=$_POST['unit_name'];
    $unit_discription=$_POST['unit_discription'];
    $units_array=array( 
                        "dom_name"=>$unit_name,
                        "dom_des"=>$unit_discription
                      );
    $db->insert('tbl_product_domain',$units_array);
    header("LOCATION:product-domain-list.php");
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
                  <h4 class="card-title">Add Product Domain</h4>
                  <form action=""  method="POST" class="form-sample">
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Domain Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="unit_name" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Description</label>
                          <div class="col-sm-9">
                            <textarea type="text" name="unit_discription" rows="6" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    

                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-12">
                        <div class="text-center">
                          <input class="btn btn-primary" name="add_unit" type="submit" value="Add">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
        <?php include '../../libraries/footer.php'; ?>
        
      </div>
        
      </div>
     
    </div>
    
<?php include '../../libraries/js_libs.php'; ?>
  </body>
</html>