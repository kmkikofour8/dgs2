<html>
<?php
         include $_SERVER["DOCUMENT_ROOT"]."Header.php";

         ?>
    <head>
    <!-- JavaScript Includes -->
	
		<script src="/sell/assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="/sell/assets/js/jquery.ui.widget.js"></script>
		<script src="/sell/assets/js/jquery.iframe-transport.js"></script>
		<script src="/sell/assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="/sell/assets/js/script1.js"></script>
                
                <script src="/dropzone.js"></script>
                <link href="/dropzone.css" rel="stylesheet"/>
                <script src="/js/dz.js"></script>
    </head>
    <body >
        <?php
    

        $_SESSION['sale_fee']=$_POST['sale_fee'];
        $sellerID=$_SESSION['login_email'];
        $_SESSION['quantity']=$quantity = $_POST['quantity'];
        $_SESSION['title']=$title=$_POST['title'];
        $_SESSION['description']=$description=$_POST['description'];
        $_SESSION['brandID']=$brandID=$_POST['brandID'];
        $_SESSION['color']=$color=$_POST['color'];
        $_SESSION['size']=$size=$_POST['size'];
        $_SESSION['shipFrom']=$shipFrom=$_POST['shipFrom'];
        $_SESSION['shipTo']=$shipTo=$_POST['shipTo'];
        $_SESSION['return']=$return=$_POST['return'];
        $_SESSION['price']=$price=$_POST['ask_price'];
        $_SESSION['iID']=$iID=$_POST['iID'];
        $_SESSION['selliID']=$_SESSION['login_user'];
        $_SESSION['paypal']=$paypal=$_POST['paypal'];
        
        $q3="SELECT * FROM google_users WHERE google_email=\"$sellerID\";";
        $x2=  mysql_query($q3);
        
        $sellerName=mysql_result($x2, 0, "google_name");
        $sellerImage=  mysql_result($x2, 0,"google_picture_link");
        $email=  mysql_result($x2, 0,"google_email");
        $ratingsID=  mysql_result($x2, 0, "ratingID");
        $location=  mysql_result($x2,0, "location");
        
        $q4="SELECT * FROM ratings WHERE ratingsID=\"$ratingsID\";";
        $x4=  mysql_query($q4);
        if(mysql_num_rows($x4)!=0){
        $stars=  mysql_result($x4, 0,"stars");
        $numReviews=  mysql_result($x4, 0,"numReviews");
        }
        else{
            $stars=0;
            $numReviews=0;
        } 
            
        ?>
        <div class="row item_container container-fluid wrap" >
            <div class="row">
                <div class="col-sm-6 col-md-4" >
                    <form action="/sell/upload.php" id="dropzone1" class="dropzone">
                    <input type="hidden" name="iID" value="<?php echo $iID?>"/>   
                    </form>
			
                    <input type="hidden" id="mainImage" value=""/>
                </div>
	
        
		

                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <div id="div_price" class="panel-success item_container1">
                        <div class="panel-heading" id="title"><?php echo $title?></div>
                        <div class="panel-body">
                            <div class="row">
                            <!--<div class="col-md-8"> <?php echo $description ?></div>-->
                                <div class="col-md-12"><h4><strong> Price: $<?php echo $price ?></strong></h4></div>
                            </div>
                            </div>
                        </div></div>
                    <div class="row">
                   
                      <table class="table table-bordered table-condensed table-centered item_container1" style="margin-top:10px;">
                                  <tbody>
                                      <tr style="color: #888888; font-weight: bold;">
                                          <th>
                                              Item ID
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
                                          <td id="iID"><?php echo $iID?></td>
                                          <td id="brandID"><?php echo $brandID?></td>
                                          <td id="color"><?php echo $color?></td>
                                          <td id="size"><?php echo $size?></td>
                                          <td id="date"><?php $mydate=getdate(date("U"));
echo "$mydate[month] $mydate[mday], $mydate[year]";?></td>
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
                        <div class="col-md-6">
                            <a  <?php echo "href='/user.php?id=".$sellerID."'" ?>>
                            <span id="sellerID"><?php echo $sellerName?></span></a>
                        </div>
                        <div class="col-md-6">
                            <?php echo $email?>
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
                    </div></div>
                         <div class='row'>
                        <div class='col-md-4 widget form-control' >
                            PayPal: <?php echo $paypal?></div>
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
                <b>You MUST upload a verification photo in order for your listing to be approved and posted. <a class="button" href="#popup1" >What is a verification photo?</a></b>
                <br>Your verification number is: <b>
                    <?php
function new_rand(){                    $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
    return $rand;
}
function check($raa){
    $q31="SELECT COUNT(verificationNum) FROM verification WHERE verificationNum=\"$raa\";";
        $x12=  mysql_query($q31);
        $zz=mysql_result($x12, 0);
if($zz==0)
    return 0;
else
    return 1;
        
};
$rand=new_rand();
while(check($rand)==1){
    $rand=new_rand();
}
    echo $rand;
    $_SESSION['verification']=$rand
                    
                    ?>
                </b>
                <form action="/sell/upload.php" id="dropzone2" class="dropzone">
                    <input id="iID" type="hidden" name="iID" value="<?php echo $iID?>"/>
                </form>
                  
                
                
            </div></div>
            
            <div class="row wrap">
                <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    Description
                    </div>
                <div class="panel-body" id="description"><?php echo $description?></div>
            </div>
                </div>
                    
          
               
                
           
                <div class="col-md-4">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping & Handling Information
                </div>
                    <div class="panel-body">
                     <?php
                    
                     echo "The item will ship from: <span id=\"shipFrom\"> ";
                     echo $shipFrom;
                     echo "</span><br>The item will ship to: <span id=\"shipTo\">";
                     echo $shipTo;
                     echo "</span><br>Return Policy: <span id=\"return\">";
                     echo $return;
                     echo "</span>"
                     ?>
                        <br>
                        
                    </div>
                </div>

            </div>
                
                  </div>
            
           <a href="/sell/premium.php"><button class='btn btn-primary btn_buy' id="createPage">Submit</button></a>
        </div> 
        
	<div id="popup1" class="overlay">
                    <div class="popup">
		<h2>Verification Photo</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
                    Post a picture of your item with the given verification number.<br>
                    Example:<br>
                    <img id="verEx" src="/img/pIcon.png"/>
		</div>
	</div>
</div>
                
    </body>
</html>