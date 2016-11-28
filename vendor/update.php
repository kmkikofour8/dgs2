<?php
session_start();
$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
mysql_select_db($database);
if (!$link) {
    die("could not connect" . mysql_error());
}
$itemID1=$_GET['itemID'];
$sellerID1=$_GET['sellerID'];
$commentz1=$_GET['commentz'];
$uid=$_SESSION['login_user'];
$q=  mysql_query("SELECT username from seller where sellerID='".$uid."'");
$username=  mysql_result($q, 0);


$q8="INSERT INTO comments (sellerID, itemID,comment, date, username) VALUES ('$uid', '$itemID1', '$commentz1', CURDATE(),'$username');";
echo $q8;
 #$query = "SELECT * FROM $itemID WHERE itemID=\"$\";";
$result1=  mysql_query($q8);
//$result1=mysql_query("INSERT INTO 'db_1'.'comments' ('sellerID', 'itemID', 'comment', 'date') VALUES ($sellerID1\", \"$itemID1\", \"$commentz1\", \"0000-00-00\",\"\");");
if(!$result1){
  echo  mysql_error();
}



#echo "<script type=\"text/javascript\">window.load=function(){location.href=\"/buy/item.php?i=".$itemID1.";}";
header("Location: /buy/item.php?i=$itemID1");



?>
