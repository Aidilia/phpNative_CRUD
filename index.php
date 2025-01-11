<?php
session_start();

if( !isset($_SESSION["login"])){
    header(("Location: login.php"));
    exit;
}

require 'connection.php';

// //konfigurasi pagination (LIMIT)
 $jumlahDataperhalaman = 2;
// $result = mysqli_query($koneksi, "SELECT * FROM siswa"); //mengembalikan objek
// $jumlahdatasiswa = mysqli_num_rows($result); //akan menghasilakan ada berapa baris data siswa
//cara lain
$jumlah_data = count(query("SELECT * FROM siswa"));
$jumlahHalaman = ceil($jumlah_data / $jumlahDataperhalaman); //round membulatkan ke desimal terdekat  || floor membulatkan ke bawah || ceil membulatkan ke atas

//kita ingin tahu dihalaman berapa yang kita lihat
//kasih kondisi
// if( isset($_GET["halaman"]) ){
//     $halamanAktif =  $_GET["halaman"];
// }else{
//     $halamanAktif = 1;
// }

//cara lain operator ternari
//jika kondisi bernilai true ?=maka masuk ke halaman else angka 1
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;

//jika di halaman 2, maka indexnya dari 2
//jika halaman 3, maka indexnya dari 4
$awalData = ($jumlahDataperhalaman * $halamanAktif) - $jumlahDataperhalaman;

//menampilkan data Data ke-2 indexnya 1
$siswa = query("SELECT * FROM siswa LIMIT $awalData,$jumlahDataperhalaman");

//tombol cari diklik
if(isset($_POST["cari"])){

    $siswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php"> Logout </a>
    <h1>Daftar Siswa</h1>
    <a href="tambah_siswa.php"> Tambah Data Siswa</a>
    <br>
</br>
<br>
<form action="" method="post">
    <input type="text" name="keyword" size="40" autofocus placeholder="Searching ..." autocomplete="off">
    <button type="submit" name="cari">
        Cari!
    </button>
</form>

<!--buat navigasi halaman-->
<?php if( $halamanAktif > 1) :?>
<a href="?halaman=<?= $halamanAktif - 1 ?>"> &laquo; </a> <!-- kalo lt tanda panah 1 || kalo laquo tanda panah 2-->
<?php endif; ?>

<?php
for($i=1; $i<= $jumlahHalaman; $i++) : ?>
<?php if ( $i == $halamanAktif) : ?>
<a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"> <?= $i ?></a>
<?php else : ?>
    <a href="?halaman=<?= $i ?>"><?= $i; ?></a>
    <?php endif; ?>
<?php endfor; ?>

<?php if( $halamanAktif < $jumlahHalaman) :?>
<a href="?halaman=<?= $halamanAktif + 1 ?>"> &raquo; </a> <!-- kalo gt tanda panah 1 || kalo raquo tanda panah 2-->
<?php endif; ?>
</br>
    <table border="1" cellpadding="10" cellspacing="0">
        
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Namar</th>
            <th>NISN</th>
            <th>Gambar</th>
            <th>Email</th>
        </tr>
        <?php  foreach ($siswa as $row) :        ?>
        <tr>
            <td><?= ++$no; ?></td>
            <td>
                <a href="ubah.php?id_siswa=<?= $row["id_siswa"]; ?> " onclick=
                return confirm('Yakin?')">Ubah</a> | 
                <a href="control_hapus.php?id_siswa=<?= $row["id_siswa"]; ?> " onclick="
                return confirm('Yakin?')">Hapus</a>
            </td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["nisn"]; ?></td>
            <td>
                <img src="img/<?=  $row["gambar"]; ?>" width="60">
            </td>
           
        </tr>
        <?php $i++; ?>
            <?php
            endforeach;
            ?>

</table>
</body>
</html>