<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 								
	if(isset($_GET['id']))
	{	$id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from static_pages where id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	
	$title='';
	if($id==1)
	{ $title='Term & Conditions'; }
	else if($id==2)
	{ $title='Privacy Policy'; }
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center"><?php echo $title; ?></h1>
						<div class="uk-form-row">
							<div class="uk-width-10-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							 
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
								<div class="uk-grid" data-uk-grid-margin>
									<?php echo $result['description'];?>
									
									<div style="clear:both"></div>
                                    <div class="uk-width-medium-2-10">
									
										<?php 
											$url='';
											if($id==1)
											{
												$url='terms.php?id='.$id;
											}
											else if($id==2)
											{
												$url='privacy_policy.php?id='.$id;
											}
											else if($id==3)
											{
												$url='guide.php?id='.$id;
											}
										
										?>
									
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo $url; ?>">Edit</a>
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
   
  