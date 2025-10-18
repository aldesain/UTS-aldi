<?php
include 'koneksi.php';

// Cek apakah ID dikirim lewat URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    // Jika data tidak ditemukan, kembali ke index
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }

    $data = mysqli_fetch_assoc($result);
} else {
    header("Location: index.php");
    exit;
}

// Update data ke database
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $jurusan_id = $_POST['jurusan_id'];
    $umur = $_POST['umur'];

    $update = "UPDATE mahasiswa SET nama='$nama', jurusan_id='$jurusan_id', umur='$umur' WHERE id='$id'";
    $hasil = mysqli_query($koneksi, $update);

    if ($hasil) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Mahasiswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex justify-center items-center p-8">

  <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl w-full max-w-md p-8">
    <h1 class="text-2xl font-bold text-white mb-6 text-center">✏️ Edit Data Mahasiswa</h1>

    <form method="POST" class="space-y-5">
      <!-- Nama -->
      <div>
        <label class="block font-semibold mb-2 text-gray-300">Nama Mahasiswa</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required
               class="w-full bg-gray-700 text-gray-100 border border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition">
      </div>

      <!-- Jurusan -->
      <div>
        <label class="block font-semibold mb-2 text-gray-300">Jurusan</label>
        <select name="jurusan_id" required
                class="w-full bg-gray-700 text-gray-100 border border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition">
          <option value="">-- Pilih Jurusan --</option>
          <?php
          $jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
          while ($row = mysqli_fetch_assoc($jurusan)) {
              $selected = ($row['id'] == $data['jurusan_id']) ? 'selected' : '';
              echo "<option value='{$row['id']}' $selected>{$row['nama']}</option>";
          }
          ?>
        </select>
      </div>

      <!-- Umur -->
      <div>
        <label class="block font-semibold mb-2 text-gray-300">Umur</label>
        <input type="number" name="umur" value="<?= htmlspecialchars($data['umur']); ?>" required
               class="w-full bg-gray-700 text-gray-100 border border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition">
      </div>

      <!-- Tombol -->
      <div class="flex justify-between items-center mt-6">
        <a href="index.php" class="text-gray-400 hover:text-indigo-400 transition">← Kembali</a>
        <button type="submit" name="update"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold shadow transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

</body>
</html>
