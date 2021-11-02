<?php
/*
============================================================
== Configration all files & information special MyDream   ==
============================================================
*/

    session_start(); // starting session

    include 'config/connectDB.php'; // connect To DB
    // check if isset session customer
    $sessionCustomer = '';
    if (isset($_SESSION['customer_id'])) {
      $sessionCustomer = $_SESSION['customer_id'];
    } else {
      if(!isset($_SESSION['customer_id'])) {
        $_SESSION['customer_id'] = rand(10, 100000);
      }
      $_SESSION['cart'] = 0;
    }

    $sessionCustomer_not_login = $_SESSION['customer_id'];

    

    // === All short path  ===

     // => Special includes directory
    $temp = 'includes/templates/';
    $page = 'includes/pages/';
    $func = 'includes/functions/';
    $lang = 'includes/langs/';
     // => special layout directory
    $css  = 'layout/css/';
    $js   = 'layout/js/';
    $img  = 'layout/images/';
    $libr = 'layout/libraries/';

    // Static files

    include $func . 'function.php';   // functions file
    include 'config/config_lang.php';  // Configration languages
    include $temp . 'header.php';      // header template

    if (!isset($head_dis)) {
      include $temp . 'main-nav.php';
    }

?>
