<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

require_once $_SERVER['DOCUMENT_ROOT'].'Header.php';

//require_once 'Mobile_Detect.php';
//$detect = new Mobile_Detect;

//$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');


?>

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
        <script src="/js/script.js">
        
        
        
        </script>
    </head>
    <body>
     <?php
     //if($deviceType=="computer"){
      //   include 'Header.php';
     //}
    // else if($deviceType=="phone"){
         //include $_SERVER['DOCUMENT_ROOT'].'Header.php';
    // }
     ?>
 







                <hr>
               

                <!-- for tiles______________________________________________    --->
                <?php
                
                error_reporting(E_ERROR | E_PARSE);
                $categories = array('tugs', 'collars', 'harnesses', 'suits', 'muzzles', 'ecollars', 'leashes', 'other');
                for ($j = 0; $j < 8; $j++) {
                    echo "<div id=\"row_";
                    echo $categories[$j];
                    echo "\" class=\"row wrap\"><div class=\"col-md-12 navbar navbar-default subnav\"><a href=\"/Buy.php?page=";
                    echo strtoupper($categories[$j])."\">".strtoupper($categories[$j])."</a></div>";
//                    echo "<div class=\"row\">  <div class=\"col-xs-12 col-sm-6 col-md-3\"><div class=\"carrier_panel panel panel-success\"><div class=\"panel-heading\">";
//                    echo "<a href=\"/Buy.php?page=";
//                    echo $categories[$j];
//                    echo "\" title=\"";
//                    echo $categories[$j];
//                    echo "\"> All ";
//                    echo $categories[$j];
//                    echo " »</a></div><div class=\"panel-body\" align=\"center\" style=\"padding-top: 10px; min-height:135px;\">";
//                    echo "<a href=\"/Buy.php?page=";
//                    echo $categories[$j];
//                    echo "\" title=\"";
//                    echo $categories[$j];
//                    echo "\" class=\"carrier_pic\"><img src=\"img/";
//                    echo $categories[$j];
//                    echo ".jpg\"width=\"200\" height=\"100\" alt=\"";
//                    echo $categories[$j];
//                    echo "\" border=\"0\"></a></div></div></div>";




                    $query = "SELECT COUNT(*) FROM $categories[$j] WHERE PREMIUM=1 AND SOLD=0;";
                    $xq = mysql_query($query);
                    $x = mysql_result($xq, 0);
                    $PremExist=TRUE;
                    if($x<=0){
                    $query = "SELECT COUNT(*) FROM $categories[$j];";
                    $xq = mysql_query($query);
                    $x = mysql_result($xq, 0);
                    
                    $PremExist=FALSE;
                    }
                    for ($i = 0; $i < $x ; $i++) {
                        if($PremExist){
                        $query2 = mysql_query("SELECT * FROM $categories[$j] WHERE PREMIUM=1;");}
                        else{
                            $query2 = mysql_query("SELECT * FROM $categories[$j];");
                        }
                        
                        
                        if ($query2) {
                            $itemID = mysql_result($query2, $i, "itemID");
                            $itemName = mysql_result($query2, $i, "name");
                            $price = mysql_result($query2, $i, "price");
                            $itemImage = mysql_result($query2, $i, "image");
                            $brandID = mysql_result($query2, $i, "brandID");
                         //   $pagelink=  mysql_result($query2, $i,"pagelink");
                            

                            echo"<div class=\"col-md-6\" id=\"";
                            echo $categories[$j]+$i;
                            echo "\"><div class=\"dev_cell_wide\"><div class=\"image pull-left\"id=\"";
                            echo $itemID;
                            echo "\"> <img src=\"img/tiles/".$itemID."/";
                            echo $itemImage;
                            echo "\"  width=\"57\" height=\"110\" alt=\"\" border=\"0\" itemprop=\"image\"></div><div class=\"panel-body\" ><div class=\"title cell_link\"><a href=\"/buy/item.php?i=";
                            echo $itemID;
                            echo "\" title=\"";
                            echo $itemID;
                            echo "\">";
                            echo $itemName;
                            echo "</a></div><div class=\"prices cell_link\"><a href=\"/buy/item.php?i=";
                            echo $itemID;
                            echo "\" title=\"";
                            echo $itemID;
                            echo "\">";
                            echo $brandID;
                            echo "<br>";
                          /*  if($j==1||$j==4||$j==6){
                                echo $type;
                                echo "<br>";
                            }*/
                            echo $price;
                            echo "</a></div><div class=\"buttons\"><a href=\"/buy/item.php?i=";
                            echo $itemID;
                            echo "\" class=\"btn btn-primary btn_buy\" title=\"";
                            echo $itemID;
                            echo "\">Buy</a>";#<a href=\"/sell.php?item";
                          #  echo $itemID;
                          #  echo "\"  class=\"btn btn-primary btn_sell\" title=\"";
                           # echo $itemID;
                            #echo "\">Sell</a>"
                            echo "</div></div></div></div>";
                        } else {
                            echo mysql_error();
                        }
                       
                    }
                    
                     
                }
                    
                    ?>

                

            </div>
        </div>













        <footer class="container">
            <div class="row" id="footer1"><!--padding top:10px, bgcolor:tanish?--->
                <div class="col-md-3">
                    <h3>Info</h3>
                    <ul>
                        <li>About Us</li>
                        <li>Contact Us</li>
                        <li>FAQ</li>
                        <li>Terms of Use</li>
                        <li>Policies</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>Buy and Sell Gear</h3>
                    <ul>

                        <li>Tugs</li>
                        <li>Harness</li>
                        <li>ETC</li>
                    </ul>
                </div></div>
            <div class="row">
                <div class="col-md-8">
                    <img src="img/malinoisLogo.jpg"/>
                </div>
                <div class="col-md-4">
                    Copyright????
                </div>
            </div>
        </footer>
    </body>

</html>