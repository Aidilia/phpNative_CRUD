<?php
require 'connection.php';
if(isset($_POST["register"])){
    if(registrasi($_POST)>0){
        echo " <script>
            alert('User baru berhasil ditambahakan!');
            document.location.href = 'index.php';
        </script>";
    }else{
        echo mysqli_error($koneksi);
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label{
            display: block
        }
    </style>
</head>
<body>
    <center>
    <h1>Halaman Registrasi</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username"> Username : </label>
                <input type="text" name="username" id="username" required>
            </li>
            <li>
                <label for="password"> Password : </label>
                <input type="password" name="password" id="password" required>
            </li>
            <li>
                <label for="password2"> Confirm Password : </label>
                <input type="password" name="password2" id="password2" required>
            </li>
            <li>
                <button type="submit" name="register" > Registrasi! </button>
            </li>
        </ul>
    </center>
    </form>
</body>
</html>