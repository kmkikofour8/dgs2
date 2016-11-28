<html>
    <head>
        <title>TODO supply a title</title>
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
    <body>



<?php
require_once 'db.php';
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

$var_value = $_GET['page'];
$haystack = array('TUGS', 'COLLARS', 'HARNESSES', 'SUITS_SLEEVES', 'MUZZLES', 'ECOLLARS', 'LEASHES', 'OTHER');
if(!in_array($var_value, $haystack, true)){
  header('HTTP/1.0 404 Not Found');
  header("Location: http://localhost/");
    die();
  exit();
}
else{
if($deviceType=="computer"){
         include '/Header.php';
     }
     else if($deviceType=="phone"){
         include '/Header.php';
     }
#}

   # echo in_array($var_value, $haystack, true);
$categories=array($var_value);
$j=0;
$query = "SELECT COUNT(*) FROM $categories[$j] order by PREMIUM;";
                    $xq = mysql_query($query);
                    $x = mysql_result($xq, 0);
                    $PremExist=TRUE;
                    if($x<=0){
                    $query = "SELECT COUNT(*) FROM $categories[$j];";
                    $xq = mysql_query($query);
                    $x = mysql_result($xq, 0);
                    
                    $PremExist=FALSE;
                    }
                    echo "<div id=\"row_";
                    echo $categories[$j];
                    echo "\" class=\"dev_grid dev_row\">";
                    echo "<div class=\"row\">";
                    for ($i = 0; $i < $x ; $i++) {
                        if($PremExist){
                        $query2 = mysql_query("SELECT * FROM $categories[$j] order by PREMIUM desc;");}
                        else{
                            $query2 = mysql_query("SELECT * FROM $categories[$j];");
                        }
                        if ($i % 4 == 0 && $i != 0) {
                            echo "</div><div class=\"row\">";
                        }
                        
                        if ($query2) {
                            $itemID = mysql_result($query2, $i, "itemID");
                            $itemName = mysql_result($query2, $i, "name");
                            $price = mysql_result($query2, $i, "price");
                            $itemImage = mysql_result($query2, $i, "image");
                            $brandID = mysql_result($query2, $i, "brandID");
                            if($j==1||$j==4||$j==6){
                                $type=  mysql_result($query2, $i, "type");
                            }

                            echo"<div class=\"col-xs-12 col-sm-6 col-md-3\" id=\"";
                            echo $categories[$j]+$i;
                            echo "\"><div class=\"dev_cell_wide\"><div class=\"image pull-left\"id=\"";
                            echo $itemID;
                            echo "\"> <img src=\"img/tiles/".$itemID."/";
                            echo $itemImage;
                            echo "\"  width=\"57\" height=\"110\" alt=\"\" border=\"0\" itemprop=\"image\"></div><div class=\"panel-body\" ><div class=\"title cell_link\"><a href=\"/buy/";
                            echo $itemID;
                            echo "\" title=\"";
                            echo $itemID;
                            echo "\">";
                            echo $itemName;
                            echo "</a></div><div class=\"prices cell_link\"><a href=\"/buy/";
                            echo $itemID;
                            echo "\" title=\"";
                            echo $itemID;
                            echo "\"> <span class=\"brandName\">";
                            echo $brandID;
                            echo "</span><br>";
                            if($j==1||$j==4||$j==6){
                                echo $type;
                                echo "<br>";
                            }
                            echo $price;
                            echo "</a></div><div class=\"buttons\"><a href=\"/buy/";
                            echo $itemID;
                            echo "\" class=\"btn btn-primary btn_buy\" title=\"";
                            echo $itemID;
                            echo "\">Buy</a><a href=\"/sell/";
                            echo $itemID;
                            echo "\"  class=\"btn btn-primary btn_sell\" title=\"";
                            echo $itemID;
                            echo "\">Sell</a></div></div><div class=\"clearfix\"></div></div></div>";
                        } else {
                            echo mysql_error();
                        }
                       
                    }

                    
                    
                     echo "</div></div></div></div>";
}
?>
    </body>
</html>