<?php
    require 'db.php';
    include "$_SERVER[DOCUMENT_ROOT]/Header.php";

$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);
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
        <script src="/js/script.js"></script>
        <script src="/js/jquery.validate.js"></script>
    </head>
<?php


//        $_SESSION['sale_fee']=$_POST['sale_fee'];
//        $sellerID=$_SESSION['login_user'];
//        $_SESSION['quantity']=$quantity = $_POST['quantity'];
//        $_SESSION['title']=$title=$_POST['title'];
//        $_SESSION['description']=$description=$_POST['description'];
//        $_SESSION['brandID']=$brandID=$_POST['brandID'];
//        $_SESSION['color']=$color=$_POST['color'];
//        $_SESSION['size']=$size=$_POST['size'];
//        $_SESSION['shipFrom']=$shipFrom=$_POST['shipFrom'];
//        $_SESSION['shipTo']=$shipTo=$_POST['shipTo'];
//        $_SESSION['return']=$return=$_POST['return'];
//        $_SESSION['price']=$price=$_POST['total_price'];
//        $_SESSION['iID']=$iID=$_POST['iID'];
//        $_SESSION['selliID']=$_SESSION['login_user'];
//        $_SESSION['paypal']=$paypal=$_POST['paypal'];
//        
        //$_SESSION['image']=$_POST['mainImage'];
        
        
        
       
?>

    <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style='text-align: center'><h2>Would You Like To Make Your Item Featured</h2> <br> This will make you item appear on the front
        page of DogGearTrade.com and will also make it appear first on the individual category page.</div>
        <div class="panel-body">
            <form action="/vendor/payment.php" method="POST">
            <div class="col-md-6" >
                <button type='submit' name='yes' value='yes' style="width:100%">Yes</button>
            </div>
             <div class="col-md-6" >
                <button type='submit' name='no' value='no' style="width:100%">No</button>
            </div>
            </form>
        </div>


    </div>

    </div>
