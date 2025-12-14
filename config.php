<?php
$host = "localhost";
$user = "root";   // default Laragon
$pass = "";       // default Laragon (kosong)
$db   = "parfum_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
?>
