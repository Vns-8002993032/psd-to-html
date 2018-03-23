<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Today's Total Sales</b></h1>
				
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
							<th>Order By</th>
							<th>Vendor Name</th>
							<th>Dish Name</th>
							<th>Order status</th>
                        </tr>
					</thead>
					<tbody>
						<?php
						$today=date('Y-m-d',time());
							$query=mysqli_query($conn,"SELECT * FROM orders where date_format(FROM_UNIXTIME((SubStr(created_on, 1, LENGTH(created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='".$today."'") or die(mysqli_error($conn));
							
							//echo "SELECT * FROM orders where date_format(FROM_UNIXTIME((SubStr(created_on, 1, LENGTH(created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='".$today."'";
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$query1=mysqli_query($conn,"SELECT * FROM users where uid='".$row['order_by']."'") or die(mysqli_error($conn));
									$row1=mysqli_fetch_assoc($query1);
									$query2=mysqli_query($conn,"SELECT * FROM users where uid='".$row['vendor_id']."'") or die(mysqli_error($conn));
									$row2=mysqli_fetch_assoc($query2);
									$query3=mysqli_query($conn,"SELECT * FROM dishes where id='".$row['dish_id']."'") or die(mysqli_error($conn));
									$row3=mysqli_fetch_assoc($query3);
						?>	
									<tr>
										<td><?php echo $row1['first_name']." ".$row1['last_name'];?></td>
										<td><?php echo $row2['first_name']." ".$row2['last_name'];?></td>
										<td><?php echo $row3['dish_name'];?></td>
										<td><?php if($row['delivery_status']==0){ echo "Pending";} else { echo "Completed"; }?></td>
										
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