<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php
	date_default_timezone_set('UTC');
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from users where uid=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">User Detail</h1>
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
										<label>User Name</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['first_name'].' '.$result['last_name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Email:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['email'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Date of birth:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php //echo date("d-m-Y", $result['dob']);
										
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
										<label>Gender:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['gender'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Mobile Number:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['mobile_no'];?></label>
                                    </div>
                                    <div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="users_edit.php?id=<?php echo $result['uid'];?>">Edit</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="#my-id" data-uk-modal>Delete</a>
                        			</div>
									<?php if($result['status']==1){?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['uid'];?>&action=block&role=user&status=<?=$result['status'];?>">Block</a>
										</div>
									
									<?php }else{ ?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['uid'];?>&action=block&role=user&status=<?=$result['status'];?>">UnBlock</a>
										</div>
									<?php } ?>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="users_list.php">Cancel</a>
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
		<h3 class="uk-text-left">Remove User</h3>
		<hr />
		<div>
			<p> Are you sure you want to remove this user? </p>
		</div>
		<hr />
		<div style="text-align:right">
			<a class="md-btn md-btn-wave uk-modal-close">Cancel</a>
			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light"
			href="case.php?id=<?= $result['uid'];?>&action=delete&role=user">Yes</a>
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
   
  