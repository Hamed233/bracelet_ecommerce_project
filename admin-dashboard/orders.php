<?php

/*
===============================
   orders Page
===============================
*/

   ob_start(); // OutPut Buffering Start
   if(isset($_GET['do']) == 'order_content') {
    $pageTitle = 'Order content';
   } else {
    $pageTitle = 'Manage Orders';
   }
   include 'init.php';
if (isset($_SESSION['ID'])) {

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {

          // Select All orders

          $sql = $con->prepare("SELECT * FROM orders ORDER BY ord_id DESC");
          $sql->execute();
          $orders = $sql->fetchAll(); ?>

<h1 class="text-center global-h1"><?php echo $lang['Manage orders']; ?></h1>
<div class="container-fluid orders">
    <div class="stat st-items">
        <i class="fab fa-first-order-alt dash_i"></i>
        <div class="info">
            <?php echo $lang['Total orders']; ?>
            <span>
                <a href="orders.php"><?php echo countItems('ord_id', 'orders') ?></a>
            </span>
        </div>
    </div>
    <?php  if (!empty($orders)) { ?>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td><?php echo $lang['order number']; ?></td>
                <td><?php echo $lang['customer_name']; ?></td>
                <td><?php echo $lang['payment_type']; ?></td>
                <td><?php echo $lang['customer_phone']; ?></td>
                <td><?php echo $lang['customer_phone_whats']; ?></td>
                <td><?php echo $lang['area_address']; ?></td>
                <td><?php echo $lang['cus_address_2']; ?></td>
                <td><?php echo $lang['additional_info']; ?></td>
                <td><?php echo $lang['customer_area']; ?></td>
                <td><?php echo $lang['order_total_price']; ?></td>
                <td><?php echo $lang['Order Date']; ?></td>
                <td><?php echo $lang['Control']; ?></td>
            </tr>

            <?php

              foreach($orders as $order) {

                  echo "<tr>";
                    echo "<td><a href='orders.php?do=order_content&ordernum=" . $order['ord_number'] . "' target='_blank'>" . $order['ord_number'] . "</a></td>";
                    echo "<td>" . $order['f_name'] . ' ' . $order['s_name'] . "</td>";
                    echo "<td>" . $order['payment_type']         . "</td>";
                    echo "<td>+" . $order['country_key'] . ' ' . $order['cus_phone_number'] . "</td>";
                    echo "<td>+" . $order['country_key'] . ' ' . $order['cus_whats_number'] . "</td>";
                    echo "<td>" . $order['area_address']         . "</td>";
                    echo "<td>" . $order['s_address'] . "</td>";
                    echo "<td>" . $order['additional_information']         . "</td>";
                    echo "<td>" . $order['custmer_area'] . "</td>";
                    echo "<td>" . $order['ord_total_price'] . ' ' . $lang['dinar'] . "</td>";
                    echo "<td>" . $order['ord_date'] . "</td>";
                    echo "<td>
                        <a href='orders.php?do=Delete&orderid=" . $order['ord_id'] . "&ordernum" . $order['ord_number'] . "'' class='btn btn-danger confirm'><i class='fas fa-times'></i>  " . $lang['Delete'] . "</a>";
                    echo "</td>";
                  echo "</tr>";

              }

            ?>

        </table>
    </div>
    <?php } else { ?>
    <div class="container container-special">
        <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle'
                    style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any orders.']; ?></b></div>
    </div>
    <?php } ?>
</div>

<?php } elseif ($do == 'order_content') { 

      echo "<h1 class='text-center global-h1'>" . $lang['All products special order:'] . ' <span class="order_num">' . $_GET['ordernum'] . "</span></h1>";
              echo "<div class='container-fluid'>";
              // Check If Get Request order num Is Numeric & Get The Integer Value It
              $ordernum = isset($_GET['ordernum']) && is_numeric($_GET['ordernum']) ? intval($_GET['ordernum']) : 0;

              // Select All Data Depend On This ID
              $check = checkItem('ord_number', 'orders', $ordernum);

              // If There Is Such ID Show The Form
              if($check > 0) {

                $stmt = $con->prepare('SELECT * FROM orderdetails WHERE ord_number = ? ORDER BY ord_detail_id DESC');
                $stmt-> execute(array($ordernum));
                $products = $stmt->fetchAll();
 
                $total = 0;
                if (!empty($products)) { ?>
<div class="table-responsive">
    <table class="main-table text-center table table-bordered">
        <tr>
            <td><?php echo $lang['Product ID']; ?></td>
            <td><?php echo $lang['Product Name']; ?></td>
            <td><?php echo $lang['order quantity']; ?></td>
            <td><?php echo $lang['size']; ?></td>
            <td><?php echo $lang['color']; ?></td>
            <td><?php echo $lang['Font']; ?></td>
            <td><?php echo $lang['Engraving']; ?></td>
            <td><?php echo $lang['product_f_price']; ?></td>
            <td><?php echo $lang['Order Date']; ?></td>
            <td><?php echo $lang['Control']; ?></td>
        </tr>

        <?php

          foreach($products as $product) {

              echo "<tr>";
                echo "<td><a href='products.php?do=product_content&p_id=" . $product['productID'] . "'>" . $product['ord_number'] . "</a></td>";
                echo "<td>" . $product['p_name'] . "</td>";
                echo "<td>" . $product['ord_quantity'] . "</td>";
                echo "<td>" . $product['size'] . "</td>";
                echo "<td>" . $product['product_color'] . "</td>";
                echo "<td>" . $product['bracelet_type'] . "</td>";
                echo '<td class="engraving">';
                // Get shape
                $stmt = $con->prepare('SELECT * FROM shape WHERE p_id = ? ORDER BY shap_id DESC');
                $stmt-> execute(array($product['productID']));
                $shapes = $stmt->fetchAll();
                if(!empty($shapes)) {
                  echo '<p>' . $lang['Engraving shape'] . ':</p>';
                  foreach($shapes as $shape) { ?>
        <img class="shap_img" src="../layout/images/personalize_images/<?php echo $shape['shap_img']; ?>" alt="shape" />
        <?php }
                } else {
                  echo $lang['Without Engraving'];
                }
                if(!empty($product['text_engraving']) && $product['text_engraving'] != 'not_found') {
                  echo '<div class="engraving-txt">';
                  echo '<p>' . $lang['Engraving txt'] . ':' . '</p>';
                  echo '<span>' . $product['text_engraving'] . '</span>';
                  echo '<p>' . $lang['Engraving txt position'] . ':' . '</p>';
                  echo '<span>' . ($product['position_txt_eng'] != 'not_found' ? $product['position_txt_eng'] : 'Center') . '</span>';
                  echo '</div>';
                }        
                echo '</td>';
                echo "<td>" . $product['product_f_price'] . ' ' . $lang['Dinar'] . "</td>";
                echo "<td>" . $product['timestamp']            . "</td>";
                echo "<td>
                  <a href='orders.php?do=done_delivery&pid=" . $product['productID'] . "&ordnum=" . $product['ord_number'] . "&orderid=" . $product['ord_detail_id'] . "'' class='btn btn-primary'><i class='fas fa-check'></i>  " . $lang['Done Delivery'] . "</a>";
                echo "</td>";
              echo "</tr>";

              $total +=  $product['product_f_price'];

          }

        ?>

    </table>
    <div class="footer-table">
        <a href="orders.php" class="btn btn-secondary"><?php echo $lang['Go back']; ?></a>

        <div class="total_price">
            <?php echo $lang['total price'] . ": " . $total . ' ' . $lang['Dinar'] ; ?>
        </div>


    </div>
</div>
<?php } else { ?>
      <div class="container container-special">
          <div class='alert alert-danger' style='margin-top: 60px;'><b><i class='fas fa-exclamation-circle'
                      style="padding: 10px;"></i> <?php echo $lang['Sorry Not Found Any orders.']; ?></b></div>
      </div>
<?php } 

      } else {
          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Order Not Exist'] . '</div>';
          redirectHome($theMsg);
      }
echo "</div>";

      

     } elseif ($do == 'done_delivery') {

       echo "<h1 class='text-center global-h1'>" . $lang['Done Delivered'] . "</h1>";
           echo "<div class='container'>";

              // Check If Get Request Itemid Is Numeric & Get The Integer Value It
              $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;

              // Select All Data Depend On This ID
              $check = checkItem('ord_detail_id', 'orderdetails', $orderid);

              // If There Is Such ID Show The Form
            if($check > 0) {
              
                // First update product done sell
                $stmt1 = $con->prepare("UPDATE products SET done_sell = done_sell + 1 WHERE p_id = ? LIMIT 1");
                $stmt1->execute(array($_GET['pid']));

                // Second delete shapes special product if exist
                $stmt2 = $con->prepare('DELETE FROM shape WHERE p_id = :zid');
                $stmt2->bindparam(":zid", $_GET['pid']);
                $stmt2-> execute();

                // Third delete orderdetails special order
                $stmt3 = $con->prepare('DELETE FROM orderdetails WHERE ord_detail_id = :zid');
                $stmt3->bindparam(":zid", $orderid);
                $stmt3-> execute();

                $theMsg = "<div class='alert alert-success text-center'>" . $stmt3->rowCount() . ' ' . $lang['order is delivered'] . '</div>';
                redirectHome($theMsg, 'back');

            } else {

                $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Id Not Exist'] . '</div>';
                redirectHome($theMsg, 'back');
            }

       echo "</div>";
                  ?>

<?php } elseif ($do == 'Delete') {

                echo "<h1 class='text-center global-h1'>" . $lang['Delete order'] . "</h1>";
                  echo "<div class='container'>";

                        // Check If Get Request orderid Is Numeric & Get The Integer Value It 
                       $orderid = isset($_GET['orderid']) && is_numeric($_GET['orderid']) ? intval($_GET['orderid']) : 0;
                       $ordernum = isset($_GET['ordernum']) && is_numeric($_GET['ordernum']) ? intval($_GET['ordernum']) : 0;

                        // Select All Data Depend On This ID
                        $check = checkItem('ord_id', 'orders', $orderid);

                        // If There Is Such ID Show The Form
                      if($check > 0) {
                         // delete order details 
                          $stmt1 = $con->prepare('DELETE FROM orderdetails WHERE ord_number = :zid');
                          $stmt1->bindparam(":zid", $ordernum);
                          $stmt1-> execute();

                          // delete order
                          $stmt2 = $con->prepare('DELETE FROM orders WHERE ord_id = :zid');
                          $stmt2->bindparam(":zid", $orderid);
                          $stmt2-> execute();


                          $theMsg = "<div class='alert alert-success text-center'>" . $stmt2->rowCount() . ' Delete Record</div>';
                           redirectHome($theMsg, 'back');

                      } else {

                          $theMsg = '<div class="alert alert-danger text-center">' . $lang['This Order Not Exist'] . '</div>';
                          redirectHome($theMsg, 'back');
                      }

                  echo "</div>";


        } else {
          header('Location: dashboard.php');
          exit();
        }

        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php';

    } else {
        header('Location: index.php');
        exit();
    }

   ob_end_flush();
?>