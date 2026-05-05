<?php
session_start(); // mulai session data login bisa disemua halaman

if(!isset($_SESSION['login'])){ // cek apakah user sudah login atau belum
    header("Location: login.php"); // kalau belum login, lempar ke login.php
    exit; // stop script biar gak lanjut jalan
}
?>

<?php
include 'koneksi.php'; // konek ke database

if(isset($_POST['simpan'])){ // cek tombol simpan ditekan

    $id_siswa = $_POST['id_siswa']; // ambil id siswa dari form
    $sakit = $_POST['sakit']; // ambil jumlah sakit
    $izin = $_POST['izin']; // ambil jumlah izin
    $alpha = $_POST['alpha']; // ambil jumlah alpha

    $cek = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_siswa='$id_siswa'");
    // cek apakah siswa ini sudah punya data absensi di database

    if(mysqli_num_rows($cek) > 0){ 
        // kalau data sudah ada

        mysqli_query($koneksi, "
            UPDATE absensi 
            SET sakit='$sakit', izin='$izin', alpha='$alpha'
            WHERE id_siswa='$id_siswa'
        ");
        // update data absensi lama

    } else { 
        // kalau data belum ada

        mysqli_query($koneksi, "
            INSERT INTO absensi (id_siswa, sakit, izin, alpha)
            VALUES ('$id_siswa','$sakit','$izin','$alpha')
        ");
        // masukin data baru ke database
    }

    header("Location: absensi.php?pesan=berhasil"); // redirect ke halaman absensi + notif
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi Siswa</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- font Poppins dari google font -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- ambil icon dari font awesome -->

    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- file css utama -->

    <link rel="stylesheet" href="rapot_css/absensi.css">
    <!-- file css khusus absensi -->
</head>

<body>

<?php include 'sidebar.php'; ?> 
<!-- sidebar menu -->

<div class="main-content"> 
<!-- bagian isi utama halaman -->

    <div class="container"> 
    <!-- pembungkus konten -->

        <div class="header"> 
        <!-- bagian header -->
            <h1>📅 Absensi Siswa</h1> 
            <p>Kelola data kehadiran siswa</p>
        </div>

        <?php if(isset($_GET['pesan'])){ ?> 
        <!-- cek kalau ada parameter pesan dari URL -->
            <div class="alert-success">
                Data berhasil disimpan!
            </div>
        <?php } ?>

        <div class="card-form"> 
        <!-- card untuk form input -->

            <h2>Input Absensi</h2> 

            <form method="POST"> 
            <!-- form kirim data pakai POST -->

                <label>Nama Siswa</label> 
                <!-- label dropdown siswa -->

                <select name="id_siswa" required> 
                <!-- dropdown pilih siswa -->
                    <option value="">-- Pilih Siswa --</option>

                    <?php
                    $siswa = mysqli_query($koneksi,"SELECT * FROM siswa");
                    // ambil semua data siswa dari database

                    while($s = mysqli_fetch_assoc($siswa)){
                    // looping data siswa
                    ?>
                        <option value="<?= $s['id_siswa'] ?>">
                            <?= $s['nama'] ?>
                        </option>
                    <?php } ?>

                </select>

                <label>Sakit</label> 
                <input type="number" name="sakit" required>
                <!-- input jumlah sakit -->

                <label>Izin</label>
                <input type="number" name="izin" required>
                <!-- input jumlah izin -->

                <label>Alpha</label>
                <input type="number" name="alpha" required>
                <!-- input jumlah alpha -->

                <div class="form-action">
                    <button type="submit" name="simpan" class="btn">
                        Simpan
                    </button>
                    <!-- tombol untuk submit data -->
                </div>

            </form>

        </div>

        <div class="table-wrapper" style="margin-top:20px;">
        <!-- wrapper tabel data -->

            <h2>Data Absensi</h2>

            <table class="modern-table">
            <!-- tabel data absensi -->

                <thead>
                    <tr>
                        <th>No</th>  
                        <th>Nama</th> 
                        <th>Sakit</th> 
                        <th>Izin</th> 
                        <th>Alpha</th> 
                        <th>Aksi</th> 
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1; 
                // nomor urut awal

                $data = mysqli_query($koneksi,"
                    SELECT a.*, s.nama 
                    FROM absensi a
                    JOIN siswa s ON a.id_siswa = s.id_siswa
                ");
                // join tabel absensi dan siswa biar dapet nama

                while($d = mysqli_fetch_assoc($data)){
                // looping data absensi
                ?>

                    <tr>
                        <td><?= $no++ ?></td> <!-- nomor urut -->
                        <td><?= $d['nama'] ?></td> <!-- nama siswa -->
                        <td><?= $d['sakit'] ?></td> <!-- data sakit -->
                        <td><?= $d['izin'] ?></td> <!-- data izin -->
                        <td><?= $d['alpha'] ?></td> <!-- data alpha -->

                        <td>
                            <a href="edit_absen.php?id=<?= $d['id_absensi'] ?>" class="btn-edit">
                                Edit
                            </a>
                            <!-- tombol edit data -->

                            <a href="hapus_absen.php?id=<?= $d['id_absensi'] ?>" 
                               onclick="return confirm('Yakin mau hapus?')" 
                               class="btn-delete">
                               Hapus
                            </a>
                            <!-- tombol hapus-->
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