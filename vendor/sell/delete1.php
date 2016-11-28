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
$id=$_GET['iID'];
$myFile = "$_SERVER[DOCUMENT_ROOT]/img/".$id."/".$name;
unlink($myFile);

        $q4 = "DELETE FROM `db_1`.`images` WHERE `imagePath`='/img/".$id."/".$name."'";
        $retval = $x4 = mysql_query($q4);
        if (!$retval)
            echo mysql_error();
        exit;


?>
