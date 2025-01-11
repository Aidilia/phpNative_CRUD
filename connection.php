<?php
//namahost,username,password,namadatabase
$koneksi = mysqli_connect("localhost","root","","sekolah");

function query($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows=[];

    while ($row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data){
    global $koneksi;

    $nama   = htmlspecialchars($data["nama"]);
    $nisn   = htmlspecialchars($data["nisn"]);
    //$gambar = htmlspecialchars($data["gambar"]);
   
    //upload gambar 
    $gambar = upload();

    if(!$gambar){
        return false;
    }

    $email  = htmlspecialchars($data["email"]);

    $query = "INSERT INTO siswa VALUES (null,'$nama','$nisn','$email','$gambar')";

    if(mysqli_query($koneksi,$query)){
        return mysqli_affected_rows($koneksi);
    }else{
        echo "Error: " . mysqli_error($koneksi);
        return false;
    };
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    #cek apakah tidak ada gambar yg diupload
    if( $error !== 0){
        echo "<script>
                alert('Error Uploading');
            </script>";

            return false;
    }

    //cek apakah yg diupload adalah gambar
    $ekstensiFile = ['jpg','jpeg','png' ];
    //explode fungsi untuk memecah sebuah string menjadi array
    $ekstensiGmbr = explode('.', $namaFile);
    //contoh aidilia.jpg menjadi ['aidilia', 'jpg']
    //end itu untuk mengambil nama file yg diakhir
    //strtolower untuk mengubah tulisan akhir menjadi tulisan kecil
    $ekstensiGmbr = strtolower(end($ekstensiGmbr));

    if( in_array($ekstensiGmbr, $ekstensiFile) === true){
        if($ukuranFile<1000000){
           
            move_uploaded_file($tmpName, 'img/'.$namaFile);
            return $namaFile;
        
        }else{echo "<script>
            alert('ukuran gambar terlalu besar!');
        </script>";
        }
    } else {
        echo "<script>
        alert('yang anda upload bukan gambar!');
        </script>";
    }
}

function control_hapus($id_siswa){
    global $koneksi;

    $query = "DELETE FROM siswa WHERE id_siswa = '$id_siswa';";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function ubah($data){
    global $koneksi;

    $id_siswa = $data["id_siswa"];
    $nama   = htmlspecialchars($data["nama"]);
    $nisn   = htmlspecialchars($data["nisn"]);
    $gambar = htmlspecialchars($data["gambar"]);
    $email  = htmlspecialchars($data["email"]);

    $query = "UPDATE siswa SET 
                nama = '$nama',
                nisn = '$nisn',
                gambar = '$gambar',
                email = '$email'
                WHERE id_siswa = '$id_siswa'
            ";

    mysqli_query($koneksi,$query);

    return mysqli_affected_rows($koneksi);
}

function cari($keyword){
    global $koneksi;

    $query = "SELECT * FROM siswa
                WHERE
                nama LIKE '%$keyword%' OR
                nisn LIKE '%$keyword%' OR
                email LIKE '%$keyword%'
            ";

    return query($query);
}

function registrasi($data){
    global $koneksi;
    //membersihkan username karakter tertentu (misalnya slash)
    //username menjadi huruf kecil strtolower

    $username = strtolower(stripslashes($data["username"]));

    //cek username yang sudah ada
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_row($result)){
        echo "<script>
            alert('username sudah terdaftar!')
        </script>";
    }
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
    
    //cek konfirmasi password
    if( $password !== $password2 ){
        echo "<script>
            alert('konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }
    //enkirpsi password MD5 (sangat mudah ditebak)
    //$password = md5($password);
   $password = password_hash($password, PASSWORD_DEFAULT);
   // var_dump($password);

    //tambahkan user baru ke database
    $query = "INSERT INTO user VALUES (null, '$username','$password')";
    mysqli_query($koneksi, $query);
}
?>