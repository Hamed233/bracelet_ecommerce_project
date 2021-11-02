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
                   <p class="text-center"><?php echo $lang['Hello in our store']; ?><span> <a href="https://www.zlkwt.com/">Zlkwt</a> </span><?php echo $lang['For Good Bracelets, Nice Shopping!']; ?></p>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>

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
                         <li>
                           <a class="home-link active" href="index.php"><?php echo $lang['Home']; ?></a>
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
                           <?php $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $sessionCustomer_not_login; ?>
                         <li>
                           <a class="order-link active" href="order.php?do=my_orders&customerid=<?php echo $sessionCus; ?>"><?php echo $lang['My orders']; ?></a>
                         </li>
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

                         <?php if (!isset($_SESSION['customer'])) { ?>
                             <li> <a class="login-link" href="login.php"><?php echo $lang['Signin'] . ' / ' . $lang['SignUp']; ?></a></li>
                       <?php  } else { ?>
                         <li>
                           <a href="#"><?php echo $_SESSION['customer']; ?></a>
                           <ul class="dropdown">
                              <li> <a href="logout.php"><?php echo $lang['logout']; ?></a></li>
                           </ul>
                         </li>
                      <?php  } ?>
                   </ul>

                   <!-- Search Icon -->
                   <div id="searchIcon">
                     <i class="fas fa-search"></i>
                   </div>

                   <!-- Search Form -->
                  <div class="search-form">
                    <form action="result_search.php" method="get">
                      <input type="search" name="s" id="search" placeholder="<?php echo $lang['What you need...']; ?>">
                      <button type="submit" class="d-none"></button>
                    </form>
                    <!-- Close Icon -->
                    <div class="closeIcon"><i class="fas fa-times" aria-hidden="true"></i></div>
                  </div>


                   <!-- Cart Icon -->
                   <div id="cartIcon">
                     <a href="cart.php">
                       <i class="fas fa-shopping-cart"></i>
                       <span id="cart-quantity" class="cart-quantity">
                       <?php 
                       $sessionCus = isset($_SESSION['cus_id']) ? $_SESSION['cus_id'] : $_SESSION['customer_id'];
                       if (isset($_SESSION['cart']) && isset($sessionCus)){
                         $cou_cart = countItems("p_c_id", "store_cart_item", "WHERE customer_id = {$sessionCus}");
                         echo $cou_cart;
                        } else {
                          echo "0";
                        } ?>
                        </span>
                     </a>
                   </div>
                   <!-- Favorite products -->
                   <div id="favIcon">
                    <a class="favIcon" href="favproduct.php">
                      <i class="fas fa-heart fav_icon"></i>
                      <?php 
                        $cou_fav = countItems("p_fav", "favorite_products", "WHERE userid = {$sessionCus}");
                        echo '<span id="span_count" class="fav_count">' . $cou_cart . '</span>';
                      ?>
                    </a>
                  </div>
                 </div>
                 <!-- Navbar End -->
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
      </div>

       <?php if (!isset($cats_nav)){ ?>
       <div class="navbar-cats">
         <ul>
        <?php
          $cats = getAllFrom("*", "categories", "WHERE active = 0", "AND parent < '1'", "", "c_id");
          if(!empty($cats)) {
            foreach($cats as $cat) { ?>
              <li><a href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>"><?php echo $cat['c_name']; ?></a></li>           
         <?php }
         } ?>
         </ul>
       </div>
    <?php } ?>
             <!-- login -->
     </header>
     <!-- ##### Header Area End ##### -->
