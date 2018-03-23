<?php
$roleId = isset($_SESSION['role'])? $_SESSION['role']: 5;
$requestUri =  $_SERVER['REQUEST_URI'];
$isSubAdmin = ($roleId == 4 && strpos($requestUri,'sub-admin'))? true: false;


if($isSubAdmin || $roleId == 5){
    $link_array = explode('/',$requestUri);
    $page = end($link_array);
    return true;
}
else{
    header('location:../../admin/viralAdmin/logout.php'); 
}
