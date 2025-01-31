 <?php

  date_default_timezone_set("Asia/Jakarta");
  $tanggalSekarang = date("Y-m-d");
  $jamSekarang = date("h:i a");
  ?>
 <!DOCTYPE html>
 <html>

 <head>
   <meta charset="utf-8">
   <meta name="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">
   <title><?php echo $judul; ?></title>

   <!-- boootstrap -->
   <link href="../vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">

   <link href="../vendor/css/bootstrap/bootstrap.css" rel="stylesheet">

   <!-- icon dan fonts -->
   <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

   <!-- tema css -->
   <link href="../css/tampilan.css" rel="stylesheet">

   <!-- jsPDF Library -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>

 </head>

 <body>
   <!-- Menu -->
   <div id="wrapper">

     <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
           <span class="sr-only">navigation</span> Menu <i class="fa fa-bars"></i>
         </button>
         <a class="navbar-brand">Inventory Pury Electronic</a>
       </div>
       <?php
        $id = $_SESSION['idinv2'];
        include '../koneksi.php';
        $sql = "SELECT * FROM tb_petugas WHERE id_petugas = '$id'";
        $query = mysqli_query($koneksi, $sql);
        $r = mysqli_fetch_array($query);

        ?>
       <ul class="nav navbar-top-links navbar-right">
         <li class="dropdown">
           <a class="dropdown-toggle" data-toggle="dropdown" href="#">
             </i> <?php echo $r['nama']; ?>
           </a>
           <ul class="dropdown-menu dropdown-user">
             <li>
               <form class="" action="logout_petugas.php" onclick="return confirm('Apakah anda ingin logout?');" method="post">
                 <button class="btn btn-default" type="submit" name="keluar"><i class="fa fa-sign-out"></i> Logout</button>
               </form>
             </li>
           </ul>
         </li>
       </ul>

       <!-- menu samping -->
       <div class="navbar-default sidebar" role="navigation">
         <div class="sidebar-nav navbar-collapse">
           <ul class="nav" id="side-menu">
             <li>
               <a href="?m=awal.php">
                 <i class="fa fa-dashboard"></i> Beranda
               </a>
             </li>
             <li>
               <a href="?m=barangMasuk&s=awal">
                 <i class="fa fa-cart-arrow-down"></i> Data Barang Masuk
               </a>
             </li>

             <li>
               <a href="?m=ajuan&s=awal">
                 <i class="fa fa-gift"></i> Data Ajuan
               </a>
             </li>
             <li>
               <a href="logout_petugas.php" onclick="return confirm('Apakah anda ingin logout?');">
                 <i class="fa fa-warning"></i> Logout
               </a>
             </li>

           </ul>
         </div>
       </div>
     </nav>

     <div id="page-wrapper">
       <div class="row">
         <div class="col-lg-12">
           <h1 class="page-header">Data Ajuan</h1>
         </div>
       </div>

       <!-- Button triggers -->
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
         Tambah data
       </button>
       <button type="button" class="btn btn-success" onclick="generatePDF()">Cetak</button>

       <!-- Modal -->
       <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Ajuan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <form action="?m=ajuan&s=simpan" method="POST" enctype="multipart/form-data">
                 <div class="form-group">
                   <label for="exampleInputEmail1">Nomor Ajuan</label>
                   <input type="text" class="form-control" id="exampleInputEmail1" name="no_ajuan" aria-describedby="emailHelp" placeholder="Masukkan Nomor Ajuan">
                   <small id="emailHelp" class="form-text text-muted">Masukkan Tanggal</small>
                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Tanggal</label>
                   <input type="text" readonly="" class="form-control" value="<?php echo $tanggalSekarang; ?>" id="exampleInputEmail1" name="tanggal" aria-describedby="emailHelp" placeholder="Masukkan Tanggal">
                   <small id="emailHelp" class="form-text text-muted">Masukkan Tanggal</small>
                 </div>

                 <div class="form-group">
                   <label for="exampleInputEmail1">Kode Barang</label>

                   <?php
                    include("../koneksi.php");
                    $supp = ("SELECT * FROM tb_barang");
                    $result = mysqli_query($koneksi, $supp);

                    $jsArray = "var prdName = new Array();";

                    echo '<select name="kode_brg" onchange="changeValue(this.value)">';
                    echo '<option>--- PILIH ---</option>';

                    while ($row = mysqli_fetch_array($result)) {
                      echo '<option value="' . $row['kode_brg'] . '">KDB' . $row['kode_brg'] . '</option>';
                      $jsArray .= "prdName['" . $row['kode_brg'] . "'] 
              = {nama_brg:'" . addslashes($row['nama_brg']) . "',
                stok:'" . addslashes($row['stok']) . "', supplier:'" . addslashes($row['supplier']) . "'
              };";
                    }


                    echo '</select>';
                    ?>
                   <script type="text/javascript">
                     <?php echo $jsArray; ?>

                     function changeValue(id) {

                       document.getElementById('prd_nmbrg').value = prdName[id].nama_brg;
                       document.getElementById('prd_stk').value = prdName[id].stok;
                       document.getElementById('prd_sup').value = prdName[id].supplier;
                     }
                   </script>

                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Nama Barang</label>
                   <input type="text" name="nama_brg" readonly="" id="prd_nmbrg" size="67">

                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Stok</label>
                   <input type="text" class="form-control" id="prd_stk" name="stok" readonly="" aria-describedby="emailHelp" placeholder="Masukkan Stok Barang">

                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Jumlah Ajuan</label>
                   <input type="text" class="form-control" id="exampleInputEmail1" name="jml_ajuan" aria-describedby="emailHelp" placeholder="Masukkan Jumlah Masuk">
                   <small id="emailHelp" class="form-text text-muted">Masukkan Jumlah Ajuan</small>
                 </div>
                 <div class="form-group">
                   <label for="exampleInputEmail1">Karyawan</label>
                   <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $r['nama']; ?>" readonly="" name="petugas" aria-describedby="emailHelp" placeholder="Masukkan Nama Admin">
                 </div>
                <div class="form-group">
                  <label for="rak">Rak</label>
                  <select class="form-control" name="rak" required>
                    <?php
                    $sql = "SELECT * FROM tb_rak";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                      <option value="<?php echo $data['nama_rak']; ?>"><?php echo $data['nama_rak']; ?></option>
                    <?php } ?>
                  </select>
                </div>


             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" name="simpan" class="btn btn-primary">Save changes</button>
             </div>
             </form>
           </div>
         </div>
       </div>

       <div class="row">

         <div class="table-responsive table--no-card m-b-30">
           <table class="table table-borderless table-striped table-earning">
             <thead>
               <tr>
                 <th>No</th>
                 <th>No Ajuan</th>
                 <th>Tanggal</th>
                 <th>Kode Barang</th>
                 <th>Nama Barang</th>
                 <th>Stok</th>
                 <th>Jumlah Ajuan</th>
                 <th>Karyawan</th>
                 <th>Rak</th>




                 <th>Aksi</th>

               </tr>
             </thead>
             <tbody>

               <?php

                include 'paging.php';

                ?>
             </tbody>
           </table>
           <center>
             <ul class="pagination justify-content-center">
               <li class="page-item">
                 <a class="page-link" <?php if ($halaman > 1) {
                                        echo "href='?m=ajuan&s=awal&halaman=$previous'";
                                      } ?>>Previous</a>
               </li>
               <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                 <li class="page-item"><a class="page-link" href="?m=ajuan&s=awal&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
               <?php
                }
                ?>
               <li class="page-item">
                 <a class="page-link" <?php if ($halaman < $total_halaman) {
                                        echo "href='?m=ajuan&s=awal&halaman=$next'";
                                      } ?>>Next</a>
               </li>
             </ul>
           </center>
         </div>
       </div>


     </div>
   </div>


   <!-- Footer -->
   <footer class="text-center">
     <div class="footer-below">
       <div class="container">
         <div class="row">
           <div class="col-lg-12">
             <p class="text-muted" style="font-size: 16px;">Copyright &copy; <script>
                 document.write(new Date().getFullYear());
               </script> All rights reserved</p>
           </div>
         </div>
       </div>
     </div>
   </footer>

   <!-- jQuery -->
   <script src="../vendor/jquery/jquery.min.js"></script>
   <!-- Bootstrap JS -->
   <script src="../vendor/css/js/bootstrap.min.js"></script>

   <!-- PDF Generation Script -->
   <script>
     function generatePDF() {
       const {
         jsPDF
       } = window.jspdf;
       const doc = new jsPDF();

       // Set font size for the title
       doc.setFontSize(18);

       // Get the width of the title text
       const title = "Pury Electronic";
       const titleWidth = doc.getStringUnitWidth(title) * doc.internal.getFontSize() / doc.internal.scaleFactor;

       // Calculate the X position to center the title
       const pageWidth = doc.internal.pageSize.width;
       const titleX = (pageWidth - titleWidth) / 2; // Position to center the title

       // Add header text centered
       doc.text(title, titleX, 20); // Position the title at calculated X, Y = 20

       // Get the table
       const table = document.querySelector('.table');

       // Get the table rows
       const rows = table.querySelectorAll("tr");

       // Collect the table data excluding the "Aksi" column
       const tableData = [];
       let counter = 1; // Initialize a counter for numbering

       rows.forEach(row => {
         const cols = row.querySelectorAll("td");
         const rowData = [];

         cols.forEach((col, index) => {
           // Exclude the "Aksi" column (usually the last column)
           if (index !== cols.length - 1) {
             // Add a serial number (index) before the "Kode Barang"
             if (index === 0) {
               rowData.push(counter); // Add number for the first column (Kode Barang)
             }
             rowData.push(col.innerText.trim());
           }
         });

         if (rowData.length > 0) {
           tableData.push(rowData);
           counter++; // Increment counter for the next row
         }
       });

       // Define the headers for the table (update as per your column names)
       const headers = [
         ['No', 'No Ajuan', 'Tanggal', 'Kode Barang', 'Nama Barang', 'Stok', 'Jumlah Ajuan', 'Petugas']
       ]; // Add 'No' column header

       // Use autoTable to render the table in the PDF
       doc.autoTable({
         head: headers,
         body: tableData,
         startY: 30, // Starting Y position after the title
       });

       // Instead of auto downloading, show the generated PDF in the browser
       const pdfOutput = doc.output('datauristring');
       window.open(pdfOutput, '_blank');
     }
   </script>
 </body>

 </html>
