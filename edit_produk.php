<?php
// Kredensial koneksi database
$host = 'localhost'; // Ganti dengan nama host Anda jika berbeda
$dbname = 'produk'; // Nama database yang telah Anda buat
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

// Membuat koneksi ke database menggunakan PDO
try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    die();
}

// Jika parameter id produk diberikan melalui URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Mendapatkan nilai parameter dari URL
    $id_produk = trim($_GET["id"]);
    
    // Query SQL untuk mendapatkan data produk berdasarkan id
    $query = "SELECT * FROM produk WHERE id_produk = :id_produk";
    
    try {
        // Prepare statement
        $statement = $koneksi->prepare($query);
        
        // Bind parameter
        $statement->bindParam(':id_produk', $id_produk);
        
        // Execute statement
        $statement->execute();
        
        // Mengambil hasil query sebagai array asosiatif
        $produk = $statement->fetch(PDO::FETCH_ASSOC);

        // Jika produk dengan id yang diberikan tidak ditemukan
        if(!$produk){
            echo "<h2>Produk tidak ditemukan.</h2>";
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang diinput dari form
    $nama_produk = $_POST['nama_produk'];
    $stock_produk = $_POST['stock_produk'];
    $harga_produk = $_POST['harga_produk'];
    $id_produk = $_POST['id_produk'];

    // Query SQL untuk update produk
    $query = "UPDATE produk SET nama_produk=:nama_produk, stock_produk=:stock_produk, harga_produk=:harga_produk WHERE id_produk=:id_produk";
    
    try {
        // Prepare statement
        $statement = $koneksi->prepare($query);
        
        // Bind parameter
        $statement->bindParam(':nama_produk', $nama_produk);
        $statement->bindParam(':stock_produk', $stock_produk);
        $statement->bindParam(':harga_produk', $harga_produk);
        $statement->bindParam(':id_produk', $id_produk);
        
        // Execute statement
        $statement->execute();

        // Redirect kembali ke halaman view_produk setelah berhasil mengedit produk
        header("Location: view_produk.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
        
        <label for="nama_produk">Nama Produk:</label><br>
        <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>"><br>

        <label for="stock_produk">Stock:</label><br>
        <input type="text" id="stock_produk" name="stock_produk" value="<?php echo $produk['stock_produk']; ?>"><br>

        <label for="harga_produk">Harga:</label><br>
        <input type="text" id="harga_produk" name="harga_produk" value="<?php echo $produk['harga_produk']; ?>"><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas Kelompok 4</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <h3><span class="brand-text font-weight-light"><b>Toko JayaKaya</b></span></h3>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          
          <li class="nav-header">Produk</li>
          
          <li class="nav-item">
          <a href="view_produk.php" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
              <p>Tabel Produk</p>
            </a>
          </li>
          </li>

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Form Edit Produk</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Produk</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="card-body">

              <div class="form-group">
                <input type="hidden" class="form-control" name="id_produk" value="<?php echo $produk['id_produk']; ?>"">
              </div>

              <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>">
              </div>
              
              <div class="form-group">
                <label for="stock_produk">Jumlah Stock</label>
                <input type="text" class="form-control" id="stock_produk" name="stock_produk" value="<?php echo $produk['stock_produk']; ?>">
              </div>
          
              <div class="form-group">
                <label for="harga_produk">Harga</label>
                <input type="text" class="form-control" id="harga_produk" name="harga_produk" value="<?php echo $produk['harga_produk']; ?>">
              </div>
          
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary" value="Simpan">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
        </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
