<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
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
							<th>Dish Name</th>
							<th>Business Name</th>
							<th>Total Order</th>
							<th>Quantity</th>
                        </tr>
					</thead>
					<tbody>
						<?php 
							$query=mysqli_query($conn,"select * from dishes") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$query1=mysqli_query($conn,"select count(no_of_items), SUM(no_of_items), dish_id from orders where dish_id='".$row['id']."'") or die(mysqli_error($conn));
									$row1=mysqli_fetch_assoc($query1);
						?>	
									<tr>
                                   	 	<td><a href="item_order_history.php?id=<?php echo $row1['dish_id'];?>"><?php echo $row['dish_name'];?></a></td>
                                        <td><a href="item_order_history.php?id=<?php echo $row1['dish_id'];?>"><?php echo $row['business'];?></a></td>
										<td><a href="item_order_history.php?id=<?php echo $row1['dish_id'];?>"> <?php echo $row1['count(no_of_items)']; ?></a></td>
										<td><a href="item_order_history.php?id=<?php echo $row1['dish_id'];?>"><?php echo $row1['SUM(no_of_items)'];?></a></td>
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
   