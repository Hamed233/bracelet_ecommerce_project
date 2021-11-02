<?php

    ob_start(); // Output Buffering start
    $pageTitle =  'Dashboard admin';  // for main title page
    include 'init.php';

    if(!isset($_SESSION['ID'])) {
      header('Location: index.php');
      exit();
    }
    $pageTitle = isset($_GET['lang']) ? $lang['Dashboard admin'] : '';

    // if (isset($_SESSION['adm_id'])) {

        /* Start Dashboard Page */

        $numCustomers = 5;  // Number Of The Latest Customers
        $latestCustomers  = getLatest("*", "customers", "cus_id", $numCustomers); // Latest Members Array

        $numAdmins = 5;  // Number Of The Latest Admins
        $latestAdmins  = getLatest("*", "admins", "adm_id", $numAdmins); // Latest Admins Array

        $numProducts = 10;  // Number Of The Latest Items
        $latestProducts = getLatest("*", "products", "p_id", $numProducts);  // Latest Items Array

        $numPenProducts = 10;  // Number Of The Latest Pending Items
        $stmt = $con->prepare("SELECT * FROM products WHERE product_status = 0 ORDER BY p_id DESC LIMIT 10");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $num_pend = $stmt->rowCount();

        $customers_num = countItems('cus_id', 'customers');
        $products_num  = countItems('p_id', 'products');
        $cats_num      = countItems('c_id', 'categories');
        $orders_num    = countItems('ord_id', 'orders');
        $orders_bask   = countItems('p_c_id', 'store_cart_item');
        ?>

      <div class="dashboard-page">
        <div class="home-stats">
          <div class="container text-center">
             <h2 class="page-heading"><?php echo $lang['Dashboard']; ?></h2>
              <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat st-members">
                        <i class="fas fa-users dash_i"></i>
                         <div class="info">
                           <?php echo $lang['Total Customers']; ?>
                             <span>
                                 <a href="customers.php"><?php echo $customers_num; ?></a>
                             </span>
                         </div>
                      </div>
                   </div>

                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat st-items">
                         <i class="fas fa-tag dash_i"></i>
                         <div class="info">
                            <?php echo $lang['Total Products']; ?>
                             <span>
                                 <a href="products.php"><?php echo $products_num; ?></a>
                             </span>
                          </div>
                      </div>
                   </div>

                  <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="stat categories-count">
                         <div class="info">
                          <?php echo $lang['Total Categories']; ?>
                             <span>
                                <a href="categories.php"><?php echo $cats_num; ?></a>
                             </span>
                         </div>
                      </div>
                   </div>

                   <div class="col-sm-12 col-md-3 col-lg-3">
                      <div class="stat customers-count">
                          <div class="info">
                           <?php echo $lang['Total Customers']; ?>
                              <span>
                                 <a href="products.php"><?php echo $num_pend; ?></a>
                              </span>
                          </div>
                       </div>
                    </div>

                   <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="stat st-order_d">
                        <i class="fab fa-first-order-alt dash_i"></i>
                          <div class="info">
                            <?php echo $lang['Total orders']; ?>
                              <span>
                                  <a href="orders.php"><?php echo $orders_num; ?></a>
                              </span>
                          </div>
                       </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                       <div class="stat st-orders">
                         <i class="fas fa-question dash_i"></i>
                           <div class="info">
                             <?php echo $lang['Total orders in baskets']; ?>
                               <span>
                                   <a href="orders.php"><?php echo $orders_bask; ?></a>
                               </span>
                           </div>
                        </div>
                     </div>
              </div>
           </div>

           <div class="container">
             <div class="row">
               <div class="col-sm-6">
                 <div class="pie-first">
                  <label class="label label-success">Pie Total Numbers Chart</label>
                  <div id="pie-chart"></div>
                 </div>
               </div>

               <div class="col-sm-6">
                 <div class="pie-second">
                   <label class="label label-success">Pie Orders Chart</label>
                   <div id="pie-chart-order"></div>
                 </div>
               </div>
             </div>
           </div>
         </div>



         <!-- <div id="chart-container">
          <canvas id="graphCanvas"></canvas>
         </div> -->

       <div class="container">
         <h2 class="page-heading"><?php echo $lang['statistics']; ?></h2>
         <div class="first-block">
            <div class="row">

             <div class="col-sm-6 text-center">
                <div class="panel panel-card">
                     <div class="panel-heading">
                       <i class="fas fa-tag"></i> <?php echo $lang['Latest'] . ' ' . $numProducts . ' ' . $lang['products']; ?>
                        <span class="toggle-info pull-right">
                            <i class="fas fa-plus fa-lg"></i>
                         </span>
                     </div>
                     <div class="panel-body">
                       <div class="table-responsive">
                         <?php if (! empty($latestProducts)) { ?>
                          <table class="table latest-product">
                            <thead class="bg-light">
                              <tr class="border-1">
                                <th class="border-0"><?php echo $lang['Product Name']; ?></th>
                                <th class="border-0"><?php echo $lang['Price']; ?></th>
                                <th class="border-0"><?php echo $lang['Discount']; ?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php

                                   foreach ($latestProducts as $product) {
                                     echo '<tr>';
                                      echo '<td>' . $product['p_name'] . '</td>';
                                      echo '<td>' . '$' . $product['price'] . '</td>';
                                      echo '<td>' . '$' . $product['discount'] . '</td>';
                                     echo '</tr>';
                                   }
                                 ?>
                            </tbody>
                          </table>
                <?php } else { ?>
                           <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Products']; ?> </div>
                  <?php } ?>
                       </div>
                    </div>
                </div>
           </div>


           <div class="col-sm-6 text-center">
              <div class="panel panel-card">
                   <div class="panel-heading">
                     <i class="fas fa-tag"></i> <?php echo $lang['Pending'] . ' ' . $numPenProducts . ' ' . $lang['products']; ?>
                      <span class="toggle-info pull-right">
                          <i class="fas fa-plus fa-lg"></i>
                       </span>
                   </div>
                   <div class="panel-body">
                     <div class="table-responsive">
                       <?php if (! empty($rows)) { ?>
                        <table class="table latest-product">
                          <thead class="bg-light">
                            <tr class="border-1">
                              <th class="border-0"><?php echo $lang['Product Name']; ?></th>
                              <th class="border-0"><?php echo $lang['Price']; ?></th>
                              <th class="border-0"><?php echo $lang['Discount']; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                                 foreach ($rows as $product) {
                                   echo '<tr>';
                                    echo '<td>' . $product['p_name'] . '</td>';
                                    echo '<td>' . '$' . $product['price'] . '</td>';
                                    echo '<td>' . '$' . $product['discount'] . '</td>';
                                   echo '</tr>';
                                 }
                               ?>
                          </tbody>
                        </table>
              <?php } else { ?>
                         <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Products']; ?> </div>
                <?php } ?>
                     </div>
                  </div>
              </div>
         </div>
         </div><!-- #first-block -->

           <div class="second-block">
             <div class="row">
               <div class="col-sm-6 text-center">
                  <div class="panel panel-card">
                       <div class="panel-heading">
                         <i class="fas fa-users"></i> <?php echo $lang['Latest'] . ' ' . $numCustomers . ' ' . $lang['Registerd Customers']; ?>
                          <span class="toggle-info pull-right">
                              <i class="fas fa-plus fa-lg"></i>
                           </span>
                       </div>
                       <div class="panel-body">
                         <div class="table-responsive">
                            <?php if (! empty($latestCustomers)) { ?>
                            <table class="table latest-product">
                              <thead class="bg-light">
                                <tr class="border-1">
                                  <th class="border-0"><?php echo $lang['Username']; ?></th>
                                    <th class="border-0"><?php echo $lang['Email']; ?></th>
                                  <th class="border-0"><?php echo $lang['Date']; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                     foreach ($latestCustomers as $customer) {
                                       echo '<tr>';
                                        echo '<td>' . $customer['cus_name'] . '</td>';
                                        echo '<td>' . $customer['cus_mail'] . '</td>';
                                        echo '<td>' . $customer['cus_enter_date'] . '</td>';
                                       echo '</tr>';
                                     }
                                   ?>
                              </tbody>
                            </table>
                          <?php } else { ?>
                                <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Customers']; ?></div>
                            <?php } ?>
                         </div>
                      </div>
                  </div>
             </div>

             <div class="col-sm-6 text-center">
                <div class="panel panel-card">
                     <div class="panel-heading">
                       <i class="fas fa-users"></i> <?php echo $lang['Latest'] . ' ' . $numAdmins . ' ' . $lang['Admins']; ?>
                        <span class="toggle-info pull-right">
                            <i class="fas fa-plus fa-lg"></i>
                         </span>
                     </div>
                     <div class="panel-body">
                       <div class="table-responsive">
                          <?php if (! empty($latestAdmins)) { ?>
                          <table class="table latest-product">
                            <thead class="bg-light">
                              <tr class="border-1">
                                <th class="border-0"><?php echo $lang['admin_name']; ?></th>
                                  <th class="border-0"><?php echo $lang['Email']; ?></th>
                                <th class="border-0"><?php echo $lang['Date']; ?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                   foreach ($latestAdmins as $admin) {
                                     echo '<tr>';
                                      echo '<td>' . $admin['adm_name'] . '</td>';
                                      echo '<td>' . $admin['adm_mail'] . '</td>';
                                      echo '<td>' . $admin['date_register'] . '</td>';
                                     echo '</tr>';
                                   }
                                 ?>
                            </tbody>
                          </table>
                        <?php } else { ?>
                              <div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i><?php echo $lang['Sorry Not Found Any Customers']; ?></div>
                          <?php } ?>
                       </div>
                    </div>
                </div>
           </div>

             </div>
           </div>

     </div><!-- #container -->
  </div>
</div>

<?php

  // // First Chart
  // $query = $con->prepare("SELECT * FROM test");
  // $query->execute();
  // $result = $query->fetchAll();
  //
  // $chart_data = '';
  // foreach($result as $row) {
  //  $chart_data .= "{ year:'".$row["year"]."', profit:".$row["profit"].", purchase:".$row["purchase"].", sale:".$row["sale"]."}, ";
  // }
  // $chart_data = substr($chart_data, 0, -2);

  // Second Chart
  // Third Chart
 ?>


</div>

      <?php
        $customers_num = countItems('cus_id', 'customers');
        $products_num  = countItems('p_id', 'products');
        $cats_num      = countItems('c_id', 'categories');
        $orders_num    = countItems('ord_id', 'orders');
        $orders_bask   = countItems('p_c_id', 'store_cart_item');

        $pie_data = "{label: 'Products', value:".$products_num."}, {label: 'Categories', value:".$cats_num."}, {label: 'Customers', value:".$customers_num."}";
        $pie_chart_order = "{label: 'Main Orders', value:".$orders_num."}, {label: 'Orders in baskets', value:".$orders_bask."}";

        /* End Dashboard Page */
        include $tpl . 'footer-copyright.php';
        include $tpl . 'footer.php'; ?>

        <script>
          Morris.Donut({
           element: 'pie-chart',
           data: [<?php echo $pie_data; ?>]
          });

          Morris.Donut({
            element: 'pie-chart-order',
            data: [<?php echo $pie_chart_order; ?>]
          });
        </script>
  <?php
 // } else {
 //        header('Location: index.php');
 //        exit();
 //      }
       ?>

<?php
ob_end_flush();
?>
