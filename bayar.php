<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 
  
  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
      header('location:login.php');
      exit;
    }
  }

  //memanggil data dari table transaksi
  $id_user = $_SESSION['id_user'];
  $id_transaksi = $_GET['id_transaksi'];

  $transaksi = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.id_transaksi = '$id_transaksi'");
  $panggil_transaksi = mysqli_fetch_assoc($transaksi);

  //jika tobol bayar di tekan
  if (isset($_POST['bayar'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $uang_bayar = $_POST['uang_bayar'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $total_harga_cuci = $_POST['total_harga_cuci'];
    if ($uang_bayar < $total_harga_cuci) {
      echo "
        <script>
           $(document).ready(function() {
                    Swal.fire({
                      type: 'error',
                      title: 'Jumlah uang kurang dari total harga!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'bayar.php?id_transaksi=$id_transaksi';
                      }
                    });
                  })
        </script>
      ";
      return false;
    }

    $kembalian = $uang_bayar - $total_harga_cuci;
    $sql_pembayaran = mysqli_query($konek, "INSERT INTO pembayaran VALUES ('','$total_harga_cuci', '$uang_bayar', '$kembalian', '$tgl_bayar', '$id_user', '$id_transaksi')");

    $ubah_status = mysqli_query($konek, "UPDATE transaksi SET dibayar = 'sudah dibayar' WHERE transaksi.id_transaksi = '$id_transaksi'");
  }
  

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Pembayaran </title>

  <!-- Custom fonts for this template-->
  <link href="bs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bs/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="bs/css/sb-admin-2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="bs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body id="page-top">

   <!-- navbar logo -->
      <nav class="navbar navbar-expand-lg navbar-light bg-primary" style="background-image: url('img/bg-logn5.png'); height: 65px;"></nav>
      <!-- akhir navbar logo -->

      <!-- navbar link -->
     <nav class="navbar navbar-expand-lg navbar-light bg-dark shadow p-3 bg-white rounded">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="container-fluid">
        <img src="img/logonavbar.png" alt="" style="width: 250px;">
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav text-uppercase">
          <li class="nav-item">
            <a class="nav-link collapsed" href="home.php">
              <i class="fas fa-home"></i>
              <span>dasbor</span>
            </a>
          </li>
        <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
          <p class="mt-2">|</p>
           <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-tasks"></i>
                    manajemen
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <h6 class="dropdown-header">Komponen : </h6>
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                          <a class="dropdown-item" href="daftar_pengguna.php">Pengguna</a>
                        <?php endif ?>
                        <a class="dropdown-item" href="pelanggan.php">Pelanggan</a>
                        <a class="dropdown-item" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item" href="transaksi_cuci.php">Transaksi</a>
                  </div>
                </li>
        <?php endif ?>
           <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'owner'): ?>
              <p class="mt-2">|</p>
              <li class="nav-item">
                <a class="nav-link collapsed" href="laporan.php">
                  <i class="fas fa-file-signature"></i>
                  <span>laporan</span>
                </a>
              </li>
            <p class="mt-2">|</p>
              <li class="nav-item">
                <a class="nav-link collapsed" href="riwayat.php">
                  <i class="fas fa-history"></i>
                  <span>riwayat</span>
                </a>
              </li>
           <?php endif ?>
            </ul>
           </div>
             <form class="form-inline my-2 my-lg-0">
                  <a onclick="return confirm('Apakah ingin keluar dari sistem?')" class="nav-link btn btn-sm btn-outline-danger rounded-lg collapsed text-uppercase" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </form>
          </div>
        </nav>
      <!-- akhir navbar link -->

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column text-dark mt-1">
      
      <div id="content" class="p-4 p-md-5 pt-5">
       <span><h4><i class="fas fa-money-bill-wave-alt"></i> | Pembayaran "<?php echo $panggil_transaksi['nama_member']; ?> | Invoice - <?php echo $panggil_transaksi['kode_invoice']; ?>" </h4></span>
          
          <?php foreach ($transaksi as $data): 

                        $id_transaksi = $data['id_transaksi'];
                        $harga_total = 0;

                        //mencari total harga dari table detail
                        $sql_panggil_detail = "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE dt.id_transaksi = '$id_transaksi'";
                        $panggil_detail_transaksi = mysqli_query($konek, $sql_panggil_detail);
                        while ($data_total = mysqli_fetch_array($panggil_detail_transaksi)) {
                          $jumlah_harga = $data_total['harga'] * $data_total['qty'];
                          $harga_total += $jumlah_harga;
                        }

                        $total_bayar = ($harga_total + $data['pajak'] + $data['biaya_tambahan']) - $data['diskon'];
                      
                    ?>

              <?php endforeach ?>
      <hr>
         <div class="row justify-content-center">
           <div class="col-lg-4 rounded-lg p-4 shadow-lg p-3 mb-5 bg-white rounded">
            <form action="" method="POST">
              <input type="hidden" name="id_transaksi" value="<?php echo $panggil_transaksi['id_transaksi']; ?>">
              <input type="hidden" name="total_harga_cuci" value="<?php echo $total_bayar; ?>">
              <div class="form-row">
                <div class="col-lg-6">
                  <label for="">Harga Cuci / Rp.</label>
                  <input type="text" class="form-control" style="cursor: not-allowed;" disabled name="<?php echo $total_bayar; ?>"  value="<?php echo number_format($total_bayar); ?>">
                </div>
                <div class="col-lg-6">
                  <label for="">Tanggal Bayar</label>
                  <input type="date" name="tgl_bayar" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
              </div>
              <?php if (isset($_POST['bayar'])): ?>
                <div class="form-row mt-2">
                  <div class="col-lg-6">
                    <label for="">Jumlah Uang</label>
                    <input type="number" name="uang_bayar" class="form-control" value="<?php echo $uang_bayar; ?>">
                  </div>
                  <div class="col-lg-6">
                    <label for="">Jumlah Kembalian</label>
                    <input type="number" name="kembalian" style="cursor: not-allowed;" disabled class="form-control" value="<?php echo $kembalian; ?>">
                  </div>
                </div>
              <?php else: ?>
                <div class="form-group mt-2">
                  <label for="">Jumlah Uang</label>
                  <input type="number" class="form-control" name="uang_bayar">
                </div>
              <?php endif ?>
              <div class="form-group mt-4">
                <button type="submit" class="btn btn-success btn-lg btn-block" name="bayar">Bayar</button>
                <a href="transaksi_cuci.php" class="btn btn-danger btn-lg btn-block">Kembali</a>
              </div>
            </form>
            <hr>
            <footer class="main-footer mt-2 text-center">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
            </footer>
           </div>
         </div>
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="bs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="bs/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="bs/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="bs/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="bs/js/demo/chart-area-demo.js"></script>
  <script src="bs/js/demo/chart-pie-demo.js"></script>


</body>

</html>
