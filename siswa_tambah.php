<?php
session_start();

// cek login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<?php
include 'koneksi.php';

// ambil data kelas buat dropdown
$kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
<!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS UTAMA (SIDEBAR + LAYOUT) -->
    <link rel="stylesheet" href="rapot_css/utama.css">

    <!-- CSS KHUSUS DATA SISWA -->
    <link rel="stylesheet" href="rapot_css/data_siswa.css">
    <!-- CSS -->
    <link rel="stylesheet" href="rapot_css/siswa_tambah.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <center><h2><i class="fa-solid fa-book"></i> E-Raport</h2></center>

    <div class="user-box">
        <p><?= $_SESSION['user'] ?></p>
        <span class="role-badge <?= $_SESSION['role'] ?>">
            <?= $_SESSION['role'] ?>
        </span>
    </div>

    <a href="utama.php">
        <i class="fa-solid fa-house"></i> Dashboard
    </a>

    <?php if($_SESSION['role'] == 'admin'){ ?>
    <a href="data_siswa.php" class="active">
        <i class="fa-solid fa-users"></i> Data Siswa
    </a>
    <?php } ?>

    <a href="input.php">
        <i class="fa-solid fa-pen"></i> Input Nilai
    </a>

    <a href="data_nilai_semua.php">
        <i class="fa-solid fa-table"></i> Data Nilai
    </a>

    <a href="absensi.php">
        <i class="fa-solid fa-calendar-check"></i> Absensi
    </a>

    <a href="pilih_cetak_siswa.php">
        <i class="fa-solid fa-file-pdf"></i> Cetak Rapor
    </a>

    <a href="logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

</div>

<div class="container">

    <!-- ================================
         HEADER
    ================================= -->
    <div class="header">
        <h1>Tambah Siswa</h1>
        <p>Masukkan data siswa baru</p>
    </div>

    
       <!--  FORM CARD -->
    <div class="form-card">

        <form action="simpan_siswa.php" method="post">

            <!-- NIS -->
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" required>
            </div>

            <!-- NAMA -->
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" required>
            </div>

            <!-- KELAS -->
            <div class="form-group">
                <label>Kelas</label>
                <select name="id_kelas" required>
                    <option value="">-- Pilih Kelas --</option>

                    <?php while($k = mysqli_fetch_assoc($kelas)) { ?>
                        <option value="<?= $k['id_kelas']; ?>">
                            <?= $k['nama_kelas']; ?>
                        </option>
                    <?php } ?>

                </select>
            </div>

            <!-- BUTTON -->
            <div class="form-action">
                <button type="submit" class="btn">Simpan</button>
               
            </div>

        </form>

    </div>

</div>

</body>
</html>