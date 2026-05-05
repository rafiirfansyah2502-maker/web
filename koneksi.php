<?php
$koneksi = mysqli_connect("localhost", "root", "", "eraport_xi_rpl");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}