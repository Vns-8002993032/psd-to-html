<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $oid=$_GET['id']; }
	$query=mysqli_query($conn,"select co.*,u.first_name,u.last_name,u.mobile_no,u.address,u.email from cartorders co join users u on co.uid=u.uid where pkuniquecartid='".$oid."'") or die(mysqli_error($conn));
	
	$result=mysqli_fetch_assoc($query);
	$vdata=mysqli_query($conn,"select business_name,address,mobile_no,business_email from users where uid='".$result['vendor_id']."'");
	$fetchedData=mysqli_fetch_assoc($vdata);
	$dishData=mysqli_query($conn,"select * from dishes where id ='".$result['dish_id']."'");
	$dishfetchedData=mysqli_fetch_assoc($dishData);
	
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Order Detail</h1>
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
										<label>Transaction Id:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['transaction_id']; ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Name:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['first_name']." ".$result['last_name']; ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Email No:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['email'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Mobile No:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['mobile_no'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Invoice Date:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo date("d-m-Y", $result['created_on']/1000);?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Time:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo date("h:i:s",ceil($result['created_on']/1000)); ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Order status:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php if($result['delivery_status']==0){ echo "Pending";}elseif($result['delivery_status']==1){ echo "Completed";}elseif($result['delivery_status']==2) echo "Cancelled";?></label>
                                    </div>
									
									<?php 
										$ord=explode(',',$result['orders']);
										$n=1;
										for($i=0;$i<sizeof($ord);$i++)
										{
											$qry=mysqli_query($conn,"select o.*,d.dish_name from orders o join dishes d on 
											o.dish_id=d.id where o.order_id='".$ord[$i]."' and vendor_id='".$_GET['uid']."'")
											 or die(mysqli_error($conn));
											
											$rs=mysqli_fetch_assoc($qry);
											if(mysqli_num_rows($qry)>0)
											{
												$damt=$rs['dish_amount']-(($rs['dish_amount']*$rs['dish_discount'])/100);
												$users=mysqli_query($conn,"select * from users where 
												uid='".$rs['order_by']."'") or die(mysqli_error($conn));
												$u=mysqli_fetch_assoc($users);
										?>
												<div class="uk-width-3-10">
													<label>Dish <?php echo $n?>:</label>
												</div>
												<div class="uk-width-7-10">
													<?php echo $rs['dish_name'];?>
												</div>
												<div class="uk-width-3-10">
													<label>Dish Amount <?php echo $n?>:</label>
												</div>
												<div class="uk-width-7-10">
													<?php echo $damt;?>
												</div>
												<div class="uk-width-3-10">
													<label>Dish <?php echo $n?> User Name:</label>
												</div>
												<div class="uk-width-7-10">
													<?php echo $u['first_name']; ?>
												</div>
												<div class="uk-width-3-10">
													<label>Dish <?php echo $n?> Mobile Number:</label>
												</div>
												<div class="uk-width-7-10">
													<?php echo $u['mobile_no']; ?>
												</div>
												<div class="uk-width-3-10">
													<label>Dish <?php echo $n?> Address:</label>
												</div>
												<div class="uk-width-7-10">
													<?php echo $u['address']; ?>
												</div>
									
                                    <?php  $n++; }
									} /*?><div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="busi_order_edit.php?id=<?php echo $result['order_id'];?>">Edit</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<form method="post" action="">
											<button type="submit" name="sendInvoice" class="md-btn md-btn-primary">sendInvoice</button>
										</form>
                        			</div><?php */?>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="business_order_history.php?id=<?php echo $_GET['uid']; ?>">Cancel</a>
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
   
  