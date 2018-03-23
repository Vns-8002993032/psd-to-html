<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 								
	if(isset($_GET['id']))
	{	$id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from static_pages where id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	
	
	$error=$descriptionErr="";
	if(isset($_POST['submit']))
	{
		if(empty($_POST['description']))
		{
			$error=$descriptionErr="Description is required";	
		}
		elseif(empty($error))
		{
			$update=mysqli_query($conn,"update static_pages set description='".$_POST['description']."' where id=$id");
			if($update==1)
			{
				$_SESSION['success']= "Privacy Policy page updated";
				?> <script> window.location='pages.php?id=<?php echo $id; ?>'; </script> <?php
				exit;
			}
			else{ $_SESSION['success']= "Page not updated. Try agian";
				?> <script> window.location='privacy_policy.php?id=<?php echo $id; ?>'; </script> <?php
				exit;
			}	
		}
	}
	
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Privacy Policy</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<form action = "" method = "post" enctype="multipart/form-data">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							 
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
								<div class="uk-grid" data-uk-grid-margin>
									
									<textarea class="ckeditor" name="description"><?php echo $result['description'];?></textarea>
									<span class="uk-text-danger"><?php echo $descriptionErr;?></span>
									<div style="clear:both;"></div>
                                    
									<div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Save</button>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="pages.php?id=2">Cancel</a>
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

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'detail', {
    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editor, '../' );
</script>
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
   
  