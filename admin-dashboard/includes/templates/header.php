<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php getTitle(); ?></title>

        <link rel="stylesheet" href="<?php echo $libr; ?>bootstrap/bootstrap.min.css" /><!-- Bootstrap-css -->
        <link rel="stylesheet" href="<?php echo $libr; ?>fontawesome/css/all.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>back-end.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <?php
          if (isset($_SESSION['lang'])) {
            if ($_SESSION['lang'] == 'ar') { ?>
            <link rel="stylesheet" href="<?php echo $css; ?>rtl.css" />
       <?php }
     }  ?>
     <link rel="shortcut icon" href="<?php echo $img; ?>f_logo.png" type="image/x-icon">

    </head>
    <body>
