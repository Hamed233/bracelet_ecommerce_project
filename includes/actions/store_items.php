<?php
session_start();
$lang = '../langs/';
include '../../config/config_lang.php';  // Configration languages
include '../../config/connectDB.php';  // connect db
include '../functions/function.php';

  // check if isset session customer
  $sessionCustomer = '';
  if (isset($_SESSION['customer'])) {
    $sessionCustomer = $_SESSION['customer'];
  } else {
    if(!isset($_SESSION['customer_id'])) {
      $_SESSION['customer_id'] = rand(10, 100000);
    }
    $_SESSION['cart'] = 0;
  }
  $sessionCustomer_not_login = $_SESSION['customer_id'];

  // get number of cart product
  if (isset($_POST['total_cart_items'])) {
    if (isset($_SESSION['cart'])) {
      $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;
      if (isset($sessionCus)){
        $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$sessionCus}");
        echo $cou_cart;
        exit();
      }
    } else {
      echo '0';
    }
  } 

    // get number of love product
    if (isset($_POST['total_love_items'])) {
        $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;
          $cou_fav = countItems("p_fav", "favorite_products", "WHERE userid = {$sessionCus}");
          echo $cou_fav;
          exit();
    }


  if(isset($_POST['productid'])) {

    $p_id = $_POST['productid'];
    $userid = $_POST['user_id'];
    $icon = $_POST['icon'];

      $stmt1 = $con->prepare("SELECT * FROM favorite_products WHERE p_id = ? limit 1");
      $stmt1->execute(array($p_id));
      $rows = $stmt1->rowCount();

      if($rows < 1){
        $stmt = $con->prepare("INSERT INTO favorite_products(p_id, userid, icon) VALUES (:zpid, :zuserid, :zicon)");
        $stmt->execute(array(
          'zpid'    => $p_id,
          'zuserid' => $userid,
          'zicon'   => $icon
        ));
        echo $p_id;
      } else {
        $stmt = $con->prepare("DELETE FROM favorite_products WHERE p_id = :pid");
        $stmt->bindparam(":pid", $p_id);
        $stmt->execute();
  
        echo "Deleted";
        echo $p_id;
      }
  }


if (isset($_POST['item_img'])) {
  // store information
  $cart                   = $_POST['cart'];
  $img                    = $_POST['item_img'];
  $name_item              = $_POST['item_name'];
  $p_desc                 = $_POST['item_dec'];
  $product_id             = $_POST['product_id'];
  $color                  = $_POST['color_p'];
  $size                   = $_POST['size'];
  $kind                   = $_POST['kind_p'];
  if(!empty($_POST['text_engraving'])){
    $text_engraving = $_POST['text_engraving'];
  } else {
    $text_engraving = 'not_found';
  }

  if(!empty($_POST['position_eng'])){
    $position_eng = $_POST['position_eng'];
  } else {
    $position_eng = 'Center';
  }
  
  $price                  = $_POST['item_price'];
  $discount               = $_POST['price_discount'];
  $quantity               = $_POST['item_quantity'];

  // check if product is exist or not
  $sql = $con->prepare("SELECT p_id FROM store_cart_item WHERE p_id = ?");
  $sql->execute(array($product_id));
  $count = $sql->rowCount();

  if(isset($_SESSION['cus_id'])) {
    $sessionCus = $_SESSION['cus_id'];
  } else {
    $sessionCus = $sessionCustomer_not_login;
  }

  if ($count !== 1) {
    $stmt = $con->prepare("INSERT INTO
                            store_cart_item(p_id, p_name, p_desc, p_img, p_price, p_quantity, discount, color, kind, customer_id, product_size, text_engraving, position_eng,  date_insert)
                            VALUES(:id, :pname, :descr, :pimg, :price, :quan, :discount, :color, :kind, :cusid, :size, :text_eng, :pos_eng, now())");
    $stmt->execute(array(
      'id'       => $product_id,
      'pname'    => $name_item,
      'descr'    => $p_desc,
      'pimg'     => $img,
      'price'    => $price,
      'quan'     => $quantity,
      'discount' => $discount,
      'color'    => $color,
      'kind'     => $kind,
      'cusid'    => $sessionCus,
      'size'     => $size,
      'text_eng' => $text_engraving,
      'pos_eng'  => $position_eng
    ));

    // for equal session with information
    $_SESSION['cart']     = $cart;
    $_SESSION['id']       = $product_id;
  }
  $cou_cart = countItems("p_c_id", "store_cart_item");
  echo $cou_cart;
  exit();
}

if (isset($_POST['mycart'])) {
  $total    = 0; ?>
  <form class="ft-product" action="order.php?do=check" method="POST">
    <?php
    // Get All products special client
    if(isset($_SESSION['cus_id'])) {
      $cus_id = $_SESSION['cus_id'];
    } else {
      $cus_id = $sessionCustomer_not_login;
    }

    $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id DESC");
    $getAll->execute(array($cus_id));
    $all = $getAll->fetchAll();
    

    foreach ($all as $value) { ?>

      <div class="ln product for_desktop">
          <div class="image ft-product-image">
            <a href="product.php?p_id=<?php echo $value['p_id'] . '&productname=' . preg_replace('/\s/', '%', $value['p_name']) . '&action=getproductinformation'; ?>" target="_blank">
              <img class="lazy -loaded" width="60" height="60" src="<?php echo $value['p_img']; ?>" value="<?php echo $value['p_img']; ?>" alt="product img">
            </a>
            <input name="image" type="hidden" value="<?php echo $value['p_img']; ?>">
          </div>

          
          <div class="item">
            <input name="product" type="hidden" value="<?php echo $value['p_name']; ?>">
            <a href="#" class="name -mbs -inline-block ft-product-name "><?php echo $value['p_name']; ?></a>
            <p class="product-desc"><?php echo $value['p_desc']; ?></p>
            <?php 
              // Get All shape special every product
              $shapes = $con->prepare("SELECT * FROM shape WHERE p_id = ? ORDER BY shap_id DESC");
              $shapes->execute(array($value['p_id']));
              $all_shapes = $shapes->fetchAll();

              if(!empty($all_shapes)) {
                echo '<div class="engraving-content">';
                echo "<p class='d-inline-block'>" . $lang['Engraving shape: '] . "</p>"; 
                echo '<br /> <div class="shape-img-content text-center">';
                foreach($all_shapes as $shape) { ?>
                  <img src="layout/images/personalize_images/<?php echo $shape['shap_img']; ?>" alt="shape" />
          <?php 
               }
               echo "</div>";
          
              if($value['text_engraving'] != 'not_found') {
                echo "<p class='d-inline-block engraving_t'>" . $lang['Engraving text: '] . '<span>' . $value['text_engraving'] . '</span>' . "</p>";
                echo "<p class='d-inline-block engraving_t'>" . $lang['Engraving position: '] . '<span>' . $value['position_eng'] . '</span>' . "</p>";
              }
              echo "</div>";
          } ?>
            
            <p class="product-size"><?php echo $lang['Size'] . ': ' . $value['product_size']; ?></p>
            <div class="acts">
              <a class="osh-btn -link js-remove confirm" href="cart.php?action=delete&productid=<?php echo $value['p_id']; ?>">
                <i class="fas fa-trash"></i>
                <span class="label"><?php echo $lang['delete']; ?></span>
              </a>
            </div>
          </div>

           <!-- product id -->
          <input type="hidden" value="<?php echo $value['p_id']; ?>" name="product_id">
          <div class="quantity">
            <div class="osh-dropdown -select-box ft-product-quantity -default">
              <div class="quantity quan-ca">
                <?php echo '<p><span>' . $value['p_quantity'] . ' </span>' . $lang['Piece'] . '</p>'; ?>
              </div>
            </div>
          </div><!-- .quantity -->

          <div class="unit-price ft-product-unit-price">
            <div class="content_all">
            <span class="current">
              <span class="product-price"><?php echo ($value['p_price'] - $value['discount']) . 'Kwt'; ?></span>
              <input name="price" type="hidden" value="<?php echo $value['p_price']; ?>">
            </span>
            <span class="old -mtm">
              <span>
                <?php 
                  if (!empty($value['discount'])) {
                    echo $value['p_price']  . 'Kwt';
                  } ?>
              </span>
            </span>
            <span class="save"><?php echo $lang['Provided:']; ?> <span> <?php echo $value['discount'] . 'Kwt'; ?></span></span>
          </div>
          </div><!-- .unit-price -->
        <?php

        $final_price = ($value['p_price'] - $value['discount']) * $value['p_quantity']; ?>
        <div class="subtotal f_price ft-product-subtotal-price">
          <span id="product-line-price" class="product-line-price"><?php echo number_format($final_price, 2)  . 'Kwt'; ?></span>
        </div>
      </div>


      <div class="for_phone">
       <div class="row">
        <div class="col-xs-6 col-sm-6 width_50">
          <div class="image-phone">
            <a href="product.php?p_id=<?php echo $value['p_id'] . '&productname=' . preg_replace('/\s/', '%', $value['p_name']) . '&action=getproductinformation'; ?>" target="_blank">
              <img class="lazy -loaded" width="60" height="60" src="<?php echo $value['p_img']; ?>" value="<?php echo $value['p_img']; ?>" alt="product img">
            </a>
            <input name="image" type="hidden" value="<?php echo $value['p_img']; ?>">
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 width_50">
          <div class="item">
            <input name="product" type="hidden" value="<?php echo $value['p_name']; ?>">
            <a href="#" class="name -mbs -inline-block ft-product-name "><?php echo $value['p_name']; ?></a>
            <p class="product-desc"><?php echo $value['p_desc']; ?></p>
            <?php 
              // Get All shape special every product
              $shapes = $con->prepare("SELECT * FROM shape WHERE p_id = ? ORDER BY shap_id DESC");
              $shapes->execute(array($value['p_id']));
              $all_shapes = $shapes->fetchAll();

              if(!empty($all_shapes)) {
                echo '<div class="engraving-content">';
                echo "<p class='d-inline-block'>" . $lang['Engraving shape: '] . "</p>"; 
                echo '<br /> <div class="shape-img-content text-center">';
                foreach($all_shapes as $shape) { ?>
                  <img src="layout/images/personalize_images/<?php echo $shape['shap_img']; ?>" alt="shape" />
          <?php 
               }
               echo "</div>";
          
               if($value['text_engraving'] != 'not_found') {
                echo "<p class='d-inline-block engraving_t'>" . $lang['Engraving text: '] . '<span>' . $value['text_engraving'] . '</span>' . "</p>";
                echo "<p class='d-inline-block engraving_t'>" . $lang['Engraving position: '] . '<span>' . $value['position_eng'] . '</span>' . "</p>";
              }
              echo "</div>";
          } ?>
            
            <p class="product-size"><?php echo $lang['Size'] . ': ' . $value['product_size']; ?></p>
            <div class="acts">
              <a class="osh-btn -link js-remove confirm" href="cart.php?action=delete&productid=<?php echo $value['p_id']; ?>">
                <i class="fas fa-trash"></i>
                <span class="label"><?php echo $lang['delete']; ?></span>
              </a>
            </div>
          </div>
        </div>

        <div class="col-12"><hr /></div>
        <!-- product id -->
        <input type="hidden" value="<?php echo $value['p_id']; ?>" name="product_id">
        <div class="col-xs-2 col-sm-2 width_25">
        <div class="head_table"><?php echo $lang['amount']; ?></div>
          <div class="quantity">
            <div class="osh-dropdown -select-box ft-product-quantity -default">
              <div class="quan-ca">
                <?php echo '<p><span>' . $value['p_quantity'] . ' </span>' . $lang['pieces'] . '</p>'; ?>
              </div>
            </div>
          </div><!-- .quantity -->
        </div>

        <div class="col-xs-5 col-sm-5 width_50">
        <div class="unit-price head_table"><?php echo $lang['The total amount']; ?></div>
          <div class="unit-price ft-product-unit-price">
            <div class="content_all">
            <span class="current">
              <span class="product-price"><?php echo ($value['p_price'] - $value['discount'])  . 'Kwt'; ?></span>
              <input name="price" type="hidden" value="<?php echo $value['p_price']; ?>">
            </span>
            <span class="old -mtm">
              <span>
                <?php 
                  if (!empty($value['discount'])) {
                    echo $value['p_price']  . 'Kwt';
                  } ?>
              </span>
            </span>
            <span class="save"><?php echo $lang['Provided:']; ?> <span> <?php echo $value['discount']  . 'Kwt'; ?></span></span>
          </div>
          </div><!-- .unit-price -->
          </div>
        <?php

        $final_price = ($value['p_price'] - $value['discount']) * $value['p_quantity']; ?>
        <div class="col-xs-5 col-sm-5 width_25">
        <div class="subtotal head_table"><?php echo $lang['final price']; ?></div>
          <div class="subtotal f_price ft-product-subtotal-price">
            <span id="product-line-price" class="product-line-price"><?php echo number_format($final_price, 2)  . 'Kwt'; ?></span>
          </div>
        </div>
       </div>
      </div>


      <input name="discount" type="hidden" value="<?php echo $value['discount']; ?>">
      <input name="final_price" type="hidden" value="<?php echo $final_price; ?>">

      <?php $total += $final_price; ?>
      <input name="total_price" type="hidden" value="<?php echo $total; ?>">

    <?php  } ?>

    <div class="btn btn-light clean-cart">
      <a href="cart.php?action=deleteall"><?php echo $lang['clean cart']; ?></a>
    </div>


    <div class="totals">
      <div class="totals-item">
        <label><?php echo $lang['Total price']; ?>:</label>
        <div class="totals-value" id="cart-subtotal"><?php echo number_format($total, 2)  . 'Kwt'; ?></div>
      </div>
    </div>

    <div class="btn-sub">
     <button type="submit" class="btn btn-brown"><?php echo $lang['follow buying']; ?></button><!-- f060 || f061 -->
    </div>

    </div>
  </form>

<?php
  exit();
}