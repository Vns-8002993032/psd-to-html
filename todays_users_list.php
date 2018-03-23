<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Today's User List</b></h1>
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
							<th>User Name</th>
							<th>Email Id</th>
							<th>Date of birth</th>
							<th>Gender</th>
							<th>Phone Number</th>
							<th>Action</th>
                        </tr>
					</thead>
					<tbody>
					
						<?php 
						$today=date('Y-m-d',time());
                        	$query=mysqli_query($conn,"SELECT * from users where role=2 and 
date_format(FROM_UNIXTIME(created_on,'%Y-%m-%d'),'%Y-%m-%d')='".$today."'") or die(mysqli_error($conn));
							//date_default_timezone_set('UTC+8');
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
						?>	
									<tr>
										<td><?php echo $row['first_name']." ".$row['last_name'];?></td>
										<td><?php echo $row['email'];?></td>
										<td><?php //echo date("d-m-Y", $row['dob']);
										if($row['dob']) {
												$unix_timestamp = $row['dob'] / 1000;
												$datetime = new DateTime("@$unix_timestamp"); 
												echo $datetime->format('d-m-Y') ;
										}
										else {
											echo "Date is not entered";
											}
										?></td>
										<td><?php echo $row['gender'];?></td>
										<td><?php echo $row['mobile_no'];?></td>
										<td class="uk-text-center">
											<a href="user_view.php?id=<?php echo $row['uid']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
											<!--<a href="#"><i class="md-icon material-icons">&#xE872;</i></a>-->
										</td>
									</tr>
						<?php }
						}
						?>
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