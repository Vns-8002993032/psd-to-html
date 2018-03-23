<?php include 'connection.php'; ?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
        <title>Fooduction Pty Ltd</title>
        <!-- additional styles for plugins -->
        <!-- weather icons -->
        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css" media="all">
        <!-- metrics graphics (charts) -->
        <link rel="stylesheet" href="bower_components/metrics-graphics/dist/metricsgraphics.css">
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
        <!-- uikit -->
        <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">
        <!-- flag icons -->
        <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">
        <!-- style switcher -->
        <link rel="stylesheet" href="assets/css/style_switcher.min.css" media="all">
        <!-- altair admin -->
        <link rel="stylesheet" href="assets/css/main.min.css" media="all">
        <!-- themes -->
        <link rel="stylesheet" href="assets/css/themes/themes_combined.min.css" media="all">
        <link rel="stylesheet" href="assets/css/custom.css" />
        <!-- matchMedia polyfill for testing media queries in JS -->
        <!--[if lte IE 9]>
            <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
            <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
            <link rel="stylesheet" href="assets/css/ie.css" media="all">
        <![endif]-->
    </head>

    <?php date_default_timezone_set('Australia/Perth'); ?>	
    <?php
//$v_dob;
    /* $upd_dob=mysqli_query($conn,"select * from users where uid='1106'");
      //$v_dob=mysqli_fetch_array($upd_dob);
      while($v_dob=mysqli_fetch_array($upd_dob))
      {
      $string=$v_dob['dob'];
      if($string=='')
      {

      }else
      {
      $replacement = "000";
      $final = substr($string, 0, -3).$replacement;
      $upd_dob=mysqli_query($conn,"update users set dob='".$final."' where uid='".$v_dob['uid']."'");

      }
      } */
    $query = mysqli_query($conn, "select * from users order by uid desc") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {

            $string = $row['dob'];
            if ($string == '') {
                
            } else {
                if (strlen($string) == 13) {
                    $replacement = "000";
                    $final = substr($string, 0, -3) . $replacement;
                    $upd_dob = mysqli_query($conn, "update users set dob='" . $final . "' where uid='" . $row['uid'] . "'");
                }
            }
        }
    }
    ?>