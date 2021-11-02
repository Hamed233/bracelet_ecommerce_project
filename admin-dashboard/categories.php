<?php
/*
===============================
==   Category Page           ==
===============================
*/
  ob_start(); // OutPut Buffering Start
  $pageTitle = 'Categories';
  include "init.php";

  if (isset($_SESSION['ID'])) {
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {
      // Get Categories where parent < 1
      $stmt= $con->prepare("SELECT * FROM categories WHERE parent < ? order by c_id DESC");
      $stmt->execute(array('1'));
      $cats = $stmt->fetchAll();
      // Get Visible categories
      $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 0");
      $sql->execute();
      $count_vis = $sql->fetchColumn();
      // Get UnVisible categories
      $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 1");
      $sql->execute();
      $count_unvis = $sql->fetchColumn();
      // Get Categories number
      $cats_num = countItems('c_id', 'categories'); ?>

       <h1 class='text-center global-h1'><?php echo $lang['Manage Categories']; ?></h1>
         <div class="container-fluid categories">
           <div class="row">
           <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="stat categories-count">
                  <div class="info">
                   <?php echo $lang['Total Categories']; ?>
                      <span>
                         <a href="categories.php"><?php echo $cats_num; ?></a>
                      </span>
                  </div>
               </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="pie-first">
               <div id="pie-chart-cats"></div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
               <div class="stat categories-count">
                   <div class="info">
                    <?php echo $lang['Total visibile Categories']; ?>
                       <span>
                          <a href="categories.php"><?php echo $count_vis; ?></a>
                       </span>
                   </div>
                </div>
             </div>
          </div>
          <?php if (! empty($cats)) { // check if not categories empty ?>
           <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                   <tr>
                       <td>#ID</td>
                       <td><?php echo $lang['Category Name']; ?></td>
                       <td><?php echo $lang['Category Brand']; ?></td>
                       <td><?php echo $lang['Category Description']; ?></td>
                       <td><?php echo $lang['Visible']; ?></td>
                       <td><?php echo $lang['Children']; ?></td>
                       <td><?php echo $lang['Control']; ?></td>
                   </tr>
                   <?php foreach($cats as $cat) {
                           echo "<tr>";
                             echo "<td>" . $cat['c_id']    . "</td>";
                             echo "<td>" . $cat['c_name']  . "</td>"; ?>
                             <td>
                               <div class="box" style="background:url('<?php echo 'upload/categories_img/' . $cat['c_picture'] . ''; ?>')">
                         			    <!-- Star Cover Right -->
                         			    <div class="cover right">
                                    <button type="button" name="update" class="btn btn-warning bt-xs update" id="<?php echo $cat['c_id']; ?>">Edit Img >></button>
                         			    </div>
                         			  </div>
                              </td>
                             <?php
                              echo "<td>" . $cat['c_description']   . "</td>";
                              echo "<td>"; if ($cat['active'] == 0) { echo "Public"; } else { echo "Private"; } echo "</td>";
                              echo "<td>";

                              $childCats = getAllFrom("*", 'categories', "WHERE parent = {$cat['c_id']}", "", "c_id", "ASC");
                              if (!empty($childCats)){
                                  foreach ($childCats as $c) {
                                     echo "<a href='categories.php?do=childcat&catid=" . $c['c_id'] . "'>" . $c['c_name'] . "</a><br>";
                                  }
                              } else {
                                  echo "Not Found Any Children";
                              }

                              echo "</td>";
                              echo "<td>
                                   <a href='categories.php?do=Edit&catid=" . $cat['c_id'] . "' class='btn btn-primary'><i class='fas fa-edit'></i> " . $lang['Edit'] . "</a>
                                   <a href='categories.php?do=Delete&catid=" . $cat['c_id'] . "' class='confirm btn btn-danger'><i class='fas fa-times'></i> " . $lang['Remove'] .  "</a>";
                              echo "</td>";
                            echo "</tr>";
                        } ?>
                </table>
                <a class="add_category btn btn-brown" href="categories.php?do=Add"> <i class="fas fa-plus"></i>  <?php echo $lang['Add New Category']; ?></a>
             <?php } else { ?>
                      <div class="container container-special">
                       <div class='alert alert-danger' style='margin-top: 60px;'><i class='fas fa-exclamation-circle' style="padding: 10px;"></i><?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></div>
                        <a href ='categories.php?do=Add' class='btn btn-brown'>
                         <i class='fas fa-plus'></i>
                         <?php echo $lang['Add New Category']; ?>
                        </a>
                      </div>
              <?php } ?>
             </div>
          </div>

          <div id="image_data"></div>
          <!-- model for update image -->
          <div id="imageModal" class="modal fade" role="dialog">
           <div class="modal-dialog">
            <div class="modal-content">
             <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Image</h4>
             </div>
             <div class="modal-body">
              <form id="image_form" method="post" enctype="multipart/form-data">
                <p>
                  <label>Select Image:</label><br />
                  <input type="file" name="image" id="image" />
                </p><br />
               <input type="hidden" name="action" id="action" value="insert" />
               <input type="hidden" name="image_id" id="image_id" />
               <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />

              </form>
             </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
            </div>
           </div>
          </div>

 <?php } elseif ($do == 'Add') { ?>

          <h1 class="text-center global-h1"><?php echo $lang['Add New Category']; ?></h1>
          <div class="container container-special form-content">
              <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                <!-- Start  Name Field -->
                <div class="form-group form-group-lg">
                  <div class="col-12">
                    <h5><?php echo $lang['Category Name']; ?></h5>
                    <input type="text" name="name" class="form-control" autocomplete= "off" required="required" placeholder="<?php echo $lang['Category Name']; ?>">
                  </div>
               </div>
               <!-- End  Name Field -->
               <!-- Start  Description Field -->
               <div class="form-group form-group-lg">
                  <div class="col-12">
                     <h5><?php echo $lang['Category Description']; ?></h5>
                     <input type="text" name="description" class="form-control" required="required" placeholder="<?php echo $lang['Category Description']; ?>"/>
                  </div>
               </div>
                <!-- End  Description Field -->
                <!-- Start Categories Brand -->
                <div class="form-group form-group-lg">
                    <div class="col-12">
                      <h5><?php echo $lang['Category Brand']; ?></h5>
                      <input
                         type="file"
                         name="cat_img"
                         class="form-control"
                         required="required"
                         placeholder="<?php echo $lang['Category Brand']; ?>" />
                    </div>
               </div>
               <!-- End Categories Brand -->
                <!-- Start category field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label"><?php echo $lang['Parent ?']; ?></label>
                    <div class="col-12">
                        <select class="browser-default custom-select" name="parent">
                            <option value="0"><?php echo $lang['None']; ?></option>
                            <?php
                             $allCats = getAllFrom("*", 'categories', "", "", "c_id", "ASC");
                              foreach ($allCats as $cat) {
                                  echo "<option value= '" . $cat['c_id'] . "'>" . $cat['c_name'] . "</option>";
                              }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- End category field -->
                <!-- Start  Visibltiy Field -->
                <div class="form-group form-group-lg">
                  <label class="col-sm-2 control-label"><?php echo $lang['Visible']; ?></label>
                    <div class="col-12">
                        <div>
                          <input id="vis-yes" type="radio" name="visiblity" value="0" checked />
                            <label for="vis-yes"><?php echo $lang['Yes']; ?></label>
                        </div>
                        <div>
                          <input id="vis-no" type="radio" name="visiblity" value="1" />
                            <label for="vis-no"><?php echo $lang['No']; ?></label>
                        </div>
                    </div>
                </div>
                <!-- End  Visiblity Field -->
                <!-- Start  submit Field -->
                <div class="form-group form-group-lg">
                    <div class="col-12">
                      <input type="submit" value="<?php echo $lang['Add New Category']; ?>" class="btn btn-brown btn-block" />
                    </div>
                </div>
                <!-- End  submit Field -->
              </form>
          </div>
          <div class="container padding-0">
            <a href="categories.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
          </div>

    <?php } elseif ($do == 'Insert') {
            // Insert Category Page
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

              <h1 class='text-center global-h1'><?php echo $lang['Insert Category']; ?></h1>
              <div class='container container-special'>

              <?php
              // Img info
               $cateImg     = $_FILES['cat_img'];
               $cateImgName = $_FILES['cat_img']['name'];
               $cateImgSize = $_FILES['cat_img']['size'];
               $cateImgTmp  = $_FILES['cat_img']['tmp_name'];
               $cateImgType = $_FILES['cat_img']['type'];

                // List Odf Allowed File Typed To Upload
                $cateImgAllowedExtention = array("jpeg", "jpg", "png", "gif");
                // Get cateImg Extention
                $cateImgEtention = strtolower(end(explode('.', $cateImgName)));
                // Get Variable From The Form
                $name              = $_POST['name'];
                $description       = $_POST['description'];
                $visiblity         = $_POST['visiblity'];
                $parent            = $_POST['parent'];

                // Validate The Form
                $formErrors = array();
                if (empty($name) || strlen($name) < 5) { $formErrors[] = '<b>Category Name</b> very short or empty'; }
                if (empty($description) || strlen($description) < 10) { $formErrors[] = '<b>Category Description</b> very short or empty'; }
                if (! empty($cateImgName) && ! in_array($cateImgEtention, $cateImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($cateImgName)) { $formErrors[] = '<b>Image category</b> is Required'; }
                if ($cateImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formErrors)) {
                  $cateImg = rand(0, 1000000) . '_' . $cateImgName;
                  move_uploaded_file($cateImgTmp, "upload/categories_img/" . $cateImg);

                    // Check If User Exist In Database
                  $check = checkItem("c_name", "categories", $name);
                    if ($check == 1) {
                        $theMsg =  "<div class='alert alert-danger text-center'><i class='fas fa-exclamation-circle' style='padding: 10px;'>" . $lang['Sorry This Category Is Exist'] . "</div>";
                        redirectHome($theMsg, 'back');
                    } else {
                        // Insert CategoryInfo In DB
                        $sql = $con->prepare("INSERT INTO
                                            categories(c_name, c_description, c_picture, active, parent)
                                            VALUES(:zname, :zdescription, :zcatImg, :zavisible, :zparent)");
                        $sql->execute(array (

                            'zname'            => $name,
                            'zdescription'     => $description,
                            'zcatImg'          => $cateImg,
                            'zavisible'        => $visiblity,
                            'zparent'           => $parent
                        ));
                          echo "<div class='container'>";
                           // Echo Success Message
                           $theMsg = "<div class='alert alert-success text-center' style='direction: ltr;'>" . $sql->rowCount() . ' Record Inserted</div>';
                           redirectHome($theMsg, 'back');
                          echo "</div>";
                       } // end check
                     } else {
                       // Loop Into Errors Array And Echo It
                       foreach($formErrors as $error) {
                         echo '<div class="alert alert-danger text-left" style="direction: ltr;"><i class="fas fa-exclamation-circle"></i> ' . $error . '</div>';
                       }
                       $theMsg = "";
                       redirectHome($theMsg, 'back');
                     } // end else
                   } else {
                     // Echo Failed Message
                     $theMsg = "<div class='alert alert-Danger text-center'>". $lang['Sorry Yoy Can\'t Browse This Page Directly'] . "</div>";
                     redirectHome($theMsg, 'back');
                  }
              echo "</div>"; // end insert container

        } elseif ($do == 'Edit') {
            // Check If Get Request Catid Is Numeric & Get The Integer Value It
           $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            // Select All Data Depend On This ID
            $sql = $con->prepare("SELECT * FROM categories WHERE c_id = ? ");
            // Execute Query
            $sql->execute(array($catid));
            // Fetch The Data
            $cat  = $sql->fetch();
            // The Row Count
            $count = $sql->rowCount();

            if($count > 0) { // If There Is Such ID Show The Form ?>

                <h1 class="text-center global-h1"><?php echo $lang['Edit Category']; ?></h1>
                <div class="container container-special form-content">
                    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="catid" value="<?php echo $catid ?>" />
                        <!-- Start  Name Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <h5><?php echo $lang['Category Name']; ?></h5>
                                  <input type="text" name="name" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['Category Name']; ?>" value="<?php echo $cat['c_name'] ?>">
                                </div>
                           </div>
                        <!-- End  Name Field -->
                        <!-- Start  Description Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                   <h5><?php echo $lang['Category Description']; ?></h5>
                                   <input type="text" name="description" class="form-control" required='required' placeholder="<?php echo $lang['Category Description']; ?>" value="<?php echo $cat['c_description'] ?>"/>
                                </div>
                            </div>
                        <!-- End  Description Field -->
                        <!-- Start category field -->
                            <div class="form-group form-group-lg">
                              <label class="col-sm-2 control-label"><?php echo $lang['Parent ?']; ?></label>
                                <div class="col-12">
                                    <select class="browser-default custom-select" name="parent">
                                      <option value="0">no parent</option>
                                      <?php 
                                          $allCats = getAllFrom("*", 'categories', "", "", "c_id", "ASC");
                                          foreach ($allCats as $c) {
                                              echo "<option value= '" . $c['c_id'] . "'";
                                              if ($cat['parent'] == $c['c_id']) {echo 'selected';}
                                              echo ">" . $c['c_name'] . "</option>"; 
                                          }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        <!-- End category field -->
                        <!-- Start  Visibltiy Field -->
                            <div class="form-group form-group-lg">
                              <label class="col-sm-2 control-label"><?php echo $lang['Visible']; ?></label>
                                <div class="col-12">
                                  <div>
                                    <input id="vis-yes" type="radio" name="visiblity" value="0" <?php if($cat['active'] == '0') { echo "checked"; } ?> />
                                      <label for="vis-yes" <?php if($cat['active'] == 0) { echo "checked"; } ?>><?php echo $lang['Yes']; ?></label>
                                  </div>
                                  <div>
                                    <input id="vis-no" type="radio" name="visiblity" value="1" <?php if($cat['active'] == '1') { echo "checked"; } ?>/>
                                      <label for="vis-no" <?php if($cat['active'] == 1) { echo "checked"; } ?>><?php echo $lang['No']; ?></label>
                                  </div>
                                </div>
                            </div>
                        <!-- End  Visiblity Field -->
                        <!-- Start  submit Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-12">
                                  <input type="submit" value="<?php echo $lang['Update Category']; ?>" class="btn btn-danger btn-block" />
                                </div>
                            </div>
                        <!-- End  submit Field -->
                    </form>
                </div>
                <div class="container padding-0">
                  <a href="categories.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                </div>
       <?php
        // If There Is No Such ID Show Error Message
        } else {
            echo "<div class='container container-special'>";
            $theMsg    =  "<div class='alert alert-danger'>There is No Such Id</div>";
            redirectHome($theMsg);
            echo "</div>";
        }

      } elseif ($do == 'Update') {

          echo "<h1 class='text-center global-h1'>" . $lang['Update Category'] . "</h1>";
          echo "<div class='container container-special'>";

          if($_SERVER['REQUEST_METHOD'] == 'POST') {
              // Get Variable From The Form
              $id          = $_POST['catid'];
              $name        = $_POST['name'];
              $desc        = $_POST['description'];
              $visibilty   = $_POST['visiblity'];
              $parent      = $_POST['parent'];

               if (empty($name)) { $formErrors [] = "Category name must be written."; }
               if (empty($desc)) { $formErrors [] = "Category description must be written.";  }
               if (empty($formErrors)) {
                // Update The Database With This Information
                $sql = $con->prepare("UPDATE
                                          categories
                                      SET
                                          c_name = ?,
                                          c_description = ?,
                                          active = ?,
                                          parent = ?
                                      WHERE
                                           c_id = ?");
                $sql->execute(array($name, $desc, $visibilty, $parent, $id));
                 // Echo Success Message
                $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . " Record Update.</div>";
                redirectHome($theMsg, 'back');
              } else {
                foreach ($formErrors as $err) {
                  $theMsg = "<div class='alert alert-danger text-center'>" . $err . "</div>";
                  redirectHome($theMsg, 'back');
                }
              }
           } else {
              $theMsg  = '<div class="alert alert-danger text-center">Sorry you Can\'t Browse This Page Directory</div>';
              redirectHome($theMsg);
          }
        echo "</div>";

      } elseif ($do == 'Delete') {

          echo "<h1 class='text-center global-h1'>" . $lang['Delete Category'] . "</h1>";
          echo "<div class='container container-special'>";

            // Check If Get Request Catid Is Numeric & Get The Integer Value It
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('c_id', 'categories', $catid);
            // If There Is Such ID Show The Form
            if($check > 0) {
              $sql = $con->prepare('DELETE FROM categories WHERE c_id = :zid');
              $sql->bindparam(":zid", $catid);    // ربطهم ببعض
              $sql-> execute();
              $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Delete Record'] . '</div>';
              redirectHome($theMsg, 'back');
            } else {
              $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
              redirectHome($theMsg, 'back');
            }
          echo "</div>";
      } elseif($do == 'childcat') {

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
            $check = checkItem('c_id', 'categories', $catid);

            if($check > 0) {
            // Get Categories where parent < 1
            $stmt= $con->prepare("SELECT * FROM categories WHERE c_id = ? order by c_id DESC");
            $stmt->execute(array($catid));
            $cats = $stmt->fetchAll(); ?>

          <div class="container-fluid categories">

            <?php if (!empty($cats)) { // check if not categories empty ?>
              <div class="table-responsive">
                  <table class="main-table text-center table table-bordered">
                      <tr>
                          <td>#ID</td>
                          <td><?php echo $lang['Category Name']; ?></td>
                          <td><?php echo $lang['Category Brand']; ?></td>
                          <td><?php echo $lang['Category Description']; ?></td>
                          <td><?php echo $lang['Visible']; ?></td>
                          <td><?php echo $lang['Control']; ?></td>
                      </tr>
                      <?php foreach($cats as $cat) {
                              echo "<tr>";
                                echo "<td>" . $cat['c_id']    . "</td>";
                                echo "<td>" . $cat['c_name']  . "</td>"; ?>
                                <td>
                                  <div class="box" style="background:url('<?php echo 'upload/categories_img/' . $cat['c_picture'] . ''; ?>')">
                                      <!-- Star Cover Right -->
                                      <div class="cover right">
                                       <button type="button" name="update" class="btn btn-warning bt-xs update" id="<?php echo $cat['c_id']; ?>">Edit Img >></button>
                                      </div>
                                    </div>
                                 </td>
                                <?php
                                 echo "<td>" . $cat['c_description']   . "</td>";
                                 echo "<td>"; if ($cat['active'] == 0) { echo "Public"; } else { echo "Private"; } echo "</td>";
                                 echo "<td>
                                      <a href='categories.php?do=Edit&catid=" . $cat['c_id'] . "' class='btn btn-primary'><i class='fas fa-edit'></i> " . $lang['Edit'] . "</a>
                                      <a href='categories.php?do=Delete&catid=" . $cat['c_id'] . "' class='confirm btn btn-danger'><i class='fas fa-times'></i> " . $lang['Remove'] .  "</a>";
                                 echo "</td>";
                               echo "</tr>";
                           } ?>
                   </table>
                   <a href="categories.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                <?php } else { ?>
                         <div class="container container-special">
                          <div class='alert alert-danger' style='margin-top: 60px;'><i class='fas fa-exclamation-circle' style="padding: 10px;"></i><?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></div>
                          <a href="categories.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                 <?php } 
                 echo "</div>";
            } else {
              header("Location: categories.php");
              exit();
            }
          } else {
          header('Location: index.php');
          exit();
        }

          // Get Visible categories
          $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 0");
          $sql->execute();
          $count_vis = $sql->fetchColumn();
          // Get UnVisible categories
          $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 1");
          $sql->execute();
          $count_unvis = $sql->fetchColumn();
          // Get Categories number
          $cats_num = countItems('c_id', 'categories');

          $pie_chart_cats = "{label: 'Categories', value:".$cats_num."}, {label: 'Visibile Categories', value:".$count_vis."}, {label: 'UnVisibile Categories', value:".$count_unvis."}";

          include $tpl .'footer-copyright.php';
          include $tpl .'footer.php'; ?>
          
         <script>
          Morris.Donut({
            element: 'pie-chart-cats',
            data: [<?php echo $pie_chart_cats; ?>]
          });
        </script>

  <?php } else {
          header('Location: index.php');
          exit();
      }
   ob_end_flush(); // Release The Output
?>


