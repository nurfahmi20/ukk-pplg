<?php
include"../config/koneksi.php";

if(isset($_POST['simpan'])){
    $BukuID = $_POST['BukuID'];
    $Judul = $_POST['Judul'];
    $Penuls = $_POST['Penulis'];
    $Penerbit = $_POST['Penerbit'];
    $TahunTerbit = $_POST['TahunTerbit'];

    $sql = "INSERT INTO Buku(BukuID, Judul, Penulis, Penerbit, TahunTerbit) VALUES('$BukuID', '$Judul', '$Penulis', '$Penerbit', '$TahunTerbit')";
    mysqli_query($koneksi, $sql);  // Execute the query to insert

    // Fetch and display records after insert
    $data = mysqli_query($koneksi, "SELECT * FROM buku");
    while ($hasil = mysqli_fetch_array($data)) {
        var_dump($hasil); // Debugging line
    }
}


?>


<!DOCTYPE html>
<html>
<head>
     <Title>Halaman Buku</Title>
</head>
 <body>

<h1 style="text-align:center;"><strong>PERPUSTAKAAN DIGITAL</strong></h1>

<button style="background-color: skyblue;"><a href="form_tambah.php">Tambah</a></button>
 <br>
<!-- Table -->
<!-- <table d="table" table border="1"> -->
<table width="97%" border="1" align="center" cellpadding="3" cellspacing="0">
  <thead>
 <tr style="background-color: pink;">
    <th> No. </th>
    <th> BukuID</th>
    <th> Judul</th>
    <th> Penulis</th>
    <th> Penerbit</th>
    <th> TahunTerbit</th>
    <th> aksi</th>
</tr>
  </thead>
  <tbody>
 <?php
    include"../config/koneksi.php";

    $no =1;
    $data= mysqli_query($conn,"SELECT * FROM buku");
    while ($hasil= mysqli_fetch_array($data)) {
        ?>
    
    <tr> 
    <td><?php echo $no++; ?></td>
    <td><?php echo $hasil['BukuID']; ?></td>
    <td><?php echo $hasil['Judul']; ?></td>
    <td><?php echo isset($hasil['Penulis']) ? $hasil['Penulis'] : 'N/A'; ?></td>
    <td><?php echo isset($hasil['Penerbit']) ? $hasil['Penerbit'] : 'N/A'; ?></td>
    <td><?php echo $hasil['TahunTerbit']; ?></td>
    <td align="center">
        <a href="edit.php>">edit</a> ||
        <a onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ini?')" href="hapus.php>">Hapus</a>
    </td>
</tr>

  </tbody>
  <?php } ?>
 
 


</table>

 </body>
 </html>