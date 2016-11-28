<?php

include_once(__DIR__ . "\paypal.class.php");
#e('../Header.php');
require '../db.php';

$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);
require '../vendor/autoload.php';

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

$logger = "";
if (!isset($_GET["token"])) {

    $price = floatval($_SESSION['iprice']);
    $title = $_SESSION['ititle'];
    $iID = $_SESSION['iid'];
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

    $q = mysql_query("SELECT sale_fee, paypal,description,sellerID from " . $categories . " where itemID='" . $iID . "'");
    $sf = floatval(mysql_result($q, 0, 'sale_fee'));
    $sellerPP = mysql_result($q, 0, 'paypal');
    $sellerGoogleID=mysql_result($q,0,'sellerID');
    if (!$sellerPP) {
        $v = mysql_error();
    }
    $desc = mysql_result($q, 0, "description");
    $_SESSION['sellerID'] = mysql_result($q, 0, "sellerID");


    //$q2 = mysql_query("SELECT google_email from google_users where ='" . $_SESSION['login_user'] . "';");
    $senderPP = $_SESSION['login_user'];
    echo $senderPP;

//
//      Parameters for SetExpressCheckout, which will be sent to PayPal
    $padata = '&METHOD=SetExpressCheckout' .
            '&RETURNURL=' . urlencode("http://localhost:8080/vendor/payment3.php") .
            '&CANCELURL=' . urlencode("http://localhost:8080/buy/item.php?i=" . $iID) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_1_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_0_PAYMENTREQUESTID=' . urldecode($iID) .
            '&PAYMENTREQUEST_1_PAYMENTREQUESTID=' . urlencode($iID . "Sale Fee") .
            '&PAYMENTREQUEST_0_AMT=' . urlencode($price - $sf).
            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($price - $sf) .
            '&PAYMENTREQUEST_0_TAXAMT=0' .
            '&PAYMENTREQUEST_0_DESC=' . urlencode($desc) .
            '&PAYMENTREQUEST_0_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_0_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=' . urlencode($sellerPP) .
            '&PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_0_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($title) .
            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($iID) .
            '&L_PAYMENTREQUEST_0_QTY0=1' .
            '&L_PAYMENTREQUEST_0_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($price - $sf) .
            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($desc) .
            '&PAYMENTREQUEST_1_AMT=' . urlencode(floatval($sf)) .
            '&PAYMENTREQUEST_1_ITEMAMT=' . urlencode(floatval($sf)) .
            '&PAYMENTREQUEST_1_TAXAMT=0' .
            '&PAYMENTREQUEST_1_DESC=' . urlencode('Fee for selling item on the website') .
            '&PAYMENTREQUEST_1_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_1_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID=' . urlencode('xjordon11x-facilitator@gmail.com') .
            '&PAYMENTREQUEST_1_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_1_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_1_NAME0=' . urlencode("Dog Sport Gear Trade Sale Fee") .
            '&L_PAYMENTREQUEST_1_NUMBER0=' . urlencode(1) .
            '&L_PAYMENTREQUEST_1_QTY0=1' .
            '&L_PAYMENTREQUEST_1_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_1_AMT0=' . urlencode($sf) .
            '&L_PAYMENTREQUEST_1_DESC0=' . urlencode("Dog Sport Gear Trade Sale Fee (Built into original Price)");
    '&ALLOWNOTE=1';
    $ppUsername = "xjordon11x-facilitator_api1.gmail.com";
    $ppPassword = "V9JQ7G7YTLUBJ2MW";
    $ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
    $ppaAppId = "APP-80W284485P519543T";

    $_SESSION['sellerPP'] = $sellerPP;
    $_SESSION['iID'] = $iID;
    $_SESSION['title'] = $title; //Item Name
    $_SESSION['ItemName2'] = "DogSportGear.com Sale Fee"; //Item Name
    $_SESSION['price'] = floatval($price); //Item Price
    $_SESSION['sf'] = floatval($sf); //Item Price
    $_SESSION['desc'] = $desc; //Item description
    $_SESSION['ItemDesc2'] = "Fee for selling item on the website"; //Item description
    $_SESSION['ItemQty'] = 1; // Item Quantity
    $_SESSION['ItemTotalPrice'] = $price; //total amount of product; 
    $_SESSION['TotalTaxAmount'] = 0;  //Sum of tax for all items in this order. 
    $_SESSION['HandalingCost'] = 0;  //Handling cost for this order.
    $_SESSION['InsuranceCost'] = 0;  //shipping insurance cost for this order.
    $_SESSION['ShippinDiscount'] = 0; //Shipping discount for this order. Specify this as negative number.
    $_SESSION['ShippinCost'] = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
    $_SESSION['GrandTotal'] = $price;





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
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
//    
//    //get session variables
    $title = $_SESSION['title']; //Item Name
    $price = $_SESSION['price']; //Item Price
    //  $ItemNumber1         = $_SESSION['ItemNumber1']; //Item Number
    $desc = $_SESSION['desc']; //Item Number
    $ItemName2 = $_SESSION['ItemName2']; //Item Name
    $sf = $_SESSION['sf']; //Item Price
    $iID = $_SESSION['iID'];
    //   $ItemNumber2         = $_SESSION['ItemNumber2']; //Item Number
    $ItemDesc2 = $_SESSION['ItemDesc2']; //Item Number
    $sellerPP = $_SESSION['sellerPP'];
    $ItemQty = $_SESSION['ItemQty']; // Item Quantity
    $ItemTotalPrice = $_SESSION['ItemTotalPrice']; //total amount of product; 
    $TotalTaxAmount = $_SESSION['TotalTaxAmount'];  //Sum of tax for all items in this order. 
    $HandalingCost = $_SESSION['HandalingCost'];  //Handling cost for this order.
    $InsuranceCost = $_SESSION['InsuranceCost'];  //shipping insurance cost for this order.
    $ShippinDiscount = $_SESSION['ShippinDiscount']; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost = $_SESSION['ShippinCost']; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
    $GrandTotal = $_SESSION['GrandTotal'];
//
    $padata = '&TOKEN=' . urlencode($token) .
            '&PAYERID=' . urlencode($payer_id) .
            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_1_PAYMENTACTION=' . urlencode("SALE") .
            '&PAYMENTREQUEST_0_PAYMENTREQUESTID=' . urldecode($iID) .
            '&PAYMENTREQUEST_1_PAYMENTREQUESTID=' . urlencode($iID . "Sale Fee") .
            '&PAYMENTREQUEST_0_AMT=' . urlencode(floatval($price - $sf)) .
            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode(floatval($price - $sf)) .
            '&PAYMENTREQUEST_0_TAXAMT=0' .
            '&PAYMENTREQUEST_0_DESC=' . urlencode($desc) .
            '&PAYMENTREQUEST_0_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_0_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID=' . urlencode($sellerPP) .
            '&PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_0_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($title) .
            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($iID) .
            '&L_PAYMENTREQUEST_0_QTY0=1' .
            '&L_PAYMENTREQUEST_0_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($price - $sf) .
            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($desc) .
            '&PAYMENTREQUEST_1_AMT=' . urlencode(floatval($sf)) .
            '&PAYMENTREQUEST_1_ITEMAMT=' . urlencode(floatval($sf)) .
            '&PAYMENTREQUEST_1_TAXAMT=0' .
            '&PAYMENTREQUEST_1_DESC=' . urlencode('Fee for selling item on the website') .
            '&PAYMENTREQUEST_1_INSURANCEAMT=0' .
            '&PAYMENTREQUEST_1_SHIPDISCAMT=0' .
            '&PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID=' . urlencode('xjordon11x-facilitator@gmail.com') .
            '&PAYMENTREQUEST_1_INSURANCEOPTIONOFFERED=false' .
            '&PAYMENTREQUEST_1_PAYMENTACTION=Sale' .
            '&L_PAYMENTREQUEST_1_NAME0=' . urlencode("Dog Sport Gear Trade Sale Fee") .
            '&L_PAYMENTREQUEST_1_NUMBER0=' . urlencode(1) .
            '&L_PAYMENTREQUEST_1_QTY0=1' .
            '&L_PAYMENTREQUEST_1_TAXAMT0=0' .
            '&L_PAYMENTREQUEST_1_AMT0=' . urlencode($sf) .
            '&L_PAYMENTREQUEST_1_DESC0=' . urlencode("Dog Sport Gear Trade Sale Fee");
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
        $transactionID2=$httpParsedResponseAr["PAYMENTINFO_1_TRANSACTIONID"];
        echo '<h2>Success</h2>';
    echo 'Your First Transaction ID : ' . urldecode($transactionID1);
            echo 'Your Second Transaction ID : ' . urldecode($transactionID2);
//            
//                /*
//                //Sometimes Payment are kept pending even when transaction is complete. 
//                //hence we need to notify user about it and ask him manually approve the transiction
//                */
//                
    if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_1_PAYMENTSTATUS"]&&'Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
        echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
    } elseif ('Pending' == $httpParsedResponseAr["PAYMENTINFO_1_PAYMENTSTATUS"]&&'Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
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
                    $p2=urldecode($httpParsedResponseAr["PAYMENTREQUEST_1_AMT"]);
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
                    $bID=$_SESSION['login_user'];
                  //  echo $bName;
                    
                    //echo $bID;
                   
                    
                    $insert_row = $mysqli->query("INSERT INTO transactions 
                    (buyerID,buyerName,email,transactionID,title,itemID,price,quantity,toWho,sellerGoogleID)
                    VALUES ('$bID','$buyerName','$buyerEmail','$transactionID1','$title','$iID',$p1,'1','$seller','$sellerGoogleID')");
//                    
                    $insert_row = $mysqli->query("INSERT INTO transactions 
                    (buyerID,buyerName,email,transactionID,title,itemID,price,quantity,toWho)
                    VALUES ('$bID','$buyerName','$buyerEmail','$transactionID2','$title','$iID', $p2,'1','xjordon11x-facilitator@gmail.com')");
//                    
                    if($insert_row){
                        print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
//                    
//                    */
//                    
$type = substr($iID, 0, 1);
        
        switch ($type) {
            case 't': {$categories = 'Tugs';break;}
            case 'l': {$categories = 'Leashes';break;}
            case 's': {$categories = 'Suits_Sleeves';break;}
            case 'c': {$categories = 'Collars';break;}
            case 'e': {$categories = 'Electronic Collars';break;}
            case 'm': {$categories = 'Muzzles';break;}
            case 'o': {$categories = 'Other';break;}
            case 'h': {$categories = 'Harnesses';break;}
        }
                    
                   $mysqli->query(" UPDATE `db_1`.`$categories` SET `sold`='1' WHERE `itemID`='$iID' and`name`='$title';");

                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
                } else  {
                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["PAYMENTINFO_0_LONGMESSAGE"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
//
                }
//    
    }else{
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["PAYMENTINFO_0_LONGMESSAGE"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
      $lppemail=$_SESSION['login_paypal'];
      
        $lemail=$_SESSION['login_email'];
        
        $lid=$_SESSION['login_user'];
        
        $lpicture=$_SESSION['profilePic'];
        
        
        session_unset();
        
    
        $_SESSION['login_paypal']=$lppemail;
        $_SESSION['profilePic']=$lpicture;
        $_SESSION['login_user']=$lid;
        $_SESSION['login_email']=$lemail;
         echo '<a href="/Homepage.php" id="buy_now" class="btn btn-primary btn_buy" style="float:left">Buy Now</a>';
}
?>