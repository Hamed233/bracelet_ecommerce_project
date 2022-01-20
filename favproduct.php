<?php
/*
============================
== Favorite products page
============================
*/

  ob_start();
  $pageTitle ='My Favorite products';   // Page title
  include "init.php";         // initialize file
?>

<div class="bradcam_bg_2 fav_header">
    <h1 class="text-center"><?php echo $lang['My Favorite products']; ?>..<i class="fas fa-heart"></i></h1>
</div>
<div class="container text-center fav_content">
    <div class="text-center">
    <div class="row">
    <?php
      $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;
        // Select All Users Expect Admin
        $sql = $con->prepare("SELECT
                                products. *,
                                favorite_products.*
                            FROM
                                products
                            INNER JOIN
                                favorite_products
                            ON favorite_products.p_id = products.p_id
                            WHERE
                                userid = ?");
        $sql->execute(array($sessionCus));
        $products = $sql->fetchAll();

        if (!empty($products)) { 
        foreach ($products as $product) { ?>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 phone_50 text-center">
            <div class="product-content">
            <i id="<?php echo $product['p_id']; ?>_love" class="far fa-heart fa-fw" onclick="addLove(<?php echo $product['p_id']; ?>, <?php echo $sessionCus; ?>)" aria-hidden="true" data-icon="far" data-productid="<?php echo $product['p_id']; ?>"></i>
            <div class="product-img">
                <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" alt="product image" />
            </div><!-- .product-img -->
            <div class="product-name">
                <?php echo$product['p_name']; ?>
            </div><!-- .product-name -->

            <div class="product-price">
                <?php echo $product['price'] . 'Kwt'; ?>
            </div><!-- .product-price -->

            <div class="control-product">
                <a class="btn btn-brown btn-block" href="product.php?p_id=<?php echo $product['p_id'] . '&productname=' . preg_replace('/\s/', '%', $product['p_name']) . '&action=getproductinformation'; ?>" target="_blank">
                <i class="fas fa-cart-plus"></i>
                <?php echo $lang['add to cart']; ?>
                </a>
            </div><!-- .control-product -->
            <div class="save-product-num">
                <span><?php echo $lang['Available'] . ' ' .$product['available_product_num'] . ' ' . $lang['Piece']; ?></span>
            </div>
            </div><!-- product-content -->
        </div>
        <?php }
        } else { ?>
          <div class="col-12 text-center">
            <div class="empty-state">
                <i class="far fa-times-circle"></i>
                <div class="title"><?php echo $lang['Whoops']; ?>!</div>
                <div class="description">
                  <?php echo $lang['Not found any favorite products, You can browse product and add now!']; ?>
                </div>
                <div class="button-block">
                <a href="index.php" class=" btn btn-brown"><?php echo $lang['Browse Now']; ?></a>
                </div>
            </div>
            </div>
    <?php } ?>
    </div>
    </div>
</div>

<?php
    // Include Footer page
    include $temp . 'footer.php';
    ob_end_flush();
?>