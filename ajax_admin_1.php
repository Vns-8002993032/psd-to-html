<?php include("connection.php");


if($_POST['type']=="Order")
{
  	$orid=explode(",",$_POST['oid']);
		
	for($i=0;$i<sizeof($orid);$i++)
	{
		$query=mysqli_query($conn,"update orders set delivery_status='".$_POST['order']."' where order_id='".$orid[$i]."'") or die(mysqli_error($conn));
	}
	if($query)
	{
		echo "upd";
		exit;
	}
	else
	{
		echo "not";
		exit;
	}
	
}
?>