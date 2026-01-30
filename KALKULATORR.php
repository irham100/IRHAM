<?php
/* =====================================================
   1. MEMULAI SESSION
   ===================================================== */
session_start();

/* =====================================================
   2. INISIALISASI RIWAYAT
   ===================================================== */
if (!isset($_SESSION['riwayat'])) {
    $_SESSION['riwayat'] = [];
}

/* =====================================================
   3. AMBIL HASIL TERAKHIR
   ===================================================== */
$hasil = isset($_SESSION['hasil']) ? $_SESSION['hasil'] : '';

/* =====================================================
   4. PROSES SAAT TOMBOL HITUNG DIKLIK
   ===================================================== */
if (isset($_POST['submit'])) {

    // Ambil input angka
    $num1 = floatval($_POST['num1']);
    $num2 = floatval($_POST['num2']);
    $drop = $_POST['drop'];

    // Inisialisasi variabel
    $op = '';
    $hasil = '';

    /* =================================================
       5. LOGIKA PERHITUNGAN
       ================================================= */
    switch ($drop) {
        case 'tambah':
            $hasil = $num1 + $num2;
            $op = '+';
            break;

        case 'kurang':
            $hasil = $num1 - $num2;
            $op = '-';
            break;

        case 'kali':
            $hasil = $num1 * $num2;
            $op = '×';
            break;

        case 'bagi':
            $op = '÷';
            if ($num2 == 0) {
                $hasil = 'Error (Tidak bisa dibagi 0)';
            } else {
                $hasil = $num1 / $num2;
            }
            break;
    }

    /* =================================================
       6. SIMPAN KE SESSION
       ================================================= */
    $_SESSION['hasil'] = $hasil;
    $_SESSION['riwayat'][] = "$num1 $op $num2 = $hasil";

    /* =================================================
       7. REDIRECT (ANTI DOUBLE SUBMIT)
       ================================================= */
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/* =====================================================
   8. HAPUS RIWAYAT
   ===================================================== */
if (isset($_POST['hapus'])) {
    $_SESSION['riwayat'] = [];
    $_SESSION['hasil'] = '';
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kalkulator Sederhana</title>

<style>
/* =====================================================
   9. RESET BOX MODEL
   ===================================================== */
* {
    box-sizing: border-box;
}

/* Tampilan dasar halaman */
body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
}

/* Container utama kalkulator */
.container {
    width: 320px;
    margin: 60px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
}

/* Input, select, button */
input, select, button {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
}

/* Tombol hitung */
button {
    background: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

/* Tombol hapus */
.hapus {
    background: #e74c3c;
}

/* Tampilan hasil */
.hasil {
    margin-top: 15px;
    font-weight: bold;
    text-align: center;
}

/* Footer nama */
.footer {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    color: #555;
}
</style>
</head>

<body>

<div class="container">
    <h2>Kalkulator</h2>

    <!-- =========================================
         10. FORM INPUT
         ========================================= -->
    <form method="POST">
        <input type="number" step="any" name="num1" placeholder="Angka pertama" required>
        <input type="number" step="any" name="num2" placeholder="Angka kedua" required>

        <select name="drop" required>
            <option value="">Pilih Operasi</option>
            <option value="tambah">Tambah (+)</option>
            <option value="kurang">Kurang (-)</option>
            <option value="kali">Kali (×)</option>
            <option value="bagi">Bagi (÷)</option>
        </select>

        <button type="submit" name="submit">Hitung</button>
    </form>

    <!-- =========================================
         11. TAMPILKAN HASIL
         ========================================= -->
    <div class="hasil">
        Hasil: <?php echo $hasil; ?>
    </div>

    <!-- =========================================
         12. HAPUS RIWAYAT
         ========================================= -->
    <form method="POST">
        <button type="submit" name="hapus" class="hapus">Hapus Riwayat</button>
    </form>

    <!-- =========================================
         13. RIWAYAT PERHITUNGAN
         ========================================= -->
    <ul>
        <?php
        if (!empty($_SESSION['riwayat'])) {
            foreach ($_SESSION['riwayat'] as $data) {
                echo "<li>$data</li>";
            }
        } else {
            echo "<li>Belum ada riwayat</li>";
        }
        ?>
    </ul>

    <!-- =========================================
         14. NAMA PEMBUAT
         ========================================= -->
    <hr>
    <div class="footer">
        Dibuat oleh <strong>Irham Maulana XII RPL 1</strong>
    </div>

</div>

</body>
</html>
