<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from help where id='".$id."'") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Help Reply</h1>
						<div class="uk-form-row">
							<div class="uk-width-10-10 uk-container-center">
								<?php if(!empty($_SESSION['success'])) { ?>
									<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
								<?php $_SESSION['success']="";} ?>
								 
								<?php if(!empty($_SESSION['error'])) { ?>
									<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
								<?php $_SESSION['error']="";} ?>
								 <?php
                                    $error=$suggestionErr="";
									if(isset($_POST['submit']))
									{
										if(empty($_POST['suggestion']))
										{
											$error=$suggestionErr="Suggestion cann't be blank";
										}
										else
										{
											$email=$result['email'];
											$data=mysqli_query($conn,"update help set request_status=1,admin_reply='".$_POST['suggestion']."' where id=$id");
												if($data==1)
												{
													$to = $email;
													$subject = "Fooduction Help Center";
													$txt = $_POST['suggestion'];
													$headers = "From: 'help@fooduction.com.au'";
													mail($to,$subject,$txt,$headers);
													$_SESSION['success']= "Replied Successfully";
													?> <script> window.location='help_list.php'; </script> <?php
													exit;
												}
												else{ $_SESSION['error']="Error in creating user.";
													?> <script> window.location='help_reply.php?id=<?php echo $id ?>'; 
													</script> <?php exit;
												 }	
											}
										}
                                    ?>
								
								<form action="" method="post" enctype="multipart/form-data" id="addUser">
								<div class="uk-grid" data-uk-grid-margin>
									
									<div class="uk-width-2-10">
										<label>Client Name:</label>
                                    </div>
                                   	<div class="uk-width-8-10">
                                        <label><?php echo $result['name'];?></label>
                                    </div>
									<div class="uk-width-2-10">
										<label>Email:</label>
                                    </div>
                                   	<div class="uk-width-8-10">
                                        <label><?php echo $result['email'];?></label>
                                    </div>
									<div class="uk-width-2-10">
										<label>Query:</label>
                                    </div>
                                   	<div class="uk-width-8-10">
                                        <label><?php echo $result['query'];?></label>
                                    </div>
									<div class="uk-width-2-10">
										<label>Suggestion:</label>
                                    </div>
                                   	<div class="uk-width-8-10">
                                        <textarea name="suggestion" class="md-input" ></textarea>
										<span class="uk-text-danger"><?php echo $suggestionErr;?></span>
                                    </div>
									
                                   <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="help_list.php">Cancel</a>
                        			
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
   
  