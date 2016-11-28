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
$name=$_GET['name'];
$id= $_SESSION['selliID'];
$myFile = "$_SERVER[DOCUMENT_ROOT]img/tiles/".$id."/".$name;
unlink($myFile);

        $q4 = "DELETE FROM `db_1`.`tileimages` WHERE `imagePath`='/img/tiles".$id."/".$name."'";
        $retval = $x4 = mysql_query($q4);
        if (!$retval)
            echo mysql_error();
        exit;


?>
