<html>
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
                    <div class="controls widget" > <input class="form-control" type="text" name="quantity" style="width:100%;"  /></div>
                    Title:
                    <div class="controls widget"> <input class="form-control" type="text" name="title" style="width:100%;"/></div>
                    Product Description:
                    <div class="controls widget"><textarea class="form-control" name="description" style="width:100%;" ></textarea></div>
                </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Key Features
            </div>
            <div class="panel-body">
                <div class="controls widget"> Brand <span id="brandID"><input class="form-control" name="brandID" type="text" placeholder="Please Put Name of the Brand" style="width:100%;" autocomplete="off"/></span></div>
                    <div class="controls widget">Color: <span id="shipTo" ><input class="form-control" name="color" type="text" placeholder="Please enter the color of the item" style="width:100%" autocomplete="off"/></span></div>
                    <div class="controls widget">Size: <input class="form-control" type="text" name="size" placeholder="" style="width:100%" autocomplete="off"/></div>
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
                <div class="controls widget"> The item will ship from: <span id="shipFrom"><input class="form-control" name="shipFrom" type="text" placeholder="Please Put City,State" style="width:100%;"autocomplete="off"/></span></div>
                <div class="controls widget"> The item will ship to: <span id="shipTo" ><input class="form-control" name="shipTo"type="text" placeholder="Please Put Country Only or enter ALL" style="width:100%"autocomplete="off"/></span></div>
                <div class="controls widget"> Return Policy: <input class="form-control" type="text" name="return" placeholder="Please explain your return policy or enter None" style="width:100%"autocomplete="off"/></div>
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
                <div class="controls widget">      Asking Price <span style="font-size:9px">This is the amount you'll get paid (less Sale fee) <br>Please include reasonable shipping costs (usually about $5-15) in ask price</span> </div>
                <div class="controls widget" style="margin-bottom: 0px;">
                    <input class="form-control" type="text" name="ask_price" value="0" id="id_ask_price" class="form-control spinedit noSelect required" style="display:inline;width:25%;" autocomplete="off"><span id="list_price_extra" style="font-size: 110%; visibility: visible;">
                        + <span id="id_sale_fee">0</span> (Sale Fee) =
                        <span id="id_total_price">0</span> (Total Price shown to Buyers)
                        <input type="hidden" value="" id="phidden" name="total_price"/>
                        <input type="hidden" value="" id="sfhidden" name="sale_fee"/>
                    </span>
                </div>
                <div>
                    Enter PayPal Address
                    <input class="form-control" type="text" id="paypal" name="paypal" value="<?php echo $_SESSION['login_paypal']?>" readonly/></div>

               
            </div>
        </div>

    </div>


    
        </div>

    <button type='submit' class='btn btn-primary btn_buy'>Submit</button>
    </form>
    <a href="/Homepage.php"><button class='btn btn-primary btn_buy'>Cancel</button></a>
</html>
