<?php
session_start(); /* mulai session biar bisa ambil data login */

if(!isset($_SESSION['user'])){ /* cek apakah user belum login */
    header("Location: login.php"); /* kalo belum login lempar ke login */
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Judul Halaman</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS UTAMA -->
    <link rel="stylesheet" href="rapot_css/utama.css">
</head>

<body>

    <!-- SIDEBAR -->
    <?php include 'sidebar.php'; ?>
<!-- MAIN CONTENT -->
<div class="main-content">

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h1>📌 E-RAPORT XI RPL B</h1>
            <p>
                Selamat Datang, <b><?= $_SESSION['user']; ?></b> 👋 <br>
                Anda login sebagai 
                <b><?= ucfirst($_SESSION['role']); ?></b>
            </p>
        </div>

        <!-- CARD DASHBOARD (OPSIONAL BIAR GA KOSONG) -->
        <div class="card-form">

            <h2>Dashboard</h2>
            <p>Silakan pilih menu di sidebar untuk mulai mengelola data.</p>

        </div>

    </div>

</div>

</body>

</html>