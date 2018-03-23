<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $id=$_GET['id']; }
	$query=mysqli_query($conn,"select d.id as dish_id,d.status as dish_status,d.comment as comm,d.*,dc.*,u.* from dishes d join dishes_category dc on d.category=dc.id join users u on u.uid=d.posted_by where d.id=$id") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Edit Dish</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								
								$error = $dnameErr = $cnameErr = $descriptionErr = $discountErr = $quantityErr = $totalAmountErr = $selectUserErr=$selectCategoryErr=$selectDishErr=$allergicIngredentErr="";
								
								if(isset($_POST['submit']))
								{
									
									if($_POST['user_id'] == "select"){
										$error=$selectUserErr="Please select user";
									}elseif($_POST['category_name'] == "select"){
										$error=$selectCategoryErr="Please select category";
									}elseif($_POST['dish_name'] == "select"){
										$error=$selectDishErr="Please select dish";
									}elseif(empty($_POST['description'])){
										$error = $descriptionErr ="Please enter description";
									}elseif(empty($_POST['discount'])){
										$error = $discountErr ="Please enter discount";
									}elseif(empty($_POST['quantity'])){
										$error = $quantityErr ="Please enter quantity";
									}elseif(empty($_POST['total_amount'])){
										$error = $totalAmountErr ="Please enter price";
									}
									elseif(empty($error)){
									
										$allergicIngredent=implode(",",$_POST['allergic_ingredent']);
										if(!empty($_FILES['dish_image']['name']))
										{
											$fileSaveDirectory="../../trunk/images/dishes/";
											$target_dir = "images/dishes/";
											$target_file = $target_dir.$_FILES["dish_image"]["name"];
											$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
											
											if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png")
											{
												$_SESSION['error']= "File Format Not Suppoted";
												header('location:dishes_list.php');
												?> <script> window.location='dishes_list.php'; </script> <?php
												exit;
											} 			 
											
										}// dish img
										else
										{
											$target_file=$_POST['hid_tdimg'];
										}
										
							//			$savingCost = ($_POST['total_amount'] - ($_POST['total_amount'] * 100 / $_POST['discount']));
							//$savingCost = ($_POST['price']-(($_POST['price'] * $_POST['discount'])/100));
							
							$savingCost = ($_POST['total_amount'] - ($_POST['total_amount'] * $_POST['discount']) / 100 );
							$totalCost=$_POST['quantity']*$savingCost;
							
										$query1 = mysqli_query($conn,"select latitude,longitude,business_name from users where uid='".$_POST['user_id']."'");
										$row1=mysqli_fetch_assoc($query1);
										
										$query=mysqli_query($conn,"update dishes set dish_name='".$_POST['dish_name']."',business='".$row1['business_name']."',description='".addslashes($_POST['description'])."',category='".$_POST['category_name']."',discount='".$_POST['discount']."',quantity='".$_POST['quantity']."',allergic_ingredients='".$allergicIngredent."',commission='".$_POST['commission']."',price='".$_POST['total_amount']."',total_amount='".$totalCost."',saving_cost='".$savingCost."', dish_image='".$target_file."',comment='".addslashes($_POST['comment'])."',latitude='".$row1['latitude']."',longitude='".$row1['longitude']."' where id=$id");
										
										if($query==1)
										{
											$_SESSION['success']= "Record Updated Successfully";
											header('location:dishes_list.php?id='.$id);
											?> <script> window.location='dishes_list.php?id=<?php echo $id ?>'; </script> 
											<?php
											exit;
										}
										else{
											$_SESSION['error']="Error in updating dish ".mysqli_error($conn);
										}	
										
									}//error
											
								} //if
									
							?>
							
							<form action="" method="post" enctype="multipart/form-data" id="addUser">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-2">
										<label>Select User*</label>
                                        <select class="masked_input md-input" name="user_id">
											<option value="select">Select</option> 
											<?php $userEmail=mysqli_query($conn,"select uid,email from users where role=3");
												if(mysqli_num_rows($userEmail)){
													while($row=mysqli_fetch_assoc($userEmail)){
												  ?>
													<option value="<?=$row['uid'];?>"<?php if($result['uid']==$row['uid']){ echo "selected";} ?>><?=$row['email'];?></option>
													<?php }}?>
										</select>
										<span class="uk-text-danger"><?php echo $selectUserErr;?></span>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Category*</label>
                                        <select class="masked_input md-input" id="select-category" name = "category_name">
											<option value="select">Select</option> 						
											<?php $data=mysqli_query($conn,"select id,category_name from dishes_category group by category_name");
												if(mysqli_num_rows($data)>0){
													while($row=mysqli_fetch_assoc($data)){																													
												?>
													<option value="<?= $row['id'];?>" <?php if($result['category']==$row['id']){ echo "selected";} ?>><?= $row['category_name']?></option>
												<?php }} ?>
										</select>
										<span class="uk-text-danger"><?php echo $selectCategoryErr;?></span>
                                    </div>
                                    
									
									<div class="uk-width-medium-1-2">
                                        <label>Dish*</label>
                                        <select class="md-input masked_input" id="select-dishes" name = "dish_name">
											<option value="select">Select</option> 						
											<?php $data=mysqli_query($conn,"select id,dish_name from dishes group by dish_name");
											if(mysqli_num_rows($data)>0){
												while($row=mysqli_fetch_assoc($data)){																														
											?>
												<option value="<?= $row['dish_name'];?>" <?php if($result['dish_name']==$row['dish_name']){ echo "selected";} ?>><?= $row['dish_name']?></option>
											<?php }} ?>
										</select>
										<span class="uk-text-danger"><?php echo $selectDishErr;?></span>
                                    </div>
                                   	
									<div class="uk-width-medium-1-2">
                                        <label>Description*</label>
                                         <input class="md-input masked_input" id="description" name="description" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['description']; ?>" />
										<span class="uk-text-danger"><?php echo $descriptionErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Discount*</label>
                                         <input class="md-input masked_input" id="discount" name="discount" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['discount']; ?>" />
										<span class="uk-text-danger"><?php echo $discountErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Quantity*</label>
                                         <input class="md-input masked_input" id="quantity" name="quantity" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['quantity']; ?>" />
										<span class="uk-text-danger"><?php echo $quantityErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Pricet*</label>
                                         <input class="md-input masked_input" id="total_amount" name="total_amount" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['price']; ?>" />
										<span class="uk-text-danger"><?php echo $totalAmountErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Allergic Ingredent</label>
										<?php $alin = array($result['allergic_ingredients']); ?>
                                         <select class="md-input masked_input" name="allergic_ingredent[]" multiple>
											<option <?php if(in_array("Eggs", $alin)){ echo "selected='selected'"; } ?>>
											Eggs</option>
											<option <?php if(in_array("Fish", $alin)){ echo "selected='selected'"; } ?>>
											Fish</option>
											<option <?php if(in_array("Milk", $alin)){ echo "selected='selected'"; } ?>>
											Milk</option>
											<option <?php if(in_array("Peanut", $alin)){ echo "selected='selected'"; } ?>>
											Peanut</option>
											<option <?php if(in_array("Sesame", $alin)){ echo "selected='selected'"; } ?>>
											Sesame</option>
											<option <?php if(in_array("Soy", $alin)){ echo "selected='selected'"; } ?>>
											Soy</option>
											<option <?php if(in_array("Tree nuts", $alin)){ echo "selected='selected'"; } ?>>
											Tree nuts</option>
											<option <?php if(in_array("Wheat", $alin)){ echo "selected='selected'"; } ?>>
											Wheat</option>
										</select>
										<span class="uk-text-danger"><?php //echo $allergicIngredentErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
										<h3 class="heading_a uk-margin-bottom">Dish Image</h3>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="dish_image" type="file" name="dish_image">
											<input type="hidden" name="hid_tdimg" id="hid_tdimg" value="<?php echo $result['dish_image']; ?>" />
                                        </div>
										<?php if($result['dish_image']!=''){ ?>
										<span style="margin-left:20px;">
											<img class = "img-responsive img-circle" height="100px" width="100px"
											src="<?php echo baseURL().$result['dish_image'];?>">
										</span>
										<?php } ?>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Commission</label>
                                         <input class="md-input masked_input" id="commission" name="commission" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['commission']; ?>" />
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Comment</label>
                                         <input class="md-input masked_input" id="comment" name="comment" type="text" data-inputmask-showmaskonhover="false" value="<?php echo $result['comm']; ?>" />
										
                                    </div>
									
                                    
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="dishes_list.php">Cancel</a>
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
   
  