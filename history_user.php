<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="md-card uk-margin-medium-bottom">
			<div class="md-card-content">
				<h1 class="uk-text-center"><b>Order History</b></h1>
				
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
							<th>Total Order</th>
							<th>Email</th>
							<th>Mobile No.</th>
                            <th>You Saved</th>
                        </tr>
					</thead>
					<tbody>
						<?php 
							$query=mysqli_query($conn,"select count(pkuniquecartid), uid from cartorders group by uid") or die(mysqli_error($conn));
							if(mysqli_num_rows($query)>0)
							{
								while($row=mysqli_fetch_assoc($query))
								{
									$total_you_saved=0;
									$userdetail=mysqli_query($conn,"select * from users where uid='".$row['uid']."'");
									$udetail=mysqli_fetch_assoc($userdetail);
									
									$query1=mysqli_query($conn,"select * from cartorders where uid='".$row['uid']."'");
									while($row1=mysqli_fetch_assoc($query1))
									{
										$orid=explode(",",$row1['orders']);
										for($a=0;$a<sizeof($orid);$a++)
										{
											$query2=mysqli_query($conn,"select * from orders where order_id='".$orid[$a]."'");
											$row2=mysqli_fetch_assoc($query2);
											$dish_amt=$row2['dish_amount'];
											$dish_dis=$row2['dish_discount'];
											$price_with_dis=$dish_amt - ($dish_amt * ($dish_dis / 100));
											$you_saved=$dish_amt-$price_with_dis;
											$total_you_saved=$total_you_saved+$you_saved;
										}
									}
						?>	
									<tr>
										<td> <a href="user_order_history.php?id=<?php echo $udetail['uid'];?>"> <?php echo $udetail['first_name']." ".$udetail['last_name']; ?></a></td>
										<td><a href="user_order_history.php?id=<?php echo $udetail['uid'];?>"><?php echo $row['count(pkuniquecartid)'];?></a></td>
										<td><a href="user_order_history.php?id=<?php echo $udetail['uid'];?>"><?php echo $udetail['email'];?></a></td>
										<td><a href="user_order_history.php?id=<?php echo $udetail['uid'];?>"><?php echo $udetail['mobile_no'];?></a></td>
										<td><a href="user_order_history.php?id=<?php echo $udetail['uid'];?>"><?php echo $total_you_saved; ?></a></td>
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
   