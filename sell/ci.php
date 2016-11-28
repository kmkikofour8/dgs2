<html>
    <head>
        <title>Dog Gear Trade</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="/css/index.css">
        <script src="/js/script.js"></script>
    </head>
    <?php
    $username = "jordon";
    $password = "Aryahij11!";
    $database = "db_1";
    $link = mysql_connect('127.0.0.1:3306', $username, $password);
    if (!$link) {
        die("could not connect" . mysql_error());
    }
    mysql_select_db($database);

    include "$_SERVER[DOCUMENT_ROOT]/Header.php";
    $quantity = $_POST['quantity'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $brandID = $_POST['brandID'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $shipFrom = $_POST['shipFrom'];
    $shipTo = $_POST['shipTo'];
    $return = $_POST['return'];
    $total_price = $_POST['total_price'];
    $submit = $_POST['submit'];
    $iID=$_POST['iID'];
#echo $quantity.$title.$description;
#echo"<br>".$total_price;
#echo"<br>".$submit;
    ?>

    <div class="row">
        <div class="col-mid-8" id="targetImage"></div>
        <div class="col-md-4">
            <form action='ImageUpload.php' method='Post' target='resultFrame' enctype="multipart/form-data">
            Select Main image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"/>
    <input type="hidden" name="ID" id="imageID" value="<?php echo $iID?>" />
    <input type="submit" value="Upload Image" name="submit" id="ImageUpload"/>
            </form>
    <!--</form>-->
        <iframe name="resultFrame" width="500" height="300"></iframe>
</div>
    </div>
    
        <div class="row">
            <div class='col-md-12'>
<!--<form action="<php echo "/sell/ImageUpload.php"?>" method="POST" enctype="multipart/form-data">-->
Select image to upload:
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="hidden" name="ID" id="imageID" value="<?php echo $iID?>" >
<input type="submit" value="Upload Image" name="submit" id="ImageUploadB">

        </div>
    </div>
<!--</form>-->




</html>