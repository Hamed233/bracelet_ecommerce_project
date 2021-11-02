<?php
/*
============================
== categories page
============================
*/

  ob_start();
  if (isset($_GET['catname'])) {
    $pageTitle = preg_replace('/\s+|%/', ' ', $_GET['catname']);
  } else {
    $pageTitle ='Categories';  // Page title
  }
  include "init.php";         // initialize file

  $action = isset($_GET['action']) ? $_GET['action'] : 'Categories';

  if ($action == 'Categories') { ?>

  <div class="header-img">
     <p class="text-center"><?php echo $lang['All Categories']; ?></p>
  </div>

  <div class="container">
    <h1 class="all-cats-head"><?php echo $lang['All Categories']; ?></h1>
    <div class="row">
      <?php
        $cats = getAllFrom("*", "categories", "WHERE active = 0", "", "", "c_id", "");
         if (!empty($cats)) {
           foreach($cats as $cat) { ?>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 phone_50">
               <div class="cat-content text-center">
                 <a href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>" target="_blank">
                  <div class="cat-img">
                    <img src="admin-dashboard/upload/categories_img/<?php echo $cat['c_picture']; ?>" alt="cat image" />
                  </div>
                  <h3><?php echo $cat['c_name']; ?></h3>
                 </a>
               </div>
            </div>
          <?php
          }
        } ?>
    </div>
  </div>



<?php } elseif ($action == $_GET['action']) {  ?>
  <div class="header-img">
     <p class="text-center"><?php echo preg_replace('/\s+|%/', ' ', $_GET['catname']); ?></p>
  </div>

    <input type="hidden" id="catid" value="<?php echo $_GET['catid']; ?>" />

    <div class="container-fluid">

     <?php
       $products = getAllFrom("*", "products", "WHERE categoryID = {$_GET['catid']}", "", "", "p_id", ""); // AND Approve = 1 AND Rating = $rating
     ?>
      <div class="row">

        <div class="col-md-2 filter_side">
          <div class="filter-side">

           <div class="list-group">
             <h4><?php echo $lang['product status']; ?></h4>
              <div class="product_status">
                 <div class="list-group-item checkbox">
                   <label>
                     <input type="checkbox" class="common_selector status_product" value="New"> <?php echo $lang['New']; ?>
                   </label>
                 </div>

                 <div class="list-group-item checkbox">
                   <label>
                     <input type="checkbox" class="common_selector status_product" value="Like-New"> <?php echo $lang['Like New']; ?>
                   </label>
                 </div>

                 <div class="list-group-item checkbox">
                   <label>
                     <input type="checkbox" class="common_selector status_product" value="Used"> <?php echo $lang['Used']; ?>
                   </label>
                 </div>

                 <div class="list-group-item checkbox">
                   <label>
                     <input type="checkbox" class="common_selector status_product" value="Old"> <?php echo $lang['Old']; ?>
                   </label>
                 </div>
              </div>
          </div>

           <div class="list-group">
            <h3><?php echo $lang['Country made']; ?></h3>
               <div class="list-group-item checkbox">
                 <label>
                   <input type="checkbox" class="common_selector country_made" value="Kwuit"> Kwuit
                 </label>
               </div>

               <div class="list-group-item checkbox">
                 <label>
                   <input type="checkbox" class="common_selector country_made" value="Egypt"> Egypt
                 </label>
               </div>

               <div class="list-group-item checkbox">
                 <label>
                   <input type="checkbox" class="common_selector country_made" value="China"> China
                 </label>
               </div>

               <div class="list-group-item checkbox">
                 <label>
                   <input type="checkbox" class="common_selector country_made" value="Japan"> Japan
                 </label>
               </div>

               <div class="list-group-item checkbox">
                 <label>
                   <input type="checkbox" class="common_selector country_made" value="America"> America
                 </label>
               </div>
          </div>

         <div class="list-group">
          <h3><?php echo $lang['Sort By']; ?></h3>
            <div class="list-group-item">
                <input type="radio" id="asc" name="ordering" class="common_selector sort" value="ASC" > 
                <label for="asc"><?php echo $lang['Oldest products']; ?></label>
            </div>

            <div class="list-group-item">
                <input type="radio" id="desc" name="ordering" class="common_selector sort" value="DESC"> 
                <label for="desc"><?php echo $lang['Latest products']; ?></label>
            </div>
         </div>
    </div>
  </div>

         <div class="col-md-10">
           <div class="filter-content">
            <i class="d-inline fas fa-sort-amount-up"></i>
            <p class="d-inline"> Filter</p>
           </div>
           <br />
           <div class="row filter_data">

           </div>
         </div>
    </div>
                <!-- The Modal message -->
            <div id="myModal" class="modal">
              <!-- Modal content -->
              <div class="modal-content">
                <div class="my-modal-header">
                  <span class="close">&times;</span>
                  <h2 class="text-left">Filter</h2>
                </div>
                <div class="modal-body">
                <div class="row">

                <div class="col-12">
                  <div class="filter-side">

                  <div class="list-group">
                    <h4><?php echo $lang['product status']; ?></h4>
                      <div class="product_status">
                        <div class="list-group-item checkbox">
                          <label>
                            <input type="checkbox" class="common_selector status_product" value="New"> <?php echo $lang['New']; ?>
                          </label>
                        </div>

                        <div class="list-group-item checkbox">
                          <label>
                            <input type="checkbox" class="common_selector status_product" value="Like-New"> <?php echo $lang['Like New']; ?>
                          </label>
                        </div>

                        <div class="list-group-item checkbox">
                          <label>
                            <input type="checkbox" class="common_selector status_product" value="Used"> <?php echo $lang['Used']; ?>
                          </label>
                        </div>

                        <div class="list-group-item checkbox">
                          <label>
                            <input type="checkbox" class="common_selector status_product" value="Old"> <?php echo $lang['Old']; ?>
                          </label>
                        </div>
                      </div>
                  </div>

                  <div class="list-group">
                    <h3><?php echo $lang['Country made']; ?></h3>
                      <div class="list-group-item checkbox">
                        <label>
                          <input type="checkbox" class="common_selector country_made" value="Kwuit"> Kwuit
                        </label>
                      </div>

                      <div class="list-group-item checkbox">
                        <label>
                          <input type="checkbox" class="common_selector country_made" value="Egypt"> Egypt
                        </label>
                      </div>

                      <div class="list-group-item checkbox">
                        <label>
                          <input type="checkbox" class="common_selector country_made" value="China"> China
                        </label>
                      </div>

                      <div class="list-group-item checkbox">
                        <label>
                          <input type="checkbox" class="common_selector country_made" value="Japan"> Japan
                        </label>
                      </div>

                      <div class="list-group-item checkbox">
                        <label>
                          <input type="checkbox" class="common_selector country_made" value="America"> America
                        </label>
                      </div>
                  </div>


                <div class="list-group">
                  <h3><?php echo $lang['Sort By']; ?></h3>
                    <div class="list-group-item">
                        <input type="radio" id="asc" class="common_selector sort" value="ASC" > 
                        <label for="asc"><?php echo $lang['Oldest products']; ?></label>
                    </div>

                    <div class="list-group-item">
                        <input type="radio" id="desc" class="common_selector sort" value="DESC"> 
                        <label for="desc"><?php echo $lang['Latest products']; ?></label>
                    </div>
                   </div>
                   <div class="btn btn-light btn-lg filter_ok" style="margin-top: 20px;">OK</div>
                  </div>
                 </div>
                </div>
               </div>
              </div>
            </div>
  </div> <!-- .container -->
<?php
} else {
  header("Location: index.php");
  exit();
}
     // Include Footer page
    include $temp . 'footer.php';
    ob_end_flush();
?>
