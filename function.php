<?php
ob_start();
ob_clean();
error_reporting(0);
include('connection.php');


function baseURL(){
		$url = "http://" .$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$slashPos = (strrpos($url,'/'));
		$basePath = substr($url,0,$slashPos + 1);
		$basePath = str_replace('admin/viralAdmin', 'trunk', $basePath);		
		return $basePath;
	}
//Block/UnBlock Users and Vendors		
function block($id,$status,$role){
	global $conn;
	if($status==1){
		$status=0;
		}
	else{
		$status=1;
		}	
$query=mysqli_query($conn,"update users set status=$status where uid=$id");
if($query==1){
	if($role=='user'){
	header('location:user_view.php?id='.$id);
}elseif($role=='vendor'){
	header('location:vendor_view.php?id='.$id);
}
	$_SESSION['success']= "Record Updated Successfully";
	}
else{
	mysqli_error($conn);
	}	
}

//Delete users and vendor

function delete($id,$role){
	global $conn;
	$query=mysqli_query($conn,"delete from users where uid=$id");
	if($query==1){
		if($role=='user')
		{
			$_SESSION['success']= "User deleted successfully";
			header('location:users_list.php');
		}
		elseif($role=='vendor')
		{
			$_SESSION['success']= "Vendor deleted successfully";
			header('location:vendor_list.php');
		}
		
	}
	else{
		mysqli_error($conn);
		if($role=='user')
		{
			$_SESSION['error']= "Something wrong... Try again.";
			header('location:users_list.php');
		}
		elseif($role=='vendor')
		{
			$_SESSION['error']= "Vendor not deleted successfully..";
			header('location:vendor_list.php');
		}
	}	
}
function delete_help($id,$role)
{
	global $conn;
	$query=mysqli_query($conn,"delete from help where id=$id");
	if($query==1)
	{
		$_SESSION['success']= "Help Request deleted successfully";
		header('location:help_list.php');
	}
	else
	{
		$_SESSION['error']= "Help Request not deleted successfully..";
		header('location:help_list.php');
	}	
}

//Genrating random password
function pass_rend(){
		$pass="qwertyuiopasdfghjklzxcvbnm789456123@$&";
		$new_pass=substr( str_shuffle( $pass ), 0, 8 );
		return $new_pass;
		}		

//Approve Dish
function approveDish($id,$status){
	global $conn;
	if($status==1){
		$status=0;
		}
	else{
		$status=1;
		}	
$query=mysqli_query($conn,"update dishes set status=$status where id=$id");
if($query==1){

	header('location:dish_view.php?id='.$id);
	$_SESSION['success']= "Record Updated Successfully";
	}
else{
	mysqli_error($conn);
	}	
}	

//Reject Dish
function rejectDish($id){
	global $conn;
	$query=mysqli_query($conn,"update dishes set status=2 where id=$id");
if($query==1){
	header('location:dishes_list.php');
	$_SESSION['success']= "Record Updated Successfully";
	}
else{
	mysqli_error($conn);
	}	
	}
	
function validate_user($user_id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid FROM users WHERE `email` ='".$user_id."'");
	    $row = mysqli_num_rows($result);
		return $row;
    }
function validate_mobile($user_id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid FROM users WHERE `mobile_no` ='".$user_id."'");
	    $row = mysqli_num_rows($result);
		return $row;
    }
    
    function validate_businessEmail($user_id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid FROM users WHERE `business_email` ='".$user_id."'");
	    $row = mysqli_num_rows($result);
		return $row;
    }
function validate_businessPhoneNumber($user_id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid FROM users WHERE `business_phone_no` ='".$user_id."'");
	    $row = mysqli_num_rows($result);
		return $row;
    }

function validated_userEmail($user_id,$id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid,email FROM users WHERE `uid` ='".$id."'");
		$userDetail=mysqli_fetch_assoc($result);
		if($userDetail['email']==$user_id){
			return 0;
		}else{
			return validate_user($user_id);
		}
	   // $row = mysqli_num_rows($result);
		//return $row;
    }
function validated_userMobile($user_id,$id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid,mobile_no FROM users WHERE `uid` ='".$id."'");
		$userDetail=mysqli_fetch_assoc($result);
	    if($userDetail['mobile_no']==$user_id){
			return 0;
		}else{
			return validate_mobile($user_id);
			//return 1;
		}
    }
    
    function validated_userBusinessEmail($user_id,$id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid,business_email FROM users WHERE `uid` ='".$id."'");
		$userDetail=mysqli_fetch_assoc($result);
		
	    if($userDetail['business_email']==$user_id){
			return 0;
		}else{
			return validate_businessEmail($user_id);
		}
    }
function validated_userBusinessPhoneNumber($user_id,$id) {
		global $conn;
		$result = mysqli_query($conn, "SELECT uid,business_phone_no FROM users WHERE `uid` ='".$id."'");
		$userDetail=mysqli_fetch_assoc($result);
	    if($userDetail['business_phone_no']==$user_id){
			return 0;
		}else{
			return validate_businessPhoneNumber($user_id);
		}
    }

    function pdfGenerate($url,$data)
	{
		
		require 'pdfcrowd.php';

		try
		{
			
			
			// create an API client instance
			$client = new Pdfcrowd("Fooduction", "d7d0f38a7147d9f4c6bf613b6301a4a2");
			
			// convert a web page and store the generated PDF into a $pdf variable
			//$pdf = $client->convertURI($url.'/order.php?data='.$data);
						
			// convert an HTML string
			$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
				<head>
					<title>Order Confirmation</title>					
				</head>
			<body style="font-family: Arial, Helvetica, sans-serif;   font-size: 13px;   line-height: 20px;  text-align: left;">
				<!-- Container Table -->
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" border="0" width="640" style="margin:0 auto;">
								<tr>
									<td><img src="logo.png"></td>
									<td align="right">
										<span style="font-size:16px; font-weight:bold; color:#000;">Order - </span>
										<span style="font-size:16px; font-weight:bold; color:#000;">PickUp</span>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="font-size:16px; font-weight:bold; color:#000; text-align:right; padding:0 0 10px 0;">(Order Confimation)</td>
								</tr>
								<tr>
									<td colspan="2" style="border:1px solid #ccc; padding:5px;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td width="16%">Venue:</td>
												<td width="80%">'. $data['vname'] .'</td>									
											</tr>
											<tr>
												<td width="16%">Delivery Provider:</td>	
												<td width="80%"></td>
											</tr>
											<tr>
												<td width="16%">Address:</td>	
												<td width="80%">'. $data['vadd'] .'</td>
											</tr>	
											<tr>
												<td width="16%">Phone:</td>	
												<td width="80%">'. $data['vphone'].'</td>
											</tr>									
										</table>
									</td>
								</tr>
								<tr>
									<td height="20px"></td>
								</tr>
								
								<tr>
									<td width="50%" style="border:1px solid #ccc; padding:5px; border-right:0;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td width="20%">Order No:</td>
												<td width="45%">'.$data['oid'] .'</td>									
											</tr>
											<tr>
												
												<td  width="23%">Request Date: <br/> (DD/MM/YYYY)</td>
												<td  width="45%" style="vertical-align:top;">'. $data['rdate'] .'</td>		
											</tr>
																	
										</table>						
									</td>
									<td width="50%" style="border:1px solid #ccc; padding:5px; border-left:0;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td  width="20%">Order Amount:</td>	
												<td  width="45%">$'. $data['amount'] .'</td>							
											</tr>
											<tr>
												<td  width="23%">PickUp Time: <br/> (DD/MM/YYYY)</td>	
												<td  width="45%" style="vertical-align:top;">Within the trading hours of the business</td>
											</tr>
																	
										</table>						
									</td>
								</tr>
								<tr>
									<td height="20px"></td>
								</tr>
								<tr>
									<td width="50%"  style="border:1px solid #ccc; padding:5px; border-right:0;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td width="20%">Customer Name:</td>
												<td width="45%">'.$data['cname'] .'</td>									
											</tr>
											<tr>									
												<td width="23%">Mobile:</td>
												<td width="45%">'. $data['cphone'] .'</td>		
											</tr>
											<tr>									
												<td width="23%">Payment Method:</td>
												<td width="45%"></td>		
											</tr>	
											
										</table>						
									</td>
									<td width="50%"  style="border:1px solid #ccc; padding:5px; border-left:0;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td  width="20%">Phone:</td>	
												<td  width="45%">N/A</td>							
											</tr>											
										</table>						
									</td>
								</tr>	
									<td height="20px"></td>
								</tr>					
								<tr>
									<td colspan="2">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr>
												<td>Customer Comments:</td>																		
											</tr>
											<tr>
												<td>
													<textarea row="5" col="50" style="width:100%; border:1px solid #ccc;"></textarea>
												</td>
											</tr>
										</table>
									</td>
								</tr>	
								</tr>	
									<td height="20px"></td>
								</tr>					
								<tr>
									<td colspan="2">
										<table cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #ccc;">
											<tr>
												<th style="background:#ddd; padding:5px;"></th>
												<th align="center" style="background:#ddd; padding:5px;">UNIT</th>
												<th align="center" style="background:#ddd; padding:5px;">QTY</th>
												<th align="center" style="background:#ddd; padding:5px;">Unit Price</th>
												<th align="center" style="background:#ddd; padding:5px;">TOTAL</th>
											</tr>
											<tr>
												<td style="border:1px solid #ccc; border-left:0; border-top:0; padding:5px;">'.$data['dishName'].'</td>
												<td align="center" style="border:1px solid #ccc; border-left:0; border-top:0; padding:5px;"></td>
												<td align="center" style="border:1px solid #ccc; border-left:0; border-top:0; padding:5px;">'.$data['quantity'] .'</td>
												<td align="center" style="border:1px solid #ccc; border-left:0;  border-right:0; padding:5px; border-top:0;">$'.$data['uprice'] .'</td>
												<td align="right" style="border:1px solid #ccc; border-right:0; border-top:0; padding:5px;">$'. $data['amount'] .'</td>
											</tr>
											<tr>
												<td style="border:1px solid #ccc; border-left:0; border-top:0; padding:5px;">Sub-total</td>
												<td colspan="4" align="right" style="border:1px solid #ccc; border-left:0; padding:5px; border-right:0; border-top:0;">$'.$data['amount'] .'</td>
											</tr>
											<tr>
												<td style="border:1px solid #ccc; border-left:0; border-top:0; padding:5px;">Delivery Fee</td>
												<td colspan="4" align="right" style="border:1px solid #ccc; border-left:0; padding:5px; border-right:0; border-top:0;"></td>
											</tr>
											<tr>
												<td style="border:1px solid #ccc; border-left:0; border-top:0; border-bottom:0; padding:5px;">Total Order Amount</td>
												<td colspan="4" align="right" style="border:1px solid #ccc; border-left:0; border-bottom:0; border-right:0; border-top:0; padding:5px;">$'. $data['amount'] .'</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding:5px 0;"><b>Your payment has been processed</b></td>
								</tr>
								</tr>	
									<td height="50px"></td>
								</tr>	
								<tr>
									<td colspan="2" style="padding:5px 0; text-align:center; font-size:10px; line-height:12px;">
										Fooduction Pty Ltd Level 1, 38 Richardson Street West Perth WA 6005  </br>
										ABN: 60 615 234 725</br>
										Phone: 1300 896 006 Email:orders@fooduction.com.au</br>	
										 http://www.fooduction.com.au</br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
			</html>';
			$fileName = 'document.pdf';
    		$filePath = dirname(__FILE__);
			$out_file = fopen($filePath.'/'.$fileName, "wb");
			$pdf = $client->convertHtml($html, $out_file);
			
		 
			// set HTTP response headers
			header("Content-Type: application/pdf");
			header("Cache-Control: max-age=0");
			header("Accept-Ranges: none");
			header("Content-Disposition: attachment; filename=\"order.pdf\"");
			
			
			// send the generated PDF 
			return  $pdf;
		}
		catch(PdfcrowdException $why)
		{
			echo "Pdfcrowd Error: " . $why;
		}
	}
	
	function mail_attachment($content,$mailto, $from_mail, $subject, $message) {
		
				
			 $content = chunk_split(base64_encode($content));
			 
			 $uid = md5(uniqid(time()));
			 $header = "From:orders@fooduction.com.au \r\n";			 
			 $header .= "MIME-Version: 1.0\r\n";
			 $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
			 $header .= "This is a multi-part message in MIME format.\r\n";
			 $header .= "--".$uid."\r\n";
			 $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
			 $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			 $header .= $message."\r\n\r\n";
			 $header .= "--".$uid."\r\n";
			 $header .= "Content-Type: application/octet-stream; name=\"order.pdf\"\r\n"; // use different content types here
			 $header .= "Content-Transfer-Encoding: base64\r\n";
			 $header .= "Content-Disposition: attachment; filename=\"order.pdf\"\r\n\r\n";
			 $header .= $content."\r\n\r\n";
			 $header .= "--".$uid."--";
			 
			 if (mail($mailto, $subject, "", $header)) {
				 return 1;
				
			 } else {
				 return 1;
				
			 } 
			
		}

function send_email($content,$mailto, $from_mail, $subject, $message)
{

    $fileName = 'document.pdf';
    $filePath = dirname(__FILE__);
    $url = 'https://api.sendgrid.com/';
    $params['api_user'] = "FooductionApp";
    $params['api_key'] = "Liferocks123";
    $params['from'] = "orders@fooduction.com.au";
    $params['to'] = $mailto;
    $params['html'] = $message;
    $params['files['.$fileName.']']='@'.$filePath.'/'.$fileName;
    $params['subject'] = $subject;
    $request = $url.'api/mail.send.json';

    // Generate curl request
    $session = curl_init($request);

    // Tell curl to use HTTP POST
    curl_setopt ($session, CURLOPT_POST, true);

    // Tell curl that this is the body of the POST
    curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

    // Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    // obtain response
    $response = curl_exec($session);
    curl_close($session);
    return $response;

}		
?>
