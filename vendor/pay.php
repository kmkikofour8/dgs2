<?php

require $_SERVER['DOCUMENT_ROOT'].'db.php';
//require '/vendor/autoload.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
if(isset($_GET['approved'])){
    $approved=$_GET['approved']==='true';
    if($approved){
        $payerId=$_GET['PayerID'];
        $paymentID=mysql_query("select paymentID from transactions_premium where hash='".$_SESSION['paypal_hash']."'");
        if(!$paymentID)
            $v=  mysql_error ();
        
    $pID=  mysql_result($paymentID,0);
    $payment=Payment::get($pID, $api);
    $execution=new PaymentExecution();
    $execution->setPayerId($payerId);
    $payment->execute($execution,$api);
    
    $complete=mysql_query("UPDATE transactions_premium SET complete='1' WHERE hash='".$_SESSION['paypal_hash']."';");
    $_SESSION['premium']=1;
    include $_SERVER['DOCUMENT_ROOT']."sell/createPage.php";
    header('Location: /buy/item.php?i='.$_SESSION['iID']);
    }
    else{
        $_SESSION['premium']=0;
        include $_SERVER['DOCUMENT_ROOT']."sell/createPage.php";
        header('Location: /buy/item.php?i='.$_SESSION['iID']);
    }
}




?>
