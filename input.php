<?php
session_start(); // mulai session → biar bisa ambil data login (user & role)

// cek login
if(!isset($_SESSION['login'])){ // kalo belum login
    header("Location: login.php"); // lempar ke halaman login
    exit; // hentikan program
}

// koneksi database
include 'koneksi.php'; // panggil file koneksi DB

// ambil data siswa
$siswa = mysqli_query($koneksi, "SELECT * FROM siswa"); 
// query ambil semua data siswa dari database

// ambil data mapel
$mapel = mysqli_query($koneksi, "SELECT * FROM mapel"); 
// query ambil semua data mata pelajaran
?>

<!DOCTYPE html> <!-- HTML5 -->
<html lang="id">
<!-- bahasa indonesia -->

<head>
    <meta charset="UTF-8"> <!-- biar karakter aman -->
    <title>Input Nilai Siswa</title> <!-- judul tab -->

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- ambil font biar tampilan modern -->

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- ambil icon (buat sidebar) -->

    <!-- CSS DASHBOARD -->
    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- css buat sidebar & layout -->

    <!-- CSS FORM -->
    <link rel="stylesheet" href="rapot_css/input.css">
    <!-- css khusus form input -->
</head>

<body>

     <?php include 'sidebar.php'; ?>
    <!-- KONTEN KANAN -->
    <div class="main-content">
        <!-- isi halaman -->

        <!-- HEADER -->
        <div class="header">
            <h1>📚 Input Nilai Siswa</h1>
            <p>Kelola Nilai</p>
        </div>
        <div class="card-form">
            <!-- kotak form -->

            <h2>Input Nilai Siswa</h2> <!-- judul -->

            <!-- FORM -->
            <form action="simpan_nilai.php" method="post">
                <!-- kirim data ke simpan_nilai.php pakai POST -->

                <!-- PILIH SISWA -->
                <label>Siswa</label> <!-- label -->
                <select name="id_siswa" required>
                    <!-- dropdown siswa -->
                    <option value="">-- Pilih Siswa --</option>

                    <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                    <!-- looping data siswa -->

                    <option value="<?= $s['id_siswa']; ?>">
                        <?= $s['nama']; ?>
                        <!-- tampil nama -->
                    </option>

                    <?php } ?>
                </select>

                <!-- PILIH MAPEL -->
                <label>Mata Pelajaran</label>
                <select name="id_mapel" required>
                    <option value="">-- Pilih Mapel --</option>

                    <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
                    <!-- looping mapel -->

                    <option value="<?= $m['id_mapel']; ?>">
                        <?= $m['nama_mapel']; ?>
                    </option>

                    <?php } ?>
                </select>

                <!-- INPUT NILAI -->
                <label>Tugas</label>
                <input type="number" name="tugas" min="0" max="100" required>
                <!-- input nilai tugas -->

                <label>UTS</label>
                <input type="number" name="uts" min="0" max="100" required>
                <!-- input nilai uts -->

                <label>UAS</label>
                <input type="number" name="uas" min="0" max="100" required>
                <!-- input nilai uas -->

                <!-- TOMBOL -->
                <div class="form-action">
                    <!-- pembungkus tombol -->

                    <button type="submit" class="btn-submit">
                        Simpan
                    </button> <!-- kirim data -->

                </div>

            </form>

        </div>

    </div>

</body>

</html>