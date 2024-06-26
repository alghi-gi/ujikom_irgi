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

  //jika tombol ubah ditekan
 if (isset($_POST['ubah'])) {
   if (transaksi_ubah($_POST) > 0) {
     echo "
      <script>
        $(document).ready(function() {
                    Swal.fire({
                      type: 'success',
                      title: 'Transaksi berhasil diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'transaksi_cuci.php';
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
                      title: 'Transaksi gagal diubah!',
                    }).then((result = true) => {
                      if (result.value) {
                        document.location.href = 'ubah_transaksi.php';
                      }
                    });
                  })
      </script>
    ";
   }
 }

   $id_transaksi = $_GET['id_transaksi'];

   $sql_transaksi = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.id_transaksi = '$id_transaksi'");

    $panggil_transaksi = mysqli_fetch_assoc($sql_transaksi);

    //panggil data member
    $panggil_member = mysqli_query($konek, "SELECT * FROM member");


 

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Ubah Paket "<?php echo $panggil_transaksi['nama_member']; ?>" </title>

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
       <span><h4><i class="fas fa-pen"></i> | Ubah Paket "<?php echo $panggil_transaksi['nama_member']; ?> | INVOICE - <?php echo $panggil_transaksi['kode_invoice']; ?>"</h4></span>
      <hr>
         <div class="row justify-content-center">
           <div class="col-lg-4 rounded-lg p-4 shadow-lg p-3 mb-5 bg-white rounded">
             <form action="" method="POST">
                  <input type="hidden" name="id_transaksi" value="<?php echo $panggil_transaksi['id_transaksi']; ?>">
                  <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                  <input type="hidden" name="id_outlet" value="<?php echo $panggil_transaksi['id_outlet']; ?>">
                  <div class="form-row">
                    <div class="form-group col-md-8">
                      <label for="">Nama Pelanggan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></i></span>
                            </div>
                           <select name="id_member" class="form-control" id="">
                              <option value="<?php echo $panggil_transaksi['id_member']; ?>"><?php echo $panggil_transaksi['nama_member']; ?></option>
                               <option value="">-- Pilih Nama Pelanggan Ubah --</option>
                              <?php foreach ($panggil_member as $data): ?>
                                <?php if ($panggil_transaksi['id_member'] !== $data['id_member']): ?>
                                  <option value="<?php echo $data['id_member']; ?>"><?php echo $data['nama_member']; ?></option>
                                <?php endif ?>
                              <?php endforeach ?>
                            </select>
                          </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="">Kode Invoice</label>
                      <input type="number" class="form-control" name="kode_invoice" required placeholder="Contoh : 001" value="<?php echo $panggil_transaksi['kode_invoice']; ?>">
                    </div>
                  </div>
                   <div class="form-row">
                    <div class="form-group col-md-6">
                      <input type="hidden" name="tgl" value="<?= date('Y-m-d'); ?>">
                      <label for="">Tanggal Cuci</label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" name="tgl" value=<?php echo $panggil_transaksi['tgl']; ?>"<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Batas Waktu</label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                          </div>
                          <input type="date" class="form-control" name="batas_waktu" value=<?php echo $panggil_transaksi['batas_waktu']; ?>"<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="">Status Cuci</label>
                      <select name="status" id="" class="form-control" >
                       <?php if ($panggil_transaksi['status'] == 'baru'): ?>
                          <option value="baru">Baru</option>
                          <option value="proses">Proses</option>
                          <option value="selesai">Selesai</option>
                          <option value="diambil">Diambil</option>
                        <?php elseif ($panggil_transaksi['status'] == 'proses'): ?>
                          <option value="proses">Proses</option>
                          <option value="selesai">Selesai</option>
                          <option value="diambil">Diambil</option>
                          <option value="baru">Baru</option>
                        <?php elseif ($panggil_transaksi['status'] == 'selesai'): ?>
                          <option value="selesai">Selesai</option>
                          <option value="diambil">Diambil</option>
                          <option value="baru">Baru</option>
                          <option value="proses">Proses</option>
                        <?php elseif ($panggil_transaksi['status'] == 'diambil'): ?>
                          <option value="diambil">Diambil</option>
                          <option value="baru">Baru</option>
                          <option value="proses">Proses</option>
                          <option value="selesai">Selesai</option>
                       <?php endif ?>                     
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="">Status Bayar</label>
                      <select name="dibayar" id="" class="form-control" >
                       <?php if ($panggil_transaksi['dibayar'] == 'belum dibayar'): ?>
                          <option value="belum dibayar">Belum dibayar</option>
                          <option value="sudah dibayar">Sudah dibayar</option>
                        <?php elseif ($panggil_transaksi['dibayar'] == 'sudah dibayar'): ?>
                          <option value="sudah dibayar">Sudah dibayar</option>
                          <option value="belum dibayar">Belum dibayar</option>
                       <?php endif ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group mt-2">
                    <a href="transaksi_cuci.php" class="btn btn-danger btn-col btn-block">Kembali</a>
                    <button onclick="return confirm('Apakah ingin mengubah data ini?')" type="submit" class="btn btn-success btn-col btn-block" name="ubah">Ubah</button>
                  </div>
              </form>
              <hr>
                  <footer class="main-footer mt-2 text-center">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
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
