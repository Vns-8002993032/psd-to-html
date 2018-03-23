<?php
if(!isset($_SESSION['uid']))
{
	?> <script> window.location='index.php'; </script> <?php
} ?>
  <!-- main sidebar -->
    <aside id="sidebar_main">
        
        <div class="sidebar_main_header">
            <div class="sidebar_logo">
                <a href="dashboard.php" class="sSidebar_hide sidebar_logo_large">
                    <img class="logo_regular" src="assets/img/logo_main.png" alt="" />
                </a>
            </div>	
            </div>
        </div>
        
        <div class="menu_section">
            <ul>
                <li class="current_section" title="Dashboard">
                    <a href="dashboard.php">
                        <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                        <span class="menu_title">Dashboard</span>
                    </a>
                    
                </li>
<!--                <li title="Forms">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE7FE;</i></span>
                        <span class="menu_title">Users</span>
                    </a>
                    <ul>
                        <li><a href="user_add.php">Add User</a></li>
                        <li><a href="users_list.php">User Management</a></li>
					</ul>
                </li>-->
                <li title="Layout">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                        <span class="menu_title">Business</span>
                    </a>
                    <ul>
                        <li><a href="vendor_add.php">Add Business</a></li>
                        <li><a href="vendor_list.php">Business Management</a></li>
                    </ul>
                </li>
                <li title="Kendo UI Widgets">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE1BD;</i></span>
                        <span class="menu_title">Dishes</span>
                    </a>
                    <ul>
                        <li><a href="dish_add.php">Add Dishes</a></li>
                        <li><a href="dishes_list.php">Dishes Management</a></li>
                    </ul>
                </li>
				<li title="Kendo UI Widgets">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8F6;</i></span>
                        <span class="menu_title">Coupons</span>
                    </a>
                    <ul>
                        <li><a href="coupons_add.php">Add Coupons</a></li>
                        <li><a href="coupons_list.php">Coupons Management</a></li>
                    </ul>
                </li>
        
                <li title="E-commerce">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8CB;</i></span>
                        <span class="menu_title">Orders</span>
                    </a>
                    <ul>
               
                        <li><a href="user_order.php">User Orders</a></li>
                    </ul>
                </li>
              
               <li title="E-commerce">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE422;</i></span>
                        <span class="menu_title">History</span>
                    </a>
                    <ul>
                        <li><a href="history_business.php">Business History</a></li>
                    </ul>
                
                </li>
				<li title="Dashboard">
                    <a href="send_notification.php">
                        <span class="menu_icon"><i class="material-icons">&#xE8AF;</i></span>
                        <span class="menu_title">Send Notification</span>
                    </a>
                </li>
              	<li title="Dashboard">
                    <a href="help_list.php">
                        <span class="menu_icon"><i class="material-icons">&#xE0C6;</i></span>
                        <span class="menu_title">Help Request</span>
                    </a>
                </li>
    			
                 <li title="E-commerce">
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8C3;</i></span>
                        <span class="menu_title">CMS Pages</span>
                    </a>
                    <ul>
                    	
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="pages.php?id=2">Privacy Policy</a></li>
                        <li><a href="pages.php?id=1">Terms & Conditions</a></li>
						<li><a href="pages.php?id=3">Guide</a></li>
                    </ul>
                
                </li>
                 <li title="Forms">
                 	<a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE865;</i></span>
                        <span class="menu_title">Reports</span>
                    </a>
                 	 <ul>
                    	
                        <li><a href="vendor_list-report.php">Business Reports</a></li>
                        <li><a href="dishes_list-report.php">Dish Reports</a></li>
						<li><a href="user_order-report.php">Order Reports</a></li>
                    </ul>
                 </li>
                <li title="Dashboard">
                    <a href="video.php">
                        <span class="menu_icon"><i class="material-icons">&#xE0C6;</i></span>
                        <span class="menu_title">Upload Video</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside><!-- main sidebar end -->
