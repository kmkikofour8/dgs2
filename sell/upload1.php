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
$id = $_POST['iID'];


if(!file_exists("$_SERVER[DOCUMENT_ROOT]img/$id/")){
   mkdir("$_SERVER[DOCUMENT_ROOT]img/$id/",755,true);
   #exec("chmod -R 755"."$_SERVER[DOCUMENT_ROOT]img/$id/");
   chmod("$_SERVER[DOCUMENT_ROOT]img/$id",0755);
}
chmod("$_SERVER[DOCUMENT_ROOT]img/$id",0755);
$path = "/img/" . $id . "/" . $_FILES["file"]["name"];
$p2="$_SERVER[DOCUMENT_ROOT]".$path;
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($extension), $allowed)) {
        file_put_contents("/php_error.log", '{"status":"error"}');
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $p2)) {

        #echo "<img src=\"/img/".$id."/".$_FILES["fileToUpload"]["name"]."\"/>";
      
        $q4 = "INSERT INTO images (`imagePath`, `itemID`) VALUES('$path','$id');";
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