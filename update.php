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
$itemID1=$_POST['itemID'];

$commentz1=$_POST['comment'];
if(isset($_SESSION['login_user'])){
$uid=$_SESSION['login_user'];


$email=$_SESSION["login_email"];
$name=$_SESSION["login_name"];
$q8="INSERT INTO comments (google_email, itemID, comment, date,name) VALUES ('$email', '$itemID1', '$commentz1', NOW(),'$name');";
 #$query = "SELECT * FROM $itemID WHERE itemID=\"$\";";
$result1=  mysql_query($q8);
//$result1=mysql_query("INSERT INTO 'db_1'.'comments' ('sellerID', 'itemID', 'comment', 'date') VALUES ($sellerID1\", \"$itemID1\", \"$commentz1\", \"0000-00-00\",\"\");");
if(!$result1){
  echo  mysql_error();
}
}

header("Location: /buy/$itemID1");



?>
