<?php include('header.php');include ('checkUserRole.php');include('toppart.php'); include('menu.php'); include('function.php'); ?>
 <?php

            function sendFCM($mess, $id) {
                $url = 'https://fcm.googleapis.com/fcm/send';
                $type = "custom";
                $fields = array(
                    'to' => $id,
                    'data' => array("message" => $mess, "info" => $mess, "sound" => "default", "click_action" => "FCM_PLUGIN_ACTIVITY", "type" => $type),
                    'notification' => array(
                        "body" => $mess,
                        "title" => "Fooduction",
                        "icon" => "myicon"
                    )
                );
                $fields = json_encode($fields);
                $headers = array(
                    'Authorization: key=' . "AAAA8Loq8sY:APA91bFvzPhLNcUh6PubzcxpGB6p3_GJBEJSl1aXKUkBHZqM9IibuFcHqkqaUpLqRMZ29QLkQCTIUgq2r3_HvkHUjJFNQFuDEd5ieKdKXldD92Lc_18qMdt2fR7THsoKyKWOMcUKsXq8QDFz3GaGFcs6b6wnbiB61A",
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

                 $result = curl_exec($ch);
                
                curl_close($ch);
                return TRUE;
            }

            function ios_push_notification($deviceID, $message, $mesg_info, $type) {


                $apiKey = "AAAAPVQk4jc:APA91bHP1nKhLND24-qZgCoB0dKKNaOkr1hy_eOkHNH4gVP0aXGxd-bJXXzi17cCp5TRTWfVEUhIOPNxLkz3bQAQFKh_Inu6jI5XvEe5bNMQrd3QPOU_oJ8zQjWup8FZD3kfd0wxznGy";
//                                $apiKey = "AAAA8Loq8sY:APA91bFvzPhLNcUh6PubzcxpGB6p3_GJBEJSl1aXKUkBHZqM9IibuFcHqkqaUpLqRMZ29QLkQCTIUgq2r3_HvkHUjJFNQFuDEd5ieKdKXldD92Lc_18qMdt2fR7THsoKyKWOMcUKsXq8QDFz3GaGFcs6b6wnbiB61A";
                //$url = 'https://android.googleapis.com/gcm/send';
                $url = 'https://fcm.googleapis.com/fcm/send';
                $fields = array(
                    'notification' => array("title" => "Fooduction", "body" => $message, "sound" => "default", "click_action" => "FCM_PLUGIN_ACTIVITY", "icon" => "fcm_push_icon",),
                    'data' => array("message" => $message, "info" => $mesg_info, "type" => $type),
                    'to' => $deviceID,
                    'priority' => "high"
                );
                $headers = array(
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                );
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);

//                echo $result;
//                exit;
        curl_close($ch);
                return $result;
            }

            if (isset($_POST['submit'])) {



                $query = mysqli_query($conn, "select uid,devic_type,device_id from users where role=2 AND device_id!=''") or die(mysqli_error($conn));
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                       
                        $deviceID = $row['device_id'];
                        if ($row['devic_type'] == "android" || $row['devic_type'] == "Android") {

//                            $deviceID = "clfNe9qT7BM:APA91bFCv8krKizcFOFPiGjB4VxJslxoRotJxLAqNv4NrbrpJeL9YozwrBXg6ZXbiPjrRyzZnrf-tC9_BgO54kn9QXosNaY2jzdcojOfYY0oaLARMKOGOGfZHCjf3w-Sv5qfPRxDpL_x";
                            $mesg_info = $_POST['notificationtext'];
                            sendFCM($mesg_info, $deviceID);
                        } elseif ($row['devic_type'] == "ios" || $row['devic_type'] == "Ios" || $row['devic_type'] == "IOS") {
//                            $deviceID = "c_0QwGWcIz4:APA91bHZ_aAzqnqqY8Eain6MorKv4kkuTqgLOpHLVoMuQMLaRaYJo0NcoQgenFzs61GyT33SCNcKQNWi9u7z_UmZA3-80sszsXflQ7zlOWsGXUdy618mjiizGomz1UGZ5oVdBIxFYLhw";
                            $mesg_info = $_POST['notificationtext'];
                            $message = $_POST['notificationtext'];
                            $type = "iospushnoti";
                            ios_push_notification($deviceID, $message, $mesg_info, $type);
                        }
                    }
                }
            }
            ?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-grid" data-uk-grid-margin>	
			<div class="uk-width-8-10 uk-container-center">
				<div class="md-card">
					<div class="md-card-content"><h1 class="uk-text-center">Send Notification</h1>
						<div class="uk-form-row">
							<div class="uk-width-8-10 uk-container-center">
							<?php if(!empty($_SESSION['success'])) { ?>
								<div class='alert alert-success'> <?php echo $_SESSION['success']?> </div>
							<?php $_SESSION['success']="";} ?>
							<?php if(!empty($_SESSION['error'])) { ?>
								<div class='alert alert-danger'> <?php echo $_SESSION['error']?> </div>
							<?php $_SESSION['error']="";} ?>
							
							<?php 
								$error = $not_msgErr = "";
								if(isset($_POST['submit']))
								{
									if(empty($_POST['notificationtext'])){
										$error = $not_msgErr ="Please Enter Message";
									}
									elseif(empty($error))
									{
										$query = mysqli_query($conn, "select uid,devic_type,device_id from users where role=2") or die(mysqli_error($conn));
										if (mysqli_num_rows($query) > 0)
										{
											while ($row = mysqli_fetch_assoc($query))
											{
												$deviceID = $row['device_id'];
												if($row['devic_type'] == "android" || $row['devic_type'] == "Android")
												{
													$mesg_info = $_POST['notificationtext'];
                            						sendFCM($mesg_info, $deviceID);
												}
												elseif ($row['devic_type'] == "ios" || $row['devic_type'] == "Ios" || $row['devic_type'] == "IOS")
												{
													$mesg_info = $_POST['notificationtext'];
													$message = $_POST['notificationtext'];
													$type = "iospushnoti";
													ios_push_notification($deviceID, $message, $mesg_info, $type);
												}
                    						}
                						}//if
										
										if($query==1){
											$_SESSION['success']="Notification send successfully.";
											header('location:send_notification.php');
											?> <script> window.location='send_notification.php'; </script> <?php
											exit;
										}
										else{
											$_SESSION['error']="Error in sending notification ".mysqli_error($conn);
										}
									}//else
								} //if
									
							?>
							
							<form action="" method = "post" enctype="multipart/form-data" class="profile-form" id="addDish">
								<div class="uk-grid" data-uk-grid-margin>
									<div class="uk-width-medium-1-1">
										<label>Message*</label>
										<textarea class="masked_input md-input" name="notificationtext" 
										id="notificationtext"></textarea>
										<span class="uk-text-danger"><?php echo $not_msgErr;?></span>
                                    </div>
                                    
                                    <div class="uk-width-medium-1-6">
										<button type="submit" name="submit" class="md-btn md-btn-primary">Submit</button>
                        			</div>
									<div class="uk-width-medium-1-6">
										<a class="md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light" href="coupons_list.php">Cancel</a>
									</div>
                                </div>
							</form>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
          
<?php include ('footer.php'); ?>
    <!-- ionrangeslider -->
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>

</body>
</html>
   
  