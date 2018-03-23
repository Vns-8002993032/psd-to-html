<?php include('header.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 								
	
	$data=mysqli_query($conn,"select video_link from video_tutorial");
	$row=mysqli_fetch_assoc($data);


	if(isset($_POST['submit'])){
	if(empty($_FILES['video'])){
		$_SESSION['error']="File is requird";
		}
	else{	
			$dir="video/";
			$target_dir = "../../trunk/video/";			 
			$target_file = $target_dir . basename($_FILES["video"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);			 
			if($imageFileType != "mp4" && $imageFileType != "avi" && $imageFileType != "mov" && $imageFileType != "3gp" && $imageFileType != "mpeg")
			{
				$_SESSION['error']="File Format Not Suppoted";
			} 			 
			else
			{			 
			$video_path=$dir.$_FILES['video']['name'];			 
			mysqli_query($conn,"update video_tutorial set video_link='".$video_path."' ") or die("Video can't be uploaded");			 
			move_uploaded_file($_FILES["video"]["tmp_name"],$target_dir."/".basename($_FILES["video"]["name"]));			 
			$_SESSION['success']= "uploaded ";			 
			}	
	}
}

?>
<script src="jwplayer/jwplayer.js"></script>
<script>jwplayer.key="QVfPCrvWLDuhaC39ZZ5KRHD6143cJmsjnjAvGw==";</script>
<script type="text/javaScript">
	var playerInstance = jwplayer("myElement");
	playerInstance.setup({
			flashplayer: "player.swf",
			file: "<?= baseURL().$row['video_link'];?>"
	});
</script>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Video</h1>
						<div class="uk-form-row">
							<div class="uk-width-10-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							 
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							<form method="post" enctype="multipart/form-data" action="">
								<div class="uk-grid" data-uk-grid-margin>
									
									<div class="uk-width-3-10">
										<label>Upload Video(Upto 8 Mb)</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <div class="uk-form-file md-btn md-btn-primary">Select
											<input id="video" type="file" name="video">
										</div>
                                    </div>
									
									<div style="clear:both"></div>
                                    <div class="uk-width-medium-10-10">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Upload</button>
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
   
  