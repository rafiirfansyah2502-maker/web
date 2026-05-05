<?php
session_start(); 
// mulai session biar bisa cek login user

include 'koneksi.php'; 
// koneksi ke database mysql biar bisa ambil & update data

$id = $_GET['id'] ?? ''; 
// ambil id nilai dari url (?id=...), kalau kosong jadi string kosong

// ambil data nilai berdasarkan id
$data = mysqli_query($koneksi, "select * from nilai where id_nilai='$id'");
// query buat ambil data nilai dari database

$n = mysqli_fetch_assoc($data); 
// ubah hasil query jadi array biar gampang dipakai di form

// cek kalau tombol simpan ditekan
if(isset($_POST['simpan'])){

    $tugas = $_POST['tugas']; 
    // ambil input nilai tugas dari form

    $uts = $_POST['uts']; 
    // ambil input nilai uts

    $uas = $_POST['uas']; 
    // ambil input nilai uas

    // hitung rata-rata nilai
    $rata = ($tugas + $uts + $uas) / 3; 
    // rumus sederhana buat cari nilai akhir

    // update data ke database
    mysqli_query($koneksi, "
        update nilai set
        tugas='$tugas', 
        uts='$uts', 
        uas='$uas', 
        rata_rata='$rata'
        where id_nilai='$id'
    ");

    // setelah update, balik ke halaman data nilai siswa
    header("Location: data_nilai.php?id_siswa=".$n['id_siswa']); 
    // kirim id siswa biar balik ke halaman yang benar
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>edit nilai</title>
    <!-- judul tab browser -->

    <link href="https://fonts.googleapis.com/css2?family=poppins&display=swap" rel="stylesheet">
    <!-- font biar lebih modern -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- icon library -->

    <link rel="stylesheet" href="rapot_css/utama.css">
    <!-- css utama -->

    <link rel="stylesheet" href="rapot_css/edit_nilai.css">
    <!-- css khusus halaman edit nilai -->
</head>

<body>

<?php include 'sidebar.php'; ?> 
// panggil sidebar biar konsisten

<div class="main-content"> 
// bagian isi utama halaman

    <div class="container"> 
    // pembungkus konten biar rapi

        <div class="header"> 
        // header halaman
            <h1>✏️ edit nilai</h1>
            <p>perbarui nilai siswa</p>
        </div>

        <div class="card-form"> 
        // card form putih

            <form method="POST"> 
            // form kirim data pakai POST

                <label>tugas</label>
                // label input tugas

                <input type="number" name="tugas" value="<?= $n['tugas'] ?>" required>
                // input tugas + isi otomatis dari database

                <label>uts</label>
                // label uts

                <input type="number" name="uts" value="<?= $n['uts'] ?>" required>
                // input uts + data lama

                <label>uas</label>
                // label uas

                <input type="number" name="uas" value="<?= $n['uas'] ?>" required>
                // input uas + data lama

                <div class="form-action">
                // bagian tombol

                    <a href="data_nilai.php?id_siswa=<?= $n['id_siswa'] ?>" class="btn-secondary">
                        ← kembali
                    </a>
                    // tombol balik tanpa simpan

                    <button type="submit" name="simpan" class="btn">
                        simpan
                    </button>
                    // tombol update data

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>