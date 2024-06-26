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
  $transaksi = mysqli_query($konek, "SELECT * FROM transaksi as tr INNER JOIN outlet as ot ON tr.id_outlet = ot.id_outlet INNER JOIN member as mb ON tr.id_member = mb.id_member INNER JOIN user as us ON tr.id_user = us.id_user WHERE tr.id_transaksi = '$id_transaksi'");
  $panggil_transaksi = mysqli_fetch_assoc($transaksi);

  //panggil tanggal bayar dari table pembayaran
  $id_transaksi = $_GET['id_transaksi'];
  $pembayaran = mysqli_query($konek, "SELECT * FROM pembayaran WHERE id_transaksi = '$id_transaksi'");
  $panggil_bayar = mysqli_fetch_assoc($pembayaran);

  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SlowClean | Daftar Transaksi "<?php echo $panggil_transaksi['nama_member']; ?>"</title>

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
        
      <div id="content" class="p-4 p-md-5 pt-5 text-dark">
          <h4><i class="fas fa-table"></i> | Data Detail Transaksi "<?php echo $panggil_transaksi['nama_member']; ?>"</h4>
          <hr>
       
       <div class="container shadow-lg p-3 mb-5 bg-white rounded">   
        <div class="row justify-content-center">
          <div class="col-lg-11 rounded-lg">
            <img src="img/fjeifhenokjh.png" alt="" width="300px;" class="mt-3">
            <hr>
              <div class="row">
                <div class="col-lg-1">
                  ->
                </div>
                <div class="col-lg-8">
                  <h5>Kode Invoice : </h5><h5 class="font-weight-bold"><?php echo $panggil_transaksi['kode_invoice']; ?></h5>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-1">
                  ->
                </div>
                <div class="col-lg-5">
                  <h5>Nama Pelanggan : </h5><h5 class="font-weight-bold"><?php echo $panggil_transaksi['nama_member']; ?></h5>
                </div>
                 <div class="col-lg-5">
                  <h5>Alamat : </h5><h5 class="font-weight-bold"><?php echo $panggil_transaksi['alamat']; ?></h5>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-1">
                  ->
                </div>
                <div class="col-lg-5">
                  <h5>Tanggal Cuci : </h5><h5 class="font-weight-bold"><?php echo date_format(date_create($panggil_transaksi['tgl']), "d-M-Y"); ?></h5>
                </div>
                  <div class="col-lg-5">
                  <h5>batas Waktu : </h5><h5 class="font-weight-bold"><?php  echo date_format(date_create($panggil_transaksi['batas_waktu']), "d-M-Y"); ?></h5>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-lg-1">
                  ->
                </div>
                <div class="col-lg-3">
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
                  <h5>Biaya Cuci :</h5><h5 class="font-weight-bold">Rp.<?php echo number_format($harga_total); ?></h5>
                </div>
                <div class="col-lg-2">
                  <h5>Diskon :</h5><h5 class="font-weight-bold"><?php echo number_format($panggil_detail['diskon']); ?>%</h5>
                </div>
                <div class="col-lg-3">
                  <h5>Pajak :</h5><h5 class="font-weight-bold"><?php echo number_format($panggil_detail['pajak']); ?>%</h5>
                </div>
                <div class="col-lg-3">
                  <h5>Total Harga : </h5><h5 class="font-weight-bold">Rp.<?php echo number_format($total_bayar); ?></h5>
                </div> 
              </div>
              <div class="row mt-1">
                <div class="col-lg-1">
                  ->
                </div>
                <div class="col-lg-5">
                  <h5>Status Cuci :</h5><h5 class="font-weight-bold">
                     <?php 
                        $id_transaksi = $data['id_transaksi'];
                         $status_detail = mysqli_query($konek, "SELECT * FROM detail_transaksi as dt INNER JOIN transaksi as tr ON dt.id_transaksi = tr.id_transaksi INNER JOIN paket as pk ON dt.id_paket = pk.id_paket WHERE tr.id_transaksi = '$id_transaksi'");
                      ?>
                      <?php if (mysqli_fetch_assoc($status_detail) == NULL): ?>
                        <a class="btn btn-secondary" href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>">
                          Kosong
                        </a>
                      <?php else: ?>
                    <?php if ($panggil_transaksi['status'] == 'baru'): ?>
                      <span class="btn btn-info"><?php echo $panggil_transaksi['status']; ?></span>
                    <?php elseif ($panggil_transaksi['status'] == 'proses'): ?>
                      <span class="btn btn-danger"><?php echo $panggil_transaksi['status']; ?></span>
                    <?php elseif ($panggil_transaksi['status'] == 'selesai'): ?>
                      <span class="btn btn-success"><?php echo $panggil_transaksi['status']; ?></span>
                    <?php elseif ($panggil_transaksi['status'] == 'diambil'): ?>
                      <span class="btn btn-dark"><?php echo $panggil_transaksi['status']; ?></span>
                      <?php endif ?>
                    <?php endif ?>
                  </h5>
                </div>
                <div class="col-lg-5">
                  <h5>Status Pembayaran : </h5><h5 class="font-weight-bold">
                    <?php if ($panggil_transaksi['dibayar'] == 'sudah dibayar'): ?>
                      <span class="btn btn-success"><?php echo $panggil_transaksi['dibayar']; ?></span>
                    <?php elseif ($panggil_transaksi['dibayar'] == 'belum dibayar'): ?>
                      <span class="btn btn-danger"><?php echo $panggil_transaksi['dibayar']; ?></span>
                    <?php endif ?>
                  </h5>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-lg-1">
                  ->
                </div>
                <div class="col-lg-8">
                  <h5>Tanggal Bayar :</h5><h5 class="font-weight-bold"><?php echo $panggil_bayar['tgl_bayar']; ?></h5>
                </div>
              </div>
               <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped text-dark text-center">
                      <thead class="text-center bg-dark text-white">
                        <tr>
                          <th>No</th>
                          <th>Jenis Paket</th>
                          <th>Nama Paket</th>
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
                            <td><?php echo $data['jenis']; ?></td>
                            <td><?php echo $data['nama_paket']; ?></td>
                            <td>Rp.<?php echo number_format($data['harga']); ?></td>
                            <td><?php echo $data['qty']; ?></td>
                            <td>Rp.<?php echo number_format($jumlah_harga); ?></td>
                            <td><?php echo $data['keterangan']; ?></td>
                          </tr>
                      </tbody>
                    <?php endforeach ?>
                    </table>
                    </div>
                    <h5>Diskon 10% (Jika lebih dari Rp.90.000)</h5>
                    <hr>
                    <a href="transaksi_cuci.php" class="btn btn-danger btn-col btn-block mb-3">Kembali</a>
                  </div>
                 </div>
                 <footer class="main-footer mt-3 mb-3">
                       <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script></strong> SlowClean Laundry
                        <div class="float-right d-none d-sm-inline-block">
                          <b>Versi</b> 0.0.0
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
