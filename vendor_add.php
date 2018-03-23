<?php include('header.php');
include ('checkUserRole.php');
include('toppart.php');
include('menu.php');
include('function.php'); ?>
<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-grid" data-uk-grid-margin>	
            <div class="uk-width-10-10 uk-container-center">
                <div class="md-card">
                    <div class="md-card-content"><h1 class="uk-text-center">Add Vendor</h1>
                        <div class="uk-form-row">
                            <div class="uk-width-10-10 uk-container-center">
                                <?php if (!empty($_SESSION['success'])) { ?>
                                    <div class='alert alert-success'> <?php echo $_SESSION['success'] ?> </div>
                                    <?php $_SESSION['success'] = "";
                                } ?>
                                <?php if (!empty($_SESSION['error'])) { ?>
                                    <div class='alert alert-danger'> <?php echo $_SESSION['error'] ?> </div>
                                    <?php $_SESSION['error'] = "";
                                } ?>

                                <?php
                                $error = $legalNameErr = $businessTradingNameErr = $cpnErr = $dojErr = $businessEmailErr = $businessEmailValidate = $businessPhoneNumberErr = $businessPhoneNoValidate = $emailErr = $emailValidate = $phoneNumberErr = $phoneNoValidate = $abn = $passwordErr = $passwordValidationErr = $cnfErr = $cityErr = "";
                                if (isset($_POST['submit'])) {
                                    if (empty($_POST['legalName'])) {
                                        $error = $legalNameErr = "Please enter your legal name.";
                                    } elseif (empty($_POST['businessTradingName'])) {
                                        $error = $businessTradingNameErr = "Please enter business trading name.";
                                    } elseif (empty($_POST['cpn'])) {
                                        $error = $cpnErr = "Please enter contact person name.";
                                    } elseif (empty($_POST['doj'])) {
                                        $error = $dojErr = "Please enter date of joining.";
                                    } elseif (empty($_POST['businessEmail'])) {
                                        $error = $businessEmailErr = "Please enter business email.";
                                    } elseif (validate_businessEmail($_POST['businessEmail'])) {
                                        $error = $businessEmailValidate = "Email already exist choose a different email.";
                                    } elseif (empty($_POST['businessPhoneNumber'])) {
                                        $error = $businessPhoneNumberErr = "Please enter your business phone number..";
                                    } elseif (validate_businessPhoneNumber($_POST['businessPhoneNumber'])) {
                                        $error = $businessPhoneNoValidate = "Number already exist choose a different number.";
                                    } elseif (empty($_POST['secondaryEmail'])) {
                                        $error = $emailErr = "Please enter email address.";
                                    } elseif (validate_user($_POST['secondaryEmail'])) {
                                        $error = $emailValidate = "Email already exist choose a different email.";
                                    } elseif (empty($_POST['secondaryPhoneNumber'])) {
                                        $error = $phoneNumberErr = "Please enter your mobile number..";
                                    } elseif (validate_mobile($_POST['secondaryPhoneNumber'])) {
                                        $error = $phoneNoValidate = "Mobile number already exist choose a different number.";
                                    } elseif (empty($_POST['abn'])) {
                                        $error = $abn = "Please enter your australian business number(ABN).";
                                    } elseif (empty($_POST['password'])) {
                                        $error = $passwordErr = "Please enter password..";
                                    } elseif (empty($_POST['cnf'])) {
                                        $error = $cnfErr = "Please enter confirm password..";
                                    } elseif ($_POST['password'] != $_POST['cnf']) {
                                        $error = $passwordValidationErr = "Password and confirm password not matched.";
                                    } elseif (empty($_POST['longitude'])) {
                                        $error = $longitudeErr = "Please enter longitude..";
                                    } elseif (empty($_POST['latitude'])) {
                                        $error = $latitudeErr = "Please enter latitude..";
                                    } elseif (empty($_POST['address'])) {
                                        $error = $addressErr = "Please enter address..";
                                    } elseif ($_POST['city_name'] == "select") {
                                        $error = $cityErr = "Please enter city name..";
                                    } elseif (empty($error)) {

                                        if (!empty($_FILES['profile_pic']['name'])) {
                                            $fileSaveDirectory = "../../trunk/images";
                                            $target_dir = "images/";
                                            $target_file = $target_dir . $_FILES["profile_pic"]["name"];
                                            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                                                $_SESSION['error'] = "File Format Not Suppoted";
                                                header('location:users_list.php');
                                                ?> <script> window.location = 'users_list.php';</script> <?php
                                                exit;
                                            } else {
                                                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $fileSaveDirectory . "/" . basename($_FILES['profile_pic']['name']))) {
                                                    
                                                } else {
                                                    echo "Sorry, there was an error uploading your file.";
                                                }
                                            }
                                        }
                                        if (!empty($_FILES['food_licence_pic']['name'])) {
                                            $fileSaveDirectory = "../../trunk/images/food_registration";
                                            $target_dir_food = "images/food_registration/";
                                            $target_file_food = $target_dir_food . basename($_FILES["food_licence_pic"]["name"]);
                                            if (move_uploaded_file($_FILES["food_licence_pic"]["tmp_name"], $fileSaveDirectory . "/" . basename($_FILES['food_licence_pic']['name']))) {
                                                
                                            } else {
                                                echo "Sorry, there was an error uploading your file.";
                                            }
                                        }
                                        if (!empty($_FILES['business_reg_pic']['name'])) {
                                            $fileSaveDirectory = "../../trunk/images/business_licence";
                                            $target_dir_business = "images/business_licence/";
                                            $target_file_business = $target_dir_business . basename($_FILES["business_reg_pic"]["name"]);
                                            if (move_uploaded_file($_FILES["business_reg_pic"]["tmp_name"], $fileSaveDirectory . "/" . basename($_FILES['business_reg_pic']['name']))) {
                                                
                                            } else {
                                                echo "Sorry, there was an error uploading your file.";
                                            }
                                        }
                                        $password = $_POST['password'];
                                        //	$doj=date("Y-m-d", strtotime($_POST['doj']));

                                        $doj = str_replace("/", '-', $_POST['doj']);
                                        $doj = (strtotime($doj) * 1000);
                                        $data = mysqli_query($conn, "INSERT INTO `users`( first_name, last_name, email, password,mobile_no,dob,gender,business_name,business_email,business_phone_no,aus_business_no,address,profile_pic,business_reg_pic,food_licence_pic,device_id,devic_type,role,status,isNotify,social_id,social_type,latitude,longitude,city_id,created_on)
										VALUES('" . $_POST['legalName'] . "','" . $_POST['cpn'] . "','" . $_POST['secondaryEmail'] . "','" . md5($password) . "','" . $_POST['secondaryPhoneNumber'] . "','" . $doj . "','','" . $_POST['businessTradingName'] . "','" . $_POST['businessEmail'] . "','" . $_POST['businessPhoneNumber'] . "','" . $_POST['abn'] . "','" . $_POST['address'] . "', '" . $target_file . "', '" . $target_file_business . "','" . $target_file_food . "','','', '3', '0', '1', '', '',
										 '" . $_POST['latitude'] . "', '" . $_POST['longitude'] . "','" . $_POST['city_name'] . "',
										 '" . time() . "')");

                                        if ($data) {
                                            $lastid = mysqli_insert_id($conn);

                                            $busi = mysqli_query($conn, "INSERT INTO `business_hr`(uid,monform,monto, 
											tuefrom,tueto,wedfrom,wedto,thufrom,thuto,frifrom,frito,satfrom,satto,sunfrom
											,sunto) VALUES ('" . $lastid . "','" . $_POST['monfrom'] . "','" . $_POST['monto'] . "',
											'" . $_POST['tuefrom'] . "','" . $_POST['tueto'] . "','" . $_POST['wedfrom'] . "',
											'" . $_POST['wedto'] . "','" . $_POST['thufrom'] . "','" . $_POST['thuto'] . "',
											'" . $_POST['frifrom'] . "','" . $_POST['frito'] . "','" . $_POST['satfrom'] . "',
											'" . $_POST['satto'] . "','" . $_POST['sunfrom'] . "','" . $_POST['sunto'] . "')");

                                            $_SESSION['success'] = "Vendor created successfully";
                                            header('location:vendor_list.php');
                                            ?> <script> window.location = 'vendor_list.php';</script> <?php
                                            exit;
                                        } else {
                                            $_SESSION['error'] = "Error in creating user.";
                                        }
                                    }//else if		
                                } //if
                                ?>

                                <form action="" method="post" enctype="multipart/form-data" id="addUser">
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-2">
                                            <label>Legal Name*</label>
                                            <input type="text" class="masked_input md-input" name="legalName" id="legalName" 
                                                   value="<?php if (isset($_POST['legalName'])) {
                                    echo $_POST['legalName'];
                                } else {
                                    echo "";
                                } ?>" />
                                            <span class="uk-text-danger"><?php echo $legalNameErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Business Trading Name*</label>
                                            <input type="text" class="masked_input md-input" name="businessTradingName" 
                                                   id="businessTradingName" 
                                                   value="<?php if (isset($_POST['businessTradingName'])) {
                                    echo $_POST['businessTradingName'];
                                } else {
                                    echo "";
                                } ?>"/>
                                            <span class="uk-text-danger"><?php echo $businessTradingNameErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Contact Person Name*</label>
                                            <input type="text" class="masked_input md-input" name="cpn" id="cpn" 
                                                   value="<?php if (isset($_POST['cpn'])) {
                                    echo $_POST['cpn'];
                                } else {
                                    echo "";
                                } ?>"/>
                                            <span class="uk-text-danger"><?php echo $cpnErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Date of Joining*</label>
                                            <input class="md-input masked_input" type="text" name="doj" id="uk_dp_1" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="<?php if (isset($_POST['doj'])) {
                                    echo $_POST['doj'];
                                } else {
                                    echo "";
                                } ?>" 
                                                   autocomplete='off'>
                                            <span class="uk-text-danger"><?php echo $dojErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Business Email*</label>
                                            <input class="masked_input md-input" name="businessEmail" id="businessEmail" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" value="<?php if (isset($_POST['businessEmail'])) {
                                    echo $_POST['businessEmail'];
                                } else {
                                    echo "";
                                } ?>" />
                                            <span class="uk-text-danger"><?php echo $businessEmailErr; ?></span>
                                            <span class="uk-text-danger"><?php echo $businessEmailValidate; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Business Phone Number*</label>
                                            <input class="md-input masked_input" id="businessPhoneNumber" 
                                                   name="businessPhoneNumber" type="text"
                                                   data-inputmask-showmaskonhover="false" value="<?php if (isset($_POST['businessPhoneNumber'])) {
                                    echo $_POST['businessPhoneNumber'];
                                } else {
                                    echo "";
                                } ?>" />
                                            <span class="uk-text-danger"><?php echo $businessPhoneNumberErr; ?></span>
                                            <span class="uk-text-danger"><?php echo $businessPhoneNoValidate; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Secondary Email*</label>
                                            <input class="masked_input md-input" name="secondaryEmail" id="secondaryEmail" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" value="<?php if (isset($_POST['secondaryEmail'])) {
                                    echo $_POST['secondaryEmail'];
                                } else {
                                    echo "";
                                } ?>" />
                                            <span class="uk-text-danger"><?php echo $emailErr; ?></span>
                                            <span class="uk-text-danger"><?php echo $emailValidate; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Secondary Phone Number*</label>
                                            <input class="md-input masked_input" id="secondaryPhoneNumber" 
                                                   name="secondaryPhoneNumber" type="text"
                                                   data-inputmask-showmaskonhover="false" value="<?php if (isset($_POST['secondaryPhoneNumber'])) {
                                            echo $_POST['secondaryPhoneNumber'];
                                        } else {
                                            echo "";
                                        } ?>" />
                                            <span class="uk-text-danger"><?php echo $phoneNumberErr; ?></span>
                                            <span class="uk-text-danger"><?php echo $phoneNoValidate; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Australian Business Number(ABN)*</label>
                                            <input class="md-input masked_input" id="abn" name="abn" type="text"
                                                   data-inputmask-showmaskonhover="false" value="<?php if (isset($_POST['abn'])) {
                                            echo $_POST['abn'];
                                        } else {
                                            echo "";
                                        } ?>" />
                                            <span class="uk-text-danger"><?php echo $abn; ?></span>
                                        </div>
<?php /* ?><div class="uk-width-medium-1-2">
  <label>Business Trading Hours From*</label>
  <input class="md-input masked_input" id="tradingHoursFrom"
  name="tradingHoursFrom" type="text" data-uk-timepicker="{format:'12h'}"
  data-inputmask-showmaskonhover="false"  />
  <span class="uk-text-danger"><?php echo $tradingHoursFrom;?></span>
  </div>
  <div class="uk-width-medium-1-2">
  <label>Business Trading Hours To*</label>
  <input class="md-input masked_input" id="tradingHoursTo"
  name="tradingHoursTo" type="text" data-uk-timepicker="{format:'12h'}"
  data-inputmask-showmaskonhover="false"  />
  <span class="uk-text-danger"><?php echo $tradingHoursTo;?></span>
  </div><?php */ ?>
                                        <div class="uk-width-medium-1-2">
                                            <label>Profile Pic : </label>
                                            <div class="uk-form-file md-btn md-btn-primary">Select
                                                <input id="profile_pic" type="file" name="profile_pic" 
                                                       accept="image/gif, image/jpeg ,image/png">
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Business Certificate : </label>
                                            <div class="uk-form-file md-btn md-btn-primary">Select
                                                <input id="business_reg_pic" type="file" name="business_reg_pic" 
                                                       accept="image/gif, image/jpeg ,image/png">
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Food Licence Pic : </label>
                                            <div class="uk-form-file md-btn md-btn-primary">Select
                                                <input id="food_licence_pic" type="file" name="food_licence_pic" 
                                                       accept="image/gif, image/jpeg ,image/png">
                                            </div>
                                        </div>

                                        <div class="uk-width-medium-1-2">Password
                                            <input type="password" class="md-input" name="password" id="password" />
                                            <a href="#" class="uk-form-password-toggle" data-uk-form-password>show</a>
                                            <span class="uk-text-danger"><?php echo $passwordErr; ?></span>
                                            <span class="uk-text-danger"><?php echo $passwordValidationErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">Confirm Password
                                            <input type="password" class="md-input" name="cnf" id="cnf" />
                                            <a href="#" class="uk-form-password-toggle" data-uk-form-password>show</a>
                                            <span class="uk-text-danger"><?php echo $cnfErr; ?></span>
                                        </div>
                                        <!--////////////////////-->
                                        <div class="uk-width-medium-1-2">
                                            <label>Longitude</label>
                                            <input type="text" class="md-input" name="longitude" id="longitude" />
                                            <span class="uk-text-danger"><?php echo $longitudeErr; ?></span>
                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label>Latitude</label>
                                            <input type="text" class="md-input" name="latitude" id="latitude" />
                                            <span class="uk-text-danger"><?php echo $latitudeErr; ?></span>

                                        </div>
                                        <div class="uk-width-medium-1-1">
                                            <label>Address</label>
                                            <input type="text" class="md-input" name="address" id="address" />
                                            <span class="uk-text-danger"><?php echo $addressErr; ?></span>

                                        </div>
                                        <div class="uk-width-medium-1-2">
                                            <label style="font-family: 'Roboto';font-size: 14px;color: #444;">City*</label>
                                            <select class="masked_input md-input" id="select-city" name = "city_name">
                                                <option value="select" >Select</option> 						
<?php
$data = mysqli_query($conn, "select id,city_name from cities");
if (mysqli_num_rows($data) > 0) {
    while ($row = mysqli_fetch_assoc($data)) {
        ?>
                                                        <option value="<?= $row['id']; ?>" <?php if (isset($_POST['city_name'])) {
            if ($_POST['city_name'] == $row['id']) {
                echo "selected";
            }
        } ?>><?= $row['city_name'] ?></option>
    <?php }
} ?>
                                            </select>
                                            <span class="uk-text-danger"><?php echo $cityErr; ?></span>
                                        </div>
                                        <!--////////////////////-->
                                        <div class="uk-width-medium-1-1">
                                            <h3> Business Trading hours </h3>
                                        </div>
                                        <div class="uk-width-medium-1-6">
                                            <label>Monday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="monfrom" name="monfrom" type="text"
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="monto" 
                                                   name="monto" type="text" data-uk-timepicker="{format:'12h'}"
                                                   data-inputmask-showmaskonhover="false"  />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Tuesday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="tuefrom" name="tuefrom" type="text"
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="tueto" name="tueto" type="text"
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Wednesday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="wedfrom" name="wedfrom" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="wedto" name="wedto" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Thursday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="thufrom" name="thufrom" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="thuto" name="thuto" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Friday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="frifrom" name="frifrom" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="frito" 
                                                   name="frito" type="text" data-uk-timepicker="{format:'12h'}"
                                                   data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Saturday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="satfrom" 
                                                   name="satfrom" type="text" data-uk-timepicker="{format:'12h'}"
                                                   data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="satto" 
                                                   name="satto" type="text" data-uk-timepicker="{format:'12h'}"
                                                   data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6" >
                                            <label>Sunday</label>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>From</label>
                                            <input class="md-input masked_input" id="sunfrom" 
                                                   name="sunfrom" type="text" data-uk-timepicker="{format:'12h'}"
                                                   data-inputmask-showmaskonhover="false" />
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <label>To</label>
                                            <input class="md-input masked_input" id="sunto" name="sunto" type="text" 
                                                   data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" />
                                        </div>

                                        <div style="clear:both"></div>
                                        <div class="uk-width-medium-1-6">
                                            <button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                                        </div>
                                        <div class="uk-width-medium-1-6">
                                            <a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="vendor_list.php">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include ('footer.php'); ?>
<!-- ionrangeslider -->
<script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
<!-- htmleditor (codeMirror) -->
<script src="assets/js/uikit_htmleditor_custom.min.js"></script>
<!-- inputmask-->
<script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<!--  forms advanced functions -->
<script src="assets/js/pages/forms_advanced.min.js"></script>

</body>
</html>

