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
        <script src="/js/jquery.validate.js"></script>
    </head>
    <?php
    
    include $_SERVER['DOCUMENT_ROOT'].'Header.php';
    
    ?>
    
    <form id="sellform" action="/sell/sItem.php" method='POST'>
        <div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            
            <div class="panel-heading">Basic Information-- Item ID:
<?php

$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);
$category = $_POST['type'];
$q = "SELECT itemID from $category order by itemID desc limit 1";
$x = mysql_query($q);
$iID="";
$i =mysql_result($x, 0);
if($i!=NULL){
$letter = substr($i, 0, 1);
//echo $letter;
$num = substr($i, 1);
$num+=1;
//echo $num;
$iID = $letter . $num;
}
else{
    $letter=  substr($category, 0,1);
    $num=0;
    $iID = strtolower($letter) . $num;
}
echo $iID;
?>
            </div>
 <input type="hidden" name="iID" value="<?php echo $iID?>"/>
          
 
 <div class="panel-body">
                    Quantity:
                    <input type="text" name="quantity" style="width:100%;" autocomplete="off" /><br><br>
                    Title:
                    <input type="text" name="title" style="width:100%;" autocomplete="off"/><br>
                    <br> Product Description:
                    <textarea name="description" style="width:100%;" ></textarea>
                </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Key Features
            </div>
            <div class="panel-body">
                Brand <span id="brandID"><input name="brandID" type="text" placeholder="Please Put Name of the Brand" style="width:100%;" autocomplete="off"/></span>
                <br><br>Color: <span id="shipTo" ><input name="color" type="text" placeholder="Please enter the color of the item" style="width:100%" autocomplete="off"/></span><br>
                <br>Size: <input type="text" name="size" placeholder="" style="width:100%" autocomplete="off"/>
                <br>
            </div>
        </div>

    </div>
    </div>

        <div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Shipping & Handling Information
            </div>
            <div class="panel-body">
                The item will ship from: <span id="shipFrom"><input name="shipFrom" type="text" placeholder="Please Put State and Country" style="width:100%;"autocomplete="off"/></span>
                <br><br>The item will ship to: <span id="shipTo" ><input name="shipTo"type="text" placeholder="Please Put Country Only or enter ALL" style="width:100%"autocomplete="off"/></span>
                <br><br>Return Policy: <input type="text" name="return" placeholder="Please explain your return policy or enter None" style="width:100%"autocomplete="off"/>
                <br>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Payment Information
            </div>
            <div class="panel-body">
                Asking Price <span style="font-size:9px">This is the amount you'll get paid (less Sale fee) and should include standard shipping costs. Please include reasonable shipping costs (usually about $10-15) in ask price</span> 
                <div class="controls widget" style="margin-bottom: 0px;">
                    <input type="text" name="ask_price" value="0" id="id_ask_price" class="form-control spinedit noSelect required" style="display:inline;width:25%;" autocomplete="off"><span id="list_price_extra" style="font-size: 110%; visibility: visible;">
                        + <span id="id_sale_fee">0</span> (Sale Fee) =
                        <span id="id_total_price">0</span> (Total Price shown to Buyers)
                        <input type="hidden" value="" id="phidden" name="total_price"/>
                        <input type="hidden" value="" id="sfhidden" name="sale_fee"/>
                    </span>
                </div>
                <div>
                    <br>Enter PayPal Address<br>
                    <input type="text" id="paypal" name="paypal" value=""/></div>

               
            </div>
        </div>

    </div>


    
        </div>

    <!--<div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Images
            </div>
        </div>
        <div class="panel-body">
            
            
              <php 
                 $q5="SELECT COUNT(*) FROM images WHERE itemID=\"$iID\";";
                 $x5=  mysql_query($q5);
                 $Imgcount=  mysql_result($x5, 0);
                 $q6="SELECT * FROM images WHERE itemID=\"$iID\";";
                 $x6=  mysql_query($q6);
                 for($i=0;$i<$Imgcount;$i++){
                    $Imgpath=  mysql_result($x6, $i, "imagePath");
                    $bigImg=  mysql_result($x6, $i, "bigImage");
                     echo "<a href=\"$bigImg\"   rel=\"lightbox\">";
                     echo "<div class=\"col-md-1\"><img class=\"smallImage \"src=\"$Imgpath\"/></div></a>";
                 }
                 
                ?>
            
        </div>
    </div>
    <!--
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Upload Images
            </div>
            <div class="panel-body">
            <!--			<p>
                                            Select one or more files to upload...
                                    </p>
                                    
                                    <form id="image_upload_form" action="ImageUpload.php" method="post" enctype="multipart/form-data" class="form-inline" role="form">
                                            <div class="form-group">
                                                    <input id="id_image_file" class="form-control" type="file" name="image_file" multiple="">
                                            </div>
                                            <button id="image_upload_button" class="btn btn-primary">Upload Image Files</button>
                                    </form>
                                    
                                    <div id="file_upload_progress" class="progress" style="margin-top: 10px; display: none;">
                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                    <p id="file_upload_message" style="display: none;">
                                            File upload...
                                    </p>
                            </div>
            
    -->
    <!--<form action="<php echo "/sell/ImageUpload.php"?>" method="POST" enctype="multipart/form-data">
Select image to upload:
<input type="file" name="fileToUpload" id="fileToUpload">
<input type="hidden" name="ID" id="imageID" value="<php echo $iID?>" >
<input type="submit" value="Upload Image" name="submit" id="ImageUploadB">

</form>
    
    <input type="Submit" value="Submit" name="submit"/>-->
    <button type='submit' >Submit</button>
    </form>
    <a href="/Homepage.php"><button>Cancel</button></a>
</html>
