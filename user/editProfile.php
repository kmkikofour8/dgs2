<?php
include $_SERVER['DOCUMENT_ROOT'] . 'user/userHeader.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$username = "jordon";
$password = "Aryahij11!";
$database = "db_1";
$link = mysql_connect('127.0.0.1:3306', $username, $password);
if (!$link) {
    die("could not connect" . mysql_error());
}
mysql_select_db($database);

$q5 = "SELECT * FROM paypal_info WHERE google_id='" . $_SESSION['login_user'] . "';";
//$lname=$q5;
$x5 = mysql_query($q5);

$fname = mysql_result($x5, 0, "fname");
$lname = mysql_result($x5, 0, "lname");

?>
<section id="section_main">




    <form id="formProfile" action="/user/editPaypal" method="post" novalidate="novalidate">

        <div class="row">
            <div class="col-md-12">


                <div class="panel panel-default" id="private_info">
                    <div class="panel-heading">
                        <i class="fa fa-user-secret"></i>
                        Private Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">


                                <div id="field_first_name" class="field form-group required">
                                    <label for="id_first_name" class="control-label">First Name *</label>

                                    <div class="controls widget" style="margin-bottom: 0px;">
                                        <input id="id_first_name" maxlength="30" name="fname" type="text" value="<?php echo $fname ?>" class="form-control required">
                                    </div>
                                    <div class="errors help-block" style="margin: 0px; padding-top: 5px;"></div>
                                </div>


                            </div>
                            <div class="col-md-6">


                                <div id="field_last_name" class="field form-group required">
                                    <label for="id_last_name" class="control-label">Last Name *</label>

                                    <div class="controls widget" style="margin-bottom: 0px;">
                                        <input id="id_last_name" maxlength="30" name="lname" type="text" value="<?php echo $lname ?>" class="form-control required">
                                    </div>
                                    <div class="errors help-block" style="margin: 0px; padding-top: 5px;"></div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">


                                <div id="field_paypal_email" class="field form-group">
                                    <label for="id_paypal_email" class="control-label">PayPal Email </label>

                                    <p class="help-block">Email address used for receiving payments via PayPal. (Private)</p>

                                    <div class="controls widget" style="margin-bottom: 0px;">
                                        <input id="id_paypal_email" maxlength="254" name="email" type="email" value="<?php echo $_SESSION['login_paypal'] ?>" class="form-control">
                                    </div>
                                    <div class="errors help-block" style="margin: 0px; padding-top: 5px;"></div>
                                </div>


                                <!-- PayPal listing update -->

                                <div id="field_update_listings_paypal" style="margin: -10px 0px 15px 5px; padding: 0px;">
                                    <input id="id_update_listings_paypal" name="update_listings_paypal" type="checkbox">
                                    <label for="id_update_listings_paypal" style="font-weight: normal;" class="with_popover" data-placement="bottom" data-content="Updates your active listings with this PayPal email address. Check the box and Save Profile to update the listings." data-original-title="" title="">Update active listings with PayPal email address on save? </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button id="saveprofile" class="btn btn-primary">Save Profile</button>
                        
                    </div>
                </div>

            </div>

        </div>

    </form>

</section>