<?php

/*
===============================
   products Page
===============================
*/
   ob_start(); // OutPut Buffering Start
   $pageTitle = 'products';
   include 'init.php';
if (isset($_SESSION['ID'])) {

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

                  // Select All Users Expect Admin
                   $sql = $con->prepare("SELECT
                                              products. *,
                                              categories.c_name
                                        FROM
                                              products
                                        INNER JOIN
                                              categories
                                        ON    categories.c_id = products.categoryID
                                        ORDER BY p_id DESC");
                   $sql->execute();
                   $products = $sql->fetchAll();

       ?>

                      <h1 class="text-center global-h1"><?php echo $lang['Manage products']; ?></h1>
                        <div class="container-fluid products">
                          <div class="row">
                           <div class="col-sm-12">
                             <div class="pie-first">
                              <div id="pie-chart-products"></div>
                             </div>
                           </div>
                         </div>
                  <?php if (! empty($products)) { ?>
                            <div class="table-responsive">
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>#ID</td>
                                        <td><?php echo $lang['Product Image']; ?></td>
                                        <td><?php echo $lang['Product Name']; ?></td>
                                        <td><?php echo $lang['available_product_num']; ?></td>
                                        <td><?php echo $lang['Country made']; ?></td>
                                        <td><?php echo $lang['Price']; ?></td>
                                        <td><?php echo $lang['Category']; ?></td>
                                        <td><?php echo $lang['Adding Data']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($products as $product) {

                                             echo "<tr>";
                                                echo "<td>" . $product['p_id']    . "</td>"; ?>
                                                <td>
                                                  <div class="box" style="background:url('<?php echo 'upload/products/' . $product['p_picture'] . ''; ?>')">
                                                     <!-- Star Cover Right -->
                                                     <div class="cover right">
                                                       <button type="button" name="update_product_img" class="btn btn-warning bt-xs update_product_img" id="<?php echo $product['p_id']; ?>">Edit Img >></button>
                                                     </div>
                                                   </div>
                                                 </td>
                                                <?php
                                                echo "<td>" . $product['p_name']          . "</td>";
                                                echo "<td>" . $product['available_product_num'] . "</td>";
                                                echo "<td>" . $product['country_made']   . "</td>";
                                                echo "<td>" . $product['price']  . ' ' . $lang['Dinar'] . "</td>";
                                                echo "<td>" . $product['c_name']      . "</td>";
                                                echo "<td>" . $product['date_inserted']      . "</td>";
                                                echo "<td>
                                                    <a href='products.php?do=Edit&productid= " . $product['p_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> " . $lang['Edit'] . "</a>
                                                    <a href='products.php?do=Delete&productid= " . $product['p_id'] . "'' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                                    if ($product['product_status'] == 0) {
                                                        echo "<a href='products.php?do=Approve&productid= " . $product['p_id'] . "'' class='btn btn-info activate'><i class='fa fa-check'></i>  " . $lang['Approve'] . "</a>";
                                                    }
                                               echo "</td>";
                                             echo "</tr>";
                                         } ?>
                                </table>
                                <div class='btn btn-brown'><a href='products.php?do=Add'><i class="fas fa-plus"></i> <?php echo $lang["Add New product"]; ?></a></div>
                              <?php } else { ?>
                                       <div class="container container-special">
                                          <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle' style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any Record To Show, but you can add now.']; ?></b></div>

                                        <div class='btn btn-brown'>
                                          <a href='products.php?do=Add'>
                                            <i class='fas fa-plus'></i> <?php echo $lang['Add New product']; ?>
                                          </a>
                                      </div>
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
                           <input type="hidden" name="action" id="action_pro" value="insert" />
                           <input type="hidden" name="image_id" id="image_id" />
                           <input type="submit" name="insert" id="insert_pro" value="Insert" class="btn btn-info" />

                          </form>
                         </div>
                         <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         </div>
                        </div>
                       </div>
                      </div>

    <?php    } elseif ($do == 'Add') { ?>

                       <h1 class="text-center global-h1"><?php echo $lang['Add New Products']; ?></h1>
                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                <!-- Start  Name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Name Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="name"
                                                 class="form-control"
                                                 value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                                                 autocomplete= "off"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Name Of The product']; ?>" />
                                        </div>
                                      </div>
                                <!-- End  Name Field -->

                                <!-- Start  Description Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Description Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="description"
                                                 class="form-control"
                                                 value="<?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?>"
                                                 autocomplete= "off"
                                                 placeholder="<?php echo $lang['Description Of The product']; ?>" />
                                        </div>
                                     </div>
                                <!-- End  Description Field -->

                                <!-- Start  Price Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Price Of The product']; ?></h5>
                                          <input
                                                 type="text"
                                                 name="price"
                                                 class="form-control"
                                                 value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>"
                                                 autocomplete= "off"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Price Of The product']; ?>" />
                                        </div>
                                   </div>
                                <!-- End  Price Field -->

                                <!-- Start  discount Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['product discount']; ?></h5>
                                        <input
                                          type="number"
                                          name="discount"
                                          class="form-control"
                                          value="<?php echo isset($_POST['discount']) ? $_POST['discount'] : ''; ?>"
                                          autocomplete= "off"
                                          required='required'
                                          placeholder="<?php echo $lang['Discount']; ?>" />
                                    </div>
                                </div>
                                <!-- End  discount Field -->

                                <!-- Start  available_product_num Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['available_product_num']; ?></h5>
                                        <input
                                          type="number"
                                          name="available_product_num"
                                          class="form-control"
                                          value="<?php echo isset($_POST['available_product_num']) ? $_POST['available_product_num'] : ''; ?>"
                                          autocomplete= "off"
                                          required='required'
                                          placeholder="<?php echo $lang['available_product_num']; ?>" />
                                    </div>
                                </div>
                                <!-- End  available_product_num Field -->

                                <!-- Start Main Product Image -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Main Product Image']; ?></h5>
                                          <input
                                                 type="file"
                                                 name="product_img"
                                                 class="form-control"
                                                 value="<?php echo isset($_FILES['product_img']) ? $_FILES['product_img'] : ''; ?>"
                                                 autocomplete= "off"
                                                 required='required'
                                                 placeholder="<?php echo $lang['Product Image']; ?>" />
                                        </div>
                                   </div>
                                <!-- End Main Product Image -->

                                <!-- Start country made filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Country made']; ?></h5>
                                        <select class="form-control" name="country" required>
                                          <option value="0"><?php echo $lang['Country made']; ?></option>
                                          <option value="Kwuit">Kwuit</option>
                                          <option value="Egypt">Egypt</option>
                                          <option value="China">China</option>
                                          <option value="Japan">Japan</option>
                                          <option value="America">America</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End country made filed -->

                                <!-- Start  Status Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product status']; ?></h5>
                                            <select class="form-control" name="status">
                                                <option value="not"><?php echo $lang['Status']; ?></option>
                                                <option value="New"><?php echo $lang['New']; ?></option>
                                                <option value="Like-New"><?php echo $lang['Like New']; ?></option>
                                                <option value="Used"><?php echo $lang['Used']; ?></option>
                                                <option value="Old"><?php echo $lang['Old']; ?></option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Status Field -->

                                <!-- Start  Category Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product category']; ?></h5>
                                            <select class="form-control" name="category">
                                                <option value="not"><?php echo $lang['Category']; ?></option>
                                                  <?php
                                                  $allCats = getAllFrom("*", "categories", "", "", "c_id");
                                                       foreach ($allCats as $cat) {
                                                           echo "<option value='" . $cat['c_id'] . "'>" . $cat['c_name'] . "</option>";
                                                       }
                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Category Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input
                                                 type="submit"
                                                 value="<?php echo $lang['Add New product']; ?>"
                                                 class="btn btn-brown btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->
                            </form>
                        </div>
                        <div class="padding-0 container">
                          <a href="products.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                        </div>

    <?php } elseif ($do == 'Insert') {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

               echo "<h1 class='text-center global-h1'>" . $lang['Insert Product'] . "</h1>";
               echo "<div class='container'>";

                // Get Variable From The Form
                $name                  = $_POST['name'];
                $desc                  = $_POST['description'];
                $price                 = $_POST['price'];
                $discount              = $_POST['discount'];
                $country               = $_POST['country'];
                $status                = $_POST['status'];
                $category              = $_POST['category'];
                $available_product_num = $_POST['available_product_num'];

                $productImg     = $_FILES['product_img'];
                $productImgName = $_FILES['product_img']['name'];
                $productImgSize = $_FILES['product_img']['size'];
                $productImgTmp  = $_FILES['product_img']['tmp_name'];
                $productImgType = $_FILES['product_img']['type'];



                // List Odf Allowed File Typed To Upload
                $productImgAllowedExtention = array("jpeg", "jpg", "png", "gif");
                // Get productImg Extention
                $productImgEtention = strtolower(end(explode('.', $productImgName)));

                // Validate The Form
                $formErrors = array();
                if (empty($name)) { $formErrors[] = 'Name Can\'t Be <strong> Empty</strong>';  }
                if (!empty($productImgName) && ! in_array($productImgEtention, $productImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
                if (empty($productImgName)) { $formErrors[] = 'Image Product is <strong> Required </strong>'; }
                if ($productImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }
                if (empty($available_product_num)) { $formErrors[] = 'Available product number Product is <strong> Required </strong>';  }
                if (empty($desc)) { $formErrors[] = 'Description Can\'t Be <strong> Empty</strong>'; }
                if (empty($price)) { $formErrors[] = 'Price Can\'t Be <strong> Empty</strong>'; }
                if (empty($country)) { $formErrors[] = 'Country Can\'t Be <strong> Empty</strong>'; }
                if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                if ($country == '0') { $formErrors[] = 'You Must Choose <strong>Country</strong>'; }
                if ($category == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }


                if (empty($formErrors)) { // Check If There's No Proceed The Update Operation


                  $productImg = rand(0, 1000000) . '_' . $productImgName;

                  move_uploaded_file($productImgTmp, "upload/products/" . $productImg); // move image to dashboard-area

                  $tmp='upload/products/'. $productImg;
                  $new = '../upload/products/'. $productImg;
                  $cpy = copy($tmp, $new);
                  move_uploaded_file($productImgTmp, $cpy); // move image to front-area



                  $check = checkItem("p_name", "products", $name);// Check If User Exist In Database

                    if ($check == 1) {
                        $theMsg =  "<div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i> Sorry This Name Is Exist</div>";
                        redirectHome($theMsg, 'back');
                    } else {
                         // Insert UserInfo In DB
                        $sql = $con->prepare("INSERT INTO
                                            products(p_name, p_description, price, discount, available_product_num, country_made, p_picture, status_material, date_inserted, categoryID)
                                            VALUES(:zname, :zdesc, :zprice, :zprice_discount, :ava_pro_num, :zcountry, :zproductImg, :zstatus, now(), :zcategory)");
                        $sql->execute(array (
                            'zname'            => $name,
                            'zdesc'            => $desc,
                            'zprice'           => $price,
                            'zprice_discount'  => $discount,
                            'ava_pro_num'      => $available_product_num,
                            'zcountry'         => $country,
                            'zproductImg'      => $productImg,
                            'zstatus'          => $status,
                            'zcategory'        => $category
                        ));

                              echo "<div class='container'>";
                               // Echo Success Message
                               $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' Record Inserted</div>';
                               redirectHome($theMsg, 'back');
                              echo '</div>';
                          exit();
                       }

                } else {
                    // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo '<div class="alert alert-danger text-left container_special"><i class="fas fa-exclamation-circle" style="padding: 10px;"></i>' . $error . '</div>'; }
                    $theMsg = '';
                    redirectHome($theMsg, 'back');
                }

            } else {
                $theMsg =  '<div class="alert alert-danger">Sorry you Can\'t Enter To This Page</div>';
                redirectHome($theMsg);
            }
     echo "</div>";


        } elseif ($do == 'Edit') {

                    // Check If Get Request itemid Is Numeric & Get The Integer Value It
                   $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;
                    // Select All Data Depend On This ID
                    $sql   = $con->prepare("SELECT * FROM products WHERE p_id = ?");
                    // Execute Query
                    $sql->execute(array($productid));
                    // Fetch The Data
                    $product   = $sql->fetch();
                    // The Row Count
                    $count = $sql->rowCount();

                  // If There Is Such ID Show The Form
                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit products']; ?></h1>
                         <div class="container container-special form-content">
                           <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                             <input type="hidden" name="productid" value="<?php echo $productid ?>" />

                                <!-- Start  Name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Product Name']; ?></h5>
                                          <input
                                             type="text"
                                             name="name"
                                             class="form-control"
                                             autocomplete= "off"
                                             required='required'
                                             placeholder="<?php echo $lang['Name Of The product']; ?>"
                                             value="<?php echo $product['p_name'] ?>"/>
                                        </div>
                                      </div>
                                <!-- End  Name Field -->

                                <!-- Start  Description Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Description Of The product']; ?></h5>
                                          <input
                                             type="text"
                                             name="description"
                                             class="form-control"
                                             autocomplete= "off"
                                             placeholder="<?php echo $lang['Description Of The product']; ?>"
                                             value="<?php echo $product['p_description'] ?>"/>
                                        </div>
                                     </div>
                                <!-- End  Description Field -->

                                <!-- Start  Price Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Price Of The product']; ?></h5>
                                          <input
                                           type="text"
                                           name="price"
                                           class="form-control"
                                           autocomplete= "off"
                                           required='required'
                                           placeholder="<?php echo $lang['Price Of The product']; ?>"
                                           value="<?php echo $product['price'] ?>" />
                                        </div>
                                   </div>
                                <!-- End  Price Field -->
                                <!-- Start  discount Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Discount']; ?></h5>
                                        <input
                                          type="number"
                                          name="discount"
                                          class="form-control"
                                          autocomplete= "off"
                                          value="<?php echo $product['discount'] ?>"
                                          required='required'
                                          placeholder="<?php echo $lang['Discount']; ?>" />
                                    </div>
                                </div>
                                <!-- End  discount Field -->

                                <!-- Start  available_product_num Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Discount']; ?></h5>
                                        <input
                                                type="number"
                                                name="available_product_num"
                                                class="form-control"
                                                autocomplete= "off"
                                                value="<?php echo $product['available_product_num'] ?>"
                                                required='required'
                                                placeholder="<?php echo $lang['available_product_num']; ?>" />
                                    </div>
                                </div>
                                <!-- End  available_product_num Field -->

                                <!-- Start country made filed -->
                                <div class="form-group form-group-lg">
                                    <div class="col-12">
                                      <h5><?php echo $lang['Country made']; ?></h5>
                                        <select class="form-control" name="country" required>
                                            <option value="Kwuit" <?php if ($product['country_made'] == $product['country_made'] ) { echo "selected"; } ?>>Kwuit</option>
                                            <option value="Egypt" <?php if ($product['country_made'] == $product['country_made'] ) { echo "selected"; } ?>>Egypt</option>
                                            <option value="China" <?php if ($product['country_made'] == $product['country_made'] ) { echo "selected"; } ?>>China</option>
                                            <option value="Japan" <?php if ($product['country_made'] == $product['country_made'] ) { echo "selected"; } ?>>Japan</option>
                                            <option value="America" <?php if ($product['country_made'] == $product['country_made'] ) { echo "selected"; } ?>>America</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End country made -->

                                <!-- Start  Status Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product status']; ?></h5>
                                            <select class="form-control" name="status">
                                                <option value="new" <?php if ($product['status']== 'new') { echo "selected"; } ?> ><?php echo $lang['New']; ?></option>
                                                <option value="like-new" <?php if ($product['status']== 'like-new') { echo "selected"; } ?> ><?php echo $lang['Like New']; ?></option>
                                                <option value="used" <?php if ($product['status']== 'used') { echo "selected"; } ?> ><?php echo $lang['Used']; ?></option>
                                                <option value="old" <?php if ($product['status']== 'old') { echo "selected"; } ?> ><?php echo $lang['Old']; ?></option>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Status Field -->

                                <!-- Start  Category Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['product category']; ?></h5>
                                            <select class="form-control" name="category">
                                                  <?php
                                                     $sql2 = $con->prepare("SELECT * FROM categories");
                                                     $sql2->execute();
                                                     $cats = $sql2->fetchAll();
                                                       foreach ($cats as $cat) {
                                                           echo "<option value='" . $cat['c_id'] . "'";
                                                           if ($product['categoryID'] == $cat['c_id']) { echo "selected"; }
                                                           echo ">" . $cat['c_name'] . "</option>";
                                                       }

                                                    ?>
                                            </select>
                                        </div>
                                   </div>
                                <!-- End  Category Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input
                                                 type="submit"
                                                 value="<?php echo $lang['Save Item']; ?>"
                                                 class="btn btn-brown btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->
                            </form>
                        </div>
                        <div class="padding-0 container">
                          <a href="products.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                        </div>
             <?php
                // If There Is No Such ID Show Error Message
              } else {
                  echo "<div class='container'>";
                    $theMsg ="<div class='alert alert-danger text-center'>There is No Such Id</div>";
                    redirectHome($theMsg);
                  echo "</div>";
                }


        }  elseif ($do == 'Update') {

            echo "<h1 class='text-center global-h1'>" . $lang['Update Product'] . "</h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form
                $id                    = $_POST['productid'];
                $name                  = $_POST['name'];
                $desc                  = $_POST['description'];
                $price                 = $_POST['price'];
                $discount              = $_POST['discount'];
                $available_product_num = $_POST['available_product_num'];
                $country               = $_POST['country'];
                $status                = $_POST['status'];
                $cat                   = $_POST['category'];

                // Validate The Form
                $formErrors = array();
                if (empty($name)) { $formErrors[] = 'Name Can\'t Be <strong> Empty</strong>';  }
                if (empty($desc)) { $formErrors[] = 'Description Can\'t Be <strong> Empty</strong>'; }
                if (empty($price)) { $formErrors[] = 'Price Can\'t Be <strong> Empty</strong>'; }
                if (empty($country)) { $formErrors[] = 'Country Can\'t Be <strong> Empty</strong>'; }
                if ($status == 'not') { $formErrors[] = 'You Must Choose <strong>Status</strong>'; }
                if ($cat == 'not') { $formErrors[] = 'You Must Choose <strong>Category</strong>'; }

                // Check If There's No Proceed The Update Operation
                if (empty($formError)) {
                  // Update The Database With This Information
                  $sql = $con->prepare("UPDATE
                                              products
                                        SET
                                               p_name = ?,
                                               p_description = ?,
                                               price = ?,
                                               discount = ?,
                                               available_product_num = ?,
                                               country_made = ?,
                                               status_material = ?,
                                               categoryID = ?
                                        WHERE
                                               p_id = ? LIMIT 1");
                  $sql->execute(array($name, $desc, $price, $discount, $available_product_num, $country, $status, $cat, $id ));

                   // Echo Success Message
                   $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Record Update'] . "</div>";
                   redirectHome($theMsg, 'back');
                } else {
                  // Loop Into Errors Array And Echo It
                  foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                  $theMsg = '';
                  redirectHome($theMsg, 'back');
                }
            } else {
                $theMsg   = '<div class="alert alert-danger">' . $lang['Sorry you Can\'t Browse This Page Directory'] . '</div>';
                redirectHome($theMsg);
            }

        echo "</div>";
 
      } elseif ($do == 'product_content') {

         // Select All Users Expect Admin
         $sql = $con->prepare("SELECT
                  products. *,
                  categories.c_name
            FROM
                  products
            INNER JOIN
                  categories
            ON    categories.c_id = products.categoryID
            WHERE 
                  p_id = ?
            ORDER BY p_id DESC");
         $sql->execute(array($_GET['p_id']));
         $products = $sql->fetchAll();

          ?>

        <h1 class="text-center global-h1"><?php echo $lang['All product information']; ?></h1>
        <div class="container-fluid products">
          <?php if (! empty($products)) { ?>
          <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
              <tr>
                <td>#ID</td>
                <td><?php echo $lang['Product Image']; ?></td>
                <td><?php echo $lang['Product Name']; ?></td>
                <td><?php echo $lang['available_product_num']; ?></td>
                <td><?php echo $lang['Country made']; ?></td>
                <td><?php echo $lang['Price']; ?></td>
                <td><?php echo $lang['Category']; ?></td>
                <td><?php echo $lang['Adding Data']; ?></td>
                <td><?php echo $lang['Control']; ?></td>
              </tr>

            <?php

                foreach($products as $product) {

                    echo "<tr>";
                      echo "<td>" . $product['p_id']    . "</td>"; ?>
                      <td>
                        <div class="box" style="background:url('<?php echo 'upload/products/' . $product['p_picture'] . ''; ?>')">
                            <!-- Star Cover Right -->
                            <div class="cover right">
                              <button type="button" name="update_product_img" class="btn btn-warning bt-xs update_product_img" id="<?php echo $product['p_id']; ?>">Edit Img >></button>
                            </div>
                          </div>
                        </td>
                      <?php
                      echo "<td>" . $product['p_name']          . "</td>";
                      echo "<td>" . $product['available_product_num'] . "</td>";
                      echo "<td>" . $product['country_made']   . "</td>";
                      echo "<td>" . $product['price'] . ' ' . $lang['Dinar'] . "</td>";
                      echo "<td>" . $product['c_name']      . "</td>";
                      echo "<td>" . $product['date_inserted']      . "</td>";
                      echo "<td>
                          <a href='products.php?do=Edit&productid= " . $product['p_id'] . "' class='btn btn-success'><i class='fas fa-edit'></i> " . $lang['Edit'] . "</a>
                          <a href='products.php?do=Delete&productid= " . $product['p_id'] . "'' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                          if ($product['product_status'] == 0) {
                              echo "<a href='products.php?do=Approve&productid= " . $product['p_id'] . "'' class='btn btn-info activate'><i class='fas fa-check'></i>  " . $lang['Approve'] . "</a>";
                          }
                      echo "</td>";
                    echo "</tr>";
                } ?>
            </table>
          <?php } else { ?>
            <div class="container container-special">
              <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle' style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any Record To Show']; ?></b></div>
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
                  </p>
                  <br />
                  <input type="hidden" name="action" id="action_pro" value="insert" />
                  <input type="hidden" name="image_id" id="image_id" />
                  <input type="submit" name="insert" id="insert_pro" value="Insert" class="btn btn-info" />

                </form>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
 
     <?php } elseif ($do == 'Delete') {

                echo "<h1 class='text-center global-h1'>" . $lang['Delete Product'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request Itemid Is Numeric & Get The Integer Value It
                       $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('p_id', 'products', $productid);

                        // If There Is Such ID Show The Form
                        if($check > 0) {
                          $sql = $con->prepare('DELETE FROM products WHERE p_id = :zname');
                          $sql->bindparam(":zname", $productid);    // ربطهم ببعض
                          $sql-> execute();

                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' Delete Record</div>';
                          redirectHome($theMsg, 'back');
                      } else {
                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg);
                      }

                  echo "</div>";

        } elseif ($do == 'Approve') {

                  echo "<h1 class='text-center global-h1'>" . $lang['Approve Product'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It
                       $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('p_id', 'products', $productid);

                        // If There Is Such ID Show The Form
                        if($check > 0) {
                          $sql = $con->prepare("UPDATE products SET product_status = 1 WHERE p_id = ?");
                          $sql-> execute(array($productid));

                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . " Record Approved" .  '</div>';
                          redirectHome($theMsg, 'back');
                      } else {
                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";
           } else {
             header('Location: dashboard.php');
             exit();
           }

        include $tpl . 'footer-copyright.php'; ?>

        <?php
          // Get pending products
          $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE product_status = 0");
          $sql->execute();
          $count_1 = $sql->fetchColumn();
          // Get approved products
          $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE product_status = 1");
          $sql->execute();
          $count_2 = $sql->fetchColumn();
          // Get Categories number
          $products_num = countItems('p_id', 'products');


          $pie_chart_products = "{label: 'Total Products', value:".$products_num."}, {label: 'Pending products', value:".$count_1."}, {label: 'Approved products', value:".$count_2."}"; ?>


        <?php
        include $tpl . 'footer.php'; ?>
        <script>
          Morris.Donut({
            element: 'pie-chart-products',
            data: [<?php echo $pie_chart_products; ?>]
          });
       </script>
  <?php } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();
?>
