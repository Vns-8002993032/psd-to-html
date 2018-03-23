<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from users where uid=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit User</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error=$firstNameErr=$lastNameErr=$emailErr=$phoneNumberErr=$genderErr=$dobErr=$passwordErr=$cnfErr=$emailValidate=$phoneNoValidate=$passwordValidationErr="";
								
								if(isset($_POST['submit']))
								{
									if(empty($_POST['firstName'])){$error=$firstNameErr="Please enter your first name.";}
									elseif(empty($_POST['email'])){ $error=$emailErr="Please enter email address.";}
									elseif(validated_userEmail($_POST['email'],$id)){
										$error=$emailValidate="Email already exist choose a different email.";
									}
									elseif(empty($_POST['phoneNumber'])){
										$error=$phoneNumberErr="Please enter your mobile number..";
									}
									elseif(validated_userMobile($_POST['phoneNumber'],$id)){								
										$error=$phoneNoValidate="Mobile number already exist choose a different number.";
									}
									elseif(empty($_POST['dob'])){ $error=$dobErr="Please enter date of birth."; }
									elseif(empty($_POST['gender'])){ $error=$genderErr="Please select gender."; }
									
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
										else{
											$target_file=$_POST['hid_tdimg'];
										}
										//$dt=date("d-m-Y", strtotime($_POST['dob']));
										$dt=str_replace("/",'-',$_POST['dob']); 
										$dt=(strtotime($dt)*1000);
										
										$result=mysqli_query($conn,"update users set first_name='".$_POST['firstName']."',last_name='".$_POST['lastName']."',email='".$_POST['email']."',gender='".$_POST['gender']."',mobile_no='".$_POST['phoneNumber']."',profile_pic='".$target_file."',dob='".$dt."' where uid=$id");
										
										if($result)
										{
											$_SESSION['success']="Record Updated Successfully";
											header('location:users_list.php');
											?> <script> window.location='users_list.php'; </script> <?php
											exit;
										}
										else
										{
											$_SESSION['error']="Error in Updating Record.";
											?> <script> window.location='users_edit.php?id=<?php echo $_GET['id'] ?>'; </script> <?php
											exit;
										}	
									}//else if	
											
								} //if
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="editUser">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-1">
										<label>First Name*</label>
                                        <input type="text" class="masked_input md-input" name="firstName" id="firstName" 
										value="<?php echo $result['first_name'];?>" />
										<span class="uk-text-danger"><?php echo $firstNameErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Last Name*</label>
                                        <input type="text" class="masked_input md-input" name="lastName" id="lastName" 
										value="<?php echo $result['last_name'];?>"/>
										<span class="uk-text-danger"><?php echo $lastNameErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Email Id*</label>
                                       <input class="masked_input md-input" name="email" id="email" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" value="<?php echo $result['email'];?>" />
										<span class="uk-text-danger"><?php echo $emailErr;?></span>
										<span class="uk-text-danger"><?php echo $emailValidate;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Mobile Number*</label>
                                         <input class="md-input masked_input" id="phoneNumber" name="phoneNumber" type="text"
										 data-inputmask-showmaskonhover="false" value="<?php echo $result['mobile_no'];?>" />
										<span class="uk-text-danger"><?php echo $phoneNumberErr;?></span>
										<span class="uk-text-danger"><?php echo $phoneNoValidate;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Date of Birth*</label>
                                        <input class="md-input masked_input" type="text" name="dob" id="uk_dp_1" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="<?php //echo date("d-m-Y", $result['dob']);
				if($result['dob']) {
												$unix_timestamp = $result['dob'] / 1000;
												$datetime = new DateTime("@$unix_timestamp"); 
												echo $datetime->format('d-m-Y') ;
										}
										else {
											echo "";
											}						
										
										?>" autocomplete='off'>
										<span class="uk-text-danger"><?php echo $dobErr; ?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label class="inline-label">Gender* :- </label>
                                        <span class="icheck-inline">
											<input type="radio" name="gender" id="radio_demo_inline_1" data-md-icheck value="Male" <?php if($result['gender']=='Male'){ echo 'checked="checked"'; }?>  />
											<label for="radio_demo_inline_1" class="inline-label">Male</label>
										</span>
										<span class="icheck-inline">
											<input type="radio" name="gender" id="radio_demo_inline_2" data-md-icheck value="Female" <?php if($result['gender']=='Female'){ echo 'checked="checked"'; }?> />
											<label for="radio_demo_inline_2" class="inline-label">Female</label>
										</span>
										<span class="uk-text-danger"><?php echo $genderErr; ?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
										<h3 class="heading_a uk-margin-bottom">Profile Pic</h3>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="profile_pic" type="file" name="profile_pic">
											<input type="hidden" name="hid_tdimg" id="hid_tdimg" value="<?php echo $result['profile_pic']; ?>" />
                                        </div>
										<?php if($result['profile_pic']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['profile_pic'];?>">
										</span>
										<?php } ?>
                                    </div>
                                    
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="users_list.php">Cancel</a>
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
   
  