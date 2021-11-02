<?php
  ob_start();
  $pageTitle = "My Cart";
  include 'init.php';

  $action = isset($_GET['action']) ? $_GET['action'] : '';
  // delete item
  if ($action == 'delete') {

      // Check If Get Request Itemid Is Numeric & Get The Integer Value It

     $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;

      // Select All Data Depend On This ID

      $check = checkItem('p_id', 'store_cart_item', $productid);

      // If There Is Such ID Show The Form

    if($check > 0) {

        // Delete product
        $sql = $con->prepare('DELETE FROM store_cart_item WHERE p_id = :zid');
        $sql->bindparam(":zid", $productid);
        $sql-> execute();

        // Delete shapes
        $stmt = $con->prepare('DELETE FROM shape WHERE p_id = :zid');
        $stmt->bindparam(":zid", $productid);
        $stmt-> execute();
    }
  } elseif ($action == 'deleteall') {

    if(isset($_SESSION['cus_id'])) {
      $cus_id = $_SESSION['cus_id'];
    } else {
      $cus_id = $sessionCustomer_not_login;
    }  

      // delete all products in cart
      $sql1 = $con->prepare('DELETE FROM store_cart_item WHERE customer_id = :zcuss');
      $sql1->bindparam(":zcuss", $cus_id);
      $sql1-> execute();
  
      // delete all shapes in cart
      $sql2 = $con->prepare('DELETE FROM shape WHERE cus_id = :zcus');
      $sql2->bindparam(":zcus", $cus_id);
      $sql2-> execute();
  
      header('Location: cart.php');
      exit();
    } 
?>

<div class="my-container container_100 _mar_top cart">
    <h1 class=""><?php echo $lang['cart']; ?> (<?php
        $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;
        if (isset($_SESSION['cart']) && isset($sessionCus)){
          $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$sessionCus}");
            echo "<span class='count-product'>" . $cou_cart . "</span>";
        } else {
            echo "<span class='count-product'>0</span>";
        } ?>
           <?php echo $lang['product']; ?>)</h1>

    <div class="free-shiping-eligible-cart-header"></div>

    <?php

     
     if (!empty($cou_cart) && isset($sessionCus)) { 
         $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$sessionCus}"); ?>
    <div class="items ft-products-list">
        <div class="header">
            <div class="item"><?php echo $lang['product']; ?></div>
            <div class="quantity"><?php echo $lang['amount']; ?></div>
            <div class="unit-price"><?php echo $lang['The total amount']; ?></div>
            <div class="subtotal"><?php echo $lang['final price']; ?></div>
        </div>

        <!-- Here All Cart Info -->
        
          <div id="mecart"></div> 
    </div>
</div>
    <?php } else { ?>
        <div class="cart-empty">
            <i class="fas fa-cart-plus main-cart"></i>
            <h2><?php echo $lang['Your cart is empty']; ?></h2>
            <p><?php echo $lang['Browse our categories and discover our best offers']; ?></p>
            <div class="btn btn-brown">
              <i class="fas fa-cart-plus"></i>
              <a href="index.php"><?php echo $lang['Shopping']; ?></a>
            </div>
        </div>
    <?php  } ?>
</div>

  <?php
    include $temp . 'footer.php';
    ob_end_flush();
   ?>

