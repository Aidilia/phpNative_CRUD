<?php
session_start();

if ( !isset($_SESSION["login"])){
    header(("Location: login.php"));
}

include 'connection.php';

//ambil data di URlL
$id_siswa = $_GET["id_siswa"];


//query data siswa berdasarkan id;
$query = "SELECT * FROM siswa WHERE id_siswa = $id_siswa";
$hasil = mysqli_query($koneksi, $query);
$sql = mysqli_fetch_assoc($hasil);

$id = $sql['id_siswa'];
$nama = $sql['nama'];
$nisn = $sql['nisn'];
$gambar = $sql['gambar'];
$email = $sql['email'];

if(isset($_POST["submit"]) ){

    if(ubah($_POST) > 0){
       echo " <script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    }else{
        echo " <script>
        alert('Data gagal diubah!');
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
    <title>Ubah data siswa</title>
</head>
<body>
    <h1>Ubah data Siswa</h1>

    <form action="" method="post">
        <input type="hidden" name="id_siswa" value="<?= $id?>">
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $nama ?>">
            </li>

            <li>
                <label for="nisn">NISN :</label>
                <input type="text" name="nisn" id="nisn" required value="<?= $nisn ?>">
            </li>

            <li>
                <label for="gambar">Gambar :</label>
                <input type="text" name="gambar" id="gambar" required value="<?= $gambar ?>">
            </li>

            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required value="<?= $email ?>">
            </li>

            <li>
                <button type="submit" name="submit">Ubah Data! </button>
            </li>

        </ul>
    </form>
    
</body>
</html>