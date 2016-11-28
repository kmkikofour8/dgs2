<?php

//include $_SERVER['DOCUMENT_ROOT'] .'/db.php';
ob_start();
include $_SERVER['DOCUMENT_ROOT'] .'/login/verifyStatus.php';
$success= ob_get_clean();


$checked = $_POST['update_listings_paypal'];
$email = $_POST['email'];
$lname = $_POST['lname'];
$fname = $_POST['fname'];

if($success=="Success"){
$st = mysqli_query($mysqli, "UPDATE google_users SET paypal=\"" . $email . "\" WHERE google_id=\"" . $_SESSION['login_user'] . "\";");
if($st){
                      echo 'good';
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
                    
$st2 = mysqli_query($mysqli, "UPDATE paypal_info SET paypal=\"" . $email . "\", fname='$fname',lname='$lname' WHERE google_id=\"" . $_SESSION['login_user'] . "\";");
if($st2){
                      echo 'googd';
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
      
if ($checked == "on") {
    $x = $_SESSION['login_user'];
    $categories = array('tugs', 'collars', 'harnesses', 'suits_sleeves', 'muzzles', 'ecollars', 'leashes', 'other');
    foreach ($categories as &$y) {
        $result2 = mysql_query("select itemID from $y where sellerID='$x' AND SOLD=0 order by premium desc");
        $numAff = mysql_num_rows($result2);
        for ($i = 0; $i < $numAff; $i++) {
                $ii = mysql_result($result2, $i, "itemID");
                $st3 = mysqli_query($mysqli, "UPDATE $y SET paypal=\"" . $email . "\" WHERE sellerID=\"" . $_SESSION['login_user'] . "\" AND itemID='$ii';");
                if($st3){
                      echo 'good';
                    }else{
                        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                    }
      
                
                
                
                
        }
    }
}
$_SESSION['login_paypal']=$email;
header('Location: /user/editProfile.php#popup3');
}   
else {
 header('Location: /user/editProfile.php#popup4');
}
?>

