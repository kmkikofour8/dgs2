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
    </head>
<?php

        $username = "jordon";
        $password = "Aryahij11!";
        $database = "db_1";
        $link = mysql_connect('127.0.0.1:3306', $username, $password);
        if (!$link) {
            die("could not connect" . mysql_error());
        }
        mysql_select_db($database);
     
include "$_SERVER[DOCUMENT_ROOT]/Header.php";

?>
    <form action="createpage.php" method="Post">
              <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Basic Information</div>
    <select>
        <option name="false">Select Item Category</option>
        <option name="Tugs">Tug</option>
        <option name="Suits/Sleeves">Suit/Sleeve</option>
        <option name="Collars">Collar</option>
        <option name="Harnesses">Harness</option>
        <option name="Muzzles">Muzzle</option>
        <option name="Electronic Collars">Electronic Collar</option>
        <option name="Leashes">Leash</option>
        <option name="Other">Other</option>        
    </select>
  
                    <div class="panel-body">
                             Quantity
     <input type="text" name="quantity" style="width:100%;"/>
     Enter Headline
     <input type="text" name="title" style="width:100%;"/>
     <br> Enter Full Product Description
    <input type="text" name="Description" style="width:100%;"/>
                    </div>
                    </div>
                    </div>
    <div class="col-md-6">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Key Features
                </div>
                    <div class="panel-body">
                        Brand <span id="brandID"><input name="brandID" type="text" placeholder="Please Put Name of the Brand" style="width:100%;"/></span>
                        <br>Color: <span id="shipTo" ><input name="color" type="text" placeholder="Please enter the color of the item" style="width:100%"/></span><br>
                        Size: <input type="text" name="size" placeholder="Please explain your return policy or enter None" style="width:100%"/>
                        <br>
                    </div>
                </div>

            </div>
      <div class="col-md-6">
                <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping & Handling Information
                </div>
                    <div class="panel-body">
                        The item will ship from: <span id="shipFrom"><input name="shipFrom" type="text" placeholder="Please Put State and Country" style="width:100%;"/></span>
                        <br>The item will ship to: <span id="shipTo" ><input name="shipTo"type="text" placeholder="Please Put Country Only or enter ALL" style="width:100%"/></span><br>
                        Return Policy: <input type="text" name="return" placeholder="Please explain your return policy or enter None" style="width:100%"/>
                        <br>
                    </div>
                </div>

            </div>
    
    </form>
</html>
