<?php

include_once(__DIR__ . "\paypal.class.php");
include $_SERVER['DOCUMENT_ROOT'] . 'db.php';

#$username = "jordon";
#$password = "Aryahij11!";
#$database = "db_1";
#$link = mysql_connect('127.0.0.1:3306', $username, $password);
#if (!$link) {
#    die("could not connect" . mysql_error());
#}
#mysql_select_db($database);
include $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
#require '../vendor/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsItemType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\SellerDetailsType;
use PayPal\EBLBaseComponents\AddressType;

//PPHttpConfig::$DEFAULT_CURL_OPTS[CURLOPT_SSLVERSION] = 4;

if(isset($_POST["no"])){
    header('Location:/sell/createpage.php');
    $_SESSION['premium']=0;
}
$logger = "";
if (!isset($_GET["token"])) {
   $iID = $_SESSION['iID'];
//$price=15;
//$iID='t1';
//$title="Black Tug Test";
    $type = substr($iID, 0, 1);
    $categories = "";

    switch ($type) {
        case 't': {
                $categories = 'tugs';
                break;
            }
        case 's': {
                $categories = 'suits_Sleeves';
                break;
            }
        case 'c': {
                $categories = 'collars';
                break;
            }
        case 'e': {
                $categories = 'ecollars';
                break;
            }
        case 'm': {
                $categories = 'muzzles';
                break;
            }
        case 'l': {
                $categories = 'leashes';
                break;
            }
        case 'o': {
                $categories = 'other';
                break;
            }
        case 'h': {
                $categories = 'harnesses';
                break;
            }
    }

   
//      Parameters for SetExpressCheckout, which will be sent to PayPal
    $padata = '&METHOD=SetExpressCheckout' .
            '&RETURNURL=' . urlencode("http://localhost/vendor/premiumpayment.php") .
            '&CANCELURL=' . urlencode("http://localhost/" . $iID) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_0_PAYMENTREQUESTID=' . urldecode($iID) .
            '&PAYMENTREQUEST_0_AMT=' . urlencode(5).
            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode(5) .
            '&PAYMENTREQUEST_0_TAXAMT=0' .
            '&PAYMENTREQUEST_0_DESC=' . urlencode("Dog Gear Trade Fee for having a Premium Item") .
            '&PAYMENTREQUEST_0_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_0_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=' . urlencode("xjordon11x-facilitator@gmail.com") .
            '&PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_0_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode("Premium Fee") .
            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($iID) .
            '&L_PAYMENTREQUEST_0_QTY0=1' .
            '&L_PAYMENTREQUEST_0_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode(5) .
            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode("Premium Fee") .
            
    '&ALLOWNOTE=1';
    $ppUsername = "xjordon11x-facilitator_api1.gmail.com";
    $ppPassword = "V9JQ7G7YTLUBJ2MW";
    $ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
    $ppaAppId = "APP-80W284485P519543T";

    $_SESSION['sellerPP'] = $sellerPP;
    $_SESSION['iID'] = $iID;



    //We need to execute the "SetExpressCheckOut" method to obtain paypal token
    $paypal = new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $ppUsername, $ppPassword, $ppSignature, "sandbox");
    var_dump($httpParsedResponseAr);
    //Respond according to message we receive from Paypal
    if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

        //Redirect user to PayPal store with Token received.
        $paypalurl = 'https://www.' . 'sandbox' . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
        header('Location: ' . $paypalurl);
    } else {
        //Show error message
        echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
        echo '<pre>';
        print_r($httpParsedResponseAr);
        echo '</pre>';
    }
}
if (isset($_GET["token"]) && isset($_GET["PayerID"])) {
//    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
//    //Note: we haven't received any payment yet.
//    
    $iID=$_SESSION['iID'];
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
//  
    $padata = '&TOKEN=' . urlencode($token) .
            '&PAYERID=' . urlencode($payer_id) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_0_PAYMENTREQUESTID=' . urldecode($iID) .
            '&PAYMENTREQUEST_0_AMT=' . urlencode(5) .
            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode(5) .
            '&PAYMENTREQUEST_0_TAXAMT=0' .
            '&PAYMENTREQUEST_0_DESC=' . urlencode("Dog Gear Trade Fee for having a Premium Item") .
            '&PAYMENTREQUEST_0_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_0_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=' . urlencode("xjordon11x-facilitator@gmail.com") .
            '&PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_0_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode("Premium Fee") .
            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode(5) .
            '&L_PAYMENTREQUEST_0_QTY0=1' .
            '&L_PAYMENTREQUEST_0_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode(5) .
            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode("Premium Fee") .
           '&ALLOWNOTE=1';

    $ppUsername = "xjordon11x-facilitator_api1.gmail.com";
    $ppPassword = "V9JQ7G7YTLUBJ2MW";
    $ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
    $ppaAppId = "APP-80W284485P519543T";
//    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal = new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $ppUsername, $ppPassword, $ppSignature, 'sandbox');
   // var_dump($httpParsedResponseAr);
//    //Check if everything went ok..
    if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
    {
//
        $transactionID1=$httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"];
        
        echo '<h2>Success</h2>';
    echo 'Your First Transaction ID : ' . urldecode($transactionID1);
            
//            
//                /*
//                //Sometimes Payment are kept pending even when transaction is complete. 
//                //hence we need to notify user about it and ask him manually approve the transiction
//                */
//                
    if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]&&'Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
        echo '<div style="color:green">Payment Received! Your product will be premium featured!</div>';
    } elseif ('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]&&'Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
        echo '<div style="color:red">Transaction Complete, but payment is still pending! ' .
        'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
    }
//
//                // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
//                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                $padata =   '&TOKEN='.urlencode($token);
                $paypal= new MyPayPal();
                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $ppUsername, $ppPassword, $ppSignature, 'sandbox');
                var_dump($httpParsedResponseAr);
                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                {
                    
                    echo '<br /><b>Stuff to store in database :</b><br /><pre>';
               //     echo $sellerPP;
//                    /*
//                    #### SAVE BUYER INFORMATION IN DATABASE ###
//                    //see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage
//                    
                    $buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
                    $buyerEmail = urldecode($httpParsedResponseAr["EMAIL"]);
                    $p1=urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_AMT"]);
                    $seller=urldecode($httpParsedResponseAr["PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID"]);
                             
//                    //Open a new connection to the MySQL server
$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
                    $mysqli = new mysqli('127.0.0.1:3306',$username,$password,$database);
//                    
//                    //Output any connection error
                    if ($mysqli->connect_error) {
                        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
                    }       
                    $bName=$_SESSION['login_user'];
                  
                    //echo $bID;
                   
                    
                    $insert_row = $mysqli->query("INSERT INTO transactions 
                    (buyerID,buyerName,email,transactionID,title,itemID,price,quantity,toWho)
                    VALUES ('$bName','$buyerName','$buyerEmail','$transactionID1','Premium Fee','$iID','5','1','$seller')");
//                    
                    if($insert_row){
                        print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
//                    
//                    */
//                    
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
                } else  {
                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
//
                }
//    
    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
    $_SESSION['premium']=1;
        echo '<form action="/sell/createPage.php" method="POST">
             <div >
                <button type="submit" name="Continue" value="" style="width:100%">Continue</button>
              
            
             </div>
            </form>
 ';
}
?>
 
