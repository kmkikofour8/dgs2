
<?php
       echo "<br><br>To Buy or Sell you require a paypal Verified Email Address!";
        $fname=$user->givenName;
        echo "<input type='text' id='fname' value='$fname'></input>";
        echo "<input type='text' id='lname' value='$user->familyName'></input>";
        echo "Please enter paypal address<br><input type='text' id='email'></input><br>";
        echo "<input type='submit' value='Submit' id='submit22' ></input>";
        echo "<a href='/login/logout.php'><input type='submit' value='Cancel'></input></a>";
        ?>
    