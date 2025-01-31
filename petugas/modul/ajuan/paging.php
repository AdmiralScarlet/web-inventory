<?php
include '../koneksi.php';

$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;

// Query untuk tabel tb_ajuan
$data_ajuan = mysqli_query($koneksi, "SELECT * FROM tb_ajuan");
$jumlah_data_ajuan = mysqli_num_rows($data_ajuan);
$total_halaman_ajuan = ceil($jumlah_data_ajuan / $batas);

$data_brg_in = mysqli_query($koneksi, "SELECT * FROM tb_ajuan LIMIT $halaman_awal, $batas");
$nomor = $halaman_awal + 1;

// Query untuk tabel tb_rak
$data_rak = mysqli_query($koneksi, "SELECT * FROM tb_rak");
$jumlah_data_rak = mysqli_num_rows($data_rak);
$total_halaman_rak = ceil($jumlah_data_rak / $batas);

$data_rak_paginated = mysqli_query($koneksi, "SELECT * FROM tb_rak LIMIT $halaman_awal, $batas");
?>

<head>
    <title>Data Ajuan dan Rak</title>
</head>
<body>
    <h2>Data Ajuan</h2>
    <table border="1">
        <tr>
            <th>No Ajuan</th>
            <th>Tanggal</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Jumlah Ajuan</th>
            <th>Petugas</th>
            <th>Validasi</th>
            <th>Nama Rak</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($data_brg_in)) { ?>
            <tr>
                <td><?php echo $row['no_ajuan']; ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td><?php echo $row['kode_brg']; ?></td>
                <td><?php echo $row['nama_brg']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td><?php echo $row['jml_ajuan']; ?></td>
                <td><?php echo $row['petugas']; ?></td>
                <td><?php echo $row['val']; ?></td>
                <?php $rak = mysqli_fetch_array($data_rak_paginated); ?>
                <td><?php echo $rak['nama_rak']; ?></td>
                <td><a href="index.php?m=ajuan&s=hapus&no_ajuan=<?php echo $row['no_ajuan']; ?>" onclick="return confirm('Yakin Akan dihapus?')"><button class="btn btn-danger">Hapus</button></a></td>
            </tr>
        <?php } ?>
    </table>
</body>
