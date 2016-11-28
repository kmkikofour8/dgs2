<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/JS/script.js"></script>
</head>
<?php
session_start(); //session start

require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '73577313401-lj9ndq2a8n09vkpfcchrvdgri6q4ako8.apps.googleusercontent.com'; 
$client_secret = 'aALbhqmkdLVPdUiTriDqN8mG';
$redirect_uri = 'http://localhost:8080/login/index.php';

//database
$db_username = "jordon"; //Database Username
$db_password = "Aryahij11!"; //Database Password
$host_name = "localhost"; //Mysql Hostname
$db_name = 'db_1'; //Database Name

//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.
echo '<div style="margin:20px">';
if (isset($authUrl)){ 
	//show login url
	
	echo '<div>Please click login button to connect to Google.</div>';
	echo '<a class="login" href="' . $authUrl . '"><img src="/img/google_signin_button.png" /></a>';
	
} 
else{
    
	$user = $service->userinfo->get(); //get user info 
	
	// connect to database
	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
	
	//check if user exist in database using COUNT
	$result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id='$user->id'");
     
	$user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
     
        if($user_count==0){
            $r2=$mysqli->query("SELECT COUNT(google_email) as usercountz FROM google_users WHERE google_email='$user->email'");
            $user_count2=$r2->fetch_object()->usercountz;
            if($user_count2!=0&&$user_count==0){   
                $st=  mysqli_query($mysqli,"UPDATE google_users SET google_id=\"$user->id\" WHERE google_email=\"$user->email\";");
                 //$st2=  mysqli_query($mysqli,"UPDATE paypal_info SET google_id=\"$user->id\" WHERE google_email=\"$user->email\";");
               $user_count=1;
            }
        }
if($user_count==0){

   if(!isset($_GET['ppemail'])){ 
        include($_SERVER['DOCUMENT_ROOT']."login/cpp.php");
    } 
    else{
    $user = $service->userinfo->get(); //get user info 
    	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
        
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
	
	$ppemail=$_GET['ppemail'];
     echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
     $result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id='$user->id'");
     
	$user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
             

     $statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link,paypal,ratingID) VALUES (?,?,?,?,?,?,?)");
                if($user->link==NULL){
                    $user->link="localhost";
                }
                
                $statement->bind_param('sssssss', $user->id,  $user->name, $user->email, $user->link, $user->picture,$ppemail,$user->id);
		
                $statement->execute();
echo $mysqli->error;
                
                $_SESSION['login_name']=$user->name;
        $_SESSION['login_paypal']=$ppemail;
        $_SESSION['login_email']=$user->email;
        $_SESSION['login_user']=$user->id;
        $_SESSION['profilePic']=$user->picture;
                
$mysqli->query('INSERT INTO paypal_info (google_id, paypal_email, fname, lname) VALUES (\''.$_SESSION['login_user'].'\',\''.$_SESSION['pp_email'].'\',\''. $_SESSION['pp_fname'].'\', \''.$_SESSION['pp_lname'].'\');');

     $statement = $mysqli->prepare("INSERT INTO paypal_info (google_id, paypal, fname, lname) VALUES (?,?,?,?)");
                
                $statement->bind_param('ssss',$_SESSION['login_user'],$_SESSION['pp_email'],$_SESSION['pp_fname'],$_SESSION['pp_lname']);
		
                $statement->execute();
    echo $mysqli->error;
    echo "<a href='/Homepage.php'> Homepage</a>";
    }       
}


else {
	
              
	//show user picture
	echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
	echo $user_count;
	if($user_count!=0) //if user already exist change greeting text to "Welcome Back"
    {
     
         $r32=$mysqli->query("SELECT paypal as payp FROM google_users WHERE google_email='$user->email'");
            $payp=$r32->fetch_object()->payp;
                           $_SESSION['login_name']=$user->name;
        $_SESSION['login_paypal']=$payp;
        $_SESSION['login_email']=$user->email;
        $_SESSION['login_user']=$user->id;
        $_SESSION['profilePic']=$user->picture;

        if(isset($_SESSION['ref'])){
            header("Location: ".$_SESSION["ref"]);
        }
        else{
               header("Location: /Homepage.php");
        }
    }
    
   
}	
}

echo '</html>';


?>

