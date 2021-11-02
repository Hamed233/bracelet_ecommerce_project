<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['message'])) {

		$to       = "zlkwt2020@gmail.com";
		$from     = $_POST['email'];
		$name     = $_POST['name'];
		$subject_f  = $_POST['subject'];
		$cmessage = $_POST['message'];

		$formErrors = array();

		// validate mail
		if (isset($email)) {

			$filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

			if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {
				$formErrors[] = 'This <b>Email</b> Not Valid';
			}

			if (empty($email)) {
				$formErrors[] = 'Field <b>Email</b> Is Required';
			}
		}
		
		// validate Customer name
		if (isset($name)) {

			$name = filter_var($name, FILTER_SANITIZE_STRING);

			if (strlen($name) < 3) {
				$formErrors[] = 'Name is very <b>short</b>';
			}

			if (strlen($name) > 30) {
				$formErrors[] = 'Name is very <b>long</b>';
			}

			if (empty($name)) {
				$formErrors [] = 'Field <b>Name</b> is Required';
			}
		}

		// validate Customer name
		if (isset($subject)) {

			$subject = filter_var($subject, FILTER_SANITIZE_STRING);

			if (strlen($subject) < 3) {
				$formErrors[] = 'Subject is very <b>short</b>';
			}

			if (strlen($name) > 40) {
				$formErrors[] = 'Subject is very <b>long</b>';
			}

			if (empty($subject)) {
				$formErrors [] = 'Field <b>Subject</b> is Required';
			}
		}

        // validate cmessage
		if (isset($cmessage)) {

			$cmessage = filter_var($cmessage, FILTER_SANITIZE_STRING);

			if (strlen($cmessage) < 10) {
				$formErrors[] = 'Message is very <b>short</b>';
			}

			if (strlen($cmessage) > 200) {
				$formErrors[] = 'Message is very <b>long</b>';
			}

			if (empty($cmessage)) {
				$formErrors [] = 'Field <b>Message</b> is Required';
			}
		}

		if(empty($formErrors)) {

			$headers = "From: $from";
			$headers = "From: " . $from . "\r\n";
			$headers .= "Reply-To: ". $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$subject = "You have a message from your website Zlkwt.com.";

			$logo = '../layout/images/logo_d.png';
			$link = 'https://zlkwt.com/';

			$output  = "<p>This email from:</p>";
			$output .= "<p>Email: <strong>{$from}</strong></p>";
			$output .= "<p>Name: <strong>{$name}</strong></p>";
			$output .= "<p><br>------------------------------<br></p>";
			$output .= "<p>Subject is: <strong>{$subject_f}</strong></p>";
			$output .= "<p><br>------------------------------<br></p>";
			$output .= "<p>Message is: <strong>{$cmessage}</strong></p>";

			
			$body = $output;

			$send = mail($to, $subject, $body, $headers);
			$_SESSION["done_send"] = ["type" => "success", "message" => '<p class="d-inline-block">Your message is send successfully.</p>'];

			header('Location: ../../../../contact-us.php');
		    exit();
		} else {
			echo "Something Errors";
		}
	}
}
?>
