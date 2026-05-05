<?php
session_start(); 
// mulai session biar bisa cek user login

if(!isset($_SESSION['login'])){
    // kalau user belum login
    header("Location: login.php"); 
    // arahkan ke halaman login
    exit; 
    // stop script biar gak lanjut
}

include 'koneksi.php'; 
// koneksi ke database mysql

// ambil id siswa dari url (?id_siswa=...)
$id = $_GET['id_siswa'] ?? ''; 
// kalau tidak ada id, isi kosong biar aman

if($id == ''){
    die('pilih siswa dulu bro'); 
    // kalau tidak ada id, program langsung berhenti
}

// ambil data siswa berdasarkan id
$siswa = mysqli_query($koneksi,"SELECT * FROM siswa WHERE id_siswa='$id'");

// ubah hasil query jadi array
$s = mysqli_fetch_assoc($siswa);

// ambil data nilai + join mapel + guru
$data = mysqli_query($koneksi,"
select 
    n.*, 
    m.nama_mapel, 
    g.nama_guru
from nilai n
join mapel m on n.id_mapel = m.id_mapel 
// nyambung nilai ke mapel

join guru g on m.id_guru = g.id_guru 
// nyambung mapel ke guru

where n.id_siswa = '$id' 
// cuma ambil data sesuai siswa yang dipilih

order by m.nama_mapel asc 
// urutin mapel dari a-z
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>data nilai</title>
    <!-- judul tab browser -->

    <link href="https://fonts.googleapis.com/css2?family=poppins&display=swap" rel="stylesheet">
    <!-- font biar lebih modern -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- icon library -->

    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- css utama -->

    <link rel="stylesheet" href="rapot_css/data_nilai.css">
    <!-- css khusus halaman nilai -->
</head>

<body>

<?php include 'sidebar.php'; ?> 
// panggil sidebar biar gak bikin manual lagi

<div class="main-content"> 
// bagian isi utama halaman

    <div class="container"> 
    // pembungkus konten

        <div class="header"> 
        // header halaman
            <h1>📊 data nilai</h1>
            <p>detail nilai siswa</p>
        </div>

        <p class="info">
            nama : <b><?= $s['nama'] ?></b>
        </p>
        // tampilkan nama siswa yang dipilih

        <div class="table-wrapper">
        // pembungkus tabel

            <table class="modern-table">
            // tabel data nilai

                <thead>
                    <tr>
                        <th>no</th>
                        // nomor urut

                        <th>mata pelajaran</th>
                        // nama mapel

                        <th>guru</th>
                        // nama guru

                        <th>tugas</th>
                        // nilai tugas

                        <th>uts</th>
                        // nilai uts

                        <th>uas</th>
                        // nilai uas

                        <th>rata-rata</th>
                        // nilai akhir

                        <th>aksi</th>
                        // tombol edit hapus
                    </tr>
                </thead>

                <tbody>

                <?php 
                $no = 1; 
                // nomor urut dari 1

                while($n = mysqli_fetch_assoc($data)){ 
                // looping semua data nilai siswa
                ?>

                    <tr>

                        <td><?= $no++ ?></td>
                        // tampilkan nomor urut

                        <td><?= $n['nama_mapel'] ?></td>
                        // tampilkan mapel

                        <td><?= $n['nama_guru'] ?></td>
                        // tampilkan guru

                        <td><?= $n['tugas'] ?></td>
                        // nilai tugas

                        <td><?= $n['uts'] ?></td>
                        // nilai uts

                        <td><?= $n['uas'] ?></td>
                        // nilai uas

                        <td class="<?= ($n['rata_rata'] < 75) ? 'nilai-merah' : '' ?>">
                        // kalau nilai di bawah 75 kasih warna merah

                            <?= round($n['rata_rata']) ?>
                            // tampilkan nilai dibulatkan
                        </td>

                        <td>
                            <a href="edit_nilai.php?id=<?= $n['id_nilai'] ?>" class="btn-edit">
                                edit
                            </a>
                            // tombol edit nilai

                            <a href="hapus_nilai.php?id=<?= $n['id_nilai'] ?>" 
                               onclick="return confirm('yakin mau hapus?')" 
                               class="btn-delete">
                                hapus
                            </a>
                            // tombol hapus + konfirmasi
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <div class="top-action">
            <a href="data_siswa.php" class="btn-secondary">← kembali</a>
        </div>
        // tombol balik ke halaman siswa

    </div>

</div>

</body>
</html>