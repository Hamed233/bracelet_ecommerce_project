<?php

/*
===============================
   About Us Page
===============================
*/
   ob_start(); // OutPut Buffering Start
   $pageTitle = 'Contact Us';
   include 'init.php';
 ?>

      <!-- bradcam_area  -->
      <div class="bradcam_bg_2 about_us"></div>
    <!--/ bradcam_area  -->

  <!-- about_area_start  -->
   <div class="container">
    <div class="about-us-content">
       <div class="row">
           <div class="col-12">
               <div class="content-section">
                   <h2 class="com_brief"><?php echo $lang['Company brief']; ?></h2>
                   <div class="text-content-1">
                     <p><?php echo $lang['content_text']; ?></p>
                   </div>
                   <hr />
                   <h2><?php echo $lang['Our slogan']; ?></h2>
                   <div class="text-content-2">
                     <p><?php echo $lang['content_text_2']; ?></p>
                   </div>
               </div>
           </div>
       </div>
    </div>
</div>

<?php
  include $temp . 'footer.php';
  ob_end_flush();
?>
