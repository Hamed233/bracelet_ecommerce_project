<?php
/*
** =================================== **
**** 404 Not Found Page *****
** =================================== **
*/
  ob_start();
  $no_ads = ''; // for disable main navbar
  $pageTitle = '404 Not Found'; // Page Main Title
  include 'init.php'; // this file contain all info for config
 ?>

    <h1 class="not-found-h">404 Error Page</h1>
    <p class="zoom-area">Not Found This page!</p>
    <section class="error-container">
      <span class="four"><span class="screen-reader-text">4</span></span>
      <span class="zero"><span class="screen-reader-text">0</span></span>
      <span class="four"><span class="screen-reader-text">4</span></span>
    </section>
    <div class="link-container">
      <a target="_blank" href="index.php" class="more-link">Back Home</a>
    </div>

<?php
    include $temp . 'footer.php'; // Footer template
    ob_end_flush(); // Release The Output
 ?>