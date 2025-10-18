<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-slate-900 to-gray-800 text-gray-100 min-h-screen p-8">

    <div class="max-w-5xl mx-auto bg-gray-800/80 backdrop-blur-xl border border-gray-700 rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-blue-500 bg-clip-text text-transparent">
                📘 Data Mahasiswa
            </h1>
            <a href="tambah.php" 
               class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500
                      hover:from-indigo-400 hover:via-blue-500 hover:to-purple-400
                      text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg
                      hover:shadow-blue-500/40 transition duration-300 transform hover:-translate-y-0.5">
               + Tambah Data
            </a>
        </div>

        <!-- Notifikasi -->
        <?php if (isset($_GET['pesan'])): ?>
            <div class="mb-4 p-3 rounded-lg text-center font-medium
                <?= $_GET['pesan'] === 'sukses' 
                    ? 'bg-green-900/40 text-green-300 border border-green-700' 
                    : 'bg-red-900/40 text-red-300 border border-red-700' ?>">
                <?= $_GET['pesan'] === 'sukses' ? '✅ Data berhasil disimpan!' : '❌ Terjadi kesalahan!' ?>
            </div>
        <?php endif; ?>

        <!-- Tabel -->
        <div class="overflow-hidden rounded-xl border border-gray-700 shadow-lg">
            <table class="w-full text-sm text-gray-300">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-gray-100 uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4 text-left">Jurusan</th>
                        <th class="py-3 px-4 text-left">Umur</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php
                    // Coba ambil data dengan join jurusan
                    $query = "SELECT m.id, m.nama, m.umur, j.nama AS jurusan 
                              FROM mahasiswa m 
                              JOIN jurusan j ON m.jurusan_id = j.id
                              ORDER BY m.id ASC";

                    $result = mysqli_query($koneksi, $query);

                    // Jika query gagal (biasanya karena tabel jurusan belum ada), fallback ke tabel mahasiswa saja
                    if (!$result) {
                        $fallbackQuery = "SELECT id, nama, umur, jurusan FROM mahasiswa ORDER BY id ASC";
                        $result = mysqli_query($koneksi, $fallbackQuery);
                    }

                    // Jika tetap gagal, tampilkan pesan error
                    if (!$result) {
                        echo "<tr><td colspan='5' class='text-center py-5 text-red-400'>
                            ⚠️ Terjadi kesalahan query: " . htmlspecialchars(mysqli_error($koneksi)) . "
                        </td></tr>";
                    } else {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $jurusan = isset($row['jurusan']) ? $row['jurusan'] : '-';
                                echo "
                                <tr class='hover:bg-gray-700/40 transition-all duration-200'>
                                    <td class='py-3 px-4'>{$row['id']}</td>
                                    <td class='py-3 px-4'>{$row['nama']}</td>
                                    <td class='py-3 px-4'>{$jurusan}</td>
                                    <td class='py-3 px-4'>{$row['umur']}</td>
                                    <td class='py-3 px-4 text-center'>
                                        <a href=\"edit.php?id={$row['id']}\" 
                                           class=\"text-indigo-400 hover:text-indigo-300 font-semibold transition\">Edit</a>
                                        <span class=\"text-gray-500 mx-1\">|</span>
                                        <a href=\"hapus.php?id={$row['id']}\" 
                                           onclick=\"return confirm('Yakin mau dihapus nih serius? 🥺')\" 
                                           class=\"text-red-400 hover:text-red-300 font-semibold transition\">Hapus</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-5 text-gray-500'>
                                    Belum ada data mahasiswa 💤
                                  </td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-400 text-sm">
            <p>© <?= date('Y'); ?> UTS Pemrograman Web 3 | by 
                <span class="font-semibold text-indigo-400">Muhamad Rifaldi</span>
            </p>
        </div>
    </div>

</body>
</html>
