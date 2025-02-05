<?php

$host     = "localhost";
$username = "root";
$password = "";
$database = "perpustakaan";

$conn = new mysqli($host, $username, $password, $database);
if ($conn){
    echo "";
}else{
	echo "database tidak terkoneksi";
}
?>