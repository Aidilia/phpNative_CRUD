<?php
session_start();

if ( !isset($_SESSION["login"])){
    header(("Location: login.php"));
    exit;
}

include 'connection.php';


if(isset($_POST["submit"]) ){

    if(tambah($_POST) > 0){
       echo " <script>
            alert('Data berhasil ditambahakan!');
            document.location.href = 'index.php';
        </script>";
    }else{
        echo " <script>
        alert('Data gagal ditambahakan!');
        document.location.href = 'index.php';
    </script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data siswa</title>
</head>
<body>
    <h1>Tambah data Siswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>

            <li>
                <label for="nisn">NISN :</label>
                <input type="text" name="nisn" id="nisn" required>
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required>
            </li>

            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar" required>
            </li>

            <li>
                <input type="submit" name="submit">
</input>
            </li>

        </ul>
    </form>
    
</body>
</html>