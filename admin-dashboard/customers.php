<?php

    /*
    ======================================================
    == Manage customers Page
    ======================================================
    */

    ob_start();
    $pageTitle = 'Customers Manage';
    include 'init.php';

          if (isset($_SESSION['ID'])) {

             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

              // Start Manage Page

              if ($do == 'Manage') { // Manage Page

                  // Select All customers

                   $sql = $con->prepare("SELECT * FROM customers ORDER BY cus_id DESC");
                   $sql->execute();
                   $rows = $sql->fetchAll(); ?>


                      <h2 class="text-center text-capitalize global-h1"><?php echo $lang['customers']; ?></h2>
                        <div class="container-fluid customers ">
                          <div class="stat st-items">
                              <i class="fas fa-users dash_i"></i>
                              <div class="info">
                                 <?php echo $lang['Total customers']; ?>
                                  <span>
                                      <a href="customers.php"><?php echo countItems('cus_id', 'customers') ?></a>
                                  </span>
                               </div>
                           </div>
                           <?php if (! empty($rows)) { ?>
                            <div class="table-responsive">
                                <table class="main-table text-center manage_member table table-bordered">
                                    <tr>
                                        <td>#ID</td>
                                        <td><?php echo $lang['customer_name']; ?></td>
                                        <td><?php echo $lang['Email']; ?></td>
                                        <td><?php echo $lang['customer_phone']; ?></td>
                                        <td><?php echo $lang['city']; ?></td>
                                        <td><?php echo $lang['Register Date']; ?></td>
                                        <td><?php echo $lang['Control']; ?></td>
                                    </tr>

                                    <?php

                                         foreach($rows as $row) {

                                             echo "<tr>";
                                                echo "<td>" . $row['cus_id'] . "</td>";
                                                echo "<td>" . $row['cus_name'] .  "</td>";
                                                echo "<td>" . $row['cus_mail']   . "</td>";
                                                echo "<td>" . $row['cus_phone']  . "</td>";
                                                echo "<td>" . $row['cus_city']          . "</td>";
                                                echo "<td>" . $row['cus_enter_date'] . "</td>";
                                                echo "<td>
                                                    <a href='customers.php?do=Edit&customerid= "  . $row['cus_id'] . "' class='btn btn-success'><i class='fas fa-edit'></i>  " . $lang['Edit'] . "</a>
                                                    <a href='customers.php?do=Delete&customerid= " . $row['cus_id'] . "' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                                               echo "</td>";
                                             echo "</tr>";
                                         } ?>
                                </table>
                            </div>
                    <?php } else {

                                echo '<div class="container container-special">';
                                echo "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle' style='padding: 10px;''></i> " . $lang['Sorry Not Found Any Record To Show'] . "</b></div>";
                            } ?>
                        </div>


  <?php } elseif ($do == 'Edit') {  // Edit Page


                    // Check If Get Request customerid Is Numeric & Get The Integer Value It

                   $customerid = isset($_GET['customerid']) && is_numeric($_GET['customerid']) ? intval($_GET['customerid']) : 0;

                    // Select All Data Depend On This ID

                    $sql   = $con->prepare("SELECT * FROM customers WHERE cus_id = ? LIMIT 1");
                    // Execute Query
                    $sql->execute(array($customerid));
                    // Fetch The Data
                    $row   = $sql->fetch();
                    // The Row Count
                    $count = $sql->rowCount();

                    // If There Is Such ID Show The Form

                  if($count > 0) { ?>

                        <h1 class="text-center global-h1"><?php echo $lang['Edit customer']; ?></h1>

                        <div class="container container-special form-content">
                            <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="customerid" value="<?php echo $customerid ?>" />
                                <!-- Start customer name Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['customer_name']; ?><h5>
                                          <input type="text" name="cus_name" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['customer_name']; ?>" value="<?php echo $row['cus_name']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer name Field -->

                                <!-- Start customer mail Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['Email']; ?><h5>
                                          <input type="email" name="customer_mail" class="form-control" autocomplete= "off" required='required' placeholder="<?php echo $lang['Email']; ?>" value="<?php echo $row['cus_mail']; ?>" />
                                        </div>
                                    </div>
                                <!-- End customer mail Field -->

                                <!-- Start  Password Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['password']; ?><h5>
                                          <input type="hidden" name="oldPassword" value="<?php echo $row['cus_password']; ?>">
                                          <input type="Password" name="newPassword" class="password form-control" autocomplete="new-password" required='required' placeholder="<?php echo $lang['password']; ?>" value="<?php echo $row['cus_password']; ?>" />
                                          <i class="show-pass fas fa-eye fa-2x"></i>
                                        </div>
                                    </div>
                                <!-- End  Password Field -->

                                <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['customer_phone']; ?><h5>
                                          <input type="tel" name="phone" class="phone form-control" autocomplete="off" required='required' placeholder="<?php echo $lang['customer_phone']; ?>" value="<?php echo $row['cus_phone']; ?>" />
                                        </div>
                                    </div>
                                <!-- End phone Field -->

                                <!-- Start city Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <h5><?php echo $lang['city']; ?><h5>
                                          <input type="text" name="city" class="city form-control" autocomplete="off" required='required' placeholder="<?php echo $lang['city']; ?>"  value="<?php echo $row['cus_city']; ?>" />
                                        </div>
                                    </div>
                                <!-- End city Field -->

                                <!-- Start  submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-12">
                                          <input type="submit" value="<?php echo $lang['Edit customer']; ?>" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                <!-- End  submit Field -->

                            </form>
                        </div>
                        <div class="padding-0 container">
                          <a href="customers.php" class="btn btn-secondary go_back"><?php echo $lang['Go back']; ?></a>
                        </div>

          <?php

                // If There Is No Such ID Show Error Message

                } else {

                      echo "<div class='container container-special'>";
                        $theMsg  =  "<div class='alert alert-danger'>There is No Such Id</div>";
                        redirectHome($theMsg);
                      echo "</div>";
                }

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center global-h1'>" . $lang['Update customer'] . "</h1>";
            echo "<div class='container container-special'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get Variable From The Form

                $id              = $_POST['customerid'];
                $customer_name   = $_POST['cus_name'];
                $customer_mail   = $_POST['customer_mail'];
                $phone           = $_POST['phone'];
                $city            = $_POST['city'];

                // Password Trick
                $pass = '';

                if (empty($_POST['newPassword'])) {
                    $pass = $_POST['oldPassword'];
                } else {
                    $pass = sha1($_POST['newPassword']);
                }

                // Validate The Form

                $formErrors = array();

                if (empty($customer_name)){ $formErrors [] = 'Sorry, Customer name is required.'; }

                if (empty($customer_mail)){ $formErrors [] = 'Sorry, Customer Email is required.'; }

                if (empty($phone)){ $formErrors [] = 'Sorry, Customer phone is required.'; }

                if (empty($phone)){ $formErrors [] = 'Sorry, Customer phone is required.'; }

                if (empty($city)){ $formErrors [] = 'Sorry, Customer city is required.'; }

                if (strlen($customer_name) < 4) { $formErrors[] = 'customer name Can\'t Be Less Than<strong> 4 </strong> Characters'; }

                if (strlen($customer_name) > 20) { $formErrors[] = 'customer name Can\'t Be More Than <strong> 20 </strong>Characters'; }

                // validate phone
                if (isset($phone)) {
                    if (strlen($phone) < 11) {
                     $formErrors_sign[] = 'This <b>Phone</b> very short';
                    }

                    if (strlen($phone) > 13) {
                     $formErrors_sign[] = 'This <b>Phone</b> very long';
                    }

                    if (!is_numeric($phone)) {
                     $formErrors_sign[] = 'This <b>Phone</b> not valid';
                    }

                    if (empty($phone)) {
                     $formErrors_sign[] = 'Field <b>Phone</b> is empty';
                    }
                }

                // Check If There's No Proceed The Update Operation

                if (empty($formErrors)) {


                    $stmt = $con->prepare("SELECT
                                                  *
                                            FROM
                                                  customers
                                            WHERE
                                                	cus_mail = ?
                                            AND
                                                  cus_id != ?");
                        $stmt->execute(array($customer_mail, $id));
                        $count = $stmt->rowCount();


                    if ($count == 1) {
                        echo "<div class='alert alert-danger'>" . $lang['Sorry This Mail IS Exit'] . "</div>";
                        redirectHome($theMsg, 'back');

                    } else {
                     // Update The Database With This Information
                      $sql = $con->prepare("UPDATE customers SET cus_name = ?, cus_city = ?, cus_phone = ?, cus_mail = ?, cus_password = ? WHERE cus_id = ? LIMIT 1");
                      $sql->execute(array($customer_name, $city, $phone, $customer_mail, $pass, $id ));

                         // Echo Success Message

                        $theMsg ="<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Record Update'] . "</div>";
                        redirectHome($theMsg, 'back');
                    }

                  } else {
                    // Loop Into Errors Array And Echo It
                    foreach($formErrors as $error) { echo '<div class="alert alert-danger">' . $error . '</div>'; }
                    $theMsg = '';
                    redirectHome($theMsg, 'back');
                  }

            } else {
                 // Echo Danger Message

                $theMsg ="<div class='alert alert-danger'>" . $lang['Sorry You Can\'t Browse This Page'] . "</div>";
                redirectHome($theMsg, 'back');
            }

       echo "</div>";

        } elseif ($do == 'Delete') { // Delet Member Page

                  echo "<h1 class='text-center global-h1'>" . $lang['Delete customer'] . "</h1>";

                  echo "<div class='container container-special'>";

                        // Check If Get Request Userid Is Numeric & Get The Integer Value It

                       $customerid = isset($_GET['customerid']) && is_numeric($_GET['customerid']) ? intval($_GET['customerid']) : 0;

                        // Select All Data Depend On This ID

                        $check = checkItem('cus_id', 'customers', $customerid);

                        // If There Is Such ID Show The Form

                      if($check > 0) {

                          $sql = $con->prepare('DELETE FROM customers WHERE cus_id = :zcustomer');
                          $sql->bindparam(":zcustomer", $customerid); 
                          $sql-> execute();
                          $theMsg = "<div class='alert alert-success text-center'>" . $sql->rowCount() . ' ' . $lang['Delete Record'] . '</div>';
                           redirectHome($theMsg, 'back');

                      } else {
                          $theMsg = '<div class="alert alert-danger">' . $lang['This Id Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";

             }

      echo "</div>";


        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();
    ?>
