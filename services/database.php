<?php
//Cara pemanggilan database start
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "cuyresto";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    echo "Koneksi Database Error";
    die("koneksi database error");
}
//Cara pemanggilan database end

