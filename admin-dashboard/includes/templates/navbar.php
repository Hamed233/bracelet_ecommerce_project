

<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="dashboard.php"><img src="<?php echo $img;?>f_logo.png" alt="logo" /></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">Categories</a>
        <!-- <span class="g-count-nav">
            <a href="orders.php">
              <?php
              //  echo countItems('c_id', 'categories'); ?>
            </a>
        </span> -->
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">products</a>
        <span class="g-count-nav">
            <!-- <a href="orders.php">
              <?php 
              // echo countItems('p_id', 'products'); ?>
            </a> -->
        </span>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admins.php">Admins</a>
        
        <span class="g-count-nav">
            <!-- <a href="orders.php">
              <?php 
              // echo countItems('adm_id', 'admins'); ?></a> -->
        </span>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="customers.php">Customers</a>
        <span class="g-count-nav">
            <!-- <a href="orders.php">
              <?php 
              // echo countItems('cus_id', 'customers'); ?></a> -->
        </span>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="orders.php">Orders</a>
        <span class="order_nums_nav g-count-nav">
            <!-- <a href="orders.php">
              <?php 
              // echo countItems('ord_id', 'orders') ?></a> -->
        </span>
      </li>



    </ul>
  </div>
</nav>

 <div class="toggle-more-info">
  <a href="#menu-toggle" id="menu-toggle" class="navbar-brand">
    <i class="fas fa-minus"></i>
  </a>
</div>
<div id="wrapper" class="">
  <?php if(isset($_SESSION['ID'])){ ?>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
          <li class="profile">
            <a class="" href="#">
               <?php
                   if (empty($_SESSION['avatar'])){
                     echo "<img class='avatar' src='layout/images/avatar2.png' alt='admin avatar' />";
                   } else {
                     echo "<img class='avatar' src='upload/admins_avatars/". $_SESSION['avatar'] ."' alt='admin avatar' />";
                   }

                   if (isset($_SESSION['adm_name'])) {
                     echo $_SESSION['adm_name'];
                   } elseif (isset($_SESSION['adm_mail'])) {
                     echo $_SESSION['adm_mail'];
                   }
                ?>
            </a>
          </li>
          <li class="lang-nav">
            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                if (isset($_GET['lang'])) {
                  if ($_GET['lang'] == 'ar') { ?>
                     <div class="d-inline"><img src="layout/images/egypt.png" alt="arabic"><?php echo $lang['Arabic']; ?></div>
                <?php } elseif ($_GET['lang'] == 'en') { ?>
                     <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
                <?php } else { ?>
                  <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
                <?php  }
              } else { ?>
                <div class="d-inline"><img src="layout/images/USA.png" alt="english"><?php echo $lang['English']; ?></div>
          <?php } ?>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="?lang=ar"><img src="layout/images/egypt.png" width="34" height="24" alt="arabic"><span><?php echo $lang['Arabic']; ?></span></a>
                <a class="dropdown-item" href="?lang=en"><img src="layout/images/USA.png" width="34" height="24" alt="english"><span><?php echo $lang['English']; ?><span></a>
              </div>
            </div>
          </li>


          <li><a class="trick_r" href="../index.php"><?php echo $lang['Visit Website']; ?></a></li>
          <li><a class="trick_r" href="logout.php"><?php echo $lang['Logout']; ?></a></li>
        </ul>
    </div> <!-- /#sidebar-wrapper -->
<?php } ?>