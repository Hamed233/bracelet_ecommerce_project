<?php

/*
===============================
   Login & loginUp Page
===============================
*/
   ob_start(); // OutPut Buffering Start
   $pageTitle = 'Login';
   if (isset($_GET['do'])) {
     $pageTitle = $_GET['do']; // Page Main Title
   }
   $cats_nav = '';
   include 'init.php';

   if($_SERVER['REQUEST_METHOD'] == 'POST'){ //  Check If User Coming From HTTP Post Request

        if (isset($_POST['Signin'])) {

          $formErrors_s = array();

          $mail       = $_POST['email'];
          $pass       = $_POST['pass'];
          $hashedpass = sha1($pass);

          // validate form

          if (isset($mail)) {

              $filterEmail = filter_var($mail, FILTER_SANITIZE_EMAIL);

              if (filter_var($mail, FILTER_VALIDATE_EMAIL) != true) {
                  $formErrors_s[] = 'This <b>Email</b> not valid';
              }
           }

           if (empty($pass)) { $formErrors_s [] = 'Field <b>Password</b>is empty'; }
           if (strlen($pass < 6)) { $formErrors_s [] = 'Field <b>Password</b>is empty'; }

           if (empty($formErrors_s)) {

             $sql = $con->prepare("SELECT
                                        cus_id, cus_name,  cus_mail, cus_password, cus_avatar
                                    FROM
                                          customers
                                    WHERE
                                          cus_mail = ?
                                    AND
                                          cus_password = ?");

             $sql->execute(array($mail, $hashedpass));
             $info   = $sql->fetch();
             $count = $sql->rowCount();
             if ($count > 0) {
                 $_SESSION['customer'] = $info['cus_name'];      // Register Session Name
                 $_SESSION['cus_id']   = $info['cus_id'];  // Register User ID In Session
                 $_SESSION["success_login"] = ["type" => "success_login", "message" => $lang["Done, SignIn"]];
                 $_SESSION['cart'] = "cart";
                 if (isset($_POST['rememberme'])) {
                  setcookie ("cus_login", $mail, time() + (10 * 365 * 24 * 60 * 60));
                  setcookie ("cus_password", $hashedpass, time() + (10 * 365 * 24 * 60 * 60));
                } else {
                  if(isset($_COOKIE["member_login"])) {
                    setcookie ("cus_login","");
                  }
                }

               header('Location: index.php'); // Redirect To Index Page
               exit();
             } else {
               $formErrors_s [] = 'Sorry This Email Not Found Or Password Invalid';
             }
           }
          }
        }

   $do = isset($_GET['do']) ? $_GET['do'] : 'Signin';

   if ($do == 'Signin') { ?>
   <div class="limiter form-log">
 		<div class="container-login100">
 			<div class="wrap-login100">
 				<form class="login100-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <?php

            if (isset($_SESSION["success"])){
                vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fas fa-check-circle\"></i> %s</div>", $_SESSION["success"]);
                unset($_SESSION["success"]);
            }
           ?>

          <span class="login100-form-title p-b-43">
 					Signin
 					</span>


 					<div class="wrap-input100 validate-input">
 						<input class="input100" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
 						<span class="focus-input100"></span>
 						<span class="label-input100">Email</span>
 					</div>


 					<div class="wrap-input100 validate-input">
 						<input class="input100" type="password" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
 						<span class="focus-input100"></span>
 						<span class="label-input100">Password</span>
 					</div>

 					<div class="flex-sb-m w-full p-t-3 p-b-32 block_bottom">
 						<div class="contact100-form-checkbox check-rtl">
 							<input class="input-checkbox100" id="rememberme" type="checkbox" name="rememberme">
 							<label class="label-checkbox100" for="rememberme" name="rememberme" value="forever" <?php if(isset($_COOKIE["adm_login"])) { ?> checked <?php } ?>>
 								Remember me
 							</label>
 						</div>

 						<div class="forget-pass">
 							<a href="#" class="txt1">
 								Forget Password
 							</a>
 						</div>
 					</div>


 					<div class="container-login100-form-btn">
 						<button type="submit" class="login100-form-btn" name="Signin">
 							Signin
 						</button>
 					</div>

          <div class="singup-content">
              <p>I don't have Email! <span><a href="login.php?do=SignUp">SignUp</a></span></p>
          </div>

          <!-- This Is Loop Special To Show Errors [Filter] Field  -->
          <div class="errors text-center">
            <?php
                if (!empty($formErrors_s)) {
                    foreach ($formErrors_s as $error) {
                        echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle' style='padding: 10px;'></i>" . $error . "</div>";
                    }
                }
              ?>
          </div>
 				</form>

 			  	<div class="login100-more" style="background-image: url('<?php echo $img; ?>bg-01.jpg');">
 				</div>
 			</div>
 		</div>
 	</div>

<?php  } elseif ($do == 'SignUp') {

  if (isset($_POST['signup'])) {

     $formErrors_sign = array();

     $full_name     = $_POST['full_name'];
     $email         = $_POST['email'];
     $password      = sha1($_POST['pass']);
     $city          = $_POST['city'];
     $phone         = $_POST['phone'];

    // Img info
     $cusImg     = $_FILES['cus_img'];
     $cusImgName = $_FILES['cus_img']['name'];
     $cusImgSize = $_FILES['cus_img']['size'];
     $cusImgTmp  = $_FILES['cus_img']['tmp_name'];
     $cusImgType = $_FILES['cus_img']['type'];

    // List Odf Allowed File Typed To Upload

    $cusImgAllowedExtention = array("jpeg", "jpg", "png", "gif");

    // Get cusImg Extention

    $cusImgEtention = strtolower(end(explode('.', $cusImgName)));


         // validate Customer name
          if (isset($full_name)) {

              $full_name = filter_var($full_name, FILTER_SANITIZE_STRING);

              if (strlen($full_name) < 4) {
                  $formErrors_sign[] = 'Full Name is very <b>short</b>';
              }

              if (strlen($full_name) > 30) {
                  $formErrors_sign[] = 'Full Name is very <b>long</b>';
              }

              if (empty($full_name)) {
                $formErrors_sign [] = 'Field <b>Full name</b> is Required';
              }
          }

          // validate password
          if (isset($password)) {
              if (empty($password)) {
                  $formErrors_sign[] = '<b>Password</br> must be writing';
              }
          }

          // validate mail
          if (isset($email)) {

              $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

              if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {
                  $formErrors_sign[] = 'This <b>Email</b> Not Valid';
              }

              if (empty($email)) {
                  $formErrors_sign[] = 'Field <b>Email</b> Is Required';
              }
          }

          // validate phone
          if (isset($phone)) {
            if (strlen($phone) < 11) {
              $formErrors_sign[] = 'This <b>Phone</b> very short';
            }

            if (strlen($phone) > 13) {
              $formErrors_sign[] = 'This <b>Phone</b> very long';
            }

            if (!is_numeric($phone)) {
              $formErrors_sign[] = 'This <b>Phone</b> not valid';
            }

            if (empty($phone)) {
              $formErrors_sign[] = 'Field <b>Phone</b> is empty';
            }
          }

          // validate city

          if (empty($city)) {
            $formErrors_sign [] = 'Field <b>City</b> not valid';
          }

          if (strlen($city) > 20) {
            $formErrors_sign [] = '<b>City</b> is very long';
          } elseif (strlen($city) < 3) {
            $formErrors_sign [] = '<b>City</b> is very short';
          }

           // Validate image
           if (! empty($cusImgName) && ! in_array($cusImgEtention, $cusImgAllowedExtention)) { $formErrors[] = 'This Extention Is Not <strong> Allowed </strong>'; }
           if (empty($cusImgName)) { $formErrors[] = '<b>Image cusgory</b> is Required'; }
           if ($cusImgSize > 4194304) { $formErrors[] = 'This Image Can\'t Larger Than <strong> 4MB </strong>'; }


          // Check If There's No ERRORS Proceed The User Add
         if (empty($formErrors_sign)) {

             // Check If User Exist In Database

           $check = checkItem("cus_mail", "customers", $email); // check if mail is exist or not

             if ($check == 1) {
                 $formErrors_sign[] = 'Sorry this <b>Email</b> is exist';
             } else {

               // Image New Name
               $cusImg = rand(0, 1000000) . '_' . $cusImgName;
               // move image to front-area
               move_uploaded_file($cusImgTmp, "upload\customers\\" . $cusImg);

               $tmp='upload/customers/'. $cusImg;
               $new = '../admin-dashboard/upload/customers/'. $cusImg;
               $cpy = copy($tmp, $new);
               move_uploaded_file($cusImgTmp, $cpy); // move image to dashboard-area

                      // Insert UserInfo In DB

                 $sql = $con->prepare("INSERT INTO
                                     customers(cus_name, cus_mail, cus_password, cus_phone, cus_city, cus_avatar, cus_enter_date)
                                     VALUES(:user, :zmail, :zpass, :phone, :city, :avatar, now())");
                 $sql->execute(array (
                     'user'      => $full_name,
                     'zmail'     => $email,
                     'zpass'     => $password,
                     'phone'     => $phone,
                     'city'      => $city,
                     'avatar'    => $cusImg
                 ));
                   // echo success Msg
                  $_SESSION["success"] = ["type" => "success", "message" => $lang["Congratz!! Signin Now"]];
                  header('Location: login.php');
                  exit();
               } // end check exist
          }
       }
?>

  <div class="limiter form-log">
   <div class="container-login100">
     <div class="wrap-login100">
       <form class="login100-form" action="?do=SignUp" method="post" enctype="multipart/form-data">
         <span class="login100-form-title p-b-43">
           SignUp
         </span>


         <div class="wrap-input100">
           <input class="input100" type="text" name="full_name" value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : ''; ?>" required>
           <span class="focus-input100"></span>
           <span class="label-input100">Full name</span>
         </div>

         <div class="wrap-input100">
           <input class="input100" type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
           <span class="focus-input100"></span>
           <span class="label-input100">Email</span>
         </div>

         <div class="wrap-input100">
           <input id="psw" class="input100" type="password" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
           <span class="focus-input100"></span>
           <span class="label-input100">Password</span>
         </div>

         <div id="message">
          <h5>Password must contain the following:</h5>
          <p id="letter" class="invalid">A lowercase letter</p>
          <p id="capital" class="invalid">A capital (uppercase) letter</p>
          <p id="number" class="invalid">A number</p>
          <p id="length" class="invalid">Minimum 8 characters</p>
        </div>

         <div class="wrap-input100">
           <input class="input100" type="text" name="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>" required>
           <span class="focus-input100"></span>
           <span class="label-input100">City</span>
         </div>

         <div class="wrap-input100">
           <input class="input100" type="tel" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
           <span class="focus-input100"></span>
           <span class="label-input100">Phone</span>
         </div>

         <div class="wrap-input100">
           <input class="input100 custom-file-input" type="file" name="cus_img" required>
           <span class="focus-input100"></span>
           <span class="label-input100">avatar</span>
         </div>

         <div class="container-login100-form-btn">
           <button type="submit" class="login100-form-btn" name="signup">
             SignUp
           </button>
         </div>

         <div class="singup-content">
             <p>I have Email! <span><a href="login.php?do=Signin">Signin</a></span></p>
         </div>

         <!-- This Is Loop Special To Show Errors [Filter] Field  -->
         <div class="errors text-center">
           <?php
               if (!empty($formErrors_sign)) {
                   foreach ($formErrors_sign as $error) {
                       echo "<div class='alert alert-danger text_alert'>" . $error . "</div>";
                   }
               }

             ?>
         </div>
       </form>

       <div class="login100-more" style="background-image: url('<?php echo $img; ?>bg-01.jpg');">
       </div>
     </div>
   </div>
 </div>

   <?php } elseif ($do == 'resetpassword') {
            $errors = array();
            if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["do"]) && ($_GET["do"] == "resetpassword") && !isset($_POST["do"])){

              $_SESSION['mail'] = $_GET["email"];
              $key   = $_GET["key"];
              $email = $_GET["email"];
              $curDate = date("Y-m-d H:i:s");
              $query = $con->prepare("SELECT * FROM `password_reset` WHERE `p_key`= ? AND `email`= ?");
              $query->execute(array($key, $email));
              $row = $query->rowCount();
              $field = $query->fetch();
              if ($row == 0){
                echo '<div class="container invalid_link text-center"><h2 class="text-center">Invalid Link</h2>
                <p class="text-center">The link is invalid/expired. Either you did not copy the correct link
                from the email, or you have already used the key in which case it is 
                deactivated.</p>
                <p><a href="https://www.zlkwt.com/login.php?do=lostpassword">
                Click here</a> to reset password.</p></div>';
            } else {
              $expDate = $field['expDate'];
              if ($expDate >= $curDate){ ?>
              <br />
              <div class="container">
                <div class="login_content">
                  <div class="logo_website">
                    <img src="<?php echo $img;?>f_logo.png" alt="logo image" />
                  </div>
                  <?php 
                    if (isset($_SESSION["wrongpass"])){
                      vprintf("<div class='alert alert-danger text-center success %s'> <i class=\"fas fa-check-circle\"></i> %s</div>", $_SESSION["wrongpass"]);
                      unset($_SESSION["wrongpass"]);
                    } ?>
                <form class="login" action="?do=resetpassword" method="POST" name="update">
                  <div class="form-content">
                    <h4 class="text-center">Reset Password</h4>
                    <label for="psw">Enter New Password:</label>
                    <input id="psw" class = "form-control" type="password" name="pass1" maxlength="15" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
                                
                    <div id="message">
                      <h5>Password must contain the following:</h5>
                      <p id="letter" class="invalid">A lowercase letter</p>
                      <p id="capital" class="invalid">A capital (uppercase) letter</p>
                      <p id="number" class="invalid">A number</p>
                      <p id="length" class="invalid">Minimum 8 characters</p>
                    </div>

                    <label for="pass2">Re-Enter New Password:</label>
                    <input id="pass2" class = "form-control" type="password" name="pass2" maxlength="15" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
                    <input class ="btn btn-danger btn-block" type="submit" value="Reset Password" name ="submit" />
                  </div>
                </form>
                <?php if (!empty($errors)) { ?>
                  <div class="form_r_err">
                    <div class="error-content">
                    <?php foreach ($errors as $err) {
                          echo $err;
                      } ?>
                  </div>
                </div>
              <?php } ?>
              </div>
            </div>
            <?php
             } else {
              $errors [] = "<h2>Link Expired</h2>
              <p>The link is expired. You are trying to use the expired link which 
              as valid only 24 hours (1 days after request).<br /><br /></p>";
             }
            }
          
          } // isset email key validate end
            
            
          if(isset($_POST["pass1"]) && isset($_POST["pass2"]) && ($_GET["do"] == "resetpassword")){
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];
            $email = $_SESSION['mail'];
            $curDate = date("Y-m-d H:i:s");
            if ($pass1 != $pass2){
              $_SESSION["wrongpass"] = ["type" => "success", "message" => '<p>Password do not match, both password should be same.<br /><br /></p>'];
              $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
              header("Location: $actual_link");
              exit();
            } else {
              $pass1 = md5($pass1);
              // Insert Temp Table
              $stmt = $con->prepare("UPDATE `customers` SET `cus_password` = ? WHERE cus_mail = ?");
              $stmt->execute(array($pass1, $email));

              $stmt2 = $con->prepare("DELETE FROM `password_reset` WHERE `email` = :mail");
              $stmt2->bindparam(":mail", $email);
              $stmt2->execute();

              $_SESSION["success"] = ["type" => "success", "message" => $lang["Congratulations! Your password has been updated successfully."]];
              unset($_SESSION['mail']);
              header('Location: index.php');
              exit();
            }
        }
      
      ?>

 <?php } else {
   header("Location: index.php");
   exit();
 }
 ?>

 <?php
   include $temp . 'footer.php';
   ob_end_flush();
?>
