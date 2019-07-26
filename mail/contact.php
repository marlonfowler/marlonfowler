<?php

/* Email Variables */
$emailSubject = 'You have received an inquiry from your website';
$webMaster = 'marlonfowler@yahoo.com';

/* Data Variables */
$first = Trim(stripslashes($_POST['First']));
$last = Trim(stripslashes($_POST['Last']));
$email = Trim(stripslashes($_POST['E-Mail']));
$message = Trim(stripslashes($_POST['Message']));
$tempt = $_POST['tempt'];
$tempt2 = $_POST['tempt2'];

if ($tempt == 'http://' && empty($tempt2)) {
	
	$error_message = '';
	$reg_exp = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9­-]+\.[a-zA-Z.]{2,5}$/";
	
	if(!preg_match($reg_exp, $email)) {
		
		$error_message .= "<p>A valid email address is required.</p>";
	}
	if (empty($first)) {
		$error_message .= "<p>Please provide your first name.</p>";
	}
	if (empty($last)) {
		$error_message .= "<p>Please provide your last name.</p>";
	}
	if (empty($message)) {
		$error_message .= "<p>You cannot send the form without any comments.</p>";
	}
	
	if (!empty($error_message)) {
		
		$return['error'] = true;
		$return['msg'] = "<p>The form was not filled out correctly.</p>".$error_message;
		echo json_encode($return);
		exit();
		
	} else {
		
		$return['error'] = false;
		$return['msg'] = "<p style='top:8px; color:#ff6000; left:75px; text-align:left; font-size:1.50em;'>".$first .", <p style='top:14px; width:75%; left:75px; text-align:left; line-height:1.2em;'>thank you for taking the time to contact me.
I will respond shortly.</p>";
		echo json_encode($return);
	}
	
} else {
	
		$return['error'] = true;
		$return['msg'] = "<p>There was a problem while sending this form. Try it again.</p>";
		echo json_encode($return);
}
	
	

	$body = <<<EOD
<span style="color:#454545; font-weight:bold; font-size:1.6em;">$first</span><br>

<span style="color:#454545; font-weight:bold; font-size:1.6em;">$last</span><br>

<span style="color:#454545; font-weight:bold; font-size:1.6em;">$email</span><br>
<br>
<span style="color:#252525; font-size:1.4em;">$message</span><br>
EOD;
	$headers = "From: $email\r\n";
	$headers .= "Content-type: text/html\r\n";
	$success = mail($webMaster, $emailSubject, $body,
$headers);

?>