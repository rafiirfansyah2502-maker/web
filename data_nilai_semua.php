<?php
session_start(); 
// mulai session biar bisa akses data login user

// cek apakah user sudah login
if(!isset($_SESSION['login'])){
    header("Location: login.php"); 
    // kalau belum login, paksa balik ke halaman login
    exit; 
    // berhentiin script
}

include 'koneksi.php'; 
// koneksi ke database biar bisa ambil data nilai
?>

<?php
// query ambil data nilai + join ke tabel lain
$data = mysqli_query($koneksi, "
select 
    s.nama, /* ambil nama siswa */
    m.nama_mapel, /* ambil nama mapel */
    g.nama_guru, /* ambil nama guru */
    n.tugas, /* nilai tugas */
    n.uts, /* nilai uts */
    n.uas, /* nilai uas */
    n.rata_rata /* nilai akhir */
from nilai n
join siswa s on n.id_siswa = s.id_siswa 
// nyambungin nilai ke data siswa

join mapel m on n.id_mapel = m.id_mapel 
// nyambungin nilai ke mapel

join guru g on m.id_guru = g.id_guru 
// nyambungin mapel ke guru

order by s.nama asc 
// urutin berdasarkan nama siswa
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>data nilai semua siswa</title>
    <!-- judul halaman di tab browser -->

    <link href="https://fonts.googleapis.com/css2?family=poppins&display=swap" rel="stylesheet">
    <!-- font biar tampilan lebih modern -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- icon library -->

    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- css utama -->

    <link rel="stylesheet" href="rapot_css/data_nilai.css">
    <!-- css khusus halaman nilai -->
</head>

<body>

<?php include 'sidebar.php'; ?> 
<!-- manggil sidebar biar gak bikin manual lagi -->

<div class="main-content"> 
<!-- bagian isi utama halaman -->

    <div class="container"> 
    <!-- pembungkus isi biar rapi -->

        <div class="header"> 
        <!-- bagian judul halaman -->
            <h1>📊 data nilai semua siswa</h1>
            <p>daftar seluruh nilai siswa</p>
        </div>

        <div class="table-wrapper">
        <!-- pembungkus tabel -->

            <table class="modern-table">
            <!-- tabel nilai -->

                <thead>
                    <tr>
                        <th>nama siswa</th>
                        <!-- kolom nama siswa -->

                        <th>mapel</th>
                        <!-- kolom mata pelajaran -->

                        <th>guru</th>
                        <!-- kolom guru -->

                        <th>tugas</th>
                        <!-- nilai tugas -->

                        <th>uts</th>
                        <!-- nilai uts -->

                        <th>uas</th>
                        <!-- nilai uas -->

                        <th>rata-rata</th>
                        <!-- nilai akhir -->
                    </tr>
                </thead>

                <tbody>

                <?php 
                $nama_sebelumnya = ''; 
                // variabel buat ngecek biar nama gak diulang terus

                while($n = mysqli_fetch_assoc($data)){ 
                // looping semua data nilai
                ?>

                    <tr>

                        <td>
                        <?php 
                        // biar nama siswa cuma muncul sekali per kelompok
                        if($nama_sebelumnya != $n['nama']){
                            echo $n['nama']; 
                            // tampilkan nama siswa
                            $nama_sebelumnya = $n['nama']; 
                            // simpan nama terakhir
                        }
                        ?>
                        </td>

                        <td><?= $n['nama_mapel'] ?></td>
                        <!-- tampilkan mapel -->

                        <td><?= $n['nama_guru'] ?></td>
                        <!-- tampilkan guru -->

                        <td><?= $n['tugas'] ?></td>
                        <!-- nilai tugas -->

                        <td><?= $n['uts'] ?></td>
                        <!-- nilai uts -->

                        <td><?= $n['uas'] ?></td>
                        <!-- nilai uas -->

                        <td class="<?= ($n['rata_rata'] < 75) ? 'nilai-merah' : '' ?>">
                        <!-- nilai di bawah 75 merah -->

                            <?= round($n['rata_rata']) ?>
                            <!-- tampil nilai bulatkan -->
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