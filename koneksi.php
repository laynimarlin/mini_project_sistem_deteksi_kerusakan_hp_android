<?php

$conn = mysqli_connect("localhost", "root", "", "diagnosa_hp");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>