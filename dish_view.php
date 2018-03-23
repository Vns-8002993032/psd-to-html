<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select d.id as dish_id,d.status as dish_status,d.comment as comm,d.*,dc.*,u.* from dishes d join dishes_category dc on d.category=dc.id join users u on u.uid=d.posted_by where d.id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Dish Detail</h1>
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
										<label>Dish Image:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <?php if($result['dish_image']!=''){ ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['dish_image'];?>">
										<?php } 
										else { ?>
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo 'dfault.jpeg';?>">
										<?php } ?>
                                    </div>
									<div class="uk-width-3-10">
										<label>Owner Name</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['first_name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Category:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['category_name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Name of Dish:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['dish_name'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Description:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['description'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Discount:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['discount'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Quantity:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['quantity'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Price:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['price'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Allergic Ingredent:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['allergic_ingredients'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Commission:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['commission'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Comment:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['comm'];?></label>
                                    </div>
									
									
                                    <div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="dish_edit.php?id=<?= $result['dish_id'];?>">Edit</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="#my-id" data-uk-modal>Reject</a>
                        			</div>
									<?php if($result['dish_status']==1){?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['dish_id'];?>&action=approve&status=<?=$result['dish_status'];?>">Approved</a>
										</div>
									
									<?php }else{ ?>
										<div class="uk-width-medium-2-10">
											<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="case.php?id=<?= $result['dish_id'];?>&action=approve&status=<?=$result['dish_status'];?>">Approve</a>
										</div>
									<?php } ?>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="dishes_list.php">Cancel</a>
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
		<h3 class="uk-text-left">Remove Dishes</h3>
		<hr />
		<div>
			<p> Are you sure you want to reject this Dish? </p>
		</div>
		<hr />
		<div style="text-align:right">
			<a class="md-btn md-btn-wave uk-modal-close">Cancel</a>
			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light"
			href="case.php?id=<?= $result['dish_id'];?>&action=rejectDish">Yes</a>
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
   
  