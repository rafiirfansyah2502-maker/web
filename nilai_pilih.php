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

// ambil siswa
$siswa = mysqli_query($koneksi,"SELECT * FROM siswa ORDER BY nama");

// ambil mapel
$mapel = mysqli_query($koneksi,"SELECT * FROM mapel ORDER BY nama_mapel");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pilih Siswa & Mapel</title>
    <link rel="stylesheet" href="rapot_css/style.css">
</head>
<body>

<div class="container">
    <h2>Masukan Nilai Siswa</h2>

    <form action="input_nilai.php" method="get">
        <!-- Pilih Siswa -->
        <label>Nama Siswa</label>
        <select name="id_siswa" required>
            <option value="">-- Pilih Siswa --</option>
            <?php while($s = mysqli_fetch_assoc($siswa)) { ?>
                <option value="<?= $s['id_siswa'] ?>">
                    <?= $s['nama'] ?>
                </option>
            <?php } ?>
        </select>

        <!-- Pilih Mapel -->
        <label>Mata Pelajaran</label>
        <select name="id_mapel" required>
            <option value="">-- Pilih Mapel --</option>
            <?php while($m = mysqli_fetch_assoc($mapel)) { ?>
                <option value="<?= $m['id_mapel'] ?>">
                    <?= $m['nama_mapel'] ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Lanjut Input Nilai</button>
    </form>
</div>

</body>
</html>
  