<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $judul; ?></title>

  <!-- Bootstrap -->
  <link href="../vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/css/bootstrap/bootstrap.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Tema CSS -->
  <link href="../css/tampilanadmin.css" rel="stylesheet">

  <!-- jsPDF Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>

  <!-- jQuery and Bootstrap JS -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/js/bootstrap.min.js"></script>
</head>

<body>
  <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand">Inventory Pury Electronic</a>
        </div>
        <?php
            $id = $_SESSION['idinv'];
            include '../koneksi.php';
            $sql = "SELECT * FROM tb_admin WHERE id_admin = '$id'";
            $query = mysqli_query($koneksi, $sql);
            $r = mysqli_fetch_array($query);
        ?>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="../images/admin/<?php echo $r['foto']; ?>" height="50"></i> <?php echo $r['nama']; ?>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <form action="logout.php" onclick="return confirm('Apakah anda ingin logout?');" method="post">
                            <button class="btn btn-default" type="submit" name="keluar"><i class="fa fa-sign-out"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>

            <!-- Sidebar Menu -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="?m=awal.php"><i class="fa fa-dashboard"></i> Beranda</a></li>
                        <li><a href="?m=admin&s=awal"><i class="fa fa-user"></i> Data Admin</a></li>
                        <li><a href="?m=petugas&s=awal"><i class="fa fa-users"></i> Data Karyawan</a></li>
                        <li><a href="?m=rak&s=awal"><i class="fa fa-cubes"></i> Data Rak</a></li>
                        <li><a href="?m=supplier&s=awal"><i class="fa fa-building"></i> Data Supplier</a></li>
                        <li><a href="?m=barang&s=awal"><i class="fa fa-archive"></i> Data Barang</a></li>
                        <li><a href="?m=barangKeluar&s=awal"><i class="fa fa-cart-arrow-down"></i> Data Barang Keluar</a></li>
                        <li><a href="logout.php" onclick="return confirm('Apakah anda ingin logout?')"><i class="fa fa-warning"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Data Supplier</h1>
      </div>
    </div>

    <!-- Button triggers -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
      Tambah Data
    </button>
    <button type="button" class="btn btn-success" onclick="generatePDF()">Cetak</button>

    <!-- Modal for adding data -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Supplier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="?m=supplier&s=simpan" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">Nama</label>
                <input type="text" class="form-control" name="nama_sup" placeholder="Masukkan Nama Supplier">
              </div>
              <div class="form-group">
                <label>Email Supplier</label>
                <input type="text" class="form-control" name="kontak_sup" placeholder="Masukkan Email Supplier">
              </div>
              <div class="form-group">
                <label>Alamat Supplier</label>
                <textarea class="form-control" name="alamat_sup" placeholder="Masukkan Alamat Supplier"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Telepon Supplier</label>
                <input type="text" class="form-control" name="telepon_sup" placeholder="Masukkan Telepon Supplier">
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

    <!-- Data table -->
    <div class="row">
      <div class="table-responsive table--no-card m-b-30">
        <table class="table table-borderless table-striped table-earning">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Supplier</th>
              <th>Nama Supplier</th>
              <th>Email Supplier</th>
              <th>Alamat Supplier</th>
              <th>Telepon Supplier</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'paging.php';
            ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <center>
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" <?php if ($halaman > 1) {
                                        echo "href='?m=supplier&s=awal&halaman=$previous'";
                                      } ?>>Previous</a>
            </li>
            <?php for ($x = 1; $x <= $total_halaman; $x++) { ?>
              <li class="page-item"><a class="page-link" href="?m=supplier&s=awal&halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
            <?php } ?>
            <li class="page-item">
              <a class="page-link" <?php if ($halaman < $total_halaman) {
                                        echo "href='?m=supplier&s=awal&halaman=$next'";
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
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add centered title
    doc.setFontSize(18);
    const title = "Pury Electronic";
    const titleWidth = doc.getStringUnitWidth(title) * doc.internal.getFontSize() / doc.internal.scaleFactor;
    const pageWidth = doc.internal.pageSize.width;
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 20); // Title positioned at the top of the page

    // Collect table data
    const table = document.querySelector('.table');
    const rows = table.querySelectorAll("tr");
    const tableData = [];
    let counter = 1;

    rows.forEach(row => {
      const cols = row.querySelectorAll("td");
      const rowData = [];

      cols.forEach((col, index) => {
        if (index < 5) { // Skip the 6th column (Aksi)
          rowData.push(col.innerText);
        }
      });

      // If the row has data, insert the serial number at the beginning
      if (rowData.length > 0) {
        rowData.unshift(counter++); // Add serial number
        tableData.push(rowData);
      }
    });

    // Add table to the PDF with the serial number column
    doc.autoTable({
      head: [
        ['No', 'ID Supplier', 'Nama Supplier', 'Email Supplier', 'Alamat Supplier', 'Telepon Supplier']
      ],
      body: tableData,
      startY: 30, // Adjust to avoid overlap with title
      styles: {
        fontSize: 9, // Adjust font size for table data
      },
    });

    // Instead of auto downloading, show the generated PDF in the browser
    const pdfOutput = doc.output('datauristring');
    window.open(pdfOutput, '_blank');
  }
</script>

</body>

</html>
