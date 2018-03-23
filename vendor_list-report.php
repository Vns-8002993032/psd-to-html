<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Vendor Report List</b></h1>
				
				<?php if(!empty($_SESSION['success'])) { ?>
					<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
				<?php $_SESSION['success']="";} ?>
				 
				<?php if(!empty($_SESSION['error'])) { ?>
					<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
				<?php $_SESSION['error']="";} ?>
				<!--Date-->
                <br />
                <br />
                <form action="" method="post" enctype="multipart/form-data" id="fromtodate" name="fromtodate">
                <div class="uk-grid">  
                	<div class="uk-width-medium-1-3">
                        <label>From Date</label>
                        <input class="md-input masked_input" type="text" name="fromdate" id="fromdate" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="" autocomplete='off'>
                	</div>
                    <div class="uk-width-medium-1-3">
                        <label>To Date</label>      
                        <input class="md-input masked_input" type="text" name="todate" id="todate" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="" autocomplete='off'>
                	</div>
                    <br />
                    <div class="uk-width-medium-1-6">
						<button type="submit" name="gorecord" id="gorecord" class="md-btn md-btn-primary">Go</button>
                    </div>
                    </div>
                </form>

                <!--Date-->
                <br />
				<div class="dt_colVis_buttons"></div>
				
				<table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
					<thead>
                        <tr>
							<th>User Name</th>
							<th>Business Name</th>
                            <th>Date</th>
							<th>Email Id</th>
							<th>Business <br />Phone No.</th>
							<th>Australian <br />Business No.</th>
							<th>Last Dish <br />added on</th>
							<!--<th>Action</th> -->
                        </tr>
					</thead>
					<tbody>
					
						<?php 
                                                $cityId = $_SESSION['city_id'];
					//	date_default_timezone_set('UTC+8');
						if(isset($_POST['gorecord']))
						{
							
							$fromdate=$_POST['fromdate'];
							$todate=$_POST['todate'];
							$from=strtotime($fromdate);
							$to=strtotime($todate);
							$query=mysqli_query($conn,"select * from users where role=3 and city_id=$cityId order by uid desc") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$created_on=$row['created_on'];
									if($created_on>=$from && $created_on<=$to)
									{
									$lastdish=trim($row['last_dish_added_on']);
									if(isset($lastdish)){ 
										$date=date("d-m-Y", intval($row['last_dish_added_on']));
									}
								?>	
									<tr>
										<td><?php echo $row['first_name'];?></td>
										<td><?php echo $row['business_name'];?></td>
                                        <?php
                                        $unix_timestamp = $row['created_on'];  
										$datetime = new DateTime("@$unix_timestamp"); 
										?>
                                        <td><?php echo $datetime->format('d-m-Y'); ?></td>
										<td><?php echo $row['email'];?></td>
										<td><?php echo $row['business_phone_no'];?></td>
										<td><?php echo $row['aus_business_no'];?></td>
										<td><?php if($lastdish!=''){ echo $date; } ?></td>
										<!--<td class="uk-text-center">
											<a href="vendor_view.php?id=<?php echo $row['uid']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
											
										</td> -->
									</tr>
						<?php }}
						} 
						}
						else
						{
                        	$query=mysqli_query($conn,"select * from users where role=3 and city_id=$cityId order by uid desc") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$lastdish=trim($row['last_dish_added_on']);
									if(isset($lastdish)){ 
										$date=date("d-m-Y", intval($row['last_dish_added_on']));
									}
								?>	
									<tr>
										<td><?php echo $row['first_name'];?></td>
										<td><?php echo $row['business_name'];?></td>
                                        <?php
                                        $unix_timestamp = $row['created_on'];  
										$datetime = new DateTime("@$unix_timestamp"); 
										?>
                                        <td><?php echo $datetime->format('d-m-Y'); ?></td>
										<td><?php echo $row['email'];?></td>
										<td><?php echo $row['business_phone_no'];?></td>
										<td><?php echo $row['aus_business_no'];?></td>
										<td><?php if($lastdish!=''){ echo $date; } ?></td>
										<!--<td class="uk-text-center">
											<a href="vendor_view.php?id=<?php echo $row['uid']?>">
											<i class="md-icon material-icons">&#xE8F4;</i></a>
											
										</td> -->
									</tr>
						<?php }
						} 
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