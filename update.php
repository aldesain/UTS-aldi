<?php
include 'koneksi.php';

$id = $_POST['id_mahasiswa'];
$nama = $_POST['nama_mahasiswa'];
$jurusan = $_POST['jurusan_mahasiswa'];
$umur = $_POST['umur_mahasiswa'];

$query = "UPDATE mahasiswa SET 
            nama_mahasiswa='$nama', 
            jurusan_mahasiswa='$jurusan', 
            umur_mahasiswa='$umur' 
          WHERE id_mahasiswa='$id'";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>