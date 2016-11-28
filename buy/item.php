<html>
    <body >
        <?php
        $var_value = $_GET['i'];

        include $_SERVER['DOCUMENT_ROOT'] . 'Header.php';
        $type = substr($var_value, 0, 1);

        switch ($type) {
            case 't': {
                    $categories = 'tugs';
                    break;
                }
            case 'l': {
                    $categories = 'leashes';
                    break;
                }
            case 's': {
                    $categories = 'suits_sleeves';
                    break;
                }
            case 'c': {
                    $categories = 'collars';
                    break;
                }
            case 'e': {
                    $categories = 'ecollars';
                    break;
                }
            case 'm': {
                    $categories = 'muzzles';
                    break;
                }
            case 'o': {
                    $categories = 'other';
                    break;
                }
            case 'h': {
                    $categories = 'harnesses';
                    break;
                }
        }
        $query = "SELECT * FROM $categories WHERE itemID=\"$var_value\";";
        $result = mysql_query($query);
        $itemID = mysql_result($result, 0, "itemID");
        $name = mysql_result($result, 0, "name");
        $brandID = mysql_result($result, 0, "brandID");
        $price = mysql_result($result, 0, "price");
        $description = mysql_result($result, 0, "description");
        $sellerID = mysql_result($result, 0, "sellerID");
        $mainImage = mysql_result($result, 0, "image");
        $color = mysql_result($result, 0, "color");
        $size = mysql_result($result, 0, "size");
        $created = mysql_result($result, 0, "created");
        $sellfee = mysql_result($result, 0, "sale_fee");
        $quantity = mysql_result($result, 0, "quantity");
        $sold = mysql_result($result, 0, "sold");
        $q2 = "SELECT COUNT(*) FROM IMAGES WHERE itemID=\"$itemID\";";
        #$query2 = "select count(*) from images where itemID=\'$itemID\';";
        $xx = mysql_query($q2);
        $imageNum = mysql_result($xx, 0);
        $q3 = "SELECT * FROM google_users WHERE google_id=\"$sellerID\";";

        $x2 = mysql_query($q3);
        $sellerImage = mysql_result($x2, 0, "google_picture_link");
        $email = mysql_result($x2, 0, "google_email");
        $ratingsID = mysql_result($x2, 0, "ratingID");


        $q4 = "SELECT * FROM ratings WHERE rateID=\"$ratingsID\";";
        $x4 = mysql_query($q4);
        if (mysql_num_rows($x4) != 0) {
            $stars = mysql_result($x4, 0, "stars");
           
        } else {
            $stars = 0;
           
        }

        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#buy_now").click(function () {
<?php
if (isset($_SESSION['login_user'])) {
    $_SESSION['iprice'] = $price;
    $_SESSION['ititle'] = $name;
    $_SESSION['iid'] = $itemID;
    echo "window.location = '/vendor/payment3.php'";
} else {

    echo "window.location = '/login/index.php'";
}
?>

                })
            });

        </script>
        <div class="row item_container container-fluid wrap" >
            <div class="row">
                <div class="col-md-4" >
                    <?php echo '<a class="example-image-link" href="/img/tiles/' . $itemID . "/" . $mainImage . '" data-lightbox="mainImage" data-title=""><img src="/img/tiles/' . $itemID . "/" . $mainImage . '" alt=""/></a>';
                    ?></div>
                <div class="col-md-4">
                    <div class="row">
                        <div id="div_price" class="panel-success item_container1">
                            <div class="panel-heading" id="title"><?php echo $name . "" ?><span style="font-size:.8em"><?php echo "<br>Created: " . $created ?></span> </div>
                            <div class="panel-body">
                                <h2 style="display: inline" id="price">$<?php echo $price ?></h2>
                                <?php
                                if ($sold == 0) {
                                    echo " <a href=\"";
                                    if (isset($_SESSION['login_user'])) {
                                        $_SESSION['iprice'] = $price;
                                        $_SESSION['ititle'] = $name;
                                        $_SESSION['iid'] = $itemID;
                                        echo "/vendor/payment3.php\"";
                                    } else {
                                        echo "/login/index.php\"";
                                    }

                                    echo ' id="buy_now" class="btn btn-primary btn_buy" style="float:right">Buy Now</a>';
                                } else
                                    echo '<button disabled id="buy_now" class="btn btn-primary btn_buy" style="float:right">Sold</a>';
                                ?>
                            </div>
                        </div></div>
                    <div class="row">
                        <table class="table table-bordered table-condensed table-centered item_container1 " id="item_table" style="margin-top:10px;">
                            <tbody>
                                <tr style="color: #888888; font-weight: bold;">
                                    <th>
                                        Item ID
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Brand
                                    </th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Size
                                    </th>


                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $itemID ?>
                                    </td>
                                    <td>
                                        <?php echo $quantity ?>
                                    </td>
                                    <td>
                                        <?php echo $brandID ?>
                                    </td>
                                    <td>
                                        <?php echo $color ?>
                                    </td>
                                    <td>
                                        <?php echo $size ?>
                                    </td>

                                </tr>


                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="col-md-4" >
                    <div class="panel-success item_container1">
                        <div class="panel-heading sellerInfo" id="sellerInfo">
                            Seller Information
                            <a  <?php echo "href='/user.php?id=" . $email . "'" ?>>
                                <img id="pIcon" src='/img/pIcon.png'/>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a  <?php echo "href='/user.php?id=" . $email . "'" ?>>
                                    <?php echo $email ?>
                                </a>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="rating col-md-8">
                                <?php
                                for ($j = 0; $j < 5; $j++) {
                                    if ($j < $stars) {
                                        echo "<span id=\"starFill\">☆</span>";
                                    } else {
                                        echo "<span id=\"starNoFill\">☆</span>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Images
                        </div>
                    

                    <div class="panel-body">

                        <?php
                        $q5 = "SELECT COUNT(*) FROM images WHERE itemID=\"$itemID\";";
                        $x5 = mysql_query($q5);
                        $Imgcount = mysql_result($x5, 0);
                        $q6 = "SELECT * FROM images WHERE itemID=\"$itemID\";";
                        $x6 = mysql_query($q6);
                        for ($i = 0; $i < $Imgcount; $i++) {
                            $Imgpath = mysql_result($x6, $i, "imagePath");
                            echo '<a class="example-image-link" href="' . $Imgpath . '" data-lightbox="example-set" data-title=""><img class="example-image" src="' . $Imgpath . '" alt=""/></a>';
                        }
                        ?>


                    </div>
                </div>
                </div></div>
            <div class="row wrap">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            Description
                        </div>
                        <div class="panel-body">
                            <p>  <?php
                            echo $description
                                    ?></p>
                        </div>
                    </div>
                </div>





                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Shipping & Handling Information
                        </div>
                        <div class="panel-body">
                            <?php
                            $q78 = "SELECT * FROM shipping WHERE itemID=\"$itemID\" AND sellerID=\"$sellerID\";";
                            $x7 = mysql_query($q78);
                            $shipFrom = mysql_result($x7, 0, "shipFrom");
                            $shipTo = mysql_result($x7, 0, "shipTo");
                            $paypal = mysql_result($x7, 0, "paypal");
                            $returns = mysql_result($x7, 0, "returns");
                            echo "The item will ship from: <strong><span id=\"shipFrom\"> ";
                            echo $shipFrom;
                            echo "</span></strong><br>The item will ship to: <strong><span id=\"shipTo\">";
                            echo $shipTo;
                            echo "</span></strong><br>Return Policy:<strong> ";
                            echo $returns . "</strong>";
                            ?>
                            <br>
                            Shipping Policies
                        </div>
                    </div>

                </div>
            </div>
            <hr>                
            <section id="section_comments">
                <div class="row">
                    <div class="col-md-8">

                        <div class="comments">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-comments"></i>
                                    <?php
                                    $q8 = "SELECT COUNT(*) FROM comments WHERE itemID=\"$itemID\";";
                                    $x8 = mysql_query($q8);
                                    $commCount = mysql_result($x8, 0);
                                    ?>
                                    Comments <span class="badge"><?php echo $commCount; ?></span>
                                    <div class="inline pull-right" style="font-weight: normal;">



                                        <a href="/listing/XEP927/subscribe" class="btn btn-warning">Subscribe</a>



                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <ul class="list-group">
                                    <?php
                                    $q9 = "SELECT * FROM comments WHERE itemID=\"$itemID\";";
                                    for ($k = 0; $k < $commCount; $k++) {

                                        $x9 = mysql_query($q9);
                                        $commentSellID = mysql_result($x9, $k, "google_email");
                                        $comment = mysql_result($x9, $k, "comment");
                                        $uname = mysql_result($x9, $k, "name");
                                        $commentDate = mysql_result($x9, $k, "date");
                                        $q10 = "SELECT google_picture_link FROM google_users where google_email=\"$commentSellID\";";

                                        $x10 = mysql_query($q10);
                                        $pPic = mysql_result($x10, 0);



                                        echo '<li class="list-group-item"><div class="comment"><div class="media"><a class="propic pull-left" href="/user/' . $commentSellID . '" rel="nofollow"><img class="media-object" src="' . $pPic . '" width="50" height="50" border="0"></a><div class="media-body"><a href="/user/' . $commentSellID . '" rel="nofollow">' . $uname . '</a><div class="text"><p>' . $comment . '</p></div></div></div></div></li>';
                                    }
                                    ?>

                                </ul>
                            </div>









                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-comment-o"></i>
                                    Post Comment
                                </div>
                                <div class="panel-body">


                                    <?php
                                    if (isset($_SESSION['login_user'])) {


                                        echo '<form id="formComment" action="/update.php" method="post" role="form">
                                        <input type="hidden" name="itemID" value="'.$itemID.'"/>
                                        <input id="id_canned_key" name="canned_key" type="hidden" class="form-control">
                                        <div class="form-group">

                                            <label class="sr-only" for="id_comment">Comment</label>
                                            <textarea class="form-control" id="id_comment" name="comment" placeholder="Comment"></textarea>
                                        </div>
                                        <div id="comment_errors" class="errors"></div>
                                        <div>
                                            <div style="float: left;">
                                                <button id="submit_button" class="btn btn-primary">Post Comment</button>
                                            </div>



                                            <div style="float: left; padding-left: 10px; margin-top:-4px;">
                                                <input id="id_notify_staff" name="notify_staff" type="checkbox">
                                                <span>Swappa Staff, I need help!</span>
                                                <br>

                                                <input checked="checked" id="id_subscribe" name="subscribe" type="checkbox">
                                                <span>Subscribe (get email notifications when others comment)</span>

                                            </div>



                                            <div style="clear: both;"></div>
                                        </div>
                                    </form>';
                                    } else{
                                    echo "<p> You must first login to post a comment</p>";}
                                    ?>
                                </div>




                            </div>





                        </div>



                        <p class="alert alert-white">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <a href="/faq/answer/appropriate_listing_comments" target="_blank">
                                What comments are appropriate for listings and what's not allowed?</a>
                        </p>

                        <p class="alert alert-success">
                            When you're ready, just click the green <b>Buy Now</b> button towards the top-right of the page. 
                            Swappa will handle the PayPal transaction, take you to a private page where you and the seller can communicate, 
                            and help you track the shipment from the seller.
                        </p>
                    </div>

                    <!-- Side -->
                    <div class="col-md-4">
                        <!-- Ting Ad -->

                    </div>

                </div>
            </section>

        </div>
    </body>
</html>
