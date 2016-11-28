<?php
include $_SERVER['DOCUMENT_ROOT'] . 'user/userHeader.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
    </head>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div class="row">
        <div class="col-md-12" style="padding-top: 100px;">
            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        Items Bought
                    </strong>
                </div>
                <div class="panel-body">
                    <?php
                    $x = $_SESSION['login_user'];
                    $query = mysql_query("select itemID from transactions where title!='Premium Fee' AND buyerID='$x' AND toWho!='xjordon11x-facilitator@gmail.com'");
                    $numAff = mysql_num_rows($query);
                    $all = "";
                    if ($numAff == 0) {
                        echo "You have not bought any items.";
                    } else {
                        for ($i = 0; $i < $numAff; $i++) {
                            $ii = mysql_result($query, $i);
                            $type = substr($ii, 0, 1);

                            switch ($type) {
                                case 't': {
                                        $categories = 'Tugs';
                                        break;
                                    }
                                case 'l': {
                                        $categories = 'Leashes';
                                        break;
                                    }
                                case 's': {
                                        $categories = 'Suits_Sleeves';
                                        break;
                                    }
                                case 'c': {
                                        $categories = 'Collars';
                                        break;
                                    }
                                case 'e': {
                                        $categories = 'Electronic Collars';
                                        break;
                                    }
                                case 'm': {
                                        $categories = 'Muzzles';
                                        break;
                                    }
                                case 'o': {
                                        $categories = 'Other';
                                        break;
                                    }
                                case 'h': {
                                        $categories = 'Harnesses';
                                        break;
                                    }
                            }
                            $query1 = "SELECT * FROM $categories WHERE itemID=\"$ii\";";
                            $result = mysql_query($query1);

                            $name = mysql_result($result, 0, "name");
                            $brandID = mysql_result($result, 0, "brandID");
                            $price = mysql_result($result, 0, "price");
                            $description = mysql_result($result, 0, "description");
                            $mainImage = mysql_result($result, 0, "image");

                            if ($i < 3) {
                                //get image, and name and price
                                echo '<div class=" col-md-4" id="' . $ii . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii . '">'
                                . ' <img src="/img/tiles/' . $ii . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '">'
                                . $name . '</a>'
                                . '</div><div class="prices cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii . '" class="btn btn-primary btn_buy" title="t0">Look</a></div></div><div class="clearfix"></div></div></div>';
                            } else {

                                $all.='<div class=" col-md-4" id="' . $ii . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii . '">'
                                        . ' <img src="/img/tiles/' . $ii . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                        . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '">'
                                        . $name . '</a>'
                                        . '</div><div class="prices cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii . '" class="btn btn-primary btn_buy" title="t0">Look</a></div></div><div class="clearfix"></div></div></div>';
                            }
                        }
                    }
                    ?>
                </div>


                <div id="allbought" class="panel-body">
                    <?php echo $all ?>
                </div>
                <div class="panel-footer" style="text-align: right;">
                    <?php if ($all != "") echo '<button id="boughtItems" class="btn btn-primary btn_buy">See All Your Bought Items»</button>'; ?>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        Items Sold
                    </strong>
                </div>


                <div class="panel-body">

                    <?php
                    $x = $_SESSION['login_user'];
                    $query = mysql_query("select itemID from transactions where title!='Premium Fee' AND sellerGoogleID='$x'");
                    $numAff = mysql_num_rows($query);
                    $allsold = "";

                    if ($numAff == 0) {
                        echo "You have not sold any items.";
                    } else {
                        for ($i = 0; $i < 3 && $i < $numAff; $i++) {
                            $ii2 = mysql_result($query, $i);
                            $type = substr($ii2, 0, 1);

                            switch ($type) {
                                case 't': {
                                        $categories = 'Tugs';
                                        break;
                                    }
                                case 'l': {
                                        $categories = 'Leashes';
                                        break;
                                    }
                                case 's': {
                                        $categories = 'Suits_Sleeves';
                                        break;
                                    }
                                case 'c': {
                                        $categories = 'Collars';
                                        break;
                                    }
                                case 'e': {
                                        $categories = 'Electronic Collars';
                                        break;
                                    }
                                case 'm': {
                                        $categories = 'Muzzles';
                                        break;
                                    }
                                case 'o': {
                                        $categories = 'Other';
                                        break;
                                    }
                                case 'h': {
                                        $categories = 'Harnesses';
                                        break;
                                    }
                            }
                            $query1 = "SELECT * FROM $categories WHERE itemID=\"$ii2\";";
                            $result = mysql_query($query1);

                            $name = mysql_result($result, 0, "name");
                            $brandID = mysql_result($result, 0, "brandID");
                            $price = mysql_result($result, 0, "price");
                            $description = mysql_result($result, 0, "description");
                            $mainImage = mysql_result($result, 0, "image");

                            if ($i < 3) {
                                //get image, and name and price
                                echo '<div class=" col-md-4" id="' . $ii2 . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii2 . '">'
                                . ' <img src="/img/tiles/' . $ii2 . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii2 . '" title="' . $ii2 . '">'
                                . $name . '</a>'
                                . '</div><div class="prices cell_link"><a href="/buy/' . $ii2 . '" title="' . $ii2 . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii2 . '" class="btn btn-primary btn_buy" title="t0">Look</a></div></div><div class="clearfix"></div></div></div>';
                            } else {
                                $allsold.='<div class=" col-md-4" id="' . $ii2 . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii2 . '">'
                                        . ' <img src="/img/tiles/' . $ii2 . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                        . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii2 . '" title="' . $ii2 . '">'
                                        . $name . '</a>'
                                        . '</div><div class="prices cell_link"><a href="/buy/' . $ii2 . '" title="' . $ii2 . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii2 . '" class="btn btn-primary btn_buy" title="t0">Look</a></div></div><div class="clearfix"></div></div></div>';
                            }
                        }
                    }
                    ?>
                </div>

                <div id="allsold" class="panel-body">
                    <?php echo $allsold ?>
                </div>
                <div class="panel-footer" style="text-align: right;">
                    <?php if ($allsold != "") echo '<button id="soldItems" class="btn btn-primary btn_buy">See All Your Sold Items»</button>'; ?>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        Active Listings
                    </strong>
                </div>


                <div class="panel-body">


                    <?php
                    if(isset($_GET['userid'])){
                        if($_GET['userid']!=$_SESSION['login_user']){
                            header("Location: ".$_SERVER['DOCUMENT_ROOT'] ."user/user.php");
                        }
                    }
                    $x = $_SESSION['login_user'];
                    $categories = array('tugs', 'collars', 'harnesses', 'suits_sleeves', 'muzzles', 'ecollars', 'leashes', 'other');
                    $numAlive = 0;
                    $allactive = "";
                    foreach ($categories as &$y) {
                        $result2 = mysql_query("select * from $y where sellerID='$x' AND SOLD=0 order by premium desc");
                        $numAff = mysql_num_rows($result2);

                        if ($numAff != 0 && $numAlive < 3) {

                            for ($i = 0; $i < $numAff; $i++) {
                                $ii = mysql_result($result2, $i, "itemID");
                                $name = mysql_result($result2, $i, "name");
                                $brandID = mysql_result($result2, $i, "brandID");
                                $price = mysql_result($result2, $i, "price");
                                $description = mysql_result($result2, $i, "description");

                                $mainImage = mysql_result($result2, $i, "image");
                                

                                if ($i < 3) {
                                    echo '<div class=" col-md-4" id="' . $ii . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii . '">'
                                    . ' <img src="/img/tiles/' . $ii . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                    . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '">'
                                    . $name . '</a>'
                                    . '</div><div class="prices cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii . '" class="btn btn-primary btn_buy" title="t0">Buy</a></div></div><div class="clearfix"></div></div></div>';
                                    $numAlive++;
                                } else {
                                    $allactive.='<div class=" col-md-4" id="' . $ii . '"><div class="dev_cell_wide"><div class="image pull-left" id="' . $ii . '">'
                                            . ' <img src="/img/tiles/' . $ii . '/' . $mainImage . '" width="57" height="110" alt="" border="0" itemprop="image">'
                                            . '</div><div class="panel-body"><div class="title cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '">'
                                            . $name . '</a>'
                                            . '</div><div class="prices cell_link"><a href="/buy/' . $ii . '" title="' . $ii . '"> <span class="brandName">' . $brandID . '</span><br>' . $price . '</a></div><div class="buttons"><a href="/buy/' . $ii . '" class="btn btn-primary btn_buy" title="t0">Buy</a></div></div><div class="clearfix"></div></div></div>';
                                    $numAlive++;
                                }
                            }
                        }
                    }
                    if ($numAlive == 0) {
                        echo "You do not have any active listings.";
                    }
                    ?>
                </div>


                <div id="allactive" class="panel-body">
                    <?php if($numAlive !=0) echo $allactive; ?>
                </div>
                <div class="panel-footer" style="text-align: right;">
                    <?php if ($allactive != "") echo '<button id="activeItems" class="btn btn-primary btn_buy">See All Active Listings»</button>'; ?>
                </div>
            </div>

        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>
