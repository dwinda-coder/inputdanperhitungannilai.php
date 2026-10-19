<?php
#Inisialisasi variabel awal (default kosong atau nilai contoh)
$namaMahasiswa = "";
$nimMahasiswa  = "";
$semester      = "";
$absensi       = "";
$nilaiTugas    = "";
$nilaiUts      = "";
$nilaiUas      = "";
$hasilProses   = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMahasiswa = htmlspecialchars($_POST['nama']);
    $nimMahasiswa  = htmlspecialchars($_POST['nim']);
    $semester      = htmlspecialchars($_POST['semester']); // Diperbaiki dari 'nim' ke 'semester'
    $absensi       = floatval($_POST['absensi']);
    $nilaiTugas    = floatval($_POST['tugas']);
    $nilaiUts      = floatval($_POST['uts']);
    $nilaiUas      = floatval($_POST['uas']);
    $statusAktif   = true; // Variabel boolean

    #Fungsi untuk Menghitung Nilai Akhir
    function hitungNilaiAkhir($absensi, $tugas, $uts, $uas) {
        return ($absensi * 0.10) + ($tugas * 0.20) + ($uts * 0.35) + ($uas * 0.35);
    }

    #Fungsi untuk Menentukan Grade (Percabangan)
    function tentukanGrade($nilai) {
        if ($nilai >= 85) {
            return "A";
        } elseif ($nilai >= 70) {
            return "B";
        } elseif ($nilai >= 60) {
            return "C";
        } elseif ($nilai >= 50) {
            return "D";
        } else {
            return "E";
        }
    }

    #Kalkulasi nilai akhir
    $nilaiAkhir = hitungNilaiAkhir($absensi, $nilaiTugas, $nilaiUts, $nilaiUas);
    $grade = tentukanGrade($nilaiAkhir);
    $keterangan = ($grade != "E") ? "Lulus" : "Tidak Lulus";
    
    $hasilProses = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input & Perhitungan Nilai Mahasiswa</title>
    <style>
        body {
        font-family: Arial, sans-serif;
            background-color: rgba(8, 102, 20, 0.13);
            margin: 0;
            padding: 30px;
        }

        .container {
            width: 600px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #000000;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        input,
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #4b0333;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #521616;
        }

        .hasil {
            margin-top: 30px;
            padding: 20px;
            background-color: #eef5fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Form Input Nilai Mahasiswa</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Mahasiswa:</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>NIM:</label>
                <input type="text" name="nim" required>
            </div>
            
            <!-- Diperbaiki dari from=group menjadi form-group -->
            <div class="form-group">
                <label>Semester</label>
                <select name="semester" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option> 
                </select>
            </div>

            <div class="form-group">
                <label>Absensi (0% - 100%):</label>
                <input type="number" name="absensi" required>
            </div>

            <div class="form-group">
                <label>Nilai Tugas (0 - 100):</label>
                <input type="number" name="tugas" required>
            </div>
            <div class="form-group">
                <label>Nilai UTS (0 - 100):</label>
                <input type="number" name="uts" required>
            </div>
            <div class="form-group">
                <label>Nilai UAS (0 - 100):</label>
                <input type="number" name="uas" required>
            </div>
            <button type="submit">Hitung Nilai</button>
        </form>
    </div>

    <?php if ($hasilProses): ?>
    <div class="container">
        <h3>Hasil Perhitungan Nilai</h3>
        <p><strong>Nama:</strong> <?= $namaMahasiswa; ?></p>
        <p><strong>NIM:</strong> <?= $nimMahasiswa; ?></p>
        <p><strong>Semester:</strong> <?= $semester; ?></p> <!-- Ditampilkan agar data semester terekam -->
        <p><strong>Status Aktif:</strong> <?= $statusAktif ? "Aktif" : "Tidak Aktif"; ?></p>

        <table>
            <tr>
                <th>Komponen</th>
                <th>Nilai</th>
            </tr>
            <tr>
                <td>Nilai Akhir</td>
                <td><strong><?= number_format($nilaiAkhir, 2); ?></strong></td>
            </tr>
            <tr>
                <td>Grade Huruf</td>
                <td><strong><?= $grade; ?></strong></td>
            </tr>
            <tr>
                <td>Keterangan Kelulusan</td>
                <td><span style="color: <?= ($keterangan == 'Lulus') ? 'green' : 'red'; ?>; font-weight: bold;"><?= $keterangan; ?></span></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>

</body>
</html>