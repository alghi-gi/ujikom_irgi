<?php 

  require 'koneksi.php';

  //login
  if (!isset($_SESSION['status_login'])) {
    if ($_SESSION['status_login'] !== 1) {
      header('location:login.php');
      exit;
    }
  }

  //panggil join table
  $id_transaksi = $_GET['id_transaksi'];
  $detail_transaksi = mysqli_query($konek, "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket INNER JOIN member as mb ON tr.id_member = mb.id_member WHERE tr.id_transaksi = '$id_transaksi'");
  $panggil_detail = mysqli_fetch_assoc($detail_transaksi);

  //panggil data dari table transaksi
  $id_transaksi = $_GET['id_transaksi'];
  $panggil_transaksi = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.id_transaksi = '$id_transaksi'");
  $tr_panggil = mysqli_fetch_assoc($panggil_transaksi);

  //panggil data pembayaran dari table pembayaran
  $id_transaksi = $_GET['id_transaksi'];
  $panggil_bayar = mysqli_query($konek, "SELECT * FROM pembayaran WHERE pembayaran.id_transaksi = '$id_transaksi'");
  $pm_panggil = mysqli_fetch_assoc($panggil_bayar);

  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Invoice "<?php echo $panggil_detail['nama_member']; ?>"</title>

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
    <div id="content-wrapper" class="d-flex flex-column">
        
      <div id="content" class="p-4 p-md-5 pt-5 text-dark mt-1">
          <h4><i class="fas fa-file-invoice"></i> | Data Invoice "<?php echo $panggil_detail['nama_member']; ?> | Invoice - <?php echo $panggil_detail['kode_invoice']; ?>"</h4>
          <hr>
          
        <div class="container shadow-lg p-3 mb-5 bg-white rounded">
        <div class="row justify-content-center">
          <div class="col-lg-11 rounded-lg">
            <img src="img/sasasa.png" alt="" width="300px;">
            <h5>
              <div class="row">
                <div class="col-lg-2">
                  <p>Kode Invoice :</p>
                </div>
                <div class="col-lg-2 font-weight-bold">
                  <?php echo $tr_panggil['kode_invoice']; ?>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-2">
                  <p>Tanggal Masuk :</p>
                </div>
                <div class="col-lg-2 font-weight-bold">
                  <?php echo date_format(date_create($tr_panggil['tgl']), "d-M-Y"); ?>
                </div>   
              </div>
              <div class="row">
                <div class="col-lg-2">
                  <p>Tanggal Keluar :</p>
                </div>
                <div class="col-lg-2 font-weight-bold">
                  <?php echo date_format(date_create($tr_panggil['batas_waktu']), "d-M-Y"); ?>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-2">
                  <h5>Status Cuci:</h5>
                </div>
                <div class="col-lg-3">
                  <?php if ($panggil_detail['status'] == 'baru'): ?>
                    <span class="btn btn-info"><?php echo $panggil_detail['status']; ?></span>
                    <?php elseif ($panggil_detail['status'] == 'proses'): ?>
                      <span class="btn btn-danger"><?php echo $panggil_detail['status']; ?></span>
                    <?php elseif ($panggil_detail['status'] == 'selesai'):?>
                      <span class="btn btn-success"><?php echo $panggil_detail['status']; ?></span>
                    <?php elseif ($panggil_detail['status'] == 'diambil'): ?>
                      <span class="btn btn-dark"><?php echo $panggil_detail['status']; ?></span>
                  <?php endif ?>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-lg-2">
                  <p>Pembayaran :</p>
                </div>
                <div class="col-lg-3">
                  <?php if ($panggil_detail['dibayar'] == 'belum dibayar'): ?>
                      <span class="btn btn-danger"><?php echo $panggil_detail['dibayar']; ?></span>
                    <?php elseif ($panggil_detail['dibayar'] == 'sudah dibayar'): ?>
                      <span class="btn btn-success"><?php echo $panggil_detail['dibayar']; ?></span>
                  <?php endif ?>
                </div>
              </div>
            </h5>
           <hr class="mt-1">
            <div class="table">
               <table class="table table-bordered table-striped text-dark text-center">
                <thead class="text-center bg-dark text-white">
                        <tr>
                          <th>No</th>
                          <th>Nama Paket</th>
                          <th>Jenis Paket</th>
                          <th>Harga Satuan</th>
                          <th>Jumlah Barang</th>
                          <th>Jumlah Harga</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $n=1; ?>
                        <?php foreach ($detail_transaksi as $data): 
                            $jumlah_harga = $data['harga'] * $data['qty'];
                          ?>
                          <tr>
                            <td><?php echo $n++; ?>.</td>
                            <td><?php echo $data['nama_paket']; ?></td>
                            <td><?php echo $data['jenis']; ?></td>
                            <td>Rp.<?php echo number_format($data['harga']); ?></td>
                            <td><?php echo $data['qty']; ?></td>
                            <td>Rp.<?php echo number_format($jumlah_harga); ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                          </tr>
                      </tbody>
                    <?php endforeach ?>
               </table>
                    <p>Diskon 5% (Jika lebih dari Rp.100.000)</p>
                <hr>
                <?php foreach ($panggil_transaksi as $data): 
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
                <h5 class="text-right">
                  <div class="row">
                    <div class="col-lg-10">
                      <p>Biaya Cuci :</p>
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      Rp.<?php echo number_format($harga_total); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">
                      <p>Diskon :</p>
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      <?php echo number_format($panggil_detail['diskon']); ?>%
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">
                      <p>Pajak :</p>
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      <?php echo number_format($panggil_detail['pajak']); ?>%
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <p>-------------------------------</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">
                      <p>Total Harga :</p>
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      Rp.<?php echo number_format($total_bayar); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">
                      <p>Uang Bayar :</p>
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      Rp.<?php echo number_format($pm_panggil['uang_bayar']); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <p>-------------------------------</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">
                      Kembalian :
                    </div>
                    <div class="col-lg-1 font-weight-bold">
                      Rp.<?php echo number_format($pm_panggil['kembalian']); ?>
                    </div>
                  </div>
                </h5>
               <hr>
                <h5 class="text-center mt-3">Terima kasih sudah mempercayakan cucian Anda kepada Kami.</h5>
                 <div class="row justify-content-center mt-4">
                    <div class="col-lg-3">
                      <a class="btn btn-danger btn-lg btn-block" href="transaksi_cuci.php">Kembali</a>
                    </div>
                    <div class="col-lg-3">
                      <a href="cetak_invoice.php?id_transaksi=<?php echo $id_transaksi; ?>" class="btn btn-warning btn-lg btn-block" target="_blank">CETAK</a>
                    </div>
                  </div>
          </div>
        </div>
      </div>
      <hr>
      <footer class="main-footer mt-3">
                       <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
                        <div class="float-right d-none d-sm-inline-block">
                          <b>Versi</b> 0.0.0
                        </div>
                    </footer>
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



  


 
  

</body>

</html>
