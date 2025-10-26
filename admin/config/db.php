<?php 

$dbname = "htoo-blog";
$dbuser = "root";
$dbpass = "";
$dbhost = "localhost";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
