<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-10-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Add Dish</h1>
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
									}elseif(($_POST['category_name'] == "other") && empty($_POST['new_category'])){
										$error = $cnameErr ="Please enter category name";
									}elseif($_POST['dish_name'] == "select"){
										$error=$selectDishErr="Please select dish";
									}elseif(($_POST['dish_name'] == "other") && empty($_POST['new_dish'])){
										$error = $dnameErr ="Please enter dish name";
									}elseif(empty($_POST['description'])){
										$error = $descriptionErr ="Please enter description";
									}elseif(empty($_POST['discount'])){
										$error = $discountErr ="Please enter discount";
									}elseif(empty($_POST['quantity'])){
										$error = $quantityErr ="Please enter quantity";
									}elseif(empty($_POST['total_amount'])){
										$error = $totalAmountErr ="Please enter price";
									}elseif(empty($error)){
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
											else
											{	
												if (move_uploaded_file($_FILES["dish_image"]["tmp_name"],$fileSaveDirectory."/".basename($_FILES['dish_image']['name']))) {
												} else {
													echo "Sorry, there was an error uploading your file.";
												}
											}
											
										}// dish img
										
										//$savingCost = ($_POST['total_amount'] - ($_POST['total_amount'] * 100 / $_POST['discount']));
										$savingCost = ($_POST['total_amount'] - ($_POST['total_amount'] * $_POST['discount'] / 100 ));
										$totalCost=$_POST['quantity']*$savingCost;
										
										if ($_POST['category_name'] == "other")
										{
											$categoryData = mysqli_query($conn, "insert into dishes_category(category_name,created_on) values('" . $_POST['new_category'] . "','" . date('Y-m-d h:i:s') . "')");
											$categoryId = mysqli_insert_id($conn);
											
											if ($_POST['dish_name'] == "other")
											{
												$query1 = mysqli_query($conn,"select latitude,longitude,business_name from users where uid='".$_POST['user_id']."'");
												$row1=mysqli_fetch_assoc($query1);
												
												$query = mysqli_query($conn, "INSERT INTO `dishes`(`dish_name`, `description`, `business`, `category`, `dish_image`, `price`, `discount`, `quantity`, `total_amount`, `saving_cost`, `commission`, `allergic_ingredients`,`posted_by`, `comment`, `latitude`, `longitude`, `updated_on`, `created_on`) VALUES ('" . $_POST['new_dish'] . "', '" .addslashes($_POST['description']). "', '".$row1['business_name']."', '" . $categoryId . "', '" . $target_file . "', '" . $_POST['total_amount'] . "', '" . $_POST['discount'] . "', '" . $_POST['quantity'] . "', '" .$totalCost. "', '" . $savingCost . "', '" . $_POST['commission'] . "', '" . $allergicIngredent . "', '" . $_POST['user_id'] . "' , '" . addslashes($_POST['comment']) . "', '".$row1['latitude']."', '".$row1['longitude']."', '" . time() . "', '" . time() . "')");
											}// dish other
											else
											{
												$query1 = mysqli_query($conn,"select latitude,longitude,business_name from users where uid='".$_POST['user_id']."'");
												$row1=mysqli_fetch_assoc($query1);
												$query = mysqli_query($conn, "INSERT INTO `dishes`(`dish_name`, `description`, `business`, `category`, `dish_image`, `price`, `discount`, `quantity`, `total_amount`, `saving_cost`, `commission`, `allergic_ingredients`,`posted_by`, `comment`, `latitude`, `longitude`, `updated_on`, `created_on`) VALUES ('" . $_POST['dish_name'] . "', '" .addslashes($_POST['description']). "', '".$row1['business_name']."', '" . $categoryId . "', '" . $target_file . "', '" . $_POST['total_amount'] . "', '" . $_POST['discount'] . "', '" . $_POST['quantity'] . "', '" .$totalCost. "', '" . $savingCost . "', '" . $_POST['commission'] . "', '" . $allergicIngredent . "', '" . $_POST['user_id'] . "' , '" . addslashes($_POST['comment']) . "' , '".$row1['latitude']."', '".$row1['longitude']."', '" . time() . "', '" . time() . "')");
											}//dish
										
										}// cat other
										else
										{
											if ($_POST['dish_name'] == "other")
											{
												$query1 = mysqli_query($conn,"select latitude,longitude,business_name from users where uid='".$_POST['user_id']."'");
												$row1=mysqli_fetch_assoc($query1);
												$query = mysqli_query($conn, "INSERT INTO `dishes`(`dish_name`, `description`, `business`, `category`, `dish_image`, `price`, `discount`, `quantity`, `total_amount`, `saving_cost`, `commission`, `allergic_ingredients`,`posted_by`, `comment`, `latitude`, `longitude`, `updated_on`, `created_on`) VALUES ('" . $_POST['new_dish'] . "', '" .addslashes($_POST['description']). "', '".$row1['business_name']."', '" . $_POST['category_name'] . "', '" . $target_file . "', '" . $_POST['total_amount'] . "', '" . $_POST['discount'] . "', '" . $_POST['quantity'] . "', '" .$totalCost. "', '" . $savingCost . "', '" . $_POST['commission'] . "', '" . $allergicIngredent . "', '" . $_POST['user_id'] . "', '" . addslashes($_POST['comment']) . "' , '".$row1['latitude']."', '".$row1['longitude']."', '" . time() . "', '" . time() . "')");			
											}
											else
											{
												$query1 = mysqli_query($conn,"select latitude,longitude,business_name from users where uid='".$_POST['user_id']."'");
												$row1=mysqli_fetch_assoc($query1);
												$query = mysqli_query($conn, "INSERT INTO `dishes`(`dish_name`, `description`, `business`, `category`, `dish_image`, `price`, `discount`, `quantity`, `total_amount`, `saving_cost`, `commission`, `allergic_ingredients`,`posted_by`, `comment`, `latitude`, `longitude`, `updated_on`, `created_on`) VALUES ('" . $_POST['dish_name'] . "', '" .addslashes($_POST['description']). "', '".$row1['business_name']."','" . $_POST['category_name'] . "', '" . $target_file . "', '" . $_POST['total_amount'] . "', '" . $_POST['discount'] . "', '" . $_POST['quantity'] . "', '" .$totalCost. "', '" . $savingCost . "', '" . $_POST['commission'] . "', '" . $allergicIngredent . "', '" . $_POST['user_id'] . "', '" . addslashes($_POST['comment']) . "', '".$row1['latitude']."','".$row1['longitude']."', '" . time() . "', '" . time() . "')");
											}
										}//else
										
										if($query==1)
										{
											$_SESSION['success']="Dish has been successfully created";
											header('location:dishes_list.php');
											?> <script> window.location='dishes_list.php'; </script> <?php
											exit;
										}
										else{
											$_SESSION['error']="Error in creating dish ".mysqli_error($conn);
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
													<option value="<?=$row['uid'];?>"<?php if(isset($_POST['user_id'])){if($_POST['user_id']==$row['uid']){ echo "selected";} }?>><?=$row['email'];?></option>
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
													<option value="<?= $row['id'];?>" <?php if(isset($_POST['category_name'])){if($_POST['category_name']==$row['id']){ echo "selected";} }?>><?= $row['category_name']?></option>
												<?php }} ?>
													<option value="other" <?php if(isset($_POST['category_name'])){if($_POST['category_name']=="other"){ echo "selected";} }?>>Other</option> 
										</select>
										<span class="uk-text-danger"><?php echo $selectCategoryErr;?></span>
                                    </div>
                                    
                                   <div class="uk-width-medium-1-2" id="category12">
                                        <label>Category Name*</label>
                                         <input class="md-input masked_input" id="new_category" name="new_category" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['new_category'])){echo $_POST['new_category'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $cnameErr;?></span>
                                    </div>
									
									<div class="uk-width-medium-1-2">
                                        <label>Dish*</label>
                                        <select class="md-input masked_input" id="select-dishes" name = "dish_name">
											<option value="select">Select</option> 						
											<?php $data=mysqli_query($conn,"select id,dish_name from dishes group by dish_name");
											if(mysqli_num_rows($data)>0){
												while($row=mysqli_fetch_assoc($data)){																														
											?>
												<option value="<?= $row['dish_name'];?>" <?php if(isset($_POST['dish_name'])){if($_POST['dish_name']==$row['dish_name']){ echo "selected";} }?>><?= $row['dish_name']?></option>
											<?php }} ?>
												<option value="other" <?php if(isset($_POST['dish_name'])){if($_POST['dish_name']=="other"){ echo "selected";} }?>>Other</option>
										</select>
										<span class="uk-text-danger"><?php echo $selectDishErr;?></span>
                                    </div>
                                   	<div class="uk-width-medium-1-2">
                                        <label>Dish name*</label>
                                         <input class="md-input masked_input" id="new_dish" name="new_dish" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['new_dish'])){echo $_POST['new_dish'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $dnameErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Description*</label>
                                         <input class="md-input masked_input" id="description" name="description" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['description'])){echo $_POST['description'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $descriptionErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Discount*</label>
                                         <input class="md-input masked_input" id="discount" name="discount" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['discount'])){echo $_POST['discount'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $discountErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Quantity*</label>
                                         <input class="md-input masked_input" id="quantity" name="quantity" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['quantity'])){echo $_POST['quantity'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $quantityErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Price*</label>
                                         <input class="md-input masked_input" id="total_amount" name="total_amount" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['price'])){echo $_POST['price'];}else{echo "";}?>" />
										<span class="uk-text-danger"><?php echo $totalAmountErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Allergic Ingredent</label>
                                         <select class="md-input masked_input" name="allergic_ingredent[]" multiple>
											<option>Eggs</option>
											<option>Fish</option>
											<option>Milk</option>
											<option>Peanut</option>
											<option>Sesame</option>
											<option>Soy</option>
											<option>Tree nuts</option>
											<option>Wheat</option>
										</select>
										<span class="uk-text-danger"><?php //echo $allergicIngredentErr;?></span>
                                    </div>
									<div class="uk-width-medium-1-2">
										<h3 class="heading_a uk-margin-bottom">Dish Image</h3>
										<div class="uk-form-file md-btn md-btn-primary">Select
											<input id="dish_image" type="file" name="dish_image">
                                        </div>
                                    </div>
									<div class="uk-width-medium-1-2">
                                        <label>Commission</label>
                                         <input class="md-input masked_input" id="commission" name="commission" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['commission'])){echo $_POST['commission'];}else{echo "";}?>" />
                                    </div>
									<div class="uk-width-medium-1-1">
                                        <label>Comment</label>
                                         <input class="md-input masked_input" id="comment" name="comment" type="text" data-inputmask-showmaskonhover="false" value="<?php if(isset($_POST['comment'])){echo $_POST['comment'];}else{echo "";}?>" />
										
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
	<script>
		$(document).ready(function(){
			if($('#select-category').val()=="other"){
					$('#category12').show();
					
				}else{
					$('#category12').hide();
				}
			$('#select-category').change(function(){
				if($(this).val()=="other"){
					$('#category12').show();
					
				}else{
					$('#category12').hide();
				}
			});
		});
		$(document).ready(function(){
			if($('#select-dishes').val()=="other"){
					$('#dish12').show();
					
				}else{
					$('#dish12').hide();
				}
			$('#select-dishes').change(function(){
				if($(this).val()=="other"){
					$('#dish12').show();
					
				}else{
					$('#dish12').hide();
				}
			});
		});
	</script>
</body>
</html>
   
  