<?php
require_once '../../../wp-config.php';

global $wpdb;

$servername =$wpdb->dbhost;
$username = $wpdb->dbuser;
$password = $wpdb->dbpassword;
$dbname = $wpdb->dbname;
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
