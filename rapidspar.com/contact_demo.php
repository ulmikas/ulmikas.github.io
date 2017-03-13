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
    
    $name    = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $company    = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
    $user_email    = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone   	= filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address   	= filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $address2   	= filter_var($_POST["address2"], FILTER_SANITIZE_STRING);
    $city   	= filter_var($_POST["city"], FILTER_SANITIZE_STRING);
    $state   	= filter_var($_POST["state"], FILTER_SANITIZE_STRING);
    $postalcode   	= filter_var($_POST["postalcode"], FILTER_SANITIZE_STRING);
    $country   	= filter_var($_POST["country"], FILTER_SANITIZE_STRING);

    $software   	= filter_var($_POST["software"], FILTER_SANITIZE_STRING);
    $hardware   	= filter_var($_POST["hardware"], FILTER_SANITIZE_STRING);
    $drives   	= filter_var($_POST["drives"], FILTER_SANITIZE_STRING);
    $website   	= filter_var($_POST["website"], FILTER_SANITIZE_STRING);
    $twitter   	= filter_var($_POST["twitter"], FILTER_SANITIZE_STRING);
//    $username   	= filter_var($_POST["username"], FILTER_SANITIZE_STRING);

    $ADDRESS 	= $_SERVER['REMOTE_ADDR'];
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
      /*
    if(strlen($message)<3){ //check emtpy message
        $output = json_encode(array('type'=>'error', 'text' => 'Message is too short! Please enter something.'));
        die($output);
    }*/
    
    //email body
   // $message_body = $message."\r\n\r\n-".$user_name."\r\nEmail : ".$user_email."\r\nCountry : ".$country."\r\nCompany : ".$company."\r\nPhone Number : ". $phone_number ;
	$message_body = "NAME: $name \r\n";
	$message_body .= "COMPANY: $company \r\n"; 
	$message_body .= "EMAIL: $user_email \r\n";
	$message_body .= "PHONE: $phone \r\n";
	$message_body .= "ADDRESS: $address \r\n"; 
	$message_body .= "ADDRESS2: $address2 \r\n"; 
	$message_body .= "CITY: $city \r\n"; 
	$message_body .= "STATE: $state \r\n"; 
	$message_body .= "POSTAL CODe: $postalcode \r\n"; 
	$message_body .= "COUNTRY: $country\r\n";


	$message_body .= "Software data recovery tools: $software \r\n"; 
	$message_body .= "Hardware data recovery tools: $hardware \r\n\r\n";
	$message_body .= "Problematic drives in 1 week:\r\n$drives \r\n\r\n";
	$message_body .= "Company’s website:\r\n$website \r\n\r\n";
	$message_body .= "Twitter handle:\r\n$twitter \r\n\r\n";
//	$message_body .= "Technibble forum username:\r\n$username \r\n\r\n";
	
	
	$message_body .= "ADDRESS: $ADDRESS\r\nHOST: $HOST ";
	
    //proceed with PHP email.
    $headers = 'From: '.$user_email.'' . "\r\n" .
    'Reply-To: '.$user_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $send_mail = mail($to_email, "Rapidspar Demo Program Sign-up", $message_body, $headers);
	//authgMail($user_name, $user_email, $to_email, "Rapidspar Contact Us", $strSubject, $message_body);
	
    
   if(!$send_mail)
    {
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
    }else{
	$str = "Thank you for applying to our demo program! Here's what's going to happen next:<div class='list star col-md-11 col-sm-11 col-xs-11 col-md-offset-1 col-sm-offset-1 col-xs-offset-1'>";
	$str .= "<span> Your application will be reviewed and if you fit the criteria defined in <a href='http://rapidspar.com/demoterms.html'>terms and conditions</a>, you will be placed in the queue of our demo program participants.</span>";
	$str .= "<span> About a week before your turn you will receive a call from one of our team members to confirm your availability and shipping address.</span>"; 
	$str .= "<span> Your shipping information will be forwarded to another participant who will ship you their RapidSpar demo unit.</span>"; 
	$str .= "<span> Once it's shipped, you will receive an email with the tracking number and activation information.</span>"; 
	$str .= "<span> When you receive the unit, you will have to run rsasetup.exe to install the software. If this file isn't on the RapidSpar device anymore (deleted by previous participant), you can download it <a href='http://portal.rapidspar.com/portal/downloads/rsaSetup.exe'>here</a>.</span>"; 
	$str .= "<span> Please contact us by phone (613-225-6771) or email (<a href='mailto:support@deepspar.com'>support@deepspar.com</a>) if you run into any issues. </span>"; 
	$str .= "</div><br>We are looking forward to working with you!"; 
        $output = json_encode(array('type'=>'message', 'text' => $str));
        die($output);
    }

}
?>