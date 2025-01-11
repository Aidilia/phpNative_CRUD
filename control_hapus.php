<?php
session_start();

if ( !isset($_SESSION["login"])){
    header(("Location: login.php"));
    exit;
}

require 'connection.php';

$id_siswa = $_GET["id_siswa"];

if(control_hapus($id_siswa) > 0){
       echo " <script>
            alert('Data berhasil dihapuskan!');
            document.location.href = 'index.php';
        </script>";
} else {
        echo " <script>
        alert('Data gagal dihapuskan!');
        document.location.href = 'index.php';
    </script>";
}

?>