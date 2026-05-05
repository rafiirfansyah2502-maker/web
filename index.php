<?php
include 'koneksi.php';

// Ambil semua siswa XI RPL 1
$data = mysqli_query($koneksi,"
    SELECT * FROM siswa
    WHERE id_kelas = 1
    ORDER BY nama
");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Siswa - E-Raport Ultra Premium</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome untuk icon PDF -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS khusus ultra premium -->
    <link rel="stylesheet" href="rapot_css/style.css">
</head>
<body>

<div class="container my-5">

    <!-- Judul halaman -->
    <h1 class="text-center mb-5 page-title">DAFTAR SISWA XI RPL 1</h1>

    <!-- Grid card siswa -->
    <div class="row">
        <?php while($s = mysqli_fetch_assoc($data)) { ?>
            <div class="col-lg-4 col-md-6 mb-4 student-card-wrapper">
                <div class="card shadow student-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $s['nama'] ?></h5>
                        <p class="card-text"><strong>NIS:</strong> <?= $s['nis'] ?></p>
                        <p class="card-text"><strong>Kelas:</strong> XI RPL 1</p>
                        <a href="cetak.php?id_siswa=<?= $s['id_siswa'] ?>" target="_blank" class="btn btn-primary btn-block btn-cetak">
                            <i class="fa-solid fa-file-pdf"></i> Cetak Rapor
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>