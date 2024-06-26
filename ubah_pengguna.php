<script src="bs/vendor/jquery/jquery.min.js"></script>
<script src="bs/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<?php 
  
  require 'koneksi.php';

  //login
  if (isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !==1) {
      header('location: login.php');
      exit;
    }
  }

  //jika button ubah ditekan
  if (isset($_POST['ubah'])) {
    if (ubah_pengguna($_POST) > 0) {
      echo "
        <script>
          $(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Pengguna berhasil diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'daftar_pengguna.php';
                      }
                    });
                  })
        </script>
      ";
    }else{
      echo "
        <script>
           $(document).ready(function() {
                    Swal.fire({
                      type: 'error',
                      title: 'Pengguna gagal diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'ubah_pengguna.php';
                      }
                    });
                  })
        </script>
      ";
    }
  }

  $id_user = $_GET['id_user'];

  $sql_user = mysqli_query($konek, "SELECT * FROM user as us INNER JOIN outlet as ot ON us.id_outlet = ot.id_outlet WHERE us.id_user = '$id_user'");

  $panggil_user = mysqli_fetch_assoc($sql_user);

  
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Ubah "<?php echo $panggil_user['nama_user']; ?>" </title>

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
                        <a class="dropdown-item" href="daftar_pengguna.php">Pengguna</a>
                        <a class="dropdown-item" href="pelanggan.php">Pelanggan</a>
                        <a class="dropdown-item" href="paket.php">Paket Cuci</a>
                        <a class="dropdown-item" href="transaksi_cuci.php">Transaksi</a>
                  </div>
                </li>
        <?php endif ?>
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
    <div id="content-wrapper" class="d-flex flex-column text-dark">
      
      <div id="content" class="p-4 p-md-5 pt-5">
       <span><h4><i class="fas fa-pen"></i> | Ubah "<?php echo ucwords($panggil_user['nama_user']); ?>"</h4></span>
      <hr>
        <div class="container ">
         <div class="row justify-content-center mt-5">
           <div class="col-lg-5 rounded-lg shadow-lg p-5 mb-5 bg-white rounded">
            <form action="" method="POST">
             <input type="hidden" name="id_user" value="<?php echo $panggil_user['id_user']; ?>">
             <input type="hidden" name="id_outlet" value="<?php echo $panggil_user['id_outlet']; ?>">
              <div class="form-group">
                <label for="">Nama Pengguna</label>
                <input type="text" name="nama_user" class="form-control" required placeholder="Masukan Nama lengkap" value="<?php echo $panggil_user['nama_user']; ?>">
              </div>
              <div class="form-group">
                <label for="">Pengguna</label>
                <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                              <input type="text" name="username" class="form-control" required placeholder="Masukan Nama Baru" value="<?php echo $panggil_user['username']; ?>">
                            </div>
                </div>
              <div class="form-group">
                <label for="">Jabatan</label>
                <select name="role" id="" class="form-control">
                  <?php if ($panggil_user['role'] == 'admin'): ?>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                  <?php elseif ($panggil_user['role'] == 'kasir'): ?>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                    <option value="admin">Admin</option>
                  <?php elseif ($panggil_user['role'] == 'owner'): ?>
                    <option value="owner">Owner</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                  <?php endif ?>
                </select>
              </div>
              <div class="form-group mt-2">
                <a href="daftar_pengguna.php" class="btn btn-danger btn-lg btn-block">Kembali</a>
                <button onclick="return confirm('Apakah ingin mengubah data ini?')" type="submit" class="btn btn-success btn-lg btn-block" name="ubah">Ubah</button>
              </div>
            </form>
            <hr>
             <footer class="main-footer mt-3 text-center">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
                <div class="float-right d-none d-sm-inline-block">
            </div>
            </footer>
           </div>
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
