<?php


$sellerID = $_SESSION['login_user'];
$quantity = $_SESSION['quantity'];
$title = $_SESSION['title'];
$description = $_SESSION['description'];
$brandID = $_SESSION['brandID'];
$color = $_SESSION['color'];
$size = $_SESSION['size'];
$shipFrom = $_SESSION['shipFrom'];
$shipTo = $_SESSION['shipTo'];
$return = $_SESSION['return'];
$price = $_SESSION['price'];
$iID = $_SESSION['iID'];
$image=$_SESSION['image'];
$paypal=$_SESSION['paypal'];
$premium=$_SESSION['premium'];
$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);


 $type = substr($iID, 0, 1);
$categories="";
$query="";
switch ($type) {
            case 't': {$categories = 'tugs';break;}
            case 's': {$categories = 'suits_sleeves';break;}
            case 'c': {$categories = 'collars';break;}
            case 'e': {$categories = 'ecollars';break;}
            case 'm': {$categories = 'muzzles';break;}
            case 'l': {$categories = 'leashes';break;}
            case 'o': {$categories = 'other';break;}
            case 'h': {$categories = 'harnesses';break;}
        }
        
            $query="INSERT INTO `db_1`.`$categories` VALUES ('$iID', '$title', '$brandID', '$price','$description' , '$sellerID', '$premium', '$image', '$color', '$size', CURDATE(),".$_SESSION['sale_fee'].",'$paypal',".floatval($quantity).")";

$result = mysql_query($query);
if(!$result)
    $v= mysql_error();
$q2="INSERT INTO shipping VALUES ('$sellerID','$iID','$shipFrom','$shipTo','$return','1');";
$result = mysql_query($q2);
if(!$result)
    $v= mysql_error();
return;

?>