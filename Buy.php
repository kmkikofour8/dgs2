<html>


    <?php
    $var_value = $_GET['page'];
    $haystack = array('TUGS', 'COLLARS', 'HARNESSES', 'SUITS_SLEEVES', 'MUZZLES', 'ECOLLARS', 'LEASHES', 'OTHER');

    if (!in_array($var_value, $haystack, true)) {
        echo $var_value;
        header('HTTP/1.0 404 Not Found');
        header("Location: /404missing.html");
        die();
        exit();
    } else {
        include 'Header.php';
        
        # echo in_array($var_value, $haystack, true);
        $categories = array($var_value);
        $none = $var_value;
        if ($categories[0] == 'SUITS_SLEEVES') {
            $none = "SUITS/SLEEVES";
        }
        $j = 0;
	$categories[$j]=strtolower($categories[$j]);
        $query = "SELECT COUNT(*) FROM $categories[$j] WHERE APPROVED=1 AND SOLD=0 order by PREMIUM ;";
	$xq = mysql_query($query)  or die(mysql_error());
        $x = mysql_result($xq, 0);
        $PremExist = TRUE;
        if ($x <= 0) {
            $query = "SELECT COUNT(*) FROM $categories[$j] WHERE APPROVED=1 AND SOLD=0 order by PREMIUM desc;";
            $xq = mysql_query($query);
            $x = mysql_result($xq, 0);

            $PremExist = FALSE;
        }

        echo "<div id=\"row_";
        echo $categories[$j];
        echo "\" class=\"dev_grid dev_row\">";
        echo "<div class=\"row\">";
	if ($x == 0) {
            echo "<h3 style='text-align:center'> SORRY NO $none BEING SOLD RIGHT NOW</h3>";
        }
        for ($i = 0; $i < $x; $i++) {
            if ($PremExist) {
                $query2 = mysql_query("SELECT * FROM $categories[$j] WHERE APPROVED=1 AND SOLD=0 order by PREMIUM desc ;");
            } else {
                $query2 = mysql_query("SELECT * FROM $categories[$j] ;");
            }


            if ($i % 2 == 0 && $i != 0) {
                echo "</div><div class=\"row\">";
            }

            if ($query2) {

                $itemID = mysql_result($query2, $i, "itemID");
                $itemName = mysql_result($query2, $i, "name");
                $price = mysql_result($query2, $i, "price");
                $itemImage = mysql_result($query2, $i, "image");
                $brandID = mysql_result($query2, $i, "brandID");
                $seller = mysql_result($query2, $i, "sellerID");

                $q3 = mysql_query("SELECT google_email FROM google_users where google_id='" . $seller . "';");
                $sellerEmail = mysql_result($q3, 0);


                $q4 = "SELECT * FROM ratings WHERE rateID='".$seller."';";
                $x4 = mysql_query($q4);
                if (mysql_num_rows($x4) != 0) {
                    $stars = mysql_result($x4, 0, "stars");
                   
                } else {
                    $stars = 0;
              
                }
                $z=0;
                echo"<div class=\" col-md-6\" id=\"";
                echo $categories[$j] + $i;
                echo "\"><div class=\"dev_cell_wide\"><div class=\"image pull-left\"id=\"";
                echo $itemID;
                echo "\"> <img src=\"img/tiles/" . $itemID . "/";
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
                echo $price;
                echo "</a></div><div class=\"buttons\"><a href=\"buy/";
                echo $itemID;
                echo "\" class=\"btn btn-primary btn_buy\" title=\"";
                echo $itemID;
                echo "\">Buy</a></div></div><div class=\"panel-footer\" style='font-size:small; text-align:right' >" . $sellerEmail."<br>" ;
                for($z;$z<5;$z++){
                       if($z<$stars){
                        echo "<span style='font-size:x-small' id=\"starFill\">☆</span>";
                       }else{
                       echo "<span style='font-size:x-small' id=\"starNoFill\">☆</span>";
                       
                       }
                   }
                
                echo "</div></div></div>";
            } else {
                echo mysql_error();
            }
        }



        echo "</div></div></div>";
    }
    ?>
</body>
</html>
