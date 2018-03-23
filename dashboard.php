<?php

include ('header.php');
include ('checkUserRole.php');
include ('toppart.php');
include ('menu.php');
$cityId = $_SESSION['city_id'];

$tot_usr = mysqli_query($conn, "select * from users where role=2 and city_id=$cityId") or die(mysqli_error($conn));
$tot_bui = mysqli_query($conn, "select * from users where role=3 and city_id=$cityId") or die(mysqli_error($conn));
//$arr  =[];
//while($row=mysqli_fetch_assoc($tot_bui)){
//    array_push($arr, $row['uid']);
//}

$tot_dish = mysqli_query($conn, "SELECT SUM(no_of_items) as no_of_items FROM orders AS o LEFT JOIN users as u ON o.vendor_id=u.uid WHERE o.delivery_status=1 and u.city_id=$cityId") or die(mysqli_error($conn));
$RP = mysqli_fetch_assoc($tot_dish);

//$tot_com=mysqli_query($conn,"select * from orders where delivery_status=1 group by fkcartid") or die(mysqli_error($conn));
$tot_dish = mysqli_query($conn, "select * from dishes") or die(mysqli_error($conn));

$today = date('Y-m-d', time());

$today_user = mysqli_query($conn, "SELECT * from users where role=2 and city_id=$cityId and 
date_format(FROM_UNIXTIME(created_on,'%Y-%m-%d'),'%Y-%m-%d')='" . $today . "'");

$today_bui = mysqli_query($conn, "SELECT * from users where role=3 and city_id=$cityId and 
date_format(FROM_UNIXTIME(created_on,'%Y-%m-%d'),'%Y-%m-%d')='" . $today . "'");

$today_order = mysqli_query($conn, "SELECT * FROM cartorders where date_format(FROM_UNIXTIME((SubStr(created_on, 1, LENGTH(created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='" . $today . "'");

$today_items = mysqli_query($conn, "SELECT SUM(no_of_items) as no_of_items FROM orders where date_format(FROM_UNIXTIME((SubStr(created_on, 1, LENGTH(created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='" . $today . "'");
$RPO = mysqli_fetch_assoc($today_items);

$today_ped = mysqli_query($conn, "SELECT * from orders Where delivery_status=0 and
 date_format(FROM_UNIXTIME((SubStr(created_on, 1, LENGTH(created_on) - 3)),'%Y-%m-%d'),'%Y-%m-%d')='" . $today . "' group by fkcartid");
?>
<div id="page_content">
    <div id="page_content_inner">
        <!-- statistics (small charts) -->
        <div class="uk-grid uk-grid-width-large-1-5 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
            <div class="uk-row-first">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><i class="material-icons" style="font-size:35px;">&#xE572;</i></div>
                        <span class="uk-text-muted uk-text-small"><a href="vendor_list.php">Total Business</a></span>
                        <h2 class="uk-margin-remove" id="peity_live_text"><a href="vendor_list.php"><?php echo mysqli_num_rows($tot_bui); ?></a></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><i class="material-icons" style="font-size:35px;">&#xE801;</i></div>
                        <span class="uk-text-muted uk-text-small"><a href="total_sale.php">Total Sale</a></span>
                        <h2 class="uk-margin-remove"><a href="total_sale.php"><?php echo $RP['no_of_items'] > 0 ? $RP['no_of_items'] : 0; ?></a></noscript></span></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><i class="material-icons" style="font-size:28px;">&#xE8CB;</i></div>
                        <span class="uk-text-muted uk-text-small"><a href="total_orders_completed.php">Total Orders Completed</a></span>
                        <h2 class="uk-margin-remove"><a href="total_orders_completed.php"><span class="countUpMe">0<noscript><?php echo mysqli_num_rows($tot_com); ?></noscript></span></a></h2>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"><i class="material-icons" style="font-size:35px;">&#xE1BD;</i></div>
                        <span class="uk-text-muted uk-text-small"><a href="dishes_list.php"> Total Dishes </a></span>
                        <h2 class="uk-margin-remove"><a href="dishes_list.php"><span class="countUpMe">0<noscript><?php echo mysqli_num_rows($tot_dish); ?></noscript></span></a></h2>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="heading_a uk-margin-bottom uk-text-center"><b>Today's Updates</b></h4>

        <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>
            
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="<?php echo mysqli_num_rows($today_bui); ?>" data-bar-color="#03a9f4">
                            <span class="epc_chart_icon"><?php echo mysqli_num_rows($today_bui); ?></span>
                        </div> 
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <h3 class="uk-text-center">
                                <a href="todays_vendor_list.php"> Business </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="<?php echo mysqli_num_rows($today_order); ?>" data-bar-color="#03a9f4">
                            <span class="epc_chart_icon"><?php echo mysqli_num_rows($today_order); ?></span>
                        </div> 
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <h3 class="uk-text-center">
                                <a href="todays_order_list.php"> Order </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="<?php echo mysqli_num_rows($today_ped); ?>" data-bar-color="#03a9f4">
                            <span class="epc_chart_icon"><?php echo mysqli_num_rows($today_ped); ?></span>
                        </div> 
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <h3 class="uk-text-center">
                                <a href="todays_pending_order_list.php"> Pending Orders </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <div class="epc_chart" data-percent="<?php echo $RPO['no_of_items']; ?>" data-bar-color="#03a9f4">
                            <span class="epc_chart_icon">
                                <?php if ($RPO['no_of_items'] == "NULL" || $RPO['no_of_items'] == '') {
                                    echo '0';
                                } else {
                                    echo $RPO['no_of_items'];
                                }
                                ?>
                            </span>
                        </div> 
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <h3 class="uk-text-center">
                                <a href="todays_total_sales.php"> Total Sales </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tasks -->
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">Last Orders</h3>
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                    <tr>
                                        <th class="uk-text-nowrap">Transaction ID</th>
                                        <th class="uk-text-nowrap">Username</th>
                                        <th class="uk-text-nowrap">Status</th>
                                        <th class="uk-text-nowrap uk-text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "select * from cartorders where active=1 order by pkuniquecartid desc limit 4") or die(mysqli_error($conn));
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            $unm = mysqli_query($conn, "select * from users where uid='" . $row['uid'] . "'") or die(mysqli_error($conn));
                                            $R1 = mysqli_fetch_assoc($unm);
                                            $orid = explode(",", $row['orders']);
                                            //echo $orid[0];
                                            $query3 = mysqli_query($conn, "select * from orders where order_id='" . $orid[0] . "'") or die(mysqli_error($conn));
                                            $row3 = mysqli_fetch_assoc($query3);
                                            ?>
                                            <tr class="uk-table-middle">
                                                <td class="uk-width-3-10 uk-text-nowrap"><?php echo $row['transaction_id']; ?></td>
                                                <td class="uk-width-2-10 uk-text-nowrap"><?php echo $R1['first_name'] ?></td>
                                                <td class="uk-width-3-10">
        <?php if ($row3['delivery_status'] == 0) {
            echo "Pending";
        } elseif ($row3['delivery_status'] == 1) {
            echo "Completed";
        } elseif ($row3['delivery_status'] == 2) echo "Cancelled"; ?>
                                                </td>
                                                <td class="uk-width-2-10 uk-text-right uk-text-muted uk-text-small">
                                                    <?php
                                                    //echo $row['created_on']; 
                                                    if ($row['created_on']) {
                                                        $unix_timestamp = substr($row['created_on'], 0, -3);
                                                        //echo "<br/>";
                                                        $datetime = new DateTime("@$unix_timestamp");
                                                        echo $datetime->format('d-m-Y');
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
    <?php
    }
} else {
    ?>
                                        <tr class="uk-table-middle">
                                            <td colspan="4">Order Not Found.  
                                            </td>
                                        </tr>
<?php }
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <h3 class="heading_a uk-margin-bottom">New Vendor</h3>
                        <div class="uk-overflow-container">
                            <table class="uk-table">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Business Name</th>
                                        <th>Email Id</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$query = mysqli_query($conn, "select * from users where role=3 order by uid desc limit 4") or die(mysqli_error($conn));
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
                                            <tr class="uk-table-middle">
                                                <td class="uk-width-3-10 uk-text-nowrap"><?php echo $row['first_name']; ?></td>
                                                <td class="uk-width-2-10 uk-text-nowrap"><?php echo $row['business_name']; ?></td>
                                                <td class="uk-width-3-10"><?php echo $row['email']; ?></td>
                                            </tr>
    <?php
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

<?php include ('footer.php'); ?>

        <!-- page specific plugins -->
        <!-- d3 -->
        <script src="bower_components/d3/d3.min.js"></script>
        <!-- metrics graphics (charts) -->
        <script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
        <!-- chartist (charts) -->
        <script src="bower_components/chartist/dist/chartist.min.js"></script>
        <!-- maplace (google maps) -->
        <script src="http://maps.google.com/maps/api/js"></script>
        <script src="bower_components/maplace-js/dist/maplace.min.js"></script>
        <!-- peity (small charts) -->
        <script src="bower_components/peity/jquery.peity.min.js"></script>
        <!-- easy-pie-chart (circular statistics) -->
        <script src="bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <!-- countUp -->
        <script src="bower_components/countUp.js/dist/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
        <!-- CLNDR -->
        <script src="bower_components/clndr/clndr.min.js"></script>
        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>

        </body>
        </html>
