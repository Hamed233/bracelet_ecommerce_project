<?php

/*
===============================
   order Page
===============================
*/

ob_start(); // OutPut Buffering Start
$head_dis = ''; // for disable main navbar
$lang = 'includes/langs/'; // for languages
include 'config/config_lang.php'; // configration languages
if ($_GET['do'] == 'done') {
  $pageTitle = $lang['Done, your order is send!']; // main page title
} elseif ($_GET['do'] == 'my_orders') {
  $pageTitle = $lang['My orders'];
} elseif ($_GET['do'] == 'check') {
  $pageTitle = $lang['Follow buying'];
} elseif ($_GET['do'] == 'order_content') {
  $pageTitle = $lang['order_content'] . ' ' . $_GET['ordernum']; // main page title
}
include 'init.php'; // initialize files

 $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;

// make inside pages
$do = isset($_GET['do']) ? ($_GET['do']) : 'not-allow';

if ($do == 'not-allowd') {
  header('Location: index.php');
  exit();
} elseif ($do == 'check') {

  // form information

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_info_order'])) {

      // personal information for order
      $f_name                    = test_input($_POST['f_name']);
      $s_name                    = test_input($_POST['s_name']);
      $country_key               = test_input($_POST['country_key']);
      $phone                     = test_input($_POST['phone']);
      $whats                     = test_input($_POST['whats']);
      if(isset($_SESSION['cus_id'])) {
        $cus_id = $_SESSION['cus_id'];
      } else {
        $cus_id = $_SESSION['customer_id'];
      }
      // place recieve
      $area_address              = test_input($_POST['area_address']);
      $adress_2                  = test_input($_POST['adress_2']);
      $additional_information    = test_input($_POST['additional_information']);
      $cus_area                  = test_input($_POST['your_area']);
      // payment method
      $way_pay        = test_input($_POST['way_pay']);

      // every product info
      $order_id       = rand(200, 292002922);

      // Order info
      $total_price    = $_POST['total_price'];
      $orderNum       = rand(0, 10239048);

      // validate form
      $formErr = array();

      if ((isset($f_name) || isset($s_name))) {
        $filter_username = filter_var($f_name, FILTER_SANITIZE_STRING);
        if ($filter_username != true) {
          $formErr[] = "<div class='alert alert-danger'>This name [" . $f_name . "] Or [" . $s_name . "] Invalid. </div>";
        }

        if ((empty($f_name) || empty($s_name))) {
          $formErr[] = "<div class='alert alert-danger'>Full name is required.</div>";
        }

        if (!(preg_match("/^[a-zA-Z ]*$/", $f_name) || preg_match("/^[a-zA-Z ]*$/", $s_name))) {
          $formErr[] = "<div class='alert alert-danger'>Only letters and white space allowed in <b>Full name</b> input</div>";
        }
      }

      if ((isset($phone) || isset($whats))) {
        if (validate_phone_number($phone) !== true) {
          $formErr[] = "<div class='alert alert-danger'>" . $phone . 'Invalid phone number.' . "</div>";
        } elseif(validate_phone_number($whats) !== true) {
          $formErr[] = "<div class='alert alert-danger'>" . $whats . 'Invalid What\'s App number.' . "</div>";
        }

        if ((empty($phone) || empty($whats))) {
          $formErr[] = "<div class='alert alert-danger'>Phone & What\'s App is required.</div>";
        }
      }

        if (empty($area_address)) {
          $formErr[] = "<div class='alert alert-danger'>Area address is required.</div>";
        }

        if (strlen($adress_2) < 5) {
          $formErr[] = "<div class='alert alert-danger'>Address_1 or Address_2 is very short.</div>";
        }

        if (strlen($adress_2) > 35) {
          $formErr[] = "<div class='alert alert-danger'>Address_1 or Address_2 is very long.</div>";
        }

        if ($cus_area == '0') {
          $formErr[] = "<div class='alert alert-danger'>Your Area is required.</div>";
        }


      if (empty($formErr)) {

        $stmt2 = $con->prepare("INSERT INTO orders(customerID, ord_number, payment_type, f_name, s_name, country_key, cus_phone_number, cus_whats_number, area_address, s_address, additional_information, custmer_area, ord_total_price, ord_date)
                                 VALUES(:cusid, :ordnum, :paytype, :f_nam, :s_nam, :coun_key, :phone, :phonewhat, :area_add, :caddress_2, :add_info, :cusarea, :ord_price, now())");
        $stmt2->execute(array(
          'cusid'        => $cus_id,
          'ordnum'       => $orderNum,
          'paytype'      => $way_pay,
          'f_nam'        => $f_name,
          's_nam'        => $s_name,
          'coun_key'     => $country_key,
          'phone'        => $phone,
          'phonewhat'    => $whats,
          'area_add'     => $area_address,
          'caddress_2'   => $adress_2,
          'add_info'     => $additional_information,
          'cusarea'      => $cus_area,
          'ord_price'    => $total_price
        ));


        $count = COUNT($_POST['product_id']);
        for ($i = 0; $i < $count; $i++) {

          // product info
          $product_id     = $_POST['product_id'][$i];
          $p_name         = $_POST['p_name'][$i];
          $size           = $_POST['bracelet_size'][$i];
          $bracelet_kind  = $_POST['bracelet_kind'][$i];
          $color          = $_POST['color'][$i];
          $p_f_price      = $_POST['p_f_price'][$i];
          $quantity       = $_POST['quantity'][$i];
          $text_engraving       = $_POST['text_engraving'][$i];
          $position_eng   = $_POST['position_eng'][$i];

          $stmt3 = $con->prepare("INSERT INTO orderdetails(productID, customerID, p_name, ord_number, ord_quantity, size, product_color, bracelet_type, product_f_price, order_id, text_engraving, position_txt_eng)
                                 VALUES(:productid, :cusid, :pname, :ordnum, :ordquan, :psize, :pcolor,:type_bracelet, :f_price, :ordid, :txt_eng, :pos_eng)");
          $stmt3->execute(array(
            'productid'    => $product_id,
            'cusid'        => $cus_id,
            'pname'        => $p_name,
            'ordnum'       => $orderNum,
            'ordquan'      => $quantity,
            'psize'        => $size,
            'pcolor'       => $color,
            'type_bracelet' => $bracelet_kind,
            'f_price'      => $p_f_price,
            'ordid'        => $order_id,
            'txt_eng'      => $text_engraving,
            'pos_eng'      => $position_eng
          ));

          // update product [orders_numbers]

          $stmt4 = $con->prepare("UPDATE products SET orders_number = orders_number + 1 WHERE p_id = ?");
          $stmt4->execute(array($product_id));
        }



        // clean cart
        $stmt5 = $con->prepare("DELETE FROM store_cart_item");
        $stmt5->execute();

        header('Location: ?do=done');
        exit();
      } else {
        foreach ($formErr as $err) {
          echo "<b>" . $err . '</b>';
        }
      }
    } //

  } else {
    header('Location: index.php');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {  ?>

<div class="order-navbar">
    <div class="nav-b"><a class="navbar-brand" href="index.php"><img src="<?php echo $img; ?>logo_d.png" alt="Logo"></a>
    </div>
    <div class="section-header">
        <div class="safe-pay"><span><?php echo $lang['safe payment']; ?></span></div>
        <div class="return-easy"><span><?php echo $lang['Easy return of products']; ?></span></div>
    </div>
</div>
<div class="container order-content">
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8 f_sec_ord">
            <form action="?do=check" method="POST">
                <?php

            $cus_id = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;

             // get All orders in cart special customer
            $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id ASC");
            $getAll->execute(array($cus_id));
            $all = $getAll->fetchAll();

            // order details
            foreach ($all as $value) {
              echo '<input type="hidden" name="quantity[]" value="' . $value['p_quantity'] . '">';
              echo '<input type="hidden" name="product_id[]" value="' . $value['p_id'] . '">';
              echo '<input type="hidden" name="p_name[]" value="' . $value['p_name'] . '">';
              echo '<input type="hidden" name="color[]" value="' . $value['color'] . '">';
              echo '<input type="hidden" name="p_f_price[]" value="' . $value['p_price'] * $value['p_quantity'] . '">';
              echo '<input type="hidden" name="bracelet_kind[]" value="' . $value['kind'] . '">';
              echo '<input type="hidden" name="text_engraving[]" value="' . $value['text_engraving'] . '">';
              echo '<input type="hidden" name="position_eng[]" value="' . $value['position_eng'] . '">';
              echo '<input type="hidden" name="bracelet_size[]" value="' . $value['product_size'] . '">';
            }
            ?>
                <input type="hidden" name="total_price" value="<?php echo $_POST['total_price']; ?>">
                <!-- start customer details  -->
                <div class="section-first section-g">
                    <h3 class="following-buy-head"><?php echo $lang['Delivery information']; ?></h3>
                    <div class="data-client">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control pay_s_1_input" name="f_name"
                                    value="<?php echo isset($_POST['f_name']) ? $_POST['f_name'] : ''; ?>" id="name"
                                    placeholder="<?php echo $lang['f_name']; ?>" minlength="3" maxlength="20" required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control pay_s_1_input" name="s_name"
                                    value="<?php echo isset($_POST['f_name']) ? $_POST['f_name'] : ''; ?>" id="name"
                                    placeholder="<?php echo $lang['s_name']; ?>" minlength="3" maxlength="20" required>
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control pay_s_1_input" id="country_key" name="country_key">
                                    <option value="+974">+974</option>
                                    <option value="+966">+966</option>
                                    <option value="+212">+212</option>
                                    <option value="+971">+971</option>
                                    <option value="+973">+973</option>
                                    <option value="+968">+968</option>
                                    <option value="+965">+965</option>
                                    <option value="+962">+962</option>
                                    <option value="+20">+20</option>
                                    <option value="+213">+213</option>
                                    <option value="+961">+961</option>
                                    <option value="+218">+218</option>
                                    <option value="+269">+269</option>
                                    <option value="+222">+222</option>
                                    <option value="+">+253</option>
                                    <option value="+252">+252</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="tel" class="form-control" name="phone"
                                    value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" id="phone"
                                    placeholder="<?php echo $lang['Phone number']; ?>" maxlength="13" required>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="tel" class="form-control" name="whats"
                                    value="<?php echo isset($_POST['whats']) ? $_POST['whats'] : ''; ?>" id="whats"
                                    placeholder="<?php echo $lang['What\'s App']; ?>" maxlength="13" required>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="sec-content">
                        <div class="sec-one">
                            <h3><?php echo $lang['Delivery Address']; ?></h3>
                            <div class="data-client">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" name="area_address"
                                            value="<?php echo isset($_POST['area_address']) ? $_POST['area_address'] : ''; ?>"
                                            id="area_address" placeholder="<?php echo $lang['Area address']; ?>"
                                            minlength="10" maxlength="40" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" name="adress_2"
                                            value="<?php echo isset($_POST['adress_2']) ? $_POST['adress_2'] : ''; ?>"
                                            id="inputAddress2"
                                            placeholder="<?php echo $lang['Apartment, studio, or floor']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" name="additional_information"
                                            value="<?php echo isset($_POST['additional_information']) ? $_POST['additional_information'] : ''; ?>"
                                            id="additional_information"
                                            placeholder="<?php echo $lang['additional information']; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select class="form-control" id="your_area" name="your_area">
                                            <option value="0"><?php echo $lang['your_area']; ?></option>
                                            <option value="<?php echo $lang['area1']; ?>"><?php echo $lang['area1']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area2']; ?>"><?php echo $lang['area2']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area3']; ?>"><?php echo $lang['area3']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area4']; ?>"><?php echo $lang['area4']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area5']; ?>"><?php echo $lang['area5']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area6']; ?>"><?php echo $lang['area6']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area7']; ?>"><?php echo $lang['area7']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area8']; ?>"><?php echo $lang['area8']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area9']; ?>"><?php echo $lang['area9']; ?>
                                            </option>
                                            <option value="<?php echo $lang['area10']; ?>">
                                                <?php echo $lang['area10']; ?></option>
                                            <option value="<?php echo $lang['area11']; ?>">
                                                <?php echo $lang['area11']; ?></option>
                                            <option value="<?php echo $lang['area12']; ?>">
                                                <?php echo $lang['area12']; ?></option>
                                            <option value="<?php echo $lang['area13']; ?>">
                                                <?php echo $lang['area13']; ?></option>
                                            <option value="<?php echo $lang['area14']; ?>">
                                                <?php echo $lang['area14']; ?></option>
                                            <option value="<?php echo $lang['area15']; ?>">
                                                <?php echo $lang['area15']; ?></option>
                                            <option value="<?php echo $lang['area16']; ?>">
                                                <?php echo $lang['area16']; ?></option>
                                            <option value="<?php echo $lang['area17']; ?>">
                                                <?php echo $lang['area17']; ?></option>
                                            <option value="<?php echo $lang['area18']; ?>">
                                                <?php echo $lang['area18']; ?></option>
                                            <option value="<?php echo $lang['area19']; ?>">
                                                <?php echo $lang['area19']; ?></option>
                                            <option value="<?php echo $lang['area20']; ?>">
                                                <?php echo $lang['area20']; ?></option>
                                            <option value="<?php echo $lang['area21']; ?>">
                                                <?php echo $lang['area21']; ?></option>
                                            <option value="<?php echo $lang['area22']; ?>">
                                                <?php echo $lang['area22']; ?></option>
                                            <option value="<?php echo $lang['area23']; ?>">
                                                <?php echo $lang['area23']; ?></option>
                                            <option value="<?php echo $lang['area24']; ?>">
                                                <?php echo $lang['area24']; ?></option>
                                            <option value="<?php echo $lang['area25']; ?>">
                                                <?php echo $lang['area25']; ?></option>
                                            <option value="<?php echo $lang['area26']; ?>">
                                                <?php echo $lang['area26']; ?></option>
                                            <option value="<?php echo $lang['area27']; ?>">
                                                <?php echo $lang['area27']; ?></option>
                                            <option value="<?php echo $lang['area28']; ?>">
                                                <?php echo $lang['area28']; ?></option>
                                            <option value="<?php echo $lang['area29']; ?>">
                                                <?php echo $lang['area29']; ?></option>
                                            <option value="<?php echo $lang['area30']; ?>">
                                                <?php echo $lang['area30']; ?></option>
                                            <option value="<?php echo $lang['area31']; ?>">
                                                <?php echo $lang['area31']; ?></option>
                                            <option value="<?php echo $lang['area32']; ?>">
                                                <?php echo $lang['area32']; ?></option>
                                            <option value="<?php echo $lang['area33']; ?>">
                                                <?php echo $lang['area33']; ?></option>
                                            <option value="<?php echo $lang['area34']; ?>">
                                                <?php echo $lang['area34']; ?></option>
                                            <option value="<?php echo $lang['area35']; ?>">
                                                <?php echo $lang['area35']; ?></option>
                                            <option value="<?php echo $lang['area36']; ?>">
                                                <?php echo $lang['area36']; ?></option>
                                            <option value="<?php echo $lang['area37']; ?>">
                                                <?php echo $lang['area37']; ?></option>
                                            <option value="<?php echo $lang['area38']; ?>">
                                                <?php echo $lang['area38']; ?></option>
                                            <option value="<?php echo $lang['area39']; ?>">
                                                <?php echo $lang['area39']; ?></option>
                                            <option value="<?php echo $lang['area40']; ?>">
                                                <?php echo $lang['area40']; ?></option>
                                            <option value="<?php echo $lang['area41']; ?>">
                                                <?php echo $lang['area41']; ?></option>
                                            <option value="<?php echo $lang['area42']; ?>">
                                                <?php echo $lang['area42']; ?></option>
                                            <option value="<?php echo $lang['area43']; ?>">
                                                <?php echo $lang['area43']; ?></option>
                                            <option value="<?php echo $lang['area44']; ?>">
                                                <?php echo $lang['area44']; ?></option>
                                            <option value="<?php echo $lang['area45']; ?>">
                                                <?php echo $lang['area45']; ?></option>
                                            <option value="<?php echo $lang['area46']; ?>">
                                                <?php echo $lang['area46']; ?></option>
                                            <option value="<?php echo $lang['area47']; ?>">
                                                <?php echo $lang['area47']; ?></option>
                                            <option value="<?php echo $lang['area48']; ?>">
                                                <?php echo $lang['area48']; ?></option>
                                            <option value="<?php echo $lang['area49']; ?>">
                                                <?php echo $lang['area49']; ?></option>
                                            <option value="<?php echo $lang['area50']; ?>">
                                                <?php echo $lang['area50']; ?></option>
                                            <option value="<?php echo $lang['area51']; ?>">
                                                <?php echo $lang['area51']; ?></option>
                                            <option value="<?php echo $lang['area52']; ?>">
                                                <?php echo $lang['area52']; ?></option>
                                            <option value="<?php echo $lang['area53']; ?>">
                                                <?php echo $lang['area53']; ?></option>
                                            <option value="<?php echo $lang['area54']; ?>">
                                                <?php echo $lang['area54']; ?></option>
                                            <option value="<?php echo $lang['area55']; ?>">
                                                <?php echo $lang['area55']; ?></option>
                                            <option value="<?php echo $lang['area56']; ?>">
                                                <?php echo $lang['area56']; ?></option>
                                            <option value="<?php echo $lang['area57']; ?>">
                                                <?php echo $lang['area57']; ?></option>
                                            <option value="<?php echo $lang['area58']; ?>">
                                                <?php echo $lang['area58']; ?></option>
                                            <option value="<?php echo $lang['area59']; ?>">
                                                <?php echo $lang['area59']; ?></option>
                                            <option value="<?php echo $lang['area60']; ?>">
                                                <?php echo $lang['area60']; ?></option>
                                            <option value="<?php echo $lang['area61']; ?>">
                                                <?php echo $lang['area61']; ?></option>
                                            <option value="<?php echo $lang['area62']; ?>">
                                                <?php echo $lang['area62']; ?></option>
                                            <option value="<?php echo $lang['area63']; ?>">
                                                <?php echo $lang['area63']; ?></option>
                                            <option value="<?php echo $lang['area64']; ?>">
                                                <?php echo $lang['area64']; ?></option>
                                            <option value="<?php echo $lang['area65']; ?>">
                                                <?php echo $lang['area65']; ?></option>
                                            <option value="<?php echo $lang['area66']; ?>">
                                                <?php echo $lang['area66']; ?></option>
                                            <option value="<?php echo $lang['area67']; ?>">
                                                <?php echo $lang['area67']; ?></option>
                                            <option value="<?php echo $lang['area68']; ?>">
                                                <?php echo $lang['area68']; ?></option>
                                            <option value="<?php echo $lang['area69']; ?>">
                                                <?php echo $lang['area69']; ?></option>
                                            <option value="<?php echo $lang['area70']; ?>">
                                                <?php echo $lang['area70']; ?></option>
                                            <option value="<?php echo $lang['area71']; ?>">
                                                <?php echo $lang['area71']; ?></option>
                                            <option value="<?php echo $lang['area72']; ?>">
                                                <?php echo $lang['area72']; ?></option>
                                            <option value="<?php echo $lang['area73']; ?>">
                                                <?php echo $lang['area73']; ?></option>
                                            <option value="<?php echo $lang['area74']; ?>">
                                                <?php echo $lang['area74']; ?></option>
                                            <option value="<?php echo $lang['area75']; ?>">
                                                <?php echo $lang['area75']; ?></option>
                                            <option value="<?php echo $lang['area76']; ?>">
                                                <?php echo $lang['area76']; ?></option>
                                            <option value="<?php echo $lang['area77']; ?>">
                                                <?php echo $lang['area77']; ?></option>
                                            <option value="<?php echo $lang['area78']; ?>">
                                                <?php echo $lang['area78']; ?></option>
                                            <option value="<?php echo $lang['area79']; ?>">
                                                <?php echo $lang['area79']; ?></option>
                                            <option value="<?php echo $lang['area80']; ?>">
                                                <?php echo $lang['area80']; ?></option>
                                            <option value="<?php echo $lang['area81']; ?>">
                                                <?php echo $lang['area81']; ?></option>
                                            <option value="<?php echo $lang['area82']; ?>">
                                                <?php echo $lang['area82']; ?></option>
                                            <option value="<?php echo $lang['area83']; ?>">
                                                <?php echo $lang['area83']; ?></option>
                                            <option value="<?php echo $lang['area84']; ?>">
                                                <?php echo $lang['area84']; ?></option>
                                            <option value="<?php echo $lang['area85']; ?>">
                                                <?php echo $lang['area85']; ?></option>
                                            <option value="<?php echo $lang['area86']; ?>">
                                                <?php echo $lang['area86']; ?></option>
                                            <option value="<?php echo $lang['area87']; ?>">
                                                <?php echo $lang['area87']; ?></option>
                                            <option value="<?php echo $lang['area88']; ?>">
                                                <?php echo $lang['area88']; ?></option>
                                            <option value="<?php echo $lang['area89']; ?>">
                                                <?php echo $lang['area89']; ?></option>
                                            <option value="<?php echo $lang['area90']; ?>">
                                                <?php echo $lang['area90']; ?></option>
                                            <option value="<?php echo $lang['area91']; ?>">
                                                <?php echo $lang['area91']; ?></option>
                                            <option value="<?php echo $lang['area92']; ?>">
                                                <?php echo $lang['area92']; ?></option>
                                            <option value="<?php echo $lang['area93']; ?>">
                                                <?php echo $lang['area93']; ?></option>
                                            <option value="<?php echo $lang['area94']; ?>">
                                                <?php echo $lang['area94']; ?></option>
                                            <option value="<?php echo $lang['area95']; ?>">
                                                <?php echo $lang['area95']; ?></option>
                                            <option value="<?php echo $lang['area96']; ?>">
                                                <?php echo $lang['area96']; ?></option>
                                            <option value="<?php echo $lang['area97']; ?>">
                                                <?php echo $lang['area97']; ?></option>
                                            <option value="<?php echo $lang['area98']; ?>">
                                                <?php echo $lang['area98']; ?></option>
                                            <option value="<?php echo $lang['area99']; ?>">
                                                <?php echo $lang['area99']; ?></option>
                                            <option value="<?php echo $lang['area100']; ?>">
                                                <?php echo $lang['area100']; ?></option>
                                            <option value="<?php echo $lang['area101']; ?>">
                                                <?php echo $lang['area101']; ?></option>
                                            <option value="<?php echo $lang['area102']; ?>">
                                                <?php echo $lang['area102']; ?></option>
                                            <option value="<?php echo $lang['area103']; ?>">
                                                <?php echo $lang['area103']; ?></option>
                                            <option value="<?php echo $lang['area104']; ?>">
                                                <?php echo $lang['area104']; ?></option>
                                            <option value="<?php echo $lang['area105']; ?>">
                                                <?php echo $lang['area105']; ?></option>
                                            <option value="<?php echo $lang['area106']; ?>">
                                                <?php echo $lang['area106']; ?></option>
                                            <option value="<?php echo $lang['area107']; ?>">
                                                <?php echo $lang['area107']; ?></option>
                                            <option value="<?php echo $lang['area108']; ?>">
                                                <?php echo $lang['area108']; ?></option>
                                            <option value="<?php echo $lang['area109']; ?>">
                                                <?php echo $lang['area109']; ?></option>
                                            <option value="<?php echo $lang['area110']; ?>">
                                                <?php echo $lang['area110']; ?></option>
                                            <option value="<?php echo $lang['area111']; ?>">
                                                <?php echo $lang['area111']; ?></option>
                                            <option value="<?php echo $lang['area112']; ?>">
                                                <?php echo $lang['area112']; ?></option>
                                            <option value="<?php echo $lang['area113']; ?>">
                                                <?php echo $lang['area113']; ?></option>
                                            <option value="<?php echo $lang['area114']; ?>">
                                                <?php echo $lang['area114']; ?></option>
                                            <option value="<?php echo $lang['area115']; ?>">
                                                <?php echo $lang['area115']; ?></option>
                                            <option value="<?php echo $lang['area116']; ?>">
                                                <?php echo $lang['area116']; ?></option>
                                            <option value="<?php echo $lang['area117']; ?>">
                                                <?php echo $lang['area117']; ?></option>
                                            <option value="<?php echo $lang['area118']; ?>">
                                                <?php echo $lang['area118']; ?></option>
                                            <option value="<?php echo $lang['area119']; ?>">
                                                <?php echo $lang['area119']; ?></option>
                                            <option value="<?php echo $lang['area120']; ?>">
                                                <?php echo $lang['area120']; ?></option>
                                            <option value="<?php echo $lang['area121']; ?>">
                                                <?php echo $lang['area121']; ?></option>
                                            <option value="<?php echo $lang['area122']; ?>">
                                                <?php echo $lang['area122']; ?></option>
                                            <option value="<?php echo $lang['area123']; ?>">
                                                <?php echo $lang['area123']; ?></option>
                                            <option value="<?php echo $lang['area124']; ?>">
                                                <?php echo $lang['area124']; ?></option>
                                            <option value="<?php echo $lang['area125']; ?>">
                                                <?php echo $lang['area125']; ?></option>
                                            <option value="<?php echo $lang['area126']; ?>">
                                                <?php echo $lang['area126']; ?></option>
                                            <option value="<?php echo $lang['area127']; ?>">
                                                <?php echo $lang['area127']; ?></option>
                                            <option value="<?php echo $lang['area128']; ?>">
                                                <?php echo $lang['area128']; ?></option>
                                            <option value="<?php echo $lang['area129']; ?>">
                                                <?php echo $lang['area129']; ?></option>
                                            <option value="<?php echo $lang['area130']; ?>">
                                                <?php echo $lang['area130']; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h5><?php echo $lang['How would you like to pay for your order?']; ?></h5>
                            <div class="way-3 way-g">
                                <input id="by_hand" class="form-check-input pay_t" value="money on recieve" type="radio"
                                    name="way_pay" checked>
                                <img src="layout/images/buy-hand.png" alt="buy">
                                <span class="way-name"><?php echo $lang['Cash on delivery']; ?></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="some-notes">
                    <h4><i class="fas fa-star-of-life"></i> <?php echo $lang['Public conditions']; ?></h4>
                    <ul>
                        <li><?php echo $lang['It is not possible to edit on engraving.']; ?></li>
                        <li><?php echo $lang['Please check the size of the leather bracelet.']; ?></li>
                        <li><?php echo $lang['You can return or exchange the bracelet if it is not used or engraved within 14 days from the date of the invoice, and your money is returned 100%.']; ?>
                        </li>
                    </ul>
                    <div class="content-agree">
                      <input type="checkbox" value="agree" name="i_agree" id="agreeing" /> <?php echo $lang['I agree']; ?>
                    </div>
                </div>

                <div class="cartStepNavigation">
                    <div class="row no-gutters">
                        <div class="col-4">
                            <button class="backStep btn-lg btn btn-treatycheckout btn-treatylite btn-block lite">
                                <span><?php echo $lang['Back']; ?></span>
                            </button>
                        </div>
                        <div class="col-8 padd-trick">
                            <button class="nextStep nextStep_disabled btn-lg btn btn-treatydark btn-treatycheckout btn-block lite"
                                type="submit" name="submit_info_order" disabled>
                                <span><?php echo $lang['Delivery']; ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="formErr text-center" style="margin: 20px 0;">
                <?php
            if (isset($formErr)) {
              foreach ($formErr as $err) {
                echo "<b>" . $err . '</b>';
              }
            }
            ?>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="order-summery section-g">
                <div class="cartStepHeader">
                    <h4>
                        <?php
                $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$cus_id}");
                echo $lang['Summary your request'] . ' (<span class="brown"> ' . $cou_cart . ' </span>' . $lang['Products'] . ' )';
                ?>
                    </h4>
                </div>

                <?php
            $getAll = $con->prepare("SELECT * FROM store_cart_item WHERE customer_id = ? ORDER BY p_c_id ASC");
            $getAll->execute(array($cus_id));
            $all = $getAll->fetchAll();
            ?>


                <div class="product-or-content">
                    <div class="row">
                        <?php
                foreach ($all as $product) { ?>
                        <div class="col-4">
                            <img src="<?php echo $product['p_img']; ?>" alt="<?php echo $product['p_name']; ?>" />
                        </div>

                        <div class="col-8">
                            <div class="product-or-name"><?php echo $product['p_name']; ?></div>
                            <div class="product-or-price d-inline-block">
                                <?php echo ($product['p_price'] - $product['discount'])  . 'Kwt'; ?>
                            </div>
                            <div class="product-or-price d-inline-block float-right">
                             <?php echo '<span class="brown">' . $product['p_quantity'] . ' </span>' . $lang['pieces']; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="mon-info">
                    <?php $total = $_POST['total_price']; ?>
                    <p><?php echo $lang['Total price']; ?>: </p>
                    <span><?php echo number_format($total, 2) . 'Kwt'; ?></span>
                </div>
            </div><!-- .summery-order -->
        </div>
    </div><!-- .row -->
</div><!-- .container -->

<?php
  } else {
    header('Location: index.php');
    exit();
  } ?>


<?php  } elseif ($do == 'done') {

          if(isset($_SESSION['cus_id'])) {
            $cus_id = $_SESSION['cus_id'];
          } else {
            $cus_id = $_SESSION['customer_id'];
          }

          // get info order
          $stmt_1 = $con->prepare("SELECT * FROM orders WHERE customerID = ?");
          $stmt_1->execute(array($cus_id));
          $order = $stmt_1->fetch();
          // get info order_details
          $stmt_2 = $con->prepare("SELECT * FROM orderdetails WHERE ord_number = ?");
          $stmt_2->execute(array($order['ord_number']));
          $order_details = $stmt_2->fetch();
          // get product information.
          $stmt_3 = $con->prepare("SELECT * FROM products WHERE p_id = ?");
          $stmt_3->execute(array($order_details['productID']));
          $product_details = $stmt_3->fetchAll();
          // get customer info.
          $stmt_4 = $con->prepare("SELECT * FROM customers WHERE cus_id = ?");
          $stmt_4->execute(array($cus_id));
          $customer = $stmt_4->fetch();

        ?>

        <!-- card done page -->
        <div class="order-navbar">
            <div class="nav-b"><a class="navbar-brand" href="index.php"><img src="<?php echo $img; ?>logo_d.png" alt="Logo"></a>
            </div>
            <div class="section-header">
                <div class="safe-pay"><span><?php echo $lang['Done, your order is send!']; ?></span></div>
                <div class="return-easy"><span><?php echo $lang['You can only return the product after two weeks']; ?></span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card-done">
                <h2 class="done-head text-center"><?php echo $lang['Done, your order is send!']; ?></h2>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center"><i class="fas fa-check-circle"></i></div>
                        <div class="alert_cus">
                            <div>
                                <?php 
                        if(isset($_SESSION['customer'])) {
                          $cus_name = $_SESSION['customer'];
                        } else {
                          $cus_name = $_SESSION['customer_id'];
                        }
                      echo $lang['Hi'] . '<b> ' . $cus_name . ' </b>, ' . $lang['Done, your order is send & you number order'] . ':<span class="green"><a href="order.php?do=ordernum&order_number=' . $order['ord_number'] . '">' . $order['ord_number'] . '</a>.</span>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="more-info-for-customer">
                    <?php echo $lang['You can know all orders & follow your orders']; ?>
                    <a href="order.php?do=my_orders&customerid=<?php echo $cus_id; ?>"><span
                            class="green"><b><?php echo $lang['My orders']; ?></b></span></a>
                </div>

                <a class="btn btn-secondary" href="index.php"><?php echo $lang['Back to the web site']; ?></a>
            </div>
        </div>

<?php } elseif ($do == 'my_orders') {

  if (isset($_GET['customerid'])) {

    if(isset($_SESSION['cus_id'])) {
      $cus_id = $_SESSION['cus_id'];
    } else {
      $cus_id = $_SESSION['customer_id'];
    }

    // get info order
    $stmt_1 = $con->prepare("SELECT * FROM orders WHERE customerID = ?");
    $stmt_1->execute(array($cus_id));
    $orders = $stmt_1->fetchAll(); ?>

<header class="header-area">
    <!-- Navbar Area -->
    <div class="famie-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container-fluid">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="famieNav">
                    <!-- Nav Brand -->
                    <a href="index.php" class="nav-brand"><img src="<?php echo $img; ?>logo_d.png" alt="Logo"></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>
                        <!-- Navbar Start -->
                        <div class="classynav">
                            <ul>
                                <li class="active">
                                    <a href="index.php"><?php echo $lang['Home']; ?></a>
                                </li>
                                <li>
                                <li>
                                    <a href="#"><?php echo $lang['categories']; ?></a>
                                    <ul class="dropdown">
                                        <?php
                        $cats = getAllFrom("*", "categories", "WHERE active = 0", "", "c_id");
                        foreach ($cats as $cat) { ?>
                                        <li><a
                                                href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>"><?php echo $cat['c_name']; ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                </li>
                                <li>
                                  <a class="order-link active" href="order.php?do=my_orders&customerid=<?php echo $sessionCus; ?>"><?php echo $lang['My orders']; ?></a>
                                </li>
                                <li>
                                <li class="lang-nav">
                                    <?php
                      if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == 'ar') { ?>
                                    <a href="#"><img src="layout/images/flag_kw.png"
                                            alt="arabic"><?php echo $lang['Arabic']; ?></a>
                                    <?php } elseif ($_GET['lang'] == 'en') { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php } else { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php  }
                      } else { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php } ?>
                                    <ul class="dropdown">
                                        <a href="?lang=ar"><img src="layout/images/flag_kw.png" width="34" height="24"
                                                alt="arabic"><span><?php echo $lang['Arabic']; ?></span></a>
                                        <a href="?lang=en"><img src="layout/images/USA.png" width="34" height="24"
                                                alt="english"><span><?php echo $lang['English']; ?><span></a>
                                    </ul>
                                </li>
                                </li>

                                <?php if (!isset($_SESSION['customer'])) { ?>
                                <li> <a href="login.php"><?php echo $lang['Signin']; ?></a></li>
                                <?php  } else { ?>
                                <li>
                                    <a href="#"><?php echo $_SESSION['customer']; ?></a>
                                    <ul class="dropdown">
                                        <li> <a href="logout.php">logout</a></li>
                                    </ul>
                                </li>
                                <?php  } ?>
                            </ul>

                            <!-- Search Icon -->
                            <div id="searchIcon">
                                <i class="fas fa-search"></i>
                            </div>

                            <!-- Cart Icon -->
                            <div id="cartIcon">
                                <a href="cart.php">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span id="cart-quantity" class="cart-quantity">
                                        <?php
                        if (isset($_SESSION['cart'])) {
                          $count = count($_SESSION['cart']);
                          echo $count;
                        } else {
                          echo "0";
                        } ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <!-- Navbar End -->
                    </div>
                </nav>
</header>

<?php if (isset($_SESSION['src'])) { ?>
<!-- This Alert run when product add to cart -->
<div class="cap_status">
    <?php
        if (isset($_SESSION["success_login"])) {
          vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fas fa-check-circle\"></i> %s</div>", $_SESSION["success_login"]);
          unset($_SESSION["success_login"]);
        }
        ?>
</div>
<?php } ?>


    <!-- Search Form -->
    <div class="search-form">
        <form action="result_search.php" method="get">
            <input type="search" name="s" id="search" placeholder="<?php echo $lang['What you need...']; ?>">
            <button type="submit" class="d-none"></button>
        </form>
        <!-- Close Icon -->
        <div class="closeIcon"><i class="fas fa-times" aria-hidden="true"></i></div>
    </div>
    </div>
  </div>
</div>


<h2 class="text-center myorders_head"><?php echo $lang['My orders']; ?></h2>
<div class="container-fluid">
    <div class="my_orders_container">
        <?php if (!empty($orders)) { ?>
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                  <td><?php echo $lang['Order_number']; ?></td>
                  <td><?php echo $lang['customer_name']; ?></td>
                  <td><?php echo $lang['payment method']; ?></td>
                  <td><?php echo $lang['customer_phone']; ?></td>
                  <td><?php echo $lang['customer_phone_whats']; ?></td>
                  <td><?php echo $lang['area_address']; ?></td>
                  <td><?php echo $lang['cus_address_2']; ?></td>
                  <td><?php echo $lang['additional_info']; ?></td>
                  <td><?php echo $lang['customer_area']; ?></td>
                  <td><?php echo $lang['order_total_price']; ?></td>
                  <td><?php echo $lang['date_order']; ?></td>
                </tr>

                <?php

                  foreach($orders as $order) {

                    echo "<tr>";
                      echo "<td><a class='brown' href='order.php?do=order_content&ordernum=" . $order['ord_number'] . "' target='_blank'>" . $order['ord_number'] . "</a></td>";
                      echo "<td>" . $order['f_name'] . ' ' . $order['s_name'] . "</td>";
                      echo "<td>" . $order['payment_type']         . "</td>";
                      echo "<td>+" . $order['country_key'] . ' ' . $order['cus_phone_number'] . "</td>";
                      echo "<td>+" . $order['country_key'] . ' ' . $order['cus_whats_number'] . "</td>";
                      echo "<td>" . $order['area_address']         . "</td>";
                      echo "<td>" . $order['s_address'] . "</td>";
                      echo "<td>" . $order['additional_information'] . "</td>";
                      echo "<td>" . $order['custmer_area'] . "</td>";
                      echo "<td>" . $order['ord_total_price'] . "Kwt" . "</td>";
                      echo "<td>" . $order['ord_date'] . "</td>";
                    echo "</tr>";

                  }
              ?>

            </table>
        </div>
        <?php } else { ?>
        <div class="container">
            <div class="my_orders_empty text-center">
                <i class="fas fa-cart-arrow-down"></i>
                <div class="message_empty alert alert-danger"><i class='fas fa-exclamation-circle'
                        style='padding: 10px;'></i><?php echo $lang['Not found any orders for you, but you can shopping now and make many orders']; ?>
                </div>
                <a class="btn btn-brown" href="index.php"><?php echo $lang['Shopping']; ?></a>
            </div>
        </div>
        <?php  } ?>
    </div>
</div>

<?php } else {
    header('Location: index.php');
    exit();
  }
} elseif ($do == 'order_content') {
  // Check If Get Request order num Is Numeric & Get The Integer Value It
  $ordernum = isset($_GET['ordernum']) && is_numeric($_GET['ordernum']) ? intval($_GET['ordernum']) : 0;

  // Select All Data Depend On This ID
  $check = checkItem('ord_number', 'orders', $ordernum);

  // If There Is Such ID Show The Form
  if ($check > 0) {
    // get order number Information

    $stmt = $con->prepare('SELECT * FROM orderdetails WHERE ord_number = ? ORDER BY ord_detail_id DESC');
    $stmt-> execute(array($ordernum));
    $products = $stmt->fetchAll(); ?>

<header class="header-area">
    <!-- Navbar Area -->
    <div class="famie-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container-fluid">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="famieNav">
                    <!-- Nav Brand -->
                    <a href="index.php" class="nav-brand"><img src="<?php echo $img; ?>logo_d.png" alt="Logo"></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>
                        <!-- Navbar Start -->
                        <div class="classynav">
                            <ul>
                                <li class="active">
                                    <a href="index.php"><?php echo $lang['Home']; ?></a>
                                </li>
                                <li>
                                <li>
                                    <a href="#"><?php echo $lang['categories']; ?></a>
                                    <ul class="dropdown">
                                        <?php
                        $cats = getAllFrom("*", "categories", "WHERE active = 0", "", "c_id");
                        foreach ($cats as $cat) { ?>
                                        <li><a
                                                href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>"><?php echo $cat['c_name']; ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                </li>
                                <li>
                                  <a class="order-link active" href="order.php?do=my_orders&customerid=<?php echo $sessionCus; ?>"><?php echo $lang['My orders']; ?></a>
                                </li>
                                <li class="lang-nav">
                                    <?php
                      if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == 'ar') { ?>
                                    <a href="#"><img src="layout/images/flag_kw.png"
                                            alt="arabic"><?php echo $lang['Arabic']; ?></a>
                                    <?php } elseif ($_GET['lang'] == 'en') { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php } else { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php  }
                      } else { ?>
                                    <a href="#"><img src="layout/images/USA.png"
                                            alt="english"><?php echo $lang['English']; ?></a>
                                    <?php } ?>
                                    <ul class="dropdown">
                                        <a href="?lang=ar"><img src="layout/images/flag_kw.png" width="34" height="24"
                                                alt="arabic"><span><?php echo $lang['Arabic']; ?></span></a>
                                        <a href="?lang=en"><img src="layout/images/USA.png" width="34" height="24"
                                                alt="english"><span><?php echo $lang['English']; ?><span></a>
                                    </ul>
                                </li>
                                </li>

                                <?php if (!isset($_SESSION['customer'])) { ?>
                                <li> <a href="login.php"><?php echo $lang['Signin']; ?></a></li>
                                <?php  } else { ?>
                                <li>
                                    <a href="#"><?php echo $_SESSION['customer']; ?></a>
                                    <ul class="dropdown">
                                        <li> <a href="logout.php">logout</a></li>
                                    </ul>
                                </li>
                                <?php  } ?>
                            </ul>

                            <!-- Search Icon -->
                            <div id="searchIcon">
                                <i class="fas fa-search"></i>
                            </div>

                            <!-- Cart Icon -->
                            <div id="cartIcon">
                                <a href="cart.php">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span id="cart-quantity" class="cart-quantity">
                                        <?php
                        if (isset($_SESSION['cart'])) {
                          $count = count($_SESSION['cart']);
                          echo $count;
                        } else {
                          echo "0";
                        } ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <!-- Navbar End -->
                    </div>
                </nav>
</header>

<div class="container-fluid">
    <h2 class="order_num_head text-center">
        <?php echo $lang['all infrmation about'] . '<span class="brown"> ' . $_GET['ordernum'] . ' </span>' . $lang['order number']; ?>
    </h2>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            <tr>
                <td><?php echo $lang['Product Name']; ?></td>
                <td><?php echo $lang['order quantity']; ?></td>
                <td><?php echo $lang['size']; ?></td>
                <td><?php echo $lang['color']; ?></td>
                <td><?php echo $lang['Font']; ?></td>
                <td><?php echo $lang['Engraving']; ?></td>
                <td><?php echo $lang['final price']; ?></td>
                <td><?php echo $lang['date_order']; ?></td>
            </tr>

            <?php
            $total = 0;
            foreach($products as $product) {

              echo "<tr>";
                echo "<td><a class='brown' href='product.php?p_id=" . $product['productID'] . '&productname=' . preg_replace('/\s+|%/', ' ', $product['p_name']) . '&action=getproductinformation' . "'>" . $product['p_name']   . "</a></td>";
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
                  <img class="shap_img" src="layout/images/personalize_images/<?php echo $shape['shap_img']; ?>" alt="shape" />
              <?php }
                } else {
                  echo $lang['Without Engraving'];
                }
                if(!empty($product['text_engraving']) && $product['text_engraving'] != 'not_found') {
                echo '<div class="engraving-txt">';
                  echo '<p>' . $lang['Engraving txt'] . ':' . '</p>';
                  echo '<span>' . $product['text_engraving'] . '</span>';
                  echo '<p>' . $lang['Engraving txt position'] . ':' . '</p>';
                  echo '<span>' . ($product['position_txt_eng'] != 'not_found' ? $detail['position_txt_eng'] : 'Center') . '</span>';
                echo '</div>';
                }        
                echo '</td>';
                echo "<td>" . $product['product_f_price']  . 'Kwt' . "</td>";
                echo "<td>" . $product['timestamp']    . "</td>";
              echo "</tr>";

            $total +=  $product['product_f_price'];
            } ?>
        </table>
        <div class="footer-table">
          <div class="total_price">
              <?php echo $lang['The total amount'] . ": " . $total . ' ' . $lang['Dinar'] ; ?>
          </div>
       </div>
    </div>
</div><!-- .container -->


<?php

  } else {
    header('Location: index.php');
    exit();
  } ?>

<?php } else {
  header('Location: index.php');
  exit();
} ?>


<?php
include $temp . 'footer.php';
ob_end_flush();
?>