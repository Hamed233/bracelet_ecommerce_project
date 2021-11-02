<script>
  // Morris.Bar({
  //  element : 'chart',
  //  data:[<?php echo $chart_data; ?>],
  //  xkey:'year',
  //  ykeys:['profit', 'purchase', 'sale'],
  //  labels:['Profit', 'Purchase', 'Sale'],
  //  hideHover:'auto',
  //  stacked:true
  // });

  <?php
    // Get pending admins
    $sql = $con->prepare("SELECT COUNT('adm_id') From admins WHERE adm_status = 0");
    $sql->execute();
    $count_1 = $sql->fetchColumn();
    // Get active admins
    $sql = $con->prepare("SELECT COUNT('adm_id') From admins WHERE adm_status = 1");
    $sql->execute();
    $count_2 = $sql->fetchColumn();
    // Get admins number
    $adms_num = countItems('adm_id', 'admins');

    $pie_chart_admins = "{label: 'Total admins', value:".$adms_num."}, {label: 'Pending admins', value:".$count_1."}, {label: 'Approved admins', value:".$count_2."}"; ?>

  Morris.Donut({
    element: 'pie-chart-admins',
    data: [<?php echo $pie_chart_admins; ?>]
  });

  <?php
    // Get pending products
    $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE product_status = 0");
    $sql->execute();
    $count_1 = $sql->fetchColumn();
    // Get approved products
    $sql = $con->prepare("SELECT COUNT('p_id') From products WHERE product_status = 1");
    $sql->execute();
    $count_2 = $sql->fetchColumn();
    // Get Categories number
    $products_num = countItems('p_id', 'products');


    $pie_chart_products = "{label: 'Total Products', value:".$products_num."}, {label: 'Pending products', value:".$count_1."}, {label: 'Approved products', value:".$count_2."}"; ?>
    Morris.Donut({
      element: 'pie-chart-products',
      data: [<?php echo $pie_chart_products; ?>]
    });

<?php
  // Get Visible categories
  $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 0");
  $sql->execute();
  $count_vis = $sql->fetchColumn();
  // Get UnVisible categories
  $sql = $con->prepare("SELECT COUNT('c_id') From categories WHERE active = 1");
  $sql->execute();
  $count_unvis = $sql->fetchColumn();
  // Get Categories number
  $cats_num = countItems('c_id', 'categories');

  $pie_chart_cats = "{label: 'Categories', value:".$cats_num."}, {label: 'Visibile Categories', value:".$count_vis."}, {label: 'UnVisibile Categories', value:".$count_unvis."}";
 ?>

  Morris.Donut({
    element: 'pie-chart-cats',
    data: [<?php echo $pie_chart_cats; ?>]
  });

  <?php $pie_chart_order = "{label: 'Main Orders', value:".$orders_num."}, {label: 'Orders in baskets', value:".$orders_bask."}"; ?>
  Morris.Donut({
    element: 'pie-chart-order',
    data: [<?php echo $pie_chart_order; ?>]
  });

 <?php
   $customers_num = countItems('cus_id', 'customers');
   $products_num  = countItems('p_id', 'products');
   $cats_num      = countItems('c_id', 'categories');
   $orders_num    = countItems('ord_id', 'orders');
   $orders_bask   = countItems('p_c_id', 'store_cart_item');

  $pie_data = "{label: 'Products', value:".$products_num."}, {label: 'Categories', value:".$cats_num."}, {label: 'Customers', value:".$customers_num."}"; ?>
  Morris.Donut({
    element: 'pie-chart',
    data: [<?php echo $pie_data; ?>]
  });

</script>
