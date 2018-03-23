<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<?php 
	if(isset($_GET['id'])){ $transaction_id=$_GET['id']; }
	$query=mysqli_query($conn,"select p.created_on as date,p.*,u.*,o.* from payment p join users u on p.pay_by=u.uid join orders o on p.order_id=o.order_id where transaction_id='".$transaction_id."'") or die(mysqli_error($conn));
	$result=mysqli_fetch_assoc($query);
	$vdata=mysqli_query($conn,"select business_name,address,mobile_no,business_email from users where uid='".$result['vendor_id']."'");
	$fetchedData=mysqli_fetch_assoc($vdata);
	$dishData=mysqli_query($conn,"select * from dishes where id ='".$result['dish_id']."'");
	$dishfetchedData=mysqli_fetch_assoc($dishData);
	if(isset($_POST['sendInvoice'])){
			$url= baseURL();
			$data['vname'] = $fetchedData['business_name'];
			$data['vadd'] = $fetchedData['address'];
			$data['vphone'] = $fetchedData['mobile_no'];
			
			$data['cname'] = $result['first_name'];
			$data['cadd'] = $result['address'];
			$data['cphone'] = $result['mobile_no'];
			
			
			$data['oid'] = $result['transaction_id'];
			$data['rdate'] = date("d/m/Y",floor($result['date']/1000));
			$data['amount'] = $result['amount'];
			$data['quantity'] = $result['no_of_items'];
			$data['uprice'] = $result['amount']/$result['no_of_items'];;
			$data['dishName'] = $dishfetchedData['dish_name'];
			$pdf = pdfGenerate($url,$data);			
			
			$subject = 'Order confirmation';
			
			$message = '<html lang="HE">
                <head>
                <title>
                    Invoice
                </title>
                </head>
                <body style="text-align:left;">
                Hi '.$result['first_name'].',
			<p style="text-align:justify">Thank you for choosing to save our environment by purchasing through Fooduction App!</p> 
			<p style="text-align:justify">Your order number <b>'.$transactionId.'</b> has been successfully processed. You can pick your order up anytime inside the trading hours of the business up to 24 hours from the time of purchase.</p>
				
				<p style="text-align:justify">We are truly changing the world, one meal at a time because of our loyal followers like you. We need as much support as we can get to combat this global issue.</p>
				<p style="text-align:justify">Please share it with your friends, it is OUR world to save!	We hope you enjoy your MEAL and the SAVINGS.</p>
				<p style="text-align:justify">Share story of your #rescuemeal at @fooductionapp to get in the draw to enjoy your next meal for free.</p>				
				<p style="text-align:justify">If you need any help about your order or how you can get involved, please email us at help@fooduction.com.au</p>				
				See how else we are changing the world: <br>
				http://fooduction.com.au <br>
				http://fooduction.com <br>
				http://facebook.com/fooduction <br>
				http://instagram.com/fooductionapp <br>
				http://twitter.com/fooductionapp <br>

				<p style="text-align:justify">Much Love.</p>

				<p style="text-align:justify"><b>Fooduction<br>
				Order Food, Save Money, Save Environment
				</p>
			</body>
			</html>';
			
			send_email('/var/www/viral-shahmobileapp-16102804-web/admin/viralAdmin/document.pdf', $result['email'], $fetchedData['business_email'], $subject, $message);}
	
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
										<label>Mobile No:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['mobile_no'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Invoice Date:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo date("Y-m-d",ceil($result['date']/1000)); ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Time:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo date("h:i:s",ceil($result['date']/1000)); ?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Address:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['address'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>No of Item:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['no_of_items'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Amount:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php echo $result['amount'];?></label>
                                    </div>
									<div class="uk-width-3-10">
										<label>Order status:</label>
                                    </div>
                                   	<div class="uk-width-7-10">
                                        <label><?php if($result['delivery_status']==0){ echo "Pending";}elseif($result['delivery_status']==1){ echo "Completed";}elseif($result['delivery_status']==2) echo "Cancelled";?></label>
                                    </div>
									
									
                                    <div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="busi_order_edit.php?id=<?php echo $result['order_id'];?>">Edit</a>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<form method="post" action="">
											<button type="submit" name="sendInvoice" class="md-btn md-btn-primary">sendInvoice</button>
										</form>
                        			</div>
									<div class="uk-width-medium-2-10">
                            			<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="business_orders.php">Cancel</a>
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
   
  