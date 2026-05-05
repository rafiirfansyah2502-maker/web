<!-- SIDEBAR -->
 <link rel="stylesheet" href="rapot_css/utama.css">
<div class="sidebar"> <!-- pembungkus menu kiri -->

    <h2><i class="fa-solid fa-book"></i> E-Raport</h2>
    <!-- judul + icon buku -->

    <!-- USER INFO -->
    <div class="user-box"> <!-- box buat info user -->
        <p><?= $_SESSION['user'] ?></p>
        <!-- nampilin nama user yang login -->

        <!-- badge role -->
        <span class="role-badge <?= $_SESSION['role'] ?>">
            <?= $_SESSION['role'] ?>
        </span>
        <!-- badge role (admin/guru), class ikut role biar beda warna -->
    </div>

    <!-- MENU DASHBOARD -->
    <a href="utama.php" class="active">
        <i class="fa-solid fa-house"></i> Dashboard
    </a>
    <!-- menu dashboard + icon rumah, class active = tanda lagi dibuka -->

    <?php if($_SESSION['role'] == 'admin'){ ?> 
    <!-- cek kalo yang login admin -->

    <a href="data_siswa.php">
        <i class="fa-solid fa-users"></i> Data Siswa
    </a>
    <!-- menu data siswa cuma muncul buat admin -->

    <?php } ?> 
    <!-- penutup kondisi -->

    <!-- INPUT NILAI -->
    <a href="input.php">
        <i class="fa-solid fa-pen"></i> Input Nilai
    </a>
    <!-- ke halaman input nilai -->

    <!-- DATA NILAI -->
    <a href="data_nilai_semua.php">
        <i class="fa-solid fa-table"></i> Data Nilai
    </a>
    <!-- ke halaman lihat semua nilai -->

    <!-- ABSENSI -->
    <a href="absensi.php">
        <i class="fa-solid fa-calendar-check"></i> Absensi
    </a>
    <!-- ke halaman absensi -->

    <!-- CETAK RAPOR -->
    <a href="pilih_cetak_siswa.php">
        <i class="fa-solid fa-file-pdf"></i> Cetak Rapor
    </a>
    <!-- ke halaman cetak rapor -->

    <!-- LOGOUT -->
    <a href="logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
    <!-- keluar dari sistem -->

</div>