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

  if (isset($_POST['ubah'])) {
    if (ubah_pelanggan($_POST) > 0) {
      echo "
        <script>
             $(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Pelanggan berhasil diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'pelanggan.php';
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
                      title: 'Pelanggan gagal diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'ubah_pelanggan.php';
                      }
                    });
                  })
        </script>
      ";
    }
  }

  $id_member = $_GET['id_member'];

  $sql_member = mysqli_query($konek, "SELECT * FROM member WHERE id_member = '$id_member'");

  $panggil_member = mysqli_fetch_assoc($sql_member);

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Ubah "<?php echo $panggil_member['nama_member']; ?>"</title>

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
    <div id="content-wrapper" class="d-flex flex-column text-dark">
      
      <div id="content" class="p-4 p-md-5 pt-5">
       <span><h4><i class="fas fa-pen"></i> | Ubah Pelanggan "<?php echo $panggil_member['nama_member']; ?>"</h4></span>
      <hr>
         <div class="row justify-content-center mt-5 ">
           <div class="col-lg-4 rounded-lg p-4 shadow-lg p-3 mb-5 bg-white rounded">
            <form action="" method="POST">
              <input type="hidden" name="id_member" value="<?php echo $panggil_member['id_member']; ?>">
              <div class="form-group mt-3">
                    <label for="" class="text-dark">Nama Pelanggan</label>
                     <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                            <input type="text" class="form-control" name="nama_member" placeholder="Masukan Nama Pelanggan" required value="<?php echo $panggil_member['nama_member']; ?>">
                          </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="text-dark">Alamat</label>
                     <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></i></span>
                            </div>
                            <input type="text" class="form-control" name="alamat" placeholder="Masukan Alamat Pelanggan" required value="<?php echo $panggil_member['alamat']; ?>">
                          </div>
                  </div>
                 <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="" class="text-dark">Jenis Kelamin</label>
                       <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-venus-mars"></i></i></span>
                            </div>
                            <select name="jenis_kelamin" id="" class="form-control">
                             <?php if ($panggil_member['jenis_kelamin'] == 'laki-laki'): ?>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                              <?php elseif ($panggil_member['jenis_kelamin'] == 'perempuan'): ?>
                                 <option value="perempuan">Perempuan</option>
                                 <option value="laki-laki">Laki-laki</option>
                             <?php endif ?>
                            </select>
                          </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="" class="text-dark">Nomer Telepon</label>
                      <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></i></span>
                            </div>
                            <input type="number" class="form-control" name="no_telepon" value="<?php echo $panggil_member['no_telepon']; ?>">
                          </div>
                    </div>
                  </div>
                  <div class="form-group mt-2">
                    <a href="pelanggan.php" class="btn btn-danger btn-lg btn-block">Kembali</a>
                    <button onclick="return confirm('Apakah data ini ingin di ubah? ')" type="submit" class="btn btn-success btn-lg btn-block" name="ubah">Ubah</button>
                  </div>
                  <hr>
                   <footer class="main-footer mt-2 text-center">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
            </footer>
              </div>
            </form>
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

  <script src="bs/js/sweetalert2.min.js"></script>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: false,
        position: 'middle-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.swalDefaulthapus').click(function(){
        Toast.fire({
          type: 'info',
          title: 'Detail transaksi Berhasil dihapus!'
        })
      });
    });
  </script>

</body>

</html>
