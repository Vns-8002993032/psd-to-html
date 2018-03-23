<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from coupon where id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit Coupon</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error = $cou_codeErr = $cou_perErr = $fromdateErr = $todateErr="";
								if(isset($_POST['submit']))
								{
									if(empty($_POST['cou_code'])){
										$error = $cou_codeErr ="Please Enter Coupon Code";
									}
									elseif(empty($_POST['cou_per'])){
										$error = $cou_perErr ="Please Enter Coupon Percentage";
									}
									elseif(empty($_POST['fromdate'])){
										$error = $fromdateErr ="Please Select From Date";
									}
									elseif(empty($_POST['todate'])){
										$error = $todateErr ="Please Select To Date ";
									}
									else
									{
										$frm=date('Y-m-d',strtotime($_POST['fromdate']));
										$to=date('Y-m-d',strtotime($_POST['todate']));
										
										$query = mysqli_query($conn, "update `coupon` set coupon_code='".$_POST['cou_code']."',coupon_per='".$_POST['cou_per']."',fromdate='".$frm."',todate='".$to."' where id=$id ");
										
									if($query==1){
										$_SESSION['success']="Coupon Updated Successfully";
										header('location:coupons_list.php');
										?> <script> window.location='coupons_list.php'; </script> <?php
										exit;
									}
									else{
										$_SESSION['error']="Error in Updating Coupon ".mysqli_error($conn);
									}
									}
											
								} //if
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="addUser">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-1">
										<label>Coupon Code*</label>
                                        <input type="text" class="masked_input md-input" name="cou_code" id="cou_code" 
										value="<?php echo $result['coupon_code']; ?>" />
										<span class="uk-text-danger"><?php echo $cou_codeErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Coupon Percentage*</label>
                                        <input type="text" class="masked_input md-input" name="cou_per" id="cou_per" 
										value="<?php echo $result['coupon_per']; ?>"/>
										<span class="uk-text-danger"><?php echo $cou_perErr;?></span>
                                    </div>
                                   
                                    <div class="uk-width-medium-1-1">
                                        <label>From Date*</label>
										<?php $frm=date('d-m-Y',strtotime($result['fromdate'])); ?>
                                        <input class="md-input masked_input" type="text" name="fromdate" id="uk_dp_1" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="<?php echo $frm; ?>" 
										autocomplete='off'>
										<span class="uk-text-danger"><?php echo $fromdateErr; ?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>To Date*</label>
										<?php $to=date('d-m-Y',strtotime($result['todate'])); ?>
                                        <input class="md-input masked_input" type="text" name="todate" id="uk_dp_1" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="<?php echo $to; ?>" 
										autocomplete='off'>
										<span class="uk-text-danger"><?php echo $todateErr; ?></span>
                                    </div>
                                    
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="coupons_list.php">Cancel</a>
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
   
  