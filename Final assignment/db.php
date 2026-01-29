<?php

$host   = "127.0.0.1";
$dbname = "product_db";
$dbuser = "root";
$dbpass = "";

function getConnection(){
    global $host, $dbname, $dbuser, $dbpass;

    $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    if(!$con){
        die("DB Connection failed: " . mysqli_connect_error());
    }
    return $con;
}

function esc($con, $str){
    return mysqli_real_escape_string($con, $str);
}
?>
