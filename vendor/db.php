<?php
session_start();
$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);
use PayPal\Rest\ApiContext;
require $_SERVER['DOCUMENT_ROOT']."vendor/autoload.php";
$api=new ApiContext(
        new PayPal\Auth\OAuthTokenCredential(
                'AddO-L6p5oIaYaLTLZiDA78gnC-CZGsIRbtzTO170k9SiDH44nQ4LjDFfQ8qg5zXBxANg4QlBIlpl4zr',
                'EN6jm_AqTAlgyyYTvU_0WfwFYsG02kXW3EIDb8x6QcwgnUjqCj7oFkYK5eM6wEBuDTFr2JsWUfc-HzVm'
                )
        );
try{
$api->setConfig([
    'mode'=>'sandbox',
    'http.ConnectionTimeout'=>30,
    'log.logEnabled'=>false,
    'log.FileName'=>'',
    'log.Level'=>'FINE',
    'validation.Level'=>'Log'    
]);
}catch(PayPal\Exception\PayPalConnectionException $ex){
    echo $ex->getData();
}

?>
