<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysql_connect("localhost", "jordon", "Aryahij11!");
// To protect MySQL injection for Security purpose
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
// Selecting Database
$db = mysql_select_db("db_1", $connection);
// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from seller where password='$password' AND sellerID='$username'", $connection);
$rows = mysql_num_rows($query);
$profilePic=  mysql_result($query,0,"profilePic");
$_SESSION['profilePic']=$profilePic;
//$_SESSION['username']=$username;
if ($rows == 1) {
$_SESSION['login_user']=$username; // Initializing Session
if(isset($_SESSION['ref'])){
$ref=$_SESSION['ref'];}
else{
   $_SESSION['ref']='/Homepage.php';
    $ref='/Homepage.php';
    
}
    

//unset($_SESSION['ref']);
header("location: ".$ref.""); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
mysql_close($connection); // Closing Connection
}
}
?>