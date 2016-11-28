<!DOCTYPE html>

<?php
#echo $_SERVER['DOCUMENT_ROOT'].'db.php';
include $_SERVER['DOCUMENT_ROOT'] . 'db.php';


$page=$_SERVER['REQUEST_URI'];

?>
<html>
    <head>
    <!--<link rel="stylesheet" href="/lightbox/lightbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/lightbox/lightbox.js"></script>-->
      
    <link rel="stylesheet" href="/lbox/dist/css/lightbox.min.css">
    <script src="/lbox/dist/js/lightbox-plus-jquery.min.js"></script>
    <title>Dog Gear Trade</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/JS/script.js"></script>
    <script src="/JS/jquery.validate.js"></script>
<script src="/JS/buy.js"></script>
    <script src="/JS/dz.js"></script>

    

    <!-- BOOTSRAP         _-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/index.css">
</head>
    <nav class="navbar navbar-default navbar-fixed-top subnav" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#subnav-collapse-content1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" rel="home" href="/HomePage.php" title="Home">
                        <img style="max-width:100px; height:50px; margin-top: -15px;"
                             src="/img/malinoisLogo.jpg">
                    </a>
                </div>
                <div class="collapse navbar-collapse"  id="subnav-collapse-content1">
                    <ul class="nav navbar-nav"> 
                        <li class="divider-vertical"></li>
                        <li id="subnav_tugs_li1">
                            <a href=<?php
                            if (isset($_SESSION['login_user'])) {
                                echo "/sell/sellItem.php";
                            } else {
                                $_SESSION['ref'] = "/sell/sellItem.php";
                                echo "/login/index";
                            }
                            ?>
                               >Sell</a>
                        </li>
                        <li id="subnav_collars_li1">
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>

                        </li></ul>
                          <ul class="nav navbar-nav navbar-right">
                         <?php
                    if(isset($_SESSION['login_user'])){
                        
                    echo "<li id=\"subnav_propic_li1\"><img id=\"propic\" src=\"".$_SESSION['profilePic']." \"/></li>";
                    echo "<li  id=\"subnav_user_li1\"><a href=\"/user/profile\">".$_SESSION['login_email']."</a></li>";
                    echo "<li  id=\"subnav_login_li1\"><a href=\"/login/logout.php\">Logout</a></li>";
                     }else{
                    echo "<li  id=\"subnav_empty_li1\"><img id=\"propic\" src=\"/img/no_profile_50.png\"/></li>";
                    echo "<li id=\"subnav_login_li1\"><a href=\"/login/index\">Login/Register</a></li>";
                    
                     }
$_SESSION['ref']=$_SERVER['REQUEST_URI']
                     ?>
                          </ul>
                    

                </div>

            </nav>

    <div class="wrap">
        <div class="container">
            <!--<div class="jumbotron" style="text-align: center"><h2>Buy and Sell Newish Dog Gear</h2></div>-->
            <div><img id="mainPic" src="/img/malinoisLogo.jpg" /></div>
            <nav class="navbar navbar-default subnav" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#subnav-collapse-content">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse"  id="subnav-collapse-content">
                        <ul class="nav navbar-nav"> 
                            <li class="divider-vertical"></li>
                            <li id="subnav_tugs_li">
                                <a href="/Buy.php?page=TUGS" title="Tugs">Tugs</a>
                            </li>
                            <li id="subnav_collars_li">
                                <a href="/Buy.php?page=COLLARS" title="Collars">Collars</a>
                            </li>
                            <li id="subnav_harnesses_li">
                                <a href="/Buy.php?page=HARNESSES" title="harness">Harnesses</a>
                            </li>
                            
                            <li id="subnav_sleeves_li">
                                <a href="/Buy.php?page=SUITS_SLEEVES" title="Suits/Sleeves">Suits/Sleeves</a>
                            </li>
                            <li id="subnav_muzzles_li">
                                <a href="/Buy.php?page=MUZZLES" title="Muzzles">Muzzles</a>
                            </li>
                            <li id="subnav_ecollars_li">
                                <a href="/Buy.php?page=ECOLLARS" title="Electronic Collars">Electronic Collars</a>
                            </li>
                            <li id="subnav_leashes_li">
                                <a href="/Buy.php?page=LEASHES" title="Leashes">Leashes</a>
                            </li>
                            <li id="subnav_other_li">
                                <a href="/Buy.php?page=OTHER" title="Other">Other</a>
                            </li>   

                        </ul>
                    
                    </div>

                </nav>
            <hr id="headHR">  
            
            
            
            
            
            
            
            
