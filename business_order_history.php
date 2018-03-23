<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
            <?php
			
			$userdetail=mysqli_query($conn,"select * from users where uid ='".$_GET['id']."'");
			$udetail=mysqli_fetch_assoc($userdetail);
			
			$userorder=mysqli_query($conn,"select * from orders where vendor_id ='".$_GET['id']."'");
			$uorder=mysqli_fetch_assoc($userorder);
			
			$userorderdish=mysqli_query($conn,"select * from dishes where id ='".$uorder['dish_id']."'");
			$udish=mysqli_fetch_assoc($userorderdish);
			
			?>
				<h1 class="uk-text-center"><b><?php echo $udetail['first_name']." ".$udetail['last_name']; ?></b></h1>
				
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
							<th> Name </th>
							<th> Transaction Id </th>
							<th> Mobile No. </th>
							<th> Order Placed On </th>
                            <th> Order status </th>
							<th> Action </th>
                        </tr>
					</thead>
					<tbody>
						<?php
							$query=mysqli_query($conn,"select c.pkuniquecartid, c.uid,c.transaction_id,c.orders,c.created_on, o.order_id, o.order_by, o.vendor_id, o.delivery_status from cartorders c LEFT JOIN orders o on FIND_IN_SET(o.order_id,c.orders) and o.order_by=c.uid where o.vendor_id='".$_GET['id']."' group by c.orders");
							
							date_default_timezone_set('UTC');
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{ ?>
									<tr>
										<td><?php echo $udetail['first_name']." ".$udetail['last_name'];?></td>
										<td><?php echo $row['transaction_id'];?></td>
										<td><?php echo $udetail['mobile_no'];?></td>
                                       	<td><?php echo date("d-m-Y", $row['created_on']/1000);?></td>
                                        <td><?php if($row['delivery_status']==0){ echo "Pending";}elseif($row['delivery_status']==1){ echo "Completed";}elseif($row['delivery_status']==2) echo "Cancelled"; ?></td>
										<td class="uk-text-center">
											<a href="business_order_hview.php?id=<?php echo $row['pkuniquecartid']?>&uid=<?php echo $_GET['id']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
										</td>
									</tr>
							<?php }
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