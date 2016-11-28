<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'Header.php';

//require_once 'Mobile_Detect.php';
//$detect = new Mobile_Detect;
//$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
?>

<html>

    <!-- for tiles______________________________________________    --->
    <?php
    error_reporting(E_ERROR | E_PARSE);
    $categories = array('tugs', 'collars', 'harnesses', 'suits_sleeves', 'muzzles', 'ecollars', 'leashes', 'other');
    $cats2 = array('tugs', 'collars', 'harnesses', 'suits/sleeves', 'muzzles', 'ecollars', 'leashes', 'other');
    for ($j = 0; $j < 8; $j++) {
        $count = 0;



        $query = "SELECT COUNT(*) FROM $categories[$j] WHERE PREMIUM=1 AND SOLD=0 AND APPROVED=1;";
        $xq = mysql_query($query);
        $x = mysql_result($xq, 0);
        $PremExist = TRUE;
        if ($x != 0) {

            $count++;
            echo "<div id=\"row_";
            echo $categories[$j];
            echo "\" class=\"row wrap\"><div class=\"col-md-12 navbar navbar-default subnav catsep\"><h4><a href=\"/Buy.php?page=";
            echo strtoupper($categories[$j]) . "\">" . strtoupper($cats2[$j]) . "</a></h4></div>";





            for ($i = 0; $i < $x; $i++) {
                if ($PremExist) {
                    $query2 = mysql_query("SELECT * FROM $categories[$j] WHERE PREMIUM=1 AND SOLD=0 AND APPROVED=1;");
                } else {
                    $query2 = mysql_query("SELECT * FROM $categories[$j] WHERE SOLD=0;");
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


                    $q4 = "SELECT * FROM ratings WHERE rateID='" . $seller . "';";
                    $x4 = mysql_query($q4);
                    if (mysql_num_rows($x4) != 0) {
                        $stars = mysql_result($x4, 0, "stars");
                    } else {
                        $stars = 0;
                    }
                    $z = 0;




                    //   $pagelink=  mysql_result($query2, $i,"pagelink");
                    ?>
                    <div class="col-md-6" id="<?php echo $categories[$j] + $i; ?>">
                        <div class="dev_cell_wide">
                            <div class="image pull-left"id="<?php echo $itemID; ?>">
                                <img src="img/tiles/<?php echo $itemID . "/" . $itemImage ?>"  width="57" height="110" alt="" border="0" itemprop="image">
                            </div>
                            <div class="panel-body" ><div class="title cell_link">
                                    <a href="/buy/<?php echo $itemID; ?>" title="<?php echo $itemID; ?>"><?php echo $itemName; ?></a>
                                </div>
                                <div class="prices cell_link">
                                    <a href="/buy/<?php echo $itemID; ?>" title="<?php echo $itemID; ?>"><?php echo $brandID; ?>
                                        <br>
                <?php echo $price; ?>
                                    </a>
                                </div>
                                <div class="buttons">
                                    <a href="/buy/<?php echo $itemID; ?>" class="btn btn-primary btn_buy" title="<?php echo $itemID; ?>">Buy</a>

                                </div></div>
                            <div class="panel-footer" style="font-size:small; text-align:right">
                <?php
                echo $sellerEmail . "<br>  ";
                for ($z; $z < 5; $z++) {
                    if ($z < $stars) {
                        echo "<span style='font-size:x-small' id=\"starFill\">☆</span>";
                    } else {
                        echo "<span style='font-size:x-small' id=\"starNoFill\">☆</span>";
                    }
                }
                ?>


                            </div>

                        </div></div>
                    <?php
                } else {
                    echo mysql_error();
                }
            }
            echo "</div>";
        }
    }
    ?>



</div>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . "Footer.php"; ?>
</html>