<?php ob_start(); ?>
<?php
session_start();
if (!($_SESSION['uid'])) {
    header("Location:index.php");
} else {
    ?>
    <?php include('header.php'); ?>
    <?php include('connection.php'); ?>
    <?php include('function.php'); ?>

    <div class="clearfix"></div>
    <?php if (!empty($_SESSION['success'])) { ?>
        <div class='alert alert-success'> <?php echo $_SESSION['success'] ?> </div>
        <?php
        $_SESSION['success'] = "";
    }
    ?>

    <?php if (!empty($_SESSION['error'])) { ?>
        <div class='alert alert-danger'> <?php echo $_SESSION['error'] ?> </div>
        <?php
        $_SESSION['error'] = "";
    }
    ?>
    <div class="content-body">
        <div class="container-fluid">
            <?php
            ?>
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


                $query = mysqli_query($conn, "select uid,devic_type,device_id from users where role=2") or die(mysqli_error($conn));
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

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Send Notification</h1>							
            </section>
            <form action = "<?php ?>" method = "post" enctype="multipart/form-data" class="profile-form" id="addDish">






                <div class="row">         
                    <div class="form-group col-sm-2 col-sm-offset-2">
                        <label for = "notificationtext" >Message :</label>
                    </div>
                    <div class="form-group col-sm-6 <?php //echo //form_error('lcv_from') ? 'has-error' : '';                     ?>">
                        <!--<input type = "text"  name = "notificationtext"   class = "form-control" >-->
                        <textarea class="form-control" name="notificationtext" required="required"></textarea>

                    </div>  
                </div>

                <div class="form-group col-sm-2 col-sm-offset-4">
                    <input type = "submit" name="submit" class = "btn btn-primary btn-large" value = "Submit">
                </div>
                <div class ="form-group col-sm-1">
                    <a href="sendNotification.php">
                        <button class="btn btn-danger" type="button">Cancel</button></a></a>
                </div>
            </form>     
        </div>
    </div>
    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
<?php }include('footer.php'); ?>
