<?php
session_start();
include_once "sesi_admin.php";
$modul=(isset($_GET['m']))?$_GET['m']:"awal";
$jawal="Admin || Pury Electronic Test";
switch($modul){
    case 'awal': default: $aktif="Beranda"; $judul="Beranda $jawal"; include "awal.php"; break;
    case 'admin': $aktif="Admin"; $judul="$jawal"; include "modul/admin/index.php"; break;
    case 'petugas': $aktif="Petugas"; $judul="Petugas $jawal"; include "modul/petugas/index.php"; break;
    case 'supplier': $aktif="Supplier"; $judul="Supplier $jawal"; include "modul/supplier/index.php"; break;
    case 'rak': $aktif="Rak"; $judul="Rak $jawal"; include "modul/rak/index.php"; break;
    case 'barang': $aktif="Barang"; $judul="Barang $jawal"; include "modul/barang/index.php"; break;
    case 'barangKeluar': $aktif="Barang Keluar"; $judul="Barang Keluar $jawal"; include "modul/barangKeluar/index.php"; break;
    
   
}

?>
