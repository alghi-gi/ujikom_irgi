<?php 
  
  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
      header('location:login.php');
      exit;
    }
  }

  //panggil data transaksi untuk menampikan di table
  $panggil_filter_transaksi =  mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user");

  //jika tombol filter di klik
  if (isset($_POST['filter'])) {
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];

    $panggil_filter_transaksi =  mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'");

     //hitung total hasil menurut dari pencarian 
    
    // $hitung_hasil = mysqli_query($konek, "SELECT SUM($total_bayar) as jml_hasil FROM transaksi WHERE tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    // $panggil_hitung_hasil = mysqli_fetch_assoc($hitung_hasil);

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

  <title>SlowClean | Laporan </title>

  <!-- Custom fonts for this template-->
  <link href="bs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bs/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="bs/css/sb-admin-2.min.css" rel="stylesheet">

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
       <span><h4><i class="fas fa-file"></i> | Laporan </h4></span>
            <hr>
        <div class="container rounded-lg shadow p-3 mb-3 bg-white rounded">
          <form action="" method="POST">
            <div class="row p-3 mt-2">
              <div class="col-lg-1">
                <h4>Tanggal Awal : </h4>
              </div>
             <div class="col-lg-5">
               <input type="date" class="form-control" name="tgl_awal" value="<?php echo date('Y-m-d'); ?>">
             </div>
             <div class="col-lg-1">
               <h4>Tanggal Akhir : </h4>
             </div>
             <div class="col-lg-5">
               <input type="date" class="form-control" name="tgl_akhir">
             </div>
           </div>
           <hr>
           <div class="row justify-content-center mb-2">
             <div class="col-lg-10">
               <button type="submit" data-toggel="popover" data-placement="bottom" title="Cari Tanggal" class="btn btn-primary btn-lg btn-block" name="filter"><i class="fas fa-search"></i></button>
             </div>
           </div>
          </form>
        </div>
          
           <?php if (isset($_POST['filter'])): ?>
          <div class="container rounded-lg mt-3 shadow-lg p-3 mb-5 bg-white rounded">
            <h5>Hasil laporan dari tanggal <b><?php echo date_format(date_create($tgl_awal), "d-M-Y"); ?> s/d <?php echo date_format(date_create($tgl_akhir), "d-M-Y"); ?></b></h5>
             <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped text-dark">
                  <thead class="text-center" style="background-color: skyblue;">
                   <tr>
                    <th>No</th>
                    <th>Kode Invoice</th>
                    <th>Nama Pelanggan</th>
                    <th>Outlet</th>
                    <th>Tanggal Masuk</th>
                    <th>Total Harga</th>
                    <th>Status Cuci</th>
                    <th>Status Pembayaran</th>
                    <th>Penginput</th>
                   </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; ?>
                    <?php $penghasilan = 0; ?>
                    <?php foreach ($panggil_filter_transaksi as $data): 
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
                        $penghasilan += $total_bayar;

                      ?>
                      
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $data['kode_invoice']; ?></td>
                        <td><a class="btn btn-info" href="info_transaksi_pelanggan.php?id_transaksi=<?php echo $data['id_transaksi']; ?>"><?php echo $data['nama_member']; ?></a></td>
                        <td><?php echo $data['nama_outlet']; ?></td>
                        <td><?php echo date_format(date_create($data['tgl']), "d-M-Y"); ?></td>
                        <td>Rp.<?php echo number_format($total_bayar); ?></td>
                        <td class="text-center">
                          <?php 
                            $id_transaksi = $data['id_transaksi'];
                            $status_detail = mysqli_query($konek, "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE tr.id_transaksi = '$id_transaksi'");
                           ?>
                           <?php if (mysqli_fetch_assoc($status_detail) == NULL): ?>
                             <a class="btn btn-secondary" href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>">
                               Kosong
                             </a>
                           <?php else: ?>
                          <?php if ($data['status'] == 'baru'): ?>
                            <span class="btn btn-sm btn-info"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'proses'):?>
                            <span class="btn btn-sm btn-danger"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'selesai'):?>
                            <span class="btn btn-sm btn-success"><?php echo $data['status']; ?></span>
                          <?php elseif ($data['status'] == 'diambil'):?>
                            <span class="btn btn-sm btn-dark"><?php echo $data['status']; ?></span>
                          <?php endif ?>
                         <?php endif ?>
                        </td>
                        <td>
                            <?php if ($data['dibayar'] == 'belum dibayar'): ?>
                              <a href="bayar.php?id_transaksi=<?php echo $data['id_transaksi'] ?>">
                                <span class="btn btn-sm btn-danger"><?php echo $data['dibayar']; ?></span>
                              </a>
                            <?php elseif ($data['dibayar'] == 'sudah dibayar'):?>
                              <span class="btn btn-sm btn-success"><?php echo $data['dibayar']; ?></span>
                            <?php endif ?>
                        </td>
                        <td><?php echo ucwords($data['nama_user']); ?></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
              <h4>Total Penghasilan : <b>Rp.<?php echo number_format($penghasilan); ?></b></h4>
              <hr>
              <footer class="main-footer mt-3">
                 <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
                <div class="float-right d-none d-sm-inline-block">
              <b>Versi</b> 0.0.0
            </div>
            </footer>
            </div>
           <?php endif ?>
           </div>
         </div>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

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
  <script>
    $(document).ready(function(){
      $('[data-toggle="popover"]').popover();
    })
  </script>

</body>

</html>
