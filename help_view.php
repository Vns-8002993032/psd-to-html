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
					<div class="md-card-content"><h1 class="uk-text-center">Help Request</h1>
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
										<label>Name</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Email:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['email'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Query:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['query'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Reply Message:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['admin_reply'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Request Status:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php if($result['request_status']==0){echo "Pending";}elseif($result['request_status']==1){echo "Replied";}?></label>
                                    </div>
                                   
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="help_reply.php?id=<?php echo $result['id'];?>">Reply</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="#my-id" data-uk-modal>Delete</a>
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
		<h3 class="uk-text-left">Remove Help Request</h3>
		<hr />
		<div>
			<p> Are you sure you want to remove this help request? </p>
		</div>
		<hr />
		<div style="text-align:right">
			<a class="md-btn md-btn-wave uk-modal-close">Cancel</a>
			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light"
			href="case.php?id=<?= $result['id'];?>&action=deletehelp&role=help">Yes</a>
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
   
  