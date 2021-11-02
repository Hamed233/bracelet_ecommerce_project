<?php

 session_start();

 include 'config/connect-db.php';

  // pathes

 $tpl   = 'includes/templates/';    // Templates Directory
 $func  = 'includes/functions/';    // Function Directory
 $css   = 'layout/css/';            // Css Directory
 $js    = 'layout/js/';             // js Directory
 $libr  = 'layout/libraries/';      // Libraries Directory
 $img   = 'layout/images/';         // images Directory
 $lang  = 'includes/langs/';        // languages Directory

 // for handle errors
 ini_set('log_errors','On');
 ini_set('display_errors','Off');
 ini_set('error_reporting', E_ALL );
 define('WP_DEBUG', false);
 define('WP_DEBUG_LOG', true);
 define('WP_DEBUG_DISPLAY', false);



  /*
   ---------Include The Important Files----------
  */

    include $func . 'function.php'; // Include Functions Page
    include 'config/config_lang.php';  // Configration languages
        // Include Header page
    include $tpl . 'header.php';

    if (!isset($_SESSION['ID'])) {
        $noNavbar = '';
    }
      
   // Include Navbar On All Pages Expect The With $noNavbar Variable
  if (!isset($noNavbar)) {
      include $tpl . 'navbar.php';
  } 
  

