<?php
 include "../config/koneksi.php";

 $id= $_GET['id'];
 $conn = new mysqli($host,"DELETE FROM buku where id='$id'");

if($data){
    header('location:buku/index.php');
}else{
    echo "Maaf Data Tidak Berhasil";
}
?>