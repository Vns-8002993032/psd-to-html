<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Dishes List</b></h1>
				
				<?php if(!empty($_SESSION['success'])) { ?>
					<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
				<?php $_SESSION['success']="";} ?>
				 
				<?php if(!empty($_SESSION['error'])) { ?>
					<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
				<?php $_SESSION['error']="";} ?>
				
	<!--			<div class="dt_colVis_buttons"></div> -->
				
				<table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
				
					<thead>
                        <tr>
                       <!-- <th>ID</th> -->
                        		<th>Business Name</th>
							  <th>Owner Name</th>
							  <th>Category</th>
							  <th>Name of dish</th>
                              <th>Quantity</th>
							  <th>Commission</th>
							  <th>Status</th>
							  <th>Action</th>
                        </tr>
					</thead>
					<tbody>
					
						<?php 
							$query=mysqli_query($conn,"select d.id as dish_id,d.dish_name,d.quantity,d.commission,d.status as dishStatus,d.description,dc.category_name,u.first_name,u.last_name,u.business_name from dishes d join dishes_category dc on d.category=dc.id join users u on u.uid=d.posted_by order by d.id desc") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
						?>	
									<tr>
                                  <!--  <td><?php //echo $row['dish_id'];?></td> -->
                                    	<td><?php echo $row['business_name'];?></td>
										<td><?php echo $row['first_name'];?></td>
										<td><?php echo $row['category_name'];?></td>
										<td><?php echo $row['dish_name'];?></td>
                                        <td><?php echo $row['quantity'];?></td>
										<td><?php echo $row['commission'];?></td>
										<td><?php if($row['dishStatus']==1){echo "Approved";}elseif($row['dishStatus']==0){echo "Pending";}elseif ($row['dishStatus']==2){echo "Rejected";}?></td>
										<td class="uk-text-center">
											<a href="dish_view.php?id=<?php echo $row['dish_id']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
											<!--<a href="#"><i class="md-icon material-icons">&#xE872;</i></a>-->
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