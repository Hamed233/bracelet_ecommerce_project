<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]-->
     <head>
        <title><?php getTitle(); ?></title> <!-- Main Title -->
               <!-- All Meta -->
            <meta charset="UTF-8" />
            <meta http-equiv ="X-UA-Compatible" content="IE=edge" />
            <meta name ="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="google-site-verification" content="MAzNr3QZ8ogeR5RD3E5QBxDoStMA0xR2D1c-k05ffns" />
            <meta name ="author" content="Hamed Essam" />
            <meta name ="description" content="Zlkwt for shopping bracelets" />

           <!-- All file must be included -->
               <!--  All plugins -->
            <link rel="stylesheet" href="<?php echo $libr; ?>bootstrap/bootstrap.min.css" /> <!-- v4.0 -->
            <link rel="stylesheet" href="<?php echo $libr; ?>fontawesome/css/all.min.css" /><!-- Font-awesome library -->
            <link rel="stylesheet" href="<?php echo $libr; ?>normalize/normalize.css" /> <!-- Normailze library -->
            <link rel="stylesheet" href="<?php echo $css; ?>classy-nav.css" /> <!-- class nav library -->
            <link rel="stylesheet" href="<?php echo $css; ?>flexslider.css" /> <!-- Flexslider css (for Testimonials) -->
            <link rel="stylesheet" href="<?php echo $css; ?>popuo-box.css" />  <!-- Popup css (for Video Popup) -->
            <link rel="stylesheet" href="<?php echo $css; ?>owl.carousel.min.css"/>  <!-- owl carousel css -->
            <link rel="stylesheet" href="<?php echo $css; ?>lightbox.css" />
            <link rel="stylesheet" href ="<?php echo $css; ?>jquery-ui.css">
               <!-- css file -->
             <link rel="stylesheet" href="<?php echo $css; ?>main_style.css" />
             <!--[if lt IE 9]>
               <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
             <![endif]-->
              <?php
                 if ($_SESSION['lang'] == "ar") { ?>
                    <link rel="stylesheet" href="<?php echo $css; ?>rtl.css" />
              <?php } ?>

               <!-- Favicon -->
            <link rel="icon" href="<?php echo $img; ?>logo_d.png" type="image/x-icon">


     </head>
     <body onload="checkRefresh()">
      <!-- Preloader -->
      <!-- <div class="preloader d-flex align-items-center justify-content-center">
         <p class="round">
         <span class="ouro ouro3">
            <span class="left"><span class="anim"></span></span>
            <span class="right"><span class="anim"></span></span>
         </span>
         </p>
      </div> -->