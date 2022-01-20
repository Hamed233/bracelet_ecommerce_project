<?php
  session_start();
  include '../../config/connectDB.php'; // connect To DB
  $lang = '../../includes/langs/';
  include '../../config/config_lang.php';  // Configration languages

  // check if isset session customer
  $sessionCustomer = '';
  if (isset($_SESSION['customer_id'])) {
    $sessionCustomer = $_SESSION['customer_id'];
  } else {
    if(!isset($_SESSION['customer_id'])) {
      $_SESSION['customer_id'] = rand(10, 100000);
    }
    $_SESSION['cart'] = 0;
  }

  $sessionCustomer_not_login = $_SESSION['customer_id'];

if(isset($_POST["action_product"])){

 $catid = $_POST['catid'];
 $query = "SELECT * FROM products WHERE product_status = '1' AND categoryID = '$catid'";

 if(isset($_POST["status_product"])){
  $status_product = implode("','", $_POST["status_product"]);
  $query .= "AND status_material IN('".$status_product."')";
 }

 if(isset($_POST["country_made"])){
  $country_made = implode("','", $_POST["country_made"]);
  $query .= "AND country_made IN('".$country_made."')";
 }

 $sort = 'ASC';
 $sort_array = array('ASC', 'DESC');
 if (isset($_POST['sort']) && in_array($_POST['sort'], $sort_array)) {
    $sort = $_POST["sort"];
    $query .= " ORDER BY p_id '$sort'";
 }

 $statement = $con->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();

 $output = '';

 $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;

 if($total_row > 0){
  foreach($result as $product){
  $output .= '
   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 phone_50">
     <div class="product-content product-cats">
      <i id="' . $product['p_id'] . '_love" class="far fa-heart fa-fw" onclick="addLove(' . $product['p_id'] . ',' . $sessionCus . ')" aria-hidden="true" data-icon="far" data-productid="' . $product['p_id'] .'"></i>
       <div class="product-img">
         <img src="admin-dashboard/upload/products/' . $product['p_picture'] . '" alt="product image" />
       </div><!-- .product-img -->
       <a class="" href="product.php?productname=' . preg_replace('/\s+|&/', '%', $product['p_name']) . '&p_id=' . $product['p_id'] . '&action=getproductinformation' . '"  target="_blank">
        <div class="product-name">' . $product['p_name'] . '</div>

        <div class="product-price">' . 'Kwt' . $product['price'] . '</div>

        <div class="control-product btn btn-brown btn-block">
            <i class="fas fa-cart-plus"></i>
            ' . $lang['add to cart'] . '
        </div><!-- .control-product -->
       </a>
       <div class="save-product-num">
         <span>' . $lang['Save products'] . ' ' . $product['available_product_num'] . ' </span>
       </div>
     </div><!-- product-content -->
   </div>
   ';

  }
 } else {
  $output = '
  <div class="col-12 text-center">
  <div class="empty-state">
    <i class="far fa-times-circle"></i>
    <div class="title">' . $lang['Whoops'] . '!</div>
    <div class="description">
      ' . $lang['We couldn’t find the products you’re looking for'] . '
    </div>
  </div>
  </div>
  ';
 }

 echo $output;
  } ?>

