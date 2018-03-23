<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; 
	$query=mysqli_query($conn,"select * from users where uid=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	$busi_hr=mysqli_query($conn,"select * from business_hr where uid=$id") or die(mysqli_error($conn));
	$bushr=mysqli_fetch_assoc($busi_hr);
	}
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit Vendor</h1>
						<div class="uk-form-row">
							<div class="uk-width-10-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error=$legalNameErr=$businessTradingNameErr=$cpnErr=$dojErr=$businessEmailErr=$businessEmailValidate=$businessPhoneNumberErr=$businessPhoneNoValidate=$emailErr=$emailValidate=$phoneNumberErr=$phoneNoValidate=$abn=$passwordErr=$passwordValidationErr=$cnfErr="";
								if(isset($_POST['submit']))
								{
									if(empty($_POST['legalName']))
									{
										$error=$legalNameErr="Please enter your legal name.";
									}elseif(empty($_POST['businessTradingName'])){
										$error=$businessTradingNameErr="Please enter business trading name.";
									}elseif(empty($_POST['cpn'])){
										$error=$cpnErr="Please enter contact person name.";
									}elseif(empty($_POST['doj'])){
										$error=$dojErr="Please enter date of joining.";
									}elseif(empty($_POST['businessEmail'])){
										$error=$businessEmailErr="Please enter business email.";
									}elseif(validated_userBusinessEmail($_POST['businessEmail'],$id)){								
										$error=$businessEmailValidate="Email already exist choose a different email.";
									}elseif(empty($_POST['businessPhoneNumber'])){
										$error=$businessPhoneNumberErr="Please enter your business phone number..";
									}elseif(validated_userBusinessPhoneNumber($_POST['businessPhoneNumber'],$id)){								
										$error=$businessPhoneNoValidate="Number already exist choose a different number.";
									}elseif(empty($_POST['secondaryEmail'])){
										$error=$emailErr="Please enter email address.";
									}elseif(empty($_POST['secondaryPhoneNumber'])){
										$error=$phoneNumberErr="Please enter your mobile number..";
									}elseif(empty($_POST['abn'])){								
										$error=$abn="Please enter your australian business number(ABN).";
									}elseif(empty($_POST['longitude'])){
										$error=$longitudeErr="Please enter longitude..";
									}elseif(empty($_POST['latitude'])){
										$error=$latitudeErr="Please enter latitude..";
									}elseif(empty($_POST['address'])){
										$error=$addressErr="Please enter address..";
									}
									elseif(empty($error))
									{
										if(!empty($_FILES['profile_pic']['name']))
										{
											$fileSaveDirectory="../../trunk/images";
											$target_dir = "images/";
											$target_file = $target_dir.$_FILES["profile_pic"]["name"];
											$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
											if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png")
											{
												$_SESSION['error']= "File Format Not Suppoted";
												header('location:users_list.php');
												?> <script> window.location='users_list.php'; </script> <?php
												exit;
											} 			 
											else
											{	
												if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['profile_pic']['name']))) {
												} else {
													echo "Sorry, there was an error uploading your file.";
												}
											}												
										}
										else{$target_file=$_POST['hid_tdimg'];}
										if(!empty($_FILES['food_licence_pic']['name']))
										{
											$fileSaveDirectory="../../trunk/images/food_registration";
											$target_dir_food = "images/food_registration/";
											$target_file_food = $target_dir_food.basename($_FILES["food_licence_pic"]["name"]);
											if (move_uploaded_file($_FILES["food_licence_pic"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['food_licence_pic']['name']))) {
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
										else{ $target_file_food=$_POST['hid_tdimg_food']; }
										
										if(!empty($_FILES['business_reg_pic']['name']))
										{
											$fileSaveDirectory = "../../trunk/images/business_licence";
											$target_dir_business = "images/business_licence/";
											$target_file_business = $target_dir_business.basename($_FILES["business_reg_pic"]["name"]);
											if (move_uploaded_file($_FILES["business_reg_pic"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['business_reg_pic']['name'])))
											{
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
										else{ $target_file_business=$_POST['hid_tdimg_business']; }
										
										
									//	$doj=date("Y-m-d", strtotime($_POST['doj']));
									$doj=str_replace("/",'-',$_POST['doj']); 
										$doj=(strtotime($doj)*1000);
									
									
										$result=mysqli_query($conn,"update users set first_name='".$_POST['legalName']."',last_name='".$_POST['cpn']."',email='".$_POST['secondaryEmail']."',mobile_no='".$_POST['secondaryPhoneNumber']."',
										dob='".$doj."',business_name='".$_POST['businessTradingName']."',
										business_email='".$_POST['businessEmail']."',
										business_phone_no='".$_POST['businessPhoneNumber']."'
										,aus_business_no='".$_POST['abn']."' ,
										address='".$_POST['address']."',
										profile_pic='".$target_file."' 
										,business_reg_pic='".$target_file_business."',
										food_licence_pic='".$target_file_food."',role='3',status='0',isNotify='1',longitude='".$_POST['longitude']."',latitude='".$_POST['latitude']."'
										where uid=$id");
									
									
										$result=mysqli_query($conn,"update dishes set longitude='".$_POST['longitude']."',latitude='".$_POST['latitude']."' where posted_by=$id");
										
										
										if($result)
										{
											
											$busi=mysqli_query($conn,"update users set monform='".$_POST['monfrom']."',
											monto='".$_POST['monto']."',tuefrom='".$_POST['tuefrom']."',
											tueto='".$_POST['tueto']."',wedfrom='".$_POST['wedfrom']."',
											wedto='".$_POST['wedto']."',thufrom='".$_POST['thufrom']."',
											thuto='".$_POST['thuto']."',frifrom='".$_POST['frifrom']."',
											frito='".$_POST['frito']."',satfrom='".$_POST['satfrom']."',
											satto='".$_POST['satto']."',sunfrom='".$_POST['sunfrom']."',
											sunto='".$_POST['sunto']."' where id=$id");
											
											$_SESSION['success']="Record Updated successfully";
											header('location:vendor_list.php');
											?> <script> window.location='vendor_list.php'; </script> <?php
											exit;
										}
										else
										{
											$_SESSION['error']="Error in Updating Record.";
											?> <script> window.location='vendor_edit.php?id=<?php echo $_GET['id'] ?>'; </script> <?php
											exit;
										}	
									
									}//else if		
								} //if
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="addUser">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
										<label>Legal Name*</label>
                                        <input type="text" class="masked_input md-input" name="legalName" id="legalName" 
										value="<?php echo $result['first_name'];?>" />
										<span class="uk-text-danger"><?php echo $legalNameErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Business Trading Name*</label>
                                        <input type="text" class="masked_input md-input" name="businessTradingName" 
										id="businessTradingName" value="<?php echo $result['business_name'];?>" />
										<span class="uk-text-danger"><?php echo $businessTradingNameErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Contact Person Name*</label>
                                        <input type="text" class="masked_input md-input" name="cpn" id="cpn" 
										value="<?php echo $result['last_name']; ?>" />
										<span class="uk-text-danger"><?php echo $cpnErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Date of Joining*</label>
                                        <input class="md-input masked_input" type="text" name="doj" id="uk_dp_1" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="<?php //echo $result['dob'];
									if($result['dob']) {
												$unix_timestamp = $result['dob'] / 1000;
												$datetime = new DateTime("@$unix_timestamp"); 
												echo $datetime->format('d-m-Y') ;
										}
										else {
											echo "";
											}							
										
										?>" 
										autocomplete='off'>
										<span class="uk-text-danger"><?php echo $dojErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Business Email*</label>
                                       <input class="masked_input md-input" name="businessEmail" id="businessEmail" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" value="<?php echo $result['business_email'];?>" />
										<span class="uk-text-danger"><?php echo $businessEmailErr;?></span>
										<span class="uk-text-danger"><?php echo $businessEmailValidate;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Business Phone Number*</label>
                                         <input class="md-input masked_input" id="businessPhoneNumber" 
										 name="businessPhoneNumber" type="text"
										 data-inputmask-showmaskonhover="false" value="<?php echo $result['business_phone_no'];?>" />
										<span class="uk-text-danger"><?php echo $businessPhoneNumberErr;?></span>
										<span class="uk-text-danger"><?php echo $businessPhoneNoValidate;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Secondary Email*</label>
                                       <input class="masked_input md-input" name="secondaryEmail" id="secondaryEmail" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" value="<?php echo $result['email'];?>" />
										<span class="uk-text-danger"><?php echo $emailErr; ?></span>
										<span class="uk-text-danger"><?php echo $emailValidate; ?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Secondary Phone Number*</label>
                                         <input class="md-input masked_input" id="secondaryPhoneNumber" 
										 name="secondaryPhoneNumber" type="text"
										 data-inputmask-showmaskonhover="false" value="<?php echo $result['mobile_no'];?>" />
										<span class="uk-text-danger"><?php echo $phoneNumberErr;?></span>
										<span class="uk-text-danger"><?php echo $phoneNoValidate;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Australian Business Number(ABN)*</label>
                                         <input class="md-input masked_input" id="abn" name="abn" type="text"
										 data-inputmask-showmaskonhover="false" value="<?php echo $result['aus_business_no'];?>" />
										<span class="uk-text-danger"><?php echo $abn;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
										<label>Profile Pic : </label>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="profile_pic" type="file" name="profile_pic" 
											accept="image/gif, image/jpeg ,image/png">
											<input type="hidden" name="hid_tdimg" id="hid_tdimg" 
											value="<?php echo $result['profile_pic'];  ?>" /> 
                                        </div>
										<?php if($result['profile_pic']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" style="height:60px;"
											src="<?php echo baseURL().$result['profile_pic'];?>">
										</span>
										
										<?php } ?>
                                    </div>
									<div class="uk-width-medium-1-2">
										<label>Business Certificate : </label>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="business_reg_pic" type="file" name="business_reg_pic" 
											accept="image/gif, image/jpeg ,image/png">
											<input type="hidden" name="hid_tdimg_business" id="hid_tdimg" 
											value="<?php echo $result['business_reg_pic'];  ?>" /> 
                                        </div>
										<?php if($result['business_reg_pic']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" style="height:60px;"
											src="<?php echo baseURL().$result['business_reg_pic'];?>">
										</span>
										<?php } ?>
                                    </div>
									<div class="uk-width-medium-1-2">
										<label>Food Licence Pic : </label>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="food_licence_pic" type="file" name="food_licence_pic" 
											accept="image/gif, image/jpeg ,image/png">
											<input type="hidden" name="hid_tdimg_food" id="hid_tdimg" 
											value="<?php echo $result['food_licence_pic'];  ?>" /> 
                                        </div>
										<?php if($result['food_licence_pic']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" style="height:60px;"
											src="<?php echo baseURL().$result['food_licence_pic'];?>">
										</span>
										<?php } ?>
                                    </div>
									 <!--////////////////////-->
                                    <div class="uk-width-medium-1-2">
                                    	<label>Longitude</label>
                                        <input type="text" class="md-input" name="longitude" id="longitude" value="<?php echo $result['longitude'] ?>"/>
									   	<span class="uk-text-danger"><?php echo $longitudeErr;?></span>
									</div>
                                    <div class="uk-width-medium-1-2">
                                    	<label>Latitude</label>
                                        <input type="text" class="md-input" name="latitude" id="latitude" value="<?php echo $result['latitude'] ?>"/>
										<span class="uk-text-danger"><?php echo $latitudeErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                    	<label>Address</label>
                                        <input type="text" class="md-input" name="address" id="address" value="<?php echo $result['address'] ?>"/>
										<span class="uk-text-danger"><?php echo $addressErr;?></span>
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
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  
										 value="<?php echo $bushr['monform'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="monto" 
										 name="monto" type="text" data-uk-timepicker="{format:'12h'}"
										 data-inputmask-showmaskonhover="false" value="<?php echo $bushr['monto'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Tuesday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="tuefrom" name="tuefrom" type="text"
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"  
										 value="<?php echo $bushr['tuefrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="tueto" name="tueto" type="text"
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false"
										 value="<?php echo $bushr['tueto'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Wednesday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="wedfrom" name="wedfrom" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['wedfrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="wedto" name="wedto" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['wedto'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Thursday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="thufrom" name="thufrom" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['thufrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="thuto" name="thuto" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['thuto'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Friday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="frifrom" name="frifrom" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['frifrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="frito" 
										 name="frito" type="text" data-uk-timepicker="{format:'12h'}"
										 data-inputmask-showmaskonhover="false" value="<?php echo $bushr['frito'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Saturday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="satfrom" 
										 name="satfrom" type="text" data-uk-timepicker="{format:'12h'}"
										 data-inputmask-showmaskonhover="false" value="<?php echo $bushr['satfrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="satto" 
										 name="satto" type="text" data-uk-timepicker="{format:'12h'}"
										 data-inputmask-showmaskonhover="false" value="<?php echo $bushr['satto'];?>" />
                                    </div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-6" >
										 <label>Sunday</label>
									</div>
									<div class="uk-width-medium-1-3">
                                        <label>From</label>
                                         <input class="md-input masked_input" id="sunfrom" 
										 name="sunfrom" type="text" data-uk-timepicker="{format:'12h'}"
										 data-inputmask-showmaskonhover="false" value="<?php echo $bushr['sunfrom'];?>" />
                                    </div>
									<div class="uk-width-medium-1-3">
                                        <label>To</label>
                                         <input class="md-input masked_input" id="sunto" name="sunto" type="text" 
										 data-uk-timepicker="{format:'12h'}" data-inputmask-showmaskonhover="false" 
										 value="<?php echo $bushr['sunto'];?>" />
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
   
  