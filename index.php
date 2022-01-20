<?php
  ob_start();
  $pageTitle = "Zlkwt For Braceletes";
  include 'init.php';

  // Get categories
  $stmt = $con->prepare("SELECT * FROM categories WHERE active = 0 ORDER BY c_id DESC");
  $stmt->execute();
  $cats = $stmt->fetch();

  $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login;
 ?>

 <!-- ##### Hero Area Start ##### -->
<div class="hero-area">
  <div class="welcome-slides owl-carousel">
    <!-- Single Welcome Slides -->

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>41.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Boys']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Bracelets For Boys on Zlkwt & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>38.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Girl Jewelries']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Bracelets For Girl Jewelries on Zlkwt & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>37.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Earrings']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Bracelets Earrings on Zlkwt & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>34.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Custom Keychains']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Custom Keychains on Zlkwt & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>products/sl1.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Girl']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Bracelets For Girl on Zlkwat & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>products/sl2.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['Custom Necklaces']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best Custom Necklaces on Zlkwat & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>products/SL3.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Women']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best bracelets For Women on Zlkwat & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="single-welcome-slides bg-img bg-overlay jarallax" style="background-image: url('<?php echo $img; ?>products/sl4.jpg');">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 col-lg-10">
            <div class="welcome-content">
              <h2 data-animation="fadeInDown" data-delay="200ms"><?php echo $lang['bracelets For Men']; ?></h2>
              <p data-animation="fadeInDown" data-delay="400ms"><?php echo $lang['The best bracelets For Men on Zlkwat & best Price']; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ##### Hero Area End ##### -->

	<div id="body">
		<div class="container">

      <div class="benefites-area">
        <div class="container">
          <div class="row">
           <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 phone_design">
             <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="100ms">
               <i class="fab fa-servicestack"></i>
               <h5><?php echo $lang['Best services']; ?></h5>
             </div>
           </div>

           <!-- Single Benefits Area -->
           <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 phone_design">
             <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="300ms">
               <i class="fas fa-infinity"></i>
               <h5><?php echo $lang['best materials']; ?></h5>
             </div>
           </div>
           <!-- Single Benefits Area -->
           <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 phone_design">
             <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="700ms">
               <i class="fas fa-dollar-sign"></i>
               <h5><?php echo $lang['suitable prices']; ?></h5>
             </div>
           </div>

           <!-- Single Benefits Area -->
           <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 phone_design">
             <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="900ms">
               <i class="fab fa-think-peaks"></i>
               <h5><?php echo $lang['Fantasy bracelets']; ?></h5>
             </div>
           </div>

         </div>
       </div>
      </div>

      <h2 class="latest-head home-h2"><?php echo $lang['Latest products']; ?></h2>
      <div class="row">
        <?php
        $latestProducts = getAllFrom("*", "products", "WHERE product_status = '1'", "", "p_id", "DESC", "limit 8");
        foreach ($latestProducts as $product) { ?>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
      </div>



      <?php
        $boysProducts = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID = '6'", "", "p_id", "limit 8");
        if (!empty($boysProducts)) { ?>

          <div class="clearfix"></div>
          <h2 class="latest-head home-h2"><?php echo $lang['bracelets For Boys']; ?></h2>
          <div class="row">

    <?php foreach ($boysProducts as $product) { ?>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
      </div>
  <?php } ?>
      <div class="clearfix"></div>

      <?php
        $braceletGirl = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID = '5'", "", "p_id", "limit 8");
        if (!empty($braceletGirl)) { ?>

          <h2 class="latest-head home-h2"><?php echo $lang['bracelets For Girl']; ?></h2>
          <div class="row">
            <?php

            foreach ($braceletGirl as $product) { ?>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
        <?php } ?>
          </div>

        <?php } ?>

        <?php
          $braceletWomen = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID = '4'", "", "p_id", "limit 8");
          if (!empty($braceletWomen)) { ?>

            <h2 class="latest-head home-h2"><?php echo $lang['bracelets For Women']; ?></h2>
            <div class="row">
              <?php

              foreach ($braceletWomen as $product) { ?>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
          <?php } ?>
            </div>

          <?php } ?>

          <?php
            $braceletMen = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID = '3'", "", "p_id", "limit 8");
            if (!empty($braceletMen)) { ?>

              <h2 class="latest-head home-h2"><?php echo $lang['bracelets For Men']; ?></h2>
              <div class="row">
                <?php

                foreach ($braceletMen as $product) { ?>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
            <?php } ?>
              </div>

            <?php } ?>

            <?php
              $braceletNecklaces = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID = '7'", "", "p_id", "limit 8");
              if (!empty($braceletNecklaces)) { ?>

                <h2 class="latest-head home-h2"><?php echo $lang['Custom Necklaces']; ?></h2>
                <div class="row">
                  <?php

                  foreach ($braceletNecklaces as $product) { ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
              <?php } ?>
                </div>

              <?php } ?>
            </div><!-- .container -->

            <div class="full-width-img design_banner">
              <div class="img-content text-center">
                 <p><?php echo $lang['The Best Gift with Our']; ?></p>
                 <p><?php echo $lang['Zlkwat best forever']; ?></p>
              </div>
            </div>

            <div class="container">
            <?php
              $otherProducts = getAllFrom("*", "products", "WHERE product_status = '1'", "AND categoryID != '7, 3, 4, 5, 6, 7, 8, 9'", "", "p_id", "");
              if (!empty($otherProducts)) { ?>

                <h2 class="latest-head home-h2"><?php echo $lang['Other products']; ?></h2>
                <div class="row">
                  <?php

                  foreach ($otherProducts as $product) { ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3 phone_50">
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
              <?php } ?>
                </div>

              <?php } ?>
            </div>

              <div class="clearfix"></div>

              <div class="full-width-img-second design_banner"></div>


            <div class="container">

              <h2 class="see-also home-h2 d-inline"><a href="categories.php"><?php echo $lang['See Also!']; ?></a></span></h2>
              <div class="cats-also-content">
                <div class="row">
                  <?php
                    $cats = getAllFrom("*", "categories", "WHERE active = 0", "", "", "c_id", "limit 12");
                     if (!empty($cats)) {
                       foreach($cats as $cat) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 phone_50">
                           <div class="cat-content text-center">
                             <a href="categories.php" target="_blank">
                              <div class="cat-img">
                                <img src="admin-dashboard/upload/categories_img/<?php echo $cat['c_picture']; ?>" alt="cat image" />
                              </div>
                              <h3><?php echo $cat['c_name']; ?></h3>
                             </a>
                           </div>
                        </div>
                      <?php
                      }
                    } else { ?>
                        <div class="col-12 text-center">
                          <div class="empty-state">
                              <i class="far fa-times-circle"></i>
                              <div class="title"><?php echo $lang['Whoops']; ?>!</div>
                              <div class="description">
                                <?php echo $lang['Not found any categories now!']; ?>
                              </div>
                          </div>
                        </div>
              <?php } ?>
                </div>
              </div>

		</div>
		<!-- / container -->
	</div>
	<!-- / body -->

<?php
  include $temp . 'footer.php';
  ob_end_flush();
 ?>
