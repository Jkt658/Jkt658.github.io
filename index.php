<?php
// Ambil data yang dikirimkan dari formulir
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Lakukan validasi data (misalnya, cek apakah email sudah terdaftar)
// Simpan data ke database (jika diperlukan)

// Redirect ke halaman login atau halaman sukses
header("Location: login.php");
exit;
?>