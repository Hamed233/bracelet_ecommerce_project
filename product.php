<?php
/*
============================
== product page
============================
*/

  ob_start();
  if (isset($_GET['productname'])) {
    $pageTitle = preg_replace('/\%/', ' ', $_GET['productname']);
  } else {
    $pageTitle ='Products';  // Page title
  }

  include "init.php";         // initialize file

  $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;

  $action = isset($_GET['action']) ? $_GET['action'] : 'Products';

  if ($action == 'Products') {
    header("Location: categories.php");
    exit();
  } elseif ($action == 'getproductinformation') {
    $stmt = $con->prepare("SELECT * FROM products WHERE p_id = {$_GET['p_id']} limit 1");
    $stmt->execute();
    $product = $stmt->fetch();
   ?>

    <div id="body">
      <div class="container">
        <div id="content" class="full">
          <div class="product product-info" data-id="<?php echo $_GET['p_id']; ?>">
            <div class="row" id="<?php echo $_GET['p_id']; ?>">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <!-- The expanding image container -->
                <div class="image product-img">
                  <!-- Expanded image -->
                  <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" id="expandedImg" alt="product image" style="width:100%">
                </div>
                <input type="hidden" id="<?php echo $_GET['p_id']; ?>_discount" data-discount="<?php echo $product['discount']; ?>" value="<?php echo $product['discount']; ?>" />
                <input type="hidden" id="<?php echo $_GET['p_id']; ?>_id" data-id="<?php echo $product['p_id']; ?>" value="<?php echo $product['p_id']; ?>" />
                <input type="hidden" id="<?php echo $_GET['p_id']; ?>_pname" data-pname="<?php echo $product['p_name']; ?>" value="<?php echo $product['p_name']; ?>" />
                <input type="hidden" id="<?php echo $_GET['p_id']; ?>_price" data-price="<?php echo $product['price']; ?>" value="<?php echo $product['price']; ?>" />
                <input type="hidden" id="<?php echo $_GET['p_id']; ?>_desc" data-desc="<?php echo $product['p_description']; ?>" value="<?php echo $product['p_description']; ?>" />

                
                <div class="part-one">
                    <h1 id="<?php echo $_GET['p_id']; ?>_productname" data-productname="<?php echo $product['p_name']; ?>"><?php echo $product['p_name']; ?></h1>
                    <p class="db-phone description_p" id="<?php echo $_GET['p_id']; ?>_desc" data-description="<?php echo $product['p_description']; ?>"><?php echo $product['p_description']; ?></p>
                    <hr />
                    <div class="product-price">
                      <h4 id="<?php echo $_GET['p_id']; ?>_f_price" data-price="<?php echo ($product['price'] - $product['discount']); ?>"><?php echo ($product['price'] - $product['discount']) . 'Kwt'; ?></h4>
                      <h5 id="<?php echo $_GET['p_id']; ?>_price" data-price="<?php echo $product['price']; ?>"><?php echo $product['price'] . 'Kwt'; ?></h5>
                    </div>
                  </div>

                  <div class="more-info-product d-phone">
                    <!-- Tab links -->
                   <div class="tab">
                     <button class="tablinks features active" onclick="openCity(event, 'features')"><?php echo $lang['Features']; ?></button>
                     <button class="tablinks more_info" onclick="openCity(event, 'more_info')"><?php echo $lang['more info']; ?></button>
                   </div>

                   <!-- Tab content -->
                   <div id="features" class="tabcontent" style="display: block;">
                     <h3><?php echo $lang['Features']; ?></h3>
                     <div class="storyInfo animated fadeInLeft">
					  						<h3 class="title"><?php echo $lang['Product Features']; ?></h3>
                        <ul class="list">
                          <li><?php echo $lang['Braided on one end']; ?></li>
                          <li><?php echo $lang['Engraving exposes the natural or dyed bottom']; ?></li>
                          <li><?php echo $lang['Durable product that gets better with age']; ?></li>
                          <li><?php echo $lang['One Size Fits All']; ?></li>
                          <li><?php echo $lang['Snap Button Closure']; ?></li>
                          <li><?php echo $lang['100% Genuine Leather Bracelet']; ?></li>
                          <li><?php echo $lang['Made in'] . ' ' . $product['country_made']; ?></li>					
                        </ul>
                        <hr>
                        <h3 class="title"><?php echo $lang['Description product']; ?></h3>
                        <div class="subtitle"><?php echo $product['p_description']; ?></div>
                      </div>                   
                    </div>

                   <div id="more_info" class="tabcontent animated fadeInLeft">
                     <h3><?php echo $lang['more info']; ?></h3>
                     <p><span><?php echo $lang['Country made'] . ':</span> ' . $product['country_made']; ?></p>
                     <p><span><?php echo $lang['product status'] . ':</span> ' . $product['status_material']; ?></p>
                     <p><span><?php echo $lang['Sell Done'] . ':</span> ' . $product['orders_number']; ?></p>
                     <p><span><?php echo $lang['available_product_num'] . ':</span> ' . $product['available_product_num']; ?></p>
                   </div>
                  </div>

                </div>

              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="details">
                  <h4 class="choose-color"><?php echo $lang['Choose size']; ?></h4>
                  <div class="part-two text-center" data-productid="<?php echo $product['p_id']; ?>">
      
                    <div class="size-option">
                      <div class="col-12">
                        <select class="form-control size_bracelet" name="size">
                            <option value="small" data-size="Small"><?php echo $lang['Small'] . ' 8.5" (16.51cm)'; ?></option>
                            <option value="medium" data-size="Medium"><?php echo $lang['Medium'] . ' 7.0" (17.78cm)'; ?></option>
                            <option value="large" data-size="Large"><?php echo $lang['Large'] . ' 7.5" (19.05cm)'; ?></option>
                            <option value="x-large" data-size="X-Large"><?php echo 'X-' . $lang['Large'] . ' 8.0" (20.32cm)'; ?></option>
                            <option value="xx-large" data-size="XX-Large"><?php echo 'XX-' . $lang['Large'] . ' 8.5" (21.59cm)'; ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr />

                  <h4 class="choose-color"><?php echo $lang['Choose color']; ?></h4>
                  <div class="part-two text-center" data-productid="<?php echo $product['p_id']; ?>">
                      <div class="color-one catalogSwatchContainer catalogSwatchContainerMain" data-productid="<?php echo $product['p_id']; ?>">
                        <img id="" class="catalogSwatch catalogSwatchActive" src="<?php echo $img; ?>personalize_images/black-braided-wrap-bracelet_swatch.jpg" alt="product color" data-color="black">
                      </div>

                      <div class="color-two catalogSwatchContainer catalogSwatchContainerMain" data-productid="<?php echo $product['p_id']; ?>">
                        <img class="catalogSwatch" src="<?php echo $img; ?>personalize_images/brown-braided-wrap-bracelet_swatch.jpg" alt="product color" data-color="brown">
                      </div>

                      <div class="color-three catalogSwatchContainer catalogSwatchContainerMain" data-productid="<?php echo $product['p_id']; ?>">
                        <img class="catalogSwatch" src="<?php echo $img; ?>personalize_images/white-black-back-braided-wrap-bracelet_swatch.jpg" alt="product color" data-color="white">
                      </div>
                  </div>
                  <hr />

             <h4 class="Personalize It"><?php echo $lang['Personalize It']; ?></h4>
             <div class="part-three">
               <div class="row">
                  <div class="col-12">
                    <div class="form-check">
                      <label class="form-check-label productFontLabel" for="Simple">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Simple" value="Simple" data-kind="Simple" checked>
                         <span class="design"></span>
                         <span class="text" style="font-family: Simple;">Simple</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Script">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Script" value="Script" data-kind="Script">
                         <span class="design"></span>
                         <span class="text" style="font-family: Script;">Script</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Block">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Block" value="Block" data-kind="Block">
                         <span class="design"></span>
                         <span class="text" style="font-family: block;">Block</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Roman">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Roman" value="Roman" data-kind="Roman">
                         <span class="design"></span>
                         <span class="text" style="font-family: Roman;">Roman</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="AZURE">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="AZURE" value="AZURE" data-kind="AZURE">
                         <span class="design"></span>
                         <span class="text" style="font-family: AZURE;">AZURE</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Sultan">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Sultan" value="Sultan" data-kind="Sultan">
                         <span class="design"></span>
                         <span class="text" style="font-family: Sultan;">سلطان</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Baby">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Baby" value="Baby" data-kind="Baby">
                         <span class="design"></span>
                         <span class="text" style="font-family: Baby;">Baby</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Contemp">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Contemp" value="Contemp" data-kind="Contemp">
                         <span class="design"></span>
                         <span class="text" style="font-family: Contemp;">Contemp</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="Scriptrund">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="Scriptrund" value="Scriptrund" data-kind="Scriptrund">
                         <span class="design"></span>
                         <span class="text" style="font-family: Scriptrund;">phScriptrund</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="SL543">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="SL543" value="SL543" data-kind="SL543">
                         <span class="design"></span>
                         <span class="text" style="font-family: SL543;">SL543</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="HHSL">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="HHSL" value="SL" data-kind="SL">
                         <span class="design"></span>
                         <span class="text" style="font-family: SL;">SL</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="HH59">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="HH59" value="59" data-kind="59">
                         <span class="design"></span>
                         <span class="text">59</span>
                       </label>

                       <label class="form-check-label productFontLabel" for="STENCll_513">
                         <input type="radio" class="form-check-input productFont" type="radio" name="productFont" id="STENCll_513" value="STENCll_513" data-kind="STENCll_513">
                         <span class="design"></span>
                         <span class="text" style="font-family: STENCll_513;">STENCll_513</span>
                       </label>
                    </div>
                    <hr />
                  </div>

                  <div id="personalizeArea" class="col-12 d-none">
                    <div class="productDetailsSymbolCaption">Click / Tap symbols to add</div>
                       <div class="productSymbolArea text-center" style="cursor: pointer;"  data-click_count="0" id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="heart engraving symbol" src="<?php echo $img; ?>personalize_images/heart.png" id="1" width="23" height="21" class="clickableSymbol" data-identifier="heart[]" data-img="heart"
                              data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="lheart engraving symbol" src="<?php echo $img; ?>personalize_images/lheart.png" id="2" width="23" height="21" class="clickableSymbol" data-identifier="lheart[]" data-img="lheart"
                               data-id="<?php echo $_GET['p_id']; ?>" >
                              <img tabindex="-1" alt="rheart engraving symbol" src="<?php echo $img; ?>personalize_images/rheart.png" id="3" width="23" height="21" class="clickableSymbol" data-identifier="rheart[]" data-img="rheart"
                              data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="music engraving symbol" src="<?php echo $img; ?>personalize_images/music.png" id="4" width="23" height="21" class="clickableSymbol" data-identifier="music[]" data-img="music"
                               data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="music2 engraving symbol" src="<?php echo $img; ?>personalize_images/music2.png" id="5" width="23" height="21" class="clickableSymbol" data-identifier="music2[]" data-img="music2"
                               data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="moon engraving symbol" src="<?php echo $img; ?>personalize_images/moon.png" id="6" width="23" height="21" class="clickableSymbol" data-identifier="moon[]" data-img="moon"
                               data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="star engraving symbol" src="<?php echo $img; ?>personalize_images/star.png" id="7" width="23" height="21" class="clickableSymbol" data-identifier="star[]" data-img="star"
                               data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="strike engraving symbol" src="<?php echo $img; ?>personalize_images/strike.png" id="8" width="23" height="21" class="clickableSymbol" data-identifier="strike[]" data-img="strike"
                               data-id="<?php echo $_GET['p_id']; ?>">
                              <img tabindex="-1" alt="sun engraving symbol" src="<?php echo $img; ?>personalize_images/sun.png" id="9" width="23" height="21" class="clickableSymbol" data-identifier="sun[]" data-img="sun"
                               data-id="<?php echo $_GET['p_id']; ?>">
                       </div>

                        <hr />
                        <div class="model_view" id="model"></div>
                        <hr />
                        <div class="text-engrave">
                          <h5><?php echo $lang['Would you want engraving a texts?']; ?></h4>
                          <input type="text" class="form-control" name="text-engraving" value="<?php echo isset($_POST['text-engraving']) ? $_POST['text-engraving'] : ''; ?>" maxlength="30" data-txt="text_engrave" placeholder="<?php echo $lang['Like Mohamed']; ?>" />
                          <hr />

                        <h5><?php echo $lang['Position of engraving a texts?']; ?></h5>
                        <div class="form-check directions">
                          <label class="form-check-label Position_engraving" for="Right">
                            <input type="radio" class="form-check-input Position_engraving" type="radio" name="Position_engraving" id="Right" value="Right" data-position="Right">
                            <span class="design"></span>
                            <span class="text"><?php echo $lang['Right']; ?></span>
                          </label>

                          <label class="form-check-label Position_engraving" for="Middle">
                            <input type="radio" class="form-check-input Position_engraving" type="radio" name="Position_engraving" id="Middle" value="Middle" data-position="Middle">
                            <span class="design"></span>
                            <span class="text"><?php echo $lang['Middle']; ?></span>
                          </label>

                          <label class="form-check-label Position_engraving" for="Left">
                            <input type="radio" class="form-check-input Position_engraving" type="radio" name="Position_engraving" id="Left" value="Left" data-position="Left">
                            <span class="design"></span>
                            <span class="text"><?php echo $lang['Left']; ?></span>
                          </label>
                        </div>
                        </div>
                       <form name="refreshForm">
                         <input type="hidden" name="visited" value="" />
                       </form>

                     </div>

                     <div id="chooseCoordinateType" class="chooseEngraveType productDetailsSwitchCaption"><?php echo $lang['Switch to coordinate engraving']; ?></div>
                   </div>

             </div><!-- .part-three -->

             <div class="part-four">
              <div class="row">
               <div class="col-5">
                 <div class="quantity quan-product">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" class="quantity-left-minus btn btn-brown btn-number" data-type="minus" data-field="">
                        <i class="fas fa-minus"></i>
                      </button>
                    </span>
                    <input type="text" id="<?php echo $_GET['p_id']; ?>_quantity" name="quantity" class="form-control input-number quantity_js" value="1" min="1" max="100">
                    <span class="input-group-btn">
                       <button type="button" class="quantity-right-plus btn btn-brown btn-number" data-type="plus" data-field="">
                         <i class="fas fa-plus"></i>
                       </button>
                    </span>
                   </div>
                 </div>
                 <div class="save-product-num-2">
                 <span><?php echo $lang['Available'] . ' ' .$product['available_product_num'] . ' ' . $lang['Piece']; ?></span>
               </div>
               </div>
               <div class="col-7">
                 <div class="add-buy-btn for_lg">
                     <button id="cart_btn" class="btn cart_btn" onclick="cart('<?php echo $_GET['p_id']; ?>')">
                       <i class="fas fa-cart-plus"></i>
                       <?php echo $lang['add to cart']; ?>
                     </button>
                  </div><!-- .add-buy-btns -->
                </div><!-- col-7 -->
              </div><!-- .row -->
            </div><!-- .part-four -->
            <!-- The Modal message -->
            <div id="myModal" class="modal">
              <!-- Modal content -->
              <div class="modal-content">
                <div class="my-modal-header">
                  <span class="close">&times;</span>
                  <h2 class="text-left">Success!</h2>
                </div>
                <div class="modal-body">
                <div class="text-center icon-success"><i class="fas fa-check-circle"></i></div>
                  <p class="text-center"><?php echo $lang['Added to cart, successfully!']; ?></p>
                  <div class="btns-message">
                   <div class="cartStepNavigation">
                    <div class="row no-gutters">
                      <div class="col-xs-12 xol-sm-12 col-md-4 co-lg-4">
                        <button class="backStep btn-lg btn btn-treatycheckout btn-treatylite btn-block lite">
                          <span><a href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"><?php echo $lang['Shop more']; ?></a></span>
                        </button>
                      </div>
                      <div class="col-xs-12 xol-sm-12 col-md-8 co-lg-8 padd-trick">
                        <button class="nextStep btn-lg btn btn-treatydark btn-treatycheckout btn-block lite">
                          <span><a href="cart.php"><?php echo $lang['Show my cart & checkout']; ?></a></span>
                        </button>
                      </div>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>

            <div class="part-five">
              

               <div class="shipping-alert">
                <h5><?php echo $lang['Shipping: KWD']; ?></h5>
                <p><?php echo $lang['Estimated Delivery:'] . ' <span>7-15</span> ' . $lang['days']; ?> <i class="fas fa-question-circle"></i></p>
               </div>
            </div> <!-- .part-five -->
           </div>
         </div><!-- .col-6 -->
       </div><!-- .row -->
       <div class="clearfix"></div>

       <hr />

       <div class="row">
          <div class="col-lg-6 qtyDiscountFeatures">
            <div class="productPromoBoxContainer">
              <div class="productPromoBoxIcon">	
                <i class="fas fa-tags"></i>
              </div>
              <div class="productPromoBoxText">	
                <span class="productPromoBoxTextTitle"><?php echo $lang['BUY MORE & SAVE!']; ?></span><br>
                <span class="productPromoBoxTextSub"><?php echo $lang['This product is eligible for QTY Discounts']; ?></span>
              </div>
            </div>
          </div>	
          <div class="col-lg-6 qtyDiscountFeatures">
            <div class="productPromoBoxContainer">
              <div class="productPromoBoxIcon">	
                <i class="fas fa-coins"></i>
              </div>
              <div class="productPromoBoxText">	
                <span class="productPromoBoxTextTitle"><?php echo $lang['EARN TREATY TOKENS']; ?></span><br>
                <span class="productPromoBoxTextSub"><?php echo $lang['Get reward points on this purchase']; ?></span>
              </div>
            </div>
          </div>	

          
          <div class="col-lg-6">
            <div class="productPromoBoxContainer">
              <div class="productPromoBoxIcon">	
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <div class="productPromoBoxText">	
                <span class="productPromoBoxTextTitle"><?php echo $lang['FREE Engraving']; ?></span><br>
                <span class="productPromoBoxTextSub"><?php echo $lang['Personalization is included']; ?></span>
              </div>
            </div>
          </div>	
          <div class="col-lg-6">
            <div class="productPromoBoxContainer">
              <div class="productPromoBoxIcon">	
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="productPromoBoxText">	
                <span class="productPromoBoxTextTitle"><?php echo $lang['Genuine']; ?></span><br>
                <span class="productPromoBoxTextSub"><?php echo $lang['Crafted from high-quality leather']; ?></span>
              </div>
            </div>
          </div>	
          <div class="col-12">
            <hr>
          </div>  
        </div>
      </div>
      </div>
    </div><!-- .container -->

    <div class="image-full-width"></div>

    <div class="container">
       <div class="similar-product-content">
         <h2 class="similar-head"><?php echo $lang['Similar products']; ?></h2>
          <div class="row">
              <?php
                $getAllSimilar = getAllFrom("*", "products", "WHERE product_status = 1", "AND p_id != {$_GET['p_id']}", "p_id", "ASC", "LIMIT 12");
                  foreach ($getAllSimilar as $product) { ?>
                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 phone_50">
                        <div class="product-content">
                          <i id="<?php echo $product['p_id']; ?>_love" class="far fa-heart fa-fw" onclick="addLove(<?php echo $product['p_id']; ?>, <?php echo $sessionCus; ?>)" aria-hidden="true" data-icon="far" data-productid="<?php echo $product['p_id']; ?>"></i>
                          <div class="product-img">
                            <img src="admin-dashboard/upload/products/<?php echo $product['p_picture']; ?>" alt="product image" />
                          </div><!-- .product-img -->
                          <a class="" href="product.php?p_id=<?php echo $product['p_id'] . '&productname=' . preg_replace('/\s/', '%', $product['p_name']) . '&action=getproductinformation'; ?>" target="_blank">           
                            <div class="product-name">
                              <?php echo $product['p_name']; ?>
                            </div><!-- .product-name -->

                            <div class="product-price">
                              <?php echo $product['price'] . 'Kwt'; ?>
                            </div><!-- .product-price -->
                          </a>

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
            </div><!-- .similar-product-content -->
         </div>
     </div>

  </div>
      <!-- / container -->
</div>
    <!-- / body -->
<?php  } ?>



<?php
	// Include Footer page
 include $temp . 'footer.php';
 ob_end_flush();
?>
