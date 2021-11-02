<?php

/*
===============================
   Contact Us Page
===============================
*/
   ob_start(); // OutPut Buffering Start
   $pageTitle = 'Contact Us';
   include 'init.php';
   ?>

<!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_2">
      <div class="container">
          <div class="row">
              <div class="col-xl-12">
                  <div class="bradcam_text">
                      <h3>Contact Us</h3>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--/ bradcam_area  -->

  <section class="contact-section section_padding">
   <div class="container">
  <?php 
    if (isset($_SESSION["done_send"])){
      vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fas d-inline-block fa-check-circle\"></i> %s</div>", $_SESSION["done_send"]);
      unset($_SESSION["done_send"]);
    } ?>
    <div class="row">
      <div class="col-12">
        <h2 class="contact-title">Send Message Now</h2>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <form class="form-contact contact_form" action="includes/actions/contact-process.php" method="POST" id="contactForm">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <input class="form-control" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder = "Enter your name" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input class="form-control" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder = "Enter email address" required>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder = "Enter Subject" required>
              </div>
            </div>
            <div class="col-12">
              <textarea name="message" class="form-control" cols="30" rows="10" placeholder="Message" required></textarea>
            </div>
          </div>
          <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Send Message</button>
          </div>
        </form>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 contact_right_section">
        <div class="media contact-info">
          <div class="media-body">
            <h3>WhatsApp: +00965 66111950</h3>
            <p>9am to 6pm</p>
          </div>
        </div>
        <div class="media contact-info">
          <div class="media-body">
            <h3>info@zlkwt.com</h3>
            <p>Send us anytime!</p>
          </div>
        </div>
        <hr />
        <h3 class="h3_contact">Z Letters Co.</h3>
        <p><i class="fas fa-globe"></i><span>www.zlkwt.com</span></p>
        <p><i class="fab fa-instagram"></i><span>z_letters</span></p>
        <p><i class="fas fa-phone"></i><span>00965 66111950</span></p>
      </div>
     </div>
   </div>
</section>

    <!-- start Our Social -->
    <div class="our-social">
      <h2 class="text-center header-social">Our Social Media</h2>
        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
    </div>

<?php
 include $temp . 'footer.php';
 ob_end_flush();
?>
