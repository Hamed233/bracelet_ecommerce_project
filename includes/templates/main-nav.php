<?php $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login; ?>

<!-- ##### Header Area Start ##### -->
     <header class="header-area">
       <!-- Top Header Area -->
       <div class="top-header-area">
         <div class="container">
           <div class="row">
             <div class="col-12">
               <div class="top-header-content d-flex align-items-center justify-content-between">
                 <!-- Top Header Content -->
                 <div class="top-header-meta">
                   <p class="text-center"><?php echo $lang['Hello in our store']; ?><span> <strong><a href="https://www.zlkwt.com/">Zlkwt</a></strong> </span><?php echo $lang['For Good Bracelets, Nice Shopping!']; ?></p>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>

       <div class="container" >
        <div class="mid-section main-info-area">
            <div class="wrap-logo-top left-section">
              <a href="index.html" class="link-to-home"><img src="<?php echo $img; ?>logo_d.png" alt="logo website" style="width: 118px;"></a>
            </div>


            <div class="wrap-search center-section">
              <div class="wrap-search-form">
                  <form action="result_search.php" method="get" id="form-search-top" name="form-search-top">
                      <input type="text" name="s" value="" placeholder="Search here...">
                      <button form="form-search-top" type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
                      <div class="wrap-list-cate">
                          <input type="hidden" name="product_cat" value="All Category" id="product-cate">
                          <input type="hidden" name="product_cat_id" value="" id="product-cate-id">

                          <a href="#" class="link-control">All Category</a>
                          <ul class="list-cate" style="display: none;">
                              <li class="level-0">All Category</li>
                              <li class="level-1" data-id="208">enim est</li>
                              <li class="level-1" data-id="210">deleniti et</li>
                              <li class="level-1" data-id="211">vitae est</li>
                              <li class="level-1" data-id="212">dolor voluptatem</li>
                              <li class="level-1" data-id="214">facere qui</li>
                              <li class="level-1" data-id="215">consequatur amet</li>
                              <li class="level-1" data-id="216">ab deserunt</li>
                              <li class="level-1" data-id="217">id voluptatem</li>
                          </ul>
                      </div>
                  </form>
              </div>
          </div>

          <div class="wrap-icon right-section">
              <div class="wrap-icon-section wishlist">
                  <div id="favIcon">
                    <a class="favIcon link-direction" href="favproduct.php">
                      <i class="fas fa-heart " aria-hidden="true"></i>
                      <?php 
                      if($sessionCus) {
                        $cou_fav = countItems("p_fav", "favorite_products", "WHERE userid = {$sessionCus}");
                        echo '<span id="span_count" class="fav_count">' . $cou_fav . '</span>';
                      }
                      
                      ?>
                      <div class="left-info">
                        <span class="title">Favourites</span>
                      </div>
                    </a>
                  </div>
            </div>
            <div class="wrap-icon-section minicart">
                <a href="cart.php" class="link-direction">
                    <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                    <span id="cart-quantity" class="cart-quantity">
                       <?php 
                       if (isset($_SESSION['cart']) && isset($sessionCus)){
                         $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$sessionCus}");
                         echo $cou_cart;
                        } else {
                          echo "0";
                        } ?>
                    </span>
                    <div class="left-info">
                      <span class="title">CART</span>
                    </div>
                </a>
              </div>
          </div>
         </div>
        </div>

       <!-- Navbar Area -->
       <div class="famie-main-menu">
         <div class="classy-nav-container breakpoint-off">
                 <!-- Menu -->
                 <nav class="classy-navbar justify-content-between" id="famieNav">
                  <div class="container-fluid">
                  <!-- Nav Brand -->
                   <a href="index.php" class="nav-brand"><img src="<?php echo $img; ?>logo_d.png" alt="logo website"></a>

                     <!-- Navbar Toggler -->
                   <div class="classy-navbar-toggler">
                     <span class="navbarToggler"><span></span><span></span><span></span></span>
                   </div>
                  
                     <!-- Navbar Start -->
                   <!-- Menu -->
                   <div class="classy-menu">
                     <!-- Close Button -->
                     <div class="classycloseIcon">
                       <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                     </div>
                      
                     <div class="classynav">
                       <ul class="left-navbar-section">
                         <li>
                           <a class="home-link active" href="index.php"><?php echo $lang['Home']; ?></a>
                         </li>
                         <li>
                           <a class="order-link active" href="order.php?do=my_orders&customerid=<?php echo $sessionCus; ?>"><?php echo $lang['My orders']; ?></a>
                         </li>
                         <li>
                           <li>
                             <a class="cats-link" href="categories.php"><?php echo $lang['categories']; ?></a>
                               <ul class="dropdown">
                                 <?php
                                   $cats = getAllFrom("*", "categories", "WHERE active = '0'", "AND parent = '0'", "c_id");
                                   foreach($cats as $cat) { ?>
                                     <li><a href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>"><?php echo $cat['c_name']; ?></a></li>
                                     <?php $childCats = getAllFrom("*", 'categories', "WHERE parent = {$cat['c_id']}", "", "c_id", "ASC");
                                      if (!empty($childCats)){
                                          foreach ($childCats as $c) { ?>
                                            <li class='child_cat'><a href='categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $c['c_name']) . '&catid=' . $c['c_id'] . '&action=getcategoryinfo'; ?>'><?php echo $c['c_name']; ?></a></li>
                                         <?php }
                                      }  } ?>
                               </ul>
                             </li>


                           </li>
                         <li>

                          <li class="lang-nav">
                                <?php
                                if (isset($_GET['lang'])) {
                                  if ($_GET['lang'] == 'ar') { ?>
                                     <a href="#"><img src="layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></a>
                                <?php } elseif ($_GET['lang'] == 'en') { ?>
                                     <a href="#"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></a>
                                <?php } else { ?>
                                  <a href="#"><?php echo $_SESSION['lang']; ?></a>
                                <?php  }
                              } else { ?>
                                <a href="#"><?php echo $_SESSION['lang']; ?></a>
                          <?php } ?>
                              <ul class="dropdown">
                                <a href="?lang=ar"><img src="layout/images/flag_kw.png" width="34" height="24" alt="arabic"><span><?php echo $lang['Arabic']; ?></span></a>
                                <a href="?lang=en"><img src="layout/images/USA.png" width="34" height="24" alt="english"><span><?php echo $lang['English']; ?><span></a>
                              </ul>
                          </li>
                        </li>
                   </ul>
                   <div class="right-navbar-section">
                <div>
                   <?php if (!isset($_SESSION['customer'])) { ?>
                          <button class="btn btn-brown signup-btn"><a class="" href="login.php?do=SignUp"><?php echo $lang['SignUp']; ?></a></button>
                          <button class="btn btn-light login-btn"><a class="" href="login.php"><?php echo $lang['Signin']; ?></a></button>
                       <?php  } else { ?>
                         
                           <a href="#"><?php echo $_SESSION['customer']; ?></a>
                           <ul class="dropdown">
                              <li> <a href="logout.php"><?php echo $lang['logout']; ?></a></li>
                           </ul>
                         
                        <?php  } ?>
                      </div>
                   </div>
                 </div>
                 <!-- Navbar End -->
                 </div>
               </div>
             </nav>
    
             <div class="cap_status"></div>
         <?php if (isset($_SESSION['customer'])) { ?>
             <!-- This Alert run when product add to cart -->
               <div class="cap_status">
                 <?php
                   if (isset($_SESSION["success_login"])){
                       vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fa fa-check-circle\"></i> %s</div>", $_SESSION["success_login"]);
                       unset($_SESSION["success_login"]);
                   }
                  ?>
               </div>
            <?php } ?>
        </div>
      

      </div>
             <!-- login -->
     </header>
     <!-- ##### Header Area End ##### -->
