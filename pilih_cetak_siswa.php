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

$data = mysqli_query($koneksi, "SELECT * FROM siswa"); 
// ambil semua data siswa dari tabel "siswa"
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pilih Siswa</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="rapot_css/utama.css">
    <link rel="stylesheet" href="rapot_css/pilih_cetak_siswa.css">
</head>

<body>

    <!-- SIDEBAR -->
    <?php include 'sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="container">

            <!-- HEADER -->
            <div class="header">
                <h1>📄 Pilih Siswa</h1>
                <p>Cetak raport siswa</p>
            </div>

            <!-- TABEL -->
            <div class="table-wrapper">

                <table class="modern-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                $no = 1;
                while($s = mysqli_fetch_assoc($data)) { 
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $s['nis'] ?></td>
                            <td><?= $s['nama'] ?></td>

                            <td>
                                <center><a href="cetak.php?id_siswa=<?= $s['id_siswa'] ?>" class="btn">
                                        Cetak
                             </a></center>
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