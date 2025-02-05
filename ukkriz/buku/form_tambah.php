<!DOCTYPE html>
<html>
<head>
    <title>Menambah Data Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(56, 227, 9, 0.1);
            width: 450px;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-family: 'Georgia', serif;
            color: #333;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        select option {
            font-size: 16px; /* Memperbesar ukuran font */
            line-height: 1.5em; /* Menambahkan tinggi baris */
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        button[type="submit"], .cancel-btn {
            background-color:rgb(46, 99, 47);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .cancel-btn {
            background-color:rgb(124, 35, 35);
            margin-left: 10px;
        }
        .cancel-btn a {
            color: white; 
            text-decoration: none;
        }
        button[type="submit"]:hover, .cancel-btn:hover {
            background-color:rgb(22, 15, 229);
        }
        .cancel-btn:hover {
            background-color:rgb(88, 29, 29);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Buku</h1>
        <form method="post" action="tambah.php">
            <label for="BukuID">BukuID</label>
            <input type="text" id="BukuID" name="BukuID">
            <label for="Judul">Judul</label>
            <input type="text" id="Judul" name="Judul">
            <label for="Penulis">Penulis</label>
            <input type="text" id="Penulis" name="Penulis">
            <label for="Penerbit">Penerbit</label>
            <input type="text" id="Penerbit" name="Penerbit">
            <label for="TahunTerbit">TahunTerbit</label>
            <input type="text" id="TahunTerbit" name="TahunTerbit">
            <div class="button-container">
                <button type="submit" name="simpan">Simpan</button>
                <a href="../../button.php" class="cancel-btn">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
