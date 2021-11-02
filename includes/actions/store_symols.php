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
    $sessionCustomer_not_login = $_SESSION['customer_id'];
  }

if(isset($_POST['item_img'])) {
   // store information
  $img                    = $_POST['item_img'] . '.png';
  $product_id             = $_POST['product_id'];
  // Inset data
  $stmt = $con->prepare("INSERT INTO
                        shape(shap_img, p_id, cus_id)
                        VALUES(:img, :id, :cus_id)");
  $stmt->execute(array (
    'img'    => $img,
    'id'       => $product_id,
    'cus_id' => $_SESSION['customer_id']

  ));
    // Get Shapes special this id exist
    $getAll = $con->prepare("SELECT * FROM shape WHERE p_id = ? ORDER BY shap_id DESC");
    $getAll->execute(array($product_id));
    $all = $getAll->fetchAll();

        foreach ($all as $value) { ?>
          <span class="shape-content" data-shapeid="<?php echo $value['shap_id']; ?>" data-id="<?php echo $value['p_id']; ?>">
           <img alt="heart engraving symbol" src="layout/images/personalize_images/<?php echo $value['shap_img']; ?>"data-shapeid="<?php echo $value['shap_id']; ?>" data-shape="<?php echo $value['shap_img']; ?>" />
          </span>
   <?php
         }
    }

    // Delete all shapes if page reloaded
    if (isset($_POST['id_img'])) {
      $product_id = $_POST['id_img'];
      $sql = $con->prepare('DELETE FROM shape WHERE p_id = :zid');
      $sql->bindparam(":zid", $product_id);
      $sql-> execute();
    }

    // Delete for reorder shap id
    if (isset($_POST['shap_id'])) {
      $shap_id = $_POST['shap_id'];
      $sql = $con->prepare('DELETE FROM shape');
      $sql-> execute();

    }