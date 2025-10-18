<?php
include 'koneksi.php';

$nama = $_POST['nama_mahasiswa'];
$jurusan = $_POST['jurusan_mahasiswa'];
$umur = $_POST['umur_mahasiswa'];

$query = "INSERT INTO mahasiswa (nama_mahasiswa, jurusan_mahasiswa, umur_mahasiswa) 
          VALUES ('$nama', '$jurusan', '$umur')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil disimpan!'); window.location='index.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>