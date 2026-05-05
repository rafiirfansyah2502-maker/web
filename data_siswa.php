<?php
session_start(); 
// mulai session biar bisa akses data login user

// cek apakah user sudah login
if(!isset($_SESSION['login'])){
    header("Location: login.php"); 
    // kalau belum login, lempar ke halaman login
    exit; 
    // stop script biar gak lanjut
}
?>

<?php
include 'koneksi.php'; 
// koneksi ke database mysql

// ambil data siswa + join ke tabel kelas
$data = mysqli_query($koneksi, "
select siswa.*, kelas.nama_kelas
// ambil semua data siswa + nama kelas

from siswa
// tabel utama siswa

join kelas on siswa.id_kelas = kelas.id_kelas
// nyambungin siswa ke kelas berdasarkan id_kelas
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>data siswa</title>
    <!-- judul tab browser -->

    <link href="https://fonts.googleapis.com/css2?family=poppins&display=swap" rel="stylesheet">
    <!-- font biar lebih modern -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- icon dari font awesome -->

    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- css utama (sidebar + layout) -->

    <link rel="stylesheet" href="rapot_css/data_siswa.css">
    <!-- css khusus halaman data siswa -->
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<!-- bagian menu samping -->

    <center><h2><i class="fa-solid fa-book"></i> e-raport</h2></center>
    <!-- judul aplikasi -->

    <div class="user-box">
        <p><?= $_SESSION['user'] ?></p>
        <!-- nampilin nama user yang login -->

        <span class="role-badge <?= $_SESSION['role'] ?>">
            <?= $_SESSION['role'] ?>
        </span>
        <!-- nampilin role user (admin/guru/dll) -->
    </div>

    <a href="utama.php">
        <i class="fa-solid fa-house"></i> dashboard
    </a>

    <?php if($_SESSION['role'] == 'admin'){ ?>
    <!-- cuma admin yang bisa lihat menu ini -->

    <a href="data_siswa.php" class="active">
        <i class="fa-solid fa-users"></i> data siswa
    </a>

    <?php } ?>

    <a href="input.php">
        <i class="fa-solid fa-pen"></i> input nilai
    </a>

    <a href="data_nilai_semua.php">
        <i class="fa-solid fa-table"></i> data nilai
    </a>

    <a href="absensi.php">
        <i class="fa-solid fa-calendar-check"></i> absensi
    </a>

    <a href="pilih_cetak_siswa.php">
        <i class="fa-solid fa-file-pdf"></i> cetak rapor
    </a>

    <a href="logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> logout
    </a>

</div>

<!-- KONTEN UTAMA -->
<div class="main-content">
<!-- bagian isi utama -->

    <div class="container">
    <!-- pembungkus isi biar rapi -->

        <div class="header">
        <!-- header halaman -->
            <h1>📚 data siswa</h1>
            <p>kelola data siswa</p>
        </div>

        <div class="top-action">
        <!-- tombol aksi di atas tabel -->
            <a href="siswa_tambah.php" class="btn">+ tambah siswa</a>
        </div>

        <div class="table-wrapper">
        <!-- pembungkus tabel -->

            <table class="modern-table">
            <!-- tabel data siswa -->

                <thead>
                    <tr>
                        <th>no</th>
                        <!-- nomor urut -->

                        <th>nis</th>
                        <!-- nomor induk siswa -->

                        <th>nama</th>
                        <!-- nama siswa -->

                        <th>kelas</th>
                        <!-- nama kelas -->

                        <th class="aksi">aksi</th>
                        <!-- tombol edit hapus -->
                    </tr>
                </thead>

                <tbody>

                <?php 
                $no = 1; 
                // nomor urut mulai dari 1

                while($s = mysqli_fetch_assoc($data)) { 
                // looping semua data siswa
                ?>

                    <tr>

                        <td><?= $no++ ?></td>
                        <!-- nomor urut -->

                        <td><?= $s['nis'] ?></td>
                        <!-- tampilkan nis -->

                        <td><?= $s['nama'] ?></td>
                        <!-- tampilkan nama siswa -->

                        <td><?= $s['nama_kelas'] ?></td>
                        <!-- tampilkan nama kelas -->

                        <td class="aksi">
                            <a href="edit_siswa.php?id=<?= $s['id_siswa'] ?>" class="btn-edit">
                                edit
                            </a>
                            <!-- tombol edit siswa -->

                            <a href="hapus_siswa.php?id=<?= $s['id_siswa'] ?>" 
                               class="btn-delete"
                               onclick="return confirm('yakin mau hapus?')">
                                hapus
                            </a>
                            <!-- tombol hapus + konfirmasi -->
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>