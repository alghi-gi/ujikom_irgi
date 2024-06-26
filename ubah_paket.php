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

  $outlet = mysqli_query($konek, "SELECT * FROM outlet");
  $panggil_outlet = mysqli_fetch_assoc($outlet);

  //jika tombil ubah ditekan
  if (isset($_POST['ubah'])) {
    if (ubah_paket($_POST) > 0) {
      echo "
        <script>
          $(document).ready(function() {
                Swal.fire({
                  type: 'success',
                  title: 'Paket berhasil diubah!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'paket.php';
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
                  title: 'Paket gagal ditambah!',
                }).then((result = true) => {
                  if (result.value) {
                    document.location.href = 'ubah_paket.php';
                  }
                });
              })
        </script>
      ";
    }
  }

  $id_paket = $_GET['id_paket'];

  $sql_paket = mysqli_query($konek, "SELECT * FROM paket as pk INNER JOIN outlet as ot ON pk.id_outlet = ot.id_outlet WHERE pk.id_paket = '$id_paket'");

  $panggil_paket = mysqli_fetch_assoc($sql_paket);

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Ubah Paket "<?php echo $panggil_paket['nama_paket']; ?>"</title>

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
       <span><h4><i class="fas fa-pen"></i> | Ubah Paket "<?php echo $panggil_paket['nama_paket']; ?>"</h4></span>
      <hr>
        <div class="container">
         <div class="row justify-content-center">
           <div class="col-lg-4 rounded-lg p-4 shadow-lg p-3 mb-5 bg-white rounded">
            <form action="" method="POST">
              <input type="hidden" name="id_paket" value="<?php echo $panggil_paket['id_paket']; ?>">
              <input type="hidden" name="id_outlet" value="<?php echo $panggil_outlet['id_outlet']; ?>">
                  <div class="form-group">
                    <label for="" class="">Nama Paket</label>
                    <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-box"></i></i></span>
                            </div>
                            <input type="text" class="form-control" <?php if ($_SESSION['role'] == 'kasir' OR $_SESSION['role'] !== 'admin'): ?>
                              style="cursor: not-allowed;" disabled
                            <?php endif ?> required name="nama_paket" placeholder="Masukan Nama paket" value="<?php echo $panggil_paket['nama_paket']; ?>">
                          </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="" >Jenis Paket</label>
                       <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-boxes"></i></i></span>
                            </div>
                             <select name="jenis" <?php if ($_SESSION['role'] == 'kasir' OR $_SESSION['role'] !== 'admin'): ?>
                               style="cursor: not-allowed;" disabled
                             <?php endif ?> class="form-control" id="">
                               <?php if ($panggil_paket['jenis'] == 'kiloan'): ?>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="selimut">Selimut</option>
                                  <option value="kaos">Kaos</option>
                                  <option value="sepatu">Sepatu</option>
                                  <option value="hemat">Hemat</option>
                                <?php elseif ($panggil_paket['jenis'] == 'bed cover'): ?>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="selimut">Selimut</option>
                                  <option value="kaos">Kaos</option>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="sepatu">Sepatu</option>
                                  <option value="hemat">Hemat</option>
                                <?php elseif ($panggil_paket['jenis'] == 'selimut'): ?>
                                  <option value="selimut">Selimut</option>
                                  <option value="kaos">Kaos</option>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="sepatu">Sepatu</option>
                                  <option value="hemat">Hemat</option>
                                <?php elseif ($panggil_paket['jenis'] == 'kaos'): ?>
                                  <option value="kaos">Kaos</option>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="selimut">Selimut</option>
                                  <option value="sepatu">Sepatu</option>
                                  <option value="hemat">Hemat</option>
                                <?php elseif ($panggil_paket['jenis'] == 'sepatu'): ?>
                                  <option value="sepatu">Sepatu</option>
                                  <option value="hemat">Hemat</option>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="selimut">Selimut</option>
                                  <option value="kaos">Kaos</option>
                                <?php elseif ($panggil_paket['jenis'] == 'hemat'): ?>
                                  <option value="hemat">Hemat</option>
                                  <option value="kiloan">Kiloan</option>
                                  <option value="bed cover">Bed Cover</option>
                                  <option value="selimut">Selimut</option>
                                  <option value="kaos">Kaos</option>
                                  <option value="sepatu">Sepatu</option>
                                <?php endif ?>
                             </select>
                          </div>
                      </div>
                    <div class="form-group col-md-6">
                     <label for="" class="">Harga / Rp</label>
                     <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-tags"></i></i></span>
                            </div>
                            <input type="number" required class="form-control" name="harga" placeholder="Masukan Harga Baru" value="<?php echo $panggil_paket['harga']; ?>">
                          </div>
                    </div>
                  </div>
                   <div class="form-group mt-2">
                    <a href="paket.php" class="btn btn-danger btn-lg btn-block">Kembali</a>
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

</body>

</html>
