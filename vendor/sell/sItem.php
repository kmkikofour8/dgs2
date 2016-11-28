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
        <link href="/sell/assets/css/style.css" rel="stylesheet">
    <!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
         include $_SERVER["DOCUMENT_ROOT"]."Header.php";
    

        $_SESSION['sale_fee']=$_POST['sale_fee'];
        $sellerID=$_SESSION['login_user'];
        $_SESSION['quantity']=$quantity = $_POST['quantity'];
        $_SESSION['title']=$title=$_POST['title'];
        $_SESSION['description']=$description=$_POST['description'];
        $_SESSION['brandID']=$brandID=$_POST['brandID'];
        $_SESSION['color']=$color=$_POST['color'];
        $_SESSION['size']=$size=$_POST['size'];
        $_SESSION['shipFrom']=$shipFrom=$_POST['shipFrom'];
        $_SESSION['shipTo']=$shipTo=$_POST['shipTo'];
        $_SESSION['return']=$return=$_POST['return'];
        $_SESSION['price']=$price=$_POST['total_price'];
        $_SESSION['iID']=$iID=$_POST['iID'];
        $_SESSION['selliID']=$_SESSION['login_user'];
        $_SESSION['paypal']=$paypal=$_POST['paypal'];
        
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
                            <h2 id="price"><?php echo $price ?></h2>
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
                                          <td id="date"><?php echo "DATE NEEDS TO BE FIXED"?></td>
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
                            <span id="sellerID"><?php echo $sellerID?></span></a>
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
                    </div></div>
                         <div class='row'>
                        <div class='col-md-4' >
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
                <b>You MUST upload a verification photo in order for your listing to be approved and posted. <a href="/verificationphoto.html" target="_blank">What is a verification photo?</a></b>
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
            <hr>                
            <div class="row wrap">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Comments
                </div>
                    <div class="panel-body"> 
                    </div>
                </div>
            
        </div>
            <button id="createPage"><a href="/sell/premium.php">Submit</a></button>
        </div>
    </body>
</html>