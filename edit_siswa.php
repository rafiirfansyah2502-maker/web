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
// nyambungin ke database (biar bisa ambil data siswa)

// ambil id dari URL (contoh: edit_siswa.php?id=1)
$id = $_GET['id'];

// ambil data siswa berdasarkan id 
$data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'");
$s = mysqli_fetch_assoc($data); 
// ubah jadi array biar gampang dipanggil

// ambil semua data kelas buat dropdown
$kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa</title>

    <!-- CSS buat halaman ini -->
    <link rel="stylesheet" href="rapot_css/edit_siswa.css">

    <!-- font biar ga kaku -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">

    <!-- judul halaman -->
    <h2>Edit Data Siswa</h2>

    <!-- FORM (buat update data) -->
    <form action="update_siswa.php" method="post">

        <!-- id disimpen tapi ga keliatan -->
        <input type="hidden" name="id" value="<?= $s['id_siswa'] ?>">
        <!-- ini penting buat tau data mana yang diupdate -->

        <!-- INPUT NIS -->
        <label>NIS</label>
        <input type="text" name="nis" value="<?= $s['nis'] ?>" required>
        <!-- value diisi dari database (biar ga kosong pas edit) -->

        <!-- INPUT NAMA -->
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $s['nama'] ?>" required>

        <!-- PILIH KELAS -->
        <label>Kelas</label>
        <select name="id_kelas" required>

            <?php while($k = mysqli_fetch_assoc($kelas)) { ?>
            <!-- looping semua data kelas -->

            <option value="<?= $k['id_kelas']; ?>"
                <?= ($k['id_kelas'] == $s['id_kelas']) ? 'selected' : '' ?>>
                <!--  kelas sama → otomatis ke pilih -->

                <?= $k['nama_kelas']; ?>
                <!-- tampil nama kelas -->
            </option>

            <?php } ?>

        </select>

        <!-- tombol sejajar -->
        <div class="form-action">

            <!-- tombol balik ke halaman data siswa -->
            <a href="data_siswa.php" class="btn-back">← Kembali</a>

            <!-- tombol buat update -->
            <button type="submit">Update</button>

        </div>

    </form>

</div>

</body>
</html>