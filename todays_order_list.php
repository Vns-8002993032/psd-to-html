<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Today's Order List</b></h1>
				
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
							<th>Transaction Id</th>
							<th>Mobile No.</th>
							<th>Order status.</th>
							<th>Action</th>
                        </tr>
					</thead>
					<tbody>
						<?php
						$today=date('Y-m-d',time());
							$query=mysqli_query($conn,"SELECT cartorders.transaction_id, cartorders.orders, cartorders.pkuniquecartid, cartorders.created_on, users.first_name, users.last_name, users.mobile_no FROM cartorders LEFT JOIN users ON cartorders.uid=users.uid where users.role=2 and date_format(FROM_UNIXTIME((SubStr(cartorders.created_on, 1, LENGTH(cartorders.created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='".$today."' ORDER BY cartorders.pkuniquecartid DESC") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$order=$row['orders'];
									$query1=mysqli_query($conn,"select * from orders where order_id in ($order)") or die(mysqli_error($conn));
									$row1=mysqli_fetch_assoc($query1);
									$query2=mysqli_query($conn,"select * from cartorders where pkuniquecartid='".$row['pkuniquecartid']."'") or die(mysqli_error($conn));
									$row2=mysqli_fetch_assoc($query2);
									$a=$row2['orders'];
						?>	
									<tr>
										<td><?php echo $row['first_name']." ".$row['last_name'];?></td>
										<td><?php echo $row['transaction_id'];?></td>
										<td><?php echo $row['mobile_no'];?></td>
                                        
										<td><select name="order_status" id="order_status<?php echo $row1['order_id'];?>" 
                                        onchange="order<?php echo $row1['order_id']; ?>(this.value)" class="masked_input md-input">
                                                <option value="0" <?php if($row1['delivery_status']=='0'){ echo "selected"; } ?>>
													Pending</option>
												<option value="1" <?php if($row1['delivery_status']=='1'){ echo "selected"; } ?>>
													Completed</option> 
                                                    <option value="2" <?php if($row1['delivery_status']=='2'){ echo "selected"; } ?>>
													Cancelled</option> 
                                            </select>
                                            <script>
												function order<?php echo $row1['order_id'];?>(val)
												{
													
													var order = val;
													var oid = '<?php echo $a; ?>';
													$.ajax({
														type: "POST",
														url: "ajax_admin_1.php",
														data: {oid:oid, order:order,type:'Order'},
														cache: true,
														success: function(html)
														{
															//alert(html);
															if(html.trim()=="upd")
															{	
																alert("Status changed successfully..."); }
															else
															{	
																alert("Status not changed...Try again..."); }
														}
													});
													return false;
												}
											</script>
                                            </td>
										<td class="uk-text-center">
											<a href="user_order_view.php?id=<?php echo $row['pkuniquecartid']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
										</td>
									</tr>
						<?php }
						 ?>
                        <?php  } ?>
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