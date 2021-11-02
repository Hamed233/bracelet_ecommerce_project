<?php
/*
============================
== index page ['login admin']
============================
*/
ob_start();
if (isset($_GET['action'])) {
  if($_GET['action'] == 'lostpassword') {
    $pageTitle ='Reset Password';  // Page title
  } else {
    $pageTitle ='Login Admin';  // Page title
  }
} else {
  $pageTitle ='Login Admin';  // Page title
}

include "init.php";         // initialize file

// check if admin register or not by adm_name Session.
if (isset($_SESSION['ID'])) { 
  header('Location: dashboard.php'); 
  exit();
}

/* ========== Recieve information & check if information true & existed or not =========== */

if($_SERVER['REQUEST_METHOD'] == 'POST'){ //  Check If User Coming From HTTP Post Request

  if (isset($_POST['login'])) {
    $adm_name_or_mail   = $_POST['adm_name_or_mail'];
    $password           = $_POST['pass'];
    $hashedPass         = md5($password);


    $sql = $con->prepare("SELECT adm_id, adm_name, adm_mail, adm_password, adm_avatar FROM admins WHERE adm_name = ? OR adm_mail = ? AND adm_password = ? LIMIT 1");
    $sql->execute(array($adm_name_or_mail, $adm_name_or_mail, $hashedPass));
    $row = $sql->fetch();
    $count = $sql->rowCount();

   // If count > 0 This Mean The Database Contain Record About This Username
   if($count > 0) {
      if ($adm_name_or_mail == $row['adm_name']) {
        $_SESSION['adm_name'] = $row['adm_name'];     // Register admin Session username
      } elseif ($adm_name_or_mail == $row['adm_mail']) {
        $_SESSION['adm_mail'] = $row['adm_mail'];     // Register admin Session mail
      }
       $_SESSION['ID'] = $row['adm_id'];   // Register Session ID
       $_SESSION['avatar'] = $row['adm_avatar'];

      if (isset($_POST['rememberme'])) {
       setcookie ("adm_login", $adm_name_or_mail, time() + (10 * 365 * 24 * 60 * 60));
       setcookie ("adm_password", $password, time() + (10 * 365 * 24 * 60 * 60));
     } else {
       if(isset($_COOKIE["member_login"])) {
         setcookie ("adm_login","");
       }
     }

       header('Location: dashboard.php');  // Redirect To Dashboard page
       exit();
   } else {

     $err = '<div class="alert alert-danger text-center">' . $lang['Not Found This Mail'] . '</div>';

   }
  }
}
  

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

if ($action == 'login') { ?>

  <div class="container">
    <div class="login_content">
      <div class="logo_website">
        <img src="<?php echo $img;?>f_logo.png" alt="logo image" />
      </div>
     <form class="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
     <?php
        if (isset($_SESSION["success"])){
            vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fas fa-check-circle\"></i> %s</div>", $_SESSION["success"]);
            unset($_SESSION["success"]);
        }
      ?>
       <div class="form-content">
         <h4 class="text-center"><?php echo $lang['Admin Login']; ?></h4>
         <label for="adm_name_mail"><?php echo $lang['Username'] . " | " . $lang['Email']; ?></label>
         <input class = "form-control" type="text" id="adm_name_mail" name="adm_name_or_mail" value="<?php echo isset($_POST['adm_name_or_mail']) ? $_POST['adm_name_or_mail'] : ''; ?>" placeholder="<?php echo $lang['Username'] . " | " . $lang['Email']; ?>" autocomplete="off" required />
         <label for="pass"><?php echo $lang['password']; ?></label>
         <input class = "form-control" type="password" id="pass" name="pass" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" placeholder="<?php echo $lang['password']; ?>" autocomplete="new-password" required />
         <div class="rememberme">
           <input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php if(isset($_COOKIE["adm_login"])) { ?> checked <?php } ?>>
           <label for="rememberme"><?php echo $lang['rememberme']; ?></label>
         </div>
         <input class ="btn btn-danger btn-block" type="submit" name="login" value="<?php echo $lang['Login']; ?>" name ="submit" />
         <div class="reset_pass">
           <div><a href="index.php?action=lostpassword"><?php echo $lang['Are you foreget password?']; ?></a><div>
         </div>
         <div class="form_errs">
           <?php if (isset($err)) { echo $err; } ?>
         </div>
       </div>
     </form>
   </div>
  </div>

<?php } elseif ($action == 'lostpassword') {
    // lost pass
    if (isset($_POST["mail"]) && (!empty($_POST["mail"]))) {
      $formErr = array();
      $email = $_POST["mail"];
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      if (!$email) {
         $formErr[] = "<div class='alert alert-danger'>Invalid email address please type a valid email address!</div>";
      } else {
         $sel_query = $con->prepare("SELECT * FROM `admins` WHERE adm_mail= ?");
         $sel_query->execute(array($email));
         $row = $sel_query->rowCount();

         if ($row == "") {
           $formErr[] = "<div class='alert alert-danger'>No user is registered with this email address!</div>";
         }
      }

         if (empty($formErr)) {
          $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
          );
          $expDate = date("Y-m-d H:i:s", $expFormat);
          $key = md5(2418*2+$email);
          $addKey = substr(md5(uniqid(rand(),1)),3,10);
          $key = $key . $addKey;

            // Insert Temp Table
            $stmt = $con->prepare("INSERT INTO `password_reset` (`email`, `p_key`, `expDate`)
            VALUES ('".$email."', '".$key."', '".$expDate."')");
            $stmt->execute();

            $output='<p>Dear user,</p>';
            $output.='<p>Please click on the following link to reset your password.</p>';
            $output.='<p>--------------------------------</p>';
            $output.='<p><a href="https://www.zlkwt.com/admin-dashboard/index.php?key='.$key.'&email='.$email.'&action=resetpassword" target="_blank">
            https://www.zlkwt.com/admin-dashboard/index.php?key='.$key.'&email='.$email.'&action=resetpassword</a></p>';

            $output.='<p>--------------------------------</p>';
            $output.='<p>Please be sure to copy the entire link into your browser.
            The link will expire after 1 day for security reason.</p>';
            $output.='<p>If you did not request this forgotten password email, no action
            is needed, your password will not be reset. However, you may want to log into
            your account and change your security password as someone may have guessed it.</p>';
            $output.='<p>Thanks,</p>';
            $output.='<p>zlkwt Team</p>';
            $body = $output;
            $headers = "From: $email";
            $headers .= "Reply-To: ". $email . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Password Recovery - zlkwt.com";
            $to = $email;

            $send = mail($to, $subject, $body, $headers);
            if(!$send){
              $formErr[] = "<div class='alert alert-danger'>Something Wrong!</div>";
            } else {
              $formErr[] = "<div class='alert alert-success'>An email has been sent to you with instructions on how to reset your password.</div>";
            }
      } 
    } ?>

  <div class="container">
    <div class="login_content">
      <div class="logo_website">
        <img src="<?php echo $img;?>f_logo.png" alt="logo image" />
      </div>
      <div class="alert alert-success"><?php echo $lang['Please enter your username or e-mail address. You will receive an email with instructions on how to reset your password.']; ?></div>
     <form class="login" action="?action=lostpassword" method="POST">
       <div class="form-content">
         <h4 class="text-center"><?php echo $lang['Reset Password']; ?></h4>
         <label for="mail"><?php echo $lang['Email']; ?></label>
         <input class = "form-control" type="text" id="mail" name="mail" placeholder="username@yourwebsite.com" autocomplete="off" required />
         <input class ="btn btn-danger btn-block" type="submit" value="<?php echo $lang['Reset Password']; ?>" name ="submit" />
         <div class="login_log">
           <div><a href="index.php?action=login"><?php echo $lang['Login']; ?></a></div>
         </div>
       </div>
     </form>
     <?php if (!empty($formErr)) { ?>
      <div class="form_r_err">
        <div class="error-content">
        <?php foreach ($formErr as $err) {
              echo $err;
          } ?>
      </div>
    </div>
   <?php } ?>
   </div>
  </div>
  <?php } elseif ($action == 'resetpassword') {
                    if (isset($_SESSION["wrongpass"])){
                        vprintf("<div class='alert alert-success text-center success %s'> <i class=\"fas fa-check-circle\"></i> %s</div>", $_SESSION["wrongpass"]);
                        unset($_SESSION["wrongpass"]);
                    }
                  
            $errors = array();
            if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "resetpassword") && !isset($_POST["action"])){

              $key   = $_GET["key"];
              $email = $_GET["email"];
              $curDate = date("Y-m-d H:i:s");
              $query = $con->prepare("SELECT * FROM `password_reset` WHERE `p_key`= ? AND `email`= ?");
              $query->execute(array($key, $email));
              $row = $query->rowCount();
              $field = $query->fetch();
              if ($row == 0){
                echo '<h2>Invalid Link</h2>
                <p>The link is invalid/expired. Either you did not copy the correct link
                from the email, or you have already used the key in which case it is 
                deactivated.</p>
                <p><a href="https://www.zlkwt.com/admin-dashboard/index.php?action=lostpassword">
                Click here</a> to reset password.</p>';
            } else {
              $expDate = $field['expDate'];
              if ($expDate >= $curDate){ ?>
              <br />
              <div class="container">
                <div class="login_content">
                  <div class="logo_website">
                    <img src="<?php echo $img;?>f_logo.png" alt="logo image" />
                  </div>
                <form class="login" action="?action=resetpassword" method="POST" name="update">
                 <input type="hidden" name="action" value="update" />
                  <div class="form-content">
                    <h4 class="text-center"><?php echo $lang['Reset Password']; ?></h4>
                    <label for="pass1">Enter New Password:</label>
                    <input id="pass1" class = "form-control" type="password" name="pass1" maxlength="15" required />
                    <label for="pass2">Re-Enter New Password:</label>
                    <input id="pass2" class = "form-control" type="password" name="pass2" maxlength="15" required />
                    <input class ="btn btn-danger btn-block" type="submit" value="<?php echo $lang['Reset Password']; ?>" name ="submit" />
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
            
            
          if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "resetpassword")){
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];
            $email = $_POST["email"];
            $curDate = date("Y-m-d H:i:s");
            if ($pass1 != $pass2){
              $_SESSION["wrongpass"] = ["type" => "success", "message" => '<p>Password do not match, both password should be same.<br /><br /></p>'];
            }
              
            if(empty($errors)){
              $pass1 = md5($pass1);
              // Insert Temp Table
              $stmt = $con->prepare("UPDATE `admins` SET `adm_password` = ? WHERE adm_mail = ?");
              $stmt->execute(array($pass1, $email));

            $stmt2 = $con->prepare("DELETE FROM `password_reset` WHERE `email` = :mail");
            $stmt2->bindparam(":mail", $email);
            $stmt2->execute();

            $_SESSION["success"] = ["type" => "success", "message" => $lang["Congratulations! Your password has been updated successfully."]];
            
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
     // Include Footer page
    include $tpl . 'footer.php';
    ob_end_flush();
?>