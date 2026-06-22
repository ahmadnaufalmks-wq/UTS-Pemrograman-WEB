<?php
include "cek_login.php";
include "koneksi.php";

// =============================
// CREATE DATA KEUANGAN
// =============================
if (isset($_POST['tambah'])) {

    $tipe = $_POST['tipe'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    $query = mysqli_query(
        $conn,
        "INSERT INTO keuangan(tipe, jenis, jumlah, tanggal)
        VALUES('$tipe','$jenis','$jumlah','$tanggal')"
    );

    if ($query) {

        echo "
        <script>
            alert('Data berhasil ditambahkan');
            window.location='keungan.php';
        </script>";

        exit;
    } else {

        echo "
        <script>
            alert('Data gagal ditambahkan');
        </script>";
    }
}

// Mengambil data pemasukan
$pemasukan = mysqli_query(
    $conn,
    "SELECT * FROM keuangan
     WHERE tipe='pemasukan'
     ORDER BY tanggal DESC"
);

// Mengambil data pengeluaran
$pengeluaran = mysqli_query(
    $conn,
    "SELECT * FROM keuangan
     WHERE tipe='pengeluaran'
     ORDER BY tanggal DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan - Masjid Al-Haq BTN CV Dewi</title>
    <link rel="stylesheet" href="desain/desain_keungan.css">
</head>

<body class="keuangan-page">
    <div class="keuangan-shell">
        <aside class="keuangan-sidebar">
            <div class="brand">
                <div class="brand-icon">🕌</div>
                <div>
                    <h1>Masjid Al-Haq</h1>
                    <p>BTN CV Dewi</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php">Dashboard</a>
                <a class="active" href="keungan.php">Keuangan</a>
                <a href="#">Laporan</a>
                <a href="#">Pengaturan</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="keuangan-main">
            <header class="keuangan-topbar">
                <div>
                    <p class="eyebrow">Manajemen Keuangan</p>
                    <h2>Data Keuangan Masjid</h2>
                </div>
                <div class="topbar-chip">Administrator</div>
            </header>

            <section class="keuangan-overview">
                <div class="overview-card">
                    <p class="card-label">Total Pemasukan</p>
                    <p class="total-value">Rp 12.450.000</p>
                    <span class="card-note">Total uang masuk bulan ini.</span>
                </div>
                <div class="overview-card">
                    <p class="card-label">Total Pengeluaran</p>
                    <p class="total-value">Rp 4.125.000</p>
                    <span class="card-note">Total uang keluar bulan ini.</span>
                </div>
                <div class="overview-card highlight">
                    <p class="card-label">Saldo Bersih</p>
                    <p class="total-value">Rp 8.325.000</p>
                    <span class="card-note">Sisa dana kas tersedia.</span>
                </div>
            </section>

            <section class="keuangan-form">
                <div class="form-container">
                    <div class="form-header">
                        <h3>Tambah Data Keuangan</h3>
                        <p>Masukkan data pemasukan atau pengeluaran baru</p>
                    </div>
                    <form action="" method="post" class="data-form">
                        <div class="form-group">
                            <label for="tipe">Tipe Transaksi</label>
                            <select id="tipe" name="tipe" required>
                                <option value="">Pilih Tipe</option>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis / Deskripsi</label>
                            <input type="text" id="jenis" name="jenis" placeholder="Contoh: Donasi Bulanan" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah (Rp)</label>
                            <input type="number" id="jumlah" name="jumlah" placeholder="0" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>
                        <button type="submit" name="tambah" class="submit-btn">Tambah Data</button>
                    </form>
                </div>
            </section>

            <section class="keuangan-tables">
                <div class="table-container">
                    <div class="table-header">
                        <h3>Uang Masuk</h3>
                        <p>Riwayat pemasukan ke kas masjid</p>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pemasukan</th>
                                <th>Jumlah</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($pemasukan)) {
                            ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['jenis']; ?></td>
                                    <td class="amount">
                                        Rp <?= number_format($row['jumlah'], 0, ",", "."); ?>
                                    </td>
                                    <td><?= $row['tanggal']; ?></td>
                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h3>Pengeluaran</h3>
                        <p>Riwayat pengeluaran dari kas masjid</p>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pengeluaran</th>
                                <th>Jumlah</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($pengeluaran)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['jenis']; ?></td>
                                    <td class="amount">
                                        Rp <?= number_format($row['jumlah'], 0, ",", "."); ?>
                                    </td>
                                    <td><?= $row['tanggal']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>

</html>