


    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="col-3 for-phone">
            <h3><?php echo $lang['categories']; ?></h3>
            <ul>
              <?php
                $cats = getAllFrom("*", "categories", "WHERE active = 0", "", "c_id", "Limit 5");
                foreach($cats as $cat) { ?>
                  <li><a href="categories.php?catname=<?php echo preg_replace('/\s+|&/', '%', $cat['c_name']) . '&catid=' . $cat['c_id'] . '&action=getcategoryinfo'; ?>"><?php echo $cat['c_name']; ?></a></li>
          <?php } ?>
            </ul>
          </div>
          <div class="col-3 contact for-phone ">
            <h3>Z Letters Co.</h3>
            <p><i class="fas fa-globe"></i><span>www.zlkwt.com</span></p>
            <p><i class="fab fa-instagram"></i><span>z_letters</span></p>
            <p><i class="fas fa-phone"></i><span>00965 66111950</span></p>
          </div>
          <div class="col-3 text-center for-phone social-footer">
            <h3><?php echo $lang['Social Media']; ?></h3>
            <ul class="social">
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-facebook"></i></a></li>
              <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
            <?php if (!isset($_SESSION['customer'])) { ?>
            <hr />
            <div class="emailSubscribeContainer col-sm-12 col-xs-6 col-xxs-12 text-center d-phone">
							<h4 class="footerEmailTitle">SUBSCRIBE NOW<br>
								<span class="subTitle">GET EXCLUSIVE PROMOS &amp; DEALS</span>
							</h4>
							<a class="footerSubscribeBtn btn-lg btn btn-dark lite" href="login.php?do=SignUp">Sign Up Now</a>
            </div>
            <?php } ?>
          </div>

          <div class="col-3 for-phone useful-links">
            <h3><?php echo $lang['Useful Links']; ?></h3>
            <ul class="useful-link">
              <li><a href="about.php">About Us</a></li>
              <li><a href="contact-us.php">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <p class="copy">All Copyright &copy; <?php echo date('Y'); ?> zlkwt <i class="fas fa-heart fa-fw" aria-hidden="true"></i> Made By Hamed Essam.</p>
      </div>
      <!-- / container -->
    </footer>
    <!-- / footer -->

        <script>
          addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
          }, false);

          function hideURLbar() {
            window.scrollTo(0, 1);
          }
        </script>
        <script src="<?php echo $libr; ?>jq/jquery-3.3.1.min.js"></script><!-- Jquery Library -->
        <script src="<?php echo $js; ?>jquery-ui.js"></script>
        <script src="<?php echo $js; ?>popper.min.js"></script><!-- Popper js -->
        <script src="<?php echo $libr; ?>bootstrap/bootstrap.min.js"></script> <!-- v4.0 -->
        <script src="<?php echo $js; ?>owl.carousel.min.js"></script><!-- Owl Carousel js -->
        <script src="<?php echo $js; ?>classynav.js"></script><!-- Classynav -->
        <script src="<?php echo $js; ?>jquery.sticky.js"></script><!-- Sticky js -->
        <script src="<?php echo $js; ?>intersectionObserver.js"></script>
        <script src="<?php echo $js; ?>jquery.scrollup.min.js"></script><!-- Scrollup js -->
        <script src="<?php echo $js; ?>ajax.js"></script><!-- Ajax File -->
        <script src="<?php echo $js; ?>jquery.js"></script><!-- Jquery File -->
        <script src="<?php echo $js; ?>main.js"></script><!-- Javascript File -->

        <script>
      		jQuery(document).ready(function ($) {
      			$(".scroll").click(function (event) {
      				event.preventDefault();

      				$('html,body').animate({
      					scrollTop: $(this.hash).offset().top
      				}, 1000);
      			});
      		});
        </script>
    </body>
</html>
