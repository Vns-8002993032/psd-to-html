<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from users where uid=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	$busi=mysqli_query($conn,"select * from business_hr where uid=$id") or die(mysqli_error($conn));
	$RP=mysqli_fetch_assoc($busi);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Vendor Detail</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							 
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-3-10">
										<label>Profile Picture:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <?php if($result['profile_pic']!=''){ ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['profile_pic'];?>">
										<?php } 
										else { ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo 'dfault.jpeg';?>">
										<?php } ?>
                                    </div>
									<div class="uk-width-3-10">
										<label>User Name:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['first_name']; ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Business Trading Name:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['business_name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Email:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['email'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Business Phone Number:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['business_phone_no'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Business Email:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['business_email'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Australian Business Number:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['aus_business_no'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Date of Joining:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label>
										<?php //echo $result['dob'];
										
										if($result['dob']) {
												$unix_timestamp = $result['dob'] / 1000;
												$datetime = new DateTime("@$unix_timestamp"); 
												echo $datetime->format('d-m-Y') ;
										}
										else {
											echo "";
											}						
										
										
										?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Phone Number:</label>
                                    </div>
                                    <div class="uk-width-7-10">
                                        <label><?php echo $result['mobile_no'];?></label>
                                    </div>
                                    <div class="uk-width-3-10">
										<label>Longitude:</label>
                                    </div>
                                    <div class="uk-width-7-10">
                                        <label><?php echo $result['longitude'];?></label>
                                    </div>
                                    <div class="uk-width-3-10">
										<label>Latitude:</label>
                                    </div>
                                    <div class="uk-width-7-10">
                                        <label><?php echo $result['latitude'];?></label>
                                    </div>
                                    <div class="uk-width-3-10">
										<label>Address:</label>
                                    </div>
                                    <div class="uk-width-7-10">
                                        <label><?php echo $result['address'];?></label>
                                    </div>
                                   
									<div class="uk-width-3-10">
										<label>Business Certificate:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <?php if($result['business_reg_pic']!=''){ ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['business_reg_pic'];?>">
										<?php } 
										else { ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo 'dfault.jpeg';?>">
										<?php } ?>
                                    </div>
									<div class="uk-width-3-10">
										<label>Business Licence:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <?php if($result['food_licence_pic']!=''){ ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['food_licence_pic'];?>">
										<?php } 
										else { ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo 'dfault.jpeg';?>">
										<?php } ?>
                                    </div>
									<div class="uk-width-medium-1-1">
										<h3> Business Trading hours </h3>
									</div>
									<div class="uk-width-medium-1-4"><label><b>Day</b></label></div>
									<div class="uk-width-medium-1-3"><label><b>From</b></label></div>
									<div class="uk-width-medium-1-3"><label><b>To</b></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Monday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['monform'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['monto'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Tuesday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['tuefrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['tueto'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Wednesday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['wedfrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['wedto'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Thrusday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['thufrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['thuto'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Friday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['frifrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['frito'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Saturday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['satfrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['satto'];?></label></div>
									<div style="clear:both"></div>
									<div class="uk-width-medium-1-4"><label>Sunday</label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['sunfrom'];?></label></div>
									<div class="uk-width-medium-1-3"><label><?php echo $RP['sunto'];?></label></div>
									
									
									<div style="clear:both"></div>
                                    <div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="vendor_edit.php?id=<?php echo $result['uid'];?>">Edit</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="#my-id" data-uk-modal>Delete</a>
                        			</div>
									<?php if($result['status']==1){?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['uid'];?>&action=block&role=vendor&status=<?=$result['status'];?>">Block</a>
										</div>
									
									<?php }else{ ?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['uid'];?>&action=block&role=vendor&status=<?=$result['status'];?>">UnBlock</a>
										</div>
									<?php } ?>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="vendor_list.php">Cancel</a>
                        			</div>
                        			
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
        
<div id="my-id" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<h3 class="uk-text-left">Remove Vendor</h3>
		<hr />
		<div>
			<p> Are you sure you want to remove this vendor? </p>
		</div>
		<hr />
		<div style="text-align:right">
			<a class="md-btn md-btn-wave uk-modal-close">Cancel</a>
			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light"
			href="case.php?id=<?= $result['uid'];?>&action=delete&role=vendor">Yes</a>
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
   
  