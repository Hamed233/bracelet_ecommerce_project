<?php
include '../../config/connect-db.php';
error_reporting( ~E_NOTICE ); // avoid notice

// Update Category Image
if(isset($_POST["action"])) {
   // Img info
    $Img     = $_FILES['image'];
    $ImgName = $_FILES['image']['name'];
    $ImgSize = $_FILES['image']['size'];
    $ImgTmp  = $_FILES['image']['tmp_name'];
    $ImgType = $_FILES['image']['type'];

    // List Of Allowed File Typed To Upload
    $ImgAllowedExtention = array("jpeg", "jpg", "png", "gif");
    // Get cateImg Extention
    $ImgEtention = strtolower(end(explode('.', $ImgName)));
    $formErrors = array();
    if (! empty($ImgName) && ! in_array($ImgEtention, $ImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
    if ($ImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }

    if (empty($formErrors)) {

      if($_POST["action"] == "update"){
        $catImg = rand(0, 1000000) . '_' . $ImgName;
        move_uploaded_file($ImgTmp, "../../upload/categories_img/" . $catImg);
        $query = $con->prepare("UPDATE categories SET c_picture = '$catImg' WHERE c_id = '".$_POST["image_id"]."'");
        $query->execute();
        $row = $query->rowCount();

      if($row > 0){
        echo 'Image Updated Into Database, please reload page for show all updates!';
     }

   } elseif ($_POST["action"] == "update_product_img") {
     $productImg = rand(0, 1000000) . '_' . $ImgName;
     move_uploaded_file($ImgTmp, "../../upload/products/" . $productImg);
     $query = $con->prepare("UPDATE products SET p_picture = '$productImg' WHERE p_id = '".$_POST["image_id"]."'");
     $query->execute();
     $row = $query->rowCount();

    if($row > 0){
     echo 'Image Updated Into Database, please reload page for show all updates!';
    }
  } elseif ($_POST["action"] == "update_adm_img") {
     $admImg = rand(0, 1000000) . '_' . $ImgName;
     move_uploaded_file($ImgTmp, "../../upload/admins_avatars/" . $admImg);
     $query = $con->prepare("UPDATE admins SET adm_avatar = '$admImg' WHERE adm_id = '".$_POST["image_id"]."'");
     $query->execute();
     $row = $query->rowCount();

    if($row > 0){
     echo 'Image Updated Into Database, please reload page for show all updates!';
    }
   }
 }
}
?>
