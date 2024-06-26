<?php 
  
  require 'koneksi.php';

  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
      header('location: login.php');
      exit;
    }
  }

  //jumlah dashboard pelanggan
  $jumlah_member = mysqli_fetch_assoc(mysqli_query($konek, "SELECT *, COUNT(member.id_member) as jml_member FROM member"));


  //jumlah dashboard status
  $jumlah_baru = mysqli_fetch_assoc(mysqli_query($konek, "SELECT *, COUNT(transaksi.status) as jml_baru FROM transaksi WHERE status = 'baru'"));

  $jumlah_proses = mysqli_fetch_assoc(mysqli_query($konek, "SELECT *, COUNT(transaksi.status) as jml_proses FROM transaksi WHERE status = 'proses'"));

  $jumlah_selesai = mysqli_fetch_assoc(mysqli_query($konek, "SELECT *, COUNT(transaksi.status) as jml_selesai FROM transaksi WHERE status = 'selesai'"));

  $jumlah_barang_diambil = mysqli_fetch_assoc(mysqli_query($konek, "SELECT *, COUNT(transaksi.status) as jml_barang_diambil FROM transaksi WHERE status = 'diambil'"));

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Beranda</title>

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
          <li class="nav-item active">
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
                <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
                  <a href="pengambilan_barang.php" class="btn btn-outline-primary mr-2"><i class="fas fa-check"></i> Pengambilan Barang</a> 
                  | 
                <?php endif ?>
                  <a onclick="return confirm('Apakah ingin keluar dari sistem?')" class="nav-link btn btn-sm btn-outline-danger rounded-lg collapsed text-uppercase ml-2" href="logout.php">
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
    <div id="content-wrapper" class="d-flex flex-column">
      
      <div id="content" class="p-4 p-md-5 pt-5">
        <span><h4 class="text-dark"><i class="fas fa-home"></i> | Dasbor</h4></span>
        <form class="form-inline my-2 my-lg-0">
            <div>
              <?php 
                //panggil role
                $role = ucwords(strtolower($_SESSION['role']));  

                //panggil nama user
                $nama_user = ucwords(strtolower($_SESSION['nama_user']));
              ?>
              <b><h6>Halo, <b class="text-dark"><?php echo $nama_user; ?></b> role anda adalah sebagai <b class="text-dark"><?= $role; ?></b>!</h6></b>
            </div>
          </form>
       <hr>
         <div class="row mt-5">
           <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pelanggan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_member['jml_member']; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cucian Baru</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_baru['jml_baru']; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-plus"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cucian Proses</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_proses['jml_proses']; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-retweet"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Cucian Selesai</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_selesai['jml_selesai']; ?></div>
                    </div>
                    <div class="col-auto">
                     <i class="fas fa-check"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
             <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Cucian Diambil</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_barang_diambil['jml_barang_diambil']; ?></div>
                    </div>
                    <div class="col-auto">
                     <i class="fas fa-people-carry"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>      
          </div>
         </div>
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="bs/vendor/jquery/jquery.min.js"></script>
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
  <script src="bs/js/sweetalert2.min.js"></script>
  <script type="text/javascript"></script>


</body>

</html>
