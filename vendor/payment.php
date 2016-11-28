<?php
require $_SERVER['DOCUMENT_ROOT'].'db.php';
require '../vendor/autoload.php';
use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PPConnectionException;
use PayPal\Rest\ApiContext;

$price=$_SESSION['price'];
$title=$_SESSION['title'];
$iID=$_SESSION['iID'];

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
        var_dump($categories);
        var_dump($iID);
//$q=mysql_query("SELECT sale_fee, paypal from ".$categories." where itemID='".$iID."'");
//$sf=  mysql_result($q, 0,'sale_fee');
//$sellerID=mysql_result($q,0,'paypal');
$sf=$_SESSION['sale_fee'];
$sellerID=$_SESSION['login_user'];
$payer=new Payer();
$details=new Details();
$amount=new Amount();
$details2=new Details();
$amount2=new Amount();
$transaction=new Transaction();
$transaction2=new Transaction();
$payment=new Payment();
$redirectUrls=new RedirectUrls();
$receiver = array();


//Payer
$payer->setPaymentMethod('paypal');
//$details
$details->setShipping('0.00')
        ->setTax('0.00')
        ->setSubTotal(2);

$details2->setShipping('0.00')
        ->setTax('0.00')
        ->setSubTotal($sf);
//amount
$amount->setCurrency('USD')
        ->setTotal(2)
        ->setDetails($details);
$amount2->setCurrency('USD')
        ->setTotal($sf)
        ->setDetails($details2);

//transaction
$transactions=array();
$transactions[0]=new Transaction();
$transactions[0]->setAmount($amount)
          ->setDescription("To Make \"".$title."\" a PREMIUM ITEM on DogGearTrade.com for $2.00");
$transactions[1]=new Transaction();
$transactions[1]->setAmount($amount2)
            ->setDescription("DogGearTrade.com Sale Fee: $".$sf.".");
//var_dump($transactions);

//payment
$payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions([$transactions[0]]);
$payment->create($api);        

//redirect url
$redirectUrls->setReturnUrl('http://localhost:8080/vendor/pay.php?approved=true')
        ->setCancelUrl('http://localhost:8080/vendor/pay.php?approved=false');



$payment->setRedirectUrls($redirectUrls);

try{
    
    
    $hash=md5($payment->getId());
    $_SESSION['paypal_hash']=$hash;
    $store="INSERT INTO transactions_premium (sellerID,paymentID,hash,complete) VALUES ('".$_SESSION['login_user']."','".$payment->getID()."','".$hash."',0)";
    $retval = mysql_query($store);
     if (!$retval)
            $v= mysql_error();
     
} catch (PayPalConnectionException $ex) {
    echo $ex->getData();
    echo $ex->getCode();
   
//header('Location: /error.php');
}
foreach($payment->getLinks() as $link){
    if($link->getRel()=='approval_url'){
        $redirectUrl=$link->getHref();
    }
}
var_dump($redirectUrl);
header('Location:'.$redirectUrl);



?>

