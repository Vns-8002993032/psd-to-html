<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $transaction_id=$_GET['id']; }
	$query=mysqli_query($conn,"select * from payment p join users u on p.pay_by=u.uid join orders o on p.order_id=o.order_id where p.order_id='".$transaction_id."'") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit Order</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error=$nameErr=$mobileNoErr=$addressErr=$noOfItemErr=$amountErr=$statusErr="";
								if(isset($_POST['submit']))
								{
									if(empty($_POST['no_of_items']))
									{
										$error=$noOfItemErr="No of items is required";
									}elseif($_POST['order_status']==""){
										$error=$statusErr="Order status can't be null";
									}else{
										$result=mysqli_query($conn,"update orders set no_of_items='".$_POST['no_of_items']."',delivery_status='".$_POST['order_status']."' where order_id=$transaction_id");
										if($result==1){
											$_SESSION['success']= "Record Updated Successfully";
											header('location:order_list.php?id='.$id);
											?> <script> window.location='business_orders.php'; </script> <?php
												exit;
										}
										else{ $_SESSION['error']="Error in creating user.";
										?> <script> window.location='busi_order_edit.php?id=<?php echo $_GET['id'] ?>'; </script> <?php
											exit;
										}	
									}
								}
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="editUser">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-1">
										<label>No of Item*</label>
                                        <input type="text" class="masked_input md-input" name="no_of_items" id="no_of_items" 
										value="<?php echo $result['no_of_items'];?>" />
										<span class="uk-text-danger"><?php echo $noOfItemErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-1">
                                        <label>Order status*</label>
                                        <select name="order_status" class="masked_input md-input">
											<option value="<?= $result['delivery_status'];?>"><?php if($result['delivery_status']==0){ echo "Pending";}elseif($result['delivery_status']==1){ echo "Completed";}elseif($result['delivery_status']==2) echo "Cancelled";?></option>
											<option value="0">Pending</option>
											<option value="1">Completed</option>
											<option value="2">Cancelled</option>
										</select>
										<span class="uk-text-danger"><?php echo $statusErr;?></span>
                                    </div>
                                    
                                    
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="business_orders.php">Cancel</a>
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
   
  