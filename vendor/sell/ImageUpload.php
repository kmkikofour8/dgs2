<?php
#echo exec('whoami');
$id=$_POST['ID'];
#$fname=$_POST['fileToUpload'];
#echo $id." ".$fname;
#echo "$_SERVER[DOCUMENT_ROOT]img/$id/"."<br>A";
#echo $_FILES["fileToUpload"]["name"];
if(!file_exists("$_SERVER[DOCUMENT_ROOT]img/$id/")){
   mkdir("$_SERVER[DOCUMENT_ROOT]img/$id/",755,true);
   #exec("chmod -R 755"."$_SERVER[DOCUMENT_ROOT]img/$id/");
   chmod("$_SERVER[DOCUMENT_ROOT]img/$id",0755);
}
chmod("$_SERVER[DOCUMENT_ROOT]img/$id",0755);
$target_dir = "$_SERVER[DOCUMENT_ROOT]img/$id/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
//echo $_FILES["fileToUpload"]["tmp_name"];
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
  #      echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
) {
    echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 #       echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$path="/img/".$id."/".$_FILES["fileToUpload"]["name"];
echo $path;
#echo "<img src=\"/img/".$id."/".$_FILES["fileToUpload"]["name"]."\"/>";
$username = "jordon";
    $password = "Aryahij11!";
    $database = "db_1";
    $link = mysql_connect('127.0.0.1:3306', $username, $password);
    if (!$link) {
        die("could not connect" . mysql_error());
    }
    mysql_select_db($database);
    $q4="INSERT INTO images (`imagePath`, `itemID`) VALUES('$path','$id');";
    echo $q4;
    $retval=$x4=  mysql_query($q4);
    if(!$retval)
        echo mysql_error();
    
    $q5="SELECT COUNT(*) FROM images WHERE itemID=\"$id\";";
                 $x5=  mysql_query($q5);
                 $Imgcount=  mysql_result($x5, 0);
                 $q6="SELECT * FROM images WHERE itemID=\"$id\";";
                 $x6=  mysql_query($q6);
                 for($i=0;$i<$Imgcount;$i++){
                    $Imgpath=  mysql_result($x6, $i, "imagePath");
                    
                     echo "<div class=\"col-md-1\"><a href=\"$Imgpath\" rel=\"lightbox\">  <img class=\"smallImage1\"src=\"$Imgpath\"/></div></a>";
                 }

?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(
            function(){
               $("#targetImage").append('<img src="/img/<?php echo $id ?>/<?php echo $_FILES["fileToUpload"]["name"]?>"/>');
               
            });
            </script>