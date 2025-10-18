<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $cek = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id='$id'");
    if (mysqli_num_rows($cek) == 0) {
        $status = 'error';
        $pesan = ' Data-nya udah kaga ada kocak';
    } else {
        $hapus = mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id='$id'");

        if ($hapus) {
            // Urutkan ulang ID biar rapi
            mysqli_query($koneksi, "SET @num := 0;");
            mysqli_query($koneksi, "UPDATE mahasiswa SET id = @num := (@num+1) ORDER BY id;");
            mysqli_query($koneksi, "ALTER TABLE mahasiswa AUTO_INCREMENT = 1;");

            $status = 'success';
            $pesan = '🫡 Dah dihapus yeeee~ (ID-nya juga dah auto glow up liat aee 🌸)';
        } else {
            $status = 'error';
            $pesan = '😩 Gagal hapus... mungkin server-nya lagi insecure 💅';
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hapus Data 💀</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      setTimeout(() => {
        Swal.fire({
          title: '<?= $status === "success" ? "✨ CIAOOOOO ✨" : "😵 Hayoooooooo!" ?>',
          html: '<?= $pesan ?>',
          icon: '<?= $status ?>',
          background: '<?= $status === "success" ? "#f0f9ff" : "#fff0f3" ?>',
          color: '#0f172a',
          confirmButtonText: ' Oke gas!',
          confirmButtonColor: '<?= $status === "success" ? "#6366f1" : "#ef4444" ?>',
          showClass: {
            popup: 'animate__animated animate__tada'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOut'
          },
          footer: '<?= $status === "success" ? : "😔 benerin dulu gih" ?>'
        }).then(() => {
          window.location = 'index.php';
        });
      }, 800);
    });
  </script>
</head>
<body style="background: linear-gradient(135deg, #f5f3ff, #e0f2fe); display:flex; justify-content:center; align-items:center; height:100vh; color:#334155; font-family: Poppins, sans-serif;">
  <h2 style="font-size:18px;"> Wait a sec... lagi ngehapus dulu napa sabar</h2>
</body>
</html>
