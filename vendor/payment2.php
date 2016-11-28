<?php

include_once(__DIR__."\paypal.class.php");
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
if(!isset($_GET["token"])){

$price=floatval($_GET['price']);
$title=$_GET['title'];
$iID=$_GET['id'];
//$price=15;
//$iID='t1';
//$title="Black Tug Test";
 $type = substr($iID, 0, 1);
$categories="";

switch ($type) {
            case 't': {$categories = 'tugs';break;}
            case 's': {$categories = 'suits_Sleeves';break;}
            case 'c': {$categories = 'collars';break;}
            case 'e': {$categories = 'ecollars';break;}
            case 'm': {$categories = 'muzzles';break;}
            case 'l': {$categories = 'leashes';break;}
            case 'o': {$categories = 'other';break;}
            case 'h': {$categories = 'harnesses';break;}
        }
     
$q=mysql_query("SELECT sale_fee, paypal,description,sellerID from ".$categories." where itemID='".$iID."'");
$sf= floatval( mysql_result($q, 0,'sale_fee'));
$sellerPP=mysql_result($q,0,'paypal');
$desc=mysql_result($q,0,"description");
$_SESSION['sellerID']=mysql_result($q,0,"sellerID");


$q2=mysql_query("SELECT email from seller where sellerID='".$_SESSION['login_user']."';");
$senderPP=  mysql_result($q2, 0);


//
//      Parameters for SetExpressCheckout, which will be sent to PayPal
     $padata =   '&METHOD=SetExpressCheckout'.
                 '&RETURNURL='.urlencode("http://localhost:8080/vendor/payment2.php" ).
                '&CANCELURL='.urlencode("http://localhost:8080/buy/item.php?i=".$iID).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
//                
                 '&L_PAYMENTREQUEST_0_NAME0='.urlencode($title).
                 '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($iID).
                 '&L_PAYMENTREQUEST_0_DESC0='.urlencode($desc).
                 '&L_PAYMENTREQUEST_0_AMT0='.urlencode(floatval(floatval($price)-floatval($sf))).
                 '&L_PAYMENTREQUEST_0_QTY0='. urlencode(1).
                 '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID='.$sellerPP.
                 '&PAYMENTREQUEST_1_SELLERPAYPALACCOUNTID=xjordon11x-buyer@gmail.com'.

                 
//                 / Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
             '&L_PAYMENTREQUEST_0_NAME1='.urlencode("DogSportGear.com Sale Fee").
                 '&L_PAYMENTREQUEST_0_DESC1='.urlencode("Fee for selling item on the website").
                 '&L_PAYMENTREQUEST_0_AMT1='.urlencode(floatval($sf)).
                 '&L_PAYMENTREQUEST_0_QTY1='.urlencode(1).
//             
                 '&NOSHIPPING=1'. //set 1 to hide buyer's shipping address, in-case products that do not require shipping
                
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode(floatval(floatval($price))).
                '&PAYMENTREQUEST_0_AMT='.urlencode(floatval(floatval($price))).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode("USD").
//                '&PAYMENTREQUEST_0_ITEMAMT1='.urlencode(floatval($sf)).
//                '&PAYMENTREQUEST__AMT1='.urlencode(floatval($sf)).
//                '&PAYMENTREQUEST_1_CURRENCYCODE='.urlencode("USD").
//              //  '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
//               // '&LOGOIMG=http://www.sanwebe.com/wp-content/themes/sanwebe/img/logo.png'. //site logo
//                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';
//                
//                ############# set session variable we need later for "DoExpressCheckoutPayment" #######
                $_SESSION['sellerPP']           =$sellerPP;
                $_SESSION['ItemName1']           =  $title; //Item Name
                $_SESSION['ItemName2']           =  "DogSportGear.com Sale Fee"; //Item Name
                $_SESSION['ItemPrice1']          =  floatval($price-$sf); //Item Price
                $_SESSION['ItemPrice2']          =  floatval($sf); //Item Price
                $_SESSION['ItemDesc1']           =  $desc; //Item description
                $_SESSION['ItemDesc2']           =  "Fee for selling item on the website"; //Item description
                $_SESSION['ItemQty']            =  1; // Item Quantity
                $_SESSION['ItemTotalPrice']     =  $price; //total amount of product; 
                $_SESSION['TotalTaxAmount']     =  0;  //Sum of tax for all items in this order. 
                $_SESSION['HandalingCost']      =  0;  //Handling cost for this order.
                $_SESSION['InsuranceCost']      =  0;  //shipping insurance cost for this order.
                $_SESSION['ShippinDiscount']    =  0; //Shipping discount for this order. Specify this as negative number.
                $_SESSION['ShippinCost']        =   0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
                $_SESSION['GrandTotal']         =  $price;
//
$ppUsername= "xjordon11x-facilitator_api1.gmail.com";
$ppPassword = "V9JQ7G7YTLUBJ2MW";
$ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
$ppaAppId ="APP-80W284485P519543T";

        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
        $paypal= new MyPayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $ppUsername, $ppPassword, $ppSignature, "sandbox");
        var_dump($httpParsedResponseAr);
        //Respond according to message we receive from Paypal
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
        {

                //Redirect user to PayPal store with Token received.
                $paypalurl ='https://www.'.'sandbox'.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                header('Location: '.$paypalurl);
             
        }else{
            //Show error message
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }
}

//
////Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
//    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
//    //Note: we haven't received any payment yet.
//    
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
//    
//    //get session variables
    $ItemName1           = $_SESSION['ItemName1']; //Item Name
    $ItemPrice1          = $_SESSION['ItemPrice1'] ; //Item Price
  //  $ItemNumber1         = $_SESSION['ItemNumber1']; //Item Number
    $ItemDesc1           = $_SESSION['ItemDesc1']; //Item Number
    $ItemName2           = $_SESSION['ItemName2']; //Item Name
    $ItemPrice2          = $_SESSION['ItemPrice2'] ; //Item Price
 //   $ItemNumber2         = $_SESSION['ItemNumber2']; //Item Number
    $ItemDesc2           = $_SESSION['ItemDesc2']; //Item Number
    $sellerPP              =$_SESSION['sellerPP'];
    $ItemQty            = $_SESSION['ItemQty']; // Item Quantity
    $ItemTotalPrice     = $_SESSION['ItemTotalPrice']; //total amount of product; 
    $TotalTaxAmount     = $_SESSION['TotalTaxAmount'] ;  //Sum of tax for all items in this order. 
    $HandalingCost      = $_SESSION['HandalingCost'];  //Handling cost for this order.
    $InsuranceCost      = $_SESSION['InsuranceCost'];  //shipping insurance cost for this order.
    $ShippinDiscount    = $_SESSION['ShippinDiscount']; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost        = $_SESSION['ShippinCost']; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
    $GrandTotal         = $_SESSION['GrandTotal'];
//
    $padata =   '&TOKEN='.urlencode($token).
                '&PAYERID='.urlencode($payer_id).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
//                
//                //set item info here, otherwise we won't see product details later  
                '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName1).
                '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode(1).
                '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc1).
                '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice1).
                '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
                 '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
                '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode(2).
                '&L_PAYMENTREQUEST_0_DESC1='.urlencode($ItemDesc2).
                '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
                '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty).
                '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID0='.$sellerPP.
                 '&PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID1=xjordon11x-buyer@gmail.com'.
//                 /* 
//                //Additional products (L_PAYMENTREQUEST_0_NAME0 becomes L_PAYMENTREQUEST_0_NAME1 and so on)
//                '&L_PAYMENTREQUEST_0_NAME1='.urlencode($ItemName2).
//                '&L_PAYMENTREQUEST_0_NUMBER1='.urlencode($ItemNumber2).
//                '&L_PAYMENTREQUEST_0_DESC1=Description text'.
//                '&L_PAYMENTREQUEST_0_AMT1='.urlencode($ItemPrice2).
//                '&L_PAYMENTREQUEST_0_QTY1='. urlencode($ItemQty2).
//                */
                '&NOSHIPPING=1'. 
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode("USD");
    
$ppUsername= "xjordon11x-facilitator_api1.gmail.com";
$ppPassword = "V9JQ7G7YTLUBJ2MW";
$ppSignature = "AFcWxV21C7fd0v3bYYYRCpSSRl31Asl95bUWpECspOW776y32gQeyGWo";
$ppaAppId ="APP-80W284485P519543T";    
//    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $ppUsername, $ppPassword, $ppSignature, 'sandbox');
//    
//    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
//    {
//
            echo '<h2>Success</h2>';
            echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
//            
//                /*
//                //Sometimes Payment are kept pending even when transaction is complete. 
//                //hence we need to notify user about it and ask him manually approve the transiction
//                */
//                
                if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                }
                elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
                    'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                }
//
//                // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
//                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
//                $padata =   '&TOKEN='.urlencode($token);
//                $paypal= new MyPayPal();
//                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
//
//                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
//                {
//                    
//                    echo '<br /><b>Stuff to store in database :</b><br /><pre>';
//                    /*
//                    #### SAVE BUYER INFORMATION IN DATABASE ###
//                    //see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage
//                    
//                    $buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
//                    $buyerEmail = $httpParsedResponseAr["EMAIL"];
//                    
//                    //Open a new connection to the MySQL server
//                    $mysqli = new mysqli('host','username','password','database_name');
//                    
//                    //Output any connection error
//                    if ($mysqli->connect_error) {
//                        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
//                    }       
//                    
//                    $insert_row = $mysqli->query("INSERT INTO BuyerTable 
//                    (BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
//                    VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");
//                    
//                    if($insert_row){
//                        print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
//                    }else{
//                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
//                    }
//                    
//                    */
//                    
//                    echo '<pre>';
//                    print_r($httpParsedResponseAr);
//                    echo '</pre>';
//                } else  {
//                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
//                    echo '<pre>';
//                    print_r($httpParsedResponseAr);
//                    echo '</pre>';
//
//                }
//    
//    }else{
//            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
//            echo '<pre>';
//            print_r($httpParsedResponseAr);
//            echo '</pre>';
//    }
}
?>