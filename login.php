<?php
session_start();
require 'connection.php';

if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil user berdasarkan id
    $query = "SELECT username FROM user WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan user
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] == true;
    }

}

if( isset($_SESSION["login"]) ){
    header("Location: index.php");
    exit;
}


if( isset($_POST["login"]) ){
  
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $query = "SELECT * FROM user 
                WHERE username = '$username' ";

    $result = mysqli_query($koneksi,$query);
  
   //cek username 
   if( mysqli_num_rows($result) === 1){
        
        //cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($password, $row["password"]) ){
            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if( isset($_POST['remember']) ){
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }

            header("Location: index.php");
            exit;
        }
    }
    
    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>
    <center>
    <h1>Halaman Login</h1>

    <?php if(isset($error)):?>
        <p style="color: red; font: Arial"> Username / Password Salah </p>
    <?php endif; ?>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username"> Username : </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password"> Password : </label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember"> Remember Me : </label>
            </li>
            <li>
               <button type="submit" name="login"> Sign In </button>
            </li>
        </ul>
    </form>
    </center>
</body>
</html>