<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Coupons List</b></h1>
				
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
							<th>Coupon Code</th>
						    <th>Coupon Percentage </th>
						    <th>From Date</th>
						    <th>To Date</th>
						    <th>Action</th>
                        </tr>
					</thead>
					<tbody>
					
						<?php 
							$query=mysqli_query($conn,"select * from coupon order by id desc") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$frm=date('d-m-Y',strtotime($row['fromdate']));
									$to=date('d-m-Y',strtotime($row['todate']));
						?>	
									<tr>
										<td><?php echo $row['coupon_code'];?></td>
										<td><?php echo $row['coupon_per'].' %';?></td>
										<td><?php echo $frm;?></td>
										<td><?php echo $to;?></td>
										<td class="uk-text-center">
											<a href="coupon_edit.php?id=<?= $row['id']?>">
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