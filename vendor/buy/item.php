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
        
        <script src="/js/buy.js"></script>
        
    </head>
    <body >
        <?php
        
        $var_value = $_GET['i'];
        
            include $_SERVER['DOCUMENT_ROOT'].'Header.php';
        $type = substr($var_value, 0, 1);
        
        switch ($type) {
            case 't': {$categories = 'Tugs';break;}
            case 'l': {$categories = 'Leashes';break;}
            case 's': {$categories = 'Suits_Sleeves';break;}
            case 'c': {$categories = 'Collars';break;}
            case 'e': {$categories = 'Electronic Collars';break;}
            case 'm': {$categories = 'Muzzles';break;}
            case 'o': {$categories = 'Other';break;}
            case 'h': {$categories = 'Harnesses';break;}
        }
        $query = "SELECT * FROM $categories WHERE itemID=\"$var_value\";";
        $result = mysql_query($query);
        $itemID = mysql_result($result, 0, "itemID");
        $name = mysql_result($result, 0, "name");
        $brandID = mysql_result($result, 0, "brandID");
        $price = mysql_result($result, 0, "price");
        $description = mysql_result($result, 0, "description");
        $sellerID = mysql_result($result, 0, "sellerID");
        $mainImage=  mysql_result($result, 0, "image");
        $color=  mysql_result($result, 0, "color");
        $size=  mysql_result($result, 0, "size");
        $created=  mysql_result($result, 0, "created");
        $sellfee=mysql_result($result,0,"sale_fee");
        $quantity=mysql_result($result,0,"quantity");
        
        $q2="SELECT COUNT(*) FROM IMAGES WHERE itemID=\"$itemID\";";
        #$query2 = "select count(*) from images where itemID=\'$itemID\';";
        $xx = mysql_query($q2);
        $imageNum = mysql_result($xx, 0);
        $q3="SELECT * FROM SELLER WHERE sellerID=\"$sellerID\";";
        $x2=  mysql_query($q3);
        $sellerImage=  mysql_result($x2, 0,"profilePic");
        $email=  mysql_result($x2, 0,"email");
        $ratingsID=  mysql_result($x2, 0, "ratingID");
        $location=  mysql_result($x2,0, "location");
        
        $q4="SELECT * FROM ratings WHERE ratingsID=\"$ratingsID\";";
        $x4=  mysql_query($q4);
        $stars=  mysql_result($x4, 0,"stars");
        $numReviews=  mysql_result($x4, 0,"numReviews");
        
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#buy_now").click(function(){
                    <?php
                    if(isset($_SESSION['login_user'])){
                      
                        echo "window.location = '/vendor/payment3.php?title=".$name."&price=".$price."&id=".$itemID."'";
                    }
                    else {
                        $_SESSION['ref']="/buy/item.php?i=".$itemID;
                        echo "window.location = '/login/loginPage.php'";
                    }
                    ?>
                    
                })   
            });
            
            </script>
        <div class="row item_container container-fluid wrap" >
            <div class="row">
                <div class="col-sm-6 col-md-4" >
                    <img src="/img/tiles/<?php echo $itemID."/".$mainImage ?>"/></div>
                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <div id="div_price" class="panel-success item_container1">
                        <div class="panel-heading" id="title"><?php echo $name?></div>
                        <div class="panel-body">
                            <h2 style="display: inline" id="price"><?php echo $price ?></h2>
                            <button id="buy_now" class="btn btn-primary btn_buy" style="float:right">Buy Now</button>
                        </div>
                        </div></div>
                    <div class="row">
                   
                      <table class="table table-bordered table-condensed table-centered item_container1 " style="margin-top:10px;">
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
                                          <th>
                                              Created
                                          </th>
                                          
                                      </tr>
                                      <tr>
                                          <td>
                                              <?php echo $itemID?>
                                          </td>
                                          <td>
                                              <?php echo $quantity?>
                                          </td>
                                          <td>
                                              <?php echo $brandID?>
                                          </td>
                                          <td>
                                              <?php echo $color?>
                                          </td>
                                          <td>
                                              <?php echo $size?>
                                          </td>
                                          <td>
                                              <?php echo $created?>
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
                               <a  <?php echo "href='/user.php?id=".$sellerID."'" ?>>
                             <img id="pIcon" src='/img/pIcon.png'/>
                         </a>
                     </div>
                    <div class="row">
                        <div class="col-md-3">
                            <a  <?php echo "href='/user.php?id=".$sellerID."'" ?>>
                            <?php echo $sellerID
                                    ?></a>
                        </div>
                        <div class="col-md-3">
                            <?php echo $email?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $location?>
                        </div>
                    </div>
                    <div class="row">
                    <div class="rating col-md-8">
                    <?php 
                    for($j=0;$j<5;$j++){
                       if($j<$stars){
                        echo "<span id=\"starFill\">☆</span>";
                       }else{
                       echo "<span id=\"starNoFill\">☆</span>";}
                   }
                    ?>
                    </div>
                    </div>
                    </div>
                </div>
                        
                </div>
            
            <hr>
            <div class="row wrap">
                
            <div class="panel panel-default">
                <div class="panel-heading">
                    Images
                </div>
            </div>
            <div class="panel-body">
                
                    <?php 
                     $q5="SELECT COUNT(*) FROM images WHERE itemID=\"$itemID\";";
                     $x5=  mysql_query($q5);
                     $Imgcount=  mysql_result($x5, 0);
                     $q6="SELECT * FROM images WHERE itemID=\"$itemID\";";
                     $x6=  mysql_query($q6);
                     for($i=0;$i<$Imgcount;$i++){
                        $Imgpath=  mysql_result($x6, $i, "imagePath");
             
                         echo "<a href=\"$Imgpath\"   rel=\"lightbox\">";
                         echo "<div class=\"col-md-1\"><img class=\"smallImage \"src=\"$Imgpath\"/></div></a>";
                     }
                     
                    ?>
                
                
            </div></div>
            <div class="row wrap">
                <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    Description
                    </div>
                <div class="panel-body">
                    <?php 
                    echo $description
                    ?>
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
                     $q78="SELECT * FROM shipping WHERE itemID=\"$itemID\" AND sellerID=\"$sellerID\";";
                     $x7=mysql_query($q78);
                     $shipFrom=  mysql_result($x7, 0, "shipFrom");
                     $shipTo=mysql_result($x7,0,"shipTo");
                     $paypal=mysql_result($x7,0,"paypal");
                     $returns=mysql_result($x7,0,"returns");
                     echo "The item will ship from: <span id=\"shipFrom\"> ";
                     echo $shipFrom;
                     echo "</span><br>The item will ship to: <span id=\"shipTo\">";
                     echo $shipTo;
                     echo "</span><br>Return Policy: ";
                     echo $returns;
                     ?>
                        <br>
                        Shipping Policies
                    </div>
                </div>

            </div>
                  </div>
            <hr>                
            <div class="row wrap">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Comments
                </div>
                    <div class="panel-body"> 
                        <div>
                            <form method="GET" action="/update.php">
                               
                                <input type="text" name="commentz" id="comment"/>
                                <button type="submit" id="comment_submit" >Submit</button>
                                <input type="hidden" name="itemID" value="<?php echo $itemID?>"/>
                                <!--<input type="hidden" name="sellerID" value="<php echo $sellerID #need to change this seller id to customerID   ?>"/>-->
                                <?php if(isset($_SESSION['login_user']))
                                    echo "<input type=\"hidden\" name=\"username\" value=\"".$_SESSION['login_user']."\"/>";
                                else
                                    echo "YOU MUST LOGIN IN TO MAKE A COMMENT"
                                    ?>
                                
                            </form>
                        </div>
                        <div class="comment-group">
                        <?php
                        $q8="SELECT COUNT(*) FROM comments WHERE itemID=\"$itemID\";";
                        $x8=mysql_query($q8);
                        $commCount=mysql_result($x8, 0);
                        echo "<ul>";
                        for($k=0;$k<$commCount;$k++){
                        $q9="SELECT * FROM comments WHERE itemID=\"$itemID\";";
                        $x9=mysql_query($q9);
                        $commentSellID=  mysql_result($x9, $k,"username");
                        $comment=  mysql_result($x9, $k, "comment");
                        $commentDate=mysql_result($x9,$k,"date");
                        $q10="SELECT profilePic FROM seller where sellerID=\"$commentSellID\";";
                        $x10=  mysql_query($q10);
                        $pPic=  mysql_result($x10, 0);
                        echo "<li class=comment><div class=\"pull-left\"><a href=\"/user.php?id=".$commentSellID."\"><img class=\"propic\" src=\"".$pPic."\"></div><div>".$commentSellID."</a> ".$commentDate."<br> ".$comment."</div>";}
                        ?>
                        </div>
                    </div>
                </div>
            
        </div>
        
    </div>
    </body>
</html>