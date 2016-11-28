<?php

// Include required library files.
require_once($_SERVER['DOCUMENT_ROOT'] . 'db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php');
$host_split = explode('.', $_SERVER['HTTP_HOST']);
$sandbox = $host_split[0] == 'sandbox' && $host_split[1] == 'domain' ? TRUE : FALSE;
$ppUsername = "xjordon11x-facilitator_api1.gmail.com";
$ppPassword = "V9JQ7G7YTLUBJ2MW";
$ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
$ppaAppId = "APP-80W284485P519543T";
// Create PayPal object.
$PayPalConfig = array(
    'DeveloperAccountEmail' => 'xjordon11x@gmail.com',
    'ApplicationID' => 'APP-80W284485P519543T',
    'IPAddress' => $_SERVER['REMOTE_ADDR'],
    'APIUsername' => $ppUsername,
    'APIPassword' => $ppPassword,
    'APISignature' => $ppSignature,
    'PrintHeaders' => false
);

$PayPal = new angelleye\PayPal\Adaptive($PayPalConfig);

// Prepare request arrays
$GetVerifiedStatusFields = array(
    'EmailAddress' => $_POST['email'], // Required.  The email address of the PayPal account holder.
    'FirstName' => $_POST['fname'], // The first name of the PayPal account holder.  Required if MatchCriteria is NAME
    'LastName' => $_POST['lname'], // The last name of the PayPal account holder.  Required if MatchCriteria is NAME
    'MatchCriteria' => 'NAME'     // Required.  The criteria must be matched in addition to EmailAddress.  Currently, only NAME is supported.  Values:  NAME, NONE   To use NONE you have to be granted advanced permissions
);

$PayPalRequestData = array('GetVerifiedStatusFields' => $GetVerifiedStatusFields);

// Pass data into class for processing with PayPal and load the response array into $PayPalResult
$PayPalResult = $PayPal->GetVerifiedStatus($PayPalRequestData);

// Write the contents of the response array to the screen for demo purposes.
if ($PayPalResult['Ack'] == 'Success') {

    $_SESSION['pp_email'] = $_POST['email'];
    $_SESSION['pp_fname'] = $_POST['fname'];
    $_SESSION['pp_lname'] = $_POST['lname'];
}
echo ($PayPalResult['Ack']);
?>