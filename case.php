<?php 
include('function.php');
$action=$_GET['action'];
$id=$_REQUEST['id'];
switch($action){
//Block/UnBlock Users and Vendors	
case 'block':
	block($id,$_REQUEST['status'],$_REQUEST['role']);
	break;
//Delete users and vendor
case 'delete':
	delete($id,$_REQUEST['role']);
	break;
//Approve Dish
case 'approve':
	approveDish($id,$_REQUEST['status']);
	break;
//Reject Dish
case 'rejectDish':
	rejectDish($id);
	break;
case 'deletehelp':
	delete_help($id,$_REQUEST['role']);
	break;
}
?>
