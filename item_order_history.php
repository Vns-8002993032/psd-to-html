<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); 
$dish_id=$_GET['id'];
?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Item History</b></h1>
				<?php if(!empty($_SESSION['success'])) { ?>
					<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
				<?php $_SESSION['success']="";} ?>
				 
				<?php if(!empty($_SESSION['error'])) { ?>
					<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
				<?php $_SESSION['error']="";} ?>
				
				<div class="dt_colVis_buttons"></div>
				<table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
					<thead>
                        <tr>
							<th>Name</th>
							<th>Order ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
							<th>Amount</th>
							<th>Date & Time</th>
                            <th>Transaction ID</th>
                        </tr>
					</thead>
					<tbody>
						<?php 
							$query=mysqli_query($conn,"select * from orders where dish_id='".$dish_id."'") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$query1=mysqli_query($conn,"select * from users where uid='".$row['order_by']."'") or die(mysqli_error($conn));
									$row1=mysqli_fetch_assoc($query1);
									
									$query2=mysqli_query($conn,"select * from dishes where id='".$dish_id."'") or die(mysqli_error($conn));
									$row2=mysqli_fetch_assoc($query2);
									
									$query3=mysqli_query($conn,"select * from cartorders where orders LIKE '%".$row['order_id']."%'") or die(mysqli_error($conn));
									$row3=mysqli_fetch_assoc($query3);
									
									echo "select * from cartorders where orders LIKE '%".$row['order_id']."%'";
									
											?>
												<tr>
                                                    <td><?php echo $row1['first_name']." ".$row1['last_name']; ?></td>
                                                    <td><?php echo $row3['pkuniquecartid'];?></td>
                                                    <td><?php echo $row2['dish_name'];?></td>
                                                    <td><?php echo $row['no_of_items'];?></td>
                                            
													<?php
                                                        $dish_amt=$row['dish_amount'];
                                                        $dish_dis=$row['dish_discount'];
                                                        $price_with_dis=$dish_amt - ($dish_amt * ($dish_dis / 100));
                                                    ?>
                                            
                                                    <td><?php echo $price_with_dis;?></td>
                                                    <td><?php echo date("d-m-Y h:i:s",ceil($row['created_on']/1000));?></td>
                                                    <td><?php echo $row3['transaction_id'];?></td>
												</tr>
                                   			<?php
											//}
										//}
								}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>     
    <?php include('footer.php'); ?>
	
     <!-- datatables -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!-- datatables buttons-->
    <script src="bower_components/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="assets/js/custom/datatables/buttons.uikit.js"></script>
    <script src="bower_components/jszip/dist/jszip.min.js"></script>
    <script src="bower_components/pdfmake/build/pdfmake.min.js"></script>
    <script src="bower_components/pdfmake/build/vfs_fonts.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.html5.js"></script>
    <script src="bower_components/datatables-buttons/js/buttons.print.js"></script>
    <!-- datatables custom integration -->
    <script src="assets/js/custom/datatables/datatables.uikit.min.js"></script>
    <!--  datatables functions -->
    <script src="assets/js/pages/plugins_datatables.min.js"></script>
    </body>
    </html>
   