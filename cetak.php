<?php
session_start(); 
// mulai session biar bisa cek login user

if(!isset($_SESSION['login'])){
    // kalau user belum login
    header("Location: login.php");
    // paksa balik ke login
    exit; 
    // stop script
}
?>

<?php
require('fpdf184/fpdf.php'); 
// panggil library FPDF (buat bikin file PDF)

include 'koneksi.php'; 
// koneksi ke database 

// ambil id siswa dari URL (?id_siswa=...)
$id = $_GET['id_siswa'] ?? ''; 
// kalau kosong, isi jadi string kosong biar aman

if($id==''){
    die('ID ga ada'); 
    // kalau id tidak dikirim, program langsung berhenti
}

// ambil data siswa dari database
$siswa = mysqli_query($koneksi,"SELECT * FROM siswa WHERE id_siswa='$id'");

// ubah hasil query jadi array
$s = mysqli_fetch_assoc($siswa);

// kalau siswa tidak ditemukan
if(!$s){
    die('Data ga ketemu'); 
    // hentikan program
}

// ambil data nilai + join mapel + guru
$nilai = mysqli_query($koneksi,"
SELECT 
    m.nama_mapel, 
    g.nama_guru,
    n.rata_rata
FROM nilai n
JOIN mapel m ON n.id_mapel = m.id_mapel
JOIN guru g ON m.id_guru = g.id_guru
WHERE n.id_siswa='$id'
");

// ambil data absensi siswa
$absen = mysqli_query($koneksi,"
SELECT * FROM absensi WHERE id_siswa='$id'
");

// ambil 1 data absensi
$a = mysqli_fetch_assoc($absen);

// kalau absensi kosong, biar gak error
if(!$a){
    $a = ['sakit'=>0,'izin'=>0,'alpha'=>0];
    // isi default 0
}

// ===== MULAI PDF =====
$pdf = new FPDF('P','mm','A4'); 
// P = potrait, mm = satuan, A4 = ukuran kertas

$pdf->AddPage(); 
// bikin halaman baru

// ===== KOP SEKOLAH =====
$pdf->SetFont('Arial','B',14); 
// font Arial, Bold, ukuran 14

$pdf->Cell(190,7,'SMK NEGERI',0,1,'C'); 
// tulis teks di tengah

$pdf->SetFont('Arial','',10); 
// font biasa ukuran 10

$pdf->Cell(190,6,'Jl. Pendidikan No.1',0,1,'C'); 
// alamat sekolah

$pdf->Ln(2); 
// kasih jarak kosong

$pdf->Line(10,30,200,30); 
// bikin garis horizontal

$pdf->Ln(5); 
// jarak lagi

// ===== judul raport =====
$pdf->SetFont('Arial','B',13);
$pdf->Cell(190,8,'LAPORAN HASIL BELAJAR SISWA',0,1,'C');

$pdf->Ln(3); 
// jarak

// ===== data identitas =====
$pdf->SetFont('Arial','',11);

// baris 1 (nama & kelas)
$pdf->Cell(30,7,'Nama'); 
// label nama
$pdf->Cell(5,7,':'); 
$pdf->Cell(60,7,$s['nama'],0,0); 
// isi nama siswa

$pdf->Cell(30,7,'Kelas'); 
$pdf->Cell(5,7,':'); 
$pdf->Cell(60,7,'XI RPL 1',0,1); 
// isi kelas

// baris 2 (nis & semester)
$pdf->Cell(30,7,'NIS'); 
$pdf->Cell(5,7,':'); 
$pdf->Cell(60,7,$s['nis'],0,0);

$pdf->Cell(30,7,'Semester'); 
$pdf->Cell(5,7,':'); 
$pdf->Cell(60,7,'Genap',0,1);

// baris 3 (tahun ajaran)
$pdf->Cell(30,7,'Tahun Ajaran'); 
$pdf->Cell(5,7,':'); 
$pdf->Cell(60,7,'2024 / 2025',0,1);

$pdf->Ln(5); 
// jarak

// ===== header tabel =====
$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,8,'No',1);
// kolom nomor

$pdf->Cell(60,8,'Mata Pelajaran',1);
// kolom mapel

$pdf->Cell(40,8,'Guru',1);
// kolom guru

$pdf->Cell(20,8,'Nilai',1);
// kolom nilai

$pdf->Cell(60,8,'Deskripsi',1);
// kolom deskripsi

$pdf->Ln(); 
// pindah baris

// ===== isi tabel nilai =====
$pdf->SetFont('Arial','',10);

$no = 1; 
// nomor urut

while($n = mysqli_fetch_assoc($nilai)){
    // looping data nilai

    // kalau nilai di bawah 75 → merah
    if($n['rata_rata'] < 75){
        $pdf->SetTextColor(255,0,0); 
        // teks merah
    } else {
        $pdf->SetTextColor(0,0,0); 
        // teks hitam
    }

    // bikin deskripsi otomatis
    if($n['rata_rata'] >= 85){
        $ket = "Sangat baik, aktif dan paham materi";
    }elseif($n['rata_rata'] >= 75){
        $ket = "Baik, cukup memahami materi";
    }else{
        $ket = "Perlu peningkatan belajar";
    }

    // isi nomor
    $pdf->Cell(10,8,$no++,1);

    // isi mapel
    $pdf->Cell(60,8,$n['nama_mapel'],1);

    // isi nama guru
    $pdf->Cell(40,8,$n['nama_guru'],1);

    // isi nilai
    $pdf->Cell(20,8,$n['rata_rata'],1);

    // reset warna biar deskripsi normal lagi
    $pdf->SetTextColor(0,0,0);

    $pdf->MultiCell(60,8,$ket,1);
}

$pdf->Ln(5); 
// jarak

// ===== data absensi =====
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,7,'Kehadiran',0,1);

$pdf->SetFont('Arial','',10);

// tampilkan sakit
$pdf->Cell(60,6,'Sakit : '.$a['sakit'].' hari',0,1);

// tampilkan izin
$pdf->Cell(60,6,'Izin  : '.$a['izin'].' hari',0,1);

// tampilkan alpha
$pdf->Cell(60,6,'Alpha : '.$a['alpha'].' hari',0,1);

$pdf->Ln(10); 
// jarak bawah

// ===== tanda tangan =====
$pdf->Cell(95,7,'Orang Tua',0,0,'C');
// kolom orang tua

$pdf->Cell(95,7,'Wali Kelas',0,1,'C');
// kolom wali kelas

$pdf->Ln(20); 
// ruang tanda tangan

$pdf->Cell(95,7,'(________)',0,0,'C');
// tanda tangan orang tua

$pdf->Cell(95,7,'(________)',0,1,'C');
// tanda tangan wali kelas

// ===== output pdf =====
$pdf->Output(); 
// tampilkan PDF di browser
?>