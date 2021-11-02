<?php
  ob_start();
  if (isset($_POST['search'])) {
    $pageTitle = "your search: " . $_POST['search'];
  } else {
    $pageTitle = 'Search Result'; // Page Main Title
  }

  $no_ads    = '';
  include 'init.php';
  $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;

if (isset($_GET['s'])) {
  // start form information
  $search = htmlspecialchars($_GET['s'], ENT_QUOTES, 'UTF-8');

  $formError = array();
  if (empty($search)) {
    $formError[] = 'Search field is empty';
  }

  if (strlen($search) < 3) {
    $formError[] = 'Your search is very short';
  }

  if (empty($formError)) {

    $stmt = $con->prepare("SELECT * FROM products WHERE p_description LIKE '%" . $search . "%' OR p_name LIKE '%" . $search . "%'");
    $stmt->execute();
    $searchResult = $stmt->fetchAll();

  } 
?>

<div class="container" style="min-height: 100%">
  <div class="search_result">
  <h2 class="search-header"><?php if (isset($search)) { echo $lang['Your search'] . ":  [ <span> " . $search . "</span> ]"; } ?></h2>
  <div class="row">
    <?php
     if (isset($search)) {
       if(!empty($searchResult)) {
       foreach ($searchResult as $result) { ?>
         <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 phone_50">
           <div class="product-content">
           <i id="<?php echo $result['p_id']; ?>_love" class="far fa-heart fa-fw" onclick="addLove(<?php echo $result['p_id']; ?>, <?php echo $sessionCus; ?>)" aria-hidden="true" data-icon="far" data-productid="<?php echo $result['p_id']; ?>"></i>
             <div class="product-img">
               <img src="admin-dashboard/upload/products/<?php echo $result['p_picture']; ?>" alt="product image" />
             </div><!-- .product-img -->
             <div class="product-name">
               <?php echo $result['p_name']; ?>
             </div><!-- .product-name -->

             <div class="product-price">
               <?php echo $result['price'] . 'Kwt'; ?>
             </div><!-- .product-price -->

             <div class="control-product">
                <a class="btn btn-brown btn-block" href="product.php?p_id=<?php echo $result['p_id'] . '&productname=' . preg_replace('/\s/', '%', $result['p_name']) . '&action=getproductinformation'; ?>" target="_blank">
                  <i class="fas fa-cart-plus"></i>
                  <?php echo $lang['add to cart']; ?>
                </a>
              </div><!-- .control-product -->
             <div class="save-product-num">
                <span><?php echo $lang['Available'] . ' ' .$result['available_product_num'] . ' ' . $lang['Piece']; ?></span>
              </div>
           </div><!-- product-content -->
         </div>
<?php }
} else { ?>
    <div class="container">
     <div class="col-12 text-center">
        <div class="empty-state">
            <i class="far fa-times-circle"></i>
            <div class="title"><?php echo $lang['Whoops']; ?>!</div>
            <div class="description">
              <?php echo $lang['Not Found Any products Like you write!']; ?>
            </div>
        </div>
      </div>
      <hr />
     <div class="more-product-same">
     <h4><?php echo $lang['More items you like']; ?></h4>
      <div class="row">
       <?php
         $sql = $con->prepare("SELECT * FROM products WHERE product_status = 1 ORDER BY p_id ASC");
         $sql->execute();
         $allProducts = $sql->fetchAll();

         foreach ($allProducts as $product) { ?>
           <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 phone_50">
             <div class="product-content">
               <i id="<?php echo $product['p_id']; ?>_love" class="far fa-heart fa-fw" onclick="addLove(<?php echo $product['p_id']; ?>, <?php echo $sessionCus; ?>)" aria-hidden="true" data-icon="far" data-productid="<?php echo $product['p_id']; ?>"></i>
               <div class="product-img">
                 <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" alt="product image" />
               </div><!-- .product-img -->
               <div class="product-name">
                 <?php echo $product['p_name']; ?>
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
      <?php } ?>
    </div><!-- .row -->
  </div>
</div>
<?php }
     }
    ?>

   </div><!-- .row -->
  </div><!-- .search_result -->
</div><!-- .container -->

<?php } else {
  header('Location: index.php');
  exit();
} ?>

  <?php
     include $temp . 'footer.php'; // Footer template
     ob_end_flush(); // Release The Output
  ?>
