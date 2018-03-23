<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; 
	$query=mysqli_query($conn,"select * from about_us where id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	
	}
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit About Us Detail</h1>
						<div class="uk-form-row">
							<div class="uk-width-10-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error=$ltitleErr=$descErr="";
								if(isset($_POST['submit']))
								{
									if(empty($_POST['title']))
									{
										$error=$titleErr="Please enter title.";
									}
									elseif(empty($_POST['desc'])){
										$error=$descErr="Please enter description.";
										}
									elseif(empty($error))
									{
										if(!empty($_FILES['image_1']['name']))
										{
											$fileSaveDirectory="../../trunk/images/about_us";
											$target_dir = "images/about_us/";
											$target_file = $target_dir.$_FILES["image_1"]["name"];
											$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
											if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png")
											{
												$_SESSION['error']= "File Format Not Suppoted";
												//header('location:users_list.php');
												header('location:about_us.php');
												?> <script> window.location='about_us.php'; </script> <?php
												exit;
											} 			 
											else
											{	
												if (move_uploaded_file($_FILES["image_1"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['image_1']['name']))) {
												} else {
													echo "Sorry, there was an error uploading your file.";
												}
											}												
										}
										else{$target_file=$_POST['hid_tdimg'];}
										
										if(!empty($_FILES['image_2']['name']))
										{
											$fileSaveDirectory="../../trunk/images/about_us";
											$target_dir_food = "images/about_us/";
											$target_file_food = $target_dir_food.basename($_FILES["image_2"]["name"]);
											if (move_uploaded_file($_FILES["image_2"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['image_2']['name']))) {
											} else {
												echo "Sorry, there was an error uploading your file.";
											}
										}
										else{ $target_file_food=$_POST['hid_tdimg_food']; }
										
										
									
										$result=mysqli_query($conn,"update about_us set title='".$_POST['title']."',
										image_1='".$target_file."', 
										image_2='".$target_file_food."',
										description='".$_POST['desc']."'
										where id=$id");
									
										if($result)
										{
											
											$_SESSION['success']="Record Updated successfully";
											header('location:about_us.php');
											?> <script> window.location='about_us.php'; </script> <?php
											exit;
										}
										else
										{
											$_SESSION['error']="Error in Updating Record.";
											?> <script> window.location='about_us.php?id=<?php echo $_GET['id'] ?>'; </script> <?php
											exit;
										}	
									
									}//else if		
								} //if
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="addUser">
								<div class="uk-grid" data-uk-grid-margin>
                                
									<div class="uk-width-medium-1-1">
										<label>Title*</label>
                                        <input type="text" class="masked_input md-input" name="title" id="title" 
										value="<?php echo $result['title'];?>" />
										<span class="uk-text-danger"><?php echo $titleErr;?></span>
                                    </div>
                                    
									<div class="uk-width-medium-1-1">
										<label>Image 1 : </label>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="image_1" type="file" name="image_1" 
											accept="image/gif, image/jpeg ,image/png">
											<input type="hidden" name="hid_tdimg" id="hid_tdimg" 
											value="<?php echo $result['image_1'];  ?>" /> 
                                        </div>
										<?php if($result['image_1']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" style="height:60px;"
											src="<?php echo baseURL().$result['image_1'];?>">
										</span>
										
										<?php } ?>
                                    </div>
									
									<div class="uk-width-medium-1-1">
										<label>image 2 : </label>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="image_2" type="file" name="image_2" 
											accept="image/gif, image/jpeg ,image/png">
											<input type="hidden" name="hid_tdimg_food" id="hid_tdimg_food" 
											value="<?php echo $result['image_2'];  ?>" /> 
                                        </div>
										<?php if($result['image_2']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" style="height:60px;"
											src="<?php echo baseURL().$result['image_2'];?>">
										</span>
										<?php } ?>
                                    </div>
                                    
									<!--<div class="uk-width-medium-1-1">
										<label>Description*</label>
										<textarea class="masked_input md-input" name="desc" 
										id="desc"><?php echo $result['description'];?></textarea>
										<span class="uk-text-danger"><?php echo $descErr;?></span>
                                    </div>-->
                                    <div class="uk-width-medium-1-1">
                                    <label>Description*</label>
                                        <textarea class="ckeditor" name="desc" id="desc"><?php echo $result['description'];?></textarea>
                                        <span class="uk-text-danger"><?php echo $descErr;?></span>
                                    </div>
                                    
                                    <div style="clear:both"></div>
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="about_us.php">Cancel</a>
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
var editor = CKEDITOR.replace( 'desc', {
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
   
  