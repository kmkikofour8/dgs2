<?php
 
include $_SERVER['DOCUMENT_ROOT']."Header.php";

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
    </head>
    <form action='sell.php' method='POST'>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style='text-align: center'><h2>SELECT PRODUCT TYPE</h2>  </div>
        <div class="panel-body">
            <div class="col-md-6" >
                <button type='submit' name='type' value='Tugs' style="width:100%">Tugs</button>
            </div>
             <div class="col-md-6" >
                <button type='submit' name='type' value='suits_sleeves' style="width:100%">Suits/Sleeves</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='collars' style="width:100%">Collars</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='Harnesses' style="width:100%">Harnesses</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='Muzzles' style="width:100%">Muzzles</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='ecollars' style="width:100%">Electronic Collars</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='Leashes' style="width:100%">Leashes</button>
            </div>
            <div class="col-md-6" >
                <button type='submit' name='type' value='Other' style="width:100%">Other</button>
            </div>
        </div>


    </div>

    </div>
    
    </form>
    
    </html>
