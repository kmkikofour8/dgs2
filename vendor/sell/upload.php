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
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif', 'jpeg');
ini_set("log_errors", 1);
ini_set("error_log", "/php_error.log");
$id= $_POST['iID'];
$x="$_SERVER[DOCUMENT_ROOT]/img/tiles/$id/";

if(!file_exists("$_SERVER[DOCUMENT_ROOT]img/tiles/$id/")){
   mkdir("$_SERVER[DOCUMENT_ROOT]img/tiles/$id/",755,true);
   #exec("chmod -R 755"."$_SERVER[DOCUMENT_ROOT]img/$id/");
   chmod("$_SERVER[DOCUMENT_ROOT]img/tiles/$id",0755);
}
chmod("$_SERVER[DOCUMENT_ROOT]img/tiles/$id",0755);
$path = "$_SERVER[DOCUMENT_ROOT]img/tiles/" . $id . "/" . $_FILES["file"]["name"];
$p2="/img/tiles/" . $id . "/" . $_FILES["file"]["name"];
$_SESSION['image']=$_FILES["file"]["name"];
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($extension), $allowed)) {
        file_put_contents("/php_error.log", '{"status":"error"}');
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {

       
        $q4 = "INSERT INTO tileimages (`imagePath`, `itemID`) VALUES('$p2','$id');";
        echo $q4;
        $retval = $x4 = mysql_query($q4);
        if (!$retval)
            echo mysql_error();
        exit;
    }
}

echo '{"status":"error"}';
exit;
?>