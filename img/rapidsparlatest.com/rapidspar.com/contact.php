<?php

if($_POST)
{
    $to_email       = "infors@deepspar.com"; //Recipient email, Replace with own email here

    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

        $output = json_encode(array( //create JSON data
            'type'=>'error',
            'text' => 'Sorry Request must be Ajax POST'
        ));
        die($output); //exit script outputting json data
    }

    //Sanitize input data using PHP filter_var().
    $user_name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $user_email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $country   		= filter_var($_POST["country"], FILTER_SANITIZE_STRING);
    $phone   		= filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $company        = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
    $message        = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
	$iheard        	= filter_var($_POST["iheard"], FILTER_SANITIZE_STRING);
    $ADDRESS = $_SERVER['REMOTE_ADDR'];
	$HOST = gethostbyaddr($ADDRESS);

    //additional php validation
   /* if(strlen($user_name)<2){ // If length is less than 4 it will output JSON error.
        $output = json_encode(array('type'=>'error', 'text' => 'Is your name really so short!'));
        die($output);
    }*/
    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
        $output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
        die($output);
    }

    if(strlen($message)<3){ //check emtpy message
        $output = json_encode(array('type'=>'error', 'text' => 'Message is too short! Please enter something.'));
        die($output);
    }

    //email body
   // $message_body = $message."\r\n\r\n-".$user_name."\r\nEmail : ".$user_email."\r\nCountry : ".$country."\r\nCompany : ".$company."\r\nPhone Number : ". $phone_number ;
    $message_body = "NAME: $user_name \r\n";
	$message_body .= "EMAIL: $user_email \r\n";
	$message_body .= "PHONE: $phone \r\n";
	$message_body .= "COMPANY: $company \r\n";
	$message_body .= "COUNTRY: $country\r\n";
	$message_body .= "HEARD FROM: $iheard \r\n\r\n";
	$message_body .= "MESSAGE:\r\n$message \r\n\r\n";
	$message_body .= "ADDRESS: $ADDRESS\r\nHOST: $HOST ";

    //proceed with PHP email.
    $headers = 'From: '.$user_email.'' . "\r\n" .
    'Reply-To: '.$user_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $send_mail = mail($to_email, "Rapidspar Contact Us", $message_body, $headers);
	//authgMail($user_name, $user_email, $to_email, "Rapidspar Contact Us", $strSubject, $message_body);

    if(!$send_mail)
    {
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Thank you for your interest, '.$user_name.'! <br>One of our representatives will be in touch shortly!'));
        die($output);
    }

}
?>
