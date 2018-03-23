<?php session_start();
/*
$servername="localhost";
$username="pro_fooductionad";
$password="qwOEyree";
$dbname="pro_fooductionadmin_10feb17";
*/

/* Local SetUp
$servername="localhost";
$username="root";
$password="";
$dbname="fooduction";
 * */

// Dev Environment
$servername="localhost";
$username="root";
$password="";
$dbname="development_1";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
